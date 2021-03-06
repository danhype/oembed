<?php
/**
 * This is a fallback view and will try to generate embed code
 *
 * @uses $vars['url']     the original URL which will be embedded
 * @uses $vars['adapter'] the Embed\Adapters\Adapter to get information from
 */

use Embed\Adapters\Adapter;

$adapter = elgg_extract('adapter', $vars);
if (!($adapter instanceof Adapter)) {
	return;
}

// change embed width to 100%
$adjust_width = function($match) {
	
	if (!isset($match[1])) {
		return $match[0];
	}
	
	return 'width="100%"';
};
// adjust embed height to plugin setting (if any)
$adjust_height = function($match) {
	
	if (!isset($match[1])) {
		return $match[0];
	}
	
	$new_height = (int) elgg_get_plugin_setting('default_height', 'oembed', 300);
	
	return "height=\"{$new_height}\"";
};

$code = preg_replace_callback('/width=[\"\'](\d+\w*)[\"\']/', $adjust_width, $adapter->getCode());
$code = preg_replace_callback('/height=[\"\'](\d+\w*)[\"\']/', $adjust_height, $code);

echo $code;
