# Changelog


---

## All notable changes to this publication will be documented in this file

### 1.8.4 - 10/07/2020

* Added ob_start to prevent problems with modified header information in docker container. Also added new dockerfiles that is isolated (new images).

### 1.8.3 - 02/06/2020

* Added alt text attribute to champion images for better access

### 1.8.2 - 13/05/2020

* Change in dockerfile to put specific ownership for the Cache dir to www-data, problem with file_put_contents and file_get_contents because ownership was set to 1000 in this dir

### 1.8.1 - 08/05/2020

* Fixed css img div issue where the container would be too big because of champion name length, adjusted with rem to fit the viewport

### 1.8 - 05/05/2020

* Optimized the docker container issues. Had issue with crashing containers because of CMD/Entrypoint in the images used, put all in one and added an infinite bash loop to keep the web container alive. Refactored so its built of an ubuntu image for stability and easier accessibility. It installs nginx, php-fpm through APT, and composer is downloaded and installed through curl

### 1.8b - 04/05/2020

* Fixed an issue with docker containers crashing making it only accessible on windows, but not on unix-like system because of permissions(chown/chmod), added a kamikaze container that will crash itself after its intended purpose of setting the environment correctly

### 1.8a -  03/05/2020

* Added testing environment for docker-compose, creates two containers, installs composer dependencies also.
* Fixed error with chown/chmod for docker container not being able to write, group and user set to www-data with 775.
* Added a new dockerfile based off the composer image

### 1.7.6 - 26/04/2020

* Added form validation with htmlspecialchar for POST action

### 1.7.5 - 20/04/2020

* Added a twig templating for errors that can occur if using VPN (server error 500) \ 
needs further investigation, some IPs will cause the geolocation API to not run (internal 500)

### 1.7.4 - 09/04/2020

* Added bin/ directory with two executable php scripts made to be used with crontab, see readme
* Added docs/ directory for installation.md

### 1.7.3 - 08/04/2020

* Refactored some code, added new dir with resources for Cache and other files that are not PHP

### 1.7.2 - 07/04/2020

* Fixed Readme with some vital information and made time window for rotation to 5min
* Added backup methods for fetching rotation despite being of opposite server location, 
would not work before because no cookie or post request sent from wget (with crontab), see readme for example

### 1.7.1 - 07/04/2020

* Fixed issue with overwriting current json rotation
* Changed writing from fread/fwrite/fclose to file_put_contents


### 1.7 - 06/04/2020

* Added an if statement that checks if the caches exist, and loads then despite the timer logic if they dont
as they are required to display anything in the first place, also added TODOS.
* Added for devs an auto-fetcher for external IP with phpdotenv if localhost is used to prevent geolocation to break
* Added a checker for if cookies exist, if not- methods for getIP and fetch(location) will invoke and put user at their
respective location, this cookie checker was added to prevent the geolocation API to be ratelimited

### 1.6 - 04/04/2020

* Refactored code so API usage to only load in once a week to prevent rate limiting
* Still needs testing to see how behaviour is under rotation, branching to **experimental**

### 1.5.2 - 04/04/2020

* Updated Twig template to display actual errors, tested with guzzle mocking

### 1.5.1 -  03/04/2020

* Fixed typo in guzzleclass making champions display the ID from DDragon JSON instead of the name,
the ID is still intended for the op.gg img link - where name would not work.

### 1.5 - 02/04/2020

* BIG CHANGE: Riot changed the format for ARAM, new is 65 set champions + current week from API. I refactored the
aramchampions method to display these 65 (removing duplicates). This will also make the cache not fully needed, only
for displaying the currentweek when the time difference between EU and NA happens.

### 1.4.3 - 01/04/2020

* Made a script that automatically fetches the most recent available DDragon patch and puts it in the phpdotenv

### 1.4.2 - 01/04/2020

* Refactored class code, removed constants and replaced with env variables for current patch

### 1.4.1 - 31/03/2020

* Added php built-in function for setting timezone to Europe/Berlin, DST should follow accordingly
* Added comments with what variables that should be changed if no DST

### 1.4 - 30/03/2020

* Added templates for Twig in case of Client/Server errors, foundation for future development- make template for the most common API errors possible

### 1.3.2 - 23/03/2020

* Fixed an error that displayed the wrong time for EUW and NA on the servercheck, correctly fixed to W - 1 day -2h for EUW and additional -6h for NA

### 1.3.1 - 22/03/2020

* Added a guzzle middleware for Riotgames REST API rate limit, max 3 request per second
* Added href on images to op.gg to the respective champion
* Added img for github with href to project in top-left corner

### 1.3.0 - 21/03/2020

* Added Geoloocation class that checks if you have no cookies - then if you're in NA or EU it will choose your server accordingly
if none can be found an own message will tell you to pick manually (e.g. for Asia)
* Added an .env IP only for dev/testing purposes, it is not necessary for production

### 1.2.0 - 17/03/2020

* Added ARAM champion pool
* uses two previous rotations that is stored in a cache as json then fetched when needed
* Added difference function between EUW and NA (the 7h timespan has to use cache for NA for current, and minus extra week for all json)
* Changed default background to dark

### 1.1.1 - 12/03/2020

* Added exceptions for client- and server side errors
* Put expiration time  for JS cookies(for light/dark mode)

### 1.1.0 - 11/03/2020

* Toggle for white/dark mode that works with cookies (JS)

### 1.0.2 -  10/03/2020

- Added cookies for the purpose of saving server location
- Changed countdown on NA according to DST
- Refactored some code

### 1.0.1 -  05/03/2020

- Added toggle between dark/white mode
- Fixed .error css class to grid display for mobile compatibility

### 1.0.0 -  03/03/2020

- First build ready for production
