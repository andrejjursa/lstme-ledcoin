{extends file='web/layouts/admin.tpl'}
{block content_block}
    {if count($form.arangement) gt 2}
    <form action="javascipt:void(0);" class="online_filter_form" method="post" data-search_form="form.persons_form" data-search_data="person-name,person-login">
        {include file='web/partials/form.tpl' form=filter_get_online_filter_form() inline}
    </form>
    <hr class="form_divider_simple" />
    {/if}
    <form action="{'operations/do_batch_ledcoin_addition'|site_url}" method="post" data-ajax="false" class="persons_form">
    {include file='web/partials/form.tpl' form=$form inline}
    <button type="submit" class="ui-shadow ui-btn ui-corner-all">Pridať</button>
    </form>
{/block}