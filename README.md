# Free Champion Rotations for League of Legends

### Installation

- Replace the API Value with your own key, then copy the env example to .env  \
`cp .env.example .env`
- enable the class autoloader and packages required with composer \
  `composer install --no-dev`
- for testing built-in webserver can be used to run the app \
  `php -S localhost:8080 -t public/`

## About the project

* Displays the free champions available for the current week
* Displays Aram rotations (cached from previous weeks)
* Has an option for both EUW and NA
* Includes a countdown timer for both servers
* Has a toggle for dark/light mode which uses cookies
* Uses cookies to remember which location you have chosen
* images has link to their op.gg guides
* Does not collect any information- cookies stores what server you picked based off your location and cookie for your preferred background
