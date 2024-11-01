<div id="post-body">
	<div id="post-body-content">
		<?php 
			$xbooster_dis_op = get_option('xbooster_display_options'); 
			$xbooster_dis_op_decoded = json_decode($xbooster_dis_op);

			if ( isset( $_POST['update_do'] ) ) {

				if ( "yes" == $_POST['update_do'] ) {

					if ( isset ( $_POST['xbooster_sp_action'] ) ) {

						$xbooster_sp_action_text = $_POST['xbooster_sp_action'];
					
					}

					if ( isset ( $_POST['xbooster_sp_do_content'] ) ){

						$xbooster_sp_content_pos = $_POST['xbooster_sp_do_content'];
						
					}

					if ( isset ( $_POST['xbooster_sp_content_icon'] ) ) {

						$xbooster_sp_content_icon = $_POST['xbooster_sp_content_icon'];

					}

					if ( isset ( $_POST['xbooster_sp_do_overlay'] ) ) {

						$xbooster_sp_overlay_pos = $_POST['xbooster_sp_do_overlay'];

						
					}
					if ( isset ( $_POST['xbooster_sp_counter'] ) ) {

						$xbooster_sp_counter = $_POST['xbooster_sp_counter'];

					}


					if ( isset ( $_POST['xbooster_ss_action'] ) ) {

						$xbooster_ss_action_text = $_POST['xbooster_ss_action'];
						
					}

					if ( isset ( $_POST['xbooster_ss_do_content'] ) ){

						$xbooster_ss_content_pos = $_POST['xbooster_ss_do_content'];
						
					}

					if ( isset ( $_POST['xbooster_ss_content_icon'] ) ) {

						$xbooster_ss_content_icon = $_POST['xbooster_ss_content_icon'];

					}

					if ( isset ( $_POST['xbooster_ss_do_overlay'] ) ) {

						$xbooster_ss_overlay_pos = $_POST['xbooster_ss_do_overlay'];

						
					}
					if ( isset ( $_POST['xbooster_ss_counter'] ) ) {

						$xbooster_ss_counter = $_POST['xbooster_ss_counter'];

					}


					


					$stack = (array) $xbooster_dis_op_decoded;
					$stack['sp']->text 			= $xbooster_sp_action_text;
					$stack['sp']->content 		= $xbooster_sp_content_pos;
					$stack['sp']->content_icon 	= $xbooster_sp_content_icon;
					$stack['sp']->overlay 		= $xbooster_sp_overlay_pos;
					$stack['ss']->text 			= $xbooster_ss_action_text;
					$stack['ss']->content 		= $xbooster_ss_content_pos;
					$stack['ss']->content_icon 	= $xbooster_ss_content_icon;
					$stack['ss']->overlay 		= $xbooster_ss_overlay_pos;
					$stack['sp']->counter 		= $xbooster_sp_counter;
					$stack['ss']->counter 		= $xbooster_ss_counter;

					$xbooster_do_new = json_encode($stack);

					update_option('xbooster_display_options', $xbooster_do_new);

					$xbooster_dis_op_updated = json_decode($xbooster_do_new);	
				}
			}


			if ( isset ( $xbooster_dis_op_updated) ) {

				$xbooster_do_settings = $xbooster_dis_op_updated;

			} else {

				$xbooster_do_settings = $xbooster_dis_op_decoded;
			}

			if ( "both" == $xbooster_do_settings->sp->content ){

				$sp_content_checked_both 	= ' checked="checked" ';
				$sp_content_checked_before = '';
				$sp_content_checked_after 	= '';
				$sp_content_checked_none 	= '';

			} else if ( "after" == $xbooster_do_settings->sp->content ) {

				$sp_content_checked_both 	= '';
				$sp_content_checked_before = '';
				$sp_content_checked_after 	= ' checked="checked" ';
				$sp_content_checked_none 	= '';

			} else if ( "before" == $xbooster_do_settings->sp->content ){

				$sp_content_checked_both 	= '';
				$sp_content_checked_after 	= '';
				$sp_content_checked_before	= ' checked="checked" ';
				$sp_content_checked_none 	= '';

			} else {

				$sp_content_checked_both 	= '';
				$sp_content_checked_after 	= '';
				$sp_content_checked_before	= '';
				$sp_content_checked_none 	= ' checked="checked" ';

			}



			if ( "left" == $xbooster_do_settings->sp->overlay ){

				$sp_overlay_checked_left		= ' checked="checked" ';
				$sp_overlay_checked_right		= '';
				$sp_overlay_checked_none		= '';

			} else if ( "right" == $xbooster_do_settings->sp->overlay ) {

				$sp_overlay_checked_right		= ' checked="checked" ';
				$sp_overlay_checked_left		= '';
				$sp_overlay_checked_none		= '';

			} else {
				
				$sp_overlay_checked_none		= ' checked="checked" ';
				$sp_overlay_checked_left		= '';
				$sp_overlay_checked_right		= '';

			}



			if ( "both" == $xbooster_do_settings->ss->content ){

				$ss_content_checked_both 	= ' checked="checked" ';
				$ss_content_checked_before = '';
				$ss_content_checked_after 	= '';
				$ss_content_checked_none 	= '';

			} else if ( "after" == $xbooster_do_settings->ss->content ) {

				$ss_content_checked_both 	= '';
				$ss_content_checked_before = '';
				$ss_content_checked_after 	= ' checked="checked" ';
				$ss_content_checked_none 	= '';

			} else if ( "before" == $xbooster_do_settings->ss->content ){

				$ss_content_checked_both 	= '';
				$ss_content_checked_after 	= '';
				$ss_content_checked_before	= ' checked="checked" ';
				$ss_content_checked_none 	= '';

			} else {

				$ss_content_checked_both 	= '';
				$ss_content_checked_after 	= '';
				$ss_content_checked_before	= '';
				$ss_content_checked_none 	= ' checked="checked" ';

			}


			if ( "left" == $xbooster_do_settings->ss->overlay ){

				$ss_overlay_checked_left		= ' checked="checked" ';
				$ss_overlay_checked_right		= '';
				$ss_overlay_checked_none		= '';

			} else if ( "right" == $xbooster_do_settings->ss->overlay ) {

				$ss_overlay_checked_right		= ' checked="checked" ';
				$ss_overlay_checked_left		= '';
				$ss_overlay_checked_none		= '';

			} else {
				
				$ss_overlay_checked_none		= ' checked="checked" ';
				$ss_overlay_checked_left		= '';
				$ss_overlay_checked_right		= '';

			}



			if ( "yes" == $xbooster_do_settings->sp->counter ){

				$sp_counter_checked_yes		= ' checked="checked" ';
				$sp_counter_checked_no		= '';

			} else if ( "no" == $xbooster_do_settings->sp->counter ) {

				$sp_counter_checked_no		= ' checked="checked" ';
				$sp_counter_checked_yes		= '';

			} else {
				
				$sp_counter_checked_yes		= ' checked="checked" ';
				$sp_counter_checked_no		= '';
			}


			if ( "yes" == $xbooster_do_settings->ss->counter ){

				$ss_counter_checked_yes		= ' checked="checked" ';
				$ss_counter_checked_no		= '';

			} else if ( "no" == $xbooster_do_settings->ss->counter ) {

				$ss_counter_checked_no		= ' checked="checked" ';
				$ss_counter_checked_yes		= '';

			} else {
				
				$ss_counter_checked_yes		= ' checked="checked" ';
				$ss_counter_checked_no		= '';
			}

		?>

		<div class="postbox">
			<h3><?php _e('Display Settings','xboostersocial'); ?></h3>
			<div class="inside">
				<p class="howto"><?php _e('There are different options to display Social Network Profile Icons and Social Network Sharing Icons. Widgets, Shortcodes, PHP functions and Auto Placement. On this page you can choose the places to show icons based on wordpress content.','xboostersocial'); ?></p>
				<hr>
				<h3><?php _e('Auto Placement','xboostersocial'); ?></h3>
				<p class="howto"><?php _e('There are great ways to display icons on your pages. And these are fully customizable. ','xboostersocial'); ?></p>
				<form name="xbooster_form_do" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" >
				<input type="hidden" name="update_do" value="yes" />

					<div class="form-field">
						<label for="xbooster_sp_action"><h2><?php _e('Social Profile Text','xboostersocial'); ?></h2></label>
						<input name="xbooster_sp_action" id="xbooster_sp_action" type="text" value="<?php echo $xbooster_do_settings->sp->text; ?>" size="100" />
					</div>
					<hr>
					<div class="form-field">
						<p>Display Icons Before/After Content</p>
						<img src="<?php echo plugins_url( '../assets/images/contentbeforeafter.svg', __FILE__ ); ?>" style="float:left;height:100px;" alt="" />
						<input <?php echo $sp_content_checked_none;?> type="radio" name="xbooster_sp_do_content" value="none" style="width:auto;" ><?php _e('None','xboostersocial'); ?>  <br />
						<input <?php echo $sp_content_checked_before;?> type="radio" name="xbooster_sp_do_content" value="before" style="width:auto;" ><?php _e('Before','xboostersocial'); ?>	<br />
						<input <?php echo $sp_content_checked_after;?> type="radio" name="xbooster_sp_do_content" value="after" style="width:auto;" ><?php _e('After','xboostersocial'); ?>  <br />
						<input <?php echo $sp_content_checked_both;?> type="radio" name="xbooster_sp_do_content" value="both" style="width:auto;" ><?php _e('Before &amp; After','xboostersocial'); ?> <br />
						<div style="clear:both;"></div>
					</div>
					<div class="form-field">
						<label for="xbooster_sp_content_icon"><h2><?php _e('Icon Size (inlude px or em information too. ie: 32px)','xboostersocial'); ?></h2></label>
						<input name="xbooster_sp_content_icon" id="xbooster_sp_content_icon" type="text" value="<?php echo $xbooster_do_settings->sp->content_icon; ?>" size="100" />
					</div>
					<hr>
					<div class="form-field">
						<p><?php _e('Display Icons as Overlay','xboostersocial'); ?></p>
						<img src="<?php echo plugins_url( '../assets/images/overlay-left-right.svg', __FILE__ ); ?>" style="float:left;height:100px;" alt="" />
						<input <?php echo $sp_overlay_checked_none;?> type="radio" name="xbooster_sp_do_overlay" value="none" style="width:auto;" ><?php _e('None','xboostersocial'); ?>  <br />
						<input <?php echo $sp_overlay_checked_left;?> type="radio" name="xbooster_sp_do_overlay" value="left" style="width:auto;" ><?php _e('Left','xboostersocial'); ?>	<br />
						<input <?php echo $sp_overlay_checked_right;?> type="radio" name="xbooster_sp_do_overlay" value="right" style="width:auto;" ><?php _e('Right','xboostersocial'); ?>  <br />
						<div style="clear:both;"></div>
					</div>
					<hr>
					<div class="form-field">
						<p>Show Counter?</p>
						<input <?php echo $sp_counter_checked_yes;?> type="radio" name="xbooster_sp_counter" value="yes" style="width:auto;" ><?php _e('Yes','xboostersocial'); ?>  <br />
						<input <?php echo $sp_counter_checked_no;?> type="radio" name="xbooster_sp_counter" value="no" style="width:auto;" ><?php _e('No','xboostersocial'); ?>	<br />
						<div style="clear:both;"></div>
					</div>
					<hr>
					<br />
					
					<div class="form-field">
						<label for="xbooster_ss_action"><h2><?php _e('Social Sharing Text','xboostersocial'); ?></h2></label>
						<input name="xbooster_ss_action" id="xbooster_ss_action" type="text" value="<?php echo $xbooster_do_settings->ss->text; ?>" size="100" />
					</div>
					<hr>
					<div class="form-field">
						<p><?php _e('Display Icons Before/After Content','xboostersocial'); ?></p>
						<img src="<?php echo plugins_url( '../assets/images/contentbeforeafter.svg', __FILE__ ); ?>" style="float:left;height:100px;" alt="" />
						<input <?php echo $ss_content_checked_none;?> type="radio" name="xbooster_ss_do_content" value="none" style="width:auto;"><?php _e('None','xboostersocial'); ?>  <br />
						<input <?php echo $ss_content_checked_before;?> type="radio" name="xbooster_ss_do_content" value="before" style="width:auto;" ><?php _e('Before','xboostersocial'); ?> <br />
						<input <?php echo $ss_content_checked_after;?> type="radio" name="xbooster_ss_do_content" value="after" style="width:auto;" ><?php _e('After','xboostersocial'); ?>  <br />
						<input <?php echo $ss_content_checked_both;?> type="radio" name="xbooster_ss_do_content" value="both" style="width:auto;" ><?php _e('Before &amp; After','xboostersocial'); ?><br />
						<div style="clear:both;"></div>
					</div>
					<div class="form-field">
						<label for="xbooster_ss_content_icon"><h2><?php _e('Icon Size (inlude px or em information too. ie: 32px)','xboostersocial'); ?></h2></label>
						<input name="xbooster_ss_content_icon" id="xbooster_ss_content_icon" type="text" value="<?php echo $xbooster_do_settings->ss->content_icon; ?>" size="100" />
					</div>
					<hr>
					<div class="form-field">
						<p>Display Icons as Overlay</p>
						<img src="<?php echo plugins_url( '../assets/images/overlay-left-right.svg', __FILE__ ); ?>" style="float:left;height:100px;" alt="" />
						<input <?php echo $ss_overlay_checked_none;?> type="radio" name="xbooster_ss_do_overlay" value="none" style="width:auto;" ><?php _e('None','xboostersocial'); ?>  <br />
						<input <?php echo $ss_overlay_checked_left;?> type="radio" name="xbooster_ss_do_overlay" value="left" style="width:auto;" ><?php _e('Left','xboostersocial'); ?>	<br />
						<input <?php echo $ss_overlay_checked_right;?> type="radio" name="xbooster_ss_do_overlay" value="right" style="width:auto;" ><?php _e('Right','xboostersocial'); ?>  <br />
						<div style="clear:both;"></div>
					</div>
					<hr>
					<div class="form-field">
						<p><?php _e('Show Counter?','xboostersocial'); ?></p>
						
						<input <?php echo $ss_counter_checked_yes;?> type="radio" name="xbooster_ss_counter" value="yes" style="width:auto;" ><?php _e('Yes','xboostersocial'); ?>  <br />
						<input <?php echo $ss_counter_checked_no;?> type="radio" name="xbooster_ss_counter" value="no" style="width:auto;" ><?php _e('No','xboostersocial'); ?>	<br />
						<div style="clear:both;"></div>
					</div>
					<p class="submit"><input name="submit" id="submit" type="submit" value="Save Settings" class="button button-primary"/></p>
				</form>

			</div>
		</div>	
	</div>
</div>