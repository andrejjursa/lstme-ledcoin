{extends file='web/layouts/admin.tpl'}
{block content_block}
    <form action="{'operations/create_operation'|site_url}" method="post" data-ajax="false">
    {include file='web/partials/form.tpl' form=$form inline}
    <button type="submit" class="ui-shadow ui-btn ui-corner-all">Vytvoriť</button>
    </form>
{/block}
{block header_block}
<script type="text/javascript">
$(document).ready(function() {
    $('#operation-type').change(function() {
        $('form').prop('action', '{'operations/new_operation'|site_url}').submit();
    });
});
</script>
{/block}