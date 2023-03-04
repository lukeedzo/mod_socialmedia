
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
								color: {$inks_color}!important;
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
                // Add default layout-specific styles here
                break;
            case 'masonry':
                // Add masonry layout-specific styles here
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