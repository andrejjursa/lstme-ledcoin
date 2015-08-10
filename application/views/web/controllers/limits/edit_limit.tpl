{extends file='web/layouts/admin.tpl'}
{block content_block}
    <form action="{"limits/update_limit/{$limit->id|intval}"|site_url}" method="post" data-ajax="false">
        {include file='web/partials/form.tpl' form=$form source=$limit}
        <button type="submit" class="ui-shadow ui-btn ui-corner-all">Upraviť</button>
    </form>
{/block}