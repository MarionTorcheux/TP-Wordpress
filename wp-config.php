<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'modelisme' );

/** Database username */
define( 'DB_USER', 'admin' );

/** Database password */
define( 'DB_PASSWORD', 'admin' );

/** Database hostname */
define( 'DB_HOST', 'database' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'Q@-4zU9TzFOHA5D%>|w8c#[Z{om&0]#/L`x2(I` $Et}ilT5<1/y7`cKYF2OgUu&' );
define( 'SECURE_AUTH_KEY',   '/Sp~VaIA6/#Nb-C]yeJ%oKo+Fl2%_tn)(yjE|c{C+h?:%J(]]-cO*g3SM0PGxYLP' );
define( 'LOGGED_IN_KEY',     'xr_VPA*a*@cP3=m6LVYX<oV|^i+59IKu&ht@iY1*.2M!sTcGx!QYzL}H-5,<&)K-' );
define( 'NONCE_KEY',         '!NcPAsou^B-hoQKC#^eTZ |i<3yP_g.^j^wmGeyXo]s_:;d!8$+*HM44f+@h5x~%' );
define( 'AUTH_SALT',         '[w[Fey/|0uknu:01lm,/H,jx(+BuotwYf0U*8*(a+V_:u>QH.[B}<e.GBbGynS_0' );
define( 'SECURE_AUTH_SALT',  'RbAKX,J Qt.w~n&6/~:Al3)MMso::;9pwIU}b#^P2)BbsGOr8S^H/|@<KHW6@V=T' );
define( 'LOGGED_IN_SALT',    'd)x{,@PYp@9IHy;85kclMiz8(rFaGx1l+[/-D829?&J@D9y))UMDJqHLZ6jDH{Za' );
define( 'NONCE_SALT',        '01I6ubEW2lew.68DM+4E$ZL73CP%h46P%Kk2C{Gda^+sk+C[I<ZFU}o00Ot0ceqj' );
define( 'WP_CACHE_KEY_SALT', '[A/h~4B5QRUpRDUMap{LALoqp5f=S5PQcR3PNfr[&)]&6@VTfq4G6n:N`q]Be2h[' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
