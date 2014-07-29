<?php /* Smarty version Smarty-3.1.17, created on 2014-07-29 10:46:00
         compiled from "application\views\web\controllers\persons\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2549553cd67311d1640-44249875%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '658b0474042077230f1713a17a7d47770186db9f' => 
    array (
      0 => 'application\\views\\web\\controllers\\persons\\index.tpl',
      1 => 1406622469,
      2 => 'file',
    ),
    'da973a66f1b8150ce141d2f611ea06a8b729feb5' => 
    array (
      0 => 'application\\views\\web\\layouts\\admin.tpl',
      1 => 1406622469,
      2 => 'file',
    ),
    '3fbf8869f9133a2dcb36200bfd275fde4aa88b2a' => 
    array (
      0 => 'application\\views\\web\\partials\\navpanel.tpl',
      1 => 1406622469,
      2 => 'file',
    ),
    'f55371eff71ae32ec6531cdb4f5413d25646fdda' => 
    array (
      0 => 'application\\views\\web\\partials\\flashmessages.tpl',
      1 => 1406622469,
      2 => 'file',
    ),
    'd6e2cedd3cb1b56eb26745753243a1acf2548024' => 
    array (
      0 => 'application\\views\\web\\partials\\logoutDialog.tpl',
      1 => 1406622469,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2549553cd67311d1640-44249875',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_53cd67312aea52_93919570',
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
<?php if ($_valid && !is_callable('content_53cd67312aea52_93919570')) {function content_53cd67312aea52_93919570($_smarty_tpl) {?><!DOCTYPE html><?php $_smarty_tpl->tpl_vars['app_version'] = new Smarty_variable($_smarty_tpl->tpl_vars['this']->value->config->item('app_version'), null, 0);?>
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
        
<script type="text/javascript">
$(document).ready(function(){
    make_gridtable_active('table.admin_grid_table');
    window.location = '#';
});
</script>

    </head>
    <body>
        <div data-role="page" id="strojak-main-page" data-theme="c">
            <div data-role="panel" id="navpanel" data-position="right" data-position-fixed="true" data-display="overlay" data-swipe-close="false">
                <?php /*  Call merged included template "web/partials/navpanel.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('web/partials/navpanel.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '2549553cd67311d1640-44249875');
content_53d75f49713c58_96698605($_smarty_tpl);
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
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('web/partials/flashmessages.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '2549553cd67311d1640-44249875');
content_53d75f4978fce7_06590762($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "web/partials/flashmessages.tpl" */?>
                
    <div class="ui-body ui-body-c ui-corner-all">
        <?php if ($_smarty_tpl->tpl_vars['persons']->value->exists()) {?>
        <table data-role="table" data-mode="reflow" class="admin_grid_table ui-responsive"
               data-gridtable-operations="edit:Upraviť,delete:Vymazať"
               data-gridtable-operation-edit-url="<?php echo site_url('persons/edit_person/--ID--');?>
"
               data-gridtable-operation-delete-prompt="true"
               data-gridtable-operation-delete-prompt-title="Vymazať osobu?"
               data-gridtable-operation-delete-prompt-text="Naozaj chcete vymazať osobu --NAME-- (--LOGIN--)?"
               data-gridtable-operation-delete-prompt-cancel="Nie, nechcem"
               data-gridtable-operation-delete-prompt-ok="Áno, chcem"
               data-gridtable-operation-delete-prompt-ok-url="<?php echo site_url('persons/delete_person/--ID--');?>
"
        >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Meno</th>
                    <th>Login</th>
                    <th>Skupina</th>
                    <th>Prihlasovanie</th>
                    <th>Administrátor</th>
                </tr>
            </thead>
            <tbody>
                <?php  $_smarty_tpl->tpl_vars['person'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['person']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['persons']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['person']->key => $_smarty_tpl->tpl_vars['person']->value) {
$_smarty_tpl->tpl_vars['person']->_loop = true;
?>
                <tr data-gridtable-unique="person_<?php echo intval($_smarty_tpl->tpl_vars['person']->value->id);?>
" data-gridtable-id="<?php echo intval($_smarty_tpl->tpl_vars['person']->value->id);?>
" data-gridtable-name="<?php echo addslashes(htmlspecialchars($_smarty_tpl->tpl_vars['person']->value->name, ENT_QUOTES, 'UTF-8', true));?>
 <?php echo addslashes(htmlspecialchars($_smarty_tpl->tpl_vars['person']->value->surname, ENT_QUOTES, 'UTF-8', true));?>
" data-gridtable-login="<?php echo addslashes(htmlspecialchars($_smarty_tpl->tpl_vars['person']->value->login, ENT_QUOTES, 'UTF-8', true));?>
">
                    <td><?php echo intval($_smarty_tpl->tpl_vars['person']->value->id);?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['person']->value->name;?>
 <?php echo $_smarty_tpl->tpl_vars['person']->value->surname;?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['person']->value->login;?>
</td>
                    <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['person']->value->group_title)===null||$tmp==='' ? '<strong>---</strong>' : $tmp);?>
</td>
                    <td><?php if ($_smarty_tpl->tpl_vars['person']->value->enabled) {?>povolené<?php } else { ?>zakázané<?php }?></td>
                    <td><?php if ($_smarty_tpl->tpl_vars['person']->value->admin) {?>áno<?php } else { ?>nie<?php }?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } else { ?>
            Momentálne v systéme neexistujú žiadne osoby.
        <?php }?>
    </div>

            </div>
            
            <div data-role="footer" data-position="fixed" data-tap-toggle="false">
                <p style="text-align: center;">&copy; LSTME 2014</p>
            </div>
            
            <?php /*  Call merged included template "web/partials/logoutDialog.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('web/partials/logoutDialog.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '2549553cd67311d1640-44249875');
content_53d75f49b6a757_37976623($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "web/partials/logoutDialog.tpl" */?>
        </div>
    </body>
</html><?php }} ?>
<?php /* Smarty version Smarty-3.1.17, created on 2014-07-29 10:46:01
         compiled from "application\views\web\partials\navpanel.tpl" */ ?>
<?php if ($_valid && !is_callable('content_53d75f49713c58_96698605')) {function content_53d75f49713c58_96698605($_smarty_tpl) {?><div class="ui-panel-inner">
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
        <li><a href="<?php echo site_url('operations');?>
" class="ui-btn ui-btn-c ui-shadow" data-ajax="false">Strojový čas</a></li>
    </ul>
<?php }?>
</div><?php }} ?>
<?php /* Smarty version Smarty-3.1.17, created on 2014-07-29 10:46:01
         compiled from "application\views\web\partials\flashmessages.tpl" */ ?>
<?php if ($_valid && !is_callable('content_53d75f4978fce7_06590762')) {function content_53d75f4978fce7_06590762($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['flash_messages'] = new Smarty_variable(get_flash_messages(), null, 0);?>
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
<?php /* Smarty version Smarty-3.1.17, created on 2014-07-29 10:46:01
         compiled from "application\views\web\partials\logoutDialog.tpl" */ ?>
<?php if ($_valid && !is_callable('content_53d75f49b6a757_37976623')) {function content_53d75f49b6a757_37976623($_smarty_tpl) {?><div data-role="popup" id="logoutDialog" data-overlay-theme="d" data-theme="d" data-dismissible="false" style="max-width:400px;">
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
