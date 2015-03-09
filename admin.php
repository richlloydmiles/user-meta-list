 <?php
global $wpdb;
$results = $wpdb->get_results( "SELECT `meta_key` FROM wp_usermeta");
 ?>
<div class="wrap">	
<h2>User Meta Field Profile Selection</h2>
 <select multiple="multiple" id="my-select" name="my-select[]">
 	<?php
foreach ($results as $key => $meta_value) {
	echo "<option value='elem_" . $key . "'>" . $meta_value->meta_key . "</option>";
}
 	?>
 </select>
<script>
var selectedArray = [];
jQuery(document).ready(function($) {
		jQuery('#my-select').multiSelect();
			jQuery(document).on('change', '#my-select', function(event) {
					$( ".ms-selected.ms-elem-selection" ).each(function( index ) {
	  					selectedArray.push($( this ).find('span').text());
		});
					jQuery('#hidden_array').val(selectedArray);
					selectedArray = [];
	});
});

</script>
	<form action="" method="POST">
		<input type="hidden" value="" id="hidden_array" name="hidden_array">
		<input type="submit" value="update" class="button button-primary" id="update">
	</form>

<?php
if (isset($_POST['hidden_array'])) {
	$array = explode(',', $_POST['hidden_array']);
	update_option( 'user_meta_fields', $array , '', 'yes' );
}
?>
</div>
<?php
		global $wpdb;
		$results = $wpdb->get_results( "SELECT `meta_key` , `meta_value` FROM wp_usermeta");
		echo '<h3>Custom User Meta Fields Example for current user</h3>';
		echo '<table class="form-table">';
		foreach ($results as $key => $result) {
			if (in_array($result->meta_key, get_option( 'user_meta_fields' ))) {
				if ($result->meta_value == 'false') {
					$result->meta_value = "";
				}
				echo '<tr>';
				echo '<th>' . $result->meta_key . '</th>';
				echo '<td><i>' . $result->meta_value . '</i></td>';
				echo '</tr>';
			}	
		}
		echo '</table>';


?>