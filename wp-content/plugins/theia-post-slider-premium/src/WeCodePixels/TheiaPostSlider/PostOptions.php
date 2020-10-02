<?php

/*
 * Copyright 2012-2020, Theia Post Slider, WeCodePixels, https://wecodepixels.com
 */

namespace WeCodePixels\TheiaPostSlider;

use WeCodePixels\TheiaPostSlider\Admin\Templates;

class PostOptions {
    public static function staticConstruct() {
        add_action( 'add_meta_boxes', __NAMESPACE__ . '\\PostOptions::add_meta_boxes', 10, 2 );
        add_action( 'save_post', __NAMESPACE__ . '\\PostOptions::save_post' );
    }

    public static function add_meta_boxes( $post_type, $post ) {
        if ( ! in_array( $post_type, Options::get_post_types() ) ) {
            return;
        }

        add_meta_box(
            'tps_options', // id, used as the html id att
            __( 'Theia Post Slider' ), // meta box title
            __NAMESPACE__ . '\\PostOptions::add_meta_boxes_callback', // callback function, spits out the content
            null, // post type or page. This adds to posts only
            'advanced', // context, where on the screen
            'low' // Priority, where should this go in the context
        );
    }

    public static function add_meta_boxes_callback( $post ) {
        $options = self::get_post_options( $post->ID );

        $menu = array(
            'navigation-bar' => 'Navigation Bar',
            'advanced'       => 'Advanced'
        );
        $menu = apply_filters( 'tps_post_options_tabs_menu', $menu );

        ?>
        <div id="theia-post-slider-post-options">
            <div class="nav-tab-wrapper">
                <?php
                foreach ( $menu as $id => $title ) {
                    ?>
                    <a href="#<?php echo $id; ?>" class="nav-tab"><?php echo $title; ?></a>
                    <?php
                }
                ?>
            </div>
            <div class="_tab" id="navigation-bar">
                <table class="form-table">
                    <?php
                    Templates::getVerticalPositionHtml( $options, true );
                    Templates::getHideNavigationBarOnFirstSlideHtml( $options, true );
                    Templates::getContentAboveUnderSliderAndNavigation($options, true);
                    ?>
                </table>
            </div>
            <div class="_tab" id="advanced">
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">
                            <label for="tps_options_enabled">Enable slider:</label>
                        </th>
                        <td>
                            <select id="tps_options_enabled" name="tps_options[enabled]">
                                <?php
                                foreach ( PostOptions::get_enabled_options() as $key => $value ) {
                                    $output = '<option value="' . $key . '"' . ( $key == $options['enabled'] ? ' selected' : '' ) . '>' . $value . '</option>' . "\n";
                                    echo $output;
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <?php Templates::get_slide_loading_mechanism_html( $options, true ); ?>
                    <tr valign="top" class="conditional-ad-options">
                        <th scope="row">
                            <label>
                                <?php Templates::outputAdBehaviorTitle(); ?>
                            </label>
                        </th>
                    </tr>
                    <?php Templates::getAdBehaviorSelect( $options ); ?>
                    <?php Templates::getOptionsAdBehaviorHtml( $options, true ); ?>
                </table>
            </div>
            <?php
            do_action( 'tps_post_options_tabs_content', $post, $options );
            ?>
        </div>
        <script>
            (function ($) {
                var e = $('#theia-post-slider-post-options');

                e.find('> .nav-tab-wrapper > a').click(function () {
                    var clickedTab = $(this);

                    // Add active class.
                    $(this).addClass('nav-tab-active');
                    e.find('> .nav-tab-wrapper > a').each(function () {
                        if (this != clickedTab[0]) {
                            $(this).removeClass('nav-tab-active');
                        }
                    });

                    // Show tab.
                    e.children('._tab').hide();
                    e.children($(this).attr('href')).show();

                    return false;
                });

                e.find('> .nav-tab-wrapper > a').eq(0).click();

                e.find('#tps_select_global_vs_post').change(function () {
                    var selection = $(this).find('option:selected').val();

                    e.find('.conditional-ad-options input').each(function () {
                        if (selection === 'global') {
                            $(this).attr('disabled', 'disabled');
                            $('.conditional-ad-options').css('display', 'none');
                        } else if (selection === 'post') {
                            $(this).removeAttr('disabled');
                            $('.conditional-ad-options').css('display', 'table-row');
                        }
                    });
                })
            })(jQuery);
        </script>
        <?php

        do_action( 'tps_add_meta_boxes_callback', $post, $options );
    }

    public static function save_post( $postId ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
        if ( ! current_user_can( 'edit_page', $postId ) ) {
            return;
        }
        if ( empty( $postId ) ) {
            return;
        }

        $defaults = self::get_post_defaults();
        $options  = array_key_exists( 'tps_options', $_REQUEST ) ? $_REQUEST['tps_options'] : array();
        foreach ( $options as $optionKey => $option ) {
            if ( ! array_key_exists( $optionKey, $defaults ) ) {
                unset( $options[ $optionKey ] );
            } else {
                // Sanitize.
                if ( is_bool( $defaults[ $optionKey ] ) ) {
                    $options[ $optionKey ] = ( $options[ $optionKey ] === true || $options[ $optionKey ] === 'true' ) ? true : false;
                }
            }
        }
        $options = array_merge( $defaults, $options );

        update_post_meta( $postId, 'tps_options', $options );
    }

    public static function get_post_defaults() {
        $defaults = array(
            'enabled'                 => 'global',
            'nav_vertical_position'   => 'global',
            'nav_hide_on_first_slide' => false,
            'slide_loading_mechanism' => 'global',
            'select_global_vs_post' => 'global',
            'refresh_ads' => false,
            'refresh_ads_every_n_slides' => 1,
            'ad_refreshing_mechanism' => 'javascript',
            'content_above_slider' => '',
            'content_under_top_navigation' => '',
            'content_above_bottom_navigation' => '',
            'content_under_slider' => '',
        );
        $defaults = apply_filters( 'tps_get_post_defaults', $defaults );

        return $defaults;
    }

    // Get post options.
    public static function get_post_options( $postId ) {
        $defaults = self::get_post_defaults();
        $options  = get_post_meta( $postId, 'tps_options', true );
        if ( ! is_array( $options ) ) {
            $options = array();
        } else {
            if ( array_key_exists( 'enable', $options ) ) {
                if ( $options['enable'] === true ) {
                    $options['enable'] = 'enabled';
                } elseif ( $options['enable'] === false ) {
                    $options['enable'] = 'disabled';
                }
            }
        }
        $options = array_merge( $defaults, $options );

        return $options;
    }

    // Get value for single/specific option.
    public static function get( $postId, $optionId, $optionGroups = array( 'tps_general', 'tps_nav', 'tps_advanced' ) ) {
        $postOptions = PostOptions::get_post_options( $postId );

        if ( array_key_exists( $optionId, $postOptions ) && $postOptions[ $optionId ] !== 'global' ) {
            $value = $postOptions[ $optionId ];
        } else {
            $value = Options::get( $optionId, $optionGroups );
        }

        return $value;
    }

    // 'Global'-type versus 'post'-type settings for ad behavior.
    public static function getAdBehaviorBasedOnType($postId, $optionId, $optionGroups) {
    	$postOptions = PostOptions::get_post_options( $postId );
    	if ($postOptions['select_global_vs_post'] === 'global') {
    		return Options::get($optionId, $optionGroups);
	    } else {
    		return self::get( $postId,$optionId, $optionGroups );
	    }
    }

    public static function get_enabled_options() {
        $options = array(
            'global'   => 'Use global setting',
            'enabled'  => 'Enabled',
            'disabled' => 'Disabled'
        );

        return $options;
    }

    public static function get_post_option_enabled( $postId ) {
        $postOptions = PostOptions::get_post_options( $postId );
        if ( $postOptions['enabled'] == 'global' ) {
            return Options::get( 'default_activation_behavior' ) == 1;
        }

        return $postOptions['enabled'] == 'enabled';
    }

    public static function get_global_vs_post_ad_select_options() {
        $options = array(
            'global' => 'Use global settings',
            'post'   => 'Use post settings'
        );

        return $options;
    }
}
