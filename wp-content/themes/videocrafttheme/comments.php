<?php
if (comments_open()) :
    ?>
    <div id="commentsbox">
        <?php if (post_password_required()) : ?>
            <p class="nopassword">
                <?php echo PASSWORDPROTECT; ?>
            </p>
        </div>
        <!-- #comments -->
        <?php
        return;
    endif;
    ?>
    <div id="comments">
        <?php if (have_comments()) : ?>  
            <h3 id="comments"> <span> <?php comments_number(__('No Responses', 'videocraft'), __('One Response', 'videocraft'), __('% Responses', 'videocraft')); ?></span></h3>              
            <div class="comment_list">
                <ol class="commentlist">
                    <?php wp_list_comments(array('callback' => 'videocraft_commentslist', 'avatar_size' => 63)); ?>
                </ol>
            </div>
        <?php endif; // end have_comments()   ?>
    </div>  
    <?php if ('open' == $post->comment_status) : ?>
        <div id="respond">
            <div class="post-info">
                <h3 id="comments"> <span>Leave a reply</span></h3>
            </div>
            <div class="comment_form">
                <?php if (get_option('comment_registration') && !$user_ID) : ?>
                    <p class="comment_message"><?php echo YOUMUST; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php echo LOGGEDIN; ?></a> <?php echo POSTCOMMENT; ?></p>
                <?php else : ?>
                    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

                        <p class="commpadd" style="margin: 10px 0 10px 0;"><span class="comments_rating"> <?php videocraft_get_rating(); ?> </span> </p>

                        <?php if ($user_ID) : ?>
                            <p class="comment_message" style="margin-bottom: 10px;"><?php echo LOG_REG; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php echo LOG_OUT; ?></a></p>
                            <p class="clearfix">
                                <textarea name="comment" id="comment" cols="50" rows="7" tabindex="1" placeholder="<?php _e('Leave Your Comment Here', 'videocraft'); ?>"></textarea>
                            </p>

                        <?php else : ?>

                            <p class="clearfix">					
                                <label for="author"><?php _e('Name', 'videocraft'); ?><small> <?php _e('(required)', 'videocraft'); ?></small></label><input type="text" name="author" id="author" tabindex="2" value="" onfocus="if (this.value == 'Your name') {
                                            this.value = '';
                                        }"/>
                            </p>

                            <p class="clearfix">					
                                <label for="email"><?php _e('Email', 'videocraft'); ?><small> <?php _e('(required)', 'videocraft'); ?></small></label><input type="text" name="email" id="email" tabindex="3" value="" />
                            </p>

                            <p class="clearfix">					
                                <label for="url"><?php _e('Website', 'videocraft'); ?></label><input type="text" name="url" id="url" tabindex="4" value=""/>
                            </p>

                            <p class="clearfix">
                                <textarea name="comment" id="comment" cols="50" tabindex="5" rows="7"  placeholder="<?php _e('Leave Your Comment Here', 'videocraft'); ?>"></textarea>
                            </p>
                        <?php endif; ?>
                        <div class="submit">
                            <input name="submit" type="submit" id="submit" tabindex="6" value="<?php _e('Submit Comment', 'videocraft'); ?>" />
                            <p id="cancel-comment-reply">
                                <?php cancel_comment_reply_link() ?>
                            </p>
                        </div>
                        <div>
                            <?php comment_id_fields(); ?>
                        </div>
                    </form>
                <?php endif; // If registration required and not logged in    ?>
            </div>
        <?php endif; // if you delete this the sky will fall on your head    ?>
    </div>
    </div>
<?php endif; // end ! comments_open() ?>
