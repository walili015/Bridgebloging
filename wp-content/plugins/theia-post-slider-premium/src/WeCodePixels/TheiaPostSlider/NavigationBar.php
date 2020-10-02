<?php

/*
 * Copyright 2012-2020, Theia Post Slider, WeCodePixels, https://wecodepixels.com
 */

namespace WeCodePixels\TheiaPostSlider;

class NavigationBar {
	// Get HTML for a navigation bar.
	public static function get_navigation_bar( $options ) {
		global $post;

		$defaults = array(
			'currentSlide' => null,
			'totalSlides'  => null,
			'prevPostId'   => null,
			'nextPostId'   => null,
			'prevPostUrl'  => null,
			'nextPostUrl'  => null,
			'id'           => null,
			'class'        => array(),
			'style'        => null,
			'title'        => null

		);
		$options  = array_merge( $defaults, $options );
		if ( ! is_array( $options['class'] ) ) {
			$options['class'] = array( $options['class'] );
		}

		if ( $options['totalSlides'] == 1 && in_array( Options::get( 'button_behaviour', 'tps_nav' ), array( 'standard', 'loop' ) ) ) {
			return '';
		}

		// Get text
		if ( $options['totalSlides'] == 1 ) {
			$text = '';
		} else {
			$text = Options::get( 'navigation_text' );
			$text = str_replace( '%{currentSlide}', $options['currentSlide'], $text );
			$text = str_replace( '%{totalSlides}', $options['totalSlides'], $text );
		}

		// Get button URLs
		$prev = NavigationBar::get_navigation_barButton( $options, false );
		$next = NavigationBar::get_navigation_barButton( $options, true );

		// Title
		if ( ! $options['title'] ) {
			$options['title'] = '<span class="_helper">' . Options::get( 'helper_text' ) . '</span>';
		}

		// Classes
		$options['class'][] = '_slide_number_' . ( $options['currentSlide'] - 1 );
		if ( $post && PostOptions::get( $post->ID, 'nav_hide_on_first_slide' ) ) {
			$options['class'][] = '_hide_on_first_slide';
		}

		// Final HTML
		$class   = array( 'theiaPostSlider_nav' );
		$class[] = '_' . Options::get( 'nav_horizontal_position' );
		if ( Options::get( 'theme_type' ) == 'font' ) {
			$class[] = 'fontTheme';
		}
		foreach ( $options['class'] as $c ) {
			$class[] = $c;
		}

		$html =
			'<div' . ( $options['id'] !== null ? ' id="' . $options['id'] . '"' : '' ) . ( $options['style'] !== null ? ' style="' . $options['style'] . '"' : '' ) . ' class="' . implode( $class, ' ' ) . '">' .
			'<div class="_buttons">' . $prev . '<span class="_text">' . $text . '</span>' . $next . '</div>' .
			'<div class="_title">' . $options['title'] . '</div>' .
			'</div>';

		return $html;
	}

	/*
	 * Get a button for a navigation bar.
	 * @param direction boolean False = prev; True = next;
	 */
	public static function get_navigation_barButton( $options, $direction ) {
		global $page, $pages;

		$direction_name = $direction ? 'next' : 'prev';
		$url            = Misc::get_post_page_url( $options['currentSlide'] + ( $direction ? 1 : - 1 ) );
		$left_text      = null;
		$right_text     = null;

		// Functionality: Last Slide's Next Goes to the First Slide and vice-versa.
		// Used the URLs directly compared to the previous version.
		if ( ! $url && Options::get( 'button_behaviour', 'tps_nav' ) == 'loop' ) {
			if ( $direction_name == 'next' ) {
				$url = Misc::get_post_page_url( 1 );
			} else {
				$url = Misc::get_post_page_url( count( $pages ) );
			}
		}

		// Check if there isn't another page but there is another post.
		$url_is_another_post = ! $url && $options[ $direction_name . 'PostUrl' ];
		if ( $url_is_another_post && Options::get( 'button_behaviour', 'tps_nav' ) == 'post' ) {
			$url = $options[ $direction_name . 'PostUrl' ];
		}

		// Check what text we should display on the buttons.
		if ( Options::get( 'button_behaviour' ) === 'post' && ( ( $direction == false && $page == 1 ) || ( $direction == true && $page == count( $pages ) ) ) ) {
			$button_text = Options::get( $direction_name . '_text_post' );
		} else {
			$button_text = Options::get( $direction_name . '_text' );
		}

		switch ( Options::get( 'theme_type' ) ) {
			case 'font':
				$direction_name_for_icons = ($direction xor is_rtl()) ? 'next' : 'prev';
				$text  = $direction_name_for_icons == 'next' ? Options::get_font_icon( 'right' ) : Options::get_font_icon( 'left' );
				$width = 0;

				if ( $direction_name == 'next' ) {
					$left_text = $button_text;
				} else {
					$right_text = $button_text;
				}
				break;

			case 'classic':
				$text       = $button_text;
				$left_text  = '';
				$right_text = '';

				if ( $url_is_another_post ) {
					$width = Options::get( 'button_width_post' );
				} else {
					$width = Options::get( 'button_width' );
				}
				break;

			default:
				return '';
		}

		$style = $width == 0 ? '' : 'style="width: ' . $width . 'px"';

//		if(! is_rtl())
		$html_part_1 = '<span class="_1">' . $left_text . '</span><span class="_2" ' . $style . '>';
		$html_part_2 = '</span><span class="_3">' . $right_text . '</span>';

		// HTML
		$html  = $html_part_1 . $text . $html_part_2;
		$class = $url_is_another_post ? ' _another_post' : '';
		if ( $url ) {
			$button = '<a rel="' . $direction_name . '" href="' . esc_url( $url ) . '" class="_button _' . $direction_name . $class . '">' . $html . '</a>';
		} else {
			$button = '<span class="_button _' . $direction_name . $class . ' _disabled">' . $html . '</span>';
		}

		return $button;
	}
}
