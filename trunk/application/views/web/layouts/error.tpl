<!DOCTYPE html>{$app_version = $this->config->item('app_version')}
<html lang="sk">
    <head>
        <title>Strojový čas{if $title}: {$title}{/if}</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" type="text/css" href="{"assets/themes/lstme.min.css?strojak_version={$app_version}"|base_url}" />
        <link rel="stylesheet" type="text/css" href="{"assets/themes/jquery.mobile.icons.min.css?strojak_version={$app_version}"|base_url}" />
        <link rel="stylesheet" type="text/css" href="{"assets/jquery.mobile.structure-1.4.3.min.css?strojak_version={$app_version}"|base_url}}" />
        <script type="text/javascript" src="{"assets/jquery-1.11.1.min.js?strojak_version={$app_version}"|base_url}"></script>
        <script type="text/javascript" src="{"assets/jquery.mobile-1.4.3.min.js?strojak_version={$app_version}"|base_url}"></script>
    </head>
    <body>
        <div data-role="page" id="strojak-main-page" data-theme="b">
            <div data-role="header" data-position="fixed">
                <h1>Strojový čas{if $title} / {$title}{/if}</h1>
            </div>
            
            <div data-role="content">
                {block content_block}{/block}
            </div>
            
            <div data-role="footer" data-position="fixed">
                <p style="text-align: center;">&copy; LSTME 2014</p>
            </div>
        </div>
    </body>
</html>