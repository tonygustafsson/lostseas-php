# Lost Seas

This is an old fashioned web based game. It is based upon Sid Meier's Pirates but with it's own ideas.
It is an adventure game with images, music and descriptive texts.

## Tech

The tech is too old to be proud of at this moment. I've begun to rebuild this project so many times.
Just now I realized that I need to do one thing at a time.

I would like to separate the backend logic from the frontend. The backend could still use CodeIgniter,
but be abstracted so that I could use NodeJS in the future. The frontend would be react with redux.

## Requirements for develop environment

-   Docker
-   Docker Compose
-   Node JS

## Setup develop environment

```
npm install -g webpack webpack-cli
npm install
sudo chmod +777 ./docker/php-fpm/sessions/
```

## Restore database backup

```
docker-compose up
```

Then visit http://localhost:8000/ and restore the database backup from ./backup

## Start develop environment

```
npm start
```

## Requirements for production setup

-   Web server
-   PHP 7+
-   MySQL / MariaDB

## Build for production

```
npm install -g webpack webpack-cli
npm install
npm run build
```

Copy the ./dist folder to web server / FTP.

## Demo

http://www.lostseas.com/

## Ideas for the future

-   A nice canvas map over the ocean, and a ship you steer with the arrow keys. I want a feeling of time passing by, and be able to sail to different waters with different characteristics.
-   Interactive fights, not just pressing "attack" and see what's happens.
-   Trading between players when they are at the same town.
-   Some sort of over all score, that tells you which players are best at a glance.
-   Difference between towns. Environments, avatars, and some functional differences. Like specific items to buy and such.
-   Missions! From avatars and governors. Maybe multiple missions at once. Maybe you have to travel to a place, get something and get back. Things like that.
-   Special rare items.
-   See the map and your position even in a town.
-   A helpful guide, maybe a parrot, that informs you what you should do next.
-   Better, more intelligent greeting phrases.
-   Ability to repair all ships at once.
-   Clearer info when finding a enemy or ally ship.
-   Clearer actions, specially on the seas on mobile. Hidden in a menu.
-   Get the app to Google Play Store.
-   Separate the frontend from the backend completely. Svelte or React for the frontend.
-   Watch CodeIgniters future, maybe time to change PHP framework?
