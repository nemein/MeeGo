<?php

$lang = $_MIDCOM->i18n->get_current_language();

$guid = '12b2201a3a6d11df9636c38ce6882b322b32';
switch ($lang) {
  case "en": 
    $guid = '12b2201a3a6d11df9636c38ce6882b322b32';
    break;
  case "hu": 
    $guid = '12b2201a3a6d11df9636c38ce6882b322b32';
    break;
}

$root_topic = new midcom_db_topic($guid);

if ( ! $root_topic || ! $root_topic->guid) 
{
    $root_topic = $_MIDCOM->get_context_data(MIDCOM_CONTEXT_ROOTTOPIC);
}


$nav = new midcom_helper_nav();
$children = $nav->list_child_elements($root_topic->id);

$url_prefix = $_MIDGARD['self'];

$first = 0;
echo '<ul id="main-menu" class="links clearfix">' . "\n";

/* Home section */
if ($_MIDGARD['argc'] == 0) {
  echo '<li class="active-trail active">';
  echo '<a href="/" class="active">' . 'Home' . '</a>';
} else {
  echo '<li>';
  echo '<a href="/">' . 'Home' . '</a>';
}
echo "</li>\n";

foreach ($children as $child) {
  $link = strtolower(substr($child[0], 0, -1));
  if ($_MIDGARD['argc'] > 0 && $_MIDGARD['argv'][0] == $link) {
    echo '<li class="active-trail active"><a href="/'. $child[0] . '" class="active">' . $child[1] . '</a>' . "\n";
  } else {
    echo '<li><a href="/'. $child[0] . '">' . $child[1] . '</a>' . "\n";
  }
  echo "</li>\n";
}
echo "</ul>\n";

?>
