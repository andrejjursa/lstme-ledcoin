<?php /* Smarty version Smarty-3.1.17, created on 2014-07-27 00:28:50
         compiled from "application\views\web\controllers\products\batch_stock_addition.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1407853d38c802719c4-79933579%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'def33bcb92bbab25548ae42b5e04437361f9b25c' => 
    array (
      0 => 'application\\views\\web\\controllers\\products\\batch_stock_addition.tpl',
      1 => 1406377733,
      2 => 'file',
    ),
    'da973a66f1b8150ce141d2f611ea06a8b729feb5' => 
    array (
      0 => 'application\\views\\web\\layouts\\admin.tpl',
      1 => 1406413697,
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
    'f8b6f27dd549b8a1acb497802261a0d41c3d6c60' => 
    array (
      0 => 'application\\views\\web\\forms\\input.tpl',
      1 => 1406138202,
      2 => 'file',
    ),
    'fb5b02a2d15ae3070ede93210e298d924797af0c' => 
    array (
      0 => 'application\\views\\web\\forms\\select.tpl',
      1 => 1406138228,
      2 => 'file',
    ),
    '2d8b3126ec8e5f5d1c2fc754f122b0241b19346d' => 
    array (
      0 => 'application\\views\\web\\forms\\flipswitch.tpl',
      1 => 1406138232,
      2 => 'file',
    ),
    '9179e7c0e492941a789c54249bbb7f1e5a7cc6ee' => 
    array (
      0 => 'application\\views\\web\\partials\\form.tpl',
      1 => 1406283693,
      2 => 'file',
    ),
    'd6e2cedd3cb1b56eb26745753243a1acf2548024' => 
    array (
      0 => 'application\\views\\web\\partials\\logoutDialog.tpl',
      1 => 1406045507,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1407853d38c802719c4-79933579',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_53d38c805611b9_86807666',
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
<?php if ($_valid && !is_callable('content_53d38c805611b9_86807666')) {function content_53d38c805611b9_86807666($_smarty_tpl) {?><!DOCTYPE html><?php $_smarty_tpl->tpl_vars['app_version'] = new Smarty_variable($_smarty_tpl->tpl_vars['this']->value->config->item('app_version'), null, 0);?>
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
        <div data-role="page" id="strojak-main-page" data-theme="d">
            <div data-role="panel" id="navpanel" data-position="right" data-position-fixed="true" data-display="overlay" data-swipe-close="false">
                <?php /*  Call merged included template "web/partials/navpanel.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('web/partials/navpanel.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '1407853d38c802719c4-79933579');
content_53d42ba2542967_54321098($_smarty_tpl);
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
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('web/partials/flashmessages.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '1407853d38c802719c4-79933579');
content_53d42ba2596830_29515047($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "web/partials/flashmessages.tpl" */?>
                
    <form action="<?php echo site_url('products/do_batch_stock_addition');?>
" method="post" data-ajax="false">
    <?php /*  Call merged included template "web/partials/form.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('web/partials/form.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('form'=>$_smarty_tpl->tpl_vars['form']->value), 0, '1407853d38c802719c4-79933579');
content_53d42ba25ea6f7_24034450($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "web/partials/form.tpl" */?>
    <button type="submit" class="ui-shadow ui-btn ui-corner-all">Hromadne pridať</button>
    </form>

            </div>
            
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                <p style="text-align: center;">&copy; LSTME 2014</p>
            </div>
            
            <?php /*  Call merged included template "web/partials/logoutDialog.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('web/partials/logoutDialog.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '1407853d38c802719c4-79933579');
content_53d42ba278e0d0_24920389($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "web/partials/logoutDialog.tpl" */?>
        </div>
    </body>
</html><?php }} ?>
<?php /* Smarty version Smarty-3.1.17, created on 2014-07-27 00:28:50
         compiled from "application\views\web\partials\navpanel.tpl" */ ?>
<?php if ($_valid && !is_callable('content_53d42ba2542967_54321098')) {function content_53d42ba2542967_54321098($_smarty_tpl) {?><div class="ui-panel-inner">
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
<?php /* Smarty version Smarty-3.1.17, created on 2014-07-27 00:28:50
         compiled from "application\views\web\partials\flashmessages.tpl" */ ?>
<?php if ($_valid && !is_callable('content_53d42ba2596830_29515047')) {function content_53d42ba2596830_29515047($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['flash_messages'] = new Smarty_variable(get_flash_messages(), null, 0);?>
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
<?php /* Smarty version Smarty-3.1.17, created on 2014-07-27 00:28:50
         compiled from "application\views\web\partials\form.tpl" */ ?>
<?php if ($_valid && !is_callable('content_53d42ba25ea6f7_24034450')) {function content_53d42ba25ea6f7_24034450($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['form']->value['fields'])&&isset($_smarty_tpl->tpl_vars['form']->value['arangement'])&&is_array($_smarty_tpl->tpl_vars['form']->value['fields'])&&is_array($_smarty_tpl->tpl_vars['form']->value['arangement'])) {?>
<?php  $_smarty_tpl->tpl_vars['index'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['index']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['form']->value['arangement']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['index']->key => $_smarty_tpl->tpl_vars['index']->value) {
$_smarty_tpl->tpl_vars['index']->_loop = true;
?>
    <?php $_smarty_tpl->tpl_vars['form_element'] = new Smarty_variable(0, null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['form']->value['fields'][$_smarty_tpl->tpl_vars['index']->value])&&is_array($_smarty_tpl->tpl_vars['form']->value['fields'][$_smarty_tpl->tpl_vars['index']->value])) {?><?php $_smarty_tpl->tpl_vars['form_element'] = new Smarty_variable($_smarty_tpl->tpl_vars['form']->value['fields'][$_smarty_tpl->tpl_vars['index']->value], null, 0);?><?php }?>
    <?php if ($_smarty_tpl->tpl_vars['form_element']->value!=0) {?>
        <?php if ($_smarty_tpl->tpl_vars['form_element']->value['type']=='text_input') {?>
            <?php /*  Call merged included template "web/forms/input.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('web/forms/input.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('form_element'=>$_smarty_tpl->tpl_vars['form_element']->value,'form_source'=>$_smarty_tpl->tpl_vars['source']->value), 0, '1407853d38c802719c4-79933579');
content_53d42ba262b486_57544870($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "web/forms/input.tpl" */?>
        <?php } elseif ($_smarty_tpl->tpl_vars['form_element']->value['type']=='password_input') {?>
            <?php /*  Call merged included template "web/forms/input.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('web/forms/input.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('form_element'=>$_smarty_tpl->tpl_vars['form_element']->value,'form_source'=>$_smarty_tpl->tpl_vars['source']->value), 0, '1407853d38c802719c4-79933579');
content_53d42ba262b486_57544870($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "web/forms/input.tpl" */?>
        <?php } elseif ($_smarty_tpl->tpl_vars['form_element']->value['type']=='select') {?>
            <?php /*  Call merged included template "web/forms/select.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('web/forms/select.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('form_element'=>$_smarty_tpl->tpl_vars['form_element']->value,'form_source'=>$_smarty_tpl->tpl_vars['source']->value), 0, '1407853d38c802719c4-79933579');
content_53d42ba26b49d1_80135955($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "web/forms/select.tpl" */?>
        <?php } elseif ($_smarty_tpl->tpl_vars['form_element']->value['type']=='flipswitch') {?>
            <?php /*  Call merged included template "web/forms/flipswitch.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('web/forms/flipswitch.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('form_element'=>$_smarty_tpl->tpl_vars['form_element']->value,'form_source'=>$_smarty_tpl->tpl_vars['source']->value), 0, '1407853d38c802719c4-79933579');
content_53d42ba271b9c5_01025642($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "web/forms/flipswitch.tpl" */?>
        <?php }?>
    <?php } else { ?>
        <p>Chyba, nedá da nájsť index <?php echo $_smarty_tpl->tpl_vars['index']->value;?>
.</p>
    <?php }?>
<?php } ?>
<?php }?><?php }} ?>
<?php /* Smarty version Smarty-3.1.17, created on 2014-07-27 00:28:50
         compiled from "application\views\web\forms\input.tpl" */ ?>
<?php if ($_valid && !is_callable('content_53d42ba262b486_57544870')) {function content_53d42ba262b486_57544870($_smarty_tpl) {?><?php if (!is_callable('smarty_function_form_value')) include 'C:\\xampp\\htdocs\\lstme_strojak\\application\\third_party\\Smarty\\plugins\\function.form_value.php';
?><div class="ui-field-contain">
    <label <?php if ($_smarty_tpl->tpl_vars['form_element']->value['id']) {?>for="<?php echo $_smarty_tpl->tpl_vars['form_element']->value['id'];?>
"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['form_element']->value['label'])===null||$tmp==='' ? 'Textový vstup' : $tmp);?>
:</label>
    <input type="<?php if ($_smarty_tpl->tpl_vars['form_element']->value['type']=='text_input') {?>text<?php } elseif ($_smarty_tpl->tpl_vars['form_element']->value['type']=='password_input') {?>password<?php }?>" name="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['form_element']->value['name'])===null||$tmp==='' ? 'unknown_name' : $tmp);?>
" <?php if ($_smarty_tpl->tpl_vars['form_element']->value['id']) {?>id="<?php echo $_smarty_tpl->tpl_vars['form_element']->value['id'];?>
"<?php }?> value="<?php ob_start();?><?php echo smarty_function_form_value(array('default'=>(($tmp = @$_smarty_tpl->tpl_vars['form_element']->value['default'])===null||$tmp==='' ? '' : $tmp),'source'=>(($tmp = @$_smarty_tpl->tpl_vars['form_source']->value)===null||$tmp==='' ? '' : $tmp),'name'=>(($tmp = @$_smarty_tpl->tpl_vars['form_element']->value['name'])===null||$tmp==='' ? '' : $tmp),'property'=>(($tmp = @$_smarty_tpl->tpl_vars['form_element']->value['object_property'])===null||$tmp==='' ? '' : $tmp)),$_smarty_tpl);?>
<?php echo htmlspecialchars(ob_get_clean(), ENT_QUOTES, 'UTF-8', true)?>"<?php if ($_smarty_tpl->tpl_vars['form_element']->value['placeholder']) {?> placeholder="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['form_element']->value['placeholder'], ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>
           <?php if (form_error($_smarty_tpl->tpl_vars['form_element']->value['name'])!='') {?>data-theme="b"<?php }?> />    
</div>
<?php if ($_smarty_tpl->tpl_vars['form_element']->value['hint']) {?><p><em><?php echo $_smarty_tpl->tpl_vars['form_element']->value['hint'];?>
</em></p><?php }?>
<?php if ($_smarty_tpl->tpl_vars['form_element']->value['name']) {?><?php echo form_error($_smarty_tpl->tpl_vars['form_element']->value['name'],'<div class="ui-bar ui-bar-b ui-corner-all">','</div>');?>
<?php }?><?php }} ?>
<?php /* Smarty version Smarty-3.1.17, created on 2014-07-27 00:28:50
         compiled from "application\views\web\forms\select.tpl" */ ?>
<?php if ($_valid && !is_callable('content_53d42ba26b49d1_80135955')) {function content_53d42ba26b49d1_80135955($_smarty_tpl) {?><?php if (!is_callable('smarty_function_form_value')) include 'C:\\xampp\\htdocs\\lstme_strojak\\application\\third_party\\Smarty\\plugins\\function.form_value.php';
if (!is_callable('smarty_function_html_options')) include 'C:\\xampp\\htdocs\\lstme_strojak\\application\\third_party\\Smarty\\plugins\\function.html_options.php';
?><div class="ui-field-contain">
    <label <?php if ($_smarty_tpl->tpl_vars['form_element']->value['id']) {?>for="<?php echo $_smarty_tpl->tpl_vars['form_element']->value['id'];?>
"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['form_element']->value['label'])===null||$tmp==='' ? 'Textový vstup' : $tmp);?>
:</label>
    <select name="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['form_element']->value['name'])===null||$tmp==='' ? 'unknown_name' : $tmp);?>
" <?php if ($_smarty_tpl->tpl_vars['form_element']->value['id']) {?>id="<?php echo $_smarty_tpl->tpl_vars['form_element']->value['id'];?>
"<?php }?> <?php if (form_error($_smarty_tpl->tpl_vars['form_element']->value['name'])!='') {?>data-theme="b"<?php }?>>
        <?php ob_start();?><?php echo smarty_function_form_value(array('default'=>(($tmp = @$_smarty_tpl->tpl_vars['form_element']->value['default'])===null||$tmp==='' ? '' : $tmp),'source'=>(($tmp = @$_smarty_tpl->tpl_vars['form_source']->value)===null||$tmp==='' ? '' : $tmp),'name'=>(($tmp = @$_smarty_tpl->tpl_vars['form_element']->value['name'])===null||$tmp==='' ? '' : $tmp),'property'=>(($tmp = @$_smarty_tpl->tpl_vars['form_element']->value['object_property'])===null||$tmp==='' ? '' : $tmp)),$_smarty_tpl);?>
<?php $_tmp1=ob_get_clean();?><?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['form_element']->value['values'],'selected'=>$_tmp1),$_smarty_tpl);?>

    </select>
</div>
<?php if ($_smarty_tpl->tpl_vars['form_element']->value['hint']) {?><p><em><?php echo $_smarty_tpl->tpl_vars['form_element']->value['hint'];?>
</em></p><?php }?>
<?php if ($_smarty_tpl->tpl_vars['form_element']->value['name']) {?><?php echo form_error($_smarty_tpl->tpl_vars['form_element']->value['name'],'<div class="ui-bar ui-bar-b ui-corner-all">','</div>');?>
<?php }?><?php }} ?>
<?php /* Smarty version Smarty-3.1.17, created on 2014-07-27 00:28:50
         compiled from "application\views\web\forms\flipswitch.tpl" */ ?>
<?php if ($_valid && !is_callable('content_53d42ba271b9c5_01025642')) {function content_53d42ba271b9c5_01025642($_smarty_tpl) {?><?php if (!is_callable('smarty_function_form_value')) include 'C:\\xampp\\htdocs\\lstme_strojak\\application\\third_party\\Smarty\\plugins\\function.form_value.php';
if (!is_callable('smarty_function_html_options')) include 'C:\\xampp\\htdocs\\lstme_strojak\\application\\third_party\\Smarty\\plugins\\function.html_options.php';
?><div class="ui-field-contain">
    <label <?php if ($_smarty_tpl->tpl_vars['form_element']->value['id']) {?>for="<?php echo $_smarty_tpl->tpl_vars['form_element']->value['id'];?>
"<?php }?>><?php echo (($tmp = @$_smarty_tpl->tpl_vars['form_element']->value['label'])===null||$tmp==='' ? 'Textový vstup' : $tmp);?>
:</label>
    <select name="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['form_element']->value['name'])===null||$tmp==='' ? 'unknown_name' : $tmp);?>
" <?php if ($_smarty_tpl->tpl_vars['form_element']->value['id']) {?>id="<?php echo $_smarty_tpl->tpl_vars['form_element']->value['id'];?>
"<?php }?> data-role="slider" <?php if (form_error($_smarty_tpl->tpl_vars['form_element']->value['name'])!='') {?>data-theme="b"<?php }?>>
        <?php $_smarty_tpl->tpl_vars['values'] = new Smarty_variable(array($_smarty_tpl->tpl_vars['form_element']->value['value_off']=>$_smarty_tpl->tpl_vars['form_element']->value['text_off'],$_smarty_tpl->tpl_vars['form_element']->value['value_on']=>$_smarty_tpl->tpl_vars['form_element']->value['text_on']), null, 0);?>
        <?php ob_start();?><?php echo smarty_function_form_value(array('default'=>(($tmp = @$_smarty_tpl->tpl_vars['form_element']->value['default'])===null||$tmp==='' ? '' : $tmp),'source'=>(($tmp = @$_smarty_tpl->tpl_vars['form_source']->value)===null||$tmp==='' ? '' : $tmp),'name'=>(($tmp = @$_smarty_tpl->tpl_vars['form_element']->value['name'])===null||$tmp==='' ? '' : $tmp),'property'=>(($tmp = @$_smarty_tpl->tpl_vars['form_element']->value['object_property'])===null||$tmp==='' ? '' : $tmp)),$_smarty_tpl);?>
<?php $_tmp2=ob_get_clean();?><?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['values']->value,'selected'=>$_tmp2),$_smarty_tpl);?>

    </select>
</div>
<?php if ($_smarty_tpl->tpl_vars['form_element']->value['hint']) {?><p><em><?php echo $_smarty_tpl->tpl_vars['form_element']->value['hint'];?>
</em></p><?php }?>
<?php if ($_smarty_tpl->tpl_vars['form_element']->value['name']) {?><?php echo form_error($_smarty_tpl->tpl_vars['form_element']->value['name'],'<div class="ui-bar ui-bar-b ui-corner-all">','</div>');?>
<?php }?><?php }} ?>
<?php /* Smarty version Smarty-3.1.17, created on 2014-07-27 00:28:50
         compiled from "application\views\web\partials\logoutDialog.tpl" */ ?>
<?php if ($_valid && !is_callable('content_53d42ba278e0d0_24920389')) {function content_53d42ba278e0d0_24920389($_smarty_tpl) {?><div data-role="popup" id="logoutDialog" data-overlay-theme="d" data-theme="d" data-dismissible="false" style="max-width:400px;">
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
