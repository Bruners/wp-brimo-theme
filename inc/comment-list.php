<?php

// Comments
function brimo_reply()
{

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'brimo_reply');


// Comments
if (!function_exists('brimo_comment')) :
    /**
     * Template for comments and pingbacks.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     */
    function brimo_comment($comment, $args, $depth)
    {
        // $GLOBALS['comment'] = $comment;

        if ('pingback' == $comment->comment_type || 'trackback' == $comment->comment_type) : ?>

            <li id="comment-<?php comment_ID(); ?>" <?php comment_class('media'); ?>>
                <div class="comment-body">
                    <?php _e('Pingback:', 'brimo'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(__('Rediger', 'brimo'), '<span class="edit-link">', '</span>'); ?>
                </div>

            <?php else : ?>

            <li id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?>>

                <article id="div-comment-<?php comment_ID(); ?>" class="comment-body mt-4 d-flex">
                    
                    <div class="flex-shrink-0 me-3">
                        <?php if (0 != $args['avatar_size']) echo get_avatar($comment, $args['avatar_size'], '', '', array('class' => 'img-thumbnail rounded-circle')); ?>
                    </div>
                    
                    <div class="comment-content">
                        <div class="card">
                            <div class="card-body">

                                <div class="mt-0"><?php printf(__('%s <span class="says d-none">sier:</span>', 'brimo'), sprintf('<h5 class="card-title">%s</h5>', get_comment_author_link())); ?>
                                </div>
                              
                                <div class="small comment-meta card-subtitle entry-meta mb-2 text-muted">
                                    <time datetime="<?php comment_time('c'); ?>">
                                        <?php printf(_x('%1$s kl %2$s', '1: date, 2: time', 'brimo'), get_comment_date(), get_comment_time()); ?>
                                    </time>
                                    <?php edit_comment_link(__('Rediger', 'brimo'), '<span class="edit-link">', '</span>'); ?>
                                </div>
                             

                                <?php if ('0' == $comment->comment_approved) : ?>
                                    <p class="comment-awaiting-moderation"><?php _e('Kommentaren venter på handling fra moderator.', 'brimo'); ?></p>
                                <?php endif; ?>

                                <div class="card-block">
                                    <?php comment_text(); ?>
                                </div><!-- .comment-content -->

                                <?php comment_reply_link(
                                    array_merge(
                                        $args,
                                        array(
                                            'add_below' => 'div-comment',
                                            'depth'     => $depth,
                                            'max_depth' => $args['max_depth'],
                                            'before'     => '<footer class="reply comment-reply">',
                                            'after'     => '</footer><!-- .reply -->'
                                        )
                                    )
                                ); ?>
                            </div> <!-- card-body -->
                        </div><!-- card -->
                    </div><!-- .comment-content -->
         
                </article><!-- .comment-body -->
            </li><!-- #comment -->

    <?php
        endif;
    }
endif; // ends check for brimo_comment()



// h5 Reply Title
add_filter('comment_form_defaults', 'custom_reply_title');
function custom_reply_title($defaults)
{
    $defaults['title_reply_before'] = '<h5 id="reply-title">';
    $defaults['title_reply_after'] = '</h5>';
    return $defaults;
}
// h5 Reply Title End

// Comment Cookie Checkbox
function wp44138_change_comment_form_cookies_consent($fields)
{
    $consent  = empty($commenter['comment_author_email']) ? '' : ' checked="checked"';
    $fields['cookies'] = '<p class="comment-form-cookies-consent custom-control form-check mb-3">' .
        '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" class="form-check-input"' . $consent . ' />' .
        '<label for="wp-comment-cookies-consent" class="form-check-label">' . __('Lagre navn, epost og nettside til neste gang jeg kommenterer.', 'brimo') . '</label>' .
        '</p>';
    return $fields;
}
add_filter('comment_form_default_fields', 'wp44138_change_comment_form_cookies_consent');
// Comment Cookie Checkbox End

// filter for get_comment_author_link
function brimo_get_comment_author_link( $content ) {
    $extra_classes = 'text-decoration-none';
    $html = preg_replace( '/url/', 'url ' . $extra_classes, $content );
    $html = str_replace("</a>", "</a> <span class='badge bg-info small'>Ekstern link</small>", $content);

    return $html;
}

add_filter( 'get_comment_author_link', 'brimo_get_comment_author_link', 99 );
