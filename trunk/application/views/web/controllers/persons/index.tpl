{extends file='web/layouts/admin.tpl'}
{block content_block}
    <div class="ui-body ui-body-c ui-corner-all">
        {if $persons->exists()}
        <table data-role="table" data-mode="reflow" class="admin_grid_table ui-responsive"
               data-gridtable-operations="edit:Upraviť,photo:Pridať/upraviť fotku,delete:Vymazať"
               data-gridtable-operation-edit-url="{'persons/edit_person/--ID--'|site_url}"
               data-gridtable-operation-photo-url="{'persons/edit_photo/--ID--'|site_url}"
               data-gridtable-operation-delete-prompt="true"
               data-gridtable-operation-delete-prompt-title="Vymazať osobu?"
               data-gridtable-operation-delete-prompt-text="Naozaj chcete vymazať osobu --NAME-- (--LOGIN--)?"
               data-gridtable-operation-delete-prompt-cancel="Nie, nechcem"
               data-gridtable-operation-delete-prompt-ok="Áno, chcem"
               data-gridtable-operation-delete-prompt-ok-url="{'persons/delete_person/--ID--'|site_url}"
        >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Obr.</th>
                    <th>Meno</th>
                    <th>Login</th>
                    <th>Skupina</th>
                    <th>Prihlasovanie</th>
                    <th>Administrátor</th>
                </tr>
            </thead>
            <tbody>
                {foreach $persons as $person}
                <tr data-gridtable-unique="person_{$person->id|intval}" data-gridtable-id="{$person->id|intval}" data-gridtable-name="{$person->name|escape:'html'|addslashes} {$person->surname|escape:'html'|addslashes}" data-gridtable-login="{$person->login|escape:'html'|addslashes}">
                    <td>{$person->id|intval}</td>
                    <td><img src="{get_person_image_min($person->id)}" alt="" /></td>
                    <td>{$person->name} {$person->surname}</td>
                    <td>{$person->login}</td>
                    <td>{$person->group_title|default:'<strong>---</strong>'}</td>
                    <td>{if $person->enabled}povolené{else}zakázané{/if}</td>
                    <td>{if $person->admin}áno{else}nie{/if}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        {else}
            Momentálne v systéme neexistujú žiadne osoby.
        {/if}
    </div>
{/block}
{block header_block}
<script type="text/javascript">
$(document).ready(function(){
    make_gridtable_active('table.admin_grid_table');
    window.location = '#';
});
</script>
{/block}