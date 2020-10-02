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
define( 'DB_NAME', 'Bridgebloging' );

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
define( 'AUTH_KEY',         'LM4KYhYX?TDU89:(~U&W%O$Am0Mg<x+^.@K*v$.XUleJ}5(eX`z5Qw]Xuvhu17xa' );
define( 'SECURE_AUTH_KEY',  '7l`NWE#V@E$+y!Z1R~!F|*735 A(HR-:<h6_duJl2%2<ZGF59vChsR1Pa83t 3My' );
define( 'LOGGED_IN_KEY',    '=52Cz*#Ou~[fXja=p.w;v/I]w(P1[dfdLbFz9_a)CL`c&<lJU87|,I!.~xNe$#.G' );
define( 'NONCE_KEY',        'R&9,B#%qi;)!b2f``GIwVeM:RzUoSh!34E]Z<6[!2C@`>3 0sV}/P#^1}[?.Zs`=' );
define( 'AUTH_SALT',        'aEE[wO%<^txo&?lRzX,#{48rVFfUS{r+S]q,Hp]<>+! 5pJn!O)Aw&LX-qC|>QQR' );
define( 'SECURE_AUTH_SALT', 'r3|UuJ22|xpJ~ Ux/$6q5+j%`72yWN*T;N!oX/hQs4uU7xyi^.HxB*@hY6_6~gvL' );
define( 'LOGGED_IN_SALT',   'DB>CbY3/~OaB>RP7kYotm4oV8rtwIyucl {a#<}4vN3D.@a)AY:M!uB%`E1Ij>B ' );
define( 'NONCE_SALT',       ':}Lv3~OxR6[qs0goj/?HRAM#RZLEwN d02qBt^lM/:<Iadyt[6c#|h aqPIlTOLD' );

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
