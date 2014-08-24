<div class="field_wrap" {include file="web/partials/data_attributes.tpl" data=$form_element.data inline}>
    {if isset($form_element.text) and trim($form_element.text) neq ''}
        <hr class="form_divider_advanced form_divider_top{if $form_element.class} {$form_element.class|escape:'html'}{/if}" />
        <p class="form_divider_text{if $form_element.class} {$form_element.class|escape:'html'}{/if}"><strong>{$form_element.text}</strong></p>
        <hr class="form_divider_advanced form_divider_bottom{if $form_element.class} {$form_element.class|escape:'html'}{/if}" />
    {else}
        <hr class="form_divider_simple{if $form_element.class} {$form_element.class|escape:'html'}{/if}" />
    {/if}
</div>