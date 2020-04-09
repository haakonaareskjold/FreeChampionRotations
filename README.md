# Free Champion Rotations for League of Legends

### Installation

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
    `1 2 * * 2 /usr/bin/env php /home/username/public_html/cronEUW.php >/dev/null 2>&1` \
    `1 10 * * 2 /usr/bin/env php /home/username/public_html/cronNA.php >/dev/null 2>&1`
     * App also needs access to write files (755 should be fine) for file_put_contents when new API is being cached
## Important changes - 31/03/2020
- Riot changed how ARAM rotations works as of 31/03/2020, legacy code with old rotation system is still available.   [Click here](https://plebs.website)
to see it. Else it is available under **legacy** branch
- major difference between legacy and current system is that now it displays 65 champions that are always available in ARAM,
plus the weekly rotation from before. Which makes the previous two rotations that used to be cached obsolete.

## About the project

* Displays the free champions available for the current week, for normal/ARAM
* Displays Aram rotations (65 champions + current week- duplicates are removed if that happens)
* Has an option for both EUW and NA
* Includes a countdown timer for both NA and EU
* Has a toggle for dark/light mode
* Detects geolocation if no cookie exist (puts you on either NA or EU)
* images has link to their op.gg guides
* no ads
* Does not collect any information- cookies stores what server you picked based off your location 
and cookie for your preferred background
