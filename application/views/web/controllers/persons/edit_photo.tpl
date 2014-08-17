{extends file='web/layouts/admin.tpl'}
{block content_block}
    <p>Fotografia osoby: <strong>{$person->name} {$person->surname}</strong></p>
    <form action="{"persons/upload_photo/{$person->id|intval}"|site_url}" method="post" data-ajax="false" enctype="multipart/form-data">
    {include file='web/partials/form.tpl' form=$form inline}
    <button type="submit" class="ui-shadow ui-btn ui-corner-all">Nahrať</button>
    </form>
{/block}