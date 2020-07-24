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
-   A pirate town! Harr!! With mainly pirates at the coast.
-   Interactive fights, not just pressing "attack" and see what's happens.
-   Trading between players when they are at the same town.
-   Some sort of over all score, that tells you which players are best at a glance.
-   Difference between towns. Such as images, mood, avatars, and some functional differences. Like specific items to buy and such.
-   Missions! From avatars and governors. Maybe multiple missions at once. Maybe you have to travel to a place, get something and get back. Things like that.
-   A new event system with it's own table, making it easier for an average developer like myself.
-   Create avatars that can talk to you while you game. Not just gibberish, but helpful information and clues.
-   Different images on all crew members, and skip the bad descriptions of them.
-   A map that you can access whereever you are, not just on the seven seas.
-   Some sort of "whats going on in the game" screen, log from all users, statistics and so on.
-   The different ship types needs to differ more from each other. You don't gain that much from buying a more expensive ship right now.
-   A better gaming guide, maybe an annoying parrot, with tips on what you should do next. Not just warnings at the docks.
-   Better, more intelligent greeting phrases.
-   WebRTC based chat (The world isn't quite ready yet). Or HTML5 sockets?
-   A developer guide (for myself at this moment). This game is quit large by now and has it's own framework (sort of).
-   New design, from the ground up. Mobile first, of course.
-   Watch CodeIgniters future, do I have to change PHP framework?
-   Replace all alerts and prompts with jQuery dialog boxes.
-   Set some global events, like weather, and implement it for all users, create a living environment.
-   Get notices from the chat when nick is mentioned.
-   Move functions from the gamelib to models, helpers and config instead.
