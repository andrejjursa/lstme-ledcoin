{extends file='web/layouts/admin.tpl'}
{block content_block}
    <form action="{'apartments/create_apartments'|site_url}" method="post" data-ajax="false">
    {include file='web/partials/form.tpl' form=$form inline}
    <button type="submit" class="ui-shadow ui-btn ui-corner-all">Vytvoriť</button>
	</form>	
{/block}