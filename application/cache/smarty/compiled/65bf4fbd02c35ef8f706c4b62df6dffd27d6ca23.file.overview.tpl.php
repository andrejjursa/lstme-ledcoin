<?php /* Smarty version Smarty-3.1.17, created on 2014-07-27 15:07:52
         compiled from "application\views\web\controllers\products\overview.tpl" */ ?>
<?php /*%%SmartyHeaderCode:752153d4f56b7327f2-21895630%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '65bf4fbd02c35ef8f706c4b62df6dffd27d6ca23' => 
    array (
      0 => 'application\\views\\web\\controllers\\products\\overview.tpl',
      1 => 1406466448,
      2 => 'file',
    ),
    'da973a66f1b8150ce141d2f611ea06a8b729feb5' => 
    array (
      0 => 'application\\views\\web\\layouts\\admin.tpl',
      1 => 1406413776,
      2 => 'file',
    ),
    '3fbf8869f9133a2dcb36200bfd275fde4aa88b2a' => 
    array (
      0 => 'application\\views\\web\\partials\\navpanel.tpl',
      1 => 1406379377,
      2 => 'file',
    ),
    'f55371eff71ae32ec6531cdb4f5413d25646fdda' => 
    array (
      0 => 'application\\views\\web\\partials\\flashmessages.tpl',
      1 => 1406046995,
      2 => 'file',
    ),
    '40186ece033bba8551d64d747de1083b009af49f' => 
    array (
      0 => 'application\\views\\web\\partials\\pieces_inflection.tpl',
      1 => 1406300950,
      2 => 'file',
    ),
    '24eafb9773b36e1e89f36d2f4b4ce25a4e25a2ec' => 
    array (
      0 => 'application\\views\\web\\partials\\minutes_inflection.tpl',
      1 => 1406286416,
      2 => 'file',
    ),
    'd6e2cedd3cb1b56eb26745753243a1acf2548024' => 
    array (
      0 => 'application\\views\\web\\partials\\logoutDialog.tpl',
      1 => 1406045507,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '752153d4f56b7327f2-21895630',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_53d4f56b7327f6_73081790',
  'variables' => 
  array (
    'this' => 0,
    'title' => 0,
    'app_version' => 0,
    'back_url' => 0,
    'new_item_url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53d4f56b7327f6_73081790')) {function content_53d4f56b7327f6_73081790($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'C:\\xampp\\htdocs\\lstme_strojak\\application\\third_party\\Smarty\\plugins\\modifier.date_format.php';
?><!DOCTYPE html><?php $_smarty_tpl->tpl_vars['app_version'] = new Smarty_variable($_smarty_tpl->tpl_vars['this']->value->config->item('app_version'), null, 0);?>
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
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/strojak_admin.css?strojak_version=".((string)$_smarty_tpl->tpl_vars['app_version']->value));?>
}" />
        <script type="text/javascript" src="<?php echo base_url("assets/jquery-1.11.1.min.js?strojak_version=".((string)$_smarty_tpl->tpl_vars['app_version']->value));?>
"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/jquery.mobile-1.4.3.min.js?strojak_version=".((string)$_smarty_tpl->tpl_vars['app_version']->value));?>
"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/strojak_admin.js?strojak_version=".((string)$_smarty_tpl->tpl_vars['app_version']->value));?>
"></script>
        
    </head>
    <body>
        <div data-role="page" id="strojak-main-page" data-theme="c">
            <div data-role="panel" id="navpanel" data-position="right" data-position-fixed="true" data-display="overlay" data-swipe-close="false">
                <?php /*  Call merged included template "web/partials/navpanel.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('web/partials/navpanel.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '752153d4f56b7327f2-21895630');
content_53d4f9a828c507_61854521($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "web/partials/navpanel.tpl" */?>
            </div>
            
            <div data-role="header" data-position="fixed" data-tap-toggle="false">
                <h1>Strojový čas<?php if ($_smarty_tpl->tpl_vars['title']->value) {?> / <?php echo $_smarty_tpl->tpl_vars['title']->value;?>
<?php }?></h1>
                <a href="#navpanel" class="strojak-navigation-link ui-btn ui-btn-icon-notext ui-corner-all ui-icon-bars ui-nodisc-icon ui-alt-icon ui-btn-right">Navigácia</a>
                <?php if ($_smarty_tpl->tpl_vars['back_url']->value) {?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['back_url']->value;?>
" data-ajax="false" class="ui-btn ui-btn-icon-notext ui-corner-all ui-icon-back ui-nodisc-icon ui-alt-icon ui-btn-left">Nazad</a>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['new_item_url']->value) {?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['new_item_url']->value;?>
" data-ajax="false" class="ui-btn ui-btn-icon-notext ui-corner-all ui-icon-plus ui-nodisc-icon ui-alt-icon ui-btn-left">Vytvoriť nový</a>
                <?php }?>
            </div>
            
            <div data-role="content">
                <?php /*  Call merged included template "web/partials/flashmessages.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('web/partials/flashmessages.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '752153d4f56b7327f2-21895630');
content_53d4f9a82dc6c9_02070426($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "web/partials/flashmessages.tpl" */?>
                
    <div class="ui-body ui-body-c ui-corner-all">
        <?php if ($_smarty_tpl->tpl_vars['product_quantities']->value->exists()) {?>
        <table data-role="table" data-mode="reflow" class="admin_grid_table ui-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Dátum</th>
                    <th>Typ</th>
                    <th>Počet kusov</th>
                    <th>Účastník</th>
                    <th>Vedúci</th>
                    <th>Zamestnanie</th>
                    <th>Cena za kus</th>
                </tr>
            </thead>
            <tbody>
                <?php  $_smarty_tpl->tpl_vars['quantity'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['quantity']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['product_quantities']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['quantity']->key => $_smarty_tpl->tpl_vars['quantity']->value) {
$_smarty_tpl->tpl_vars['quantity']->_loop = true;
?>
                <tr>
                    <td><?php echo $_smarty_tpl->tpl_vars['quantity']->value->id;?>
</td>
                    <td><?php echo (($tmp = @smarty_modifier_date_format($_smarty_tpl->tpl_vars['quantity']->value->created,'%d. %m. %Y'))===null||$tmp==='' ? 'neznámy' : $tmp);?>
</td>
                    <td><?php if ($_smarty_tpl->tpl_vars['quantity']->value->type=='addition') {?><span class="operation_type_addition_highlight">pridanie</span><?php } else { ?><span class="operation_type_subtraction_highlight">odobratie</span><?php }?></td>
                    <td><?php if ($_smarty_tpl->tpl_vars['quantity']->value->type=='addition') {?>+<?php } else { ?>-<?php }?> <?php /*  Call merged included template "web/partials/pieces_inflection.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('web/partials/pieces_inflection.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('pieces'=>intval($_smarty_tpl->tpl_vars['quantity']->value->quantity)), 0, '752153d4f56b7327f2-21895630');
content_53d4f9a835e1f4_07414927($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "web/partials/pieces_inflection.tpl" */?></td>
                    <?php if ($_smarty_tpl->tpl_vars['quantity']->value->type=='addition') {?>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                    <?php } else { ?>
                        <td><?php echo $_smarty_tpl->tpl_vars['quantity']->value->operation_person_name;?>
 <?php echo $_smarty_tpl->tpl_vars['quantity']->value->operation_person_surname;?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['quantity']->value->operation_admin_name;?>
 <?php echo $_smarty_tpl->tpl_vars['quantity']->value->operation_admin_surname;?>
</td>
                        <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['quantity']->value->operation_workplace_title)===null||$tmp==='' ? '---' : $tmp);?>
</td>
                        <td><?php /*  Call merged included template "web/partials/minutes_inflection.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('web/partials/minutes_inflection.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('minutes'=>intval($_smarty_tpl->tpl_vars['quantity']->value->price)), 0, '752153d4f56b7327f2-21895630');
content_53d4f9a838be52_02837775($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "web/partials/minutes_inflection.tpl" */?></td>
                    <?php }?>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } else { ?>
            Momentálne nie sú k dispozícii žiadne prehľadové informácie k produktu <?php echo $_smarty_tpl->tpl_vars['product']->value->title;?>
.
        <?php }?>
    </div>

            </div>
            
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                <p style="text-align: center;">&copy; LSTME 2014</p>
            </div>
            
            <?php /*  Call merged included template "web/partials/logoutDialog.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('web/partials/logoutDialog.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '752153d4f56b7327f2-21895630');
content_53d4f9a83aa6a9_25455011($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "web/partials/logoutDialog.tpl" */?>
        </div>
    </body>
</html><?php }} ?>
<?php /* Smarty version Smarty-3.1.17, created on 2014-07-27 15:07:52
         compiled from "application\views\web\partials\navpanel.tpl" */ ?>
<?php if ($_valid && !is_callable('content_53d4f9a828c507_61854521')) {function content_53d4f9a828c507_61854521($_smarty_tpl) {?><div class="ui-panel-inner">
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
            <li><a href="#logoutDialog" class="ui-btn ui-btn-b ui-shadow" data-rel="popup" data-position-to="window" data-transition="pop">Odhlásiť sa</a></li>
        <?php }?>
    </ul>
        
<?php if (!auth_is_authentificated()) {?>
    <form action="<?php echo site_url('user/login');?>
" method="post" id="login-form" data-ajax="false">
        <h3>Prihlásenie</h3>
        <label for="login-login">Prihlasovacie meno:</label>
        <input type="text" name="login[login]" id="login-login" value="" data-mini="true" data-theme="a" />
        <label for="login-password">Heslo:</label>
        <input type="password" name="login[password]" id="login-password" value="" data-mini="true" data-theme="a" />
        <input type="submit" value="Prihlásiť sa" class="ui-btn ui-shadow ui-corner-all ui-btn-b ui-mini" data-theme="a" />
        <input type="hidden" name="return_url" value="<?php if ($_smarty_tpl->tpl_vars['this']->value->router->class!='error') {?><?php echo current_url();?>
<?php } else { ?><?php echo site_url('/');?>
<?php }?>" />
    </form>
<?php }?>    
        
<?php if (auth_is_admin()) {?>
    <h3>Administrácia</h3>
    <ul data-role="listview" data-inset="true">
        <li><a href="<?php echo site_url('persons');?>
" class="ui-btn ui-btn-c ui-shadow" data-ajax="false">Ľudia</a></li>
        <li><a href="<?php echo site_url('groups');?>
" class="ui-btn ui-btn-c ui-shadow" data-ajax="false">Skupiny</a></li>
        <li><a href="<?php echo site_url('workplaces');?>
" class="ui-btn ui-btn-c ui-shadow" data-ajax="false">Zamestnania</a></li>
        <li><a href="<?php echo site_url('products');?>
" class="ui-btn ui-btn-c ui-shadow" data-ajax="false">Bufet</a></li>
        <li><a href="<?php echo site_url('services');?>
" class="ui-btn ui-btn-c ui-shadow" data-ajax="false">Služby</a></li>
        <li><a href="#" class="ui-btn ui-btn-c ui-shadow" data-ajax="false">Strojový čas</a></li>
    </ul>
<?php }?>
</div><?php }} ?>
<?php /* Smarty version Smarty-3.1.17, created on 2014-07-27 15:07:52
         compiled from "application\views\web\partials\flashmessages.tpl" */ ?>
<?php if ($_valid && !is_callable('content_53d4f9a82dc6c9_02070426')) {function content_53d4f9a82dc6c9_02070426($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['flash_messages'] = new Smarty_variable(get_flash_messages(), null, 0);?>
<?php if (is_array($_smarty_tpl->tpl_vars['flash_messages']->value)&&count($_smarty_tpl->tpl_vars['flash_messages']->value)>0) {?>
    <?php  $_smarty_tpl->tpl_vars['flash_message'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['flash_message']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['flash_messages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['flash_message']->key => $_smarty_tpl->tpl_vars['flash_message']->value) {
$_smarty_tpl->tpl_vars['flash_message']->_loop = true;
?>
        <?php if (is_object($_smarty_tpl->tpl_vars['flash_message']->value)&&trim($_smarty_tpl->tpl_vars['flash_message']->value->text)!=''&&trim($_smarty_tpl->tpl_vars['flash_message']->value->type)!='') {?>
            <?php if ($_smarty_tpl->tpl_vars['flash_message']->value->type=='success') {?>
                <div class="ui-body ui-body-c ui-corner-all" style="margin-bottom: 1em;">
                    <p><?php echo $_smarty_tpl->tpl_vars['flash_message']->value->text;?>
</p>
                </div>
            <?php } elseif ($_smarty_tpl->tpl_vars['flash_message']->value->type=='error') {?>
                <div class="ui-body ui-body-b ui-corner-all" style="margin-bottom: 1em;">
                    <p><?php echo $_smarty_tpl->tpl_vars['flash_message']->value->text;?>
</p>
                </div>
            <?php } else { ?>
                <div class="ui-body ui-body-a ui-corner-all" style="margin-bottom: 1em;">
                    <p><?php echo $_smarty_tpl->tpl_vars['flash_message']->value->text;?>
</p>
                </div>
            <?php }?>
        <?php }?>
    <?php } ?>
<?php }?><?php }} ?>
<?php /* Smarty version Smarty-3.1.17, created on 2014-07-27 15:07:52
         compiled from "application\views\web\partials\pieces_inflection.tpl" */ ?>
<?php if ($_valid && !is_callable('content_53d4f9a835e1f4_07414927')) {function content_53d4f9a835e1f4_07414927($_smarty_tpl) {?><?php echo $_smarty_tpl->tpl_vars['pieces']->value;?>
 <?php echo get_inflection_by_numbers($_smarty_tpl->tpl_vars['pieces']->value,'kusov','kus','kusy','kusy','kusy','kusov');?>
<?php }} ?>
<?php /* Smarty version Smarty-3.1.17, created on 2014-07-27 15:07:52
         compiled from "application\views\web\partials\minutes_inflection.tpl" */ ?>
<?php if ($_valid && !is_callable('content_53d4f9a838be52_02837775')) {function content_53d4f9a838be52_02837775($_smarty_tpl) {?><?php echo $_smarty_tpl->tpl_vars['minutes']->value;?>
 <?php echo get_inflection_by_numbers($_smarty_tpl->tpl_vars['minutes']->value,'minút','minúta','minúty','minúty','minúty','minút');?>
<?php }} ?>
<?php /* Smarty version Smarty-3.1.17, created on 2014-07-27 15:07:52
         compiled from "application\views\web\partials\logoutDialog.tpl" */ ?>
<?php if ($_valid && !is_callable('content_53d4f9a83aa6a9_25455011')) {function content_53d4f9a83aa6a9_25455011($_smarty_tpl) {?><div data-role="popup" id="logoutDialog" data-overlay-theme="d" data-theme="d" data-dismissible="false" style="max-width:400px;">
    <div data-role="header" data-theme="d">
    <h1>Odhlásiť sa?</h1>
    </div>
    <div role="main" class="ui-content">
        <h3 class="ui-title">Naozaj sa chceš odhlásiť?</h3>
        <?php if (auth_is_admin()) {?>
        <p>Neuložené zmeny budú stratené.</p>
        <?php }?>
        <a href="<?php echo site_url('user/logout');?>
" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" data-ajax="false">Áno</a>
        <a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-c" data-rel="back" data-transition="flip">Nie</a>
    </div>
</div><?php }} ?>