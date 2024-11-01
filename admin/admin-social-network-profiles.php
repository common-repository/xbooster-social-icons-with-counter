<div id="post-body">
	<div id="post-body-content">

		<div class="xbooster_admin_container">
			<h3><?php _e('Social Network Profiles','xboostersocial'); ?> <a href="#xbooster_snpc_new" class="add-new-h2"><?php _e('Add New','xboostersocial'); ?></a></h3>
			<div class="inside">
				<?php $xbooster_admin_social_profiles = get_option('xbooster_social_plugin_snps'); 
				$xbooster_admin_social_profiles_decoded = json_decode($xbooster_admin_social_profiles);

				/* Adding new social network */
				if( isset($_POST['xbooster_add_new_snp'])){
						$xbooster_add_new_snp = $_POST['xbooster_add_new_snp'];
						if( isset($xbooster_add_new_snp) && "yes" == $xbooster_add_new_snp ){
						
						/*
							Ceating new social profile but for this we need current profiles array and than add this new array to our array set. 
							but first checking required fields...
						*/
						if( isset($_POST["new-sp-id"]) ){
							$new_sp_id 		= $_POST['new-sp-id'];
						} else {
							$new_sp_id 		= null;
						}
						
						if( isset($_POST["new-sp-name"]) ){
							$new_sp_name 		= $_POST['new-sp-name'];
						} else {
							$new_sp_name 		= null;
						}

						if( isset($_POST["new-sp-icon"]) ){
							$new_sp_icon 		= $_POST['new-sp-icon'];
						} else {
							$new_sp_icon 		= null;
						}

						if( isset($_POST["new-sp-profile-url"]) ){
							$new_sp_purl 		= $_POST['new-sp-profile-url'];
						} else {
							$f_new_sp_purl 		= null;
						}

						if( isset($_POST["newenable"]) ){
							$new_sp_enable 		= $_POST['newenable'];
						} else {
							$new_sp_enable		= null;
						}
						
							

						if( ("" != $new_sp_id ) && ( "" != $new_sp_name ) && ( "" != $new_sp_icon ) &&  ( "" != $new_sp_purl ) ) {

							/* removing possible blank spaces and lowercase id */

							$new_sp_id_mod = str_replace(" ","",$new_sp_id);
							$new_sp_id_mod = strtolower($new_sp_id_mod);

							if( "true" != $new_sp_enable ){
								$new_sp_enable = "false";
							}
							/*
								$stack = array("orange", "banana");
								array_push($stack, "apple", "raspberry");
							*/

							$stack = (array) $xbooster_admin_social_profiles_decoded;

							//$stack =  get_object_vars($stack);;
							$new_spn =  array(
								$new_sp_id_mod		=> array( 'title'			=> $new_sp_name,
					             							  'default_icon'	=> $new_sp_icon,
					             							  'custom_icon'		=> $new_sp_icon,
					           								  'profile_url' 	=> $new_sp_purl,
					           								  'is_enabled'		=> $new_sp_enable
					            						)
								);
							
							
							
							$my_new_stack = $stack + $new_spn;
							//print_r($stack);
							
							$xbooster_updated_sn_list = json_encode($my_new_stack);
							//print_r($xbooster_updated_sn_list);
							
							$xbooster_updated_sn_list_new = json_decode($xbooster_updated_sn_list);


							//print_r($xbooster_updated_sn_list_new);
							update_option('xbooster_social_plugin_snps', $xbooster_updated_sn_list);
							
							//$obj = json_decode (json_encode ($stack), FALSE);
							

						} 
							
						}
					}

				/* Updating existing social network */
				if( isset( $_POST['update_sn'] )){

					if( "yes" == $_POST['update_sn'] ){

						if( isset($_POST['xbooster_update_sn']) ){

							$xbooster_update_me = $_POST['xbooster_update_sn'];

							if ( "" != $xbooster_update_me ){
								// we have the key of the social network to update.. get fields..
								
								// lets move our decoded object as an array 
								$stack = (array) $xbooster_admin_social_profiles_decoded;

								$param_purl = $xbooster_update_me ."-purl";
								$param_pci = $xbooster_update_me ."-pci";
								$param_ppe = $xbooster_update_me ."-ppe";

								if( isset ( $_POST[$param_purl] ) ){

									$xbooster_update_purl = $_POST[$param_purl];

									//we have a profile url.. lets update it on stack.									

									$stack[$xbooster_update_me]->profile_url = "$xbooster_update_purl";

									//print_r($stack[$xbooster_update_me]->profile_url);
								} else {

									 $xbooster_update_purl = null;
								}


								if( isset ( $_POST[$param_pci] ) ){

									$xbooster_update_pci = $_POST[$param_pci];
									$stack[$xbooster_update_me]->custom_icon = "$xbooster_update_pci";


								} else {

									$xbooster_update_pci = null;
								}


								if( isset ( $_POST[$param_ppe] ) ){

									$xbooster_update_ppe = $_POST[$param_ppe];
									if( "true" == $xbooster_update_ppe){
										$stack[$xbooster_update_me]->is_enabled = "true";

									} else {

										$stack[$xbooster_update_me]->is_enabled = "false";
									}

								} else {

									$xbooster_update_ppe = null;
									$stack[$xbooster_update_me]->is_enabled = "false";
								}

								
								$xbooster_updated_sn_list = json_encode($stack);
								//print_r($xbooster_updated_sn_list);
							
								update_option('xbooster_social_plugin_snps', $xbooster_updated_sn_list);

								$xbooster_updated_sn_list_new = json_decode($xbooster_updated_sn_list);
								//print_r($xbooster_updated_sn_list_new);

							}

						}

					}

				}

				/* Did we update any social network info or added new ? */
				if( isset ( $xbooster_updated_sn_list_new ) ){

					$sn_items = $xbooster_updated_sn_list_new;
				} else {

					$sn_items = $xbooster_admin_social_profiles_decoded;
				}

				/* create forms for each element */
				$nonce = wp_create_nonce("xbooster_ajax_profile_sort");
				?>
				<table  data-nonce="<?php echo $nonce; ?>" class="xbooster_sp_list">
									<tbody>
				<?php 
				foreach ($sn_items as $key => $value) {

					if( $value->custom_icon != "" ){

						$display_icon = $value->custom_icon;
					} else {

						$display_icon = plugins_url( '../assets/images/'.$value->default_icon, __FILE__ );
					}

					if( $value->is_enabled == "false"){

						$sm_checked = '';

					} else {

						$sm_checked = ' checked="checked" ';

					}

					?>
				
				<tr class="xbooster_sp_list_item" id="xbooster_item_<?php echo $key; ?>">
					<td>
					<div id="xbooster_snpc_<?php echo "$key"; ?>" class="xbooster_box_title">
						<form name="xbooster_form_<?php echo $key; ?>" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>"  class="validate">
						<h3><span><input <?php echo $sm_checked; ?> type="checkbox" name="<?php echo $key; ?>-ppe" value="true" id="<?php echo $key; ?>-ppe" style="width:auto;"><img src="<?php echo $display_icon; ?>" alt="" style="height:16px;" /> <?php echo $value->title; ?></span></h3>
						<div class="inside">
							
								<input type="hidden" name="update_sn" value="yes" />
								<input type="hidden" name="xbooster_update_sn" value="<?php echo $key; ?>" />
 								<div class="form-field form-required">
									<label for="<?php echo $key; ?>-purl"><?php echo $value->title; ?> <?php _e('Profile URL','xboostersocial'); ?></label>
									<input name="<?php echo $key; ?>-purl" id="<?php echo $key; ?>-purl" type="text" value="<?php echo $value->profile_url; ?>" size="100" aria-required="true">
								</div>
								<div class="form-field">
									<label for="<?php echo $key; ?>-pci"><?php echo $value->title; ?> <?php _e('Custom Icon URL (Please enter full URL of your custom icon for','xboostersocial'); ?> <?php echo $value->title; ?>)</label>
									<input name="<?php echo $key; ?>-pci" id="<?php echo $key; ?>-pci" type="text" value="<?php echo $value->custom_icon; ?>" size="100" />
								</div>
								<br />
								<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Update','xboostersocial'); ?> <?php echo $value->title; ?> Profile">
							   	
							</form>
						</div><!-- .inside -->
					</div> <!-- -->
					</td>
				</tr>
					<?php
				}
				?>

			</tbody>
		</table>



			</div> <!-- .inside -->

		</div>

		<hr >

		<div id="post-body-content">

			<div class="xbooster_admin_container">
				<div id="xbooster_snpc_new">
					<h3 class="hndle"><span><?php _e('Add New Social Network &amp; Profile','xboostersocial'); ?>  <a href="#xbooster_top" class="add-new-h2"><?php _e('Top','xboostersocial'); ?></a></span></h3>
					<div class="inside">
						<form name="xbooster_form_<?php echo $key; ?>" method="post" class="validate" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
							<input type="hidden" name="xbooster_add_new_snp" value="yes" />
							<div class="form-field form-required">
								<label for="new-sp-id"><?php _e('Social Network ID','xboostersocial'); ?> </label>
								<input name="new-sp-id" id="new-sp-id" type="text" value="" size="100" aria-required="true">
								<p class="howto"><?php _e('ID must be unique or will not work properly (only lowercase letters and numbers, no spaces or special chars)','xboostersocial'); ?></p>
							</div>
							<div class="form-field form-required">
								<label for="new-sp-name"><?php _e('Social Network Name','xboostersocial'); ?></label>
								<input name="new-sp-name" id="new-sp-name" type="text" value="" size="100" aria-required="true">
								<p>&nbsp;</p>
							</div>
							<div class="form-field form-required">
								<label for="new-sp-icon"><?php _e('Social Network Icon URL','xboostersocial'); ?></label>
								<input name="new-sp-icon" id="new-sp-icon" type="text" value="" size="100" aria-required="true">
								<p class="howto"><?php _e('http://yourdomain.com/full/url/of/yourimage.svg (all kind of images are acceptable)','xboostersocial'); ?></p>
							</div>	
							<div class="form-field form-required">
								<label for="new-sp-profile-url"><?php _e('Social Network Profile URL','xboostersocial'); ?></label>
								<input name="new-sp-profile-url" id="new-sp-profile-url" type="text" value="" size="100" aria-required="true">
								<p>&nbsp;</p>
							</div>		
							<div class="form-field form-required">
								<label for="newenable"><?php _e('Enable This Social Network?','xboostersocial'); ?></label>
								<input type="checkbox" name="newenable" value="true" id="newenable" style="width:auto;">
								<div class="locked-indicator"></div>
								<p>&nbsp;</p>
							</div>																		
							<p  id= "endof" class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Add New Social Network Profile','xboostersocial'); ?>"></p>
						</form>
					</div><!-- .inside -->
				</div> <!-- -->


			</div> <!-- .inside -->

		</div>

	</div> <!-- #post-body-content -->
</div> <!-- #post-body -->	