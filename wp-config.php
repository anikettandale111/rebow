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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'rebow' );

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

define( 'EXPIRATION_TIME_SECONDS', 2 * 3600 );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'G,Mubji+cxw<x*|hHn:}b?>RV3(vG[dkYCEgPIFNU!4M6`>i JK]p~Z+$ILuZmQU' );
define( 'SECURE_AUTH_KEY',  '|2Z<.iK!Z5EwKA=6kVw[j1+C~SvO{DB`S:k(>t,mlZfM,e{H.D(9t<MPdwceX28,' );
define( 'LOGGED_IN_KEY',    '`wCO^sumvw4aX}HxA7;  }z_!<$qM!Kj@_E_I2BX8@FA$Yb?aa/MWW0.nU9o:{<0' );
define( 'NONCE_KEY',        '}Ya?/a$v{T/0-RPC$3wfl/tzs_yuwbmAV<r-h,uS79%Cr3Rt.d]2}AV?/g|X13=3' );
define( 'AUTH_SALT',        'RxI{ip7G8qPKI!8P-|$wzxnXXbaIZu=w+/(PNE,bw9GI(E>^x%3b+h^I&b$%g33f' );
define( 'SECURE_AUTH_SALT', 'V%AOf:SDfI6Hc)Qgj,/q1*B~c:pfr^oY!IdOa}5`Crb)WW6+xW-DIckF5fG<j@K3' );
define( 'LOGGED_IN_SALT',   'pUj}Rm8[j+&bvH &Lg/^iI!pwPPuW}IC9E,1qkwFmL8$@/l*U&nCl<5,ck=l!4@o' );
define( 'NONCE_SALT',       'Fn(LogNbSBh9nr%?R+QB)b]BfQ+-?!Kl2:ab~L~:(A<kFz|R2qevzt-nEA!413+n' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
