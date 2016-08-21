<div class="field_wrap" {include file="web/partials/data_attributes.tpl" data=$form_element.data inline}>
    {if $form_element.question_text}<div>{$form_element.question_text}</div>{/if}
    <div class="ui-field-contain{if $form_element.class} {$form_element.class|escape:'html'}{/if}">
        {$selected = {form_value default=$form_element.default|default:'' source=$form_source|default:'' name=$form_element.name|default:'' property=$form_element.object_property|default:''}}
        {$selected_array = '|'|explode:$selected}
        <fieldset data-role="controlgroup">
            <legend>{$form_element.label|default:'Textový vstup'}</legend>
            {foreach $form_element.values as $oid => $option}
                {$checked = ''}
                {if !empty($selected) and in_array($oid, $selected_array)}
                    {$checked = ' checked="checked"'}
                {/if}
                <input name="{$form_element.name}[{$oid}]" id="{$form_element.id}-{$oid}" value="{$oid}" type="checkbox"{$checked} {if form_error($form_element.name) neq ''}data-theme="b"{/if} />
                <label for="{$form_element.id}-{$oid}" {if form_error($form_element.name) neq ''}data-theme="b"{/if}>{$option}</label>
            {/foreach}
        </fieldset>
    </div>
    <div{if $form_element.class} class="{$form_element.class|escape:'html'}"{/if}>
        {if $form_element.hint}<p><em>{$form_element.hint}</em></p>{/if}
        {if $form_element.name}{form_error($form_element.name, '<div class="ui-bar ui-bar-b ui-corner-all">', '</div>')}{/if}
    </div>
</div>