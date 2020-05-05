# Installation
### Docker build

* Requirement for this build is Docker-compose

- copy the environment file to .env
`cp .env.example .env`
- fill in your own API key in the .env file
- Build it with docker-compose \
`docker-compose up --build`
- can be seen on `localhost:8080` in browser
 - For production, use crontab or similar to update API
    * examples: \
    `1 2 * * 2 /usr/bin/env php /home/username/public_html/bin/cronEUW.php >/dev/null 2>&1` \
    `1 11 * * 2 /usr/bin/env php /home/username/public_html/bin/cronNA.php >/dev/null 2>&1`