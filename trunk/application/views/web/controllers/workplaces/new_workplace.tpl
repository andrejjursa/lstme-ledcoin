{extends file='web/layouts/admin.tpl'}
{block content_block}
    <form action="{'workplaces/create_workplace'|site_url}" method="post" data-ajax="false">
        {include file='web/partials/form.tpl' form=$form}
        <button type="submit" class="ui-shadow ui-btn ui-corner-all">Vytvoriť</button>
    </form>
{/block}