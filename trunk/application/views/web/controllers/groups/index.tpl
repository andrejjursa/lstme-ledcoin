{extends file='web/layouts/admin.tpl'}
{block content_block}
    {if $groups->exists()}
    <form action="javascipt:void(0);" class="online_filter_form" method="post" data-search_table="table.admin_grid_table" data-search_data="gridtable-title">
        {include file='web/partials/form.tpl' form=filter_get_online_filter_form() inline}
    </form>
    {/if}
    <div class="ui-body ui-body-c ui-corner-all">
        {if $groups->exists()}
        <table data-role="table" data-mode="reflow" class="admin_grid_table ui-responsive"
               data-gridtable-operations="edit:Upraviť,delete:Vymazať"
               data-gridtable-operation-edit-url="{'groups/edit_group/--ID--'|site_url}"
               data-gridtable-operation-delete-prompt="true"
               data-gridtable-operation-delete-prompt-title="Vymazať skupinu?"
               data-gridtable-operation-delete-prompt-text="Naozaj chcete vymazať skupinu --TITLE--?"
               data-gridtable-operation-delete-prompt-cancel="Nie, nechcem"
               data-gridtable-operation-delete-prompt-ok="Áno, chcem"
               data-gridtable-operation-delete-prompt-ok-url="{'groups/delete_group/--ID--'|site_url}"
        >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Názov</th>
                    <th>Počet účastníkov</th>
                </tr>
            </thead>
            <tbody>
                {foreach $groups as $group}
                <tr data-gridtable-unique="group_{$group->id|intval}" data-gridtable-id="{$group->id|intval}" data-gridtable-title="{$group->title|escape:'html'|addslashes}">
                    <td>{$group->id|intval}</td>
                    <td>{$group->title}</td>
                    <td><em>{$group->persons_count|intval}</em> {get_inflection_by_numbers($group->persons_count|intval, 'účastníkov', 'účastník', 'účastníci', 'účastníci', 'účastníci', 'účastníkov')}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        {else}
            Momentálne nie sú k dispozícii žiadne skupiny.
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