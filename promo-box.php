<?php
/*
Plugin Name: Genesis Promotion Box
Plugin URI: http://wpebooks.com/genesis-promo-box/
Description: Show a promotion box below single posts.
Author: Ron Rennick
Version: 0.1
Author URI: http://ronandandrea.com/

*/
/* Copyright:   (C) 2010 Ron Rennick, All rights reserved.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
class Genesis_Promo_Box_Post_Type {
	var $post_type_name = 'promotion_post';
	var $post_type = array(
		'menu_position' => '3',
		'public' => false,
		'show_ui' => true,
		'rewrite' => false,
		'query_var' => false,
		'supports' => array( 'title', 'editor' )
		);

	function Genesis_Promo_Box_Post_Type() {
		return $this->__construct();
	}

	function  __construct() {
		add_action( 'init', array( &$this, 'init' ) );

	}

	function init() {
		$this->post_type['labels'] = array( 'name' => 'Promotions' );
		register_post_type( $this->post_type_name, $this->post_type );
		add_action( 'genesis_after_post', array( $this, 'genesis_after_post' ), 8 );
	}

	function genesis_after_post() {
		if( !is_singular( 'post' ) ) {
			remove_action( 'genesis_after_post', array( $this, 'genesis_after_post' ), 8 );
			return;
		}
		
		$post = new WP_Query( array( 'showposts' => 1, 'post_type' => $this->post_type_name ) );
		if( $post->have_posts() ) {
			$post->the_post();
			?><div id="genesis-promo-box" class="alt thread-alt">
				<h3><?php the_title(); ?></h3>
				<?php the_content(); ?>
				<div class="clear"></div>
			</div><?php
		}
		wp_reset_query();
	}
}

$wpeb_gpb_post_type = new Genesis_Promo_Box_Post_Type();
