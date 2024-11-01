<?php 

if( isset( $_REQUEST['xbooster_show']) ){

	$select_network = $_REQUEST['xbooster_show'];

}

if( isset($_POST['select_network'])  ){

	$select_network = $_POST['select_network'];
}

?>
<div id="post-body-content">


		<div id="stats" class="postbox" style="">
			<h3><span><?php _e('Social Profile Click Statistics','xboostersocial'); ?></span></h3>
			<div class="inside">
				<form id="network_select" name="network_select"  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" >
				<input type="hidden" name="doselect" value="yes" />
				<div class="form-field">
				<label for="select_network"><?php _e('Select Network to display stats','xboostersocial'); ?></label>
				<select id="select_network" name="select_network">
					
				<?php
					$networks = get_option('xbooster_social_plugin_share_ns');
					$networks_decoded = json_decode($networks);
					$selected = '';
					foreach ($networks_decoded as $key => $value) {
						if( isset( $select_network ) ){
							if( $key == $select_network ){

								$selected = ' selected="selected" ';
							} else {

								$selected = '';
							}

						}
						?>
						<option <?php echo $selected; ?> value="<?php echo $key; ?>"><?php echo $value->title; ?></option>
						<?php
					}
				 ?>
				</select>
				</div>
				<p class="submit"><input name="submit" id="submit" type="submit" value="<?php _e('Show Stats','xboostersocial'); ?>" class="button button-primary"/></p>
				</form>
			</div>
		</div>

		<?php
		if ( isset($_POST['doselect']) ){
			if ( $_POST['doselect'] == "yes") {
				if( isset($select_network) ){
		?>
			<div id="stats" class="postbox" style="">
			<h3><span><?php _e('Stats','xboostersocial'); ?></span></h3>
			<div class="inside">
				
<div style="padding:5px;">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	<thead>
		<tr>
			<th><?php _e('Title','xboostersocial'); ?></th>
			<th><?php _e('Social Network','xboostersocial'); ?></th>
			<th><?php _e('Click(s)','xboostersocial'); ?></th>
			<th><?php _e('Action','xboostersocial'); ?></th>
		</tr>
	</thead>
	<tbody>
<?php 
	
//
$args = array( 'posts_per_page' => 99999);
$allposts = get_posts( $args );

foreach ($allposts as $xb_post) {
	$xb_count = get_option('xbooster_social_plugin_sns_counter_'. $xb_post->ID . '_' . $select_network);

	$xb_post_link = get_permalink($xb_post->ID);
	if( $networks_decoded->$select_network->custom_icon != "" ){

						$display_icon = $networks_decoded->$select_network->custom_icon;
					} else {

						$display_icon = plugins_url( '../assets/images/'.$networks_decoded->$select_network->default_icon, __FILE__ );
					}
	?>

		<tr>
			<td><?php echo $xb_post->post_title ?></td>
			<td class="center"><img src="<?php echo $display_icon; ?>" style="width:16px;" /alt="<?php echo $select_network; ?>"></td>
			<td class="center"><?php echo $xb_count; ?></td>
			<td class="center"><a href="<?php echo $xb_post_link; ?>" target="_blank">view</a></td>
			
		</tr>


	<?php
}
?>

		
	
	</tbody>
	<tfoot>
		<tr>
			<th><?php _e('Title','xboostersocial'); ?></th>
			<th><?php _e('Social Network','xboostersocial'); ?></th>
			<th><?php _e('Click(s)','xboostersocial'); ?></th>
			<th><?php _e('Action','xboostersocial'); ?></th>
		</tr>
	</tfoot>
</table>
<br / >
<br />

				</div>
			</div>
			
		</div>

		<?php 
				} // select network set
			} // do select eq yes
		} // do select isset
		?>
</div>
