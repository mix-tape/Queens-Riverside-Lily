<?php 

// ==========================================================================
//
//  Theme Widgets
//    Widgets and re-usable sections of content or functionality
//
// ==========================================================================


// --------------------------------------------------------------------------
// Pagination
// --------------------------------------------------------------------------

function sandpit_pagination($pages = '', $range = 2)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a class='first' href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a class='previous' href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages) echo "<a class='next' href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a class='last' href='".get_pagenum_link($pages)."'>&raquo;</a>";

     }
}

// --------------------------------------------------------------------------
// Sub Menu widget walker
// --------------------------------------------------------------------------

 
 class Selective_Walker extends Walker_Nav_Menu
	{
		 function walk( $elements, $max_depth) {
	
			 $args = array_slice(func_get_args(), 2);
			 $output = '';
	
			 if ($max_depth < -1) //invalid parameter
				 return $output;
	
			 if (empty($elements)) //nothing to walk
				 return $output;
	
			 $id_field = $this->db_fields['id'];
			 $parent_field = $this->db_fields['parent'];
	
			 // flat display
			 if ( -1 == $max_depth ) {
				 $empty_array = array();
				 foreach ( $elements as $e )
					 $this->display_element( $e, $empty_array, 2, 0, $args, $output );
				 return $output;
			 }
	
			 /*
			  * need to display in hierarchical order
			  * separate elements into two buckets: top level and children elements
			  * children_elements is two dimensional array, eg.
			  * children_elements[10][] contains all sub-elements whose parent is 10.
			  */
			 $top_level_elements = array();
			 $children_elements	 = array();
			 foreach ( $elements as $e) {
				 if ( 0 == $e->$parent_field )
					 $top_level_elements[] = $e;
				 else
					 $children_elements[ $e->$parent_field ][] = $e;
			 }
	
			 /*
			  * when none of the elements is top level
			  * assume the first one must be root of the sub elements
			  */
			 if ( empty($top_level_elements) ) {
	
				 $first = array_slice( $elements, 0, 1 );
				 $root = $first[0];
	
				 $top_level_elements = array();
				 $children_elements	 = array();
				 foreach ( $elements as $e) {
					 if ( $root->$parent_field == $e->$parent_field )
						 $top_level_elements[] = $e;
					 else
						 $children_elements[ $e->$parent_field ][] = $e;
				 }
			 }
	
			 $current_element_markers = array( 'current-menu-item', 'current-menu-parent', 'current-menu-ancestor' );  //added by continent7
			 foreach ( $top_level_elements as $e ){	 //changed by continent7
				 // descend only on current tree
				 $descend_test = array_intersect( $current_element_markers, $e->classes );
				 if ( !empty( $descend_test ) ) 
					 $this->display_element( $e, $children_elements, 4, 0, $args, $output );
			 }
	
			 /*
			  * if we are displaying all levels, and remaining children_elements is not empty,
			  * then we got orphans, which should be displayed regardless
			  */
			  /* removed by continent7
			 if ( ( $max_depth == 0 ) && count( $children_elements ) > 0 ) {
				 $empty_array = array();
				 foreach ( $children_elements as $orphans )
					 foreach( $orphans as $op )
						 $this->display_element( $op, $empty_array, 1, 0, $args, $output );
			  }
			 */
			  return $output;
		 }
	}
	
 
 class WP_Sub_Menu_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => __('Use this widget to show the current pages siblings as a menu.') );
		parent::__construct( 'sub_menu', __('Sub Menu'), $widget_ops );
	}

	function widget($args, $instance) {
		// Get menu
		$nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

		if ( !$nav_menu )
			return;

		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $args['before_widget'];

		if ( !empty($instance['title']) )
			echo $args['before_title'] . $instance['title'] . $args['after_title'];
		
		$walker = new Selective_Walker();
		
		wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu, 'walker' => $walker) );

		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';

		// Get menus
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

		// If no menus exists, direct the user to go and create some.
		if ( !$menus ) {
			echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.'), admin_url('nav-menus.php') ) .'</p>';
			return;
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:'); ?></label>
			<select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
		<?php
			foreach ( $menus as $menu ) {
				$selected = $nav_menu == $menu->term_id ? ' selected="selected"' : '';
				echo '<option'. $selected .' value="'. $menu->term_id .'">'. $menu->name .'</option>';
			}
		?>
			</select>
		</p>
		<?php
	}
}

add_action( 'widgets_init', create_function( '', 'register_widget( "WP_Sub_Menu_Widget" );' ) );
