<div id="post-body">
	<div id="post-body-content">
<?php
// xbooster_social_plugin_share_ns

	$xbooster_admin_social_sharings = get_option('xbooster_social_plugin_share_ns'); 
	$xbooster_admin_social_sharings_decoded = json_decode($xbooster_admin_social_sharings);


	if( isset( $_POST['update_sns'] ) ){

		if( "yes" == $_POST['update_sns'] ){

			$stack = (array) $xbooster_admin_social_sharings_decoded;

			if ( isset($_POST['xbooster_ppe']) ){	

				$enabled_sns = $_POST['xbooster_ppe'];
			}

			if ( isset($_POST['xbooster_pci']) ){

				$customicon_sns = $_POST['xbooster_pci'];

				//print_r($customicon_sns);
			}

			foreach ($xbooster_admin_social_sharings_decoded as $key => $value) {

					if ( isset( $enabled_sns[$key] ) && $enabled_sns[$key] == "true"){

						$stack[$key]->is_enabled = "true";
					} else {

						$stack[$key]->is_enabled = "false";
					}

					if ( isset( $customicon_sns[$key] ) ){

						$stack[$key]->custom_icon = $customicon_sns[$key];
					} 

			}


			$xbooster_updated_sns_list = json_encode($stack);
							
			update_option('xbooster_social_plugin_share_ns', $xbooster_updated_sns_list);

			$xbooster_updated_sns_list_new = json_decode($xbooster_updated_sns_list);
								


		}

	}

	//print_r($xbooster_admin_social_sharings_decoded);

	$sscount = count((array)$xbooster_admin_social_sharings_decoded);

	$nonce = wp_create_nonce("xbooster_ajax_share_sort");
?>
		<div class="xbooster_admin_container">
			<h3><?php _e('Social Sharing','xboostersocial'); ?></h3>
			<div class="inside">
				<p class=""><?php _e('xBooster is currently supporting','xboostersocial'); ?> <?php echo $sscount; ?> <?php _e('social networks. Please be sure you have the <a href="http://www.themeforest.net?ref=acbaltaci" target="blank">latest version of the plugin</a> for get more networks. Check the boxes on the left of the 
				social network and click Save Settings button to update social sharing networks on your website. Also you can change the Social Network Icon too.','xboostersocial'); ?></p>
				<form name="xbooster_form_sns" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" >
				<input type="hidden" name="update_sns" value="yes" />
				<table  data-nonce="<?php echo $nonce; ?>" class="xbooster_ss_list">
					<tbody>
				<?php


				if( isset ( $xbooster_updated_sns_list_new ) ){

					$sn_items = $xbooster_updated_sns_list_new;
				} else {

					$sn_items = $xbooster_admin_social_sharings_decoded;
				}


				foreach ($sn_items as $key => $value) {

				
					if( $value->custom_icon != "" ){

						$display_icon = $value->custom_icon;
					} else {

						$display_icon = plugins_url( '../assets/images/'.$value->default_icon, __FILE__ );
					}

					if( "true" == $value->is_enabled ){


						$encheck = ' checked = "checked" ';
					} else {

						$encheck ='';
					}

					

				?>	<tr class="xbooster_ss_list_item" id="xbooster_item_<?php echo $key; ?>" style="cursor:move;">
						<td>

						<div id="xbooster_snpc_<?php echo "$key"; ?>">
						<h3><span><input  type="checkbox" name="xbooster_ppe[<?php echo $key; ?>]" value="true" id="<?php echo $key; ?>-ppe" <?php echo $encheck; ?>style="width:auto;"><img src="<?php echo $display_icon; ?>" alt="" style="height:12px;" /> <?php echo $value->title; ?></span></h3>
						<div class="inside">
								
								<div class="form-field">
									<label for="<?php echo $key; ?>-pci"><?php echo $value->title; ?> <?php _e('Custom Icon URL','xboostersocial'); ?></label>
									<input name="xbooster_pci[<?php echo $key; ?>]" id="<?php echo $key; ?>-pci" type="text" value="<?php echo $value->custom_icon; ?>" size="100" />
								</div>
							
					
						</div><!-- .inside -->
					</div> <!-- -->
				</td>
			</tr>
				<?php
				}
				?>
				</tbody>
				</table>
				<div style="clear:both;"></div>
				<p class="submit"><input name="submit" id="submit" type="submit" value="<?php _e('Save Settings','xboostersocial'); ?>" class="button button-primary"/></p>
				</form>
			</div><!-- .inside -->
		</div> <!-- .postbox -->


	</div><!-- #post-body-content -->
</div><!-- #post-body -->