(function($){

// get values of GET variables - gfh
function getQueryVariable(variable)
{
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
}

// category of initial filtering - gfh
var queryFilter = getQueryVariable("t");
var initFilter = queryFilter;

function setCategory() {
   if ( !initFilter ) { // if not set, check for category of single - gfh
      var path = window.location.pathname.split( '/' );
      initFilter = path[2];
   }
}

$(window).load(function() {
   
   if ( initFilter ) {
      $( ".tal-post-filters-item[data-filter='." + initFilter + "'" ).addClass( "active" );
   } else {
      $( ".isotopeMenu > li:first-child > a" ).addClass( "active" );
   }
   
   
   // selector for links in menu - gfh
   var menuLinks = $( ".isotopeMenu > li > a:not(.noIso)" );
   
   menuLinks.click(function(){
      menuLinks.removeClass( "active" );
      $(this).addClass( "active" );
   });   
});

$(document).ready(function() {

   setCategory();

   var filterSelector = "*"; // default selector for isotope - gfh
   var $container = $( ".isoContent" ); // set container for isotope container - gfh

   // filter posts on page load based on GET var "t" - gfh
   if ( initFilter ) {
      filterSelector = "." + initFilter;
   }
   
   $container.isotope({ filter: filterSelector });
   
   $( ".tal-post-filters-item:not(.noIso)" ).click(function(){
      // do nothing if already selected
      if ( $(this).hasClass( "active" ) ) {
              return false;
      }
      
      // change selected category
      var $optionSet = $(this).parents( ".tal-post-filters" );
      $optionSet.find( ".active" ).removeClass( "active" );
      $(this).addClass( "active" );
      
      // filter posts
      var selector = $(this).attr( "data-filter" );
      $container.isotope({ filter: selector });
      return false;	
   });
});

})( jQuery );