<?php
// ---------------------------------------------------------------------------
// Required plugins notice on the Plugins page.
// ---------------------------------------------------------------------------
add_action( 'admin_notices', function () {
    $screen = get_current_screen();
    if ( ! $screen || 'plugins' !== $screen->id ) return;
    if ( ! current_user_can( 'manage_options' ) ) return;

    $required = [
        [
            'name'   => 'WP Sitemap Page',
            'slug'   => 'wp-sitemap-page',
            'check'  => 'wp-sitemap-page/wp-sitemap-page.php', // folder/main-file.php
			],

		[
    'name'  => 'RankMath SEO',
    'slug'  => 'seo-by-rank-math',
    'check' => 'seo-by-rank-math/rank-math.php',
],
[
    'name'  => 'RankMath Instant Indexing',
    'slug'  => 'fast-indexing-api',
    'check' => 'fast-indexing-api/instant-indexing.php',
],
[
    'name'  => 'SiteKit by Google',
    'slug'  => 'google-site-kit',
    'check' => 'google-site-kit/google-site-kit.php',
],
[
    'name'  => 'Clarity',
    'slug'  => 'microsoft-clarity',
    'check' => 'microsoft-clarity/index.php',
],
[
    'name'  => 'LiteSpeed Cache',
    'slug'  => 'litespeed-cache',
    'check' => 'litespeed-cache/litespeed-cache.php',
],
[
    'name'  => 'Google Reviews by Trustindex',
    'slug'  => 'wp-reviews-plugin-for-google',
    'check' => 'wp-reviews-plugin-for-google/wp-reviews-plugin-for-google.php',
],
[
    'name'  => 'Redirection',
    'slug'  => 'redirection',
    'check' => 'redirection/redirection.php',
],
[
    'name'  => 'ReCaptcha',
    'slug'  => 'advanced-google-recaptcha',
    'check' => 'advanced-google-recaptcha/advanced-google-recaptcha.php',
],
[
    'name'  => 'Phoenix Media Rename',
    'slug'  => 'phoenix-media-rename/',
    'check' => 'phoenix-media-rename/phoenix-media-rename.php',
],
[
    'name'  => 'Microsoft Clarity',
    'slug'  => 'microsoft-clarity/',
    'check' => 'microsoft-clarity/microsoft-clarity.php',
],
[
    'name'  => 'Fluent Forms',
    'slug'  => 'fluentform',
    'check' => 'fluentform/fluentform.php',
],
[
    'name'  => '[Local dev] GitHub Deployer',
    'slug'  => 'deployer-for-git',
    'check' => 'deployer-for-git/deployer-for-git.php',
],


    ];

    $missing = [];
    foreach ( $required as $plugin ) {
        if ( ! is_plugin_active( $plugin['check'] ) ) {
            $install_url = wp_nonce_url(
                admin_url( 'update.php?action=install-plugin&plugin=' . $plugin['slug'] ),
                'install-plugin_' . $plugin['slug']
            );
            $missing[] = sprintf(
                '<strong>%s</strong> — <a href="%s">Install now</a>',
                esc_html( $plugin['name'] ),
                esc_url( $install_url )
            );
        }
    }

    if ( empty( $missing ) ) return;
    ?>
    <div class="notice notice-warning">
        <p><strong>SiteBuilderOne</strong> recommends the following plugin(s):</p>
        <ul style="list-style:disc;margin-left:1.5em;">
            <?php foreach ( $missing as $item ) : ?>
                <li><?php echo $item; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
} );
