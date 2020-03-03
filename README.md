# Free Champion Rotations for League of Legends

### Installation

- Copy the env example to an .env file, then replace the string with your API key \
`cp .env.example .env`
- enable the class autoloader, phpdotenv and guzzle with composer \
  `composer install --no-dev`
- use built-in webserver to run the app \
  `php -S localhost:8080 -t public/`

## About the project

* App displaying the free champions available for the current week
* Has an option for both EUW and NA
* Includes a countdown timer for both servers
* Does not collect any user information
