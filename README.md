# Windows 10


First add php and mysql to path

Then download Wordpress with

`php wp-cli.phar core download`

Create database with

`php wp-cli.phar db create`

After that create wp-config.php file with

`php wp-cli.phar config create --dbname=wordpress --dbuser=root`

Then run the

`php wp-cli.phar core install --url=localhost --title=test --admin_user=admin --admin_email=test@test.me`

command

After that run the script with

`php wp-cli.phar eval-file show.php`

