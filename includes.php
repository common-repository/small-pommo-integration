<?


/*
		OPTIONS
*/
$spi_default_options = array(
	'spi_host' => DB_HOST,
	'spi_database' => DB_NAME,
	'spi_table_prefix' => 'pommo_',
	'spi_login' => DB_USER,
	'spi_password' => DB_PASSWORD,
	'spi_field' => serialize( array() ),
	'spi_email_label' => 'Your E-Mail',
	'spi_submit_label' => 'Subscribe now!',
	'spi_pommo_url' => get_option( 'siteurl' ). '/pommo/',
	'spi_ajax_ok' => '<h1>Congrats!</h1><p>A validation Mail has been send to you! Please Click on the Confirmation Link in this Mail.</p>',
	'spi_ajax_error' => '<h1>Ooops!</h1><p>Something went wrong. (%s)</p>',
	'spi_ajax_loading' => '<img src="'. spi_plugin_url(). '/ajax-loader.gif" alt="Loading" title="Loading" /> Loading ..',
	'spi_formular_title' => 'Subscribe to Newsletter!'
);
$spi_serialized_options = array( 'spi_field' );
$spi_db = null;


/** spi_init_options
	read options or defaults if non..
*/
function spi_init_options( $resettable = false ) {
	global $spi_default_options, $spi_serialized_options;
	
	$options = array(); 
	foreach ( $spi_default_options as $n => $v ) {
		
		if ( $resettable && isset( $_GET[ 'reset' ] ) && $_GET[ 'reset' ] == 1 )
			delete_option( $n );
		
		// init default value for option
		add_option( $n, $v );
		
		// read current ootion
		$options[ $n ] = in_array( $n, $spi_serialized_options )
			? unserialize( get_option( $n ) )
			: stripslashes( get_option( $n ) )
		;
	}
	
	#print"<pre>";print_r( array( "OPTIONS" => $options ) );print"</pre>";
	
	return $options;
}

/** spi_save_options
	save all options from _POST
*/
function spi_save_options( $data ) {
	global $spi_default_options, $spi_serialized_options;
	
	#print '<pre>';print_r( $data );print '</pre>';
	
	$options = array();
	foreach ( $spi_default_options as $n => $v ) {
		if ( isset( $data[ $n ] ) )
			$options[ $n ] = in_array( $n, $spi_serialized_options )
				? serialize( $data[ $n ] ) 
				: trim( $data[ $n ] )
			;
		else
			$options[ $n ] = $v;
		
		update_option( $n, $options[ $n ] );
	}
	
	return $options;
}


/*
		POMMO DATA
*/

function spi_read_pommo_fields() {
	
	// init db
	$db = spi_database_connection();
	if ( is_null( $db ) ) return;
	
	// init options
	$options = spi_init_options();
	
	// read fields
	$fields = $db->get_results( $s = sprintf( 'SELECT * FROM `%sfields` ORDER BY `field_ordering` ASC, `field_name` ASC', $options[ 'spi_table_prefix' ] ), OBJECT );
	
	#print"<pre>";print_r( array( 'FIELDS' => $fields, 'Q' => $s ) );print"</pre>";
	
	return $fields;
}



/*
		MISC
*/

/** spi_plugin_path
	relative absolute path to plugin
*/
function spi_plugin_path() {
	return WP_CONTENT_DIR . '/plugins/' . plugin_basename( dirname(__FILE__) ) . '/';
}
function spi_plugin_url() {
	return get_option( 'siteurl' ). '/plugins/' . plugin_basename( dirname(__FILE__) ) . '/';
}
function spi_action_url() {
	return get_option( 'siteurl' ). '/wp-admin/admin.php?page='. dirname(__FILE__).'/admin-gui.php';
}

/** spi_database_connection
	creates database connection ..
*/
function spi_database_connection( $options = null ) {
	global $spi_db;
	
	// init spi_db
	if ( is_null( $spi_db ) ) {
		
		// read options ..
		if ( empty( $options ) ) $options = spi_init_options();
	
		$spi_db = new wpdb( $options[ 'spi_login' ], $options[ 'spi_password' ], $options[ 'spi_database' ], $options[ 'spi_host' ] );
	}
	
	return $spi_db->ready ? $spi_db : null;
}

/** spi_database_connection_ok
	checks the database connection and return bool true if ok
*/
function spi_database_connection_ok( $options = null ) {
	$db = spi_database_connection();
	return ! is_null( $db );
}


function spi_escape( $html ) {
	if ( is_array( $html ) ) {
		foreach ( $html as $k => $v )
			$html[ $k ] = spi_escape( $v );
		return $html;
	}
	return preg_replace( '/</', '&lt;',
		preg_replace( '/>/', '&gt;',
			preg_replace( '/&/', '&amp;', $html )
		)
	);
}
function spi_escape_js( $html ) {
	if ( is_array( $html ) ) {
		foreach ( $html as $k => $v )
			$html[ $k ] = spi_escape_js( $v );
		return $html;
	}
	return preg_replace( '/[\n\r]/', '', preg_replace( '/\'/', '\\', $html ) );
}


?>
