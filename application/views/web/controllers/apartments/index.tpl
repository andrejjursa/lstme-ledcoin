{extends file='web/layouts/admin.tpl'} 
{block content_block} 
   {if $apartments->exists()}
    <form action="javascipt:void(0);" class="online_filter_form" method="post" data-search_table="table.admin_grid_table" data-search_data="gridtable-name,gridtable-login">
        {include file='web/partials/form.tpl' form=filter_get_online_filter_form() inline}
    </form>
    {/if} 
    <div class="ui-body ui-body-c ui-corner-all">
        {if $apartments->exists()}
         <table data-role="table" data-mode="reflow" class="admin_grid_table ui-responsive"
               data-gridtable-operations="edit:Upraviť,photo:Pridať/upraviť fotku,delete:Vymazať"
               data-gridtable-operation-edit-url="{'apartments/edit_apartment/--ID--'|site_url}"
               data-gridtable-operation-photo-url="{'apartments/edit_photo/--ID--'|site_url}"
               data-gridtable-operation-delete-prompt="true"
               data-gridtable-operation-delete-prompt-title="Vymazať izbu?"
               data-gridtable-operation-delete-prompt-text="Naozaj chcete vymazať izbu --NAME--?"
               data-gridtable-operation-delete-prompt-cancel="Nie, nechcem"
               data-gridtable-operation-delete-prompt-ok="Áno, chcem"
               data-gridtable-operation-delete-prompt-ok-url="{'apartments/delete_apartment/--ID--'|site_url}" 
        > 
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Obr.</th>
                    <th>Názov</th>
                </tr>
            </thead>
            <tbody>
                 {foreach $apartments as $apartment}
                <tr data-gridtable-unique="apartment_{$apartment->id|intval}" data-gridtable-id="{$apartment->id|intval}" data-gridtable-name="{$apartment->title|escape:'html'|addslashes}">
                    <td>{$apartment->id|intval}</td>
                    <td><img src="{get_person_image_min($apartment->id)}" alt="" /></td> 
                    <td>{$apartment->title}</td>
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
});
</script>
{/block}  