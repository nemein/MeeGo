<div id="account-menu" class="links">
              <div class="region region-account-links">
                <div id="block-menu-menu-account-links" class="block block-menu region-odd even region-count-1 count-2 block-">
                  <div class="content">
                    <ul class="drupal_menu">
<?php
if ($_MIDCOM->auth->user) {
  // user is here in case we need it
  $user = $_MIDCOM->auth->user->get_storage();
?>
                      <li class="leaf first"><a href="http://meego.com/user/me">My account</a></li>
                      <li class="leaf last"><a href="/midcom-logout-" title="">Logout</a></li>
<?php
} else {
?>
                      <li class="leaf first"><a href="/midcom-login-">Login</a></li>
                      <li class="leaf last"><a href="http://meego.com/user/register" title="">Register</a></li>
<?php
}
?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>