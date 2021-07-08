<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package brimo
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area mt-5">

    <?php
    // You can start editing here -- including this comment!
    if ( have_comments() ) : ?>

        <h4 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if ( '1' === $comments_number ) {
                /* translators: %s: post title */
                printf( _x( 'En kommentar på &ldquo;%s&rdquo;', 'comments title', 'brimo' ), get_the_title() );
            } else {
                printf(
                /* translators: 1: number of comments, 2: post title */
                    _nx(
                        '%1$s Kommentar på &ldquo;%2$s&rdquo;',
                        '%1$s Kommentarer på &ldquo;%2$s&rdquo;',
                        $comments_number,
                        'comments title',
                        'brimo'
                    ),
                    number_format_i18n( $comments_number ),
                    get_the_title()
                );
            }
            ?>
        </h4><!-- .comments-title -->


        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
            <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
                <h4 class="visually-hidden"><?php esc_html_e( 'Kommentarnavigasjon', 'brimo' ); ?></h4>
                <div class="nav-links">

                    <div class="nav-previous"><?php previous_comments_link( esc_html__( 'Eldre kommentarer', 'brimo' ) ); ?></div>
                    <div class="nav-next"><?php next_comments_link( esc_html__( 'Nyere kommentarer', 'brimo' ) ); ?></div>

                </div><!-- .nav-links -->
            </nav><!-- #comment-nav-above -->
        <?php endif; // Check for comment navigation. ?>

        <ul class="comment-list list-unstyled">
            <?php
                wp_list_comments( array( 'callback' => 'brimo_comment', 'avatar_size' => 128 ));
            ?>
        </ul><!-- .comment-list -->

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
            <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
                <h4 class="visually-hidden"><?php esc_html_e( 'Kommentarnavigasjon', 'brimo' ); ?></h4>
                <div class="nav-links pagination justify-content-center">

                    <div class="nav-previous page-item"><?php previous_comments_link( esc_html__( 'Eldre kommentarer', 'brimo') ) ; ?></div>
                    <div class="nav-next page-item"><?php next_comments_link( esc_html__( 'Nyere kommentarer', 'brimo' ) ); ?></div>

                </div><!-- .nav-links -->
            </nav><!-- #comment-nav-below -->
            <?php
        endif; // Check for comment navigation.

    endif; // Check for have_comments().



    // If comments are closed and there are comments, let's leave a little note, shall we?
    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

        <p class="no-comments"><?php esc_html_e( 'Kommentarer er stengt.', 'brimo' ); ?></p>
        <?php
    endif; ?>

    <?php
        /* 
         * Documentation: https://developer.wordpress.org/reference/functions/comment_form/
        */
     comment_form( $args = array(
        'id_submit'         => 'commentsubmit',
        'comment_field' =>  '<p><textarea placeholder="' . __('Start skriving...', 'brimo') . '" id="comment" class="form-control" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
        'fields' => apply_filters(
            'comment_form_default_fields',
            array(
                'author' =>'<p class="comment-form-author">' . '<input id="author" class="form-control" placeholder="' . __('Navn*', 'brimo') . '" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req = '' . ' />' . '</p>',
                'email'  => '<p class="comment-form-email">' . '<input class="form-control "id="email" placeholder="' . __('Epost* (vises ikke)', 'brimo') . '" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $aria_req = '' . ' />'  . '</p>',
                'url'    => '<p class="comment-form-url">' . '<input class="form-control" id="url" name="url" placeholder="' . __('Nettside', 'brimo') . '" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /> ' . '</p>'
            )
        ),
    ));

    ?>

</div><!-- #comments -->