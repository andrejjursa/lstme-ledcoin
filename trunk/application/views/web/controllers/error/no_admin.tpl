{extends file="web/layouts/error.tpl"}
{block content_block}
<div>
    <div class="ui-bar ui-bar-b">
        <h3>Chyba</h3>
    </div>
    <div class="ui-body ui-body-b">
        <p>Nie si prihlásený alebo nie si administrátor!</p>
        <p>Nie je možné pracovať s požadovaným modulom!</p>
        <p><a href="{'/'|site_url}" class="ui-btn ui-icon-forward ui-corner-all ui-shadow ui-btn-icon-left" data-ajax="false">Pokračuj na hlavnú stránku</a></p>
    </div>
</div>
{/block}