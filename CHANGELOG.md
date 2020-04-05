# Changelog


---

## All notable changes to this publication will be documented in this file.

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
