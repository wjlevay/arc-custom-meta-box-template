<?php
 
/*
Plugin Name: ARC Custom Meta Boxes
Plugin URI: http://themefoundation.com/
Description: Custom meta boxes for post and page edit screens.
Author: Theme Foundation and W.J. Levay
Version: 1.0
Author URI: http://themefoundation.com/
*/

/*
Use this guide: http://themefoundation.com/wordpress-meta-boxes-guide/
*/

/**********
SUPRESS FEATURED IMAGE META BOX
**********/

/**
 * Adds a meta box to the post editing screen
 */
function prfx_custom_meta() {
    add_meta_box( 'prfx_meta', __( 'Featured Image Display', 'prfx-textdomain' ), 'prfx_meta_callback', 'post', 'side', 'low' );
}
add_action( 'add_meta_boxes', 'prfx_custom_meta' );

/**
 * Outputs the content of the meta box
 */
function prfx_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
    $prfx_stored_meta = get_post_meta( $post->ID );
    ?>
 
        <p>
            <span class="prfx-row-title"><?php _e( 'You can prevent the featured image from displaying on the main News page and on the individual blog post. It will still display on Archive pages and in the sidebar widget.', 'prfx-textdomain' )?></span>
            <div class="prfx-row-content">
                <label for="meta-checkbox">
                    <input type="checkbox" name="meta-checkbox" id="meta-checkbox" value="yes" <?php if ( isset ( $prfx_stored_meta['no_image'] ) ) checked( $prfx_stored_meta['no_image'][0], 'yes' ); ?> />
                    <?php _e( 'Prevent featured image from displaying on certain pages', 'prfx-textdomain' )?>
                </label>
            </div>
        </p>
 
    <?php
}

/**
 * Saves the custom meta input
 */
function prfx_meta_save( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
    // Checks for input and saves
    if( isset( $_POST[ 'meta-checkbox' ] ) ) {
        update_post_meta( $post_id, 'no_image', 'yes' );
    } else {
        delete_post_meta( $post_id, 'no_image', 'yes' );
    }
 
}
add_action( 'save_post', 'prfx_meta_save' );

/**********
FEATURE GALLERY ON GALLERY LANDING PAGE
**********/

/**
 * Adds a meta box to the post editing screen
 */
function prfx_custom_meta_2() {
    add_meta_box( 'prfx_meta_2', __( 'Gallery Page Options', 'prfx-textdomain-2' ), 'prfx_meta_callback_2', 'page', 'side', 'low' );
}
add_action( 'add_meta_boxes', 'prfx_custom_meta_2' );

/**
 * Outputs the content of the meta box
 */
function prfx_meta_callback_2( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'prfx_nonce_2' );
    $prfx_stored_meta = get_post_meta( $post->ID );
    ?>
 
        <p><span class="prfx-row-title"><?php _e( 'If this is a Gallery Page, you can use these settings.', 'prfx-textdomain-2' )?></span>
            <div class="prfx-row-content">
                <label for="meta-checkbox-2">
                    <input type="checkbox" name="meta-checkbox-2" id="meta-checkbox-2" value="yes" <?php if ( isset ( $prfx_stored_meta['featured_gallery'] ) ) checked( $prfx_stored_meta['featured_gallery'][0], 'yes' ); ?> />
                    <?php _e( 'Feature this Gallery Page on the Gallery Landing Page', 'prfx-textdomain-2' )?>
                </label>
            </div>
        </p>
        <p>
            <label for="meta-text" class="prfx-row-title"><?php _e( 'Gallery Short Title', 'prfx-textdomain-2' )?></label>
            <input type="text" name="meta-text" id="meta-text" value="<?php if ( isset ( $prfx_stored_meta['short_title'] ) ) echo $prfx_stored_meta['short_title'][0]; ?>" />
        </p>
 
    <?php
}

/**
 * Saves the custom meta input
 */
function prfx_meta_save_2( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce_2' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce_2' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
    // Checks for input and saves
    if( isset( $_POST[ 'meta-checkbox-2' ] ) ) {
        update_post_meta( $post_id, 'featured_gallery', 'yes' );
    } else {
        delete_post_meta( $post_id, 'featured_gallery', 'yes' );
    }
    if( isset( $_POST[ 'meta-text' ] ) ) {
        update_post_meta( $post_id, 'short_title', sanitize_text_field( $_POST[ 'meta-text' ] ) );
    }
 
}
add_action( 'save_post', 'prfx_meta_save_2' );