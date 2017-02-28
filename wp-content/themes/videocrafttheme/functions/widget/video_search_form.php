<?php
add_action('widgets_init', 'video_search');

function video_search() {
    return register_widget('video_category_search');
}

class video_category_search extends WP_Widget {

    /** constructor */
    function video_category_search() {
        parent::__construct('video_category_search', $name = 'Video Search');
    }

    /**
     * This is the Widget
     * */
    function widget($args, $instance) {
        global $post;
        extract($args);
        // Widget options
        $title = apply_filters('widget_title', $instance['title']); // Title		
        ?>
        <form role="search" method="get" class="searchform" action="<?php echo home_url('/'); ?>">
            <div>
                <input type="text" onfocus="if (this.value == '<?php echo $title; ?>') {
                            this.value = '';
                        }" onblur="if (this.value == '') {
                                    this.value = '<?php echo $title; ?>';
                                }"  value="<?php echo $title; ?>" name="s" id="s" />
                <input type="submit" id="searchsubmit" value="" />
            </div>
            <input type="hidden" name="post_type" value="video_listing"/>
            <input type="hidden" name="taxonomy1" value="video_cat"/>
            <input type="hidden" name="taxonomy2" value="video_tag"/>
        </form>
        <?php
    }

    /** Widget control update */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    /**
     * Widget settings
     * */
    function form($instance) {
        // instance exist? if not set defaults
        if ($instance) {
            $title = $instance['title'];
        } else {
            //These are our defaults
            $title = '';
        }
        // The widget form 
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __('Title:', 'videocraft'); ?></label>
            <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" class="widefat" />
        </p>
        <?php
    }

}

// class video_category_search
?>