# Free Champion Rotations for League of Legends

### Installation docs can be found in docs/installation.md, please read them!

## About the project

* Displays the free champions available for the current week, for normal games and ARAM
* Displays Aram rotations (65 champions + current week. Duplicates if they exist)
* Has an option for both EUW and NA
* Includes a countdown timer for both NA and EUW
* Has a toggle for dark/light mode (caches if light mode is chosen)
* Detects geolocation if no cookie exist (puts you on either NA or EU)
* images has link to their op.gg guides
* no ads
* The app do not collect any information- one cookie by default (geolocate on what server to put you, and remembers),
other cookie is only created if light mode is chosen.
* Can also be run with docker-compose

## How it will look like
![Example of site layout](https://i.imgur.com/XGC8WJA.png)

## Important changes - 31/03/2020
- Riot changed how ARAM rotations works as of 31/03/2020, it is available under **legacy** branch
- major difference between legacy and current system is that now it displays 65 champions
that are always available in ARAM, plus the weekly rotation from before.
Which makes the previous two rotations that used to be cached obsolete.

