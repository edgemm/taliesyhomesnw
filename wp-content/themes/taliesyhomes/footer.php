	<div id="footer">
	</div><!-- #footer -->

</div><!-- #wrapper .hfeed -->

</div><!--outerwrapper-->
<div id="bottomwrap">

	<div id="footercontent">
	
		<p><a href="<?php bloginfo('url'); ?>">Home</a> | 
			 <a href="<?php bloginfo('url'); ?>/home-plans/">Available Plans</a> | 
			 <a href="<?php bloginfo('url'); ?>/neighborhoods/">Neighborhoods</a> | 
			 <a href="<?php bloginfo('url'); ?>/projects/">Current Projects</a> | 
			 <a href="<?php bloginfo('url'); ?>/showcase-features/">Showcase Features</a> |
			 <a href="<?php bloginfo('url'); ?>/news/">News & Media</a> | 
			 <a href="<?php bloginfo('url'); ?>/our-team/">Our Team</a> |
			 <a href="<?php bloginfo('url'); ?>/client-login/">Client Login</a> | 
			 <a href="<?php bloginfo('url'); ?>/2-10-warranty/">Warranty</a> 
			 <?php  if (isset($_COOKIE['userFirst'])){ echo " | <a href='".get_bloginfo('template_directory')."/page-interactive-builder.php?clear=user'>Log Out</a>";} ?>			  
		</p>
		<p>&#169 <?php echo date('Y'); ?> TA Liesy Homes NW CCB # 172302</p>
		<p>12042 SE Sunnyside Road #475, Clackamas, OR 97015<br />
		Phone: 503.761.6259 | Fax: 503.761.1378</p>
		<p><a href="http://portal.hud.gov/portal/page/portal/HUD" target="_blank"><img border="0" src="<?php bloginfo('template_directory') ?>/images/fairhousing.png" alt="" /></a>&nbsp;&nbsp;&nbsp;<a href="http://hbapdx.org" target="_blank"><img border="0" src="<?php bloginfo('template_directory') ?>/images/logo_hba_small.gif" alt="" /></a><img src="<?php bloginfo('template_directory') ?>/images/HBA_excellenceAward.jpg"></p>
		<p>Hosted by Edge Multimedia <a href="http://www.edgemm.com" target="blank"> Portland Advertising Agency</a></p>
	</div>	

</div>
<?php wp_footer() ?>
</body>
</html>