{extends file='web/layouts/admin.tpl'}
{block content_block}
    {if $workplaces->exists()}
    <form action="javascipt:void(0);" class="online_filter_form" method="post" data-search_table="table.admin_grid_table" data-search_data="gridtable-title">
        {include file='web/partials/form.tpl' form=filter_get_online_filter_form() inline}
    </form>
    {/if}
    <div class="ui-body ui-body-c ui-corner-all">
        {if $workplaces->exists()}
        <table data-role="table" data-mode="reflow" class="admin_grid_table ui-responsive"
               data-gridtable-operations="edit:Upraviť,delete:Vymazať"
               data-gridtable-operation-edit-url="{'workplaces/edit_workplace/--ID--'|site_url}"
               data-gridtable-operation-delete-prompt="true"
               data-gridtable-operation-delete-prompt-title="Vymazať zamestnanie?"
               data-gridtable-operation-delete-prompt-text="Naozaj chcete vymazať zamestnanie --TITLE--?"
               data-gridtable-operation-delete-prompt-cancel="Nie, nechcem"
               data-gridtable-operation-delete-prompt-ok="Áno, chcem"
               data-gridtable-operation-delete-prompt-ok-url="{'workplaces/delete_workplace/--ID--'|site_url}"
        >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Názov</th>
                    <th>Použíté</th>
                </tr>
            </thead>
            <tbody>
                {foreach $workplaces as $workplace}
                <tr data-gridtable-unique="workplace_{$workplace->id|intval}" data-gridtable-id="{$workplace->id|intval}" data-gridtable-title="{$workplace->title|escape:'html'|addslashes}">
                    <td>{$workplace->id|intval}</td>
                    <td>{$workplace->title}</td>
                    <td>v <em>{$workplace->operations_count|intval}</em> {get_inflection_by_numbers($workplace->operations_count|intval, 'operáciách', 'operácii', 'operáciách', 'operáciách', 'operáciách', 'operáciách')} s LEDCOIN-om</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        {else}
            Momentálne nie sú k dispozícii žiadne zamestnania.
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