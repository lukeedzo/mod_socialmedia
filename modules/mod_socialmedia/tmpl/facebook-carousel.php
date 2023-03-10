<?php defined('_JEXEC') or die;
/**
 * @version     CVS: 1.0.0
 * @package     Joomla.Modules
 * @subpackage  mod_socialmedia
 *
 * @author      Lukas Plycneris lukasplycneris@protonmail.com
 * @copyright   Copyright (C) 2023 Lukas Plyceris. All rights reserved
 */

$showMediaLogo = $params->get('show_media_logo');
$showCardFooter = $params->get('show_card_footer');
$moduleTitle = $params->get('show_module_title');?>

<div class="social-media-container-<?php echo $module->id; ?> social-media-facebook">
	<?php if ($moduleTitle == 1): ?>
	<h3 class="social-media-container__title"><?php echo $module->title ?></h3>
	<?php endif;?>
	<div class="social-media-carousel swiper">
		<div class="social-media-carousel__navigation">
			<div class="social-media-carousel__navigation-button prev slider-prev-<?php echo $module->id; ?>"></div>
			<div class="social-media-carousel__navigation-button next slider-next-<?php echo $module->id; ?>"></div>
		</div>
		<div module="<?php echo $module->id; ?>" class="swiper-container swiper-carousel-<?php echo $module->id ?>">
			<div class="swiper-wrapper">
				<?php foreach ($output as $post): ?>
				<div class="swiper-slide">
					<div class="social-media-carousel__card setting-card">
						<?php if (isset($post->picture)): ?>
						<div class="social-media-carousel__card-header">
							<a href="<?php echo $post->url; ?>">
								<img class="swiper-lazy" src="<?php echo $post->picture ?>">
							</a>
						</div>
						<?php endif?>
						<div class="social-media-carousel__card-body">
							<?php if ($showMediaLogo == 1): ?>
							<div class="social-media-carousel__card-body-logo">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
									<g fill="none">
										<circle cx="12" cy="12" r="10" fill="#0076FB"></circle>
										<path fill="#FFF"
											d="M16.167 6.167v2.639h-1.842a1.04 1.04 0 00-1.048 1.03v2.04h2.843l-.393 2.935h-2.45v7.067a10.457 10.457 0 01-2.982.03v-7.097H7.833v-2.934h2.462V9.412c0-1.792 1.477-3.245 3.298-3.245h2.574z">
										</path>
									</g>
								</svg>
							</div>
							<?php endif;?>
							<div class="social-media-carousel__card-body-content">
								<div class="social-media-carousel__card-body-content-container collapsed">
									<div class="setting-text">
										<?php echo ($post->type === 'event') ? $post->event->description : $post->message ?>
									</div>
								</div>
							</div>
						</div>
						<?php if ($showCardFooter == 1): ?>
						<div class="social-media-carousel__card-footer">
							<div class="social-media-carousel__card-footer-icons setting-text">
								<span class="social-media-carousel__card-footer-icon-container">
									<svg xmlns="http://www.w3.org/2000/svg" fill="#666666" viewBox="0 0 512 512" alt="thumbs up icon"
										class="social-media-carousel__card-footer-icon">
										<path
											d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.2s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z">
										</path>
									</svg>
									<strong class="social-media-carousel__card-footer-likes"><?php echo $post->likes ?></strong>
								</span>
								<span class="social-media-carousel__card-footer-icon-container">
									<svg xmlns="http://www.w3.org/2000/svg" fill="#666666" viewBox="0 0 512 512" alt="comment icon"
										class="social-media-carousel__card-footer-icon">
										<path
											d="M123.6 391.3c12.9-9.4 29.6-11.8 44.6-6.4c26.5 9.6 56.2 15.1 87.8 15.1c124.7 0 208-80.5 208-160s-83.3-160-208-160S48 160.5 48 240c0 32 12.4 62.8 35.7 89.2c8.6 9.7 12.8 22.5 11.8 35.5c-1.4 18.1-5.7 34.7-11.3 49.4c17-7.9 31.1-16.7 39.4-22.7zM21.2 431.9c1.8-2.7 3.5-5.4 5.1-8.1c10-16.6 19.5-38.4 21.4-62.9C17.7 326.8 0 285.1 0 240C0 125.1 114.6 32 256 32s256 93.1 256 208s-114.6 208-256 208c-37.1 0-72.3-6.4-104.1-17.9c-11.9 8.7-31.3 20.6-54.3 30.6c-15.1 6.6-32.3 12.6-50.1 16.1c-.8 .2-1.6 .3-2.4 .5c-4.4 .8-8.7 1.5-13.2 1.9c-.2 0-.5 .1-.7 .1c-5.1 .5-10.2 .8-15.3 .8c-6.5 0-12.3-3.9-14.8-9.9c-2.5-6-1.1-12.8 3.4-17.4c4.1-4.2 7.8-8.7 11.3-13.5c1.7-2.3 3.3-4.6 4.8-6.9c.1-.2 .2-.3 .3-.5z">
										</path>
									</svg>
									<strong class="social-media-carousel__card-footer-comments"><?php echo $post->comments ?></strong>
								</span>
							</div>
						</div>
						<?php endif;?>
					</div>
				</div>
				<?php endforeach;?>
			</div>
		</div>
	</div>
</div>