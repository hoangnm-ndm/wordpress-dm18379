<?php
function layers_theme_setup(){
	if ( ! isset( $content_width ) ) $content_width = 900;
	if ( is_singular() ) wp_enqueue_script( "comment-reply" );
	add_theme_support( 'automatic-feed-links' );
	load_theme_textdomain('layers');
}
add_action( 'after_theme_setup' , 'layers_theme_setup' );
function layers_add_sidebars(){
	if ( function_exists('register_sidebar') )
	register_sidebar(array(
	        'name' => 'Sidebar',
	        'before_widget' => '',
	        'after_widget' => '',
	        'before_title' => '<h3>',
	        'after_title' => '</h3>',
		));
	if ( function_exists('register_sidebar') )
	register_sidebar(array(
	        'name' => 'Footer',
	        'before_widget' => '<ul class="block"><li>',
	        'after_widget' => '</li></ul>',
	        'before_title' => '<h3>',
	        'after_title' => '</h3>',
		));
}
add_action( 'widgets_init' , 'layers_add_sidebars' );

class Layers{
	var $style;
	var $version;
	var $date;

	function get_style(){
		$this->style = get_option('layers_style');
	}


}

//Admin panel adapted from the hemingwayEx theme http://www.nalinmakar.com/hemingwayex/

$layers = new Layers();
$layers->version = "1.1.0";
$layers->date = "2008-08-19"; //The date when the current update was released
// Default Options. Used only when layers is not installed or a newer version is available
$default_options = Array(
	'width' => 'fluid',
	);// Taken as an array, as I plan to include more options in the future versions of Layers


if (!get_option('layers_version') || get_option('layers_version') < $layers->version){
	// Layers isn't installed, so we'll need to add options
	if (!get_option('layers_version') )
		add_option('layers_version', $layers->version, 'Layers Version installed');
	else
		update_option('layers_version', $layers->version);

	if (!get_option('layers_last_updated') )
		add_option('layers_last_updated', '0000-00-00', 'Last date Layers was checked for an update');

	if (!get_option('layers_known_update') )
		add_option('layers_known_update', '0000-00-00', 'Last known date when Layers update was released');

	$style_sheet = get_stylesheet_uri();

	if (!get_option('layers_style') ){
		add_option('layers_style', $style_sheet, 'Location of custom style sheet');
	}

	if (!get_option('layers_options') ) {
		add_option('layers_options', $default_options, 'Default options for Layers');
	}

	wp_cache_flush(); // I was having caching issues
}

// Stuff
add_action ('admin_menu', 'layers_menu'); //We invoke layers_menu function when admin_menu action takes place
$layers_loc = '../themes/' . basename(dirname('layers'));
$layers_options = get_option('layers_options'); //Retrieves stored options from database
$layers_last_updated = get_option('layers_last_updated'); //The last known date when Layers was checked for an update
$layers->get_style(); //$layers->style is loaded with the layers_style stored in the database


function layers_message($message) {
	echo "<div id=\"message\" class=\"updated fade\"><p>$message</p></div>\n";
}

function layers_update_version() {
	global $layers;
	$known_update = get_option('layers_known_update');
	$found_update = "";//$known_update;

	// check for new versions if it's been a week
	if (strcmp(date("Y-m-d", time() - 7 * 24 * 60 * 60), get_option('layers_last_updated')) > 0) {
		{
			// load wp rss functions for update checking.
			if (!function_exists('parse_w3cdtf')) {
				require_once(ABSPATH . WPINC . '/rss-functions.php');
			}

			// note the updating and fetch potential updates
			update_option('layers_last_updated', date("Y-m-d"));
			$update = fetch_rss("http://jaipandya.com/tag/layers/feed");

			if ($update === False) {
				layers_message(__('Layers tried to check for updates but failed. This might be the way PHP is set up, or just random network issues. Please <a href="http://jaipandya.com/themes">visit the Layers website</a> to update manually if needed.', 'layers'));
				return;
			}

			// loop through feed, pulling out any updates
			foreach($update->items as $item) {
				$updates = Array();
				if (preg_match('|<!-- Layers:Update date="(\d{4}-\d{2}-\d{2})" version="(.*?)" -->|', $item['content']['encoded'], $updates)) {
					// if this is the newest update, it

					if ($updates[1] > $found_update) {
						$found_update = $updates[1];
						$version = $updates[2];
					}
				}
			}

			// if an newer update was found, save it
			if (strcmp($found_update, $known_update) > 0)
				update_option('layers_known_update', $found_update);

			// if the best-known update is newer than this ver, tell user
			if (strcmp($found_update, $layers->date) > 0)
				layers_message(__('An update of Layers is available</a> as of ', 'layers') . $found_update . __('. Download <a href="http://jaipandya.com/Themes">Layers Version ', 'layers') . $version . '</a>.');

		}
	}
}
function layers_menu() {
	add_theme_page( 'Layers Options', 'Layers Options', 'manage_options', 'layers-menu', 'menu');
}

function menu() {
	global $layers_loc, $layers, $message, $layers_options, $style_sheet ;


	if ( isset( $_POST['custom_styles'] ) ){
		update_option('layers_style', $_POST['custom_styles']);
		wp_cache_flush();
		$message  = __('Styles updated!','layers');
	}

	if ( isset( $_POST['reset'] ) ){
		delete_option('layers_style');
		delete_option('layers_version');
		delete_option('layers_options');
		delete_option('layers_known_update');
		delete_option('layers_last_updated');
		switch_theme('default','default'); //Switch back to the default theme
		$message = __('Settings removed, Theme set to the default theme.','layers');
	}

	if ( isset( $_POST['misc_options'] )){

		$layers_options['width'] = $_POST['content_width'];

		update_option('layers_options', $layers_options);

		wp_cache_flush();
		$message  = __('Options updated!','layers');
	}
	?>


	<?php if($message) :
	layers_message($message);
	endif; ?>
	<div id="dropmessage" class="updated" style="display:none;"></div>
	<?php if (get_option('layers_version')) : ?>
	<?php layers_update_version(); ?>
	<?php
	// getting the layers options again. For some reason they disappear.
	$layers_options = get_option('layers_options');
	$layers_last_updated = get_option('layers_last_updated');
	$layers_known_update = get_option('layers_known_update');
	$style_sheet = get_stylesheet_uri();
	?>
	<div class="wrap" style="position:relative;">
	<h2><?php _e('Layers Options','layers'); ?></h2>
	<h3><?php _e('Custom Styles','layers') ?></h3>
	<p><?php _e('Select a style from the dropdown below to customize Layers with a style of your choice.','layers') ?></p>
	<form name="dofollow" action="" method="post">
	<input type="hidden" name="page_options" value="'dofollow_timeout'" />
	<select name="custom_styles">
	<?php $layers->get_style(); ?>
	<option value="<?php echo $style_sheet;?>"<?php if ($layers->style == $style_sheet) echo ' selected="selected"'; ?>><?php _e('Default dark','layers') ?></option>
	<?php
	$scheme_dir = dir(ABSPATH . '/wp-content/themes/' . get_template() . '/styles'); //@ hides the error output in case of no match
	if ($scheme_dir) {
		while(($file = $scheme_dir->read()) !== false) {
			if (!preg_match('|^\.+$|', $file) && preg_match('|\.css$|', $file))
				$scheme_files[] = $file;
		}
	}
	if ($scheme_dir || $scheme_files) {
		foreach($scheme_files as $scheme_file) {
			if ( (get_stylesheet_directory_uri() .'/styles/' . $scheme_file) == $layers->style){
				$selected = ' selected="selected"';
			}else{
				$selected = "";
			}
			echo '<option value="'. get_stylesheet_directory_uri() .'/styles/' . $scheme_file . '"' . $selected . '>' . $scheme_file . '</option>';
		}
	}
	?>
	</select><br /><br />
	<input type="submit" value="Save" />
	</form>

	<h3><?php _e('Content Width','layers') ?></h3>
	<form name="dofollow" action="" method="post">
	<input type="hidden" name="misc_options" value="1" />
	<p>
	<label><input type="radio" value="fixed" name="content_width" <?php if ($layers_options['width'] == 'fixed') echo "checked=\"checked\""; ?> /> <?php _e('Fixed Width','layers') ?> </label>
	</p>
	<p>
	<label><input type="radio" value="fluid" name="content_width" <?php if ($layers_options['width'] == 'fluid') echo "checked=\"checked\""; ?> /> <?php _e('Fluid Width','layers') ?> </label>
	</p>

	<p><br/><input type="submit" value="Save my options" />
	</p>
	</form>
	<br />
	<h3><?php _e('Updates','layers'); ?></h3>
	<p><?php _e('Layers checks for new versions when you bring up this page. (At most once per week.)','layers') ?></p>
	<p><?php _e('This copy of Layers is version ','layers') ?><b><?php echo $layers->version; ?></b><?php _e(' released on <b>','layers')?><?php echo $layers->date; ?></b>.
	<?php if(strcmp($layers_known_update, $layers->date) > 0) {
		 _e('There is an update available as of','layers')?> <?php echo $layers_known_update ?>. <?php _e('Download','layers') ?> <a href="http://jaipandya.com/themes"><?php _e('Layers','layers') ?></a>.
	<?php } else { ?>
		<?php _e('You have the latest version installed.','layers') ?>
	<?php } ?>
	</p><p><?php _e('Last checked on <b>','layers') ?><?php echo $layers_last_updated; ?></b>.</p>
	<br />

	<br />
	<h3><?php _e('Reset / Uninstall','layers') ?></h3>
	<form action="" method="post" onsubmit="return confirm('Are you sure you want to reset all of your settings?')">
	<input type="hidden" name="reset" value="1" />
	<p><?php _e('If you would like to reset or uninstall Layers, push this button. It will erase all of your preferences.','layers') ?> <input type="submit" value="<?php _e('Reset / Uninstall','layers') ?>" /></p>
	</form>
	<?php else: // else for 'if (get_option('layers_version'))' ?>
	<div class="wrap" style="position:relative;">
	<p><?php _e('Thank you for using Layers! There are two reasons you might be seeing this','layers') ?>:</p>
	<ol>
	<li><?php _e("You've just installed Layers for the first time: If this is the case, simply reload this page or click on layers Options again and you'll be on your way!",'layers') ?></li>
	<li><?php _e("You've just uninstalled Layers or reset your options. In this case your theme has been changed back to the default theme. If you want to continue using Layers, just activate it from the theme selection page.",'layers') ?></li>
	</ol>
	<?php endif; ?>
	</div>
	<?php
}

function layers_admin_message(){
	if( isset( $_GET[ 'layers-admin-dismiss' ] ) ) update_option( 'layers-admin-message' , true );

	if( '' == get_option( 'layers-admin-message' ) ) { ?>
		<div class="updated">
			<h3><?php _e( 'Important Notice', 'layers' ); ?></h3>
	        <p><?php _e( 'Layers will be undergoing a complete overhaul within the next few weeks. Be sure to backup your files if you wish to keep running this theme in its current state.', 'layers' ); ?></p>
			<a href="?layers-admin-dismiss=1"><?php _e( 'Dismiss' , 'layers' ); ?></a>
	    </div>
<?php }
}
add_action( 'admin_notices', 'layers_admin_message' );