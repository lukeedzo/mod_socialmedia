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
$moduleTitle = $params->get('show_module_title');?>

 <div class="social-media-container-<?php echo $module->id; ?> social-media-instagram">
	 <?php if ($moduleTitle == 1): ?>
		 <h3 class="social-media-container__title"><?php echo $module->title ?></h3>
	 <?php endif;?>

	 <div class="social-media-masonry">
		 <div class="social-media-masonry__grid">
			 <?php foreach ($output as $post): ?>
				 <div class="social-media-masonry__grid-item">
					 <div class="social-media-masonry__card">
						 <?php if (isset($post->picture)): ?>
						 <div class="social-media-masonry__card-header">
							 <a href="<?php echo $post->url; ?>">
								 <img src="<?php echo ($post->type === 'VIDEO') ? $post->thumbnail_url : $post->picture ?>">
							 </a>
						 </div>
						 <?php endif;?>
						 <div class="social-media-masonry__card-body">
							 <?php if ($showMediaLogo == 1): ?>
								 <div class="social-media-masonry__card-body-logo">
								 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 333333 333333" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd"><defs><linearGradient id="a" gradientUnits="userSpaceOnUse" x1="250181" y1="308196" x2="83152.4" y2="25137"><stop offset="0" stop-color="#f58529"></stop><stop offset=".169" stop-color="#feda77"></stop><stop offset=".478" stop-color="#dd2a7b"></stop><stop offset=".78" stop-color="#8134af"></stop><stop offset="1" stop-color="#515bd4"></stop></linearGradient></defs><path d="M166667 0c92048 0 166667 74619 166667 166667s-74619 166667-166667 166667S0 258715 0 166667 74619 0 166667 0zm-40642 71361h81288c30526 0 55489 24654 55489 54772v81069c0 30125-24963 54771-55488 54771l-81289-1c-30526 0-55492-24646-55492-54771v-81069c0-30117 24966-54771 55492-54771zm40125 43843c29663 0 53734 24072 53734 53735 0 29667-24071 53735-53734 53735-29672 0-53739-24068-53739-53735 0-29663 24068-53735 53739-53735zm0 18150c19643 0 35586 15939 35586 35585 0 19647-15943 35589-35586 35589-19650 0-35590-15943-35590-35589s15940-35585 35590-35585zm51986-25598c4819 0 8726 3907 8726 8721 0 4819-3907 8726-8726 8726-4815 0-8721-3907-8721-8726 0-4815 3907-8721 8721-8721zm-85468-20825h68009c25537 0 46422 20782 46422 46178v68350c0 25395-20885 46174-46422 46174l-68009 1c-25537 0-46426-20778-46426-46174v-68352c0-25395 20889-46177 46426-46177z" fill="url(#a)"></path></svg>
								 </div>
							 <?php endif;?>
							 <div class="social-media-masonry__card-body-content">
								 <div class="social-media-masonry__card-body-content-container collapsed">
									 <div class="setting-text">
										 <?php echo ($post->type === 'event') ? $post->event->description : $post->message ?>
									 </div>
								 </div>
							 </div>
						 </div>
					 </div>
				 </div>
			 <?php endforeach?>
		 </div>
	 </div>
 </div>
