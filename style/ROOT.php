<?php
  $topic = $_MIDCOM->get_context_data(MIDCOM_CONTEXT_CONTENTTOPIC);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="keywords" content="midgard,meego,maemo" />
    <meta name="description" content="Midgard SocialNews a'la MeeGo" />
    <meta name="robots" content="index, follow"/>
    <link rel="stylesheet" type="text/css" media="screen" href="/meego.css"/>
    <link rel="shortcut icon" href="http://meego.com/sites/all/themes/meego/favicon.ico" type="image/x-icon" />
    <?php
      $_MIDCOM->print_head_elements(); 
    ?>
    <?php
      $_MIDCOM->componentloader->load_graceful('net.nemein.favourites');
      if ($_MIDCOM->auth->user) {
        net_nemein_favourites_admin::get_ajax_headers('{force_ssl: false}');
      }
      else {
        net_nemein_favourites_admin::get_ajax_headers('{force_ssl: false}');
      }
    ?>  
    <link rel="stylesheet" type="text/css" media="screen" href="/favourites.css"/>
    <link rel="stylesheet" type="text/css" media="screen" href="/news.css"/>
    <title><(title)> - <?php echo $topic->extra; ?></title>
  </head>
  <body>
    <!-- page -->
    <div id="page-wrapper">
      <div id="page">
        <div id="drupal_header">
          <div class="section clearfix">
            <div id="name-and-slogan">
              <div id="site-name"><strong> <a href="/" title="Home" rel="home"><span>MeeGo</span></a> </strong></div>
            </div>
            <div id="search-box">
              <form action="search.php"  accept-charset="UTF-8" method="post" id="search-theme-form">
                <div>
                  <div id="search" class="container-inline">
                    <div class="form-item" id="query-wrapper">
                      <input type="text" name="query" id="query" size="15" title="Enter the terms you wish to search for." class="form-text" value="Search" onfocus="if (this.value == 'Search') this.value = '';" onblur="if(this.value == '') this.value='Search';" />
                    </div>
                    <input type="submit" name="op" id="edit-submit" value="Go"  class="form-submit" />
                  </div>
                </div>
              </form>
            </div>
            <(account-menu)>
          </div>
        </div>
        <div id="main-wrapper">
          <div id="main" class="clearfix with-navigation">
            <div id="drupal_nav">
              <div class="section clearfix">
                <(navi-top)>
                <(breadcrumb)>
              </div>
            </div>
            <(navi-sub)>
            <div id="drupal_content" class="column">
              <div class="section"> <br/>
              <?php
                $_MIDCOM->content(); 
              ?>
              </div>
            </div>
          </div>
        </div>
        <!-- footer -->
        <div id="drupal_footer">
          <div class="section clearfix">
            <div class="footer-top clearfix">
              <div class="region region-footer">
                <div id="block-menu_block-2" class="block block-menu_block region-odd odd region-count-1 count-3 block-">
                  <div class="content">
                    <div class="menu-name-primary-links parent-mlid-0 menu-level-1">
                      <ul class="drupal_menu">
                        <li class="leaf first menu-mlid-709"><a href="/" title="">Home</a></li>
                        <li class="leaf menu-mlid-710 has-children"><a href="/downloads" title="Downloads">Downloads</a></li>
                        <li class="leaf menu-mlid-801"><a href="/developers" title="Developers">Developers</a></li>
                        <li class="leaf menu-mlid-983 has-children"><a href="/projects" title="Projects">Projects</a></li>
                        <li class="leaf menu-mlid-985 has-children"><a href="/garage" title="Garage">Garage</a></li>
                        <li class="leaf menu-mlid-715 has-children"><a href="/community" title="Community">Community</a></li>
                        <li class="leaf last menu-mlid-728 has-children"><a href="/about" title="About">About</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <!-- /.block -->
                <div id="block-menu_block-3" class="block block-menu_block region-even even region-count-2 count-4 block-">
                  <div class="content">
                    <div class="menu-name-primary-links parent-mlid-738 menu-level-1">
                      <ul class="drupal_menu">
                        <li class="leaf first menu-mlid-813"><a href="/devices/connected-tv" title="Connected TV">Connected TV</a></li>
                        <li class="leaf menu-mlid-805"><a href="/devices/handheld" title="Handheld">Handheld</a></li>
                        <li class="leaf menu-mlid-812"><a href="/devices/in-vehicle" title="In-Vehicle">In-Vehicle</a></li>
                        <li class="leaf menu-mlid-814"><a href="/devices/media-phone" title="Media phone">Media phone</a></li>
                        <li class="leaf last menu-mlid-804"><a href="/devices/netbook" title="Netbook">Netbook</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <!-- /.block -->
                <div id="block-menu-menu-footerextras" class="block block-menu region-odd odd region-count-3 count-5 block-">
                  <div class="content">
                    <ul class="drupal_menu">
                      <li class="leaf first"><a href="/contact" title="">Contact</a></li>
                      <li class="leaf"><a href="/about/privacy-policy" title="">Privacy Policy</a></li>
                      <li class="leaf last"><a href="/about/terms-service" title="">Terms of Service</a></li>
                    </ul>
                  </div>
                </div>
                <!-- /.block -->
              </div>
              <!-- /.region -->
              <div class="drupal_sponsor clearfix"> <a href="http://linuxfoundation.org" title="Linux Foundation"><img src="http://meego.com/sites/all/themes/meego/images/linux_foundation_color.png" alt="Linux Foundation" title="" width="168" height="57" /></a><br />
              </div>
            </div>
            <div id="drupal_footer-message" class="drupal_footer-message clearfix"> Linux is a registered trademark of Linus Torvalds. <br />
              * Other names and brands may be claimed as the property of others.<br />
            </div>
          </div>
        </div>
        <!-- /footer -->
      </div>
    </div>
    <!-- /page -->
    <?php 
    $_MIDCOM->uimessages->show(); 
    $_MIDCOM->toolbars->show(); 
    ?>
  </body>
</html>

