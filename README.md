# Free Champion Rotations for League of Legends

### Installation

- Copy the env example to an .env file, then replace the string with your API key \
`cp .env.example .env`
- enable the class autoloader and packages required with composer \
  `composer install --no-dev`
- for testing, use built-in webserver to run the app \
  `php -S localhost:8080 -t public/`

## About the project

* App displaying the free champions available for the current week
* Displays Aram rotations (cached from previous weeks)
* Has an option for both EUW and NA
* Includes a countdown timer for both servers
* Has a toggle for dark/light mode which uses cookies
* Uses cookies to remember which location you have chosen
