{extends file='web/layouts/admin.tpl'}
{block content_block}
    <form action="{'products/do_batch_stock_addition'|site_url}" method="post" data-ajax="false">
    {include file='web/partials/form.tpl' form=$form inline}
    <button type="submit" class="ui-shadow ui-btn ui-corner-all">Hromadne pridať</button>
    </form>
{/block}