<?php
// Wordpress: This theme uses wp_nav_menu() in one location.
register_nav_menus( array('primary' => 'Primary Navigation') );

// Wordpress: Adds Post Thumbnail Support
add_theme_support( 'post-thumbnails' );

// Wordpress: Removes <p> from the excerpt
remove_filter('the_excerpt', 'wpautop');

// Wordpress: Removes the verion from the Head
remove_action('wp_head', 'wp_generator');

// Wordpress: Remove the error messages generated from a incorrect login
add_filter('login_errors',create_function('$a', "return null;"));

// Wordpress: Remove Update Message
add_action('admin_menu','wphidenag');
function wphidenag() {remove_action( 'admin_notices', 'update_nag', 3 );}

// Wordpress: Reomves the Udate Message from the Admin Page
if (!current_user_can('edit_users')) {
  add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
  add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
}

// global vars declaration - gfh
global $teamCat; // ID of Our Team category - gfh
$teamCat = 42;

// Tests if any of a post's assigned categories are descendants of target categories - gfh
if ( ! function_exists( 'post_is_in_descendant_category' ) ) {
	function post_is_in_descendant_category( $cats, $_post = null ) {
		foreach ( (array) $cats as $cat ) {
			// get_term_children() accepts integer ID only
			$descendants = get_term_children( (int) $cat, 'category' );
			if ( $descendants && in_category( $descendants, $_post ) )
				return true;
		}
		return false;
	}
}

// add scripts to site, some with parameters  - gfh
function tal_scripts() {
  if ( is_page_template('page-interactive-builder.php') ) wp_enqueue_script( 'jquery-cookie', get_stylesheet_directory_uri() . '/js/jquery.cookie.js', array(), '1.4.0', false );
  if ( is_page( 149 ) ) wp_enqueue_script( 'jquery-ib-forms', get_stylesheet_directory_uri() . '/js/tal-ib-forms.js', array(), '1.0.0', false );
  if ( is_page_template( 'page-team.php' ) ) wp_enqueue_script( 'jquery-isotope', get_stylesheet_directory_uri() . '/js/jquery.isotope.min.js', array(), '1.5.25', false );
  // showcase features page, team page and individual team members - gfh
  if ( is_page( 1048 ) || is_page_template( 'page-team.php' ) || in_category( array( $teamCat, 43, 44, 45 ) )  ) wp_enqueue_script( 'jquery-isotope-options', get_stylesheet_directory_uri() . '/js/tal-isotope-options.js', array(), '1.0.0', false );
}
add_action( 'wp_enqueue_scripts', 'tal_scripts' );

// add thumbnail sizea - gfh
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'team-thmb', 252, 174, true ); // small thumbnail image for Our Team page - gfh
	add_image_size( 'team-full', 346, 523 ); // large image for individual team member pages - gfh
	add_image_size( 'team-company', 200, 100 ); // large image for individual team member pages - gfh
	add_image_size( 'archive-thmb', 300, 300 ); // for use on post archive pages - gfh
}

// for closing HTML on generated post excerpts - gfh
function closeTags($html) {
	preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
	$openedtags = $result[1];
	preg_match_all('#</([a-z]+)>#iU', $html, $result);
	$closedtags = $result[1];
	$len_opened = count($openedtags);
	if (count($closedtags) == $len_opened) {
		return $html;
	}
	$openedtags = array_reverse($openedtags);
	for ($i=0; $i < $len_opened; $i++) {
		if (!in_array($openedtags[$i], $closedtags)) {
			$html .= '</'.$openedtags[$i].'>';
		} else {
			unset($closedtags[array_search($openedtags[$i], $closedtags)]);
		}
	}
	return $html;
}

add_action("wp_ajax_ib_submitted", "ib_submitted");
add_action("wp_ajax_nopriv_ib_submitted", "ib_submitted");
// populate estimate area of Interactive Builder - gfh
function ib_submitted() {
	$plan_id = $_POST['plan_id'];
	$loc_id = $_POST['loc_id'];

	$plan = ib_get_plan( $plan_id );
	$loc = ib_get_location( $loc_id );
	$est = ib_get_estimate( $plan_id, $loc_id );

	$result['plan_error'] = $plan['error'];
	$result['plan_thmb'] = $plan['thmb'];
	$result['plan_name'] = $plan['title'];
	$result['plan_sqft'] = $plan['sqft'];
	$result['plan_rooms'] = $plan['rooms'];
	$result['loc_error'] = $loc['error'];
	$result['loc_title'] = $loc['title'];
	$result['loc_img'] = $loc['map'];
	$result['estimate'] = $est;
	$result['loc_id'] = $loc_id;
	echo json_encode($result);

	die();
}

// get plan info for Interactive Builder - gfh
function ib_get_plan( $p ) {
	if ( isset( $p ) ) {
		$post = get_post( $p );
		$plan = array(
			'thmb' => 	get_the_post_thumbnail($post->ID, array(100,100) ),
			'title' => 	$post->post_title,
			'sqft' => 	get_post_meta($post->ID, 'sqft', true),
			'rooms' =>	get_post_meta($post->ID, 'rooms', true)
		);
	}
	else {
		$plan = array( 'error' => true );
	}
	
	return $plan;
}

// get neighborhood info for Interactive Builder - gfh
function ib_get_location( $n ){
	if ( isset( $n ) ) {
		$post = get_post( $n );
		$loc = array(
			'title' =>	$post->post_title,
			'map' => get_post_meta($post->ID, 'ib_map', true)
		);
	} else {
		$loc = array( 'error' => true );
	}

	return $loc;
}

function ib_get_estimate( $p, $n ) {
	//$estimate = "";

	if ( isset($p) && isset($n) ) {
		$plan = get_post($p);
		$loc = get_post($n);

		//Gets Plan Price
		$plan_price = preg_replace('/\D/', '', get_post_meta($plan->ID, 'price', true));
		//$plan_sqft = preg_replace('/\D/', '', get_post_meta($plan->ID, 'sqft', true)); // removed 1/21/14 at client request - gfh

		//Gets location price
		$loc_lot_price = preg_replace('/\D/', '', get_post_meta($loc->ID, 'ib_lot', true));
		$loc_permit_price = preg_replace('/\D/', '', get_post_meta($loc->ID, 'ib_permit', true));
		$loc_price = $loc_lot_price + $loc_permit_price;

		// Get adjustments based on location id and plan id
		//$loc_name = $loc->post_title; no longer usering name - gfh
		$loc_id = $loc->ID;
		$adjustment = ib_price_adjustments($p, $loc_id);

		// Get total estimate
		//$estimate = number_format($price_plan + $price_location + $price_sqft + $adjustment, 2); // removed sqft 1/21/14 at client request - gfh
		$estimate = number_format($plan_price + $loc_price + $adjustment, 2);
	}

	return $estimate;
}

function ib_price_adjustments($plan, $location) {
	$adjustment = 0;
	// Black Horse Estates
	if ($location == "748" && $plan == 520){$adjustment = -20100;} // metolius
	if ($location == "748" && $plan == 525){$adjustment = 9900;} // rogue
	if ($location == "748" && $plan == 99999){$adjustment = 44900;} // rogue (modified)
	if ($location == "748" && $plan == 1122){$adjustment = 4900;} // hamlin
	if ($location == "748" && $plan == 1124){$adjustment = -30100;} // missouri
	// Brookside
	if ($location == "896" && $plan == 523){$adjustment = -15100;} // willamette
	if ($location == "896" && $plan == 512){$adjustment = -16000;} // bachelor
	if ($location == "896" && $plan == 577){$adjustment = -16000;} // bennett
	if ($location == "896" && $plan == 710){$adjustment = -32000;} // jefferson
	if ($location == "896" && $plan == 525){$adjustment = 34900;} // rogue(basic)
	if ($location == "896" && $plan == 701){$adjustment = -16000;} // wilson
	if ($location == "896" && $plan == 702){$adjustment = -16100;} // shilo
	if ($location == "896" && $plan == 1117){$adjustment = -16000;} // applegate
	if ($location == "896" && $plan == 1122){$adjustment = -100;} // hamlin
	// Meriwether
	if ($location == "791" && $plan == 1500){$adjustment = -1600;} // lewis
	if ($location == "791" && $plan == 1499){$adjustment = 1500;} // clark
	if ($location == "791" && $plan == 1502){$adjustment = 3400;} // monticello
	if ($location == "791" && $plan == 1501){$adjustment = 2400;} // continental
	// Sleepy Hollow
	if ($location == "486" && $plan == 528){$adjustment = -100;} // klamath
	if ($location == "486" && $plan == 527){$adjustment = -100;} // mckenzie
	if ($location == "486" && $plan == 523){$adjustment = -100;} // willamette
	if ($location == "486" && $plan == 518){$adjustment = -20100;} // whitman
	if ($location == "486" && $plan == 512){$adjustment = -100;} // bachelor
	if ($location == "486" && $plan == 796){$adjustment = -25100;} // summit
	// Southern Ridge II
	if ($location == "490" && $plan == 525){$adjustment = 4900;} // rogue (basic)
	if ($location == "490" && $plan == 699){$adjustment = -44100;} // trask
	if ($location == "490" && $plan == 796){$adjustment = -50100;} // summit
	if ($location == "490" && $plan == 1122){$adjustment = -20100;} // hamlin
	if ($location == "490" && $plan == 99999){$adjustment = 39900;} // rogue (modified)
	if ($location == "490" && $plan == 1124){$adjustment = -65100;} // missouri
	// Sunrise Heights
	if ($location == "482" && $plan == 518){$adjustment = -100;} // whitman
	if ($location == "482" && $plan == 577){$adjustment = 9900;} // bennett
	if ($location == "482" && $plan == 710){$adjustment = -6100;} // jefferson
	if ($location == "482" && $plan == 796){$adjustment = 4900;} // summit
	if ($location == "482" && $plan == 1123){$adjustment = -10100;} // mckenzie daylight
	if ($location == "482" && $plan == 1118){$adjustment = -40100;} // avamore
	if ($location == "482" && $plan == 516){$adjustment = -2100;} // drake
	// Sunrise Mountain View
	if ($location == "731" && $plan == 1121){$adjustment = -40100;} // daybreak
	if ($location == "731" && $plan == 1126){$adjustment = 4900;} // twilight
	if ($location == "731" && $plan == 525){$adjustment = 24900;} // rogue (basic)
	// Timber Ridge at Cascadia Ridge
	if ($location == "1786" && $plan == 1117){$adjustment = -7600;} // applegate
	if ($location == "1786" && $plan == 512){$adjustment = -18500;} // bachelor
	if ($location == "1786" && $plan == 577){$adjustment = -15000;} // bennett
	if ($location == "1786" && $plan == 710){$adjustment = -23600;} // jefferson
	if ($location == "1786" && $plan == 527){$adjustment = 12400;} // mckenzie
	if ($location == "1786" && $plan == 523){$adjustment = -15500;} // willamette
	if ($location == "1786" && $plan == 701){$adjustment = -7600;} // wilson
	// Volare Townhomes
	if ($location == "745" && $plan == 1120){$adjustment = -25600;} // chickadee
	if ($location == "745" && $plan == 1125){$adjustment = 400;} // sparrow
	// Wenzel Park
	if ($location == "703" && $plan == 702){$adjustment = -14100;} // shilo
	if ($location == "703" && $plan == 701){$adjustment = -10100;} // wilson
	if ($location == "703" && $plan == 699){$adjustment = -9100;} // trask
	if ($location == "703" && $plan == 523){$adjustment = -20100;} // willamette
	if ($location == "703" && $plan == 1122){$adjustment = 4900;} // hamlin
	
	
	// following communities are not currently active
	//if ($location == "Cascadia Ridge" && $plan == 530){$adjustment = -974;}
	//if ($location == "Cascadia Ridge" && $plan == 531){$adjustment = -6076;}
	//if ($location == "Cascadia Ridge" && $plan == 524){$adjustment = -10132;}
	//if ($location == "Cascadia Ridge" && $plan == 528){$adjustment = 743;}
	//if ($location == "Cascadia Ridge" && $plan == 527){$adjustment = -5449;}
	//if ($location == "Cascadia Ridge" && $plan == 526){$adjustment = -4350;}
	//if ($location == "Cascadia Ridge" && $plan == 523){$adjustment = -5072;}
	//if ($location == "Cascadia Ridge" && $plan == 525){$adjustment = 507;}			
	//if ($location == "Cascadia Ridge" && $plan == 522){$adjustment = 1209;}
	//if ($location == "Tree View Estates" && $plan == 525){$adjustment = 13007;}
	//if ($location == "Tree View Estates" && $plan == 523){$adjustment = 5428;}
	//if ($location == "Tree View Estates" && $plan == 522){$adjustment = 5291;}
	//if ($location == "Tree View Estates" && $plan == 520){$adjustment = -1;}
	//if ($location == "Tree View Estates" && $plan == 518){$adjustment = -7877;}	
	//if ($location == "Tree View Estates" && $plan == 517){$adjustment = -17995;}
	//if ($location == "Tree View Estates" && $plan == 577){$adjustment = 3050;}
	//if ($location == "Pfeifer Ridge" && $plan == 515){$adjustment = 5000;}
	//if ($location == "Pfeifer Ridge" && $plan == 524){$adjustment = -5050;}
	
	return $adjustment;	
}

// returns titles of all posts, specified by post type - gfh
function get_some_titles( $type ){
	$args = array(
		'post_type' =>		$type,
		'orderby' =>		'title',
		'order' =>		'ASC',
		'posts_per_page' =>	-1
	);

	$wpQuery = new WP_Query( $args );
	$posts = array(); // to store all post titles

	if ($wpQuery->have_posts()) {
	      while ($wpQuery->have_posts()) : $wpQuery->the_post();

	      array_push( $posts, get_the_title() );

	      endwhile;
	}

	return $posts;
}

// This code will output the Custom Field value for a [data]key[/data]
add_shortcode('data','customfields_shortcode');
function customfields_shortcode($atts, $text) {
	global $post;
	return get_post_meta($post->ID, $text, true);
}


// Wordpress: Removes Menus defined in $restricted
add_action('admin_menu', 'remove_menus');
function remove_menus () {
global $menu;
	$restricted = array(__('Links'), __('Comments'), __('Tools'));
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
}

// Wordpress: Updates Menu Names
add_filter( 'gettext', 'update_menu_names' );
add_filter( 'ngettext', 'update_menu_names' );
function update_menu_names ( $translated ) 
{  
		// Changes Posts
    $translated = str_replace( 'Post', 'In The New', $translated );
    $translated = str_replace( 'post', 'in the new', $translated );
    
    // Changes Media
    $translated = str_replace( 'Media', 'File Uploads', $translated );
    $translated = str_replace( 'media', 'file uploads', $translated );
        
    return $translated;
}

// Wordpress: Adds Custom Post Templates (category.php)
add_filter( 'category_template', 'custom_category' );
function custom_category() {
	global $cat;
	
  if ($cat == 18){
		$template = locate_template( array('category-news.php', 'category.php') );
  } else {
		$template = locate_template( array('category.php') );
	}
  return $template;	
}

// Wordpress: Adds Custom Post Display (single.php)
add_filter('single_template', 'custom_post');
function custom_post() {
	global $post;	
  
	if ($post->post_type == 'home-plans'){
		$template = locate_template( array('single-plans.php', 'single.php') );
  } else if ($post->post_type == 'neighborhoods'){
		$template = locate_template( array('single-neighborhoods.php', 'single.php') );
  } else if ($post->post_type == 'current-projects'){
		$template = locate_template( array('single-projects.php', 'single.php') );
  } else {
		$template = locate_template( array('single.php') );
	}
  return $template;	
}

// Wordpress: Removes [...] from excerpt
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'wp_new_excerpt');
function wp_new_excerpt($text)
{
	if ($text == '')
	{
		$text = get_the_content('');
		$text = strip_shortcodes( $text );
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
		$text = strip_tags($text);
		$text = nl2br($text);
		$excerpt_length = apply_filters('excerpt_length', 55);
		$words = explode(' ', $text, $excerpt_length + 1);
		if (count($words) > $excerpt_length) {
			array_pop($words);
			array_push($words, '<a href=' . get_permalink() . ' id="permalink">[more]</a>');
			$text = implode(' ', $words);
		}
	}
	return $text;
}



// This function will return the browser type, version, and platform
// Note: for this to work, browscap.ini must be loaded in the php configuration for the server
function wp_get_browser(){
$browser = get_browser(null, true);
$tmp['browser'] = $browser['browser'];
$tmp['version'] = $browser['version'];
$tmp['platform'] = $browser['platform'];
return $tmp;
}

function wp_load_browser_css(){
$browser = wp_get_browser();	

	       if ($browser['browser'] == "Safari"){
		echo "<link rel='stylesheet' href='".get_bloginfo('template_url')."/css/safari.css' type='text/css' media='screen' /> \n";
	} else if ($browser['browser'] == "IE" && $browser['version'] == "6.0"){
		echo "<link rel='stylesheet' href='".get_bloginfo('template_url')."/css/ie6.css' type='text/css' media='screen' /> \n";
		echo "<script defer type='text/javascript' src='".get_bloginfo('template_url')."/js/iepngfix.js'></script>";
	} else if ($browser['browser'] == "Firefox" && $browser['version'] < 3.1){
		echo "<link rel='stylesheet' href='".get_bloginfo('template_url')."/css/firefox3.css' type='text/css' media='screen' /> \n";
	}
}


// Custom Post Type - Homes/Customer Projects
add_action('init', 'homes_register'); 
function homes_register() {
 
	$labels = array(
		'name' => _x('Projects', 'post type general name'),
		'singular_name' => _x('Project', 'post type singular name'),
		'add_new' => _x('Add New Project', 'home item'),
		'add_new_item' => __('Add New Home'),
		'edit_item' => __('Edit Home'),
		'new_item' => __('New Home'),
		'view_item' => __('View Home'),
		'search_items' => __('Search Homes'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'menu_icon' => get_bloginfo('template_url').'/images/icon-homes.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 9,
		'supports' => array('title','thumbnail')
	  ); 
 
	register_post_type( 'current-projects' , $args );
}

function homes_meta() {
  global $post;
  $custom = get_post_custom($post->ID);
  ?>
  <style>
  	#meta_field {width:300px;}
  </style>
  <table width="100%" border="1">


   	<tr><td width="200">Build Status:</td>
  			<td><select name="completion_date" id="meta_field">
  				<?php if ($custom["completion_date"][0] != "") { echo '<option value="'.$custom["completion_date"][0].'">'.$custom["completion_date"][0].'</option>'; }
  				      else {echo '<option value=""> -select status- </option>';}
  				?>
    				<option value="Under Construction">Under Construction</option>
    				<option value="Completed">Completed</option>
    				<option value="Move-In Ready">Move-In Ready</option>
  					</select>
  			</td></tr>
  	
  	<tr><td width="200">Plan Type:</td>
  			<td><select name="plan_type" id="meta_field">
  				<?php
				if ($custom["plan_type"][0] != "") { echo '<option value="'.$custom["plan_type"][0].'">'.$custom["plan_type"][0].'</option>'; }
  				else {echo '<option value=""> -select plan- </option>';}

				$titles = get_some_titles( 'home-plans' );
				
				foreach( $titles as $t ) {
				    echo '<option value="' . $t . '">' . $t . '</option>';
				}				
  				?>
    				<option value="Custom Plan">Custom Plan</option>
  			    </select>
  			</td></tr>
   	<tr><td width="200">Community:</td>
  			<td><select name="community" id="meta_field">
  				<?php if ($custom["community"][0] != "") { echo '<option value="'.$custom["community"][0].'">'.$custom["community"][0].'</option>'; }
  				      else {echo '<option value=""> -select community- </option>';}

				      $neighborhoods = get_some_titles( 'neighborhoods' );
				
				foreach( $neighborhoods as $n ) {
				    echo '<option value="' . $n . '">' . $n . '</option>';
				}
  				?>  
  			</select>
  			</td></tr>
  <tr><td width="200">Address:</td><td><input type="text" name="address" value="<?php echo $custom["address"][0]; ?>" id="meta_field"/></td></tr>
  <tr><td width="200">City:</td><td><input type="text" name="city" value="<?php echo $custom["city"][0]; ?>" id="meta_field"/></td></tr>
  <tr><td width="200">Lot Number:</td><td><input type="text" name="lot" value="<?php echo $custom["lot"][0]; ?>" id="meta_field"/></td></tr>
  <tr><td width="200">Gallery ID:</td><td><input type="text" name="gallery_id" value="<?php echo $custom["gallery_id"][0]; ?>" id="meta_field" /></td></tr>
  <tr><td width="200">Price:</td><td><input type="text" name="price" value="<?php echo $custom["price"][0]; ?>" id="meta_field"/></td></tr>  
  <tr><td width="200">Sq. Ft.:</td><td><input type="text" name="sqft" value="<?php echo $custom["sqft"][0]; ?>" id="meta_field"/></td></tr>
  <tr><td width="200">MLS #:</td><td><input type="text" name="mls" value="<?php echo $custom["mls"][0]; ?>" id="meta_field"/></td></tr>
  </table>

  <?php
}

add_action('save_post', 'save_homes_meta');
function save_homes_meta(){
  global $post;
  // verify if this is an auto save routine and escape
  if (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE){
  	return;
  }
  if ($post->post_type == 'current-projects') {
	  update_post_meta($post->ID, "plan_type", $_POST["plan_type"]);
	  update_post_meta($post->ID, "community", $_POST["community"]);
	  update_post_meta($post->ID, "address", $_POST["address"]);
	  update_post_meta($post->ID, "city", $_POST["city"]);
	  update_post_meta($post->ID, "lot", $_POST["lot"]);
	  update_post_meta($post->ID, "completion_date", $_POST["completion_date"]);
	  update_post_meta($post->ID, "gallery_id", $_POST["gallery_id"]);
	  update_post_meta($post->ID, "price", $_POST["price"]);
	  update_post_meta($post->ID, "sqft", $_POST["sqft"]);
	  update_post_meta($post->ID, "mls", $_POST["mls"]);
  }
}


// Custom Post Type - Homes/Customer Projects
add_action('init', 'plans_register'); 
function plans_register() {
 
	$labels = array(
		'name' => _x('Home Plans', 'post type general name'),
		'singular_name' => _x('Home Plan', 'post type singular name'),
		'add_new' => _x('Add New Plan', 'home item'),
		'add_new_item' => __('Add New Plan'),
		'edit_item' => __('Edit Plan'),
		'new_item' => __('New Plan'),
		'view_item' => __('View Plan'),
		'search_items' => __('Search Plans'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'menu_icon' => get_bloginfo('template_url').'/images/icon-plans.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 4,
		'supports' => array('title','editor','thumbnail')
	  ); 
 
	register_post_type( 'home-plans' , $args );
}

function plans_meta() {
  global $post;
  $custom = get_post_custom($post->ID);
  ?>
  <style>
  	#meta_field {width:300px;}
  </style>
  <table width="100%" border="1">
  	<tr><td width="200">Price:</td><td><input type="text" name="price" value="<?php echo $custom["price"][0]; ?>" id="meta_field" /></td></tr>
  	<tr><td width="200">Square Foot:</td><td><input type="text" name="sqft" value="<?php echo $custom["sqft"][0]; ?>" id="meta_field" /></td></tr>
  	<tr><td width="200">Rooms:</td><td><input type="text" name="rooms" value="<?php echo $custom["rooms"][0]; ?>" id="meta_field"/></td></tr>  
  	<tr><td width="200">Garage:</td><td><input type="text" name="garage" value="<?php echo $custom["garage"][0]; ?>" id="meta_field" /></td></tr>
  	<tr><td width="200">Gallery ID - Plans:</td><td><input type="text" name="gallery-plans" value="<?php echo $custom["gallery-plans"][0]; ?>" id="meta_field" /></td></tr> 
  	<tr><td width="200">Gallery ID - Photos:</td><td><input type="text" name="gallery-photos" value="<?php echo $custom["gallery-photos"][0]; ?>" id="meta_field" /></td></tr>
  	<tr><td width="200">PDF Flyer (File Name):</td><td><input type="text" name="pdf-flyer" value="<?php echo $custom["pdf-flyer"][0]; ?>" id="meta_field" /></td></tr>     
  </table>

  <?php
}

add_action('save_post', 'save_plans_meta');
function save_plans_meta(){
  global $post;  
  // verify if this is an auto save routine and escape
  if (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE){
  	return;
  }
  if ($post->post_type == 'home-plans') {
	  update_post_meta($post->ID, "price", $_POST["price"]);
	  update_post_meta($post->ID, "sqft", $_POST["sqft"]);
	  update_post_meta($post->ID, "rooms", $_POST["rooms"]);
	  update_post_meta($post->ID, "garage", $_POST["garage"]);
	  update_post_meta($post->ID, "gallery-plans", $_POST["gallery-plans"]);
	  update_post_meta($post->ID, "gallery-photos", $_POST["gallery-photos"]);
	  update_post_meta($post->ID, "pdf-flyer", $_POST["pdf-flyer"]);
	}
}


// Custom Post Type - Community
add_action('init', 'community_register'); 
function community_register() {
 
	$labels = array(
		'name' => _x('Communities', 'post type general name'),
		'singular_name' => _x('Communities', 'post type singular name'),
		'add_new' => _x('Add Community', 'home item'),
		'add_new_item' => __('Add Community'),
		'edit_item' => __('Edit Community'),
		'new_item' => __('New Community'),
		'view_item' => __('View Community'),
		'search_items' => __('Search Communities'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'menu_icon' => get_bloginfo('template_url').'/images/icon-community.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 5,
		'supports' => array('title','editor','excerpt','thumbnail')
	  ); 
 
	register_post_type( 'neighborhoods' , $args );
}

function community_meta() {
  global $post;
  $custom = get_post_custom($post->ID);
  ?>
  <style>
  	#meta_field {width:300px;}
  	#meta_field_wide {width:100%;}
  </style>
  <table width="100%" border="1">
  	<tr><td width="200">Map ID:</td><td><input type="text" name="map_id" value="<?php echo $custom["map_id"][0]; ?>" id="meta_field" /></td></tr>
  	<tr><td width="200">City/State:</td><td><input type="text" name="city" value="<?php echo $custom["city"][0]; ?>" id="meta_field" /></td></tr>
  	<tr><td width="200">Price:</td><td><input type="text" name="price" value="<?php echo $custom["price"][0]; ?>" id="meta_field" /></td></tr>
  	<tr><td width="200">Contact:</td><td><input type="text" name="contact" value="<?php echo $custom["contact"][0]; ?>" id="meta_field" /></td></tr>
  	<tr><td width="200">Model Home Location:</td><td><input type="text" name="model_home" value="<?php echo $custom["model_home"][0]; ?>" id="meta_field"/></td></tr>   
  	<tr><td width="200">Gallery ID - Photos:</td><td><input type="text" name="gallery-photos" value="<?php echo $custom["gallery-photos"][0]; ?>" id="meta_field" /></td></tr>
  	<tr><td width="200">Plat Map (File Name):</td><td><input type="text" name="plat_map" value="<?php echo $custom["plat_map"][0]; ?>" id="meta_field" /></td></tr>
  	<tr><td width="200">Lots Available:</td><td><textarea name="lots_available" rows="3" id="meta_field_wide"><?php echo $custom["lots_available"][0]; ?></textarea></td></tr>   
  	<tr><td width="200">Directions:</td><td><textarea name="directions" rows="3" id="meta_field_wide"><?php echo $custom["directions"][0]; ?></textarea></td></tr>
  	<tr><td width="200">Highlights:</td><td><textarea name="highlights" rows="3" id="meta_field_wide"><?php echo $custom["highlights"][0]; ?></textarea></td></tr>
  	<tr><td width="200">Google Map (code):</td><td><textarea name="google_map" rows="3" id="meta_field_wide"><?php echo $custom["google_map"][0]; ?></textarea></td></tr>
  </table>

  <?php
}

function community_builder_meta() {
  global $post;
  $custom = get_post_custom($post->ID);
  ?>
  <style>
  	#meta_field {width:300px;}
  	#meta_field_wide {width:100%;}
  </style>
  <table width="100%" border="1">
  	<tr><td width="200">Use this Community:</td>
  			<td><select name="ib_view" id="meta_field"> 				
    				<option value="true" <?php if ($custom["ib_view"][0] == "true"){echo "SELECTED";}?> >yes</option>
    				<option value="false" <?php if ($custom["ib_view"][0] == "false"){echo "SELECTED";}?> >no</option>
  					</select>
  			</td></tr>
  	<tr><td width="200">Lot Cost:</td><td><input type="text" name="ib_lot" value="<?php echo $custom["ib_lot"][0]; ?>" id="meta_field" /></td></tr>
  	<tr><td width="200">Permit Cost:</td><td><input type="text" name="ib_permit" value="<?php echo $custom["ib_permit"][0]; ?>" id="meta_field" /></td></tr> 
  	<tr><td width="200">Map (File Name):</td><td><input type="text" name="ib_map" value="<?php echo $custom["ib_map"][0]; ?>" id="meta_field" /></td></tr> 
  	<tr><td width="200">Available Plans (ID):</td><td><input type="text" name="ib_plans" value="<?php echo $custom["ib_plans"][0]; ?>" id="meta_field_wide" /></td></tr>  
  </table>

  <?php
}

add_action('save_post', 'save_community_meta');
function save_community_meta(){
  global $post;
  // verify if this is an auto save routine and escape
  if (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE){
  	return;
  }  
 	if ($post->post_type == 'neighborhoods') {
	  // Community Information
	  update_post_meta($post->ID, "map_id", $_POST["map_id"]);
	  update_post_meta($post->ID, "city", $_POST["city"]);
	  update_post_meta($post->ID, "price", $_POST["price"]);
	  update_post_meta($post->ID, "contact", $_POST["contact"]);
	  update_post_meta($post->ID, "model_home", $_POST["model_home"]);
	  update_post_meta($post->ID, "gallery-photos", $_POST["gallery-photos"]);
	  update_post_meta($post->ID, "plat_map", $_POST["plat_map"]);
	  update_post_meta($post->ID, "lots_available", $_POST["lots_available"]);
	  update_post_meta($post->ID, "directions", $_POST["directions"]);
	  update_post_meta($post->ID, "highlights", $_POST["highlights"]);
	  update_post_meta($post->ID, "google_map", $_POST["google_map"]);
	  
	  // Interactive Builder Data
	  update_post_meta($post->ID, "ib_view", $_POST["ib_view"]);
	  update_post_meta($post->ID, "ib_lot", $_POST["ib_lot"]);
	  update_post_meta($post->ID, "ib_permit", $_POST["ib_permit"]);
	  update_post_meta($post->ID, "ib_map", $_POST["ib_map"]);
	  update_post_meta($post->ID, "ib_plans", $_POST["ib_plans"]);	  
	}
}

add_action("admin_init", "admin_init"); 
function admin_init(){
	add_meta_box("homes_meta", "Project Information", "homes_meta", "current-projects", "normal", "low");
  add_meta_box("plans_meta", "Plan Information", "plans_meta", "home-plans", "normal", "low");
  add_meta_box("community_meta", "Community Information", "community_meta", "neighborhoods", "normal", "low");
  add_meta_box("community_builder_meta", "Interactive Builder Data", "community_builder_meta", "neighborhoods", "normal", "low");
}

// Custom Columns for Post Types
add_action("manage_posts_custom_column",  "custom_columns");
add_filter("manage_edit-home-plans_columns", "plans_edit_columns");
add_filter("manage_edit-current-projects_columns", "homes_edit_columns");
add_filter("manage_edit-neighborhoods_columns", "community_edit_columns");
 
function homes_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "title" => "Customer",
    "plan_type" => "Plan Type",
    "community" => "Community",
    "lot" => "Lot",
    "completion_date" => "Date Completed",
    "gallery_id" => "Gallery ID",
    "price" => "Price",
    "id" => "ID"
  );
 
  return $columns;
}

function plans_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "title" => "Homes",
    "sqft" => "Square Feet",
    "price" => "Price",
    "rooms" => "Rooms",
    "id" => "ID"
  );
 
  return $columns;
}

function community_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "title" => "Homes",
    "city" => "City",
    "map" => "Map ID",
    "id" => "ID"
  );
 
  return $columns;
}


function custom_columns($column){
  global $post;
 
  switch ($column) {
    case "sqft":
      $custom = get_post_custom();
      echo $custom["sqft"][0];
      break;
    case "price":
      $custom = get_post_custom();
      echo $custom["price"][0];
      break;
    case "rooms":
      $custom = get_post_custom();
      echo $custom["rooms"][0];
      break;
    case "plan_type":
      $custom = get_post_custom();
      echo $custom["plan_type"][0];
      break;
    case "community":
      $custom = get_post_custom();
      echo $custom["community"][0];
      break;
    case "lot":
      $custom = get_post_custom();
      echo $custom["lot"][0];
      break;      
    case "completion_date":
      $custom = get_post_custom();
      echo $custom["completion_date"][0];
      break;
    case "map":
      $custom = get_post_custom();
      echo $custom["map_id"][0];
      break;     
    case "city":
      $custom = get_post_custom();
      echo $custom["city"][0];
      break;
    case "gallery_id":
      $custom = get_post_custom();
      echo $custom["gallery_id"][0];
      break;             
    case "id":
      echo $post->ID;
      break;       
  }
}

?>