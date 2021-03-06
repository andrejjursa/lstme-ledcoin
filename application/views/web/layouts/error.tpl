<!DOCTYPE html>{$this->load->config('ledcoin')}{$app_version = $this->config->item('app_version')}
<html lang="sk">
    <head>
        <title>LEDCOIN{if $title}: {$title}{/if}</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" type="text/css" href="{"assets/themes/lstme.min.css?ledcoin_version={$app_version}"|base_url}" />
        <link rel="stylesheet" type="text/css" href="{"assets/themes/jquery.mobile.icons.min.css?ledcoin_version={$app_version}"|base_url}" />
        <link rel="stylesheet" type="text/css" href="{"assets/jquery.mobile.structure-1.4.5.min.css?ledcoin_version={$app_version}"|base_url}}" />
        <link rel="stylesheet" type="text/css" href="{"assets/ledcoin_error.css?ledcoin_version={$app_version}"|base_url}}" />
        <script type="text/javascript" src="{"assets/jquery-1.11.1.min.js?ledcoin_version={$app_version}"|base_url}"></script>
        <script type="text/javascript" src="{"assets/jquery.mobile-1.4.5.min.js?ledcoin_version={$app_version}"|base_url}"></script>
        <script type="text/javascript"> jQuery.mobile.ajaxEnabled = false; </script>
    </head>
    <body>
        <div data-role="page" id="ledcoin-main-page" data-theme="b">
            <div data-role="panel" id="navpanel" data-position="right" data-position-fixed="true" data-display="overlay" data-swipe-close="false">
                {include file='web/partials/navpanel.tpl' inline}
            </div>
            
            <div data-role="header" data-position="fixed" data-tap-toggle="false">
                <h1>LEDCOIN{if $title} / {$title}{/if}</h1>
                <a href="#navpanel" class="ledcoin-navigation-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-bars ui-nodisc-icon ui-alt-icon ui-btn-right">Navigácia</a>
            </div>
            
            <div data-role="content">
                {include file='web/partials/flashmessages.tpl' inline}
                {block content_block}{/block}
            </div>
            
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                <p style="text-align: center;">&copy; LSTME 2014, verzia {$app_version}</p>
            </div>
            
            {include file='web/partials/logoutDialog.tpl' inline}
        </div>
    </body>
</html>