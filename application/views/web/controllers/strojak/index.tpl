{extends file='web/layouts/standard.tpl'}
{block content_block}
    <div class="ui-body ui-body-a ui-corner-all">
        <h3>Zoznam účastníkov</h3>
        <table data-role="table" data-mode="reflow" class="ui-responsive">
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
                    <td>{include file='web/partials/minutes_inflection.tpl' minutes={{$person->plus_time - $person->minus_time_1 - $person->minus_time_2 - $person->minus_time_3}|intval} inline}</td>
                    <td>{include file='web/partials/minutes_inflection.tpl' minutes={$person->plus_time|intval} inline}</td>
                    <td>{include file='web/partials/minutes_inflection.tpl' minutes={{$person->minus_time_1 + $person->minus_time_2 + $person->minus_time_3}|intval} inline}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
{/block}