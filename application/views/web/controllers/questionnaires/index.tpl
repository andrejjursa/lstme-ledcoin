{extends file='web/layouts/admin.tpl'}
{block content_block}
    {if $questionnaires->exists()}
        <form action="javascipt:void(0);" class="online_filter_form" method="post" data-search_table="table.admin_grid_table" data-search_data="gridtable-title">
            {include file='web/partials/form.tpl' form=filter_get_online_filter_form() inline}
        </form>
    {/if}
    <div class="ui-body ui-body-c ui-corner-all">
        {if $questionnaires->exists()}
            <table data-role="table" data-mode="reflow" class="admin_grid_table ui-responsive"
                   data-gridtable-operations="show:Ukážka,edit:Upraviť,delete:Vymazať"
                   data-gridtable-operation-edit-url="{'questionnaires/edit_questionnaire/--ID--'|site_url}"
                   data-gridtable-operation-delete-prompt="true"
                   data-gridtable-operation-delete-prompt-title="Vymazať dotazník?"
                   data-gridtable-operation-delete-prompt-text="Naozaj chcete vymazať dotazník --TITLE--?"
                   data-gridtable-operation-delete-prompt-cancel="Nie, nechcem"
                   data-gridtable-operation-delete-prompt-ok="Áno, chcem"
                   data-gridtable-operation-delete-prompt-ok-url="{'questionnaires/delete_questionnaire/--ID--'|site_url}"
                   data-gridtable-object_name="title"
                   data-gridtable-operation-show-url="{'questionnaires/show_questionnaire/--ID--'|site_url}"
            >
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Názov</th>
                    <th>Zverejnený</th>
                    <th>Počet pokusov</th>
                    <th>Počet odpovedí</th>
                </tr>
                </thead>
                <tbody>
                {foreach $questionnaires as $questionnaire}
                    <tr data-gridtable-unique="group_{$questionnaire->id|intval}" data-gridtable-id="{$questionnaire->id|intval}" data-gridtable-title="{$questionnaire->title|escape:'html'|addslashes}">
                        <td>{$questionnaire->id|intval}</td>
                        <td>{$questionnaire->title}</td>
                        <td>{if $questionnaire->published}Áno{else}Nie{/if}</td>
                        <td>{if is_null($questionnaire->attempts)}Neobmedzene{else}{$questionnaire->attempts|intval}{/if}</td>
                        <td>{$questionnaire->questionnaire_answer_count|intval}</td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        {else}
            Momentálne nie sú k dispozícii žiadne dotazníky.
        {/if}
    </div>
{/block}
{block header_block}
    <script type="text/javascript">
        $(document).ready(function(){
            make_gridtable_active('table.admin_grid_table');
        });
    </script>
{/block}