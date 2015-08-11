{extends file='web/layouts/admin.tpl'}
{block content_block}
    <div class="ui-body ui-body-c ui-corner-all">
        <p>Transakcie účastníka <strong>{$person->name} {$person->surname}</strong>:</p>
        {if $operations->exists()}
        <table data-role="table" data-mode="reflow" class="admin_grid_table ui-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Dátum</th>
                    <th>Obsah operácie</th>
                    <th>LEDCOIN za operáciu</th>
                    <th>Zamestnanie</th>
                    <th>Vedúci</th>
                    <th>Komentár</th>
                </tr>
            </thead>
            <tbody>
                {foreach $operations as $operation}
                <tr>
                    <td>{$operation->id}</td>
                    <td>{$operation->created|date_format:'%d. %m. %H:%M'|default:'neznámy'}</td>
                    {$additional_amount_subtract = 0}
                    {if $operation->type eq Operation::TYPE_ADDITION}
                    <td>Pridanie {include file='web/partials/ledcoin_inflection.tpl' ledcoins=$operation->amount|doubleval inline}.</td>
                    {else}
                        {if $operation->subtraction_type eq Operation::SUBTRACTION_TYPE_DIRECT}
                        <td>Odobratie {include file='web/partials/ledcoin_inflection.tpl' ledcoins=$operation->amount|doubleval inline}.</td>
                        {elseif $operation->subtraction_type eq Operation::SUBTRACTION_TYPE_PRODUCTS}
                        <td>Nákup z bufetu:
                            {$product_quantities = $operation->product_quantity->order_by_related('product', 'title', 'asc')->include_related('product')}
                            {if $product_quantities->get_iterated()->exists()}
                                <ul class="transaction_items_list">
                                {foreach $product_quantities as $product_quantity}
                                    <li>{$product_quantity->product_title} ({$product_quantity->quantity|intval} x {include file='web/partials/ledcoin_inflection.tpl' ledcoins=$product_quantity->price|doubleval inline} x {include file='web/partials/ledcoin_inflection.tpl' ledcoins=$product_quantity->multiplier|doubleval inline})</li>
                                    {$additional_amount_subtract = $additional_amount_subtract + $product_quantity->quantity|intval * $product_quantity->price|doubleval * $product_quantity->multiplier|doubleval}
                                {/foreach}
                                </ul>
                            {else}
                                ---
                            {/if}
                        </td>
                        {elseif $operation->subtraction_type eq Operation::SUBTRACTION_TYPE_SERVICES}
                        <td>Využitie služieb:
                            {$service_usages = $operation->service_usage->order_by_related('service', 'title', 'asc')->include_related('service')}
                            {if $service_usages->get_iterated()->exists()}
                                <ul class="transaction_items_list">
                                {foreach $service_usages as $service_usage}
                                    <li>{$service_usage->service_title} ({$service_usage->quantity|intval} x {include file='web/partials/ledcoin_inflection.tpl' ledcoins=$service_usage->price|doubleval inline} x {include file='web/partials/ledcoin_inflection.tpl' ledcoins=$service_usage->multiplier|doubleval inline})</li>
                                    {$additional_amount_subtract = $additional_amount_subtract + $service_usage->quantity|intval * $service_usage->price|doubleval * $service_usage->multiplier|doubleval}
                                {/foreach}
                                </ul>
                            {else}
                                ---
                            {/if}
                        </td>
                        {/if}
                    {/if}
                    <td>{if $operation->type eq Operation::TYPE_ADDITION}<span class="operation_type_addition_highlight">+{else}<span class="operation_type_subtraction_highlight">-{/if} {include file='web/partials/ledcoin_inflection.tpl' ledcoins={$operation->amount|doubleval + $additional_amount_subtract|doubleval} inline}</span></td>
                    <td>{$operation->workplace_title|default:'---'}</td>
                    <td>{$operation->admin_name} {$operation->admin_surname}</td>
                    <td>{$operation->comment|default:'---'}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        {if $operations->paged->total_rows gte $operations->paged->page_size}
        <form action="{"operations/set_transactions_pagination/{$person->id|intval}"|site_url}" method="post" id="pagination_form" data-ajax="false">
            {include file='web/partials/form.tpl' form=$form inline}
        </form>
        {/if}
        {else}
            <p>Momentálne nie sú k dispozícii žiadne transakcie LEDOIN-u pre účastníka <strong>{$person->name} {$person->surname}</strong>.</p>
        {/if}
    </div>
{/block}
{block header_block}
<script type="text/javascript">
$(document).ready(function(){
    $('#pagination-page, #pagination-page_size').change(function() {
        $('#pagination_form').submit();
    });
});
</script>
{/block}