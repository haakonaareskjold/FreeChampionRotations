# Installation

- Replace the API Value with your own key, then copy the env example to .env  \
`cp .env.example .env`
- enable the class autoloader and packages required with composer \
  `composer install --no-dev`
- for testing built-in webserver can be used to run the app \
  `php -S localhost:8080 -t public/`
 - For production, use crontab or similar to update API, either by wget/cURL 
  to URL or execute the scripts in bin/ at the time window
    * If you want to just use one crontab you can just put it to check every hour(xx:02) on Tuesdays e.g. \
    `2 1-12 * * 2 wget -O https://example.com >/dev/null 2>&1` 
    * Else you can use a crontab with the executables mentioned above, this would require you to execute both, e.g. \
    `1 2 * * 2 /usr/bin/env php /home/username/public_html/bin/cronEUW.php >/dev/null 2>&1` \
    `1 10 * * 2 /usr/bin/env php /home/username/public_html/bin/cronNA.php >/dev/null 2>&1`
     * App also needs access to write files (755 should be fine) for file_put_contents when new API is being cached