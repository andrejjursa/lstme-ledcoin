{extends file='web/layouts/admin.tpl'}
{block content_block}
    {if $persons->exists()}
    <form action="javascipt:void(0);" class="online_filter_form" method="post" data-search_table="table.admin_grid_table" data-search_data="gridtable-name,gridtable-login">
        {include file='web/partials/form.tpl' form=filter_get_online_filter_form() inline}
    </form>
    {/if}
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
                    <th>Obr.</th>
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
                <tr data-gridtable-unique="person_{$person->id|intval}" data-gridtable-id="{$person->id|intval}" data-gridtable-name="{$person->name|escape:'html'|addslashes} {$person->surname|escape:'html'|addslashes}" data-gridtable-login="{$person->login|escape:'html'|addslashes}">
                    <td>{$person->id|intval}</td>
                    <td><img src="{get_person_image_min($person->id)}" alt="" /></td>
                    <td>{$person->name} {$person->surname}</td>
                    <td>{$person->login}</td>
                    <td>{$person->group_title|default:'<strong>---</strong>'}</td>
                    <td>{include file='web/partials/minutes_inflection.tpl' minutes={$person->plus_time|intval - $person->minus_time_direct|intval - $person->minus_time_products|intval - $person->minus_time_services|intval} inline}</td>
                    <td>{include file='web/partials/minutes_inflection.tpl' minutes=$person->plus_time|intval inline}</td>
                    <td>{include file='web/partials/minutes_inflection.tpl' minutes={$person->minus_time_direct|intval + $person->minus_time_products|intval + $person->minus_time_services|intval} inline}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        {else}
            Momentálne v systéme neexistujú žiadne osoby.
        {/if}
    </div>
    <a href="{'operations/batch_time_addition'|site_url}" class="ui-btn ui-shadow ui-corner-all ui-btn-icon-left ui-icon-plus" data-ajax="false">Hromadné pridanie strojového času</a>
{/block}
{block header_block}
<script type="text/javascript">
$(document).ready(function(){
    make_gridtable_active('table.admin_grid_table');
});
</script>
{/block}