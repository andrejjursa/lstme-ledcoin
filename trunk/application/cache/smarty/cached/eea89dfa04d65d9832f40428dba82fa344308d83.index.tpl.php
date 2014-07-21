<?php /*%%SmartyHeaderCode:2190853cd3bcc7ed6b4-85548519%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eea89dfa04d65d9832f40428dba82fa344308d83' => 
    array (
      0 => 'application\\views\\web\\controllers\\strojak\\index.tpl',
      1 => 1405959200,
      2 => 'file',
    ),
    'a9a8f65be9e6a754aeb925a8288a98183844b101' => 
    array (
      0 => 'application\\views\\web\\layouts\\standard.tpl',
      1 => 1405959883,
      2 => 'file',
    ),
    '3fbf8869f9133a2dcb36200bfd275fde4aa88b2a' => 
    array (
      0 => 'application\\views\\web\\partials\\navpanel.tpl',
      1 => 1405960090,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2190853cd3bcc7ed6b4-85548519',
  'cache_lifetime' => 3600,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_53cd3fa249e8e6_97902102',
  'variables' => 
  array (
    'this' => 0,
    'app_version' => 0,
  ),
  'has_nocache_code' => true,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53cd3fa249e8e6_97902102')) {function content_53cd3fa249e8e6_97902102($_smarty_tpl) {?><!DOCTYPE html><html lang="sk">
    <head>
        <title></title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" type="text/css" href="http://strojak.localhost/assets/themes/lstme.min.css?strojak_version=1.0.0" />
        <link rel="stylesheet" type="text/css" href="http://strojak.localhost/assets/themes/jquery.mobile.icons.min.css?strojak_version=1.0.0" />
        <link rel="stylesheet" type="text/css" href="http://strojak.localhost/assets/jquery.mobile.structure-1.4.3.min.css?strojak_version=1.0.0}" />
        <script type="text/javascript" src="http://strojak.localhost/assets/jquery-1.11.1.min.js?strojak_version=1.0.0"></script>
        <script type="text/javascript" src="http://strojak.localhost/assets/jquery.mobile-1.4.3.min.js?strojak_version=1.0.0"></script>
    </head>
    <body>
        <div data-role="page" id="strojak-main-page">
            <div data-role="panel" id="navpanel" data-position="right" data-position-fixed="true" data-display="overlay">
                <ul data-role="listview" data-inset="true">
    <li><a href="<?php echo site_url('/');?>
" class="ui-btn ui-corner-all ui-shadow" data-ajax="false">Účastníci</a></li>
    <li><a href="<?php echo site_url('strojak/bufet');?>
" class="ui-btn ui-corner-all ui-shadow" data-ajax="false">Bufet</a></li>
    <li><a href="#" class="ui-btn ui-corner-all ui-shadow" data-ajax="false">Môj strojový čas</a></li>
</ul>            </div>
            
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
