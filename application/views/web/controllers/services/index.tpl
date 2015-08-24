{extends file='web/layouts/admin.tpl'}
{block content_block}
    {if $services->exists()}
    <form action="javascipt:void(0);" class="online_filter_form" method="post" data-search_table="table.admin_grid_table" data-search_data="gridtable-title">
        {include file='web/partials/form.tpl' form=filter_get_online_filter_form() inline}
    </form>
    {/if}
    <div class="ui-body ui-body-c ui-corner-all">
        {if $services->exists()}
        <table data-role="table" data-mode="reflow" class="admin_grid_table ui-responsive"
               data-gridtable-operations="edit:Upraviť,delete:Vymazať,overview:Prehľad"
               data-gridtable-operation-edit-url="{'services/edit_service/--ID--'|site_url}"
               data-gridtable-operation-delete-prompt="true"
               data-gridtable-operation-delete-prompt-title="Vymazať produkt?"
               data-gridtable-operation-delete-prompt-text="Naozaj chcete vymazať službu --TITLE--?"
               data-gridtable-operation-delete-prompt-cancel="Nie, nechcem"
               data-gridtable-operation-delete-prompt-ok="Áno, chcem"
               data-gridtable-operation-delete-prompt-ok-url="{'services/delete_service/--ID--'|site_url}"
               data-gridtable-operation-overview-url="{'services/overview/--ID--'|site_url}"
               data-gridtable-object_name="title"
        >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Názov</th>
                    <th>Cena</th>
                </tr>
            </thead>
            <tbody>
                {foreach $services as $service}
                <tr data-gridtable-unique="service_{$service->id|intval}" data-gridtable-id="{$service->id|intval}" data-gridtable-title="{$service->title|escape:'html'|addslashes}">
                    <td>{$service->id|intval}</td>
                    <td>{$service->title}</td>
                    <td>{include file='web/partials/ledcoin_inflection.tpl' ledcoins=$service->price inline} za Horalku</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        {else}
            Momentálne nie sú v systéme žiadne služby.
        {/if}
    </div>
{/block}
{block header_block}
<script type="text/javascript">
$(document).ready(function(){
    make_gridtable_active('table.admin_grid_table');
});
</script>
{/block}