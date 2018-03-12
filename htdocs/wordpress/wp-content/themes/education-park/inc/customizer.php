<?php
/**
 * Education Park Theme Customizer
 *
 * @package Education Park
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if (!function_exists('education_park_customize_register')) :
    function education_park_customize_register($wp_customize)
    {
        $wp_customize->get_setting('blogname')->transport = 'postMessage';
        $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
        //$wp_customize->get_setting( 'display_header_text' )->transport = 'postMessage';

        if (isset($wp_customize->selective_refresh)) {
            $wp_customize->selective_refresh->add_partial('blogname', array(
                'selector' => '.site-title a',
                'render_callback' => 'education_park_customize_partial_blogname',
            ));
            $wp_customize->selective_refresh->add_partial('blogdescription', array(
                'selector' => '.site-description',
                'render_callback' => 'education_park_customize_partial_blogdescription',
            ));
        }

    }

    add_action('customize_register', 'education_park_customize_register');
endif;

function education_park_customize_partial_blogname()
{
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 *
 * @return void
 */
function education_park_customize_partial_blogdescription()
{
    bloginfo('description');
}


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
if (!function_exists('education_park_customize_preview_js')) :
    function education_park_customize_preview_js()
    {
        wp_enqueue_script('education-park-customizer-js', trailingslashit(get_template_directory_uri()) . 'js/customizer.js');

    }

    add_action('customize_preview_init', 'education_park_customize_preview_js');
endif;

function education_park_customize_main_js()
{
    wp_enqueue_script('education-park-customizer-main-js', trailingslashit(get_template_directory_uri()) . 'js/customizer-main.js');
    wp_localize_script('education-park-customizer-main-js', 'education_park_objectL10n', array(
        'response' => esc_html__('You can select upto 3 pages only', 'education-park'),
    ));
}

add_action('customize_controls_enqueue_scripts', 'education_park_customize_main_js');

/**
 *
 * Panel for customizers
 *
 **/

$customiser_control = get_template_directory() . '/inc/education-park-customize-control.php';
if ( file_exists( $customiser_control ) ) {
    require_once( $customiser_control );
}

if (!function_exists('education_park_customizer_panels')) :
    function education_park_customizer_panels($wp_customize)
    {

        $wp_customize->add_panel('education_park_theme_panel', array(
            'priority' => 25,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => esc_html__('Theme Options', 'education-park'),
            'description' => '',
        ));
    }

    add_action('customize_register', 'education_park_customizer_panels');
endif;

/************************************************/
/*           Section For Header Logo           */
/***********************************************/
if (!function_exists('education_park_header_section')) :
    function education_park_header_section($wp_customize)
    {

        // New Layout and Design

        $wp_customize->add_section('section_layout_design', array(
                'title' => esc_html__('Layout and design', 'education-park'),
                'label' => esc_html__('Layout and design. ', 'education-park'),
                'panel' => 'education_park_theme_panel',
                'priority' => 1,
            )
        );

        $wp_customize->add_setting('layout_control', array(
                'default' => 'boxed',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'education_park_sanitize_select',
            )
        );
        $wp_customize->add_control('layout_control', array(
                'label' => esc_html__('Choose Layout', 'education-park'),
                'section' => 'section_layout_design',
                'type' => 'radio',
                'choices' => array(
                    'boxed' => esc_html__('Boxed', 'education-park'),
                    'fullwidth' => esc_html__('Full Width', 'education-park'),
                ),
                'priority' => 5,
            )
        );

        $wp_customize->add_setting('layout_picker', array(
                'default' => 3,
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'education_park_sanitize_select',
            )
        );

        $wp_customize->add_control( 'layout_picker',
            array(
                'label' => esc_html__('Layout picker', 'education-park'),
                'type'     => 'select',
                'choices'  => education_park_get_global_layout_options(),
                'section' => 'section_layout_design',
                'settings' => 'layout_picker',
                'priority' => 6,
            )
        );
    }

    add_action('customize_register', 'education_park_header_section');
endif;



/**
 *
 * Customizer for the footer page
 *
 **/
if (!function_exists('education_park_front_page_customize')) {
    function education_park_front_page_customize($wp_customize)
    {

        /****************************************************************************/
        /* General Setting for Footer Content  */
        /****************************************************************************/

        $wp_customize->add_section('footer_section', array(
                'title' => esc_html__('Call To Action', 'education-park'),
                'description' => esc_html__('This is a section for Call to Action of the site above the testimonial.', 'education-park'),
                'panel' => 'education_park_theme_panel',
                'priority' => 5,
            )
        );

        $wp_customize->add_setting('cta_heading', array(
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );
        $wp_customize->add_control('cta_heading', array(
                'label' => esc_html__('Call To Action Title', 'education-park'),
                'section' => 'footer_section',
                'type' => 'text',
                'priority' => 1,
            )
        );

        $wp_customize->add_setting('cta_content_text', array(
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_textarea_field',
        ));

        $wp_customize->add_control('cta_content_text', array(
                'label' => esc_html__('The Content for the Call To Action Section', 'education-park'),
                'section' => 'footer_section',
                'settings' => 'cta_content_text',
                'priority' => 2,
                'type' => 'textarea',

            )
        );

        $wp_customize->add_setting('cta_link_url', array(
                'default' => '#',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'esc_url_raw',
            )
        );
        $wp_customize->add_control('cta_link_url', array(
                'label' => esc_html__('Button URL', 'education-park'),
                'section' => 'footer_section',
                'type' => 'url',
                'priority' => 3,
            )
        );
        $wp_customize->add_setting('cta_link_text', array(
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );
        $wp_customize->add_control('cta_link_text', array(
                'label' => esc_html__('Button Text', 'education-park'),
                'section' => 'footer_section',
                'type' => 'text',
                'priority' => 4,
            )
        );
        $wp_customize->add_setting('section_background', array(
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'section_background', array(
                    'label' => esc_html__('Background Image', 'education-park'),
                    'section' => 'footer_section',
                    'settings' => 'section_background',
                    'priority' => 5,
                )
            )
        );

        /***********************************/
        /*** Slider *****/
        /**********************************/

        $wp_customize->add_section('education_park_front_page', array(
            'title' => esc_html__('Slider Options', 'education-park'),
            'panel' => 'education_park_theme_panel',
            'priority' => 2,
        ));

        $wp_customize->add_setting('featured_post', array(
            'default' => 'none',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'education_park_text_sanitize',
        ));

        $wp_customize->add_control(new education_park_Page_Dropdown_control($wp_customize, 'featured_post', array(
            'label' => esc_html__('Select a Page for slider', 'education-park'),
            'section' => 'education_park_front_page',
            'priority' => 1,
        )));

        /******************************/
        /***** Posts below slider *****/
        /******************************/

        $wp_customize->add_section('education_park_callout', array(
            'title' => esc_html__('Courses Options', 'education-park'),
            'panel' => 'education_park_theme_panel',
            'priority' => 3,
        ));

        $wp_customize->add_setting('first_post_title', array(
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('first_post_title', array(
            'label' => esc_html__('Section Title', 'education-park'),
            'section' => 'education_park_callout',
            'priority' => 2,
        ));

        $wp_customize->add_setting('first_post', array(
            'default' => 'none',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'education_park_text_sanitize',
        ));
        $wp_customize->add_control(new education_park_Page_Dropdown_control($wp_customize, 'first_post', array(
            'label' => esc_html__('Select 3 Pages To Show Below Slider', 'education-park'),
            'description' => esc_html__('Select a category to display post below the slider', 'education-park'),
            'section' => 'education_park_callout',
            'priority' => 3,

        )));


        /**********************************************/
        /*** From the blog ***/
        /*******************************************/

        $wp_customize->add_section('education_park_blog', array(
            'title' => esc_html__('Blog Options', 'education-park'),
            'panel' => 'education_park_theme_panel',
            'priority' => 5,
        ));
        $wp_customize->add_setting('blog_title', array(
                'default' => '',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        $wp_customize->add_control('blog_title', array(
                'label' => esc_html__('Blog Title', 'education-park'),
                'section' => 'education_park_blog',
                'type' => 'text',
            )
        );

        $wp_customize->add_setting('excerpt_length', array(
                'default' => 20,
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        $wp_customize->add_control('excerpt_length', array(
                'label' => esc_html__('Excerpt Length', 'education-park'),
                'section' => 'education_park_blog',
                'type' => 'text',
            )
        );

        $wp_customize->add_setting('show_blog_meta', array(
            'default' => 1,
            'sanitize_callback' => 'education_park_sanitize_checkbox'
        ));

        $wp_customize->add_control('show_blog_meta', array(
            'label' => esc_html__('Show Meta In Blog?', 'education-park'),
            'section' => 'education_park_blog',
            'settings' => 'show_blog_meta',
            'type' => 'checkbox'
        ));
    }
}
add_action('customize_register', 'education_park_front_page_customize');

/******************************************************************/
/*              Social Media Section                              */
/******************************************************************/
if (!function_exists('education_park_social_media_section')) :
    function education_park_social_media_section($wp_customize)
    {

        $wp_customize->add_section('social_media_section', array(
                'title' => esc_html__('Top Header Options', 'education-park'),
                'panel' => 'education_park_theme_panel',
                'priority' => 1,
            )

        );

        $wp_customize->add_setting('site_facebook_link', array(
                'default' => '',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'esc_url_raw',
            )
        );

        $wp_customize->add_control('site_facebook_link', array(
                'label' => esc_html__('Facebook Link', 'education-park'),
                'section' => 'social_media_section',
                'type' => 'url',
                'priority' => 3,
            )
        );

        $wp_customize->add_setting('site_twitter_link', array(
                'default' => '',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'esc_url_raw',
            )
        );

        $wp_customize->add_control('site_twitter_link', array(
                'label' => esc_html__('Twitter Link', 'education-park'),
                'section' => 'social_media_section',
                'type' => 'url',
                'priority' => 4,
            )
        );

        $wp_customize->add_setting('site_gplus_link', array(
                'default' => '',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'esc_url_raw',
            )
        );

        $wp_customize->add_control('site_gplus_link', array(
                'label' => esc_html__('Google Plus Link', 'education-park'),
                'section' => 'social_media_section',
                'type' => 'url',
                'priority' => 5,
            )
        );

        $wp_customize->add_setting('site_pinterest_link', array(
                'default' => '',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'esc_url_raw',
            )
        );

        $wp_customize->add_control('site_pinterest_link', array(
                'label' => esc_html__('Pinterest Link', 'education-park'),
                'section' => 'social_media_section',
                'type' => 'url',
                'priority' => 9,
            )
        );
        $wp_customize->add_setting('top_head_location', array(
                'default' => '',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        $wp_customize->add_control('top_head_location', array(
                'label' => esc_html__('Address', 'education-park'),
                'section' => 'social_media_section',
                'type' => 'textarea',
                'priority' => 9,
            )
        );
        $wp_customize->add_setting('top_head_map_link', array(
                'default' => '',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'esc_url_raw',
            )
        );

        $wp_customize->add_control('top_head_map_link', array(
                'label' => esc_html__('Map Link', 'education-park'),
                'section' => 'social_media_section',
                'type' => 'text',
                'priority' => 9,
            )
        );
        $wp_customize->add_setting('top_head_phone', array(
                'default' => '',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        $wp_customize->add_control('top_head_phone', array(
                'label' => esc_html__('Phone No.', 'education-park'),
                'section' => 'social_media_section',
                'type' => 'text',
                'priority' => 9,
            )
        );

    }

    add_action('customize_register', 'education_park_social_media_section');
endif;

$repeater_path = get_template_directory() . '/inc/customizer-sanitization.php';
if ( file_exists( $repeater_path ) ) {
    require_once( $repeater_path );
}