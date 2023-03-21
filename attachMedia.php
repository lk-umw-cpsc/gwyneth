<?php $eventID = 1;
    require_once('database/dbEvents.php');
    ini_set("display_errors",1);
    error_reporting(E_ALL);
    // this lovely code will be moved into event.php when nous serons prêts
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once('include/input-validation.php');
        $args = sanitize($_POST);
        if (isset($_POST['attach-post-media-submit'])) {
            $required = [
                'url', 'description', 'format', 'id'
            ];
            if (!wereRequiredFieldsSubmitted($args, $required)) {
                echo "dude, args missing";
                die();
            }
            $type = 'post';
            $format = $args['format'];
            $url = $args['url'];
            if ($format == 'video') {
                $url = str_ireplace('watch?v=', 'embed/', $url);
            }
            $eid = $args['id'];
            $description = $args['description'];
            if (!valueConstrainedTo($format, ['link', 'video', 'picture'])) {
                echo "dude, bad format";
                die();
            }
            echo "ADD $format $type $url to $eid";
            attach_post_event_media($eid, $url, $format, $description);
        }
    }
?>
<ul>
<?php 
    foreach (get_post_event_media($eventID) as $media) {
        echo '<li>';
        if ($media['format'] == 'link') {
            echo '<a href="' . $media['url'] . '">' . $media['description'] . '</a>';
        } else if ($media['format'] == 'picture') {
            echo '<span>' . $media['description'] . '</span><br><img style="max-width: 30vw" src="' . $media['url'] . '" alt="' . $media['description'] . '">';
        } else {
            echo '<span>' . $media['description'] . '</span><br><iframe width="560" height="315" src="' . $media['url'] .'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
        }
        echo '</li>';
    }
?>
</ul>
<form method="post" name="attach-post-media" class="hidden">
    <label>Attach Post-Event Media</label>
    <label for="url">URL</label>
    <input type="text" id="url" name="url" required>
    <label for="description">Description</label>
    <input type="text" id="description" name="description">
    <label for="format">Format</label>
    <select id="format" name="format">
        <option value="link">Link</option>
        <option value="video">YouTube video (embeds video)</option>
        <option value="picture">Picture (embeds picture)</option>
    </select>
    <input type="hidden" name="id" value="<?php echo $eventID ?>">
    <input type="submit" name="attach-post-media-submit" value="Attach">
</form>