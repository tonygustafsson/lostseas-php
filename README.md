# Lost Seas

# Legacy

This game has been a part of my life for so long. It's finally time to say goodbye and say hello to the [new version, built with Next.js](https://github.com/tonygustafsson/lostseas) instead. Yarr!

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

## Active game

http://www.lostseas.com/
