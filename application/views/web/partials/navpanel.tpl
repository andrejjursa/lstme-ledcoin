<div class="ui-panel-inner">
{if auth_is_authentificated()}
    <p><strong>Používateľ:</strong> {auth_get_name()} {auth_get_surname()}</p>
{/if}
    <h3>Navigácia</h3>
    <ul data-role="listview" data-inset="true">
        <li><a href="{'/'|site_url}" class="ui-btn ui-btn-a ui-shadow" data-ajax="false">Účastníci</a></li>
        <li><a href="{'strojak/bufet'|site_url}" class="ui-btn ui-btn-a ui-shadow"data-ajax="false">Bufet</a></li>
        {if auth_is_authentificated()}
            {if !auth_is_admin()}
            <li><a href="{'strojak/my_time'|site_url}" class="ui-btn ui-btn-a ui-shadow" data-ajax="false">Môj strojový čas</a></li>
            {/if}
            <li><a href="#logoutDialog" class="ui-btn ui-btn-b ui-shadow" data-rel="popup" data-position-to="window" data-transition="pop">Odhlásiť sa</a></li>
        {/if}
    </ul>
        
{if !auth_is_authentificated()}
    <form action="{'user/login'|site_url}" method="post" id="login-form" data-ajax="false">
        <h3>Prihlásenie</h3>
        <label for="login-login">Prihlasovacie meno:</label>
        <input type="text" name="login[login]" id="login-login" value="" data-mini="true" data-theme="a" />
        <label for="login-password">Heslo:</label>
        <input type="password" name="login[password]" id="login-password" value="" data-mini="true" data-theme="a" />
        <input type="submit" value="Prihlásiť sa" class="ui-btn ui-shadow ui-corner-all ui-btn-b ui-mini" data-theme="a" />
        <input type="hidden" name="return_url" value="{if $this->router->class neq 'error'}{current_url()}{else}{'/'|site_url}{/if}" />
    </form>
{/if}    
        
{if auth_is_admin()}
    <h3>Administrácia</h3>
    <ul data-role="listview" data-inset="true">
        <li><a href="{'persons'|site_url}" class="ui-btn ui-btn-c ui-shadow" data-ajax="false">Ľudia</a></li>
        <li><a href="{'groups'|site_url}" class="ui-btn ui-btn-c ui-shadow" data-ajax="false">Skupiny</a></li>
        <li><a href="{'workplaces'|site_url}" class="ui-btn ui-btn-c ui-shadow" data-ajax="false">Zamestnania</a></li>
        <li><a href="{'products'|site_url}" class="ui-btn ui-btn-c ui-shadow" data-ajax="false">Bufet</a></li>
        <li><a href="{'services'|site_url}" class="ui-btn ui-btn-c ui-shadow" data-ajax="false">Služby</a></li>
        <li><a href="{'operations'|site_url}" class="ui-btn ui-btn-c ui-shadow" data-ajax="false">Strojový čas</a></li>
    </ul>
{/if}
</div>