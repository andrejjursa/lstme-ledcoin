{extends file='web/layouts/standard.tpl'}
{block content_block}
    <div class="ui-body ui-body-a ui-corner-all">
        <table data-role="table" data-mode="reflow" class="ui-responsive grid_table">
            <thead>
                <tr>
                    <th data-priority="persist">Názov</th>
                    <th data-priority="persist">Počet pokusov</th>
                    <th data-priority="1"></th>
                </tr>
            </thead>
            <tbody>
                {if $questionnaires->exists()}
                    {foreach $questionnaires as $questionnaire}
                        {$cant_answer = false}
                        <tr>
                            <td>{$questionnaire->title|escape:'html'}</td>
                            <td>
                                {if $questionnaire->attempts|is_null}
                                    {$to_attempts = 'Neobmedzene'}
                                {else}
                                    {$to_attempts = $questionnaire->attempts|intval}
                                    {if $questionnaire->max_answer_number|intval gte $to_attempts}
                                        {$cant_answer = true}
                                    {/if}
                                {/if}
                                {$questionnaire->max_answer_number|intval} / {$to_attempts}
                            </td>
                            <td><a href="{if $cant_answer}javascript:void(0);{else}{"ledcoin/answer_questionnaire/{$questionnaire->id|intval}"|site_url}{/if}" class="ui-shadow ui-btn ui-corner-all{if $cant_answer} ui-btn-b{/if}">Vyplniť dotazník</a></td>
                        </tr>
                    {/foreach}
                {else}
                    <tr>
                        <td colspan="3">Nie sú dostupné žiadne dotazníky.</td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
{/block}