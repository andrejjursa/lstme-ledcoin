{extends file='web/layouts/standard.tpl'}
{block content_block} 
   {if $notes->exists()}
    <form action="javascipt:void(0);" class="online_filter_form" method="post" data-search_table="table.admin_grid_table" data-search_data="gridtable-name,gridtable-login">
        {include file='web/partials/form.tpl' form=filter_get_online_filter_form() inline}
    </form>
    {/if} 
    <div class="ui-body ui-body-c ui-corner-all">
        {if $notes->exists()}
         <table data-role="table" data-mode="reflow" class="ui-responsive grid_table"
               data-gridtable-operations="edit:Upraviť,delete:Vymazať"
               data-gridtable-operation-edit-url="{'notes/edit_note/--ID--'|site_url}"
               data-gridtable-operation-delete-prompt="true"
               data-gridtable-operation-delete-prompt-title="Vymazať udalosť?"
               data-gridtable-operation-delete-prompt-text="Naozaj chcete vymazať udalosť --NAME--?"
               data-gridtable-operation-delete-prompt-cancel="Nie, nechcem"
               data-gridtable-operation-delete-prompt-ok="Áno, chcem"
               data-gridtable-operation-delete-prompt-ok-url="{'notes/delete_note/--ID--'|site_url}" 
        > 
            <thead>
                <tr>
                    <th>Názov</th>
					<th>Dátum</th>
					<th>Čas</th>
					<th>Info</th>
                </tr>
            </thead>
            <tbody>
                 {foreach $notes as $note}
                <tr data-gridtable-unique="note_{$note->id|intval}" data-gridtable-id="{$note->id|intval}" data-gridtable-name="{$note->action_name|escape:'html'|addslashes}">
                    <td>{$note->action_name}</td>
					<td>{$note->date}</td>
					<td>{$note->time}</td>
					<td>{$note->text}</td>
                </tr> 
                {/foreach}
            </tbody>
        </table> 
        {else}
            Momentálne v systéme neexistujú žiadne udalosti.
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