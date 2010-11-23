<?php
$article = $data['article'];
$node = $data['node'];


$author_string = '';
if (isset($article->metadata->authors))
{
    $authors = explode('|', $article->metadata->authors);
    foreach ($authors as $author_guid)
    {
        if (empty($author_guid))
        {
            continue;
        }
        $author = new midcom_db_person($author_guid);
        if ($author->id == 1)
        {
            continue;
        }
        $author_string = '<a href="http://news.meego.com/users/'. $author->username .'">'. $author->name . '</a>';
    }
}

$avatar_url = '/images/icons/hackergotchi-notfound.png';
if ($author->guid)
{
    /* grab avatars from gravatar */
    $hash = md5( strtolower( trim($author->email) ) );
    $avatar_url = 'http://www.gravatar.com/avatar/' . $hash . '?default=' . $avatar_url;
}

$node_string = "<a class=\"url\" href=\"{$node[MIDCOM_NAV_FULLURL]}\" rel=\"category\">${node[MIDCOM_NAV_NAME]}</a>";

$date_string = "<abbr class=\"published\" title=\"" . strftime('%Y-%m-%dT%H:%M:%S%z', $data['article']->metadata->published) . "\">" . gmdate('Y-m-d H:i e', $article->metadata->published) . "</abbr>";
?>
<div class="planet-entry">
    <?php
    $media_params = $data['article']->list_parameters('net.nemein.rss:media');
    if (isset($media_params['thumbnail@url']))
    {
        echo "<a href=\"{$article->url}\"><img src=\"{$media_params['thumbnail@url']}\" class=\"picture\" /></a>\n";
    } else {
        echo "<img class=\"picture\" src=\"{$avatar_url}\" />\n";
    }
    ?>

    <div class="author-vcard">

    <h1><a href="&(article.url);" rel="bookmark">&(article.title:h);</a></h1>
    <div class="publish-info">

    <?php
    if (empty($author_string))
    {
        echo sprintf($data['l10n']->get('%s <span>&nbsp;to&nbsp;</span> %s'), $date_string, $node_string);
    }
    else
    {
        echo sprintf($data['l10n']->get('%s <span>&nbsp;to&nbsp;</span> %s <span>&nbsp;by&nbsp;</span> %s'), $date_string, $node_string, $author_string);
    }
    ?>
    <div class="fav">
        <div id="net_nemein_favourites_for_<?php echo $data['article']->guid; ?>" class='net_nemein_favourites <?php echo net_nemein_favourites_admin::get_json_data($data['article']->__mgdschema_class_name__, $data['article']->guid, $GLOBALS['news_favourites_url']);?>'>
            <div class="fav_btn"><span class="favs_count">0</span></div>
            <div class="bury_btn"><span class="bury_count">0</span></div>
            <div class="net_nemein_favourites_clearfix"></div>
        </div>
        <noscript>
        <?php
        net_nemein_favourites_admin::render_add_link($data['article']->__mgdschema_class_name__, $data['article']->guid, $GLOBALS['news_favourites_url']);
        ?>
        </noscript>
    </div><!-- /fav -->
    </div><!-- /publish-info -->
    </div><!-- /author-vcard -->


    <div class="post-content">
        &(article.abstract:h);
    </div>
</div><!-- /planet-entry -->
