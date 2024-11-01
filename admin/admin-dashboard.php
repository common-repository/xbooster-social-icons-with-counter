
<div id="post-body-content">


		<div id="postexcerpt" class="postbox" style="">
			<div class="handlediv" title="Click to toggle"><br></div>
			<h3 class="hndle"><span><?php _e('Social Profile Click Statistics','xboostersocial'); ?></span></h3>
			<div class="inside">


				<?php $xbooster_admin_social_profiles = get_option('xbooster_social_plugin_snps'); 
				$xbooster_admin_social_profiles_decoded = json_decode($xbooster_admin_social_profiles);
				$nonce_sp = wp_create_nonce("xbooster_ajax_profile_sort");
				?>
				<table class="wp-list-table widefat fixed posts xbooster_sp_list"  data-nonce="<?php echo $nonce_sp; ?>" c>
									
										<thead>
											<tr>
												<th  style="width:40px;"><?php _e('Icon','xboostersocial'); ?></th>
												<th><?php _e('Social Network','xboostersocial'); ?></th>
												<th><?php _e('Profile URL','xboostersocial'); ?></th>
												<th><?php _e('Status','xboostersocial'); ?></th>
												<th><?php _e('Clicks','xboostersocial'); ?></th>
											</tr>
										</thead>
										<tfoot>
											
									
				<?php
				$rclass = "1";
				foreach ($xbooster_admin_social_profiles_decoded as $key => $value) {

					if( $value->custom_icon != "" ){

						$display_icon = $value->custom_icon;
					} else {

						$display_icon = plugins_url( '../assets/images/'.$value->default_icon, __FILE__ );
					}

					if( $rclass == "1" ){ $rclass="2"; } else { $rclass="1"; };
					?>
					<tr id="xbooster_stat_snpc_<?php echo "$key"; ?>" class="xbooster_sp_list_item">
						<td style="width:40px;" class="xbooster_row<?php echo $rclass; ?>"><?php echo '<img src="' . $display_icon  . '" style="width:32px;" >'; ?></td>
						<td class="xbooster_row<?php echo $rclass; ?>"><?php echo $value->title; ?></td>
						<td class="xbooster_row<?php echo $rclass; ?>"><?php
							if( $value->profile_url == "" ) {

								echo 'Please enter <a href="'.admin_url( 'options-general.php?page=' . $this->settings_page_handle . '&tab=tab2' ).'#xbooster_snpc_'.$key.'">'.__('profile url','xboostersocial').'</a>';
							} else {
								echo '<a href="'.$value->profile_url.'" target="_blank">'.__('view','xboostersocial').'</a>';
							}
							?>
						</td>
						<td class="xbooster_row<?php echo $rclass; ?>">
						<?php
							if( $value->is_enabled == "false" ) {
								echo '<a href="'.admin_url( 'options-general.php?page=' . $this->settings_page_handle . '&tab=tab2' ).'#xbooster_snpc_'.$key.'">'.__('disabled','xboostersocial').'</a>';
							} else {

								echo __('enabled','xboostersocial');
							}
						?>
						</td>
						<td class="xbooster_row<?php echo $rclass; ?>"><?php
							echo '<p class="howto">'.get_option('xbooster_social_plugin_snp_counter_'.$key).' '.__('Clicks','xboostersocial').'<br />';
							?>
						</td>
					</tr>
				<?php
				}
				?>
					</tfoot>
				</table>
				<div style="clear:both;"></div>
			</div>
		</div>


	








	<div id="postexcerpt" class="postbox" style="">
			<div class="handlediv" title="Click to toggle"><br></div>
			<h3 class="hndle"><span><?php _e('Social Sharing Click Statistics','xboostersocial'); ?></span></h3>
			<div class="inside">


				<?php $xbooster_admin_social_shares = get_option('xbooster_social_plugin_share_ns'); 
				$xbooster_admin_social_shares_decoded = json_decode($xbooster_admin_social_shares);
				$nonce_ss = wp_create_nonce("xbooster_ajax_share_sort");
				?>
				<table class="wp-list-table widefat fixed posts xbooster_ss_list"  data-nonce="<?php echo $nonce_ss; ?>" c>
									
										<thead>
											<tr>
												<th style="width:40px;" ><?php _e('Icon','xboostersocial'); ?></th>
												<th><?php _e('Social Network','xboostersocial'); ?></th>
												<th><?php _e('Status','xboostersocial'); ?></th>
												<th><?php _e('Clicks','xboostersocial'); ?></th>
											</tr>
										</thead>
										<tfoot>
											
									
				<?php
				$rclass = "1";
				foreach ($xbooster_admin_social_shares_decoded as $key => $value) {

					if( $value->custom_icon != "" ){

						$display_icon = $value->custom_icon;
					} else {

						$display_icon = plugins_url( '../assets/images/'.$value->default_icon, __FILE__ );
					}

					if( $rclass == "1" ){ $rclass="2"; } else { $rclass="1"; };
					?>
					<tr id="xbooster_stat_snpc_<?php echo "$key"; ?>" class="xbooster_ss_list_item">
						<td style="width:40px;" class="xbooster_row<?php echo $rclass; ?>"><?php echo '<img src="' . $display_icon  . '" style="width:32px;" >'; ?></td>
						<td class="xbooster_row<?php echo $rclass; ?>"><?php echo $value->title; ?></td>
						<td class="xbooster_row<?php echo $rclass; ?>">
						<?php
							if( $value->is_enabled == "false" ) {
								echo '<a href="'.admin_url( 'options-general.php?page=' . $this->settings_page_handle . '&tab=tab2' ).'#xbooster_snpc_'.$key.'">'.__('disabled','xboostersocial').'</a>';
							} else {

								echo __('enabled','xboostersocial');
							}
						?>
						</td>
						<td class="xbooster_row<?php echo $rclass; ?>"><?php
							echo '<p class="howto"><a href="'.admin_url( 'options-general.php?page=' . $this->settings_page_handle . '&tab=tab5' ).'&xbooster_show='.$key.'">'.__('View Stats','xboostersocial').'</a>';
							?>
						</td>
					</tr>
				<?php
				}
				?>
					</tfoot>
				</table>
				<div style="clear:both;"></div>
			</div>
		</div>







	



</div> <!-- #post-body-content -->
