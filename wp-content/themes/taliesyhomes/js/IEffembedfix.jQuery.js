(function($) {
    $.fn.ieffembedfix = function() {
		var pngimgurl = "../images/hIEfix.png";
    	return this.each(function() {
        	//check for IE7/8
	        if (jQuery.support.objectAll == false) {
    	        $(this).css({
					filter: 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src=" + pngimgurl + ",sizingMethod=crop',
					zoom: '1'
				});
        	}
	    });
    };
	// Apply font fix to all elements
	$('*').ieffembedfix();
})(jQuery);