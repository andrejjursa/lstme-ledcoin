{extends file='web/layouts/standard.tpl'}
{block content_block}
    <div class="ui-body ui-body-a ui-corner-all">
        <h3>Zoznam účastníkov</h3>
        {if $filter.renderas eq 'table'}
        <table data-role="table" data-mode="reflow" class="ui-responsive grid_table">
            <thead>
                <tr>
                    <th data-priority="persist">Meno</th>
                    <th data-priority="persist">Skupina</th>
                    <th data-priority="persist">Škola</th>
                    <th data-priority="1">Zostávajúci čas</th>
                    <th data-priority="2">Získaný čas</th>
                    <th data-priority="3">Použitý čas</th>
                </tr>
            </thead>
            <tbody>
                {foreach $persons as $person}
                <tr>
                    <td>{$person->name} {$person->surname}</td>
                    <td>{$person->group_title}</td>
                    <td>{$person->organisation}</td>
                    <td>{include file='web/partials/minutes_inflection.tpl' minutes={{$person->plus_time - $person->minus_time_direct - $person->minus_time_products - $person->minus_time_services}|intval} inline}</td>
                    <td>{include file='web/partials/minutes_inflection.tpl' minutes={$person->plus_time|intval} inline}</td>
                    <td>{include file='web/partials/minutes_inflection.tpl' minutes={{$person->minus_time_direct + $person->minus_time_products + $person->minus_time_services}|intval} inline}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        {else}
        <div style="overflow-x: auto">
            <div id="graph_container" style="height: 500px; min-width: {$persons->result_count() * 50 + 200}px;"></div>
        </div>
        {/if}
        <form action="{'strojak'|site_url}" method="post">
            {include file='web/partials/form.tpl' form=$form inline}
            <button type="submit" class="ui-shadow ui-btn ui-corner-all">Aplikovať</button>
        </form>
    </div>
{/block}
{block header_block}
{if $filter.renderas eq 'graph'}
<script type="text/javascript" src="{"assets/highcharts/highcharts.js?strojak_version={$app_version}"|base_url}"></script>
<script type="text/javascript" src="{"assets/highcharts/themes/grid-light.js?strojak_version={$app_version}"|base_url}"></script>
{/if}
{capture assign='data_content' name='data_content'}{foreach $persons as $person}
{if !$person@first},{/if}['{$person->name|addslashes} {$person->surname|addslashes}', {if $filter.orderby eq 'time_left'}{{$person->plus_time - $person->minus_time_direct - $person->minus_time_products - $person->minus_time_services}|intval}{elseif $filter.orderby eq 'time_acquired'}{$person->plus_time|intval}{else}{{$person->minus_time_direct + $person->minus_time_products + $person->minus_time_services}|intval}{/if}]
{/foreach}{/capture}
<script type="text/javascript">
$(document).ready(function() {
    $('#graph_container').highcharts({
        chart: { type: 'column' },
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
                text: '{if $filter.orderby eq 'time_left'}Zostávajúci čas{elseif $filter.orderby eq 'time_acquired'}Získaný čas{else}Použitý čas{/if}'
            }
        },
        legend: { enabled: false },
        series: [{
            name: '{if $filter.orderby eq 'time_left'}Zostávajúci čas{elseif $filter.orderby eq 'time_acquired'}Získaný čas{else}Použitý čas{/if}',
            data: [
                {$data_content}
            ],
            dataLabels: {
                enabled: true,
                format: '{ldelim}y{rdelim} min.',
                color: '#7cb5ec',
                align: 'center',
                /*x: 4,
                y: 10,*/
                style: {
                    fontSize: '11px',
                    fontFamily: 'Verdana, sans-serif',
                    fontWeight: 'bold'
                }
            }
        }]
    });
});
</script>
{/block}