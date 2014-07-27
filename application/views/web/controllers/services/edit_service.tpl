{extends file='web/layouts/admin.tpl'}
{block content_block}
    <form action="{"services/update_service/{$service->id|intval}"|site_url}" method="post" data-ajax="false">
    {include file='web/partials/form.tpl' form=$form source=$service inline}
    <button type="submit" class="ui-shadow ui-btn ui-corner-all">Uložiť</button>
    </form>
{/block}