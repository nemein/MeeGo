<?php
  $nap = new midcom_helper_nav();
  $node_id = $nap->get_current_node();

  $nodes = Array();
  while ($node_id != -1) {
    array_unshift($nodes, $node_id);
    $node_id = $nap->get_node_uplink($node_id);
    if ($node_id == false)
    {
      break;
    }
  }

  $section = '';
  if (count($nodes) > 1) {
    $section = $nap->get_node($nodes[1]);    
  }

  $node_id = $nap->get_current_node();
  if ( $nap->get_node_uplink($node_id) > -1 ) {
    $node = $nap->get_node($node_id);
    $_MIDCOM->componentloader->load('fi.protie.navigation');    
    $navi = new fi_protie_navigation($node_id);
    $navi->follow_all = true;
    $navi->list_leaves = true;
    $navi->skip_levels = 1;
    $navi->list_levels = 3; 
    echo '<div class="navi_sub">' . "\n";
    echo '<h2 class="title">' . $section[1] . '</h2>';
    echo '<div class="separator"></div>';
    $navi->draw();
    echo '</div>' . "\n";
  }
?>

