{extends file='web/layouts/standard.tpl'}
{block content_block}
    <div class="ui-body ui-body-a ui-corner-all">
        <h3>Môj LEDCOIN</h3>
        {if $operations->exists()}
            <table data-role="table" data-mode="reflow" class="ui-responsive grid_table" style="margin-bottom: 1em;">
                <thead>
                    <tr>
                        <th>Zostávajúci čas</th>
                        <th>Získaný čas</th>
                        <th>Použitý čas</th>
                        <th>Skupina</th>
                        <th>Škola</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{include file='web/partials/minutes_inflection.tpl' minutes={{$person->plus_time - $person->minus_time_direct - $person->minus_time_products - $person->minus_time_services}|intval} inline}</td>
                        <td>{include file='web/partials/minutes_inflection.tpl' minutes={$person->plus_time|intval} inline}</td>
                        <td>{include file='web/partials/minutes_inflection.tpl' minutes={{$person->minus_time_direct + $person->minus_time_products + $person->minus_time_services}|intval} inline}</td>
                        <td>{$person->group_title}</td>
                        <td>{$person->organisation}</td>
                    </tr>
                </tbody>
            </table>
            
            <table data-role="table" data-mode="reflow" class="ui-responsive grid_table">
                <thead>
                    <tr>
                        <th>Čas</th>
                        <th>Vedúci</th>
                        <th>Zamestnanie</th>
                        <th>Obsah transakcie</th>
                        <th>Čas za transakciu</th>
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
                        <td>+{include file='web/partials/minutes_inflection.tpl' minutes=$operation->time inline}</td>
                        <td><span class="operation_type_addition_highlight">+{include file='web/partials/minutes_inflection.tpl' minutes=$operation->time inline}</span></td>
                        {else}
                            {if $operation->subtraction_type eq Operation::SUBTRACTION_TYPE_DIRECT}
                            <td>-{include file='web/partials/minutes_inflection.tpl' minutes=$operation->time inline}</td>
                            <td><span class="operation_type_subtraction_highlight">-{include file='web/partials/minutes_inflection.tpl' minutes=$operation->time inline}</span></td>
                            {elseif $operation->subtraction_type eq Operation::SUBTRACTION_TYPE_PRODUCTS}{$additional_time_subtract = 0}
                            <td>
                                Nákup z bufetu:
                                {$product_quantities = $operation->product_quantity->order_by_related('product', 'title', 'asc')->include_related('product')}
                                {if $product_quantities->get_iterated()->exists()}
                                    <ul class="transaction_items_list">
                                    {foreach $product_quantities as $product_quantity}
                                        <li>{$product_quantity->product_title} ({$product_quantity->quantity|intval} x {include file='web/partials/minutes_inflection.tpl' minutes=$product_quantity->price|intval inline})</li>
                                        {$additional_time_subtract = $additional_time_subtract + $product_quantity->quantity|intval * $product_quantity->price|intval}
                                    {/foreach}
                                    </ul>
                                {else}
                                    ---
                                {/if}
                            </td>
                            <td><span class="operation_type_subtraction_highlight">-{include file='web/partials/minutes_inflection.tpl' minutes=$additional_time_subtract inline}</span></td>
                            {elseif $operation->subtraction_type eq Operation::SUBTRACTION_TYPE_SERVICES}{$additional_time_subtract = 0}
                            <td>
                                Využitie služieb:
                                {$service_usages = $operation->service_usage->order_by_related('service', 'title', 'asc')->include_related('service')}
                                {if $service_usages->get_iterated()->exists()}
                                    <ul class="transaction_items_list">
                                    {foreach $service_usages as $service_usage}
                                        <li>{$service_usage->service_title} ({$service_usage->quantity|intval} x {include file='web/partials/minutes_inflection.tpl' minutes=$service_usage->price|intval inline})</li>
                                        {$additional_time_subtract = $additional_time_subtract + $service_usage->quantity|intval * $service_usage->price|intval}
                                    {/foreach}
                                    </ul>
                                {else}
                                    ---
                                {/if}
                            </td>
                            <td><span class="operation_type_subtraction_highlight">-{include file='web/partials/minutes_inflection.tpl' minutes=$additional_time_subtract inline}</span></td>
                            {/if}
                        {/if}
                        <td>{$operation->comment|default:'---'}</td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
            {if $operations->paged->total_rows gt $operations->paged->page_size}
            <form action="{'ledcoin/my_time'|site_url}" method="post">
                {include file='web/partials/form.tpl' form=$form inline}
                <button type="submit">Ísť na stranu</button>
            </form>
            {/if}
        {else}
            <p>{$person->name} {$person->surname} nemá zatiaľ žiadne záznamy o transakciách s LEDCOIN-om.</p>
        {/if}
    </div>
{/block}