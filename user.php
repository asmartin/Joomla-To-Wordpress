<?php

set_time_limit( 1800 );
require_once 'config.php';

$wpdb   = new wpdb( WPDP_USER, WPDP_PASS, WPDP_DB, WPDP_HOST );
$joomdb = new wpdb( JOOM_USER, JOOM_PASS, JOOM_DB, JOOM_HOST );
$users = $joomdb->get_results( 'select * from ' . JOOM_PREFIX . 'users' );

if ( $users ) {
    foreach ($users as $user) {
        $user_data = array(
            'ID'              => $user->id,
            'user_pass'       => $user->password,
            'user_login'      => $user->username,
            'user_email'      => $user->email,
            'display_name'    => $user->username,	// change to $user->name if you want the user's real name in this field instead of username
            'user_registered' => $user->registerDate,
        );
        $user_metadata_capabilities = array(
            'user_id'    => $user->id,
            'meta_key'   => 'wp_capabilities',
            'meta_value' => 'a:1:{s:10:"subscriber";b:1;}'  // change subscriber to something else if you want to
        );
        $user_metadata_joomlapass = array(
            'user_id'    => $user->id,
            'meta_key'   => 'joomlapass',
            'meta_value' => $user->password
	);

	// import real name into first_name and last_name usermeta fields
        $names = explode(" ", $user->name);
        $first = $names[0];
        $last = "";
        if (count($names) > 1) {
            $i=0;
            foreach ($names as $key => $value) {
                if ($i > 0) {
                    $last .= " $value";
                }
                $i++;
            }
        }
	$last = trim($last);
        $user_metadata_firstname = array(
            'user_id'    => $user->id,
            'meta_key'   => 'first_name',
            'meta_value' => $first
        );
        $user_metadata_lastname = array(
            'user_id'    => $user->id,
            'meta_key'   => 'last_name',
            'meta_value' => $last
        );

        $user_metadata_user_level = array(
            'user_id'    => $user->id,
            'meta_key'   => 'wp_user_level',
            'meta_value' => '0' // change wp_user_level if you want to
        );

        $wpdb->insert(''. WPDP_PREFIX . 'users', $user_data);
        $wpdb->insert(''. WPDP_PREFIX . 'usermeta', $user_metadata_joomlapass);
        $wpdb->insert(''. WPDP_PREFIX . 'usermeta', $user_metadata_firstname);
        $wpdb->insert(''. WPDP_PREFIX . 'usermeta', $user_metadata_lastname);
//        $wpdb->insert(''. WPDP_PREFIX . 'usermeta', $user_metadata_user_level);

        //In Simple SQL
        /*
        INSERT INTO `wp_users` (`user_login`, `user_pass`, `user_nicename`, `user_email`, `user_status`)
        VALUES ('newadmin', MD5('pass123'), 'firstname lastname', 'email@example.com', '0');

        INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) 
        VALUES (NULL, (Select max(id) FROM wp_users), 'wp_capabilities', 'a:1:{s:13:"administrator";s:1:"1";}');

        INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) 
        VALUES (NULL, (Select max(id) FROM wp_users), 'wp_user_level', '10');
        */
     
    }
 echo 'Users are Transferred';
} else {
 echo "No Users Found<br>";
}
