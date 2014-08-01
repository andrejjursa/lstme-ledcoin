{extends file='web/layouts/admin.tpl'}
{block content_block}
    <div class="ui-body ui-body-c ui-corner-all">
        {if $product_quantities->exists()}
        <table data-role="table" data-mode="reflow" class="admin_grid_table ui-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Dátum</th>
                    <th>Počet kusov</th>
                    <th>Účastník</th>
                    <th>Vedúci</th>
                    <th>Cena za kus</th>
                </tr>
            </thead>
            <tbody>
                {foreach $product_quantities as $quantity}
                <tr>
                    <td>{$quantity->id}</td>
                    <td>{$quantity->created|date_format:'%d. %m. %H:%M'|default:'neznámy'}</td>
                    <td>{if $quantity->type eq Product_quantity::TYPE_ADDITION}<span class="operation_type_addition_highlight">+{else}<span class="operation_type_subtraction_highlight">-{/if} {include file='web/partials/pieces_inflection.tpl' pieces=$quantity->quantity|intval inline}</span></td>
                    {if $quantity->type eq Product_quantity::TYPE_ADDITION}
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                    {else}
                        <td>{$quantity->operation_person_name} {$quantity->operation_person_surname}</td>
                        <td>{$quantity->operation_admin_name} {$quantity->operation_admin_surname}</td>
                        <td>{include file='web/partials/minutes_inflection.tpl' minutes=$quantity->price|intval inline}</td>
                    {/if}
                </tr>
                {/foreach}
            </tbody>
        </table>
        {else}
            Momentálne nie sú k dispozícii žiadne prehľadové informácie k produktu <strong>{$product->title}</strong>.
        {/if}
    </div>
{/block}