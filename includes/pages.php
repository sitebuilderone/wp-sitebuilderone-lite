<?php

// ---------------------------------------------------------------------------
// Required pages notice on the Pages screen.
// ---------------------------------------------------------------------------
add_action( 'admin_notices', function () {
    $screen = get_current_screen();
    if ( ! $screen || 'edit-page' !== $screen->id ) return;
    if ( ! current_user_can( 'manage_options' ) ) return;

    if ( isset( $_GET['sbo_created'] ) ) {
        echo '<div class="notice notice-success is-dismissible"><p>Page created successfully.</p></div>';
    }

    $required_pages = [
        [ 'title' => 'Home',         'slug' => 'home' ],
        [ 'title' => 'About',        'slug' => 'about' ],
        [ 'title' => 'Contact',      'slug' => 'contact' ],
        [ 'title' => 'Blog',         'slug' => 'blog' ],
        [ 'title' => 'Sitemap',      'slug' => 'sitemap' ],
		[ 'title' => 'Services',      'slug' => 'services' ],
		[ 'title' => 'Brand Style Guide',      'slug' => 'style-guide' ],
        [ 'title' => 'Privacy Policy', 'slug' => 'privacy-policy' ],
        [ 'title' => 'Terms of Service', 'slug' => 'terms-of-service' ],
    ];

    $missing = [];
    foreach ( $required_pages as $page ) {
        $existing = get_page_by_path( $page['slug'] );
        if ( ! $existing ) {
            $create_url = wp_nonce_url(
                add_query_arg(
                    [ 'action' => 'sbo_create_page', 'sbo_page_title' => urlencode( $page['title'] ), 'sbo_page_slug' => $page['slug'] ],
                    admin_url( 'admin-post.php' )
                ),
                'sbo_create_page_' . $page['slug']
            );
            $missing[] = sprintf(
                '<strong>%s</strong> — <a href="%s">Create now</a>',
                esc_html( $page['title'] ),
                esc_url( $create_url )
            );
        }
    }

    if ( empty( $missing ) ) return;
    ?>
    <div class="notice notice-warning">
        <p><strong>SiteBuilderOne</strong> recommends creating the following page(s):</p>
        <ul style="list-style:disc;margin-left:1.5em;">
            <?php foreach ( $missing as $item ) : ?>
                <li><?php echo $item; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
} );

// ---------------------------------------------------------------------------
// Handler — create a single required page.
// ---------------------------------------------------------------------------
add_action( 'admin_post_sbo_create_page', function () {
    if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Unauthorized' );

    $slug = isset( $_GET['sbo_page_slug'] ) ? sanitize_title( wp_unslash( $_GET['sbo_page_slug'] ) ) : '';
    check_admin_referer( 'sbo_create_page_' . $slug );

    $title = isset( $_GET['sbo_page_title'] ) ? sanitize_text_field( urldecode( wp_unslash( $_GET['sbo_page_title'] ) ) ) : $slug;

    if ( $slug && ! get_page_by_path( $slug ) ) {
        wp_insert_post( [
            'post_title'  => $title,
            'post_name'   => $slug,
            'post_status' => 'publish',
            'post_type'   => 'page',
        ] );
    }

    wp_safe_redirect( admin_url( 'edit.php?post_type=page&sbo_created=1' ) );
    exit;
} );