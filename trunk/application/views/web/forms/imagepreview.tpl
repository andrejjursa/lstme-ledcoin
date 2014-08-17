<div class="ui-field-contain{if $form_element.class} {$form_element.class|escape:'html'}{/if}">
    <label>{$form_element.label|default:'Textový vstup'}</label>
    <img src="{$form_element.path}" alt="" />    
</div>
<div{if $form_element.class} class="{$form_element.class|escape:'html'}"{/if}>
{if $form_element.hint}<p><em>{$form_element.hint}</em></p>{/if}
{if $form_element.name}{form_error($form_element.name, '<div class="ui-bar ui-bar-b ui-corner-all">', '</div>')}{/if}
</div>