{extends file='web/layouts/admin.tpl'}
{block content_block}
    <form action="{"products/update_product_quantity/{$product->id|intval}/{$product_quantity->id|intval}"|site_url}" method="post" data-ajax="false">
    {include file='web/partials/form.tpl' form=$form source=$product_quantity inline}
    <button type="submit" class="ui-shadow ui-btn ui-corner-all">Upraviť</button>
    </form>
{/block}