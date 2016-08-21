{extends file='web/layouts/standard.tpl'}
{block content_block}
    <div class="ui-body ui-body-a ui-corner-all">
        <form action="{"ledcoin/save_questionnaire/{$questionnaire->id|intval}"|site_url}" method="post">
            {include file='web/partials/form.tpl' form=$form inline}
            <button type="submit" class="ui-shadow ui-btn ui-corner-all">Odoslať dotazník</button>
        </form>
    </div>
{/block}