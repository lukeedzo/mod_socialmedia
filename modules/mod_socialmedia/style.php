
<?php

defined('_JEXEC') or die;
require_once dirname(__FILE__) . '/core.php';
/**
 * @version     CVS: 1.0.0
 * @package     Joomla.Modules
 * @subpackage  mod_socialmedia
 *
 * @author      Lukas Plycneris lukasplycneris@protonmail.com
 * @copyright   Copyright (C) 2023 Lukas Plyceris. All rights reserved
 */

/**
 * Social media module style and provides methods to generate CSS styles for it.
 */
class SocialMediaStyle extends SocialMedia
{
    /**
     * Generate CSS styles for a social media module.
     *
     * @param int $module_id The ID of the social media module to generate styles for.
     * @return void
     *
     * @throws Exception If the module with the given ID is not found.
     */
    public function makeStyle($module_id)
    {
        // Get the module and its parameters
        $get_module = $this->getModuleWithParams($module_id);
        $params = $get_module->params;

        // Get container margins and width
        $container_width = $params->get('container_width');
        $margin_top = $params->get('container_margin_top');
        $margin_bottom = $params->get('container_margin_bottom');

        // Get text, link, button, and card background colors
        $text_color = $params->get('card_text_color');
        $links_color = $params->get('card_links_color');
        $links_hover_color = $params->get('card_links_hover_color');
        $button_color = $params->get('card_button_color');
        $card_bg_color = $params->get('card_background_color');

        // Get text and button font sizes
        $card_text_size = $params->get('card_text_size');
        $card_button_size = $params->get('card_button_size');

        // Generate CSS styles
        $css = "
						.social-media-container-{$module_id} {
								margin: 0 auto;
								margin-top: {$margin_top}px;
								margin-bottom: {$margin_bottom}px;
								max-width: {$container_width}px;
						}
						.social-media-container-{$module_id} .setting-text {
								color: {$text_color}!important;
								font-size: {$card_text_size}px!important;
						}
						.social-medlia-container-{$module_id} .setting-text a {
								color: {$links_color}!important;
						}
						.social-medlia-container-{$module_id} .setting-text a::hover {
							color: {$links_hover_color}!important;
						}
						.social-media-container-{$module_id} button {
								color: {$button_color}!important;
								font-size: {$card_button_size}px;
						}
						.social-media-container-{$module_id} .setting-card {
								color: {$button_color}!important;
								background-color: {$card_bg_color}!important;
						}
				";

        // Add media-specific styles
        switch ($params->get('media_type')) {
            case 'facebook':
                $css .= "
										.social-media-container-{$module_id} .setting-text svg {
												fill: {$text_color}!important;
										}
										.social-media-container-{$module_id} .setting-text strong {
												color: {$text_color}!important;
										}
								";
                break;
            case 'instagram':
                // Add Instagram-specific styles here
                break;
        }

        // Add layout-specific styles
        switch ($params->get('media_layout')) {
            case 'default':
                $table_responsive = $params->get('default_on_tablets');
                $small_table_responsive = $params->get('default_on_small_tablets');
                $mobile_portrait = $params->get('default_on_mobile_portrait');
                $mobile = $params->get('default_on_mobile');
                $css .= "
									@media screen and (max-width: 991px) {
										.social-media-container-{$module_id} .social-media-default__card  {
											width: calc({$table_responsive}% - 20px);
										}
									}
									@media screen and (max-width: 767px) {
										.social-media-container-{$module_id} .social-media-default__card {
											width: calc({$small_table_responsive}% - 20px);
										}
									}
									@media screen and (max-width: 657px) {
										.social-media-container-{$module_id} .social-media-default__card {
											width: calc({$mobile_portrait}% - 20px);
										}
									}
									@media screen and (max-width: 575px) {
										.social-media-container-{$module_id} .social-media-default__card {
											width: calc({$mobile}% - 20px);
										}
									}
								";
                break;
            case 'masonry':
                $table_responsive = $params->get('masonry_on_tablets');
                $small_table_responsive = $params->get('masonry_on_small_tablets');
                $mobible_portrait = $params->get('masonry_on_mobile_portrait');
                $mobile = $params->get('masonry_on_mobile');
                $css .= "
									@media screen and (max-width: 991px) {
										.social-media-container-{$module_id} .social-media-masonry__grid-item {
											width: {$table_responsive}%;
										}
									}
									@media screen and (max-width: 767px) {
										.social-media-container-{$module_id} .social-media-masonry__grid-item {
											width: {$small_table_responsive}%;
										}
									}
									@media screen and (max-width: 657px) {
										.social-media-container-{$module_id} .social-media-masonry__grid-item {
											width: {$mobible_portrait}%;
										}
									}
									@media screen and (max-width: 575px) {
										.social-media-container-{$module_id} .social-media-masonry__grid-item {
											width: {$mobile}%;
										}
									}
								";
                break;
            case 'widget':
                // Add widget layout-specific styles here
                break;
            case 'widget':
                // Add widget layout-specific styles here
                break;
        }

        // Add the styles to the HTML document
        JFactory::getDocument()->addStyleDeclaration($css);
    }
}