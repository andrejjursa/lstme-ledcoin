{extends file='web/layouts/standard.tpl'}
{block content_block}
    <div class="ui-body ui-body-a ui-corner-all">
    <form action="{'persons_registration/reg_person'|site_url}" method="post" data-ajax="false">
    {include file='web/partials/form.tpl' form=$form inline}
    <button type="submit" class="ui-shadow ui-btn ui-corner-all">Registrovať</button>
	</form>	
    </div>
{/block}