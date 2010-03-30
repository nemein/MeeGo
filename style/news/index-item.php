<?php
// Available request keys: datamanager, article, view_url, article_counter
$view = $data['datamanager']->get_content_html();
$article = $data['article'];
$view_counter = $data['article_counter'];
$article_count = $data['article_count'];

$class_str = '';
if ($view_counter == 0)
{
    $class_str = ' first';
}
elseif ($view_counter == ($article_count - 1))
{
    $class_str = ' last';
}

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
        $author_string = '<a href="http://meego.nemein.net/?q=user/'. $author->userid .'">'. $author->name . '</a>';
    }
}

if (empty($author_string))
{
    $published = sprintf($data['l10n']->get('posted on %s.'), "<abbr title=\"" . strftime('%Y-%m-%dT%H:%M:%S%z', $data['article']->metadata->published) . "\">" . gmdate('Y-m-d H:i e', $data['article']->metadata->published) . "</abbr>");
}
else
{
    $published = sprintf($data['l10n']->get('posted on %s by %s.'), "<abbr title=\"" . strftime('%Y-%m-%dT%H:%M:%S%z', $data['article']->metadata->published) . "\">" . gmdate('Y-m-d H:i e', $data['article']->metadata->published) . "</abbr>", $author_string);
}


if (array_key_exists('comments_enable', $data))
{
    $published .= " <a href=\"{$data['view_url']}#net_nehmer_comments_{$data['article']->guid}\">" . sprintf($data['l10n']->get('%s comments'), net_nehmer_comments_comment::count_by_objectguid($data['article']->guid)) . "</a>.";
}    
?>

<div class="hentry counter_&(view_counter); &(class_str);">
    <?php

    $media_params = $data['article']->list_parameters('net.nemein.rss:media');
    if (isset($media_params['thumbnail@url']))
    {
        echo "<a href=\"{$data['view_url']}\"><img src=\"{$media_params['thumbnail@url']}\" class=\"thumbnail\" /></a>\n";
    }
    ?>
    <h2 class="entry-title"><a href="&(data['view_url']);" rel="bookmark"><?php echo $data['article']->title; ?></a> </h2>

        <div id="net_nemein_favourites_for_<?php echo $data['article']->guid; ?>" class='net_nemein_favourites <?php echo net_nemein_favourites_admin::get_json_data($data['article']->__mgdschema_class_name__, $data['article']->guid, '/news/favourites/');?>'>
            <div class="fav_btn"><span class="favs_count">0</span></div>
            <div class="bury_btn"><span class="bury_count">0</span></div>
            <div class="net_nemein_favourites_clearfix"></div>
        </div>
        <noscript>
        <?php
        net_nemein_favourites_admin::render_add_link($data['article']->__mgdschema_class_name__, $data['article']->guid, $GLOBALS['maemo_favourites_url']);
        ?>
        </noscript>

    <?php 
    if (array_key_exists('image', $view) && $view['image']) { 
    ?>
        <div style="float: left; padding: 5px;">&(view['image']:h);</div>
    <?php 
    }
    
    if (isset($view['abstract']))
    {
        ?>
        <p class="entry-summary">&(view['abstract']:h);</p>
        <?php
    }
    
    if (isset($data['index_fulltext']) && $data['index_fulltext'])
    {
        ?>
        <div class="entry-content"">&(view['content']:h);</div>
        <?php
    }

    if (   isset($data['article']->content)
        && strlen($data['article']->content) > 0 )
    {
        ?>
        <div class="entry-content"><?php echo substr(strip_tags($data['article']->content), 0, 340) . "..."; ?>
            <a href="&(data['view_url']);" rel="bookmark">[More]</a>
        </div>
        <?php
    }

    ?>
    <p class="published">&(published:h);</p>
</div>

