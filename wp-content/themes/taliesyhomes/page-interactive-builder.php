<?php /* Template Name: IntBuilder */
session_start();
// Update this URL during when on DEVELOPMENT server - user for header redirects below
$site_url = "http://taliesyhomesnw.com";
//$site_url = "http://taliesyhomesnw.staging.wpengine.com";
$map_img = get_bloginfo('template_directory') . "/images/taliesy_neighborhoods_map.jpg";
global $s_location;
global $s_plan;

// Step 1: Sets Location ID
if ( isset($_GET['location']) || isset($_COOKIE['ib-location-id']) ) {
	if ( isset($_GET['location']) ) {
		$s_location = ($_GET['location']);
	} elseif ( isset($_COOKIE['ib-location-id']) ) {
		$s_location = $_COOKIE['ib-location-id'];
	}
}

// Step 2: Sets Plan ID
if ( isset($_GET['plan']) || isset($_COOKIE['ib-plan-id']) ) {
	if ( isset($_GET['plan']) ) {
		$s_plan = ($_GET['plan']);
	} elseif ( isset($_COOKIE['ib-plan-id']) ) {
		$s_plan = $_COOKIE['ib-plan-id'];
	}	
}

// Sets user as registered (set var to 'r' to work) - gfh
$r = ( $_GET['r1'] == 1 ) ? "&r=1" : "";

// Defines Location Matrix
$con = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
mysql_select_db(DB_NAME, $con);

$result = mysql_query("SELECT wp_posts.ID, wp_posts.post_title, wp_postmeta.meta_value FROM wp_posts, wp_postmeta WHERE wp_posts.post_type = 'neighborhoods' AND wp_posts.ID = wp_postmeta.post_id AND wp_postmeta.meta_key = 'map_id' ORDER BY wp_postmeta.meta_value ASC");
for ($num=1; $num<=mysql_numrows($result); $num++){
	$row = mysql_fetch_array($result);
	$location[$num]['post_id'] = $row['ID']; // get post ID for AJAX Interactive Builder - gfh
	$location[$num]['name'] = $row['post_title'];
	$location[$num]['map'] = $row['meta_value'];

  $result2 = mysql_query("SELECT meta_key, meta_value from wp_postmeta where post_id = '".$row['ID']."'");
	while($row2 = mysql_fetch_array($result2)) {		
		if ($row2['meta_key'] == "ib_view"){$location[$num]['active'] = $row2['meta_value'];}
		if ($row2['meta_key'] == "ib_map"){$location[$num]['image'] = $row2['meta_value'];}
		if ($row2['meta_key'] == "ib_lot" || $row2['meta_key'] == "ib_permit"){$location[$num]['cost'] += $row2['meta_value'];}
		if ($row2['meta_key'] == "ib_plans"){$location[$num]['plans'] = $row2['meta_value'];}
	}
}
mysql_close($con);
//echo $location[9]['active'];


	//Since the client changed their minds on having fixed bid quotes, this allows for final price adjustments
function price_adjustments($plan, $location) {
	$adjustment = 0;
	
	if ($location == "Black Horse Estates" && $plan == 520){$adjustment = -20100;} // metolius
	if ($location == "Black Horse Estates" && $plan == 525){$adjustment = 9900;} // rogue
	if ($location == "Black Horse Estates" && $plan == 99999){$adjustment = 44900;} // rogue (modified)
	if ($location == "Black Horse Estates" && $plan == 99999){$adjustment = 4900;} // hamlin
	if ($location == "Black Horse Estates" && $plan == 99999){$adjustment = -30100;} // missouri
	if ($location == "Brookside" && $plan == 523){$adjustment = -15100;} // willamette
	if ($location == "Brookside" && $plan == 512){$adjustment = -16000;} // bachelor
	if ($location == "Brookside" && $plan == 577){$adjustment = -16000;} // bennett
	if ($location == "Brookside" && $plan == 710){$adjustment = -32000;} // jefferson
	if ($location == "Brookside" && $plan == 525){$adjustment = 34900;} // rogue(basic)
	if ($location == "Brookside" && $plan == 701){$adjustment = -16000;} // wilson
	if ($location == "Brookside" && $plan == 702){$adjustment = -16100;} // shilo
	if ($location == "Brookside" && $plan == 99999){$adjustment = -16000;} // applegate
	if ($location == "Brookside" && $plan == 99999){$adjustment = -100;} // hamlin
	if ($location == "Meriwether" && $plan == 99999){$adjustment = -1600;} // lewis
	if ($location == "Meriwether" && $plan == 99999){$adjustment = 1500;} // clark
	if ($location == "Meriwether" && $plan == 99999){$adjustment = 3400;} // monticello
	if ($location == "Meriwether" && $plan == 99999){$adjustment = 2400;} // continental
	if ($location == "Sleepy Hollow" && $plan == 528){$adjustment = -100;} // klamath
	if ($location == "Sleepy Hollow" && $plan == 527){$adjustment = -100;} // mckenzie
	if ($location == "Sleepy Hollow" && $plan == 523){$adjustment = -100;} // willamette
	if ($location == "Sleepy Hollow" && $plan == 518){$adjustment = -20100;} // whitman
	if ($location == "Sleepy Hollow" && $plan == 512){$adjustment = -100;} // bachelor
	if ($location == "Sleepy Hollow" && $plan == 796){$adjustment = -25100;} // summit
	if ($location == "Southern Ridge II" && $plan == 525){$adjustment = 4900;} // rogue (basic)
	if ($location == "Southern Ridge II" && $plan == 699){$adjustment = -44100;} // trask
	if ($location == "Southern Ridge II" && $plan == 796){$adjustment = -50100;} // summit
	if ($location == "Southern Ridge II" && $plan == 99999){$adjustment = -20100;} // hamlin
	if ($location == "Southern Ridge II" && $plan == 99999){$adjustment = 39900;} // rogue (modified)
	if ($location == "Southern Ridge II" && $plan == 99999){$adjustment = -65100;} // missouri
	if ($location == "Sunrise Heights" && $plan == 518){$adjustment = -100;} // whitman
	if ($location == "Sunrise Heights" && $plan == 577){$adjustment = 9900;} // bennett
	if ($location == "Sunrise Heights" && $plan == 710){$adjustment = -6100;} // jefferson
	if ($location == "Sunrise Heights" && $plan == 796){$adjustment = 4900;} // summit
	if ($location == "Sunrise Heights" && $plan == 99999){$adjustment = -10100;} // mckenzie daylight
	if ($location == "Sunrise Heights" && $plan == 99999){$adjustment = -40100;} // avamore
	if ($location == "Sunrise Heights" && $plan == 516){$adjustment = -2100;} // drake
	if ($location == "Sunrise Mountain View" && $plan == 99999){$adjustment = -40100;} // daybreak
	if ($location == "Sunrise Mountain View" && $plan == 99999){$adjustment = 4900;} // twilight
	if ($location == "Sunrise Mountain View" && $plan == 525){$adjustment = 24900;} // rogue (basic)
	if ($location == "Volare" && $plan == 99999){$adjustment = -25600;} // chickadee
	if ($location == "Volare" && $plan == 99999){$adjustment = 400;} // sparrow
	if ($location == "Wenzel Park" && $plan == 702){$adjustment = -14100;} // shilo
	if ($location == "Wenzel Park" && $plan == 701){$adjustment = -10100;} // wilson
	if ($location == "Wenzel Park" && $plan == 699){$adjustment = -9100;} // trask
	if ($location == "Wenzel Park" && $plan == 523){$adjustment = -20100;} // willamette
	if ($location == "Wenzel Park" && $plan == 99999){$adjustment = 4900;} // hamlin
	
	
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

function get_available_location(){
	global $location;
	global $s_plan;
	global $s_location;

	echo "<div id='submenu' style='width:275px;'>";
	echo "<h3>This floorplan is available for:</h3>";

	echo "<ul>";

	if ( isset($s_plan) ){
		for($x=1;$x<=count($location);$x++){
			$tmp = explode (",", $location[$x]['plans']);
			if (in_array($s_plan, $tmp) && $location[$x]['active'] == "true") {
				if ($s_location == $x) {$selected = ' id="selected"';}
				if ( isset( $s_plan ) ) $plan = "&plan=".$s_plan;
				echo "<li><a href='../step3/?location=".$x.$plan."'".$selected.$r." >".$location[$x]['map']." - ".$location[$x]['name']."</a></li>";	
				$selected = "";
			}
		}
	}
	else {
		echo "<li><a href='".get_bloginfo('url')."/interactive-builder/step1/'>First select a Floorplan in Step 1</a></li>";
	}

	echo "</ul></div>";
}

function get_all_location(){
	global $location;

	echo "<div id='submenu' style='width:275px;'>";
	echo "<h3>Select a location:</h3>";
	
	echo "<ul>";
	for($x=1;$x<=count($location);$x++){
		$tmp = explode (",", $location[$x]['plans']);			
		if ($location[$x]['active'] == "true") {
			if ( intval( $s_location ) == intval( $x ) ) {$selected = ' id="selected"';}
			if ( isset( $s_plan ) ) $plan = "&plan=".$s_plan;
			echo "<li><a href='../step2/?location=".$x.$plan."'".$selected.$r." >".$location[$x]['map']." - ".$location[$x]['name']."</a></li>";	
			$selected = "";
		}
	}
	echo "</ul></div>";
}

function get_plan(){
	global $s_location;
	if (isset($_GET['plan'])){
		$post = get_post($_GET['plan']);
		echo get_the_post_thumbnail($post->ID, array(100,100) );
		echo "<span id='title'>".$post->post_title."</span><br />";
		echo "<span id='sqft'>SqFt: ".get_post_meta($post->ID, 'sqft', true)."</span><br/>";
		echo "<span id='sqft'>".get_post_meta($post->ID, 'rooms', true)."</span>";
	}
	else {echo "<div id='error'>No Floorplan Selected</div>";}			
}

function get_location(){
	global $location;
	if (isset($_GET['location'])) {
		echo "<img src='".get_bloginfo('template_directory')."/images/".$location[$_GET['location']]['image']."'>";
	}
	else {echo "<div id='error'>No Location Selected</div>";}				
}

function get_estimate(){
	global $location;
	if (isset ($_GET['plan']) && isset ($_GET['location'])) {
		echo "<span id='estimate'>$" . ib_get_estimate( $s_plan, $location[$s_location]['post_id'] )."</span><br />";	
		echo "Need a lower estimate?<br/>Try selecting a different location.";	
	}
	else {echo "<div id='error'>Your Estimate</div>";}	
}

function calc_estimate(){
	global $location;
	global $s_plan;
	global $s_location;
	
	$estimate = "";
	
	if (isset ($s_plan) && isset ($s_location)) {
		//Gets Plan Price
		$post = get_post($s_plan);
		$price_plan = preg_replace('/\D/', '', get_post_meta($post->ID, 'price', true));
		//$price_sqft = preg_replace('/\D/', '', get_post_meta($post->ID, 'sqft', true)); // removed 1/21/14 at client request - gfh
		$price_location = $location[$s_location]['cost'];	
		$adjustment = price_adjustments($s_plan, $location[$s_location]['name']);
		//$estimate = number_format($price_plan + $price_location + $price_sqft + $adjustment, 2); // removed sqft 1/21/14 at client request - gfh
		$estimate = number_format($price_plan + $price_location + $adjustment, 2);
	}			
	return $estimate;
}

//Determines What Step the Builder is On
$step="";
if (in_array("step1", explode("/", $_SERVER["REQUEST_URI"]))) {$step="1";}
// set to step 1 if they access from a Home Plan page - gfh
else if (in_array("step2", explode("/", $_SERVER["REQUEST_URI"]))) {
	if ( isset($_GET['plan']) && !isset($_GET['location']) ) {
		$step="1'";
	} else {$step="2";}
}
else if (in_array("step3", explode("/", $_SERVER["REQUEST_URI"]))) {$step="3";}

get_header();

if ( $s_plan ) {
	echo '<script type="text/javascript">(function($) { $.removeCookie("ib-plan-id"); $.removeCookie("ib-plan-name"); ';
	$cookiePlanId = '$.cookie( "ib-plan-id", "' . $s_plan . '", { expires: 1, path: "/" } );';
	
	$post = get_post($s_plan);
	$s_plan_name = $post->post_title;
	
	$cookiePlanName = '$.cookie( "ib-plan-name", "' . $s_plan_name . '", { expires: 1, path: "/" } );';
	
	echo $cookiePlanId;
	echo $cookiePlanName;
	
	echo ' })( jQuery )</script>';
}

if ( $s_location ) {
	echo '<script type="text/javascript">(function($) { $.removeCookie("ib-location-id"); $.removeCookie("ib-location-name"); $.removeCookie("ib-location-post"); ';
	$cookieLocId = '$.cookie( "ib-location-id", "' . $s_location . '", { expires: 1, path: "/" } );';
	
	$s_location_name = $location[$s_location]['name'];
	
	$cookieLocName = '$.cookie( "ib-location-name", "' . $s_location_name . '", { expires: 1, path: "/" } );';
	
	$s_location_post = $location[$s_location]['post_id'];
	
	$cookieLocPost = '$.cookie( "ib-location-post", "' . $s_location_post . '", { expires: 1, path: "/" } );';
	
	echo $cookieLocId;
	echo $cookieLocName;
	echo $cookieLocPost;
	
	echo ' })( jQuery )</script>';
}

?>

<script type="text/javascript">
	function ibTracking() {
		<?php if( !is_user_logged_in() ) { echo "_gaq.push(['_trackEvent', 'Form', 'Submit', 'Interactive Builder']);"; } ?>
		jQuery.cookie( "ib-user-name", jQuery( "#ib-name" ).val(), { expires: 1, path: "/" } );
		jQuery.cookie( "ib-user-email", jQuery( "#ib-email" ).val(), { expires: 1, path: "/" } );
		jQuery.cookie( "ib-user-phone", jQuery( "#ib-phone" ).val(), { expires: 1, path: "/" } );
		jQuery.cookie( "ib-user-howYouHeard", jQuery( "#ib-howyouheard" ).val(), { expires: 1, path: "/" } );
		var cLoc = jQuery.cookie( "ib-location-id" );
		var cPlan = jQuery.cookie( "ib-plan-id" );
		window.location = "<?php echo $site_url; ?>/interactive-builder/step3/?r=1&location=" + cLoc + "&plan=" + cPlan;
	}
</script>

<?php

// Google Event Tracking
if (in_array("step1", explode("/", $_SERVER["REQUEST_URI"]))) {googleEvent('Step 1');}
else if (in_array("step2", explode("/", $_SERVER["REQUEST_URI"]))) {googleEvent('Step 2');}
else if (in_array("step3", explode("/", $_SERVER["REQUEST_URI"]))) {
	if (isset($_SESSION['userFirst'])) {googleEvent('Step 3: View Estimate');}
	else {googleEvent('Step 3: Registration');}
}

function googleEvent ($step){
echo "<script type='text/javascript'>_gaq.push(['_trackEvent', 'Interactive Builder', '".$step."']);</script>";		
}
?>

<div id="container">
	<div id="content">
		<div class="grey-heading rounded">
			<div id="post-<?php echo $userCookie; ?>">
				<div id="builder-menu">
					<?php // determines what varibales to pass to pages when using graphic navigation - gfh
					if ( isset( $s_plan ) && isset( $s_location ) ) {
						$gets = "?location=".$s_location."&plan=".$s_plan.$r;
					} else if ( isset( $s_location ) ) {
						$gets = "?plan=".$s_location.$r;
					} else if ( isset( $s_plan ) ) {
						$gets = "?plan=".$s_plan.$r;
					} else {
						$gets = "";
					}
					?>
					<a href="<?php bloginfo('url'); ?>/interactive-builder/step1/<?php echo $gets; ?>"><div id="step1<?php if ($step==1){echo "-on";} ?>"></div></a>
					<a href="<?php bloginfo('url'); ?>/interactive-builder/step2/<?php echo $gets; ?>"><div id="step2<?php if ($step==2){echo "-on";} ?>"></div></a>
					<a href="<?php bloginfo('url'); ?>/interactive-builder/step3/<?php echo $gets; ?>"><div id="step3<?php if ($step==3){echo "-on";} ?>"></div></a>
				</div>
				<?php
				if ( isset( $userCookie ) ) {
					$testCookie = "cookie is ..." . $userCookie . "... here";
				} else {
					$testCookie = "no cookie set";
				}
				?>
				<div class="rounded-content entry-content" data-tesing="<?php echo $testCookie; ?>">			

				<?php if (in_array("step1", explode("/", $_SERVER["REQUEST_URI"]))) {										
					// Step 1 Output
					?>
					<script type="text/javascript">/*(function($) { $.removeCookie("ib-location-id", { path: "/" }); $.removeCookie("ib-location-name", { path: "/" }); console.log("location cookies removed"); })( jQuery );*/</script>
					<div id="int-map"><img width="580" src="<?php echo $map_img; ?>" /></div>

					
					
					<?php get_all_location(); ?>
					<br style="clear:both;" />
					<?
				
				// Step 2 Output	
				} else if (in_array("step2", explode("/", $_SERVER["REQUEST_URI"]))) { ?>
					<?php
					if ( isset( $_GET['plan'] ) && !isset( $_GET['location'] ) ) {
					?>
						<div id="int-map"><img width="580" src="<?php echo $map_img; ?>" /></div>

						<?php

						get_available_location();

					}
					else if( isset($s_location) ) {
						$args = array (
							'post__in' => explode (",", $location[$s_location]['plans']),
							'post_type' => 'home-plans',
							'meta_key' => 'sqft',
							'orderby' => 'meta_value',
							'order' => 'ASC',
							'posts_per_page' => '-1'
						);
						
						$wpQuery = new WP_Query( $args );	
						set_post_thumbnail_size(100,75, true);
						
						if ($wpQuery->have_posts()) {
							while ($wpQuery->have_posts()) {
								$wpQuery->the_post();
								?>							
								<div id="int-plan-box<?php if ($post->ID == $s_plan){echo "-selected";} ?>">					    
						    <?php the_post_thumbnail(); ?>
						    <h2><?php the_title(); ?></h2>
						    <div id="btn-select"><a href="../step3/?plan=<?php echo $post->ID; ?>&location=<?php echo $s_location; ?><?php echo $r; ?>"><img src="<?php bloginfo('template_directory') ?>/images/btn-choosethishome.png" style="border:0px;"></a></div>
						    Sq Feet: <?php echo get_post_meta($post->ID, 'sqft', true); ?><br />
								<a href="<?php the_permalink() ?>">View Details</a>	
								</div>
								<?
							}
							echo "<br style='clear:both;' />";
						}
					}
					else {echo '<div id="error">First select a location in <a href="'.$site_url.'/interactive-builder/step1/">Step 1</a></div>';}
				
				// Step 3 Output
				} else if (in_array("step3", explode("/", $_SERVER["REQUEST_URI"]))) { ?>
					<div id="int-est-box" style="display: none;">
						<div id="int-est-box-plan">
							<span id="title"></span><br />
							<span id="sqft">SqFt: </span><br/>
							<span id="rooms"></span>
						</div>
						<div id="int-est-box-location"><img class="int-est-box-location-img" src="<?php echo $site_url; ?>/wp-content/themes/taliesyhomes/images/" alt=""></div>
						<div id="int-est-box-estimate">
							<span id="estimate">$</span><br />
							Need a lower estimate?<br/>Try selecting a different location.	
						</div>
						<br style="clear:both;" />
						<div id="startover"><a href="../step1/?clear=estimate"><img src="<?php bloginfo('template_directory') ?>/images/builder-startOver.png" border="0" /></a></div>
					</div>
					<div id="message">
						
					</div>
					<div id="contact-left">
	
						<img src="<?php bloginfo('url'); ?>/wp-content/uploads/ib-contactUs.png" />																		
						<div id="disclaimer" style="display: none;">
						*Please note that the estimate provided could change based on actual project details and does not reflect a final price. All information is subject to change without notice and may not be reflected in our models, displays or written materials. See sales professional for specific details. Marketed by TA Liesy Homes Northwest, LLC. All rights reserved. CCB 172302					
						</div>
					</div>
					<div id="contact-right">
						<?php
						$post = get_post($s_plan);
						$plan = $post->post_title;
						$estimate = ib_get_estimate( $post->ID, $location[$s_location]['post_id'] );
						?>
						<script type="text/javascript">
							(function($){
								$(window).load(function(){
									$( "#ib-name" ).val( $.cookie( "ib-user-name" ) );
									$( "#ib-email" ).val( $.cookie( "ib-user-email" ) );
									$( "#ib-phone" ).val( $.cookie( "ib-user-phone" ) );
									$( "#ib-howyouheard" ).val( $.cookie( "ib-user-howYouHeard" ) );
									$( "#ib-location" ).val( "<?php echo $location[$s_location]['name']; ?>" );
									$( "#ib-plan" ).val( "<?php echo $plan; ?>" );
									$( "#ib-estimate" ).val( "$<?php echo $estimate; ?>" );
								});
							})(jQuery);
						</script>
						<?php echo do_shortcode( '[contact-form-7 id="782" title="Interactive Builder"]' ); ?>
					</div>
					<div style="clear:both;"></div>
				<?php } else {the_post(); echo the_content(); }				
				?>												
	
				</div>
			
			</div><!-- .post -->			
		</div><!-- #grey rounded -->
    
    <br style="clear:both;" />
	</div><!-- #content -->
</div><!-- #container -->
	
<?php get_footer(); ?>
