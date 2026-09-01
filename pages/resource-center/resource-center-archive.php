<?php get_header(); ?>

<div class="contain-1200">

	<!-- <div class="exhibitor-logo" style="position: relative;">
		<div class="support" style="left: 30px;"></div>
		<div class="support" style="right: 30px;"></div>
		<h1>Mirren Live Exhibit Hall</h1>
	</div>-->
	
	<div class="hide-lessthan-1000 map-wrapper">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/pages/resource-center/mirren-eventhall-5.jpg" alt="" usemap="#image-map" />
	</div>
	<div class="hide-morethan-1000 padding-mobile-1050 padding-t-50">
	
		<?php
		$data[0]['name'] = "Trinet";
		$data[0]['statement'] = "TriNet provides agencies with HR solutions to streamline payroll, benefits and more – freeing you to spend less time on HR and more time focusing on culture, serving clients, and growing your business.";
		$data[0]['url'] = "https://www.mirrensummit.com/exhibitors/trinet/";

		$data[1]['name'] = "Deltek";
		$data[1]['statement'] = "Built specifically for agencies, Deltek solutions make managing projects, people and finances easier, so you can focus on what’s important.";
		$data[1]['url'] = "https://www.mirrensummit.com/exhibitors/deltek/";
		
		$data[2]['name'] = "Mavenlink";
		$data[2]['statement'] = "Mavenlink is a comprehensive business management solution, built for agencies, to help efficiently manage resources, improve utilization, and scale your business.";
		$data[2]['url'] = "https://www.mirrensummit.com/exhibitors/mavenlink/";
		
		$data[3]['name'] = "Winmo";
		$data[3]['statement'] = "Winmo helps agencies get in front of the right brands at the right time, providing decision-maker details at thousands of national advertisers, their current agency partners, and the likelihood of when they’ll be hiring new ones.";
		$data[3]['url'] = "https://www.mirrensummit.com/exhibitors/winmo/";
		
		$data[4]['name'] = "Snippies";
		$data[4]['statement'] = "Video production anywhere in the world: research intercept videos, testimonials, pitch videos, animations, case studies, commercials.";
		$data[4]['url'] = "https://www.mirrensummit.com/exhibitors/snippies/";
		
		$data[5]['name'] = "Resonate";
		$data[5]['statement'] = "Resonate modernizes how agencies work from insights to action and research to results. We work with cutting-edge agencies of all sizes from Havas, Huge and Grey to BSSP, Ad Age’s Small Agency of the Year.";
		$data[5]['url'] = "https://www.mirrensummit.com/exhibitors/resonate/";

		$data[6]['name'] = "Armanino";
		$data[6]['statement'] = "Text Goes Here";
		$data[6]['url'] = "https://www.mirrensummit.com/exhibitors/armanino/";

		$data[7]['name'] = "Tobin Leff";
		$data[7]['statement'] = "Text Goes Here";
		$data[7]['url'] = "https://www.mirrensummit.com/exhibitors/tobinleff/";

		$data[8]['name'] = "Other Sponsor Booth 1";
		$data[8]['statement'] = "Text Goes Here";
		$data[8]['url'] = "#";

		$data[9]['name'] = "Other Sponsor Booth 2";
		$data[9]['statement'] = "Text Goes Here";
		$data[9]['url'] = "#";
		
		for ($i=0;$i<count($data);$i++){ ?>
			
			<div class="column-fixed-left padding-b-30">
				<div class="column-left-200 text-centered padding-r-30"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/exhibitor-<?php echo strtolower($data[$i]['name']); ?>.jpg" alt="" /></div>
				<div class="column-main padding-t-25">
					<h4 style="color: #fff;"><a href="<?php echo $data[$i]['url']; ?>" style="color: #fff;"><?php echo $data[$i]['name']; ?></a></h4><?php
					if ($data[$i]['statement']){ ?>
						<p style="font-size: .9rem; line-height: 1.3; margin-bottom: 5px;"><?php echo $data[$i]['statement']; ?></p><?php
					} ?>
					<a href="<?php echo $data[$i]['url']; ?>" style="font-size: .9rem; line-height: 1.3;"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Visit Booth</a>
				</div>
				<div class="clear"></div>
			</div>
			<?php
		}	?>

	</div>
</div>

<map name="image-map">

	<div class="booth-wrap booth-mavenlink">
    	<area class="booth-link" target="" alt="Mavenlink" title="Mavenlink" href="<?php echo $data[2]['url']; ?>" coords="74,303,320,561" shape="rect">
    	<div class="booth-text">
    		<h4><?php echo $data[2]['name']; ?></h4>
    		<p><?php echo $data[2]['statement']; ?></p>
    		<a class="booth-button" href="<?php echo $data[2]['url']; ?>">ENTER</a>
    	</div>
    </div>

    <div class="booth-wrap booth-winmo">
    	<area class="booth-link" target="" alt="Winmo" title="Winmo" href="<?php echo $data[3]['url']; ?>" coords="311,383,531,649" shape="rect">
    	<div class="booth-text">
    		<h4><?php echo $data[3]['name']; ?></h4>
    		<p><?php echo $data[3]['statement']; ?></p>
    		<a class="booth-button" href="<?php echo $data[3]['url']; ?>">ENTER</a>
    	</div>
    </div>

    <div class="booth-wrap booth-trinet">
    	<area target="" alt="Trinet" title="Trinet" href="<?php echo $data[0]['url']; ?>" coords="303,118,512,347" shape="rect">
    	<div class="booth-text">
    		<h4><?php echo $data[0]['name']; ?></h4>
    		<p><?php echo $data[0]['statement']; ?></p>
    		<a class="booth-button" href="<?php echo $data[0]['url']; ?>">ENTER</a>
    	</div>
    </div>
    
	
	<div class="booth-wrap booth-resonate">
		<area target="" alt="Resonate" title="Resonate" href="<?php echo $data[5]['url']; ?>" coords="24,72,262,263" shape="rect">
		<div class="booth-text">
    		<h4><?php echo $data[5]['name']; ?></h4>
    		<p><?php echo $data[5]['statement']; ?></p>
    		<a class="booth-button" href="<?php echo $data[5]['url']; ?>">ENTER</a>
    	</div>
	</div>


    <div class="booth-wrap booth-snippies">
    	<area target="" alt="Snippies" title="Snippies" href="<?php echo $data[4]['url']; ?>" coords="740,259,900,434" shape="rect">
    	<div class="booth-text">
    		<h4><?php echo $data[4]['name']; ?></h4>
    		<p><?php echo $data[4]['statement']; ?></p>
    		<a class="booth-button" href="<?php echo $data[4]['url']; ?>">ENTER</a>
    	</div>
    </div>
    
	<div class="booth-wrap booth-armanino">
		<area target="" alt="Armanino" title="Armanino" href="<?php echo $data[6]['url']; ?>" coords="473,184,693,450" shape="rect">
		<div class="booth-text">
    		<h4><?php echo $data[6]['name']; ?></h4>
    		<p><?php echo $data[6]['statement']; ?></p>
    		<a class="booth-button" href="<?php echo $data[6]['url']; ?>">ENTER</a>
    	</div>
	</div>

	<div class="booth-wrap booth-deltek">
		<area target="" alt="deltek" title="Deltek" href="<?php echo $data[1]['url']; ?>" coords="700,60,880,281" shape="rect">
		<div class="booth-text">
    		<h4><?php echo $data[1]['name']; ?></h4>
    		<p><?php echo $data[1]['statement']; ?></p>
    		<a class="booth-button" href="<?php echo $data[1]['url']; ?>">ENTER</a>
    	</div>
	</div>

	<div class="booth-wrap booth-tobinleff">
		<area target="" alt="tobinleff" title="Tobin Leff" href="<?php echo $data[7]['url']; ?>" coords="938,76,1126,286" shape="rect">
		<div class="booth-text">
    		<h4><?php echo $data[7]['name']; ?></h4>
    		<p><?php echo $data[7]['statement']; ?></p>
    		<a class="booth-button" href="<?php echo $data[7]['url']; ?>">ENTER</a>
    	</div>
	</div>

	<div class="booth-wrap booth-other-1">
		<area target="" alt="other" title="other" href="<?php echo $data[8]['url']; ?>" coords="605,473,793,683" shape="rect">
		<div class="booth-text">
    		<h4><?php echo $data[8]['name']; ?></h4>
    		<p><?php echo $data[8]['statement']; ?></p>
    		<a class="booth-button" href="<?php echo $data[8]['url']; ?>">ENTER</a>
    	</div>
	</div>

	<div class="booth-wrap booth-other-2">
		<area target="" alt="other" title="other" href="<?php echo $data[9]['url']; ?>" coords="974,360,1162,570" shape="rect">
		<div class="booth-text">
    		<h4><?php echo $data[9]['name']; ?></h4>
    		<p><?php echo $data[9]['statement']; ?></p>
    		<a class="booth-button" href="<?php echo $data[9]['url']; ?>">ENTER</a>
    	</div>
	</div>

</map>

<?php get_footer(); ?>