<?php
/*

The element places a background image within a section -- it can extend beyond the width of that section and can be fully visible on wider screens. On smaller screens, it gets cut off.

For the "content" section, it must have the following style applied to ensure that the content sits above the background image:
z-index: 1; position: relative;

You may also want to add the following style to the section wrapper:
overflow: hidden;

$options['Image'];
$options['ImageClass'];
$options['ImageWidth'];
$options['ImagePlacement']
$options['ImageMarginTop']
$options['ImageMarginRight']
$options['ImageMarginBottom']
$options['ImageMarginLeft']
$options['ContainWidth'];
$options['WrapperClass'];

Sometimes it makes sense not to use the image margins specified above, and just do it with CSS(like moving the image around based on the screen width:
.home-video-background .image-wrapper{
		margin-top: -50px;
		margin-right: -70px;
}
@media(max-width: 1100px){
	.home-video-background .image-wrapper{
			margin-top: -50px;
			margin-right: -100px;
	}
}
*/

$style = "";
$styleImageWrapper = "";

/*
if (!$options['ImagePlacement']){
	$options['ImagePlacement'] = "left";
}
*/
if (!$options['ContainWidth']){
	$options['ContainWidth'] = "1800";
}
if ($options['ImageWidth']){
	$style = "width: ".$options['ImageWidth'];
}	

if ($options['ImageMarginRight']){
	$styleImageWrapper .= "margin-right: ".$options['ImageMarginRight'];
}
if ($options['ImageMarginTop']){
	$styleImageWrapper .= "margin-top: ".$options['ImageMarginTop'];
}
if ($options['ImageMarginBottom']){
	$styleImageWrapper .= "margin-bottom: ".$options['ImageMarginBottom'];
}
if ($options['ImageMarginLeft']){
	$styleImageWrapper .= "margin-left: ".$options['ImageMarginLeft'];
}
if ($options['ImagePlacement']){
	$styleImageWrapper .= $options['ImagePlacement'].": 0";
}
?>

<div class="contain-<?php echo $options['ContainWidth']; ?> <?php echo $options['WrapperClass']; ?>" style="position:relative; z-index: 0;">
	<div class="image-wrapper" style="position: absolute; <?php echo $styleImageWrapper; ?>">
		<?php ergo_include_image($options['Image'],"",array('Class'=>$options['ImageClass'],'Style'=>$style)); ?>
	</div>
</div>
