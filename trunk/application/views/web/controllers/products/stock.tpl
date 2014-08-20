{extends file='web/layouts/admin.tpl'}
{block content_block}
    <a href="{'products'|site_url}" class="ui-btn ui-icon-back ui-shadow ui-corner-all ui-btn-icon-left" data-ajax="false">Nazad na zoznam</a>
    <div class="ui-body ui-body-c ui-corner-all">
        <h4>{$product->title}</h4>
        {if $product_quantities->exists()}
        <table data-role="table" data-mode="reflow" class="admin_grid_table ui-responsive"
               data-gridtable-operations="edit:Upraviť"
               data-gridtable-operation-edit-url="{'products/edit_product_quantity/--PRODUCT-ID--/--ID--'|site_url}"
        >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Počet</th>
                    <th>Pridaný</th>
                </tr>
            </thead>
            <tbody>
                {foreach $product_quantities as $product_quantity}
                <tr data-gridtable-unique="product_quantity_{$product_quantity->id|intval}" data-gridtable-id="{$product_quantity->id|intval}" data-gridtable-product-id="{$product_quantity->product_id|intval}">
                    <td>{$product_quantity->id|intval}</td>
                    <td>{include file='web/partials/pieces_inflection.tpl' pieces=$product_quantity->quantity inline}</td>
                    <td>{$product_quantity->created|date_format:'%d. %m. %H:%M'|default:'Neznámy dátum'}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        {else}
            Momentálne tu nie sú záznamy o žiadnych pridaných množstvách.
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