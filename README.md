# Free Champion Rotations for League of Legends

### Installation

- Replace the API Value with your own key, then copy the env example to .env  \
`cp .env.example .env`
- enable the class autoloader and packages required with composer \
  `composer install --no-dev`
- for testing built-in webserver can be used to run the app \
  `php -S localhost:8080 -t public/`
  
## Important changes - 31/03/2020
- Riot changed how ARAM rotations works as of 31/03/2020, legacy code with old rotation system is still available.   [Click here](https://plebs.website)
to see it.
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
