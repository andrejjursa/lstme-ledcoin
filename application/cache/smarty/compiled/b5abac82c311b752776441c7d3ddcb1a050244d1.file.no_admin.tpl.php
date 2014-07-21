<?php /* Smarty version Smarty-3.1.17, created on 2014-07-21 21:08:54
         compiled from "application\views\web\controllers\error\no_admin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2710653cd63c4839b65-71088544%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b5abac82c311b752776441c7d3ddcb1a050244d1' => 
    array (
      0 => 'application\\views\\web\\controllers\\error\\no_admin.tpl',
      1 => 1405969732,
      2 => 'file',
    ),
    '0ad190e36aa4e5dc00b4cf4229eafa3f3f82edea' => 
    array (
      0 => 'application\\views\\web\\layouts\\error.tpl',
      1 => 1405969312,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2710653cd63c4839b65-71088544',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_53cd63c48c6db6_02223253',
  'variables' => 
  array (
    'this' => 0,
    'title' => 0,
    'app_version' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53cd63c48c6db6_02223253')) {function content_53cd63c48c6db6_02223253($_smarty_tpl) {?><!DOCTYPE html><?php $_smarty_tpl->tpl_vars['app_version'] = new Smarty_variable($_smarty_tpl->tpl_vars['this']->value->config->item('app_version'), null, 0);?>
<html lang="sk">
    <head>
        <title>Strojový čas<?php if ($_smarty_tpl->tpl_vars['title']->value) {?>: <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
<?php }?></title>
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
        <div data-role="page" id="strojak-main-page" data-theme="b">
            <div data-role="header" data-position="fixed">
                <h1>Strojový čas<?php if ($_smarty_tpl->tpl_vars['title']->value) {?> / <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
<?php }?></h1>
            </div>
            
            <div data-role="content">
                
<div>
    <div class="ui-bar ui-bar-b">
        <h3>Chyba</h3>
    </div>
    <div class="ui-body ui-body-b">
        <p>Nie si prihlásený alebo nie si administrátor!</p>
        <p>Nie je možné pracovať s požadovaným modulom!</p>
        <p><a href="<?php echo site_url('/');?>
" class="ui-btn ui-icon-forward ui-corner-all ui-shadow ui-btn-icon-left" data-ajax="false">Pokračuj na hlavnú stránku</a></p>
    </div>
</div>

            </div>
            
            <div data-role="footer" data-position="fixed">
                <p style="text-align: center;">&copy; LSTME 2014</p>
            </div>
        </div>
    </body>
</html><?php }} ?>
