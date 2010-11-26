<?php
    $_MIDCOM->componentloader->load('fi.protie.navigation');    
    $navi = new fi_protie_navigation();
    $navi->follow_selected = true;
    $navi->list_leaves = true;
    $navi->list_levels = 3; 
    echo '<div class="navi_sub">' . "\n";
    echo '<h2 class="title">Planet MeeGo</h2>';
    echo '<div class="separator"></div>';
    $navi->draw();
    echo '</div>' . "\n";
?>