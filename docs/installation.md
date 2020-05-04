# Installation
### Docker build

* Requirement for this build is Docker-compose

- Replace the API Value with your own key, in .env.example 
- Build it with docker-compose \
`docker-compose up -d --build`
- When the container called freechampionrotations-composer/kamikaze shuts down, the App is ready and accessible 
- can be seen on `localhost:8080` in browser
 - For production, use crontab or similar to update API, either by wget/cURL 
  to URL or execute the scripts in bin/ within the time window is recommended
    * examples: \
    `1 2 * * 2 /usr/bin/env php /home/username/public_html/bin/cronEUW.php >/dev/null 2>&1` \
    `1 11 * * 2 /usr/bin/env php /home/username/public_html/bin/cronNA.php >/dev/null 2>&1`