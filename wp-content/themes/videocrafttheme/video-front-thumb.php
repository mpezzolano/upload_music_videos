<?php

if (isset($rows->ID) && $rows->ID) {
    $vid = get_post_meta($rows->ID, '_video_url', true);
    $upload_image = get_post_meta($rows->ID, '_meta_image', true);
    if (!empty($vid)) {
        $parts = parse_url($vid);
        $host = $parts['host'];
        if (empty($host)) {
            echo 'Unrecognized host';
        } else {
            $urll = $vid;
            if (strpos($urll, "dailymotion.com")) {
                $dailyid = strtok(basename($urll), '_');
                $dailymotion_pic_url = 'http://www.dailymotion.com/thumbnail/video/' . $dailyid . '.jpg';
                inkthemes_get_image(246, 160, 'dpic', $dailymotion_pic_url);
            }
            if (strpos($urll, "metacafe.com")) {
                if (preg_match("/((http:\/\/)?(www\.)?metacafe\.com)(\/watch\/)(\d+)(.*)/i", $urll, $match)) {
                    $metaid = $match[5];
                    $meta_pic_url = 'http://www.metacafe.com/thumb/' . $metaid . '.jpg';
                    inkthemes_get_image(246, 160, 'mpic', $meta_pic_url);
                }
            }
            if (strpos($urll, "vimeo.com")) {
                $video_id = explode('vimeo.com/', $urll);
                $video_id = $video_id[1];
                $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
                $vimeourl = $hash[0]['thumbnail_large'];
                inkthemes_get_image(246, 160, 'vpic', $vimeourl);
            }
            if (strpos($urll, "youtube.com")) {
                $query_string = parse_url($urll, PHP_URL_QUERY);
                parse_str($query_string, $pieces);
                $yurl = $pieces['v'];
                $y_url = 'http://img.youtube.com/vi/' . $yurl . '/mqdefault.jpg';
                inkthemes_get_image(246, 160, 'ypic', $y_url);
                echo $upload_image;
            }
        }
    }
    if ($upload_image) {
        if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {
            inkthemes_get_thumbnail(90, 60, 'fpic', $upload_image);
        } else {
            inkthemes_get_image(90, 60, 'fpic', $upload_image);
        }
    }
} else {
    $vid = get_post_meta($post->ID, '_video_url', true);

    $upload_image = get_post_meta($post->ID, '_meta_image', true);
    if (!empty($vid)) {
        $parts = parse_url($vid);
        $host = $parts['host'];
        if (empty($host)) {
            echo 'Unrecognized host';
        } else {
            $urll = $vid;
            if (strpos($urll, "dailymotion.com")) {
                $dailyid = strtok(basename($urll), '_');
                $dailymotion_pic_url = 'http://www.dailymotion.com/thumbnail/video/' . $dailyid . '.jpg';
                inkthemes_get_image(246, 160, 'dpic', $dailymotion_pic_url);
            }
            if (strpos($urll, "metacafe.com")) {
                if (preg_match("/((http:\/\/)?(www\.)?metacafe\.com)(\/watch\/)(\d+)(.*)/i", $urll, $match)) {
                    $metaid = $match[5];
                    $meta_pic_url = 'http://www.metacafe.com/thumb/' . $metaid . '.jpg';
                    inkthemes_get_image(246, 160, 'mpic', $meta_pic_url);
                }
            }
            if (strpos($urll, "vimeo.com")) {
                $video_id = explode('vimeo.com/', $urll);
                $video_id = $video_id[1];
                $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
                $vimeourl = $hash[0]['thumbnail_large'];
                inkthemes_get_image(246, 160, 'vpic', $vimeourl);
            }
            if (strpos($urll, "youtube.com")) {
                $query_string = parse_url($urll, PHP_URL_QUERY);
                parse_str($query_string, $pieces);
                $yurl = $pieces['v'];
                $y_url = 'http://img.youtube.com/vi/' . $yurl . '/mqdefault.jpg';
                inkthemes_get_image(246, 160, 'ypic', $y_url);
                echo $upload_image;
            }
        }
    }
    if ($upload_image) {
        if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {
            inkthemes_get_thumbnail(246, 160, 'fpic', $upload_image);
        } else {
            inkthemes_get_image(246, 160, 'fpic', $upload_image);
        }
    }
}
?>