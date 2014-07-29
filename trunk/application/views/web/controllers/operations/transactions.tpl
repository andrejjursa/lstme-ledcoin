{extends file='web/layouts/admin.tpl'}
{block content_block}
    <div class="ui-body ui-body-c ui-corner-all">
        {if $operations->exists()}
        <table data-role="table" data-mode="reflow" class="admin_grid_table ui-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Typ</th>
                    <th>Dátum</th>
                    <th>Kúpené produkty</th>
                    <th>Kúpené služby</th>
                    <th>Strojový čas</th>
                    <th>Celkovo za operáciu</th>
                    <th>Komentár</th>
                </tr>
            </thead>
            <tbody>
                {foreach $operations as $operation}
                <tr>
                    <td>{$operation->id}</td>
                    <td>{if $operation->type eq 'addition'}<span class="operation_type_addition_highlight">pridanie</span>{else}<span class="operation_type_subtraction_highlight">odobratie</span>{/if}</td>
                    <td>{$operation->created|date_format:'%d. %m. %Y'|default:'neznámy'}</td>
                    {$additional_time_subtract = 0}
                    {if $operation->type eq 'addition'}
                    <td>---</td>
                    <td>---</td>
                    {else}
                    <td>
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
                    <td>
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
                    {/if}
                    <td>{if $operation->type eq 'addition'}+{else}-{/if} {include file='web/partials/minutes_inflection.tpl' minutes=$operation->time|intval inline}</td>
                    <td><strong>{if $operation->type eq 'addition'}+{else}-{/if} {include file='web/partials/minutes_inflection.tpl' minutes={$operation->time|intval + $additional_time_subtract|intval} inline}</strong></td>
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
            Momentálne nie sú k dispozícii žiadne transakcie strojového času pre účastníka <strong>{$person->name} {$person->surname}</strong>.
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