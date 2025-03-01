<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'com_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'phqTWAm#+^ja9_8v9a/vKv}?TIVTQ=vOFt5*wP[^kN-;l+D[gRF!JNw f5)gAS[;' );
define( 'SECURE_AUTH_KEY',  'df=R/MrV61`/#z:/sqX!;c-d%r.e3Q !/P-r5/hjf<fVxEy51].nCiSMlFMi@jM,' );
define( 'LOGGED_IN_KEY',    'f7J=UukhysV4:d#:Bwz$lu63[psY8ypH<lZYa4$Oqat#(>tHjz$s)gx24gHEX#4/' );
define( 'NONCE_KEY',        'mL_t~+RCf`wPm[N|>`2>Q4>;-^qX)D}F8(_L8]B{pp9=oUtnIckPf,sr8c:B<C2S' );
define( 'AUTH_SALT',        '8iDz|^j;ZQ5=AemY& vI{yVcA 2i%1OOYhdjxM|zj7qIXulyM0*vZ`p@#L<$ypdD' );
define( 'SECURE_AUTH_SALT', '=:V[.%F]1{W*J/~|vW@{Xxr<w.e&8Sf>T2SHv%^^L|[wTaOy(hY^I:*p}_J8K*3.' );
define( 'LOGGED_IN_SALT',   'Uwcrv^un[_M1@t!]P@JK9]qlLcS/O00E+17i_y)Bse$4,K3VH@YGN;hj7?_)9t9o' );
define( 'NONCE_SALT',       'G:LKb@ilrV$x|eGXX:*/XvfZ2.-/ug?qF1!%zhz2eDB,4d,7 /NsEas@R`~u}[~g' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
