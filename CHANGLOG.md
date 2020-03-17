# Changelog

## TODO

* (potenial issue) cache for current month (to workaround the 7h issue -  when NA cant use API since both servers uses same cache) causes \
it to rewrite everytime a request happens, unknown if heavy on production


---

## All notable changes to this publication will be documented in this file.

### 1.2.0 - 17/03/2020

* Added ARAM champion pool
* uses two previous rotations that is stored in a cache as json then fetched when needed
* Added difference function between EUW and NA (the 7h timespan has to use cache for NA for current, and minus extra week for all json)

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
