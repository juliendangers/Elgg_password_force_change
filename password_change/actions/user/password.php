<?php
/**
 * Action for changing a user's password
 *
 * @package Elgg
 * @subpackage Core
 */

gatekeeper();

$minlength = 4;
	
$minlength = get_plugin_setting("minlength","password_change");

$current_password = get_input('current_password');
$password = get_input('password');
$password2 = get_input('password2');
$user_id = get_input('guid');

if (!$user_id) {
	$user = get_loggedin_user();
} else {
	$user = get_entity($user_id);
}

if (($user) && ($password != "")) {
	// let admin user change anyone's password without knowing it except his own.
	if (!isadminloggedin() || isadminloggedin() && $user->guid == get_loggedin_userid()) {
		$credentials = array(
			'username' => $user->username,
			'password' => $current_password
		);

		if (!pam_auth_userpass($credentials)) {
			register_error(elgg_echo('user:password:fail:incorrect_current_password'));
			forward(REFERER);
		}
	}

	if (strlen($password) >= $minlength) {
		if ($password == $password2 && $current_password != $password) {
			if(get_plugin_setting("minCheck","password_change") == "yes"){
				$ret = checkPassword($password);
				if($ret == -200){
					register_error(elgg_echo('passwordchange:common'));
					forward($_SERVER['HTTP_REFERER']);
				} else if($ret < 16 ){
					register_error(elgg_echo('passwordchange:tooweak'));
					forward($_SERVER['HTTP_REFERER']);
				} 
			}
			$user->salt = generate_random_cleartext_password(); // Reset the salt
			$user->password = generate_user_password($user, $password);
			$user->lastPwdChange = time();
			if ($user->save()) {
				system_message(elgg_echo('user:password:success'));
			} else {
				register_error(elgg_echo('user:password:fail'));
			}
		} else if($current_password == $password){
			register_error(elgg_echo('passwordchange:same'));
			forward($_SERVER['HTTP_REFERER']);
		} else {
			register_error(elgg_echo('user:password:fail:notsame'));
		}
	} else {
		register_error(elgg_echo('user:password:fail:tooshort'));
	}
}
