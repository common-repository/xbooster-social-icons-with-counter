<div  id="xbooster_top" class="wrap">
	<h2><?php _e('xBooster Social Plugin','xboostersocial'); ?></h2>
	<h2 class="nav-tab-wrapper">
				<a href="<?php echo admin_url( 'options-general.php?page=' . $this->settings_page_handle ) ?>" class="nav-tab <?php echo ( $tab == 'tab1' ) ? 'nav-tab-active' : '' ?>">
					<?php echo __( 'Dashboard', 'xboostersocial' ) ?>
				</a>
				<a href="<?php echo admin_url( 'options-general.php?page=' . $this->settings_page_handle . '&tab=tab2' ) ?>" class="nav-tab <?php echo ( $tab == 'tab2' ) ? 'nav-tab-active' : '' ?>">
					<?php echo __( 'Social Network Profiles', 'xboostersocial' ) ?>
				</a>
				<a href="<?php echo admin_url( 'options-general.php?page=' . $this->settings_page_handle . '&tab=tab3' ) ?>" class="nav-tab <?php echo ( $tab == 'tab3' ) ? 'nav-tab-active' : '' ?>">
					<?php echo __( 'Social Sharing', 'xboostersocial' ) ?>
				</a>
				<a href="<?php echo admin_url( 'options-general.php?page=' . $this->settings_page_handle . '&tab=tab4' ) ?>" class="nav-tab <?php echo ( $tab == 'tab4' ) ? 'nav-tab-active' : '' ?>">
					<?php echo __( 'Display Settings', 'xboostersocial' ) ?>
				</a>
				<a href="<?php echo admin_url( 'options-general.php?page=' . $this->settings_page_handle . '&tab=tab5' ) ?>" class="nav-tab <?php echo ( $tab == 'tab4' ) ? 'nav-tab-active' : '' ?>">
					<?php echo __( 'Sharing Stats', 'xboostersocial' ) ?>
				</a>
			</h2>
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<?php
				
 
				if ( $tab == 'tab1' ) {
					$this->settings_page_tab1();
				} else if ( $tab == 'tab2'){
					$this->settings_page_tab2();
				} else if( $tab == 'tab3') {

					$this->settings_page_tab3();
				} else if( $tab == 'tab4') {
					$this->settings_page_tab4();
				} else if( $tab == 'tab5') {
					$this->settings_page_tab5();
				} else {
					$this->settings_page_tab1();
				}

				$this->settings_page_sidebar(); 
				?>
			</div> <!-- .metabox-holder -->
<?php //$this->settings_page_sidebar(); ?>
		</div><!-- #posttuff -->	
		
</div> <!-- .wrap -->