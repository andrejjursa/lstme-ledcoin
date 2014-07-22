{$flash_messages = get_flash_messages()}
{if is_array($flash_messages) and count($flash_messages) gt 0}
    {foreach $flash_messages as $flash_message}
        {if is_object($flash_message) and trim($flash_message->text) ne '' and trim($flash_message->type) ne ''}
            {if $flash_message->type eq 'success'}
                <div class="ui-body ui-body-c ui-corner-all" style="margin-bottom: 1em;">
                    <p>{$flash_message->text}</p>
                </div>
            {elseif $flash_message->type eq 'error'}
                <div class="ui-body ui-body-b ui-corner-all" style="margin-bottom: 1em;">
                    <p>{$flash_message->text}</p>
                </div>
            {else}
                <div class="ui-body ui-body-a ui-corner-all" style="margin-bottom: 1em;">
                    <p>{$flash_message->text}</p>
                </div>
            {/if}
        {/if}
    {/foreach}
{/if}