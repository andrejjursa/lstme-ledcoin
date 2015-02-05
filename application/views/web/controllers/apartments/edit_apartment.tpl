{extends file='web/layouts/admin.tpl'}
{block content_block}
    <form action="{"apartments/update_apartment/{$apartment->id|intval}"|site_url}" method="post" data-ajax="false">
    {include file='web/partials/form.tpl' form=$form source=$apartment inline}
    <button type="submit" class="ui-shadow ui-btn ui-corner-all">Uložiť</button>
    </form>
{/block}