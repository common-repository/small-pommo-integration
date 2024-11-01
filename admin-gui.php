<?
include_once( 'includes.php' );

if ( !empty( $_POST ) && isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'save' )
	spi_save_options( $_POST );

$options = spi_escape( spi_init_options( true ) );
?>


<script type="text/javascript">
<!--
jQuery( function() {
	var listener = 'change';
	jQuery( '.handle-field input.show-radio' )[ listener ]( function() {
		var parent = jQuery( this ).parents( 'td' );
		var val = jQuery( this ).val();
		console.debug( jQuery( this ).attr( 'name' )+ ' = '+ val );
		parent.find( '.field-defaults' )[ val == 'd' ? 'show' : 'hide' ]();
		parent.find( '.field-show' )[ val == 'y' ? 'show' : 'hide' ]();
		
	} )
	jQuery( '.handle-field input.show-radio:checked' ).trigger( listener );
} );
//-->
</script>
<style type="text/css">
.spi-form {
}
.spi-form ul {
	list-style: inside square;
}
.spi-form .handle-field {
}
.spi-form .field-required,
.spi-form .field-show,
.spi-form .field-defaults {
	margin: 5px 0 0 20px;
}
.spi-form .field-required {
}
.spi-form .field-show {
}
.spi-form .field-defaults {

}
</style>
<form action="<?= spi_action_url() ?>" method="post" class="wrap spi-form">
	<input type="hidden" name="action" value="save" />
	<h2>Small Pommo Integration</h2>
	
	<h3>Pommo Database Connection</h3>
	<table style="border-bottom: 1px dashed #ccc; margin-bottom: 10px;" class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="spi_host">
						Database Host
					</label>
				</th>
				<td>
					<input type="text" name="spi_host" id="spi_host" value="<?= $options[ 'spi_host' ] ?>" class="regular-text"/>
					(default: localhost)
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="spi_database">
						Database Name
					</label>
				</th>
				<td>
					<input type="text" name="spi_database" id="spi_database" value="<?= $options[ 'spi_database' ] ?>" class="regular-text"/>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="spi_table_prefix">
						Database Table Prefix
					</label>
				</th>
				<td>
					<input type="text" name="spi_table_prefix" id="spi_table_prefix" value="<?= $options[ 'spi_table_prefix' ] ?>" class="regular-text"/>
					(default: pommo_)
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="spi_login">
						Database Login
					</label>
				</th>
				<td>
					<input type="text" name="spi_login" id="spi_login" value="<?= $options[ 'spi_login' ] ?>" class="regular-text"/>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="spi_password">
						Database Password
					</label>
				</th>
				<td>
					<input type="text" name="spi_password" id="spi_password" value="<?= $options[ 'spi_password' ] ?>" class="regular-text"/>
				</td>
			</tr>
		</tbody>
	</table>

<? if ( ! spi_database_connection_ok() ): ?>
	<h3 style="color: red">Please check/init your database connection and save</h3> 
<? else: ?>
	<h3>Pommo &lt;-&gt; Wordpress</h3>
	
	
	<h4>Pommo &amp; GUI Settings</h4>
	<table style="border-bottom: 1px dashed #ccc; margin-bottom: 10px;" class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="spi_pommo_url">
						URL to Pommo Installation
					</label>
				</th>
				<td>
					<input type="text" name="spi_pommo_url" id="spi_pommo_url" value="<?= $options[ 'spi_pommo_url' ] ?>" class="regular-text"/>
					(default: <?= get_option( 'siteurl' ) ?>/pommo/)
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="spi_email_label">
						Label for E-Mail Input
					</label>
				</th>
				<td>
					<input type="text" name="spi_email_label" id="spi_email_label" value="<?= $options[ 'spi_email_label' ] ?>" class="regular-text"/>
					(default: Your E-Mail)
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="spi_submit_label">
						Label for Submit Button
					</label>
				</th>
				<td>
					<input type="text" name="spi_submit_label" id="spi_submit_label" value="<?= $options[ 'spi_submit_label' ] ?>" class="regular-text"/>
					(default: Subscribe now!)
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="spi_formular_title">
						Formular Title
					</label>
				</th>
				<td>
					<input type="text" name="spi_formular_title" id="spi_formular_title" value="<?= $options[ 'spi_formular_title' ] ?>" class="regular-text"/>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="spi_pommo_url">
						AJAX Loading
					</label>
				</th>
				<td>
					<textarea style="width: 80%; height: 100px" name="spi_ajax_loading" id="spi_ajax_loading" class="regular-text"><?= $options[ 'spi_ajax_loading' ] ?></textarea>
					<br />
					(Only required if you use the AJAX Form.. Feel free to use HTML)
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="spi_pommo_url">
						AJAX Success Message
					</label>
				</th>
				<td>
					<textarea style="width: 80%; height: 100px" name="spi_ajax_ok" id="spi_ajax_ok" class="regular-text"><?= $options[ 'spi_ajax_ok' ] ?></textarea>
					<br />
					(Only required if you use the AJAX Form, use "%s" for the Pommo provided Success Message.. Feel free to use HTML)
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="spi_pommo_url">
						AJAX Error Message
					</label>
				</th>
				<td>
					<textarea style="width: 80%; height: 100px" name="spi_ajax_error" id="spi_ajax_error" class="regular-text"><?= $options[ 'spi_ajax_error' ] ?></textarea>
					<br />
					(Only required if you use the AJAX Form, use "%s" for the Pommo provided Error.. Feel free to use HTML)
				</td>
			</tr>
		</tbody>
	</table>
	
	
	
	<h4>Field Settings</h4>
	<? $fields = spi_read_pommo_fields(); ?>
	
	<? if ( empty( $fields ) ): ?>
	<h4 style="color: red">
		OOops! No Fields found ?! Either you really have not created any field or your "Database Table Prefix" (above) is incorrect ?
	</h4>
	<? else: ?>
	<p>
		You can decide now which fields are
		<ul>
			<li>
				Default enabled for any user subscribing through this plugin
			</li>
			<li>
				Default disabled for any user subscribing through this plugin
			</li>
			<li>
				Visual choosable in the subscription form generated by the plugin
			</li>
		</ul>
	</p>
	
	<table style="border-bottom: 1px dashed #ccc; margin-bottom: 10px;" class="form-table">
		<tbody>
	<? foreach ( $fields as $field ) : ?>
			<tr>
				<th scope="row">
					<label for="spi_field_<?= $field->field_id ?>">
						<?= $field->field_name ?>
						<br />
						<span style="font-size: x-small">
							(<?= $field->field_type ?>)
						</span>
					</label>
				</th>
				<td>
					<?= build_field( $field, $options ) ?>
				</td>
			</tr>
	<? endforeach; ?>
		</tbody>
	</table>
	
	<? endif; ?>
	
<? endif; ?>

	<p class="submit">
		<input type="submit" name="submit" value="Save all &raquo;" />
	</p>
	<?
	//print"<pre>";print_r( $options );print"</pre>";
	?>

</form>

<?

function build_field( $field, $options ) {
	
	$o = (object)( isset( $options[ 'spi_field' ] ) && isset( $options[ 'spi_field' ][ $field->field_id ] )
		? $options[ 'spi_field' ][ $field->field_id ]
		: array(
			'show' => 'n', 
			'default' => $field->field_normally,
			'initial' => $field->field_normally,
			'required' => $field->field_required != 'off' ? 'y' : 'n'
		)
	);
	#print"<pre>";print_r( $o );print"</pre>";
	
	
	$check_handle = array(
		'y' => $o->show == 'y' ? ' checked="checked"' : '',
		'n' => $o->show == 'n' ? ' checked="checked"' : '',
		'd' => $o->show == 'd' ? ' checked="checked"' : '',
	);
	$string_handle = <<<DEFAULT
			<div class="handle-field">
				<label>
					<input type="radio" class="show-radio" name="spi_field[{$field->field_id}][show]" value="y" {$check_handle['y']} />
					Show in Form
				</label>
				<label>
					<input type="radio" class="show-radio" name="spi_field[{$field->field_id}][show]" value="n" {$check_handle['n']} />
					Dont show in Form
				</label>
				<label>
					<input type="radio" class="show-radio" name="spi_field[{$field->field_id}][show]" value="d" {$check_handle['d']} />
					Set always &hellip;
				</label>
			</div>
DEFAULT;

	$check_required = array(
		'y' => $o->required == 'y' ? ' checked="checked"' : '',
		'n' => $o->required != 'y' ? ' checked="checked"' : ''
	);
	$string_required = <<<REQUIRED
				<div class="field-required">
					<label>
						<input type="radio" name="spi_field[{$field->field_id}][required]" value="y" {$check_required['y']} />
						is Required
					</label>
					<label>
						<input type="radio" name="spi_field[{$field->field_id}][required]" value="n" {$check_required['n']}  />
						is Optional
					</label>
				</div>
REQUIRED;
	// CAUTION: right now no required support ..
	$string_required = '';
	
	switch ( $field->field_type ) {
		
		
		case "checkbox":
			$check_default = array(
				'y' => $o->default == 'y' ? ' checked="checked"' : '',
				'n' => $o->default != 'y' ? ' checked="checked"' : ''
			);
			return <<<FIELD
				$string_handle
				<div class="field-defaults">
					Set always: 
					<label>
						<input type="radio" name="spi_field[{$field->field_id}][default]" value="y" {$check_default['y']} />
						On
					</label>
					<label>
						<input type="radio" name="spi_field[{$field->field_id}][default]" value="n" {$check_default['n']} />
						Off
					</label>
				</div>
FIELD;
			break;
		
		case "multiple":
			
			$array = unserialize( $field->field_array );
			$field_options = array();
			foreach ( $array as $opt ) {
				// currently selected:
				if ( $opt == $o->default )
					$options []= '<option selected="selected">';
				else
					$field_options []= '<option>';
				$field_options []= $opt. '</option>';
			}
			$field_options   = join( "\n", $field_options );
			$default_options = join( ", ", $array );
			
			return <<<FIELD
				$string_handle
				<div class="field-show">
					Options: $default_options<br />
					<strong>Default: {$field->field_normally}</strong>
					$string_required
				</div>
				<div class="field-defaults">
					<select name="spi_field[{$field->field_id}][default]">
						$field_options
					</select>
				</div>
FIELD;
			break;
		
		
		case "text":
			return <<<FIELD
				$string_handle
				<div class="field-show">
					<label for="spi_field_initial_{$field->field_id}">
						Initial Value
					</label>
					<input type="text" class="text" value="{$o->initial}" id="spi_field_initial_{$field->field_id}" name="spi_field[$field->field_id][initial]" />
				</div>
				<div class="field-defaults">
					<label for="spi_field_default_{$field->field_id}">
					Set always:
					</label>
					<input type="text" class="text" value="{$o->default}" id="spi_field_default_{$field->field_id}" name="spi_field[$field->field_id][default]" />
				</div>
FIELD;
			break;
		
		
		case "number":
			return <<<FIELD
				$string_handle
				<div class="field-show">
					<label for="spi_field_initial_{$field->field_id}">
						Initial Value
					</label>
					<input type="text" class="number" value="" id="spi_field_initial_{$field->field_id}" name="spi_field[$field->field_id][initial]" />
				</div>
				<div class="field-defaults">
					<label for="spi_field_default_{$field->field_id}">
					Set always:
					</label>
					<input type="text" class="number" value="{$o->initial}" id="spi_field_default_{$field->field_id}" name="spi_field[$field->field_id][default]" />
				</div>
FIELD;
			break;
		
		default:
			return "Sorry, unhandled Fieldtype '". $field->field_type. "'";
			break;
		
	}
}








?>

