<?php /* Template Name: HomePage */ ?>
<?php get_header(); ?>

<div id="container">
	<div id="content">
			<!--
			<a href="<?php bloginfo('url') ?>/neighborhoods/sleepy-hollow/"><img src="<?php bloginfo('url') ?>/wp-content/uploads/SleepyHollowGrandOpeningBanner.jpg" border="0" style="padding-bottom:20px;"/></a>
			-->
			<img src="<?php bloginfo('template_directory') ?>/images/hometitle.png" style="padding-left: 20px; padding-bottom: 10px;"/>
		<div id="top" class="rounded grey" style="position: relative;">
			<div id="slidecont">
				<div id="slideshow">			
					<ul>
						<li><img src="<?php bloginfo('template_directory') ?>/images/home_slider/slide11.jpg" /></li>
						<li><img src="<?php bloginfo('template_directory') ?>/images/home_slider/slide3.jpg" /></li>
						<li><img src="<?php bloginfo('template_directory') ?>/images/home_slider/slide10.jpg" /></li>
						<li><img src="<?php bloginfo('template_directory') ?>/images/home_slider/views-slide-01.jpg" /></li>
						<li><img src="<?php bloginfo('template_directory') ?>/images/home_slider/casita-v3-slider.jpg" /></li>
						<li><img src="<?php bloginfo('template_directory') ?>/images/home_slider/kitchen-v3-slider.jpg" /></li>
						<li><img src="<?php bloginfo('template_directory') ?>/images/home_slider/slide1.jpg" /></li>
						<li><img src="<?php bloginfo('template_directory') ?>/images/home_slider/slide8.jpg" /></li>
						<li><img src="<?php bloginfo('template_directory') ?>/images/home_slider/slide9.jpg" /></li>
						<li><img src="<?php bloginfo('template_directory') ?>/images/home_slider/front-v3-slide.jpg" /></li>
						<li><img src="<?php bloginfo('template_directory') ?>/images/home_slider/back-v1-slide.jpg" /></li>
						<li><img src="<?php bloginfo('template_directory') ?>/images/home_slider/great-room-v4-slider.jpg" /></li>
						<li><img src="<?php bloginfo('template_directory') ?>/images/home_slider/slide2.jpg" /></li>
						<li><img src="<?php bloginfo('template_directory') ?>/images/home_slider/slide6.jpg" /></li>
						<li><img src="<?php bloginfo('template_directory') ?>/images/home_slider/views-slide-03.jpg" /></li>
						<li><img src="<?php bloginfo('template_directory') ?>/images/home_slider/slide7.jpg" /></li>
						<li><img src="<?php bloginfo('template_directory') ?>/images/home_slider/sun-mtn-slide-01.jpg" /></li>
						<li><img src="<?php bloginfo('template_directory') ?>/images/home_slider/sun-mtn-slide-02.jpg" /></li>
					</ul>
				</div>
			</div>
			<div id="homefloat">
				<?php the_post() ?>
				<div id="entry-content-home">
					<img src="<?php bloginfo('template_directory') ?>/images/HBA_excellenceAward.png" border="0px">
					<a href="<?php bloginfo('url') ?>/wp-content/uploads/PortlandMonthlyMonitor201310.pdf" target="_blank"><img src="<?php bloginfo('template_directory') ?>/images/talcbutton.png" border="0px"></a>
					<?php /* the_content(); */ ?>
					<div id="signup">
					Notify me when new homes are available to tour:<br/>
						<a href="<?php bloginfo('url'); ?>/new-home-updates/"><img src="<?php bloginfo('template_directory') ?>/images/btn-EmailSignUp.png" border="0px"></a>
				</div>
					
					
					</div>
			</div>
		</div>
		
		<div id="steps">
			<map name="Map" id="Map">
				<area shape="rect" coords="20,80,296,288" href="<?php bloginfo('url'); ?>/interactive-builder/" />
				<area shape="rect" coords="320,78,596,288" href="<?php bloginfo('url'); ?>/interactive-builder/" />
				<area shape="rect" coords="629,76,906,288" href="<?php bloginfo('url'); ?>/interactive-builder/" />
				<area shape="rect" coords="268,322,658,371" href="<?php bloginfo('url'); ?>/interactive-builder/" />
			</map>				
			<img src="<?php bloginfo('template_directory') ?>/images/steps.png" usemap="#Map"/ border="0">
		</div>
    
		<br style="clear:both;" />

	</div><!-- #content -->
</div><!-- #container -->
	
<?php get_footer(); ?>