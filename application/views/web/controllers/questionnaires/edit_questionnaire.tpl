{extends file='web/layouts/admin.tpl'}
{block content_block}
    <form action="{"questionnaires/update_questionnaire/{$questionnaire->id|intval}"|site_url}" method="post" enctype="multipart/form-data" data-ajax="false">
        {include file='web/partials/form.tpl' form=$form source=$questionnaire}
        <button type="submit" class="ui-shadow ui-btn ui-corner-all">Uložiť alebo nahrať súbor</button>
    </form>

    {if $files}
        <frameset>
            <legeng>Súbory</legeng>
            <div>
                {foreach $files as $file}
                    <div>
                        <a href="{$file.link}" target="_blank">{$file.filename}</a>
                    </div>
                {/foreach}
            </div>
        </frameset>
    {/if}
{/block}