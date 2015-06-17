<?php

/*--------------------------------------------------*/
/* Simple Background Manager > settings page
/*--------------------------------------------------*/

function vuzzu_sbm_admin_settings_view() {

  $post_types = get_post_types( '', 'names' );
  unset($post_types['attachment']);
  unset($post_types['revision']);
  unset($post_types['nav_menu_item']);

  $sbm_support_types = get_option('simple_background_manager_support_types',array('post','page'));

  ?>

    <div class="wrap sbm-settings">

      <form method="post" action="options.php">

        <?php settings_fields( 'sbm-settings-group' ); ?>
        <?php do_settings_sections( 'sbm-settings-group' ); ?>

        <h2> <?php _e('Simple Background Manager supporting post types','sbm_terms'); ?> </h2>

        <p> <?php _e('Below you can extend support for more post types:','sbm_terms'); ?> </p>

        <?php foreach($post_types as $pt_name) : ?>
          <div>
            <label style="margin:10px;display:block">
              <?php echo ucfirst($pt_name); ?>
              <input type="checkbox" name="simple_background_manager_support_types[]"
                   value="<?php echo $pt_name; ?>"
                   <?php if(is_array($sbm_support_types) && in_array($pt_name, $sbm_support_types) ) echo 'checked="checked"'; ?> />
            </label>
          </div>
        <?php endforeach; ?>

        <?php submit_button(); ?>

      </form>
    </div>

  <?php

}


/*--------------------------------------------------*/
/* Simple Background Manager > metabox view
/*--------------------------------------------------*/

function vuzzu_sbm_metabox_view() {

    global $post;
    $imageShow = '<img />';

    $background_manager_options = get_post_meta($post->ID, 'sbm_background_manager', true);

    $actual_bg_color 		= (isset($background_manager_options['color'])) 	 ? $background_manager_options['color'] : null;
    $actual_bg_img 			= (isset($background_manager_options['img'])) 		 ? $background_manager_options['img'] : null;
    $actual_bg_img_repeat	= (isset($background_manager_options['img_repeat'])) ? $background_manager_options['img_repeat'] : null;

    // If is set actual_bg_img and is_numeric turn it to url and get image sizes
    if( $actual_bg_img && @GetImageSize( $actual_bg_img ) ) {

      $imageShow = '<img src="'.$actual_bg_img.'" />';

      $res = GetImageSize( $actual_bg_img );
      $_image_size_desc  = __('Width:', 'sbm_terms') . $res[0] . 'px, ';
      $_image_size_desc .= __('Height:', 'sbm_terms') . $res[1] . 'px';

    }

  ?>

  <style>

  	#sbm-background-manager .inside { padding: 0; }
  	#sbm-background-manager .option { padding: 0 12px 0 10px; border-bottom: 1px solid #dfdfdf; }
  	#sbm-background-manager div.option:last-child {	border-bottom: 0;	}
  	.sbm_background_manager {	position: relative;	}
  	.sbm_background_manager input[type=text],
  	.sbm_background_manager select,
  	.sbm_background_manager button { margin-bottom: 15px; }
    .sbm_background_manager input.file { width: 50%; }
  	.sbm_background_manager span { line-height:40px; }
  	.sbm_background_manager button { float: right; margin-right: 0;	padding: 0 10px; line-height: 36px; }
  	.sbm_background_manager .image_show img {	margin-top: 10px;	}
  	.sbm_background_manager .image_show a.remove { float:right; margin-right: 10px;	color: #aa1313;	font-size: 15px; cursor: pointer; }
  	.sbm_background_manager .iris-picker {	margin-top: -5px;	margin-bottom: 10px; }
  	.sbm_background_manager .colorpicker a.picker_ok { top: 1px; left: 204px;	width: 55px; height: 40px; line-height: 40px;	}

  </style>

  <script>
    jQuery(function() {
    	jQuery(document).on('click', '.sbm_background_manager .image_show a.remove', function() {

    		var self = jQuery(this);
    		var imageShow = self.parents('.image_show');

    		imageShow.children('img').fadeOut();
    		imageShow.children('p').fadeOut(function() {
    			imageShow.html('');
    		});

    		imageShow.parents('.sbm_background_manager').find('input.file').val('');

    	});
    });
  </script>

  <!-- BACKGROUND MANAGER -->
  <div class="sbm_background_manager">

    <?php uz_color_picker_input(__('Background color:','sbm_terms'),'sbm_bg_color',$actual_bg_color); ?>

    <?php uz_file_input(__('Background image url:','sbm_terms'),'sbm_bg_img',$actual_bg_img); ?>

    <?php $repeatStates = array(''=>__('None','sbm_terms'), 'repeat'=>__('Repeat','sbm_terms'), 'repeat-x'=>__('Repeat horizontally','sbm_terms'), 'repeat-y'=>__('Repeat vertically','sbm_terms'));
    uz_select_input(__('Background image repeat','sbm_terms'),'sbm_bg_img_repeat',$actual_bg_img_repeat,$repeatStates,true); ?>

  </div>
  <!-- BACKGROUND MANAGER END -->

  <?php

}
