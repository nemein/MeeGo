<?php
$article = $data['article'];
$node = $data['node'];
$article->abstract = strip_tags($article->abstract);

$author_string = '';
if (isset($article->metadata->authors))
{
    $authors = explode('|', $article->metadata->authors);
    foreach ($authors as $author_guid)
    {
        $author = new midcom_db_person($author_guid);
        $author_string = $author->name;
    }
}

$node_string = "<a href=\"{$node[MIDCOM_NAV_FULLURL]}\" rel=\"category\">${node[MIDCOM_NAV_NAME]}</a>";

$date_string = "<abbr class=\"published\" title=\"" . strftime('%Y-%m-%dT%H:%M:%S%z', $data['article']->metadata->published) . "\">" . gmdate('Y-m-d H:i e', $article->metadata->published) . "</abbr>";
?>
<div class="hentry">
    <h2 class="entry-title"><a href="&(article.url);" class="url" rel="bookmark">&(article.title:h);</a></h2>

    <p class="entry-summary">&(article.abstract:h);</p>

    <div class="post-info">
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
        <?php
        if (empty($author_string))
        {
            echo sprintf($data['l10n']->get('%s to %s with score %d'), $date_string, $node_string, $data['score']);
        }
        else
        {
            echo sprintf($data['l10n']->get('%s to %s by %s with score %d'), $date_string, $node_string, $author_string, $data['score']);
        }
        ?>
    </div>
</div>