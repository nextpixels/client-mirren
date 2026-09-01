<?php

	//$heroVideo 					= get_stylesheet_directory_uri()."/images/hero-home-20211221.mp4";
	$heroCTAFormId 			= get_field('hero_cta_hubspot_id');
	$heroButtonLabel 		= get_field('hero_cta_label');

	if (!$heroButtonLabel){
		$heroButtonLabel = "Learn More";
	}
	
	if($options['Content']['Title']){
		$heroTitle =  $options['Content']['Title'];
	}
	if($options['Content']['Text']){
		$heroText =  $options['Content']['Text'];
	}
	if($options['Content']['BackgroundImage']){
		/*  $wrapperStyle .= "background-image: url('".$options['Content']['BackgroundImage']."')"; */
	}
	if($options['Content']['ButtonTarget']){
		$heroButtonTarget =  $options['Content']['ButtonTarget'];
	}
	if($options['Content']['ButtonLabel']){
		$heroButtonLabel = $options['Content']['ButtonLabel'];
	}
	if($options['Content']['PreTitle']){
		$heroPreTitle = $options['Content']['PreTitle'];
	}
	if($options['Content']['HideButton'] == true){
		$hideHeroButton = true;
	}
	
	if (!$options['Settings']['CollapseWidth']){
		$options['Settings']['CollapseWidth'] = 900;
	}
	
?>