<?php
/**
 * @version     CVS: 1.0.0
 * @package     Joomla.Modules
 * @subpackage  mod_socialmedia
 *
 * @author      Lukas Plycneris lukasplycneris@protonmail.com
 * @copyright   Copyright (C) 2023 Luaks Plycneris. All rights reserved
 */

defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/style.php';
require_once dirname(__FILE__) . '/core.php';

$socialMediaStyle = new SocialMediaStyle();
$socialMediaStyle->makeStyle($module->id);

$socialMedia = new SocialMedia();
$socialMedia->renderingSocialMedia($module->id);
