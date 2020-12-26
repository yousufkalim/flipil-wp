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
define( 'DB_NAME', 'flipil' );

/** MySQL database username */
define( 'DB_USER', 'yousuf' );

/** MySQL database password */
define( 'DB_PASSWORD', 'KinG@KonG725' );

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
define( 'AUTH_KEY',         'Vm~18UzH;8RQ;NE7q4TLEGEYK`YOTIEh[<6ysrT`T-1C3`,:SNC{K>j#/`5nEU `' );
define( 'SECURE_AUTH_KEY',  'HJQNN4B7ds_U C#cGKNSq]l%a{g>6)qF{+yh_-HErt4[zG%_}>[&Efs^fwcP>Y?t' );
define( 'LOGGED_IN_KEY',    'P1EyB4Z]y{Erj}11E#/|+N*JDab( P&QO<,DPnsTM4ql/hp59yd$[kcxQMzJD~O5' );
define( 'NONCE_KEY',        'A}P?Me#O`YtRB-%!?c@|L{[2C`Rqr92ED6?s3:V&FYXf.`#~D(pKY)BN+_{jDbh}' );
define( 'AUTH_SALT',        '5l)BR4Jv^y#x),FX9T=_h,Q;xkv5WiyATp~2-<gU.#AQwXg2W)VqP5]J{)uk(*bm' );
define( 'SECURE_AUTH_SALT', 'v(yPUS^kc4xxi}y5c$LVJ!}tAK$5jN0D$7+O?Gm,Dz}&Tq&tpEMkX#}u-+#4Sdzs' );
define( 'LOGGED_IN_SALT',   'a(2t*$PPC+VlIKpB$>frH_TB?~G.qE@`W8ae).q~ 0ZBl2yQ?TbTc|>>`y13ISjG' );
define( 'NONCE_SALT',       'k&y{K}IRqF?6DROU[FVCLcM] CVP{e8~{sT1`+;WYbRqB`ko=SuNV:V<.Alrmhj+' );

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
