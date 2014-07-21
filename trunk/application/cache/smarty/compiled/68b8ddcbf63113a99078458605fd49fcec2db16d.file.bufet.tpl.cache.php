<?php /* Smarty version Smarty-3.1.17, created on 2014-07-21 18:28:14
         compiled from "application\views\web\controllers\strojak\bufet.tpl" */ ?>
<?php /*%%SmartyHeaderCode:440753cd3dbc564eb1-56926917%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '68b8ddcbf63113a99078458605fd49fcec2db16d' => 
    array (
      0 => 'application\\views\\web\\controllers\\strojak\\bufet.tpl',
      1 => 1405959949,
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
  'nocache_hash' => '440753cd3dbc564eb1-56926917',
  'function' => 
  array (
  ),
  'cache_lifetime' => 3600,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_53cd3dbc605238_94566543',
  'variables' => 
  array (
    'this' => 0,
    'app_version' => 0,
  ),
  'has_nocache_code' => true,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53cd3dbc605238_94566543')) {function content_53cd3dbc605238_94566543($_smarty_tpl) {?><!DOCTYPE html><?php $_smarty_tpl->tpl_vars['app_version'] = new Smarty_variable($_smarty_tpl->tpl_vars['this']->value->config->item('app_version'), null, 0);?>
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
    </head>
    <body>
        <div data-role="page" id="strojak-main-page">
            <div data-role="panel" id="navpanel" data-position="right" data-position-fixed="true" data-display="overlay">
                <?php /*  Call merged included template "web/partials/navpanel.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('web/partials/navpanel.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '440753cd3dbc564eb1-56926917');
content_53cd3f9e713fb3_72514812($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "web/partials/navpanel.tpl" */?>
            </div>
            
            <div data-role="header" data-position="fixed">
                <h1>Strojový čas</h1>
                <a href="#navpanel" class="strojak-navigation-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-bars ui-nodisc-icon ui-alt-icon ui-btn-right">Navigácia</a>
            </div>
            
            <div data-role="content">
                
    <?php echo rand('100',1000);?>


            </div>
            
            <div data-role="footer" data-position="fixed">
                <p style="text-align: center;">&copy; LSTME 2014</p>
            </div>
        </div>
    </body>
</html><?php }} ?>
<?php /* Smarty version Smarty-3.1.17, created on 2014-07-21 18:28:14
         compiled from "application\views\web\partials\navpanel.tpl" */ ?>
<?php if ($_valid && !is_callable('content_53cd3f9e713fb3_72514812')) {function content_53cd3f9e713fb3_72514812($_smarty_tpl) {?><ul data-role="listview" data-inset="true">
    <li><a href="<?php echo '/*%%SmartyNocache:440753cd3dbc564eb1-56926917%%*/<?php echo site_url(\'/\');?>
/*/%%SmartyNocache:440753cd3dbc564eb1-56926917%%*/';?>
" class="ui-btn ui-corner-all ui-shadow" data-ajax="false">Účastníci</a></li>
    <li><a href="<?php echo '/*%%SmartyNocache:440753cd3dbc564eb1-56926917%%*/<?php echo site_url(\'strojak/bufet\');?>
/*/%%SmartyNocache:440753cd3dbc564eb1-56926917%%*/';?>
" class="ui-btn ui-corner-all ui-shadow" data-ajax="false">Bufet</a></li>
    <li><a href="#" class="ui-btn ui-corner-all ui-shadow" data-ajax="false">Môj strojový čas</a></li>
</ul><?php }} ?>
