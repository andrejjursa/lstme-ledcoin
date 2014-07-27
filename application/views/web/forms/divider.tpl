{if isset($form_element.text) and trim($form_element.text) neq ''}
    <hr class="form_divider_advanced form_divider_top" />
    <p class="form_divider_text"><strong>{$form_element.text}</strong></p>
    <hr class="form_divider_advanced form_divider_bottom" />
{else}
    <hr class="form_divider_simple" />
{/if}