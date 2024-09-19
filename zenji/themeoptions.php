<?php
// 	force UTF-8 Ø
require_once(dirname(__FILE__) . '/functions.php');

class ThemeOptions {
	function __construct() {
		$me = basename(dirname(__FILE__));
		
		// set core theme option defaults
		setThemeOptionDefault('albums_per_row', 2);
		setThemeOptionDefault('albums_per_page', 6);
		setThemeOptionDefault('images_per_row', 4);
		setThemeOptionDefault('images_per_page', 20);
		setThemeOptionDefault('image_size', 650);
		setThemeOptionDefault('image_use_side', 'longest');
		setThemeOptionDefault('thumb_size', 150);
		setThemeOptionDefault('thumb_crop_width', 150);
		setThemeOptionDefault('thumb_crop_height', 150);
		setThemeOptionDefault('thumb_crop', 0);
		setThemeOptionDefault('thumb_transition', 1);
		
		// set active pages for colorbox if used
		setOptionDefault('colorbox_' . $me . '_album', 1);
		setOptionDefault('colorbox_' . $me . '_image', 1);
		setOptionDefault('colorbox_' . $me . '_search', 1);
		setOptionDefault('colorbox_' . $me . '_favorites', 1);
		
		// set active page for boxslider if used
		setOptionDefault('bxslider_' . $me . '_image', 1);
		
		// set custom theme option defaults
		setThemeOptionDefault('zj_logo', '');
		setThemeOptionDefault('zj_style', 'modern');
		setThemeOptionDefault('zj_color', 'light');
		setThemeOptionDefault('zj_linkcolor', '#008ed6');
		setThemeOptionDefault('zj_maxwidth', '960');
		setThemeOptionDefault('zj_albumthumb', 'landscape');
		setThemeOptionDefault('zj_download', true);
		setThemeOptionDefault('zj_imagemeta', true);
		setThemeOptionDefault('zj_customcss', '');
		setThemeOptionDefault('zj_search', true);
		setThemeOptionDefault('zj_archive', true);
		setThemeOptionDefault('zj_social', true);
		setThemeOptionDefault('zj_copy', '© '.date("Y"));
		
		// set image sizes for cach manager if used
		if (class_exists('cacheManager')) {
			cacheManager::deleteCacheSizes($me);
			cacheManager::addDefaultThumbSize();
			cacheManager::addDefaultSizedImageSize();
			$thumb_wmk = getOption('Image_watermark') ? getOption('Image_watermark') : null;
			$customthumbwidth = (getThemeOption('zj_maxwidth')) / (getThemeOption('albums_per_row'));
			$customthumbheight = $customthumbwidth / 2;
			$img_effect = getThemeOption('image_gray') ? 'gray' : null;
			if (getThemeOption('zj_albumthumb') == 'square') {
				cacheManager::addCacheSize($me, NULL, $customthumbwidth, $customthumbwidth, $customthumbwidth, $customthumbwidth, NULL, NULL, NULL, $thumb_wmk, $img_effect, false);
			} else if (getThemeOption('zj_albumthumb') == 'landscape') {
				cacheManager::addCacheSize($me, NULL, $customthumbwidth, $customthumbheight, $customthumbwidth, $customthumbheight, NULL, NULL, NULL, $thumb_wmk, $img_effect, false);
			} else {
				cacheManager::addDefaultThumbSize();
			}
			if (extensionEnabled('bxslider_thumb_nav')) {
				cacheManager::addCacheSize($me, NULL, getOption('bxslider_width'), getOption('bxslider_height'), getOption('bxslider_cropw'), getOption('bxslider_croph'), NULL, NULL, NULL, $thumb_wmk, $img_effect, false);
			}
		}
	}
	
	function getOptionsDisabled() {
		return array('custom_index_page');
	}
	
	function getOptionsSupported() {
		return array(	
			gettext('Logo') => array('key' => 'zj_logo', 'type' => OPTION_TYPE_CUSTOM, 
				'order' => 1, 
				'desc' => sprintf(gettext('Select a logo (files in the <em>%s</em> folder) or select to use a text logo of your gallery name. You can use the built in file uploader in Zenphoto to upload your logo file and then select it here.'),UPLOAD_FOLDER)),
			gettext('Style') => array('key' => 'zj_style', 'type' => OPTION_TYPE_SELECTOR, 
				'order' => 2,
				'selections' => array(
					gettext('Classic') => 'classic', 
					gettext('Minimal') => 'minimal', 
					gettext('Modern') => 'modern'), 
				'desc' => gettext("Select the base style. You can always add custom css declarations below.")),
			gettext('Color') => array('key' => 'zj_color', 'type' => OPTION_TYPE_RADIO, 
				'order' => 2.1,
				'buttons' => array(gettext('Light')=>'light', gettext('Dark')=>'dark'),
				'desc' => gettext("Select the base color, either light or dark. You can always add custom css declarations below.")),
			gettext('Link Color') => array('key' => 'zj_linkcolor', 'type' => OPTION_TYPE_COLOR_PICKER,
				'order'=>2.2, 
				'multilingual' => 0,
				'desc' => gettext('You can override the primary link color by setting it here. The default is a bright blue, #008ed6. You can also type the hex color directly in the square.')),
			gettext('Max Width of Site') => array('key' => 'zj_maxwidth', 'type' => OPTION_TYPE_TEXTBOX, 
				'order'=>3, 
				'multilingual' => 0,
				'desc' => gettext('Set the max-width of site in pixels.  Site is fluid but will not expand beyond this width.')),
			gettext('Custom Album Thumb') => array('key' => 'zj_albumthumb', 'type' => OPTION_TYPE_SELECTOR,
				'order' => 4, 
				'selections' => array(
					gettext('Landscape') => 'landscape', 
					gettext('Square') => 'square', 
					gettext('Use Thumb Settings') => 'usethumb'), 
				'desc' => gettext('Select to use a different crop for the album thumbs.')),
			gettext('Download Link') => array('key' => 'zj_download', 'type' => OPTION_TYPE_CHECKBOX,
				'order' => 5, 
				'desc' => gettext('Select to show a download link of original image on the image detail page. For a save dialog, you must set the download option in image options->protected view.')),	
			gettext('Image Metadata') => array('key' => 'zj_imagemeta', 'type' => OPTION_TYPE_CHECKBOX, 
				'order' => 6, 
				'desc' => gettext('Select whether to show image metadata on the image detail page. Which metadata items to show can be selected in the "Image" Options page.')),
			gettext('Custom CSS') => array('key' => 'zj_customcss', 'type' => OPTION_TYPE_TEXTAREA, 
				'order'=>7, 
				'multilingual' => 0,
				'desc' => gettext('Enter any custom CSS, safely carries over upon theme upgrade. Will be placed between style tags in the head.')),
			gettext('Search') => array('key' => 'zj_search', 'type' => OPTION_TYPE_CHECKBOX, 
				'order' => 8,
				'desc' => gettext("Check to enable search function.")),
			gettext('Archive') => array('key' => 'zj_archive', 'type' => OPTION_TYPE_CHECKBOX, 
				'order' => 8.1,
				'desc' => gettext("Check to enable archive view.")),
			gettext('Copyright Text') => array('key' => 'zj_copy', 'type' => OPTION_TYPE_TEXTBOX, 
				'order'=>10, 
				'multilingual' => 0,
				'desc' => gettext('Edit text for footer copyright. Leave blank to omit.'))			
		);
	}
	
	function handleOption($option, $currentValue) {
		// handles logo option, scans files for selectbox
		if($option == "zj_logo") { ?>
			<select id="zj_logo" name="zj_logo">
				<option value=""><?php echo gettext('*Use Gallery Name Text'); ?></option>';
				<?php generateListFromFiles($currentValue, SERVERPATH.'/'.UPLOAD_FOLDER,''); ?>
			</select>	
		<?php }
	}
}
?>
