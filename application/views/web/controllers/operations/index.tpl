{extends file='web/layouts/admin.tpl'}
{block content_block}
    <div class="ui-body ui-body-c ui-corner-all">
        {if $persons->exists()}
        <table data-role="table" data-mode="reflow" class="admin_grid_table ui-responsive"
               data-gridtable-operations="add:Pridať čas,subtract:Odobrať čas,transactions:Transakcie"
               data-gridtable-operation-transactions-url="{'operations/transactions/--ID--'|site_url}"
               data-gridtable-operation-add-url="{'operations/new_operation/addition/--ID--'|site_url}"
               data-gridtable-operation-subtract-url="{'operations/new_operation/subtraction/--ID--'|site_url}"
        >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Meno</th>
                    <th>Login</th>
                    <th>Skupina</th>
                    <th>Zostávajúci čas</th>
                    <th>Získaný čas</th>
                    <th>Použitý čas</th>
                </tr>
            </thead>
            <tbody>
                {foreach $persons as $person}
                <tr data-gridtable-unique="person_{$person->id|intval}" data-gridtable-id="{$person->id|intval}">
                    <td>{$person->id|intval}</td>
                    <td>{$person->name} {$person->surname}</td>
                    <td>{$person->login}</td>
                    <td>{$person->group_title|default:'<strong>---</strong>'}</td>
                    <td>{include file='web/partials/minutes_inflection.tpl' minutes={$person->plus_time|intval - $person->minus_time_1|intval - $person->minus_time_2|intval - $person->minus_time_3|intval} inline}</td>
                    <td>{include file='web/partials/minutes_inflection.tpl' minutes=$person->plus_time|intval inline}</td>
                    <td>{include file='web/partials/minutes_inflection.tpl' minutes={$person->minus_time_1|intval + $person->minus_time_2|intval + $person->minus_time_3|intval} inline}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        {else}
            Momentálne v systéme neexistujú žiadne osoby.
        {/if}
    </div>
{/block}
{block header_block}
<script type="text/javascript">
$(document).ready(function(){
    make_gridtable_active('table.admin_grid_table');
    window.location = '#';
});
</script>
{/block}