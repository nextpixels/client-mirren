<?php
//Creates a page with website global values

function theme_settings_page(){ 	?>

	<div class="wrap">
		<h1>Website Settings</h1>
		<form method="post" action="options.php">
			<?php
			settings_fields("section");
			do_settings_sections("theme-options");
			submit_button();
			?>
		</form>
	</div><?php 
}

function display_custom_info_fields(){
	
	add_settings_section("section", "", null, "theme-options");
	
	$inputSettings[] = array(
		"name"			=> "company_phone",
		"label" 				=> "Phone",
		"placeholder" 	=> "Enter Phone"
	);
	
	$inputSettings[] = array(
		"name"			=> "company_email",
		"label" 				=> "Email",
		"placeholder" 	=> "Enter Email"
	);
	
	$inputSettings[] = array(
		"name"			=> "company_phone_tollfree",
		"label" 				=> "Phone (Toll Free)",
		"placeholder" 	=> "Enter Phone"
	);
	
	$inputSettings[] = array(
		"name"			=> "company_address",
		"label" 				=> "Address",
		"placeholder" 	=> "Enter Address"
	);
	
	$inputSettings[] = array(
		"name"			=> "social_linkedin",
		"label" 				=> "LinkedIn Url",
		"placeholder" 	=> ""
	);
	
	$inputSettings[] = array(
		"name"			=> "social_facebook",
		"label" 				=> "Facebook Url",
		"placeholder" 	=> ""
	);
	
	$inputSettings[] = array(
		"name"			=> "social_twitter",
		"label" 				=> "Twitter Url",
		"placeholder" 	=> ""
	);
	
	$inputSettings[] = array(
		"name"			=> "social_youtube",
		"label" 				=> "Youtube Url",
		"placeholder" 	=> ""
	);
	
	$inputSettings[] = array(
		"name"			=> "herocta_title",
		"label" 				=> "Hero CTA Title",
		"placeholder" 	=> ""
	);
		
	$inputSettings[] = array(
		"name"			=> "herocta_text",
		"label" 				=> "Hero CTA Text",
		"placeholder" 	=> ""
	);
	
	$inputSettings[] = array(
		"name"			=> "herocta_button_target",
		"label" 				=> "Hero CTA Button Target",
		"placeholder" 	=> ""
	);

	$inputSettings[] = array(
		"name"			=> "herocta_button_label",
		"label" 				=> "Hero CTA Button Label",
		"placeholder" 	=> ""
	);
	


	
	for ($i=0;$i<count($inputSettings);$i++){
		add_settings_field($inputSettings[$i]['name'], $inputSettings[$i]['label'], "display_custom_field", "theme-options", "section",$inputSettings[$i]);
		register_setting("section", $inputSettings[$i]['name']);
	}
	
		
}
add_action("admin_init", "display_custom_info_fields");


function display_custom_field($settings){
	$settings['value'] 					= get_option($settings['name']);	 ?>
	<input type="text" name="<?php echo $settings['name']; ?>" placeholder="<?php echo $settings['placeholder']; ?>" value="<?php echo $settings['value']; ?>" size="35"><?php 
}


 //Ad this page to the wordpress menu:
	function add_custom_info_menu_item(){
		add_options_page("Website Settings", "Website Settings", "manage_options", "contact-info", "theme_settings_page");
	}
	add_action("admin_menu", "add_custom_info_menu_item");