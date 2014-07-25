{extends file='web/layouts/admin.tpl'}
{block content_block}
    <form action="{"products/update_product/{$product->id|intval}"|site_url}" method="post" data-ajax="false">
    {include file='web/partials/form.tpl' form=$form source=$product inline}
    <button type="submit" class="ui-shadow ui-btn ui-corner-all">Uložiť</button>
    </form>
{/block}