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

class SocialMedia
{
    const MODULE_NAME = 'mod_socialmedia';

    /**
     * Constructs and returns API endpoints for fetching social media data.
     *
     * @param JRegistry $params The module parameters.
     *
     * @return array An array of API endpoints.
     */
    private function getAPI($params)
    {
        $since = urlencode(date('Y-m-d H:i:s', strtotime('-2 months')));
        $until = urlencode(date('Y-m-d H:i:s'));
        $limit = $params->get('max_items');
        $media_type = $params->get('media_type');
        $access_token = $params->get('access_token', $params->get('store_token'));

        $endpoints = [];
        if ($media_type === 'instagram') {
            $endpoints = [
                'feed' => "https://graph.instagram.com/me/media?fields=caption,id,username,profile_picture_url,media_type,media_url,permalink,thumbnail_url,edge_media_preview_like,timestamp&access_token={$access_token}&limit={$limit}",
                'token' => "https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=",
            ];
        } else {
            $page_id = $params->get('page_id');
            $client_id = $params->get('client_id');
            $client_secret = $params->get('client_secret');
            $endpoints = [
                'profile' => "https://graph.facebook.com/{$page_id}/posts?fields=id,name,picture.type(large)&access_token={$access_token}",
                'feed' => "https://graph.facebook.com/v16.0/{$page_id}/feed?access_token={$access_token}&fields=id,message,likes.summary(true),comments.summary(true),full_picture,attachments{type,url,target{id}},created_time,from&since={$since}&until={$until}&limit={$limit}",
                'token' => "https://graph.facebook.com/v16.0/oauth/access_token?grant_type=fb_exchange_token&client_id={$client_id}&client_secret={$client_secret}&fb_exchange_token=",
            ];
        }
        return $endpoints;
    }

    /**
     * Sends an HTTP request to the specified URL and returns the response content.
     *
     * @param string  $url The URL to send the request to.
     *
     * @return string The response content from the server.
     */
    private function requestData($url)
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_RETURNTRANSFER => true,
        ]);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

    /**
     * Retrieves the module and its parameters for a Joomla module ID.
     *
     * @param int $module_id The ID of the Joomla module.
     * @return stdClass An object containing the module and its parameters.
     */
    public function getModuleWithParams($module_id)
    {
        $module = JTable::getInstance('module');
        $module->load((int) $module_id);
        $params = new JRegistry($module->params);
        $result = new stdClass();
        $result->module = $module;
        $result->params = $params;
        return $result;
    }

    /**
     * Retrieves details of a Facebook event from the Graph API.
     *
     * @param string $event_id The ID of the event to retrieve details for.
     * @param string $access_token The access token to use for the API request.
     * @param string $type The type of social media (either 'facebook' or 'instagram').
     * @param JRegistry $params The module parameters.
     *
     * @return stdClass|null The event details as an object, or null if the event cannot be found or an error occurs.
     */
    public function getFacebookEventDetails($event_id, $access_token, $type, $params)
    {
        $cache_time = $params->get('cache_time');
        $url = 'https://graph.facebook.com/v16.0/' . $event_id . '?fields=name,start_time,description,place&access_token=' . $access_token;
        $event = $this->decode($this->cache("{$type}-event{$event_id}", $url, $cache_time, SocialMedia::MODULE_NAME));

        $event_details = new stdClass;
        $event_details->name = $event->name;
        $event_details->start_time = $event->start_time;
        $event_details->description = $event->description;
        $event_details->place = isset($event->place) ? $event->place->name : null;

        return $event_details;
    }

    /**
     * Caches the content of a URL and returns it, using the Joomla caching system.
     *
     * @param string $file The cache file name to use.
     * @param string $url The URL to cache.
     * @param int $cache_time The time in seconds to cache the content for.
     * @param string $cache_group The cache group to use.
     * @param int $module_id The ID of the Joomla module.
     *
     * @return mixed The cached content.
     */
    private function cache($file, $url, $cache_time = 60, $cache_group = SocialMedia::MODULE_NAME, $module_id = 0)
    {
        $cache = JFactory::getCache($cache_group, '');
        $cache->setCaching(true);
        $cache->setLifeTime($cache_time);
        $filename = "{$cache_group}-{$file}{$module_id}";
        if ($cache->contains($filename)) {
            return $cache->get($filename);
        } else {
            $content = $this->requestData($url);
            $cache->store($content, $filename);
            return $content;
        }
    }

    /**
     * Reorganizes data retrieved from a social media API.
     *
     * @param stdClass $data The data retrieved from the API.
     * @param string $type The type of social media (e.g. 'facebook' or 'instagram').
     * @param JRegistry $params The module parameters.
     * @param $access_token The API access token.
     *
     * @return array The reorganized data as an array of objects.
     */
    public function reorganizeSocialMediaData($data, $type, $access_token, $params)
    {
        $posts = [];
        $map = [
            'facebook' => [
                'id' => 'id',
                'message' => 'message',
                'picture' => 'full_picture',
                'likes' => 'likes->summary->total_count',
                'comments' => 'comments->summary->total_count',
                'type' => 'attachments->data[0]->type',
                'url' => 'attachments->data[0]->url',
                'event' => 'event_details',
            ],
            'instagram' => [
                'id' => 'id',
                'message' => 'caption',
                'picture' => 'media_url',
                'type' => 'media_type',
                'url' => 'permalink',
                'thumbnail_url' => 'thumbnail_url',
            ],
        ];

        foreach ($data->data as $post) {
            // Get event details for Facebook event posts
            if ($type === 'facebook' && $post->attachments->data[0]->type === 'event') {
                $event_id = $post->attachments->data[0]->target->id;
                $event_details = $this->getFacebookEventDetails($event_id, $access_token, $type, $params);
                if (!empty($event_details)) {
                    $post->event_details = $event_details;
                }
            }

            $select_data = new stdClass;
            foreach ($map[$type] as $property_name => $map_path) {
                $value = $post;
                foreach (explode('->', $map_path) as $key) {
                    if (is_array($value) && isset($value[$key])) {
                        $value = $value[$key];
                    } elseif (is_object($value) && isset($value->$key)) {
                        $value = $value->$key;
                    } elseif ($property_name === 'type' || $property_name === 'url') {
                        if (empty($post->attachments) || empty($post->attachments->data)) {
                            $value = null;
                        } else {
                            $value = $post->attachments->data[0]->{$property_name};
                        }
                    } else {
                        $value = null;
                        break;
                    }
                }
                $select_data->$property_name = $value;
            }
            $posts[] = $select_data;
        }
        return $posts;
    }

    /**
     * Decodes JSON data into an object.
     *
     * @param string $data The JSON data to decode.
     *
     * @return mixed The decoded data, as an object or array.
     */
    private function decode($data)
    {
        return json_decode($data);
    }

    /**
     * Adds external CSS and JavaScript assets to the document object.
     *
     * @param JDocument $doc The document object to which the assets will be added.
     * @param JRegistry $params The module parameters containing the external asset URLs.
     *
     * @return void
     */
    public function externalAssets($doc, $params)
    {
        $asset_types = array(
            'external_css' => 'addStyleSheet',
            'external_js' => 'addScript',
        );
        foreach ($asset_types as $param_name => $add_method) {
            $urls = json_decode($params->get($param_name), true);
            if (!empty($urls['url'])) {
                foreach ($urls['url'] as $url) {
                    $doc->$add_method($url);
                }
            }
        }
    }

    /**
     * Refreshes the access token for a given module by making a request to the specified URL.
     *
     * @param string $file The cache file name to use for the request.
     * @param string $url The URL to use for the token refresh request.
     * @param int $module_id The ID of the Joomla module to refresh the token for.
     *
     * @return void
     */
    private function refreshToken($file, $url, $module_id)
    {
        $module = JTable::getInstance('module');
        $module->load((int) $module_id);
        $params = new JRegistry($module->params);
        $cache_time = $params->get('cache_time');
        $old_token = $params->get('access_token', $params->get('store_token'));
        $new_token = $this->decode($this->cache($file, $url . $old_token, $cache_time, SocialMedia::MODULE_NAME, $module_id))->access_token;
        $params->set('access_token', $new_token);
        $params->set('store_token', $new_token);
        $module->params = $params->toString();
        $module->store();
    }

    /**
     * Renders social media content for a Joomla module.
     *
     * @param int $module_id The ID of the Joomla module.
     *
     * @return void
     */
    public function renderingSocialMedia($module_id)
    {
        $get_module = $this->getModuleWithParams($module_id);
        $params = $get_module->params;
        $module = $get_module->module;

        $api = $this->getAPI($params);
        $doc = JFactory::getDocument();

        $cache_time = $params->get('cache_time');
        $layout_type = $params->get('media_type');
        $layout_name = $params->get('media_layout');
        $access_token = $params->get('access_token');

        $layout_path = JModuleHelper::getLayoutPath(SocialMedia::MODULE_NAME, $layout_type . '-' . $layout_name);
        $layout_css_path = 'modules/' . SocialMedia::MODULE_NAME . '/assets/css/' . $layout_type . '-' . $layout_name . '.min.css';
        $layout_js_path = 'modules/' . SocialMedia::MODULE_NAME . '/assets/js/' . $layout_name . '.min.js';

        if ($layout_type === 'instagram') {
            $this->refreshToken("instagram-token{$module_id}", $api['token'], $module_id);
            $feed_data = $this->decode($this->cache($layout_type, $api['feed'], $cache_time, SocialMedia::MODULE_NAME, $module_id));
            $output = $this->reorganizeSocialMediaData($feed_data, 'instagram', $access_token, $params);
        } else if ($layout_type === 'facebook') {
            $this->refreshToken("facebook-token{$module_id}", $api['token'], $module_id);
            $feed_data = $this->decode($this->cache($layout_type, $api['feed'], $cache_time, SocialMedia::MODULE_NAME, $module_id));
            // $profile_data = $this->decode($this->cache($layout_type . '-profile', $api['profile_endpoint'], $cache_time, SocialMedia::MODULE_NAME, $module_id));
            $output = $this->reorganizeSocialMediaData($feed_data, 'facebook', $access_token, $params);
        }

        require $layout_path;
        $doc->addScript($layout_js_path);
        $this->externalAssets($doc, $params);
        $doc->addStyleSheet($layout_css_path);
    }
}
