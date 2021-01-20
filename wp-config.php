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
define( 'DB_NAME', 'woo_wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'Is?4Klsrnp_m1nqr~M?B#ySUi=@&h+kfORZXZQ*x0@?bf@6en9Gk;!q[?S<9}b%3' );
define( 'SECURE_AUTH_KEY',  'P#i]jPd7(|@#P|[pm4&ZlT3Q5^rTfCkq+QllC7u9N-MCb44.z&axOj,Eo`0|QR9]' );
define( 'LOGGED_IN_KEY',    'w,]Z%NI6Qph3Dz;7GjlTtahM/r.cPYG%SB2|zrQ3/Sx3QV;O5<xDt2sfS%][nwN;' );
define( 'NONCE_KEY',        '=~2a<iJniNPjm#q?@fc,S;r+Y2,Z^iyr~iEkoX% //W28M*z6y8^b#Y~W,;CP|{x' );
define( 'AUTH_SALT',        '3qxA]X&(m;:_QW0)AYl^y|J1&*!J;~4LK*0jg$9m*j5/$H6UXkx#(Ak#hx=#QA,z' );
define( 'SECURE_AUTH_SALT', 'Z6J?a{D,(C)>;<ZfN1^[ku/*Bix?*0lFUR>e3yYX;`AWMV/IsTzek7Ti)n:HyNMk' );
define( 'LOGGED_IN_SALT',   ',p325_qVB&TO1k;8jKov)3fyKr{+A6ozvE_73h2j60KgqYr|Z?B0@3 @&TvnjI2`' );
define( 'NONCE_SALT',       ';un|IHgMKyqf@.~FzH=?X:~f[MfQNvL9AWi=5G;-$)Xjg<,OE_:cAOHgjy-yM7{w' );

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
