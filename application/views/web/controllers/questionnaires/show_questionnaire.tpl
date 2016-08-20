{extends file='web/layouts/admin.tpl'}
{block content_block}
    <h1>{$questionnaire->title|escape:'html'}</h1>
    <form action="{"questionnaires/show_questionnaire/{$questionnaire->id|intval}"|site_url}" method="post" enctype="multipart/form-data" data-ajax="false">
        {include file='web/partials/form.tpl' form=$form}
        <button type="submit" class="ui-shadow ui-btn ui-corner-all">Pokusne odoslať dotazník</button>
    </form>
{/block}