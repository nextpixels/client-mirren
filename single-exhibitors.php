
<?php



	$exhibitorName			= get_the_title();

	$exhibitorData 				= get_field("exhibitor_data");




	get_header(); 
	?>
	<div style="padding-top: 70px;"></div>

	<?php

	/*
	$theID = get_the_ID();
	if ((!isset($_GET['MirrenOpenPass'])) or ($_GET['MirrenOpenPass']!=1)) {
	
			if (($theID == '19681') || ($theID == '17667') || ($theID == '18543') || ($theID == '17665') || ($theID == '17669') || ($theID == '17412') || ($theID == '19428') || ($theID == '17666') || ($theID == '19426') || ($theID == '19440') || ($theID == '19931') || ($theID == '20190') || ($theID == '19929')) {
			if ( is_user_logged_in() ) { 

				?>
					<script type="text/javascript">
						console.log('The post id es '+<?php echo $theID ?>);
						console.log('Usuario logueado');
					</script>			
				<?php

			} else {
				?>
					<script type="text/javascript">
						console.log('The post id es '+<?php echo $theID ?>);
						console.log('Usuario NO logueado');
					</script>			
				<?php
				$loginurl = 'https://live.mirren.com/broadcast/login/';
				wp_redirect( $loginurl );
				die();
			}
		}
	
	}

	*/

	?>




<style>

	.gdlr-page-title-wrapper{

		display: none;

	}

</style>






<div class="atmousepopup-window" id="exhibitor-videos" style="position: fixed; width: 100%; height: 100%; z-index: 9999;">

	<div class="atmousepopup-window-content" style="width: 100%; max-width: 600px; height:60%; margin: 0 auto; overflow: auto; box-sizing: border-box;">

	<div class="right"><a href="" class="popup-close-link" data-target="exhibitor-videos" onclick="document.getElementsByClassName('modalVideo')[0].pause(); document.getElementsByClassName('modalVideoTwo')[0].pause();"><i class="fa fa-times-circle-o" aria-hidden="true" style="font-size: 22px;"></i></a></div>

	

	<br />

	<br />

	

		<video class="modalVideo" style="width: 100%; max-width: 445px; margin: 0 auto 20px; display: block;" controls>

			<source src="<?php echo $exhibitorData['video_2']['url']; ?>" type="video/mp4">

			Your browser does not support the video tag.

		</video>



	<?php

	if ($exhibitorData['video_3']['url']){ ?>

		<video class="modalVideoTwo" style="width: 100%; max-width: 445px; margin: 0 auto 20px; display: block;" controls>

			<source src="<?php echo $exhibitorData['video_3']['url']; ?>" type="video/mp4">

			Your browser does not support the video tag.

		</video>



	<?php

	} ?>

	

	<div class="clear"></div>

	

	

	</div>

</div>





<div class="atmousepopup-window" id="exhibitor-description-full" style="position: fixed; width: 100%; height: 100%; z-index: 9999;">

	<div class="atmousepopup-window-content" style="width: 100%; max-width: 600px; height:60%; margin: 0 auto; overflow: auto; box-sizing: border-box;">

	<div class="right"><a href="" class="popup-close-link" data-target="exhibitor-description-full"><i class="fa fa-times-circle-o" aria-hidden="true" style="font-size: 22px;"></i></a></div>

	

	<br />

	<?php echo $exhibitorData['about']; ?>

	</div>

</div>



<?php

	for ($i=1;$i<4;$i++){

		if ($exhibitorData['team_member_name_'.$i]){ ?>

			<div class="atmousepopup-window" id="exhibitor-team-member-<?php echo $i; ?>" style="position: fixed; width: 100%; height: 100%; z-index: 9999;">

			<div class="atmousepopup-window-content" style="max-width: 600px; width: 100%; height: 400px; margin: 0 auto; box-sizing: border-box;">

			

				<div class=""></div>

				<div class="right"><a href="" class="popup-close-link" data-target="exhibitor-team-member-<?php echo $i; ?>"><i class="fa fa-times-circle-o" aria-hidden="true" style="font-size: 22px;"></i></a></div>

					<h3><?php echo $exhibitorData['team_member_name_'.$i]; ?></h3>

					<p><?php echo $exhibitorData['team_member_bio_'.$i]; ?></p>

					

			</div>

			</div><?php

		}

	}

?>



<?php

	for ($i=1;$i<4;$i++){

		if ($exhibitorData['team_member_selfie_'.$i]){ ?>

			

			<div class="atmousepopup-window" id="exhibitor-team-selfie-<?php echo $i; ?>" style="position: fixed; width: 100%; height: 100%; z-index: 9999;">

			<div class="atmousepopup-window-content" style="max-width: 600px; width: 100%; height: 350px; margin: 0 auto; box-sizing: border-box;">

			

				<div class="right"><a href="" class="popup-close-link" data-target="exhibitor-team-selfie-<?php echo $i; ?>" onclick="document.getElementsByClassName('modalVideoTwo-<?php echo $i; ?>')[0].pause();"><i class="fa fa-times-circle-o" aria-hidden="true" style="font-size: 22px;"></i></a></div>



				<br />



				<div class="video-wrapper">

					<video class="modalVideoTwo-<?php echo $i; ?>" style="width: 100%; max-width: 445px;" controls>

						<source src="<?php echo $exhibitorData['team_member_selfie_'.$i]['url']; ?>" type="video/mp4">

						Your browser does not support the video tag.

					</video>

				</div>	

			</div>

			</div><?php

		}

	}

?>



<?php
	$postId = get_the_ID();
	for ($i=1;$i<4;$i++){

		if ($exhibitorData['team_member_contact_'.$i]){ ?>

			<style>
				.exhibitor-team-popup h3{
					color: #000;
				}
				.exhibitor-team-popup div{
					color: #000;
				}
			</style>

			<div class="atmousepopup-window exhibitor-team-popup" id="exhibitor-team-contact-<?php echo $i; ?>" style="position: fixed; width: 100%; height: 100%; z-index: 9999;">

			<div class="atmousepopup-window-content" style="max-width: 600px; width: 100%; height: auto; margin: 0 auto; box-sizing: border-box;">

			

				<div class=""></div>

				<div class="right"><a href="" class="popup-close-link" data-target="exhibitor-team-contact-<?php echo $i; ?>"><i class="fa fa-times-circle-o" aria-hidden="true" style="font-size: 22px;"></i></a></div>

					<div class="p-15">
						<h3 class="p-b-10"><?php echo $exhibitorData['team_member_name_'.$i]; ?></h3>
						<?php echo $exhibitorData['team_member_bio_'.$i]; ?>
						
						<div class="p-t-20">
							<a href="mailto:<?php echo $exhibitorData['team_member_email_'.$i]; ?>"><?php echo $exhibitorData['team_member_email_'.$i]; ?></a><br />
							<a href="tel:+1-<?php echo $exhibitorData['team_member_phone_'.$i]; ?>"><?php echo $exhibitorData['team_member_phone_'.$i]; ?></a>
						</div>
						<?php /*
						<h3><?php echo $exhibitorData['team_member_contact_title_'.$i]; ?></h3>

						<p><?php echo $exhibitorData['team_member_contact_'.$i]; ?></p>

						<a href="<?php echo $exhibitorData['team_member_contact_link_url_'.$i]; ?>" target="_blank" class="link-text"><?php echo $exhibitorData['team_member_contact_link_text_'.$i]; ?></a>
						*/ ?>

					</div>

					

			</div>

			</div><?php

		}

	}

?>



<div style="background: #2b3037;">

<div class="exhibitor-detail" style="background-position: center -60px; overflow: hidden; background-color: #fff;">

	<div class="contain-1200 exhibitor-detail-inner" style="">



		<div>

			<div class="exhibitor-logo">

				<div class="support" style="left: 30px;"></div>

				<div class="support" style="right: 30px;"></div>

				<a href="<?php echo $exhibitorData['website']; ?>" target="_blank"><img src="<?php echo  $exhibitorData['logo']['sizes']['medium']; ?>" alt="" style="max-height: 50px;" /></a>

			</div>

		</div>



		

		<div class="exhibitor-banner exhibitor-banner-left">

			
			<div class="exhibitor-return p-10 hide-lessthan-900" style="margin-top: -20px;"><a href="https://ai.mirren.com/broadcast/"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <strong>Return to Live Broadcast</strong></a></div>

		



			<div class="exhibitor-banner-inner exhibitor-banner-inner-left">

			

				<div class="banner-top hide-lessthan-900"></div>

				

				<div class="exhibitor-banner-background p-l-30 p-r-10 p-t-20">

				

					<div class="exhibitor-banner-left-content">

						<h2><?php echo $exhibitorData['tag_line']; ?></h2>

						<?php echo $exhibitorData['about_short']; ?>

						<br />



						<?php

						if ($exhibitorData['about']){ ?>

						<div class="p-t-10">

							<a href="#" class="atmousepopup-link" data-target="exhibitor-description-full" data-position-x="left" data-position-y="middle"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Read more</a>

						</div>

						<?php } ?>

						<br /><br />

					</div>

					

					<div class="exhibitor-team-wrapper">

						<div class="exhibitor-team-desk hide-lessthan-900"></div>

						<div class="exhibitor-team" style="position: relative; z-index: 10;">

							<?php Print_Members($exhibitorData);	?>

						</div>

					</div>

				

				</div>

				

			</div>

		</div>

		<div class="exhibitor-awards p-l-25">

			<?php if ($exhibitorData['awards_main_title']){ ?>

			<div class="awards-wrap">

				<i class="fa fa-gift" aria-hidden="true"></i>

				<h2 class="p-t-5 awards-main-title"><?php echo $exhibitorData['awards_main_title']; ?></h2>

				<?php if ($exhibitorData['awards_main_description']){ ?>

				<p class="awards-main-description"><?php echo $exhibitorData['awards_main_description']; ?></p>

				<?php } ?>

				<?php Print_Awards($exhibitorData); ?>

			</div>

			<?php }

			if ($exhibitorData['prize_form']){ ?>

			<div class="prize-form">

				<?php echo do_shortcode( $exhibitorData['prize_form'] ); ?>

			</div>

			<?php } ?>



		</div>

		<div class="exhibitor-banner exhibitor-banner-right" style="overflow: visible;">

			<div class="exhibitor-banner-inner exhibitor-banner-inner-right">

			

				<div class="banner-top hide-lessthan-900"></div>

				

				<div class="exhibitor-banner-background p-l-30 p-r-10 p-t-20">

					<?php Print_Video($exhibitorData); ?>



					<div class="resources-wrap">

						<h2 class="p-t-5">Resources</h2>

						<?php Print_Resources($exhibitorData); ?>

					</div>

					

					<div class="exhibitor-resources">

						

						<br />

						<?php Print_Contact($exhibitorData); ?>

					</div>

				

				</div>

				

			</div>

		</div>

		

		

		<div class="clear"></div>

		

	</div>

</div>

</div>



<?php //echo "Name: ".get_field('team_member_name_1');
//print_r($exhibitorData); ?>



 <?php get_footer(); ?>

 

 <?php

 

 

 

function Print_Video($exhibitorData){ ?>



	<div class="video-wrapper">

		<video style="width: 100%; max-width: 445px;" controls>

			<source src="<?php echo $exhibitorData['video_1']['url']; ?>" type="video/mp4">

			Your browser does not support the video tag.

		</video>

	</div>

<?php /*

	<div class="video-wrapper">

		<iframe width="445" height="250" src="<?php echo $exhibitorData['video_url']; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

	</div> */

	?>

	<div class="clear"></div>

	<?php

	if ($exhibitorData['video_2']['url']){ ?>

		<a href="#" class="atmousepopup-link p-t-5" data-target="exhibitor-videos" data-position-x="left" data-position-y="middle"><i class="fa fa-angle-double-right" aria-hidden="true"></i><span>More videos</span></a><?php

	} ?>

	<?php

 }

 

 function Print_Contact($exhibitorData){ 

	

	if ($exhibitorData['website']){ 

		if (!isset($exhibitorData['website_link_text'])){

				$exhibitorData['website_link_text'] = $exhibitorData['website'];

		}

		?>

		<div class="p-b-5">

			<a href="<?php echo $exhibitorData['website']; ?>" target="_blank"><strong><?php echo $exhibitorData['website_link_text'] ; ?></strong></a><br />

		</div><?php

	}

	if ($exhibitorData['linkedin']){ ?>

		<a href="<?php echo $exhibitorData['linkedin']; ?>" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true" style="font-size: 22px; vertical-align: middle;"></i> </a><?php

	}

	if ($exhibitorData['twitter']){ ?>

		<a href="<?php echo $exhibitorData['twitter']; ?>" target="_blank"><i class="fa fa-twitter-square" aria-hidden="true" style="font-size: 22px; vertical-align: middle;"></i> </a><?php

	}

	if ($exhibitorData['facebook']){ ?>

		<a href="<?php echo $exhibitorData['facebook']; ?>" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true" style="font-size: 22px; vertical-align: middle;"></i> </a><?php

	}

	if ($exhibitorData['instagram']){ ?>

		<a href="<?php echo $exhibitorData['instagram']; ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true" style="font-size: 22px; vertical-align: middle;"></i> </a><?php

	}

	if ($exhibitorData['youtube']){ ?>

		<a href="<?php echo $exhibitorData['youtube']; ?>" target="_blank"><i class="fa fa-youtube-square" aria-hidden="true" style="font-size: 22px; vertical-align: middle;"></i> </a><?php

	}
	
	if ($exhibitorData['tiktok']){ ?>

		<a href="<?php echo $exhibitorData['tiktok']; ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri()."/pages/resource-center-exhibitor/tiktok.png"; ?>" style="display: inline-block; vertical-align: middle; width: 20px; margin-left: -2px;" /> </a><?php

	}

	?>

	<div class="p-b-20"></div>

	<?php

 }

 

 function Print_Resources($exhibitorData){

	for ($i=1;$i<9;$i++){

		if ($exhibitorData['resource_title_'.$i]){ ?>

			<div class="resource-item p-b-10">

				<?php

				if (($exhibitorData['resource_file_'.$i])){ 

					//print_r($exhibitorData['resource_file_'.$i]);

					?>

					<i class="fa fa-check-circle" aria-hidden="true"></i> <a href="<?php echo $exhibitorData['resource_file_'.$i]['url']; ?>" target="_blank"><?php echo $exhibitorData['resource_title_'.$i]; ?><i class="fa fa-external-link" aria-hidden="true"></i></a><?php

				} 

				if (($exhibitorData['resource_link_'.$i])){ ?>

					<i class="fa fa-check-circle" aria-hidden="true"></i> <a href="<?php echo $exhibitorData['resource_link_'.$i]; ?>" target="_blank"><?php echo $exhibitorData['resource_title_'.$i]; ?><i class="fa fa-external-link" aria-hidden="true"></i></a><?php

				} ?>

			</div><?php

		}

	}

}

 

function Print_Awards($exhibitorData){

	for ($i=1;$i<4;$i++){

		if ($exhibitorData['award_name_'.$i]){ ?>

			<div class="award-item">

				<h4 class="award-name"><?php echo $exhibitorData['award_name_'.$i]; ?></h4>

				<p class="award-description"><?php echo $exhibitorData['award_description_'.$i]; ?></p>

			</div><?php

		}

	}

}	

 

function Print_Members($exhibitorData){

	for ($i=1;$i<4;$i++){

		if ($exhibitorData['team_member_name_'.$i]){ ?>

			<div style="float: left;min-width: 220px;" class="p-b-30">

				<div class="team-member-item" style="margin-right:20px; position: relative;">

					<?php if ($exhibitorData['team_member_selfie_'.$i]){ ?>

					<a style="" href="#" class="atmousepopup-link selfie-link" data-target="exhibitor-team-selfie-<?php echo $i; ?>" data-position-x="left" data-position-y="bottom"></a><?php

					} ?>

					<?php if ($exhibitorData['team_member_contact_'.$i]){ ?>

					<a style="" href="#" class="atmousepopup-link contact-link" data-target="exhibitor-team-contact-<?php echo $i; ?>" data-position-x="left" data-position-y="bottom"></a><?php

					}

					if ( $exhibitorData['team_member_photo_'.$i]['sizes']['medium']){ ?>
						<img class="exhibitor-member-image" src="<?php echo  $exhibitorData['team_member_photo_'.$i]['sizes']['medium']; ?>" alt="" /><?php
					} 
					else{ ?>
						<div style="width: 120px; height: 125px;"></div><?php
					}
					?>

					<div class="exhibitor-member-label" style="max-width: 200px;">
						<div>
						<h3><?php echo $exhibitorData['team_member_name_'.$i]; ?></h3>

						<h4><?php echo $exhibitorData['team_member_title_'.$i]; ?></h4>
						</div>
					</div>

					<div class="exhibitor-member-contact">
						<div>
							<a href="mailto:<?php echo $exhibitorData['team_member_email_'.$i]; ?>"><?php echo $exhibitorData['team_member_email_'.$i]; ?></a>

							<a href="tel:+1-<?php echo $exhibitorData['team_member_phone_'.$i]; ?>"><?php echo $exhibitorData['team_member_phone_'.$i]; ?></a>

							<?php

							if ($exhibitorData['team_member_bio_'.$i]){ ?>

							<a href="#" class="atmousepopup-link p-t-5" data-target="exhibitor-team-member-<?php echo $i; ?>" data-position-x="left" data-position-y="bottom"><i class="fa fa-angle-double-right" aria-hidden="true"></i>More</a><?php

							} ?>
						</div>
					</div>

				</div>

			</div>

			<?php

			//echo "<br />".$exhibitorData['team_member_name_'.$i];

		}

	} ?>

	<div class="clear"></div><?php

 }

 

 ?>