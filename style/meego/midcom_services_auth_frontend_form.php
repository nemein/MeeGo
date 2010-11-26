<?php
    // As default redirect logins to SSL port, passing GET parameters through
    $action = "https://{$_SERVER['SERVER_NAME']}{$_SERVER['REQUEST_URI']}";
?>
<form name="midcom_services_auth_frontend_form" method="post" id="midcom_services_auth_frontend_form">
    <label for="username">
        <p><?php echo $_MIDCOM->i18n->get_string('username', 'midcom'); ?></p>
        <input name="username" id="username" class="input" />
    </label>
    <label for="password">
        <p><?php echo $_MIDCOM->i18n->get_string('password', 'midcom'); ?></p>
        <input name="password" id="password" type="password" class="input" />
    </label>
    <br/>
    <br/>
    <input type="submit" name="midcom_services_auth_frontend_form_submit" id="midcom_services_auth_frontend_form_submit" value="<?php echo $_MIDCOM->i18n->get_string('login', 'midcom'); ?>" />
</form>
