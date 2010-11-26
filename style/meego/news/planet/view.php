<?php
// Available request keys: article, datamanager, edit_url, delete_url, create_urls
$view = $data['view_article'];

$publish_time = $data['article']->metadata->published;
$published = sprintf($data['l10n']->get('posted on %s.'), strftime('%Y-%m-%d %T %Z', $publish_time));
$permalink = $_MIDCOM->permalinks->create_permalink($data['article']->guid);
$prefix = $_MIDCOM->get_context_data(MIDCOM_CONTEXT_ANCHORPREFIX);
?>

<div class="hentry">
    <div id="net_nemein_favourites_for_<?php echo $data['article']->guid; ?>" class='net_nemein_favourites <?php echo net_nemein_favourites_admin::get_json_data($data['article']->__mgdschema_class_name__, $data['article']->guid, '/news/favorites/');?>'>
        <div class="fav_btn"><span class="favs_count">0</span></div>
        <div class="bury_btn"><span class="bury_count">0</span></div>
        <div class="net_nemein_favourites_clearfix"></div>
    </div>
    <noscript>
    <?php
    net_nemein_favourites_admin::render_add_link($data['article']->__mgdschema_class_name__, $data['article']->guid, $GLOBALS['news_favourites_url']);
    ?>
    </noscript>
    <h1 class="headline">&(view['title']:h);</h1>

    <?php
    if ($data['article']->url)
    {
        echo "<p class=\"permalink\">From <a href=\"{$data['article']->url}\" rel=\"bookmark\">" . substr($data['article']->url, 0, 50) . "</a></p>\n";
        echo "<script language=\"javascript\">\n";
        echo "    window.location.href = '{$data['article']->url}';\n";
        echo "</script>\n";
    }
    ?>
    
    <p class="published">&(published);</p>
    <p class="excerpt">&(view['abstract']:h);</p>

    <div class="content">
        <?php if (array_key_exists('image', $view) && $view['image']) { ?>
            <div style="float: right; padding: 5px;">&(view['image']:h);</div>
        <?php } ?>

        &(view["content"]:h);
    </div>
    
    <p><a href="&(prefix);"><?php $data['l10n_midcom']->show('back'); ?></a></p>
</div>
