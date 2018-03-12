<?php

/**
 * Bootstrap menu class injection
 */
function education_park_bootstrap_menu_objects( $sorted_menu_items, $args ) {
    if ( $args->theme_location == 'primary' ) {
        $current = array( 'current-menu-ancestor', 'current-menu-item' );
        $registry = array();
        foreach( $sorted_menu_items as $i => $item ) {
            $is_current = array_intersect( (array) $item->classes, $current );
            if ( !empty( $is_current ) ) $item->classes[] = 'active';
            $registry[$item->ID] = $i;
            if( $item->menu_item_parent ) {
                $parent_index = $registry[$item->menu_item_parent];
                if( !in_array('dropdown', $sorted_menu_items[$parent_index]->classes ) ) {
                    $sorted_menu_items[$parent_index]->classes[] = 'dropdown';
                }
            }
        }
    }
    return $sorted_menu_items;
}
add_filter( 'wp_nav_menu_objects', 'education_park_bootstrap_menu_objects', 10, 2 );


/**
 * Custom Bootstrap Walker
 */
class education_park_bootstrap_nav_menu extends Walker_Nav_Menu {

    /**
     * @see Walker::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
       $indent = str_repeat("\t", $depth);
        $submenu = ( $depth > 0 ) ? ' sub-menu' : '';
        $output    .= "\n$indent<ul style=\"display:none \" class=\"dropdown-menu$submenu \">\n";
    }


    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $li_attributes = '';
        $class_names = $value = '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        // managing divider: add divider class to an element to get a divider before it.
        $divider_class_position = array_search( 'divider', $classes );
        if ( $divider_class_position !== false ) {
            $output .= "<li class=\"divider\"></li>\n";
            unset( $classes[$divider_class_position] );
        }

        if( is_object($args)){
            $classes[] = ( $args->has_children ) ? 'dropdown' : '';
            $classes[] = ( $item->current || $item->current_item_ancestor ) ? 'active' : '';
            // $classes[] = 'menu-item-' . $item->ID;
            if ( $depth && $args->has_children ) {
                $classes[] = 'dropdown-submenu';
            }


            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ) ) );
            $class_names = ' class="' . esc_attr( $class_names ) . '"';

            $output .= $indent . '<li' . $class_names . $li_attributes . '>';

            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
            $attributes .= ($args->has_children)        ? ' class="dropdown-toggle"' : '';

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
            $item_output .= ( $depth == 0 && $args->has_children ) ? ' <b class="caret"></b></a>' : '</a>';
            $item_output .= $args->after;


            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
    }


    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
        //v($element);
        if ( !$element )
            return;
        $id_field = $this->db_fields['id'];

        //display this element
        if ( is_array( $args[0] ) )
            $args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
        else if ( is_object( $args[0] ) )
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        $cb_args = array_merge( array( &$output, $element, $depth), $args );
        call_user_func_array( array( &$this, 'start_el' ), $cb_args );

        $id = $element->$id_field;

        // descend only when the depth is right and there are childrens for this element
        if ( ( $max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id] ) ) {

            foreach( $children_elements[ $id ] as $child ){

                if ( !isset( $newlevel ) ) {
                    $newlevel = true;
                    //start the child delimiter
                    $cb_args = array_merge( array( &$output, $depth ), $args );
                    call_user_func_array( array( &$this, 'start_lvl'), $cb_args );
                }
                $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
            }
            unset( $children_elements[ $id ] );
        }

        if ( isset( $newlevel ) && $newlevel ) {
            //end the child delimiter
            $cb_args = array_merge( array( &$output, $depth ), $args );
            call_user_func_array( array( &$this, 'end_lvl'), $cb_args );
        }

        //end this element
        $cb_args = array_merge( array( &$output, $element, $depth ), $args );
        call_user_func_array( array( &$this, 'end_el'), $cb_args );

    }
}

/**
 * Bootstrap styled Caption shortcode.
 * Hat tip: http://justintadlock.com/archives/2011/07/01/captions-in-wordpress
 */
/*add_filter( 'img_caption_shortcode', 'education_park_bootstrap_img_caption_shortcode', 10, 3 );

function education_park_bootstrap_img_caption_shortcode( $output, $attr, $content ) {

    /* We're not worried abut captions in feeds, so just return the output here. 
    if ( is_feed() )  return '';

    extract(shortcode_atts(array(
                'id'    => '',
                'align' => 'alignnone',
                'width' => '',
                'caption' => ''
            ), $attr));

    if ( 1 > (int) $width || empty( $caption ) )
        return $content;

    if ( $id ) $id = 'id="' . esc_attr($id) . '" ';

    return '<div ' . $id . 'class="thumbnail ' . esc_attr( $align ) . '">'
        . do_shortcode( $content ) . '<figcaption class="wp-caption-text">' .  $caption  . '</figcaption></div>';
}
*/

/**
 * Bootstrap styled Comment form.
 */
add_filter( 'comment_form_defaults', 'education_park_bootstrap_comment_form_defaults', 10, 1 );

function education_park_bootstrap_comment_form_defaults( $defaults ) {

    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $defaults['fields'] =  array(
        'author' => '<div class="form-group comment-form-author">' .
                '<label for="author" class="col-sm-3 control-label">' . esc_html__( 'Name','education-park' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                '<div class="col-sm-9">' .
                    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"  class="form-control"' . $aria_req . ' />' .
                '</div>' .
            '</div>',
        'email'  => '<div class="form-group comment-form-email">' .
                '<label for="email" class="col-sm-3 control-label">' . esc_html__( 'Email','education-park' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                '<div class="col-sm-9">' .
                    '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '"  class="form-control"' . $aria_req . ' />' .
                '</div>' .
            '</div>',
        'url'    => '<div class="form-group comment-form-url">' .
            '<label for="url" class="col-sm-3 control-label"">' . esc_html__( 'Website','education-park' ) . '</label>' .
                '<div class="col-sm-9">' .
                    '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '"  class="form-control" />' .
                '</div>' .
            '</div>',
    );
    $defaults['comment_field'] = '<div class="form-group comment-form-comment">' .
        '<label for="comment" class="col-sm-3 control-label">' . _x( 'Comment', 'noun','education-park' ) . '</label>' .
            '<div class="col-sm-9">' .
                '<textarea id="comment" name="comment" aria-required="true" class="form-control" rows="8"></textarea>' .
                '<span class="help-block form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s','education-park' ), ' <code>' . allowed_tags() . '</code>' ) . '</span>' .
           '</div>' .
        '</div>';

    $defaults['comment_notes_after'] = '<div class="form-group comment-form-submit">';

    return $defaults;
}
add_action( 'comment_form', 'education_park_bootstrap_comment_form', 10, 1 );

function education_park_bootstrap_comment_form( $post_id ) {
    // closing tag for 'comment_notes_after'
    echo '</div><!-- .form-group .comment-form-submit -->';
}

class education_park_page_walker extends Walker_page {

    public $tree_type = 'page';

    /**
     * @see Walker::$db_fields
     * @since 2.1.0
     * @todo Decouple this.
     * @var array
     */
    public $db_fields = array ( 'parent' => 'post_parent', 'id' => 'ID' );

    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        $submenu = ( $depth > 0 ) ? ' sub-menu' : '';
        $output .= "\n$indent<ul style=\"display:none \" class=\"dropdown-menu$submenu \">\n";
    }

    /**
     * @see Walker::end_lvl()
     * @since 2.1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of page. Used for padding.
     * @param array $args
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        $output .= $indent."</ul>\n";
    }

    /**
     * @see Walker::start_el()
     * @since 2.1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $page Page data object.
     * @param int $depth Depth of page. Used for padding.
     * @param int $current_page Page ID.
     * @param array $args
     */
    public function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {
        if ( $depth ) {
            $indent = str_repeat( "\t", $depth );
        } else {
            $indent = '';
        }

        $css_class = array( 'menu-item', 'menu-item-' . $page->ID );
        if ( $depth && isset( $args['pages_with_children'][ $page->ID ] ) ) {
            $css_class[] = 'menu-item-has-children dropdown dropdown-submenu';
        }

        if ( isset( $args['pages_with_children'][ $page->ID ] ) ) {
            $css_class[] = 'menu-item-has-children dropdown';
        }

        if ( ! empty( $current_page ) ) {
            $_current_page = get_post( $current_page );
            if ( $_current_page && in_array( $page->ID, $_current_page->ancestors ) ) {
                $css_class[] = 'dropdown active';
            }
            if ( $page->ID == $current_page ) {
                $css_class[] = 'dropdown active';
            } elseif ( $_current_page && $page->ID == $_current_page->post_parent ) {
                $css_class[] = 'dropdown-submenu';
            }
        } elseif ( $page->ID == get_option('page_for_posts') ) {
            $css_class[] = 'current_page_parent';
        }

        /**
         * Filter the list of CSS classes to include with each page item in the list.
         *
         * @since 2.8.0
         *
         * @see wp_list_pages()
         *
         * @param array   $css_class    An array of CSS classes to be applied
         *                             to each list item.
         * @param WP_Post $page         Page data object.
         * @param int     $depth        Depth of page, used for padding.
         * @param array   $args         An array of arguments.
         * @param int     $current_page ID of the current page.
         */
        $css_classes = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );

        if ( '' === $page->post_title ) {
            $page->post_title = sprintf( __( '#%d (no title)','education-park' ), $page->ID );
        }

        $args['link_before'] = empty( $args['link_before'] ) ? '' : $args['link_before'];
        $args['link_after'] = empty( $args['link_after'] ) ? '' : $args['link_after'];

        /** This filter is documented in wp-includes/post-template.php */
        $dropdown_toggle = ( $depth>0 ) ? 'class="dropdown-toggle"' : '';
        $dropdown_caret = ( $depth == 0 && isset( $args['pages_with_children'][ $page->ID ] ) ) ? '<b class="caret"></b>' : '';
        $output .= $indent . sprintf(
            '<li class="%s"><a href="%s" %s>%s%s%s%s</a>',
            $css_classes,
            esc_url( get_permalink( $page->ID ) ),
            $dropdown_toggle,
            $args['link_before'],
            apply_filters( 'the_title', $page->post_title, $page->ID ),
            $args['link_after'],
            $dropdown_caret
        );

        if ( ! empty( $args['show_date'] ) ) {
            if ( 'modified' == $args['show_date'] ) {
                $time = $page->post_modified;
            } else {
                $time = $page->post_date;
            }

            $date_format = empty( $args['date_format'] ) ? '' : $args['date_format'];
            $output .= " " . mysql2date( $date_format, $time );
        }
    }

    /**
     * @see Walker::end_el()
     * @since 2.1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $page Page data object. Not used.
     * @param int $depth Depth of page. Not Used.
     * @param array $args
     */
    public function end_el( &$output, $page, $depth = 0, $args = array() ) {
        $output .= "</li>\n";
    }
}