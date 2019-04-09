<?php

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}


/**
 * 
 */

 /** Maximum base pair size which can be downloaded from NCBI sequences */
define( 'MAX_DOWNLOAD_SIZE', 500000000 );
define( 'MAX_DOWNLOAD_SIZE_STRING', '500 Mbp (500,000,0000 base pairs)' );

/** Maximum number of base pairs which can be searched */
define( 'MAX_SEARCH_SIZE', 500000000 );
define( 'MAX_SEARCH_SIZE_STRING', '500 Mbp (500,000,0000 base pairs)' );


/**
 * MySQL settings
 */

/** The name of the database */
define( 'DB_NAME', 'structure_finder_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. */
define( 'DB_COLLATE', '' );
