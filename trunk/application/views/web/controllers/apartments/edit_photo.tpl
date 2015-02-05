{extends file='web/layouts/admin.tpl'}
{block content_block}
    <p>Fotografia izby: <strong>{$apartment->title}</strong></p>
    <form action="{"apartments/upload_photo/{$apartment->id|intval}"|site_url}" method="post" data-ajax="false" enctype="multipart/form-data">
    {include file='web/partials/form.tpl' form=$form inline}
    <button type="submit" class="ui-shadow ui-btn ui-corner-all">Nahrať</button>
    </form>
{/block}