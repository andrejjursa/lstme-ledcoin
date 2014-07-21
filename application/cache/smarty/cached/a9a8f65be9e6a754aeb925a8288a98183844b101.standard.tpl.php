<?php /*%%SmartyHeaderCode:211553cd320fa0b1b4-02746589%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a9a8f65be9e6a754aeb925a8288a98183844b101' => 
    array (
      0 => 'application\\views\\web\\layouts\\standard.tpl',
      1 => 1405958989,
      2 => 'file',
    ),
    '3fbf8869f9133a2dcb36200bfd275fde4aa88b2a' => 
    array (
      0 => 'application\\views\\web\\partials\\navpanel.tpl',
      1 => 1405959016,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '211553cd320fa0b1b4-02746589',
  'cache_lifetime' => 3600,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_53cd3b6acccd33_67860075',
  'variables' => 
  array (
    'this' => 0,
    'app_version' => 0,
  ),
  'has_nocache_code' => true,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53cd3b6acccd33_67860075')) {function content_53cd3b6acccd33_67860075($_smarty_tpl) {?><!DOCTYPE html><html lang="sk">
    <head>
        <title></title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" type="text/css" href="http://strojak.localhost/assets/themes/lstme.min.css?strojak_version=1.0.0" />
        <link rel="stylesheet" type="text/css" href="http://strojak.localhost/assets/themes/jquery.mobile.icons.min.css?strojak_version=1.0.0" />
        <link rel="stylesheet" type="text/css" href="http://strojak.localhost/assets/jquery.mobile.structure-1.4.3.min.css?strojak_version=1.0.0}" />
        <script type="text/javascript" src="http://strojak.localhost/assets/jquery-1.11.1.min.js?strojak_version=1.0.0"></script>
        <script type="text/javascript" src="http://strojak.localhost/assets/jquery.mobile-1.4.3.min.js?strojak_version=1.0.0"></script>
        <script type="text/javascript">
            $(document).on('pagecreate', '#strojak-main-page', function() {
                $(document).on('swipeleft', '#strojak-main-page', function(e) {
                    if ($('#navpanel').jqmData('panel') !== 'open') {
                        $('#navpanel').panel('open');
                    }
                });
            });
        </script>
    </head>
    <body>
        <div data-role="page" id="strojak-main-page">
            <div data-role="panel" id="navpanel" data-position="right" data-position-fixed="true" data-display="overlay">
                <a href="<?php echo site_url('/');?>
" class="ui-btn ui-corner-all ui-shadow" data-transition="flip">Hlavná stránka</a>
<a href="#" class="ui-btn ui-corner-all ui-shadow">Môj strojový čas</a>            </div>
            
            <div data-role="header" data-position="fixed">
                <h1>Strojový čas</h1>
                <a href="#navpanel" class="strojak-navigation-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-bars ui-nodisc-icon ui-alt-icon ui-btn-right">Navigácia</a>
            </div>
            
            <div data-role="content">
                
            </div>
            
            <div data-role="footer" data-position="fixed">
                <p style="text-align: center;">&copy; LSTME 2014</p>
            </div>
        </div>
    </body>
</html><?php }} ?>
