{extends file='web/layouts/standard.tpl'}
{block content_block}
    <div class="ui-body ui-body-a ui-corner-all">
        <h3>Môj LEDCOIN</h3>
        {if $operations->exists()}
            <table data-role="table" data-mode="reflow" class="ui-responsive grid_table" style="margin-bottom: 1em;">
                <thead>
                    <tr>
                        <th>Zostávajúci LEDCOIN</th>
                        <th>Získaný LEDCOIN</th>
                        <th>Použitý LEDCOIN</th>
                        <th>Skupina</th>
                        <th>Škola</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{include file='web/partials/ledcoin_inflection.tpl' ledcoins={{$person->plus_amount - $person->minus_amount_direct - $person->minus_amount_products - $person->minus_amount_services}|intval} inline}</td>
                        <td>{include file='web/partials/ledcoin_inflection.tpl' ledcoins={$person->plus_amount|intval} inline}</td>
                        <td>{include file='web/partials/ledcoin_inflection.tpl' ledcoins={{$person->minus_amount_direct + $person->minus_amount_products + $person->minus_amount_services}|intval} inline}</td>
                        <td>{$person->group_title}</td>
                        <td>{$person->organisation}</td>
                    </tr>
                </tbody>
            </table>
            
            <table data-role="table" data-mode="reflow" class="ui-responsive grid_table">
                <thead>
                    <tr>
                        <th>LEDCOIN</th>
                        <th>Vedúci</th>
                        <th>Zamestnanie</th>
                        <th>Obsah transakcie</th>
                        <th>LEDCOIN za transakciu</th>
                        <th>Komentár</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach $operations as $operation}
                    <tr>
                        <td>{$operation->created|date_format:'%d. %m. %H:%M'|default:'neznámy'}</td>
                        <td>{$operation->admin_name} {$operation->admin_surname}</td>
                        <td>{$operation->workplace_title|default:'---'}</td>
                        {if $operation->type eq Operation::TYPE_ADDITION}
                        <td>+{include file='web/partials/ledcoin_inflection.tpl' ledcoins=$operation->amount inline}</td>
                        <td><span class="operation_type_addition_highlight">+{include file='web/partials/ledcoin_inflection.tpl' ledcoins=$operation->amount inline}</span></td>
                        {else}
                            {if $operation->subtraction_type eq Operation::SUBTRACTION_TYPE_DIRECT}
                            <td>-{include file='web/partials/ledcoin_inflection.tpl' ledcoins=$operation->amount inline}</td>
                            <td><span class="operation_type_subtraction_highlight">-{include file='web/partials/ledcoin_inflection.tpl' ledcoins=$operation->amount inline}</span></td>
                            {elseif $operation->subtraction_type eq Operation::SUBTRACTION_TYPE_PRODUCTS}{$additional_amount_subtract = 0}
                            <td>
                                Nákup z bufetu:
                                {$product_quantities = $operation->product_quantity->order_by_related('product', 'title', 'asc')->include_related('product')}
                                {if $product_quantities->get_iterated()->exists()}
                                    <ul class="transaction_items_list">
                                    {foreach $product_quantities as $product_quantity}
                                        <li>{$product_quantity->product_title} ({$product_quantity->quantity|intval} x {include file='web/partials/ledcoin_inflection.tpl' ledcoins=$product_quantity->price|intval inline})</li>
                                        {$additional_amount_subtract = $additional_amount_subtract + $product_quantity->quantity|intval * $product_quantity->price|intval}
                                    {/foreach}
                                    </ul>
                                {else}
                                    ---
                                {/if}
                            </td>
                            <td><span class="operation_type_subtraction_highlight">-{include file='web/partials/ledcoin_inflection.tpl' ledcoins=$additional_amount_subtract inline}</span></td>
                            {elseif $operation->subtraction_type eq Operation::SUBTRACTION_TYPE_SERVICES}{$additional_amount_subtract = 0}
                            <td>
                                Využitie služieb:
                                {$service_usages = $operation->service_usage->order_by_related('service', 'title', 'asc')->include_related('service')}
                                {if $service_usages->get_iterated()->exists()}
                                    <ul class="transaction_items_list">
                                    {foreach $service_usages as $service_usage}
                                        <li>{$service_usage->service_title} ({$service_usage->quantity|intval} x {include file='web/partials/ledcoin_inflection.tpl' ledcoins=$service_usage->price|intval inline})</li>
                                        {$additional_amount_subtract = $additional_amount_subtract + $service_usage->quantity|intval * $service_usage->price|intval}
                                    {/foreach}
                                    </ul>
                                {else}
                                    ---
                                {/if}
                            </td>
                            <td><span class="operation_type_subtraction_highlight">-{include file='web/partials/ledcoin_inflection.tpl' ledcoins=$additional_amount_subtract inline}</span></td>
                            {/if}
                        {/if}
                        <td>{$operation->comment|default:'---'}</td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
            {if $operations->paged->total_rows gt $operations->paged->page_size}
            <form action="{'ledcoin/my_ledcoin'|site_url}" method="post">
                {include file='web/partials/form.tpl' form=$form inline}
                <button type="submit">Ísť na stranu</button>
            </form>
            {/if}
        {else}
            <p>{$person->name} {$person->surname} nemá zatiaľ žiadne záznamy o transakciách s LEDCOIN-om.</p>
        {/if}
    </div>
{/block}