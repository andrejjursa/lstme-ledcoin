{extends file='web/layouts/standard.tpl'}
{block content_block}
    <div class="ui-body ui-body-a ui-corner-all">
        <h3>Zoznam účastníkov</h3>
        {if $filter.renderas eq 'table'}
        <table data-role="table" data-mode="reflow" class="ui-responsive grid_table">
            <thead>
                <tr>
                    <th data-priority="persist">Obr.</th>
                    <th data-priority="persist">Meno</th>
                    <th data-priority="persist">Skupina</th>
                    <th data-priority="persist">Škola</th>
                    <th data-priority="1">Zostávajúci LEDCOIN</th>
                    <th data-priority="2">Získaný LEDCOIN</th>
                    <th data-priority="3">Vyťažený LEDCOIN</th>
                    <th data-priority="4">Použitý LEDCOIN</th>
                </tr>
            </thead>
            <tbody>
                {foreach $persons as $person}
                <tr>
                    <td><img src="{get_person_image_min($person->id)}" alt="" /></td>
                    <td>{$person->name} {$person->surname}</td>
                    <td>{$person->group_title}</td>
                    <td>{$person->organisation}</td>
                    <td>{include file='web/partials/ledcoin_inflection.tpl' ledcoins={{$person->plus_amount - $person->minus_amount_direct - $person->minus_amount_products - $person->minus_amount_services}|doubleval} inline}</td>
                    <td>{include file='web/partials/ledcoin_inflection.tpl' ledcoins={$person->plus_amount|doubleval} inline}</td>
                    <td>{include file='web/partials/ledcoin_inflection.tpl' ledcoins={$person->plus_mined|doubleval} inline}</td>
                    <td>{include file='web/partials/ledcoin_inflection.tpl' ledcoins={{$person->minus_amount_direct + $person->minus_amount_products + $person->minus_amount_services}|doubleval} inline}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        {else}
        <div style="overflow-x: auto">
            {$cols_cnt = $persons->result_count()}{if $cols_cnt lt 16}{$cols_cnt = 14}{/if}
            {$min_width = "{$cols_cnt * 50 + 200}px"}
            {if $filter.graph_type eq 'pie'}{$min_width = '100%'}{/if}
            <div id="graph_container" style="height: {if $filter.graph_type eq 'pie'}600{else}500{/if}px; min-width: {$min_width};"></div>
        </div>
        {/if}
        <form action="{'ledcoin'|site_url}" method="post">
            {include file='web/partials/form.tpl' form=$form inline}
            <button type="submit" class="ui-shadow ui-btn ui-corner-all">Aplikovať</button>
        </form>
    </div>
{/block}
{block header_block}
{if $filter.renderas eq 'graph'}
<script type="text/javascript" src="{"assets/highcharts/highcharts.js?ledcoin_version={$app_version}"|base_url}"></script>
<script type="text/javascript" src="{"assets/highcharts/modules/data.js?ledcoin_version={$app_version}"|base_url}"></script>
<script type="text/javascript" src="{"assets/highcharts/modules/drilldown.js?ledcoin_version={$app_version}"|base_url}"></script>
<script type="text/javascript" src="{"assets/highcharts/themes/grid-light.js?ledcoin_version={$app_version}"|base_url}"></script>
<script type="text/javascript">{$graph_type = 'column'}{if $filter.graph_type eq 'pie'}{$graph_type = 'pie'}{/if}
$(document).ready(function() {
    var graph_data = {$this->get_persons_graph_json($persons, $filter.orderby, $filter.graph_type)};
    var graph_options = {
        chart: { type: '{$graph_type}' },
        title: 'Zoznam účastníkov',
        xAxis: {
            type: 'category',
            labels: {
                rotation: -90,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: graph_data.yAxis
            }
        },
        legend: { enabled: {if $filter.graph_type eq 'pie'}true{else}false{/if} },
        series: [{
            colorByPoint: true,
            name: graph_data.series_name,
            data: graph_data.series,
            dataLabels: graph_data.series_dataLabels
        }],
        drilldown: {
            series: graph_data.drilldown
        },
        plotOptions: {
            pie: {
                allowPointSelect: false,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{ldelim}point.name{rdelim} ({ldelim}point.y{rdelim})'
                },
                showInLegend: true
            }
        }
    };
    Highcharts.setOptions({
        lang: {
            drillUpText: '<< Naspäť na "{ldelim}series.name{rdelim}"'
        }
    });
    $('#graph_container').highcharts(graph_options);
});
</script>
{/if}
{/block}