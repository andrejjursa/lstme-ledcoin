{extends file='web/layouts/admin.tpl'}
{block content_block}
    {if count($form.arangement) gt 3 and $type neq Operation::TYPE_ADDITION and $subtype neq Operation::SUBTRACTION_TYPE_DIRECT}
    <form action="javascipt:void(0);" class="online_filter_form" method="post" data-search_form="form.operation_form" data-search_data="service-title,product-title">
        {include file='web/partials/form.tpl' form=filter_get_online_filter_form() inline}
    </form>
    <hr class="form_divider_simple" />
    {/if}
    <form action="{'operations/create_operation'|site_url}" method="post" data-ajax="false" class="operation_form">
    {include file='web/partials/form.tpl' form=$form inline}
    <button type="submit" class="ui-shadow ui-btn ui-corner-all">Vytvoriť</button>
    </form>
{/block}
{block header_block}
<script type="text/javascript">
$(document).ready(function() {
    $('#operation-type, #operation-subtraction_type').change(function() {
        $('form').prop('action', '{'operations/new_operation'|site_url}').submit();
    });
});
</script>
{/block}