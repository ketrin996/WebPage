<?php
//sanitize callback, returns text from text box
/**
 * Sanitization: css
 * Control: text, textarea
 *
 * Sanitization callback for 'css' type textarea inputs. This
 * callback sanitizes $input for valid CSS.
 *
 * NOTE: wp_strip_all_tags() can be passed directly as
 * $wp_customize->add_setting() 'sanitize_callback'. It
 * is wrapped in a callback here merely for example
 * purposes.
 *
 * @uses    wp_strip_all_tags() https://developer.wordpress.org/reference/functions/wp_strip_all_tags/
 */

/**
 * Sanitization: css
 * Control: text, textarea
 *
 * Sanitization callback for 'css' type textarea inputs. This
 * callback sanitizes $input for valid CSS.
 *
 * NOTE: wp_strip_all_tags() can be passed directly as
 * $wp_customize->add_setting() 'sanitize_callback'. It
 * is wrapped in a callback here merely for example
 * purposes.
 *
 * @uses    wp_strip_all_tags() https://developer.wordpress.org/reference/functions/wp_strip_all_tags/
 */

//sanitize callback, returns text from text box
if( !function_exists( 'education_park_text_sanitize' ) ) :
    function education_park_text_sanitize( $value ) {
        // Initialize the new array that will hold the sanitize values
        $new_input = array();
        // Loop through the input and sanitize each of the values
        foreach ( $value as $key => $val ) {
            $new_input[ $key ] = sanitize_text_field( $val );
        }
        return $new_input;
    }
endif;


    /**
     * Sanitize a checkbox to only allow 0 or 1
     *
     * @since  1.2.0
     * @access public
     * @param  $input
     * @return int
     */
if( !function_exists( 'education_park_sanitize_checkbox' ) ) :
    function education_park_sanitize_checkbox( $input ) {
        return ( 1 === absint( $input ) ) ? 1 : 0;
    }
endif;

/**
 * Sanitization: select
 * Control: select, radio
 *
 * Sanitization callback for 'select' and 'radio' type controls.
 * This callback sanitizes $input as a slug, and then validates
 * $input against the choices defined for the control.
 *
 * @uses    sanitize_key()          https://developer.wordpress.org/reference/functions/sanitize_key/
 * @uses    $wp_customize->get_control()    https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
 */
if( !function_exists( 'education_park_sanitize_select' ) ) :

    function education_park_sanitize_select( $input, $setting ) {

        // Ensure input is a slug
        $input = sanitize_key( $input );

        // Get list of choices from the control
        // associated with the setting
        $choices = $setting->manager->get_control( $setting->id )->choices;

        // If the input is a valid key, return it;
        // otherwise, return the default
        return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
    }
endif;

if( !function_exists( 'education_park_sanitize_hex_color' ) ) :
    function education_park_sanitize_hex_color( $color ) {
        if ( '' === $color )
            return '';

        // 3 or 6 hex digits, or the empty string.
        if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
            return $color;
    }
endif;

/**
 * Validation: image
 * Control: text, WP_Customize_Image_Control
 *
 * @uses    wp_check_filetype()     https://developer.wordpress.org/reference/functions/wp_check_filetype/
 * @uses    in_array()              http://php.net/manual/en/function.in-array.php
 */
if( !function_exists( 'education_park_validate_image' ) ) :
function education_park_validate_image( $input, $default = '' ) {
    // Array of valid image file types
    // The array includes image mime types
    // that are included in wp_get_mime_types()
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon'
    );
    // Return an array with file extension
    // and mime_type
    $file = wp_check_filetype( $input, $mimes );
    // If $input has a valid mime_type,
    // return it; otherwise, return
    // the default.
    return ( $file['ext'] ? $input : $default );
}
endif;