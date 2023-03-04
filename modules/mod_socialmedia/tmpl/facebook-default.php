<?php

defined('_JEXEC') or die;

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
$moduleTitle = $params->get('show_module_title');
?>

<div class="social-media-container-<?php echo $module->id; ?> social-media-facebook">
 <?php if ($moduleTitle == 1): ?>
	 <h3 class="social-media-container__title"><?php echo $module->title ?></h3>
 <?php endif;?>

 <div class="social-media-default">
	 <?php foreach ($output as $post): ?>
		 <div class="social-media-default__card setting-card">
			 <div class="social-media-default__card-header">
				 <a href="<?php echo $post->url; ?>">
					 <img src="<?php echo $post->picture ?>">
				 </a>
			 </div>

			 <div class="social-media-default__card-body">
				 <?php if ($showMediaLogo == 1): ?>
					 <div class="social-media-default__card-body-logo">
						 <img src="modules/mod_socialmedia/assets/img/facebook-logo.svg">
					 </div>
				 <?php endif;?>

				 <div class="social-media-default__card-body-content">
					 <div class="social-media-default__card-body-content-container collapsed">
						 <div class="setting-text">
							 <?php echo ($post->type === 'event') ? $post->event->description : $post->message ?>
						 </div>
					 </div>
				 </div>
			 </div>

			 <?php if ($showCardFooter == 1): ?>
				 <div class="social-media-default__card-footer">
					 <div class="social-media-default__card-footer-icons setting-text">
						 <span class="social-media-default__card-footer-icon-container">
							 <img src="modules/mod_socialmedia/assets/img/icons/thumbs-up-regular.svg" alt="thumbs up icon" class="icon">
							 <strong class="like-count"><?php echo $post->likes ?></strong>
						 </span>
						 <span class="social-media-default__card-footer-icon-container">
							 <img src="modules/mod_socialmedia/assets/img/icons/comment-regular.svg" alt="comment icon" class="icon">
							 <strong class="comment-count"><?php echo $post->comments ?></strong>
						 </span>
					 </div>
				 </div>
			 <?php endif;?>
		 </div>
	 <?php endforeach;?>
 </div>
</div>