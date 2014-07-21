<?php /* Smarty version Smarty-3.1.17, created on 2014-07-21 21:18:03
         compiled from "application\views\web\controllers\strojak\bufet.tpl" */ ?>
<?php /*%%SmartyHeaderCode:260053cd3fc8527e28-46686392%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '68b8ddcbf63113a99078458605fd49fcec2db16d' => 
    array (
      0 => 'application\\views\\web\\controllers\\strojak\\bufet.tpl',
      1 => 1405964719,
      2 => 'file',
    ),
    'a9a8f65be9e6a754aeb925a8288a98183844b101' => 
    array (
      0 => 'application\\views\\web\\layouts\\standard.tpl',
      1 => 1405967354,
      2 => 'file',
    ),
    '3fbf8869f9133a2dcb36200bfd275fde4aa88b2a' => 
    array (
      0 => 'application\\views\\web\\partials\\navpanel.tpl',
      1 => 1405970266,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '260053cd3fc8527e28-46686392',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_53cd3fc85cfbb1_03843476',
  'variables' => 
  array (
    'this' => 0,
    'title' => 0,
    'app_version' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53cd3fc85cfbb1_03843476')) {function content_53cd3fc85cfbb1_03843476($_smarty_tpl) {?><!DOCTYPE html><?php $_smarty_tpl->tpl_vars['app_version'] = new Smarty_variable($_smarty_tpl->tpl_vars['this']->value->config->item('app_version'), null, 0);?>
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
        <div data-role="page" id="strojak-main-page">
            <div data-role="panel" id="navpanel" data-position="right" data-position-fixed="true" data-display="overlay" data-swipe-close="false">
                <?php /*  Call merged included template "web/partials/navpanel.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('web/partials/navpanel.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '260053cd3fc8527e28-46686392');
content_53cd676b5ea6f0_81627597($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "web/partials/navpanel.tpl" */?>
            </div>
            
            <div data-role="header" data-position="fixed">
                <h1>Strojový čas<?php if ($_smarty_tpl->tpl_vars['title']->value) {?> / <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
<?php }?></h1>
                <a href="#navpanel" class="strojak-navigation-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-bars ui-nodisc-icon ui-alt-icon ui-btn-right">Navigácia</a>
            </div>
            
            <div data-role="content">
                
    <div class="ui-body ui-body-a ui-corner-all">
        <h3>Zoznam tovaru v bufete</h3>
        <table data-role="table" data-mode="reflow" class="ui-responsive">
            <thead>
                <tr>
                    <th data-priority="persist">Názov</th>
                    <th data-priority="1">Cena</th>
                    <th data-priority="2">Množstvo skladom</th>
                    <th data-priority="2">Predaných kusov</th>
                </tr>
            </thead>
            <tbody>
                <?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
?>
                <tr>
                    <td><?php echo $_smarty_tpl->tpl_vars['product']->value->title;?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['product']->value->price;?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['product']->value->plus_quantity-$_smarty_tpl->tpl_vars['product']->value->minus_quantity;?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['product']->value->minus_quantity;?>
</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

            </div>
            
            <div data-role="footer" data-position="fixed">
                <p style="text-align: center;">&copy; LSTME 2014</p>
            </div>
        </div>
    </body>
</html><?php }} ?>
<?php /* Smarty version Smarty-3.1.17, created on 2014-07-21 21:18:03
         compiled from "application\views\web\partials\navpanel.tpl" */ ?>
<?php if ($_valid && !is_callable('content_53cd676b5ea6f0_81627597')) {function content_53cd676b5ea6f0_81627597($_smarty_tpl) {?><div class="ui-panel-inner">
<?php if (auth_is_authentificated()) {?>
    <p><strong>Používateľ:</strong> <?php echo auth_get_name();?>
</p>
<?php }?>
    <h3>Navigácia</h3>
    <ul data-role="listview" data-inset="true">
        <li><a href="<?php echo site_url('/');?>
" class="ui-btn ui-btn-a ui-shadow" data-ajax="false">Účastníci</a></li>
        <li><a href="<?php echo site_url('strojak/bufet');?>
" class="ui-btn ui-btn-a ui-shadow"data-ajax="false">Bufet</a></li>
        <?php if (auth_is_authentificated()) {?>
            <li><a href="<?php echo site_url('user/logout');?>
" class="ui-btn ui-btn-b ui-shadow" data-ajax="false">Odhlásiť sa</a></li>
        <?php }?>
    </ul>
        
<?php if (!auth_is_authentificated()) {?>
    <form action="<?php echo site_url('user/login');?>
" method="post" id="login-form" data-ajax="false">
        <h3>Prihlásenie</h3>
        <label for="login-login">Prihlasovacie meno:</label>
        <input type="text" name="login[login]" id="login-login" value="" data-clear-btn="true" data-mini="true" />
        <label for="login-password">Heslo:</label>
        <input type="password" name="login[password]" id="login-password" value="" data-clear-btn="true" data-mini="true" />
        <input type="submit" value="Prihlásiť sa" class="ui-btn ui-shadow ui-corner-all ui-btn-b ui-mini" />
        <input type="hidden" name="return_url" value="<?php echo current_url();?>
" />
    </form>
<?php }?>    
        
<?php if (auth_is_admin()) {?>
    <h3>Administrácia</h3>
    <ul data-role="listview" data-inset="true">
        <li><a href="<?php echo site_url('persons');?>
" class="ui-btn ui-btn-c ui-shadow" data-ajax="false">Ľudia</a></li>
        <li><a href="#" class="ui-btn ui-btn-c ui-shadow" data-ajax="false">Skupiny</a></li>
        <li><a href="#" class="ui-btn ui-btn-c ui-shadow" data-ajax="false">Zamestnania</a></li>
        <li><a href="#" class="ui-btn ui-btn-c ui-shadow" data-ajax="false">Bufet</a></li>
        <li><a href="#" class="ui-btn ui-btn-c ui-shadow" data-ajax="false">Strojový čas</a></li>
    </ul>
<?php }?>
</div><?php }} ?>
