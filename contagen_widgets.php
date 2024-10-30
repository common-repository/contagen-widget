<?php
/**
 * Plugin Name: ContaGen Widget
 * Plugin URI: http://wordpresstech.in/contagen/
 * Description: This plugin allows you to add contact information in a widget and display it with or without icons.
 * Version:  1.0.0
 * Author: Pravin Walokar
 * Author URI: https://profiles.wordpress.org/pravin-walokar/
 * License:  GPL2
 *Text Domain: cgwgt
 *  Copyright 2015 GIN_AUTHOR_NAME  (email : walokarpravin@gmail.com)
 *
 *	This program is free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License, version 2, as
 *	published by the Free Software Foundation.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program; if not, write to the Free Software
 *	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

if(!defined('ABSPATH')) exit;      // Prevent Direct Browsing


class cgwgt_contagen_widgets extends  WP_Widget{



	// Controller
	function __construct() {
		$widget_ops = array('classname' => 'cgwgt_wrap', 'description' => __('ContaGen Widget description', 'cgwgt'));
		$control_ops = array('width' => 400, 'height' => 300);
		parent::WP_Widget(false, $name = __('ContaGen Widget', 'cgwgt'), $widget_ops, $control_ops );
	}

// widget form creation
	function form($instance) {

// Check values
		if( $instance) {
			$cgwgt_title = esc_attr($instance['cgwgt_title']);
			$cgwgt_phone = esc_attr($instance['cgwgt_phone']);
			$cgwgt_email = esc_attr($instance['cgwgt_email']);
			$cgwgt_address= esc_textarea($instance['cgwgt_address']);
			$cgwgt_checkbox= esc_attr($instance['cgwgt_checkbox']);
			$cgwgt_select= esc_attr($instance['cgwgt_select']);
		} else {
			$cgwgt_title = '';
			$cgwgt_phone = '';
			$cgwgt_email = '';
			$cgwgt_address = '';
			$cgwgt_checkbox = '';
			$cgwgt_select ='';

		}
		?>

		<p>
			<label for="<?php echo $this->get_field_id('cgwgt_title'); ?>"><?php _e('Widget Title', 'cgwgt'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('cgwgt_title'); ?>" name="<?php echo $this->get_field_name('cgwgt_title'); ?>" type="text" value="<?php echo $cgwgt_title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('cgwgt_address'); ?>"><?php _e('Address:', 'cgwgt'); ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('cgwgt_address'); ?>" name="<?php echo $this->get_field_name('cgwgt_address'); ?>"><?php echo $cgwgt_address; ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('cgwgt_phone'); ?>"><?php _e('Phone:', 'cgwgt'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('cgwgt_phone'); ?>" name="<?php echo $this->get_field_name('cgwgt_phone'); ?>" type="text" value="<?php echo $cgwgt_phone; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('cgwgt_email'); ?>"><?php _e('Email:', 'cgwgt'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('cgwgt_email'); ?>" name="<?php echo $this->get_field_name('cgwgt_email'); ?>" type="text" value="<?php echo $cgwgt_email; ?>" />
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('cgwgt_checkbox'); ?>" name="<?php echo $this->get_field_name('cgwgt_checkbox'); ?>" type="checkbox" value="1" <?php checked( '1', $cgwgt_checkbox ); ?> />
			<label for="<?php echo $this->get_field_id('cgwgt_checkbox'); ?>"><?php _e('Use Icons', 'cgwgt'); ?></label>
		</p>


		<p>
			<label for="<?php echo $this->get_field_id('cgwgt_select'); ?>"><?php _e('Alignment', 'cgwgt'); ?></label>
			<select name="<?php echo $this->get_field_name('cgwgt_select'); ?>" id="<?php echo $this->get_field_id('cgwgt_select'); ?>" class="widefat">
				<?php
				$options = array('Left', 'Center', 'Right');
				foreach ($options as $option) {
					echo '<option value="' . $option . '" id="' . $option . '"', $cgwgt_select == $option ? ' selected="selected"' : '', '>', $option, '</option>';
				}
				?>
			</select>
		</p>

	<?php
	}

// Sanitize and return the safe form values
public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['cgwgt_title'] = ( !empty( $new_instance['cgwgt_title'] ) ) ? strip_tags( $new_instance['cgwgt_title'] ) : '';
    $instance['cgwgt_phone'] = ( !empty( $new_instance['cgwgt_phone'] ) ) ? strip_tags( $new_instance['cgwgt_phone'] ) : '';
    $instance['cgwgt_email'] = ( !empty( $new_instance['cgwgt_email'] ) ) ? strip_tags( $new_instance['cgwgt_email'] ) : '';
    if ( current_user_can('unfiltered_html') ) {
        $instance['cgwgt_address'] =  $new_instance['cgwgt_address'];
    } else {
        $instance['cgwgt_address'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['cgwgt_address']) ) );
    }
    $instance['cgwgt_checkbox'] = ( !empty( $new_instance['cgwgt_checkbox'] ) ) ? strip_tags( $new_instance['cgwgt_checkbox'] ) : '';
    $instance['cgwgt_select'] = ( !empty( $new_instance['cgwgt_select'] ) ) ? strip_tags( $new_instance['cgwgt_select'] ) : '';
    return $instance;
}

	// display widget
	function widget($args, $instance) {
		extract( $args );
		// these are the widget options
		$cgwgt_title = apply_filters('widget_title', $instance['cgwgt_title']);
		$cgwgt_phone = $instance['cgwgt_phone'];
		$cgwgt_email = $instance['cgwgt_email'];
		$cgwgt_address = $instance['cgwgt_address'];
		//$cgwgt_address = apply_filters( 'widget_textarea', empty( $instance['$cgwgt_address'] ) ? '' : $instance['$cgwgt_address'], $instance );

		$cgwgt_checkbox = $instance['cgwgt_checkbox'];
		$cgwgt_select = $instance['cgwgt_select'];
		// check icons setting 
		if( $cgwgt_checkbox AND $cgwgt_checkbox == '1' )
		{
			$is_icons = ' has_icons';
			$has_icons = true;
		}
		else
		{
			$is_icons = '';
			$has_icons = false;
		}
		// check alignment setting
		if( $cgwgt_select ) {
		$align = ' align_'.strtolower($cgwgt_select);
		} 
		else
		{
			$align = ' align_left';
		}


		$output .='';

		$output .= $before_widget;
		
		$output .= '<div class="widget-text wp_widget_contact_info">';
		
		if ( $cgwgt_title ) {

			$output .= $before_title . $cgwgt_title . $after_title;

		}

		$output .= '<div class="contact_info'.$is_icons.$align.'">';
		// Check if text is set
		if( $cgwgt_address) { 
			if($has_icons)
			{
				$output .= '<div class="address"><i class="fa fa-map-marker" aria-hidden="true"></i> <span class="txt">'.$cgwgt_address.'</span></div>'; 
			}
			else
			{
				$output .= '<div class="address"><span class="txt">'.$cgwgt_address.'</span></div>'; 
			}
		}
		if( $cgwgt_phone ) {
			if($has_icons)
			{
				$output .= '<div class="phone"><i class="fa fa-phone" aria-hidden="true"></i> <span class="txt">'.$cgwgt_phone.'</span></div>';
			}
			else
			{
				$output .= '<div class="phone"><span class="txt">'.$cgwgt_phone.'</span></div>';
			}
		}
		if( $cgwgt_email ) {
			if($has_icons)
			{
				$output .= '<div class="email"><i class="fa fa-envelope-o" aria-hidden="true"></i> <span class="txt">'.$cgwgt_email.'</span></div>';
			}
			else
			{
				$output .= '<div class="email"><span class="txt">'.$cgwgt_email.'</span></div>';
			}
		}
		// Check if textarea is set

		$output .= '</div></div>';
		$output .= $after_widget;
		echo $output;
	}
}

function contagen_enqueue_style() {
	wp_enqueue_style( 'core', plugins_url().'/contagen-widget/css/contagen.css', false ); 
	wp_enqueue_style( 'icon', plugins_url().'/contagen-widget/font-awesome/css/font-awesome.min.css', false ); 
}

add_action( 'wp_enqueue_scripts', 'contagen_enqueue_style' );

// register widget
add_action('widgets_init', create_function('', 'return register_widget("cgwgt_contagen_widgets");'));










