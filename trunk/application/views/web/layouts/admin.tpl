<!DOCTYPE html>{$this->load->config('strojak')}{$app_version = $this->config->item('app_version')}
<html lang="sk">
    <head>
        <title>Strojový čas{if $title}: {$title}{/if}</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" type="text/css" href="{"assets/themes/lstme.min.css?strojak_version={$app_version}"|base_url}" />
        <link rel="stylesheet" type="text/css" href="{"assets/themes/jquery.mobile.icons.min.css?strojak_version={$app_version}"|base_url}" />
        <link rel="stylesheet" type="text/css" href="{"assets/jquery.mobile.structure-1.4.3.min.css?strojak_version={$app_version}"|base_url}}" />
        <link rel="stylesheet" type="text/css" href="{"assets/strojak_admin.css?strojak_version={$app_version}"|base_url}}" />
        <script type="text/javascript" src="{"assets/jquery-1.11.1.min.js?strojak_version={$app_version}"|base_url}"></script>
        <script type="text/javascript" src="{"assets/jquery.mobile-1.4.3.min.js?strojak_version={$app_version}"|base_url}"></script>
        <script type="text/javascript"> jQuery.mobile.ajaxEnabled = false; </script>
        <script type="text/javascript" src="{"assets/strojak_admin.js?strojak_version={$app_version}"|base_url}"></script>
        {block header_block}{/block}
    </head>
    <body>
        <div data-role="page" id="strojak-main-page" data-theme="c">
            <div data-role="panel" id="navpanel" data-position="right" data-position-fixed="true" data-display="overlay" data-swipe-close="false">
                {include file='web/partials/navpanel.tpl' inline}
            </div>
            
            <div data-role="header" data-position="fixed" data-tap-toggle="false">
                <h1>Strojový čas{if $title} / {$title}{/if}</h1>
                <a href="#navpanel" class="strojak-navigation-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-bars ui-nodisc-icon ui-alt-icon ui-btn-right">Navigácia</a>
                {if $back_url}
                <a href="{$back_url}" data-ajax="false" class="ui-btn ui-btn-icon-notext ui-corner-all ui-icon-back ui-nodisc-icon ui-alt-icon ui-btn-left">Nazad</a>
                {/if}
                {if $new_item_url}
                <a href="{$new_item_url}" data-ajax="false" class="ui-btn ui-btn-icon-notext ui-corner-all ui-icon-plus ui-nodisc-icon ui-alt-icon ui-btn-left">Vytvoriť nový</a>
                {/if}
            </div>
            
            <div data-role="content">
                {include file='web/partials/flashmessages.tpl' inline}
                {block content_block}{/block}
            </div>
            
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                <p style="text-align: center;">&copy; LSTME 2014</p>
            </div>
            
            {include file='web/partials/logoutDialog.tpl' inline}
        </div>
    </body>
</html>