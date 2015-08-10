<div class="field_wrap" {include file="web/partials/data_attributes.tpl" data=$form_element.data inline}>
    <div class="ui-field-contain{if $form_element.class} {$form_element.class|escape:'html'}{/if}">
        <label {if $form_element.id}for="{$form_element.id}"{/if}>{$form_element.label|default:'Textový vstup'}</label>
        <input type="{if $form_element.type eq 'text_input'}text{elseif $form_element.type eq 'password_input'}password{/if}" name="{$form_element.name|default:'unknown_name'}" {if $form_element.id}id="{$form_element.id}"{/if} value="{form_value|escape:'html' default=$form_element.default|default:'' source=$form_source|default:'' name=$form_element.name|default:'' property=$form_element.object_property|default:''}"{if $form_element.placeholder} placeholder="{$form_element.placeholder|escape:'html'}"{/if}
               {if form_error($form_element.name) neq ''}data-theme="b"{/if}{if $form_element.clearbutton} data-clear-btn="true"{/if}
               {if isset($form_element.role)}data-role="{$form_element.role|escape:'html'}"{/if}
               {foreach $form_element.role_config as $key => $value} data-{$key}="{$value}"{/foreach}
               {if $form_element.disabled eq TRUE}disabled="disabled"{/if} />
    </div>
    <div{if $form_element.class} class="{$form_element.class|escape:'html'}"{/if}>
    {if $form_element.hint}<p><em>{$form_element.hint}</em></p>{/if}
    {if $form_element.name}{form_error($form_element.name, '<div class="ui-bar ui-bar-b ui-corner-all">', '</div>')}{/if}
    </div>
</div>