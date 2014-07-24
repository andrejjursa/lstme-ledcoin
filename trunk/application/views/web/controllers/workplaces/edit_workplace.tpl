{extends file='web/layouts/admin.tpl'}
{block content_block}
    <form action="{"workplaces/update_workplace/{$workplace->id|intval}"|site_url}" method="post" data-ajax="false">
        {include file='web/partials/form.tpl' form=$form source=$workplace}
        <button type="submit" class="ui-shadow ui-btn ui-corner-all">Upraviť</button>
    </form>
{/block}