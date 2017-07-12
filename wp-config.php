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
 //Added by WP-Cache Manager
//define('WP_CACHE', true); //Added by WP-Cache Manager
//define( 'WPCACHEHOME', '/home/domains/vol4/638/1310638/user/htdocs/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'tester');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'T!wFN&MfWWkvGE$!58');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
define('FS_METHOD','direct');
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'r2jzk/Jy;SN}$ N$5,@BS%@`WY(#cV&/{l/Fa(Utb0^5<^;[C$A4Wj O/ArKQDmQ');
define('SECURE_AUTH_KEY',  'lJRPw(>r>`yMk5AlFLN4zKJew|&LhVY_EIjnLDZ`*m.Fz8=k1ys7%JR}uLS5]x!3');
define('LOGGED_IN_KEY',    'Eh|pI_(!m(8QOECW6rIh{E> N(DYZ0-CV-s>o2jRhGp{Oa,>[i-:BTdU`^?U_;KX');
define('NONCE_KEY',        'FBx;<?bS)S4+w,ABw!0Md.WrW4[#p}<~~skh=$ q9nz]N|(Z@)Bh=bTi* ;=46Ao');
define('AUTH_SALT',        '.W{N.rS<W;85IbWN@g)FF|q;ojVPSQFvj7%RZ6v.F|]{S|+kSpl<PqV[nQyleJll');
define('SECURE_AUTH_SALT', '|iX3`Xr(qhaiw@+9EU4#)a^ydtkc=;,LR(1U6wT?+b;BB.Ea6#-@MEO{zG3={!3y');
define('LOGGED_IN_SALT',   'HZem2gmN>7lDU&+{j+|nR%)>0+KpL=C=]<%}I/;>9{oHQ/h2:See`/13@l,kKPi,');
define('NONCE_SALT',       '*8F5uW5f}532x>Nc3;%^cTxayVGephUOQtL+S>Hg1t6>g!LdZ2Lk;_6gXvt5aXRL');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);

define('WP_MEMORY_LIMIT', '256M');
define( 'WP_MAX_MEMORY_LIMIT', '256M' );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

