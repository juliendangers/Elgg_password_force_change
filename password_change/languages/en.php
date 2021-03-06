<?php
	/**
	 * Password change language pack
	 * 
	 */

	$english = array(
	
			'passwordchange:renew' => "Your password expired, You have to create a new one to continue",
			'passwordchange:length'=>"Minimum password length",
			'passwordchange:dayslong'=>"Password validity (in days)",
			'passwordchange:strengh'=>"Check password strength",
			'passwordchange:common' => "Unsafe password! You have to change it.",
			'passwordchange:tooweak' => "Password too weak!",
			'Too short' => "Too short",
			'Too weak' =>"Too weak",
			'Weak'=>"Weak",
			'Medium'=>"Medium",
			'Strong'=>"Strong",
			'Very strong'=>"Very strong",
			'passwordchange:minlength'=>"Nombre minimum de charactères",
			'passwordchange:same' => "Current password and new password must be different",
			'passwordchange:unsafe'=>"Unsafe password word",
			'passwordchange:start'=>"Set time_created as start date (default is next connection after the activation of the plugin)? Will force older users to change their password immediately."
	);
					
	add_translation("en",$english);
?>