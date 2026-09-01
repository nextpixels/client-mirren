<?php
if ($options['ContentHtml']){
	
}
else{	?>

	<div class="hero-content-inner" style="width: 100%;">
	
		<div class="hero-title">
			<?php echo $options['HtmlTitle']; 
			if ($options['Title']){?>
				<h1><?php echo $options['Title']; ?></h1><?php
			} ?>
		</div><?php
			
			if (trim($options['SubTitle']) != ""){  ?>
				<div class="hero-sub-title"><?php echo $options['SubTitle']; ?></div><?php
			}
			
			if (trim($options['LeadText']) != ""){  ?>
				<div class="hero-lead-text"><?php echo $options['LeadText']; ?></div><?php
			}
			
			if (trim($options['Text']) != ""){  ?>
				<div class="hero-text"><?php echo $options['Text']; ?></div><?php
			}
			
			if ($options['Button_Href']){	 ?>
				<a href="<?php echo $options['Button_Href']; ?>" class="btn btn-primary"><?php echo $options['Button_Label']; ?></a><?php
			}	
			echo $options['Code'];	
			
	
			if ($options['Image'] && $options['Image_Code_Placement'] == "below"){
				ergo_include_image(get_stylesheet_directory_uri().$options['Image'],"",array('Class'=>'hero-desktop-image '.$options['Image_Class'],'Style'=>$options['Image_Style'])); 
			}
						?>
	
		</div><?php
		
}	?>
	