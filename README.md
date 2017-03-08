# Joomla-To-Wordpress
Joomla To Wordpress PHP Script 
# Usage
1. Create New Folder in WordPress Dir (like jwp)
2. Add all files to this jwp folder
3. Write Details to config.php file
4. Type in Browser http://www.site-url-wordpress-dir/jwp/index.php.
5. Click links one by one for best and correct results

# Users
Note that by default, the `wp_users.display_name` column in the Wordpress database will contain the username. First name and last name will be stored in `wp_usermeta` under the `first_name` and `last_name` keys respectively. You can change this behavior by editing the code before import.

Once users are imported, their Joomla password hash will be stored in the `joomlapass`
field in `wp_usermeta`. Then, use [this plugin](https://github.com/asmartin/joomla-to-wordpress-migrated-users-authentication-plugin) to automatically check a user's password when he/she
logs in and if it matches the Joomla hash, insert the password in the Wordpress format (thus completing the conversion).

# Notes
* Field in Joomla and Wordpress Can be change from time to time so you have to replace them as needed
* In wp-config.php on debug mode you will see any error that script is facing.
* Its Best to Place both Joomla and wordpress DB on localhost then run script there in wordpress dir
* I Used WPDP Wordpress DB Class you can use SQL also its simple.
