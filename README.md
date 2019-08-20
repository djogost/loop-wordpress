# Windows 10

First ad php and mysql to path

Then download Wordpress with
`php wp-cli.phar core download`
<br>

Create database with
`php wp-cli.phar db create`

After that create wp-config.php file with
`php wp-cli.phar config create --dbname=wordpress --dbuser=root`
<br>

Then run the
`php wp-cli.phar core install --url=localhost --title=test --admin_user=admin --admin_email=test@test.me`
command
<br>

After that run the script with
`php wp-cli.phar eval-file show.php`
