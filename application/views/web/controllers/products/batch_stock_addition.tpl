{extends file='web/layouts/admin.tpl'}
{block content_block}
    {if count($form.arangement) gt 0}
    <form action="javascipt:void(0);" class="online_filter_form" method="post" data-search_form="form.products_form" data-search_data="product-name">
        {include file='web/partials/form.tpl' form=filter_get_online_filter_form() inline}
    </form>
    <hr class="form_divider_simple" />
    {/if}
    <form action="{'products/do_batch_stock_addition'|site_url}" method="post" data-ajax="false" class="products_form">
    {include file='web/partials/form.tpl' form=$form inline}
    <button type="submit" class="ui-shadow ui-btn ui-corner-all">Hromadne pridať</button>
    </form>
{/block}