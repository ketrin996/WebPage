<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Education Park
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?> class="no-js">
<!--<![endif]-->
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <?php wp_head(); ?>
</head>

<?php
$boxedornot = education_park_boxedornot();
$pageclass = 'boxed-layout';
if ($boxedornot == 'fullwidth') {
    $pageclass = 'fullwidth-layout';
} else {
    $pageclass = 'boxed-layout container';
}
$bodyclass = array($pageclass);

?>
<body <?php body_class($bodyclass); ?>>

<div id="themenu" class="hide mobile-navigation">
    <?php
    $args = array(
        'theme_location' => 'primary',
        'depth' => 4,
    );
    wp_nav_menu($args);
    ?>
</div>
<!-- Mobile Navigation -->

<div id="page" class="hfeed site site_wrapper thisismyheader">

    <?php do_action('before'); ?>

    <header id="masthead" class="site-header" role="banner">
        <?php
        $facebook = get_theme_mod('site_facebook_link');
        $twitter = get_theme_mod('site_twitter_link');
        $site_gplus_link = get_theme_mod('site_gplus_link');
        $site_pinterest_link = get_theme_mod('site_pinterest_link');
        $site_map_link = get_theme_mod('top_head_map_link');
        $top_head_location = get_theme_mod('top_head_location');
        $top_head_phone = get_theme_mod('top_head_phone');

        if ($facebook || $twitter || $site_gplus_link || $site_pinterest_link || $site_map_link || $top_head_location || $top_head_phone) {

            ?>
            <div class="top-header">
                <div class="container">
                    <div class="row">

                        <div class="col-md-6 text-left">
                            <?php
                            if ($facebook || $twitter || $site_gplus_link || $site_pinterest_link) {
                                ?>
                                <div class="top-social-icon">
                                    <ul>
                                        <?php if ($facebook != null) { ?>
                                            <li><a href="<?php echo esc_url($facebook); ?>" class="facebook"><i
                                                            class="fa fa-facebook"></i></a></li>
                                        <?php } ?>
                                        <?php if ($twitter != null) { ?>
                                            <li><a href="<?php echo esc_url($twitter); ?>" class="twitter"><i
                                                            class="fa fa-twitter"></i></a></li>
                                        <?php } ?>
                                        <?php if ($site_gplus_link != null) { ?>
                                            <li><a href="<?php echo esc_url($site_gplus_link); ?>" class="gplus"><i
                                                            class="fa fa-google-plus"></i></a></li>
                                        <?php } ?>
                                        <?php if ($site_pinterest_link != null) { ?>
                                            <li><a href="<?php echo esc_url($site_pinterest_link); ?>"
                                                   class="pinterest"><i class="fa fa-pinterest"></i></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                        if ($site_map_link || $top_head_location || $top_head_phone) {

                            ?>
                            <div class="col-md-6 text-right">
                                <ul class="header-top-right">
                                    <?php
                                    if ($site_map_link || $top_head_location) {
                                        $site_map_link = $site_map_link ? $site_map_link : '#';
                                        ?>
                                        <li class="header-address">
                                            <p><a href="<?php echo esc_url($site_map_link); ?>" target="_blank"><i
                                                            class="fa fa-map-marker"
                                                            aria-hidden="true"></i><span><?php echo esc_html($top_head_location) ?></span></a>
                                            </p>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if ($top_head_phone) {
                                        ?>
                                        <li class="header-phone">
                                            <p><a href="<?php echo esc_html__('tel:', 'education-park');
                                                echo esc_html($top_head_phone) ?>"><i class="fa fa-phone-square"
                                                                                      aria-hidden="true"></i><span><?php echo esc_html($top_head_phone) ?></span></a>
                                            </p>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php }
        ?>
        <nav id="site-navigation"
             class="main-navigation navbar <?php if ($boxedornot == 'boxed') { ?>container<?php } ?>" role="navigation">

            <a class="skip-link screen-reader-text"
               href="#content"><?php esc_html_e('Skip to content', 'education-park'); ?></a>

            <?php if ($boxedornot == 'fullwidth') { ?>
            <div class="container">
                <?php } ?>

                <div class="navbar-header">

                    <div class="site-branding navbar-brand">
                       <?php
                        if (function_exists('has_custom_logo') && has_custom_logo()) {
                            the_custom_logo();
                        }
                        ?>
                        <div class="site-desc site-brand text-center">
                            <h3 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                                      rel="home"><?php bloginfo('name'); ?></a></h3>
                            <?php
                            $description = get_bloginfo('description', 'display');
                            if ($description || is_customize_preview()) : ?>
                                <p class="site-description"><?php echo esc_html($description);?></p>
                                <?php
                            endif; ?>
                        </div>
                    </div>
                    <!-- End the Site Brand -->

                    <a href="#themenu" type="button" class="navbar-toggle" role="button" id="hambar">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>

                </div>

                <div class="collapse navbar-collapse" id="navbar-collapse-main">
                    <?php

                    if (has_nav_menu('primary')) {
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'container' => false,
                            'depth' => 4,
                            'menu_class' => 'nav navbar-nav navbar-right main-site-nav',
                            'walker' => new education_park_bootstrap_nav_menu(),
                        ));
                    } else {
                        wp_page_menu(array(
                            'depth' => -1,
                            'menu_class' => 'menu fallback_menu_default'
                        ));
                    }
                    ?>
                </div>
                <!-- End /.navbar-collapse -->

                <?php if ($boxedornot == 'fullwidth') { ?>
            </div>
        <?php } ?>

        </nav>
        <!-- End #site-navigation -->
    </header>
    <!-- End #masthead -->

    <div id="content-wrap" class="site-content">