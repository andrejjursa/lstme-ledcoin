{foreach $form as $form_element}
    {if $form_element.type eq 'text_input'}
        {include file='web/forms/input.tpl' form_element=$form_element form_source=$source inline}
    {elseif $form_element.type eq 'password_input'}
        {include file='web/forms/input.tpl' form_element=$form_element form_source=$source inline}
    {elseif $form_element.type eq 'select'}
        {include file='web/forms/select.tpl' form_element=$form_element form_source=$source inline}
    {elseif $form_element.type eq 'flipswitch'}
        {include file='web/forms/flipswitch.tpl' form_element=$form_element form_source=$source inline}
    {/if}
{/foreach}