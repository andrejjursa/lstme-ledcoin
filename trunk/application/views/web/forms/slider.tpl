{if isset($form_element.min) and isset($form_element.max)}
<div class="ui-field-contain{if $form_element.class} {$form_element.class|escape:'html'}{/if}"{include file="web/partials/data_attributes.tpl" data=$form_element.data inline}>
    <label {if $form_element.id}for="{$form_element.id}"{/if}>{$form_element.label|default:'Číselný vstup'}</label>
    <input type="range" name="{$form_element.name|default:'unknown_name'}" {if $form_element.id}id="{$form_element.id}"{/if}
           value="{form_value|intval default=$form_element.default|default:$form_element.min source=$form_source|default:'' name=$form_element.name|default:'' property=$form_element.object_property|default:''}"
           min="{$form_element.min|intval}" max="{$form_element.max|intval}" data-show-value="true" />
</div>
<div{if $form_element.class} class="{$form_element.class|escape:'html'}"{/if}>
{if $form_element.hint}<p><em>{$form_element.hint}</em></p>{/if}
{if $form_element.name}{form_error($form_element.name, '<div class="ui-bar ui-bar-b ui-corner-all">', '</div>')}{/if}
</div>
{/if}