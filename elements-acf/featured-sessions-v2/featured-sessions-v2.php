<?php

	require_once(get_template_directory()."/functions/ergo-get-posts-from-args.php");
	require_once(get_template_directory()."/zephyr-functions/str-format-for-url.php");
	require_once(get_template_directory()."/functions/ergo-include-image.php");

	include_once(get_template_directory()."/functions/ergo-embed-styles-scripts.php");

	ergo_embed_styles_scripts(__DIR__);

	$blockData['cssClass'] = "background-light-blue";

	//Get the "session" repeater's rows into $sessions:
		$sessions = array();
		if (have_rows('session')) {
			$count = 0;
			while (have_rows('session')) {
				the_row();

				$sessions[$count]['Title'] 					= get_sub_field('title');
				$sessions[$count]['SubTitle'] 				= get_sub_field('sub_title');
				$sessions[$count]['SpeakerAgency'] 			= get_sub_field('speaker_agency');
				$sessions[$count]['SpeakerName'] 			= get_sub_field('speaker_name');
				$sessions[$count]['Image'] 					= get_sub_field('image');
				$sessions[$count]['TileBackgroundColor']	= get_sub_field('tile_background_color');
				$sessions[$count]['Tab']						= get_sub_field('tab');

				$count++;
			}
		}

	//Get the "tabs" repeater's rows into $tabsMeta, keyed by position (row 1 = tab "1", row 2 =
	//tab "2", etc.) -- there's no explicit tab-number sub-field, so this lines up with the
	//"tab" select field on each session purely by row order:
		$tabsMeta = array();
		if (have_rows('tabs')) {
			$tabNum = 1;
			while (have_rows('tabs')) {
				the_row();
				$tabsMeta[$tabNum]['Title'] = get_sub_field('tab_title');
				$tabsMeta[$tabNum]['Text']  = get_sub_field('tab_text');
				$tabNum++;
			}
		}

	//Which tab numbers (1-5) are actually in use, in order. Sessions with no tab value set
	//(blank/legacy rows) are left out of every tab -- see note further down where they're
	//rendered. If no session has a tab set at all, $usedTabs stays empty and the whole tab UI
	//is skipped below, leaving today's single flat grid exactly as it was.
		$usedTabs = array();
		foreach ($sessions as $session){
			if ($session['Tab'] !== '' && $session['Tab'] !== null && !in_array($session['Tab'],$usedTabs)){
				$usedTabs[] = $session['Tab'];
			}
		}
		sort($usedTabs, SORT_NUMERIC);

		$hasTabs = !empty($usedTabs);

	//With only one tab in use, there's nothing to switch between, so skip the tab nav itself --
	//that one tab's content still renders (it's just always the one shown, with no link to click):
		$showTabNav = $hasTabs && count($usedTabs) > 1;

?>

<style><?php
	$tileNumber = 0;
	foreach($sessions as $session){

		if (!empty($session['TileBackgroundColor'])){
			echo ".featured-sessions-tile-".$tileNumber."{background-color: ".$session['TileBackgroundColor'].";}";
		}

		//Only use the image as a background above 900px -- below that it's shown as a regular
		//<img> at the bottom of the tile instead (see the "hide-lessthan-900" image in the markup below):
		if (!empty($session['Image'])){
			echo "@media (min-width: 901px){";
				echo ".featured-sessions-tile-".$tileNumber."{background-image: url('".$session['Image']."'); background-repeat: no-repeat; background-position: bottom right;}";
			echo "}";
		}

		$tileNumber++;
	}	?>
</style>

<?php
//Renders a single session tile. $tileNumber must be the session's original index in $sessions
//(not its position within a tab's filtered list), since that's the number the <style> block
//above already generated this tile's background-color/image rule against.
//
//Guarded with function_exists since ACF block render templates get require()'d (not
//require_once'd) per instance -- without this, a second copy of this block on the same page
//would fatal with "Cannot redeclare function".
if (!function_exists('render_featured_session_tile')){
	function render_featured_session_tile($session,$tileNumber){ ?>
		<div class="featured-sessions-tile featured-sessions-tile-<?php echo $tileNumber; ?>">

			<div class="featured-sessions-tile-content">

				<h3><?php echo $session['Title']; ?></h3>
				<div class="featured-sessions-tile-subtitle"><?php echo $session['SubTitle']; ?></div>

				<div class="featured-sessions-tile-person p-t-50">
					<div class="featured-sessions-tile-agency"><?php echo $session['SpeakerAgency']; ?></div>
					<div class="featured-sessions-tile-person-name"><?php echo $session['SpeakerName']; ?></div>
				</div>

			</div>
			<?php if (!empty($session['Image'])){
				ergo_include_image($session['Image'],"",array('Class' => 'featured-sessions-tile-image hide-morethan-900'));
			} ?>

		</div><?php
	}
}
?>

<section class="featured-sessions-v2 p-t-25 p-b-75 <?php echo $blockData['cssClass']; ?>"><?php

	if ($hasTabs){ ?>

		<?php if ($showTabNav){ ?>
			<div class="contain-1100 p-mobile-1150 featured-sessions-tabs"><?php
				foreach ($usedTabs as $i => $tabNum){
					$tabLabel = !empty($tabsMeta[$tabNum]['Title']) ? $tabsMeta[$tabNum]['Title'] : "Tab ".$tabNum; ?>
					<a href="#" class="featured-sessions-tab-link <?php echo ($i == 0) ? 'current' : ''; ?>" data-target="<?php echo $tabNum; ?>"><?php echo $tabLabel; ?></a><?php
				} ?>
			</div><?php
		} ?>

		<?php foreach ($usedTabs as $i => $tabNum){ ?>
			<div id="featured-sessions-tab-content-<?php echo $tabNum; ?>" class="featured-sessions-tab-content <?php echo ($i == 0) ? 'current' : ''; ?>"><?php
				if (!empty($tabsMeta[$tabNum]['Text'])){ ?>
					<div class="contain-600 p-mobile-650 featured-sessions-tab-text text-center"><?php echo $tabsMeta[$tabNum]['Text']; ?></div><?php
				} ?>
				<div class="contain-1100 p-mobile-1150 columns-grid columns-grid-2 column-gap-30 row-gap-30 collapse-800"><?php
					foreach ($sessions as $tileNumber => $session){
						if ($session['Tab'] != $tabNum){
							continue;
						}
						render_featured_session_tile($session,$tileNumber);
					} ?>
				</div>
			</div><?php
		}

	}
	else{ ?>

		<div class="contain-1100 p-mobile-1150 columns-grid columns-grid-2 column-gap-30 row-gap-30 collapse-800"><?php
			foreach($sessions as $tileNumber => $session){
				render_featured_session_tile($session,$tileNumber);
			} ?>
		</div><?php

	} ?>
</section>
