<?php /* Smarty version Smarty-3.1.17, created on 2014-07-21 18:10:18
         compiled from "application\views\web\layouts\standard.tpl" */ ?>
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
  'function' => 
  array (
  ),
  'cache_lifetime' => 3600,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_53cd320fa4fc55_25363172',
  'variables' => 
  array (
    'this' => 0,
    'app_version' => 0,
  ),
  'has_nocache_code' => true,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53cd320fa4fc55_25363172')) {function content_53cd320fa4fc55_25363172($_smarty_tpl) {?><!DOCTYPE html><?php $_smarty_tpl->tpl_vars['app_version'] = new Smarty_variable($_smarty_tpl->tpl_vars['this']->value->config->item('app_version'), null, 0);?>
<html lang="sk">
    <head>
        <title></title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/themes/lstme.min.css?strojak_version=".((string)$_smarty_tpl->tpl_vars['app_version']->value));?>
" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/themes/jquery.mobile.icons.min.css?strojak_version=".((string)$_smarty_tpl->tpl_vars['app_version']->value));?>
" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/jquery.mobile.structure-1.4.3.min.css?strojak_version=".((string)$_smarty_tpl->tpl_vars['app_version']->value));?>
}" />
        <script type="text/javascript" src="<?php echo base_url("assets/jquery-1.11.1.min.js?strojak_version=".((string)$_smarty_tpl->tpl_vars['app_version']->value));?>
"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/jquery.mobile-1.4.3.min.js?strojak_version=".((string)$_smarty_tpl->tpl_vars['app_version']->value));?>
"></script>
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
                <?php /*  Call merged included template "web/partials/navpanel.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('web/partials/navpanel.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '211553cd320fa0b1b4-02746589');
content_53cd3b6ac9b3b1_04328662($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "web/partials/navpanel.tpl" */?>
            </div>
            
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
<?php /* Smarty version Smarty-3.1.17, created on 2014-07-21 18:10:18
         compiled from "application\views\web\partials\navpanel.tpl" */ ?>
<?php if ($_valid && !is_callable('content_53cd3b6ac9b3b1_04328662')) {function content_53cd3b6ac9b3b1_04328662($_smarty_tpl) {?><a href="<?php echo '/*%%SmartyNocache:211553cd320fa0b1b4-02746589%%*/<?php echo site_url(\'/\');?>
/*/%%SmartyNocache:211553cd320fa0b1b4-02746589%%*/';?>
" class="ui-btn ui-corner-all ui-shadow" data-transition="flip">Hlavná stránka</a>
<a href="#" class="ui-btn ui-corner-all ui-shadow">Môj strojový čas</a><?php }} ?>
