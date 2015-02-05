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
               data-gridtable-operations="add:Pridať body"
               data-gridtable-operation-add-url="{'points/new_operation/addition/--ID--'|site_url}"
        >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Obr.</th>
                    <th>Meno</th>
                    <th>Body</th>
                </tr>
            </thead>
            <tbody>
                {foreach $apartments as $apartment}
                <tr data-gridtable-unique="apartment_{$apartment->id|intval}" data-gridtable-id="{$apartment->id|intval}" data-gridtable-name="{$apartment->name|escape:'html'|addslashes} {$apartment->surname|escape:'html'|addslashes}" data-gridtable-login="{$apartment->login|escape:'html'|addslashes}">
                    <td>{$apartment->id|intval}</td>
                    <td><img src="{get_person_image_min($apartment->id)}" alt="" /></td>
                    <td>{$apartment->title} </td>
                    <td>{$apartment->points}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        {else}
            Momentálne v systéme neexistujú žiadne izby.
        {/if}
    </div>
    <a href="{'points/batch_point_addition'|site_url}" class="ui-btn ui-shadow ui-corner-all ui-btn-icon-left ui-icon-plus" data-ajax="false">Hromadné pridanie bodov</a>
{/block}
{block header_block}
<script type="text/javascript">
$(document).ready(function(){
    make_gridtable_active('table.admin_grid_table');
});
</script>
{/block}