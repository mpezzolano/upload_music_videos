<?php

$arr = get_terms('video_cat');
//print_r($arr);
foreach ($arr as $key) {
    if ($key->name == "middle category") {
        //echo $key->term_id;
        //echo "</br>";
        $a = $key->term_taxonomy_id;
    }
}
global $wpdb, $tab;
$tab = $wpdb->prefix . "term_relationships";
$query = $wpdb->get_results("select object_id from $tab where term_taxonomy_id=$a");
foreach ($query as $row) {
    $a = $row->object_id;
///print_r(get_post_meta($a));
    echo get_the_title($a);
    echo "</br>";
}
echo get_search_query();
?>