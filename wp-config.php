<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u112548p108630_apex' );

/** MySQL database username */
define( 'DB_USER', 'u112548p108630_apex' );

/** MySQL database password */
define( 'DB_PASSWORD', 'JobJobse1982' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'T8-RlD;X ^gT;Geuo1w<BKdDVn;O2rE3E&uoA#s9D~`e~jiQ rnhK>n&dF`:6!mg' );
define( 'SECURE_AUTH_KEY',  'K##gu8e.wR!Jva_nk4-XT[]5o Kcsn`af7bpGb#U.5rpUpk/K_L?:|J%dr5LXJ*[' );
define( 'LOGGED_IN_KEY',    'N41xTEgLYb6QM1^Oxc+{6gO?Fb1^v9rKlv>pMF~4lheD;dl17*zG9vzpw0~MfLI?' );
define( 'NONCE_KEY',        'cON{sSBSAxXwEPEtHyK=`dG}:<V+yTnN+p^O} &!k2:.G%)d]*nksBvZn!>1H5x$' );
define( 'AUTH_SALT',        '8z ueUtp;U5,}180ccFBXGG}fh]6G*%ak%(hNI8Y3k/*WHY.LXqU4s2=^h07elA`' );
define( 'SECURE_AUTH_SALT', 'rw(j`SYh!-wju&@SpX&#u9!LA!_5_qhY1:h;qln(y_U(WBp>#kobL0k]BmX2I;p:' );
define( 'LOGGED_IN_SALT',   'A/GY@(X^bZLC3bOI73}VwZsh|R1t%oaQWhQ7sbB1,+u}G<FBm`?eQ~k~sZG%.DTB' );
define( 'NONCE_SALT',       'R_TM}lh(.,0dF7lhCr)vBgt%?JsOxKc#=vk;p[bL{;)~)m?0h1Q `65s*~[25o7l' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_LOG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
