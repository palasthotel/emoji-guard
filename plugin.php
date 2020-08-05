<?php

namespace Palasthotel\EmojiGuard;

/*
Plugin Name: Emoji Guard
Plugin URI: https://palasthotel.de
Description: Checks data integrity
Version: 1.0.0
Author: Palasthotel (in Person: Edward Bock, Enno Welbers)
Author URI: https://palasthotel.de
*/

const OPTION_EMOJI_VALIDATION_KEY = "_emoji_guard_validation";
const OPTION_EMOJI_VALUE          = "🛡🦸⚔️";

const FILTER_EMOJI_VALUE = "emoji_guard_value";

function admin_init(){
	// check integrity
	// display warning
	// add dashboard widget?
	// add admin bar icon?
}
add_action('admin_init', __NAMESPACE__.'\admin_init');

/**
 * does the emoji db value pass the integrity check?
 * @return bool
 */
function check_emoji_integrity(){
	try{
		$shouldBe = build_emoji_value();
		$optionValue = get_emoji_option_value();
		return $shouldBe === $optionValue;
	} catch (\Exception $exception){
		return false;
	}
}

/**
 * save emoji string in options
 * @param string $emoji_string
 */
function set_emoji_option_value($emoji_string){
	update_option(OPTION_EMOJI_VALIDATION_KEY, [$emoji_string], false);
}

/**
 * get emoji string from options
 * @return false|string
 */
function get_emoji_option_value(){
	$arr = get_option(OPTION_EMOJI_VALIDATION_KEY);
	if(!is_array($arr) || count($arr) != 1) return false;
	return $arr[0];
}

/**
 * build emoji string for validation
 * @return string
 */
function build_emoji_value() {
	return apply_filters( FILTER_EMOJI_VALUE, OPTION_EMOJI_VALUE, OPTION_EMOJI_VALUE );
}

/**
 * init components on activation
 */
function on_activation() {
	set_emoji_option_value(build_emoji_value());
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\on_activation' );