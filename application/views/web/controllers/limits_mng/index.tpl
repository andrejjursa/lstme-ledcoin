{extends file='web/layouts/admin.tpl'}
{block content_block}
    <div class="ui-body ui-body-c ui-corner-all">
        {if $limits->exists()}
        <table data-role="table" data-mode="reflow" class="admin_grid_table ui-responsive"
               data-gridtable-operations="edit:Upraviť,delete:Vymazať"
               data-gridtable-operation-edit-url="{'limits_mng/edit_limit/--ID--'|site_url}"
               data-gridtable-operation-delete-prompt="true"
               data-gridtable-operation-delete-prompt-title="Vymazať limit?"
               data-gridtable-operation-delete-prompt-text="Naozaj chcete vymazať limit na deň --DATE-- s hodnotou --DAILY_LIMIT--?"
               data-gridtable-operation-delete-prompt-cancel="Nie, nechcem"
               data-gridtable-operation-delete-prompt-ok="Áno, chcem"
               data-gridtable-operation-delete-prompt-ok-url="{'limits_mng/delete_limit/--ID--'|site_url}"
        >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Deň</th>
                    <th>Denný limit LEDCOIN-ov</th>
                </tr>
            </thead>
            <tbody>
                {foreach $limits as $limit}
                <tr data-gridtable-unique="limit_{$limit->id|intval}" data-gridtable-id="{$limit->id|intval}" data-gridtable-date="{$limit->date|date_format:'d. m. Y'}" data-gridtable-daily_limit="{$limit->daily_limit|doubleval}">
                    <td>{$limit->id|intval}</td>
                    <td>{$limit->date|date_format:'d. m. Y'}</td>
                    <td>{$limit->daily_limit|doubleval}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        {else}
            V túto chvílu nie sú definované žiadne denné limity.
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