{extends file='web/layouts/error.tpl'}
{block content_block}
<div>
    <div class="ui-bar ui-bar-b">
        <h3>Stránka neexistuje</h3>
    </div>
    <div class="ui-body ui-body-b">
        <p>Stránka, ktorú sa pokúšate zobraziť sa nenašla.</p>
        <p>Ak ste zadávali adresu stránky ručne, presvečte sa, že ste v nej neurobili chybu!</p>
        <p><a href="{'/'|site_url}" class="ui-btn ui-icon-forward ui-corner-all ui-shadow ui-btn-icon-left" data-ajax="false">Návrat na hlavnú stránku</a></p>
    </div>
</div>
{/block}