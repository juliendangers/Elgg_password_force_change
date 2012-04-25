<?php
	
	function passwordchange_init() 
	{
		global $CONFIG;
		
		if(isloggedin() && !isadminloggedin()) {
			password_check_change();
	    }
	}
	
	function password_check_change(){
		$user = get_loggedin_user();
		if($_SERVER['REQUEST_URI'] != "/pg/settings/user/".$user->username && $_SERVER['REQUEST_URI'] != "/action/usersettings/save" && $_SERVER['REQUEST_URI'] != "/mod/password_change/jquery_strength_check.php") {
			if(!$user->lastPwdChange) {
				if(get_plugin_setting("begin"))
					$user->lastPwdChange = $user->time_created;
				else
					$user->lastPwdChange = time();
				$user->save();	
			}
			$diff = date_diff(date_create(date("Y-m-d", $user->lastPwdChange)),date_create(date("Y-m-d")) );
			$days = (int) $diff->format('%a');
			if($days > 60) {
				system_message(elgg_echo("passwordchange:renew"));
				forward("pg/settings/user/".$user->username);
			}
		}
		unregister_plugin_hook('usersettings:save','user','users_settings_save');
		
		register_plugin_hook('usersettings:save','user','pc_users_settings_save');
	}
	
	function pc_users_settings_save() {
		global $CONFIG;
		include($CONFIG->path . "actions/user/name.php");
		include($CONFIG->path . "mod/password_change/actions/user/password.php");
		include($CONFIG->path . "actions/email/save.php");
		include($CONFIG->path . "actions/user/language.php");
		include($CONFIG->path . "actions/user/default_access.php");
	}

	function checkPassword($C) {
            $F = 0;
			$B = get_plugin_setting('minlength');
			$L = strlen($C);
            if ($L < $B) {
                $F = ($F - 100);
            } else {
                if ($L >= $B && $L <= ($B + 2)) {
                    $F = ($F + 6);
                } else {
                    if ($L >= ($B + 3) && $L <= ($B + 4)) {
                        $F = ($F + 12);
                    } else {
                        if ($L >= ($B + 5)) {
                            $F = ($F + 18);
                        }
                    }
                }
            }
            if (preg_match ('/[a-z]/',$C)) {
                $F = ($F + 1);
            }
            if (preg_match('/[A-Z]/', $C)) {
                $F = ($F + 5);
            }
            if (preg_match('/\d+/', $C)) {
                $F = ($F + 5);
            }
            if (preg_match('/(.*[0-9].*[0-9].*[0-9])/', $C)) {
                $F = ($F + 7);
            }
            if (preg_match('/.[!,@,#,$,%,^,&,*,?,_,~]/', $C)) {
                $F = ($F + 5);
            }
            if (preg_match('/(.*[!,@,#,$,%,^,&,*,?,_,~].*[!,@,#,$,%,^,&,*,?,_,~])/', $C)) {
                $F = ($F + 7);
            }
            if (preg_match('/([a-z].*[A-Z])|([A-Z].*[a-z])/', $C)) {
                $F = ($F + 2);
            }
            if (preg_match('/([a-zA-Z])/', $C) && preg_match('/([0-9])/', $C)) {
                $F = ($F + 3);
            }
            if (preg_match('/([a-zA-Z0-9].*[!,@,#,$,%,^,&,*,?,_,~])|([!,@,#,$,%,^,&,*,?,_,~].*[a-zA-Z0-9])/', $C)) {
                $F = ($F + 3);
            }
			$common = array ("password", "sex", "god", "123456", "123", "liverpool", "letmein", "qwerty", "monkey", "azerty");
            for ($D = 0; $D < count($common); $D++) {
                if (strtolower($C) == $common[$D]) {
                   $F = -200;
                }
            }
            return $F;
        }
		
	register_elgg_event_handler('init','system','passwordchange_init', 999);

?>