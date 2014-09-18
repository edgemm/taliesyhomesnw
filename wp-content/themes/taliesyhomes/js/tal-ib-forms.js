(function($){

//if ( $.cookie( "ib-location-post" ) ) { console.log("loc post id set... " + $.cookie( "ib-location-post" )); } else { console.log("loc post id not set"); }
//if ( $.cookie( "ib-location-id" ) ) { console.log("loc id set... " + $.cookie( "ib-location-id" )); } else { console.log("loc id not set"); }
//if ( $.cookie( "ib-location-name" ) ) { console.log("loc name set... " + $.cookie( "ib-location-name" )); } else { console.log("loc name not set"); }
//if ( $.cookie( "ib-plan-id" ) ) { console.log("plan id set... " + $.cookie( "ib-plan-id" )); } else { console.log("user id not set"); }
//if ( $.cookie( "ib-plan-name" ) ) { console.log("plan name set... " + $.cookie( "ib-plan-name" )); } else { console.log("plan name not set"); }
//if ( $.cookie( "ib-user-name" ) ) { console.log("user name set... " + $.cookie( "ib-user-name")); } else { console.log("user name not set"); }
//if ( $.cookie( "ib-user-email" ) ) { console.log("user email set... " + $.cookie( "ib-user-email")); } else { console.log("user email not set"); }
//if ( $.cookie( "ib-user-phone" ) ) { console.log("user phone set... " + $.cookie( "ib-user-phone")); } else { console.log("user phone not set"); }

$(document).ready(function(){

// test to see if user has registered already
if ( $.cookie( "ib-user-name" ) ) {
	$.ajax({
		type: "post",
		dataType: "json",
		//url: window.location.href.replace(window.location.pathname, '') + "/wp-admin/admin-ajax.php",
		url: "http://taliesyhomesnw.com/wp-admin/admin-ajax.php",
		data: {
			action: "ib_submitted",
			loc_id: 	$.cookie( "ib-location-post" ),
			loc_name:	$.cookie( "ib-location-name" ),
			plan_id: 	$.cookie( "ib-plan-id" ),
			plan_name:	$.cookie( "ib-plan-name" ),
			user_name:	$.cookie( "ib-user-name" ),
			user_email:	$.cookie( "ib-user-email" ),
			user_phone: 	$.cookie( "ib-user-phone" )
		},
		success: function( response ) {
			//console.log( "plan id: " + response.plan_id );
			if ( response.plan_error || response.loc_error ) {
				console.log( "there was a error" );
				$( "#int-est-box-plan" ).html( "<div id='error'>No Floorplan Selected</div>" );
				$( "#int-est-box-location" ).html( "<div id='error'>No Location Selected</div>" );
				$( "#int-est-box-estimate" ).html( "<div id='error'>Your Estimate</div>" );
				$( "#message" ).html( "<p>Your estimate will be ready to view once you take a moment to fill out the following fields.</p><p>Thank you for your interest in TA Liesy Homes Northwest.</p>" );
			} else {
				// populate plan information - gfh
				$( "#int-est-box-plan" ).prepend( response.plan_thmb );
				$( "#int-est-box-plan #title" ).text( response.plan_name );
				$( "#int-est-box-plan #sqft" ).text( "Sqft: " + response.plan_sqft );
				$( "#int-est-box-plan #rooms" ).text( response.plan_rooms );

				// populate location image - gfh
				var loc_img = $( ".int-est-box-location-img" );
				var loc_img_src = loc_img.attr( "src" );
				loc_img.attr( "src", loc_img_src + response.loc_img );
				loc_img.attr( "alt", response.loc_title );

				// populate estimate numbers - gfh
				$( "#int-est-box-estimate #estimate" ).append( response.estimate );

				// populate text areas with text for estimate
				var est_message = "Congratulations!  You've just taken the first steps to building your dream home!  Use the contact form below to send the home you've selected directly to our team.  One of our realtors will be in touch with you to discuss the next steps."
				$( "#message" ).html( est_message );
				$( "#disclaimer" ).show();
			}

			$( "#int-est-box" ).slideDown();
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
		}
	});
	
} else {
	$( "#message" ).html( "<p>Your estimate will be ready to view once you take a moment to fill out the following fields.</p><p>Thank you for your interest in TA Liesy Homes Northwest.</p>" );
}

});

})(jQuery);