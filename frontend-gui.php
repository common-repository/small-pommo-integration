<?

$spi_ajax_script_been_printed = false;

function spi_print_pommo_form( $content = "", $args = array() ) {
	$options = spi_init_options();
	$id_prefix = (int)(rand()*99999) . '_';
	$fields = spi_read_pommo_fields();
	$action = preg_replace( '/\/+$/', '', $options[ 'spi_pommo_url' ] );
	
	$form = '<form class="spi-ajax-form" action="'. $action. '/user/process.php" method="post">
		<h2 class="spi-form-title">
			'. $options[ 'spi_formular_title' ]. '
		</h2>
		<label for="'. $id_prefix. 'email">
			'. $options[ 'spi_email_label' ]. '
		</label>
		<div class="spi-input spi-email">
			<input type="text" id="'. $id_prefix. 'email" name="Email" maxlength="60" value="" />
		</div>
	';
	
	if ( ! empty( $fields ) ) {
		foreach ( $fields as $field ) {
			$show = isset( $options[ 'spi_field' ][ $field->field_id ] )
				? $options[ 'spi_field' ][ $field->field_id ][ 'show' ]
				: 'n'
			;
			if ( $show == 'y' ) {
				$form .= spi_print_frontend_field(
					$field, $options[ 'spi_field' ][ $field->field_id ] );
			}
			elseif ( $show == 'd' ) {
				$value = $options[ 'spi_field' ][ $field->field_id ][ 'default' ];
				if ( $field->field_type == 'checkbox' )
					$value = $value == 'y' ? 'true' : 'false';
				$form .= '<input type="hidden" name="d['. $field->field_id. ']" value="'. $value. '" />';
			}
		}
	}
	$form .= '
		<div class="spi-submit">
			<input type="hidden" value="true" name="pommo_signup" />
			<input type="submit" name="pommo_signup" value="'. $options[ 'spi_submit_label' ]. '" />
		</div>
	</form>
	';
	
	return $form;

}

function spi_print_pommo_ajax_form( $content = "" ) {
	global $spi_ajax_script_been_printed;
	$options = spi_init_options();
	if ( ! $spi_ajax_script_been_printed ) {
		$spi_ajax_script_been_printed = true;
		$action = preg_replace( '/\/+$/', '', $options[ 'spi_pommo_url' ] ). '/admin/subscribers/ajax/manage.rpc.php';
		$form = '
<script type="text/javascript">
<!--
jQuery( function() {
	jQuery( \'.spi-ajax-container input[type=submit]\' ).click( function() {
		// collect form data
		var data = {}, form = jQuery( this ).parents( \'.spi-ajax-container\' ).find( \'form\' );
		form.find( \'input[type=submit],input[type=hidden],input[type=text],input[type=password],input[type=radio]:checked,input[type=checkbox]:checked,select,textarea\' ).each( function() {
			var $t = jQuery( this );
			var n = $t.attr( \'name\' ), v = $t.val();
			if ( data[ n ] !== undefined ) {
				if ( !( data[ n ] instanceof Array ) )
					data[ n ] = [ data[ n ] ];
				data[ n ].push( v )
			}
			else
				data[ n ] = v;
		} );
		
		// hide form ..
		jQuery( \'.spi-ajax-container form\' ).slideUp();
		
		// show loader
		jQuery( \'.spi-ajax-response-loader\' ).slideDown();
		
		// for the better ..
		data.no_redirect = 1;
		
		
		// send data ..
		jQuery.ajax( {
			url: form.attr( \'action\' ),
			data: data,
			dataType: \'text\',
			type: \'post\',
			success: function( result ) {
				result = jQuery( \'#alertmsg\', result ), data = { success: false, message: \'UNKNOWN\' };
				if ( result !== undefined && result.length == 1 ) {
					data.success = ! result.hasClass( \'error\' );
					data.message = result.text().replace( \'/^[\s\n\r]+/\', \'\' ).replace( \'/[\s\n\r]+/$\', \'\' );
				}
				
				// hide all responses.
				var responses = jQuery( \'.spi-ajax-response\' );
				responses.hide();
				
				// hide loader
				jQuery( \'.spi-ajax-loader\' ).slideUp();
				
				
				// determine success or error.. show form on error
				var show = \'error\', message = \'\';
				if ( data.success === true ) {
					show = \'ok\';
					message = \''. spi_escape_js( $options[ 'spi_ajax_ok' ] ). '\'.replace( \'/%s/\', data.message );
				}
				else {
					jQuery( \'.spi-ajax-container form\' ).slideDown();
					message = \''. spi_escape_js( $options[ 'spi_ajax_error' ] ) . '\'.replace( \'%s\', data.message );
				}
				
				jQuery( \'.spi-ajax-response-\'+ show ).html( message ).slideDown();
				return false;
			}
		} );
		return false;
	} );
} );
//.-->
</script>
		';
	}
	$form .= '
	<div class="spi-ajax-container">
		<div class="spi-ajax-loader" style="display: none">
			'. $options[ 'spi_ajax_loading' ]. '
		</div>
		<div class="spi-ajax-response spi-ajax-response-ok" style="display: none">
		</div>
		<div class="spi-ajax-response spi-ajax-response-error" style="display: none">
		</div>
	';
	$form .= spi_print_pommo_form( $content );
	$form .= '</div>';
	
	return $form;
}


function spi_print_frontend_field( $field, $opt ) {
	$field_html = '
		<label for="'. $id_prefix. 'field'. $field->field_id. '">
			'. $field->field_name. '
		</label>
		<div class="spi-input spi-'. $field->field_type. '">
	';
	
	switch ( $field->field_type ) {
		
		case 'checkbox':
			$field_html .= '
			<label>
				<input type="checkbox" name="d['. $field->field_id. ']" id="'. $id_prefix. 'field'. $field->field_id. '" value="1" />
				<span class="spi-field-comment">
					'. $field->field_prompt. '
				</span>
			</label>
			';
			break;
		
		case 'multiple':
			$array = unserialize( $field->field_array );
			$select_options = array();
			foreach ( $array as $arr )
				$select_options []= '<option '. ( $arr == $field->field_normally ? ' selected="selected"' : '' ). '>'. $arr. '</option>';
			$field_html .= '
			<select name="d['. $field->field_id. ']" id="'. $id_prefix. 'field'. $field->field_id . '">
				'. join( "", $select_options ). '
			</select>
			<span class="spi-field-comment">
				'. $field->field_prompt. '
			</span>
			';
			break;
		
		case 'input':
			$field_html .= '
			<input type="text" class="spi-input-text" name="d['. $field->field_id. ']" id="'. $id_prefix. 'field'. $field->field_id. '" value="'. $opt[ 'initial' ]. '" />
			<span class="spi-field-comment">
				'. $field->field_prompt. '
			</span>
			';
			break;
		
		case 'text':
			$field_html .= '
			<input type="text" class="spi-input-text" name="d['. $field->field_id. ']" id="'. $id_prefix. 'field'. $field->field_id. '" value="'. $opt[ 'initial' ]. '" />
			<span class="spi-field-comment">
				'. $field->field_prompt. '
			</span>
			';
			break;
		
		case 'number':
			$field_html .= '
			<input type="text" class="spi-input-number" name="d['. $field->field_id. ']" id="'. $id_prefix. 'field'. $field->field_id. '" value="'. $opt[ 'initial' ]. '" />
			<span class="spi-field-comment">
				'. $field->field_prompt. '
			</span>
			';
			break;
		default:
			$field_html .= '<h2>UNDEFINED FIELD TYPE "'.$field->field_type. '"</h2>';
			break;
		
	}
	
	$field_html .= '</div>';
	
	return $field_html;
}

?>
