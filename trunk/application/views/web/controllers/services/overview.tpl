{extends file='web/layouts/admin.tpl'}
{block content_block}
    <div class="ui-body ui-body-c ui-corner-all">
        {if $service_usages->exists()}
        <table data-role="table" data-mode="reflow" class="admin_grid_table ui-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Dátum</th>
                    <th>Počet minút</th>
                    <th>Účastník</th>
                    <th>Vedúci</th>
                    <th>Zamestnanie</th>
                    <th>Cena za minútu</th>
                </tr>
            </thead>
            <tbody>
                {foreach $service_usages as $usage}
                <tr>
                    <td>{$usage->id}</td>
                    <td>{$usage->created|date_format:'%d. %m. %Y'|default:'neznámy'}</td>
                    <td>{include file='web/partials/minutes_inflection.tpl' minutes=$usage->quantity|intval inline}</td>
                    <td>{$usage->operation_person_name} {$usage->operation_person_surname}</td>
                    <td>{$usage->operation_admin_name} {$usage->operation_admin_surname}</td>
                    <td>{$usage->operation_workplace_title|default:'---'}</td>
                    <td>{include file='web/partials/minutes_inflection.tpl' minutes=$usage->price|intval inline}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        {else}
            Momentálne nie sú k dispozícii žiadne prehľadové informácie k službe <strong>{$service->title}</strong>.
        {/if}
    </div>
{/block}