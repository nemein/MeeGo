<?php
// FIXME: Move this helper elsewhere
if (!function_exists('org_maemo_planet_truncater'))
{
    function org_maemo_planet_truncater(&$content, &$url)
    {
        // Normalize newlines to \n
        $content = preg_replace("/\n\r|\r\n|\r/", "\n", $content);
        //echo "DEBUG-org_maemo_planet_truncater: content<pre>". htmlentities($content) . "</pre>\n";
        static $word_limit = 1000;
        static $allowed_tags = '<p><a><img><b><i><strong><pre><ul><li><br><blockquote><em><h2><h3><h4><h5><h6><hr><code><var><object><embed><ol><abbr><dl><dt><dd><span><video>';
        //static $word_limit = 5;
        // Naive but works
        $words = count(preg_split('/\b/', strip_tags($content)));
        if ($words <= $word_limit)
        {
            echo strip_tags($content,$allowed_tags);
            return;
        }
        // The difficult part starts here

        // In stead of trying parse the HTML tree to get N words while correctly closing all tags we get first paragraph
        $content_matches = array();
        if (preg_match("%((^\s+.*?)|(^.*?))(</p>|(\n\s*){2,}|(<br\s*/?>\s*){2,}|\w+\s*<p>)%ms", $content, $content_matches))
        {
            $first_paragraph =& $content_matches[1];
            $first_paragraph_words = count(preg_split('/\b/', strip_tags($first_paragraph)));
            // Check that our "first paragraph" is of sane size
            if ($first_paragraph_words <= $word_limit)
            {
                $remaining_words = $words - $first_paragraph_words;
                echo strip_tags($first_paragraph,$allowed_tags);
                if ($remaining_words < 1)
                {
                    return;
                }
                echo "<div class='entry-truncated'><a href='{$url}'>Click to read {$remaining_words} more words</a></div>\n";
                return;
            }
        }

        // Fallback, show only "xxx words, click here to read"
        echo "<div class='entry-truncated'><a href='{$url}'>Click to read {$words} words</a></div>\n";
    }
}

$view = $data['datamanager']->get_content_html();
$view_counter = $data['article_counter'];
$article_count = $data['article_count'];
$class_str = '';
if ($view_counter == 0)
{
    $class_str = ' first';
}
elseif ($view_counter == $article_count - 1)
{
    $class_str = ' last';
}

$published = "<abbr class=\"published\" title=\"" . strftime('%Y-%m-%dT%H:%M:%S%z', $data['article']->metadata->published) . "\">" . gmdate('Y-m-d H:i e', $data['article']->metadata->published) . "</abbr>";

$author = null;
if (isset($data['article']->metadata->authors))
{
    $authors = explode('|', $data['article']->metadata->authors);
    foreach ($authors as $author_guid)
    {
        if (empty($author_guid))
        {
            continue;
        }
        $author = new midcom_db_person($author_guid);
        if ($author->guid)
        {
            break;
        }
    }
}

$homepage = "http://news.meego.com/";
if (   $author->username
    && $author->id != 1)
{
    $homepage = "http://meego.com/users/" . $author->username;
}

$avatar_url = 'http://news.meego.com/images/icons/hackergotchi-notfound.png';
if ($author->guid)
{
    /* grab avatars from gravatar */
    $hash = md5( strtolower( trim($author->email) ) );
    $avatar_url = 'http://www.gravatar.com/avatar/' . $hash . '?default=' . $avatar_url;
}

$visible = $author->get_parameter('net.nehmer.account', 'visible_field_list');
$author_name_string = '';
if (   !is_null($visible)
    && $visible != false)
{
    if (strpos($visible, 'firstname') !== false)
    {
        $author_name_string .= $author->firstname;
    }
    if (strpos($visible, 'lastname') !== false)
    {
        $author_name_string .= " {$author->lastname}";
    }
    $author_name_string = trim($author_name_string);
}

if (empty($author_name_string))
{
    $author_name_string = $author->username;
}
?>
<div class="planet-entry hentry counter_&(view_counter); &(class_str);">
    <img class="picture" src="&(avatar_url);" alt="&(author_name_string);" />
        <div class="author-vcard">
            <h1><a href="&(data['view_url']);" rel="bookmark">&(view['title']:h);</a></h1>
            <div class="publish-info">&(published:h); <span style="float: left">&nbsp;by&nbsp;</span>
            <?php
            if ($author->id == 1)
            {
                echo " <a class=\"author\" href=\"{$homepage}\">Unknown author</a>";
            }
            else
            {
            ?>
                <a href="&(homepage);" class="author url fn">&(author_name_string);</a>
            <?php
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
            </div><!-- fav -->

            </div><!-- publish-info -->
        </div><!-- /author-vcard -->



    <div class="post-content">
<?php org_maemo_planet_truncater($view['content'], $data['view_url']); ?>
    </div><!-- post-content -->


        <div class="tags">
                <?php
                $categories = $data['datamanager']->types['categories']->combine_values();
                if (count($categories) > 1)
                {
                    echo "Categories: \n";
                    $cats_shown = 0;
                    foreach ($categories as $category)
                    {
                        $cats_shown++;
                        if (substr($category, 0, 5) == 'feed:')
                        {
                            continue;
                        }
                        $category = htmlspecialchars($category);
                        echo "{$category}";
                        if ($cats_shown < count($categories))
                        {
                            echo ",";
                        }
                        echo " \n";
                    }
                }
                $tags = net_nemein_tag_handler::get_object_tags($data['article']);
                if (count($tags) > 0)
                {
                    echo "<br />Tags: \n";
                    $tags_shown = 0;
                    foreach ($tags as $tag => $url)
                    {
                        $tags_shown++;
                        $tag = htmlspecialchars($tag);
                        echo "<a href=\"{$url}\" rel=\"tag\">{$tag}</a>";
                        if ($tags_shown < count($tags))
                        {
                            echo ",";
                        }
                        echo " \n";
                    }
                }
                ?>
        </div><!-- /tags -->
</div>
