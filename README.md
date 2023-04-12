# GoodStreams

**THIS IS NOT A SECURE APPLICATION. IT IS PURELY FOR EDUCATIONAL PURPOSES, AND IS NOT MEANT FOR ANY ACTUAL DEPLOYMENT!**

NET 3010 Course Project - Website to keep track of watched movies and reviews.

## Description of Project

GoodStreams is a website that allows users to keep personalized lists of movies/shows they have watched or want to watch. The user will also be able to review movies/shows, and other users can view those reviews.

## Team Members

- [Madeline Quang](https://github.com/madelinequang9) - Front End Designer
- [Oreoluwa Adegbesan](https://github.com/Oreoluwa123) - Front-end Developer
- [Sayfullah Eid](https://github.com/FusionStreak) - Team Lead | Back-end Developer

## Database

![Schema](https://www.plantuml.com/plantuml/proxy?cache=no&src=https://raw.githubusercontent.com/fusionstreak/GoodStreams/main/schema.puml)

## MoviesDatabase API

We are using the *[MoviesDatabase](https://rapidapi.com/SAdrian/api/moviesdatabase)* from RapidAPI.

## How to setup

1) Go to <https://rapidapi.com/SAdrian/api/moviesdatabase>
2) Create/Login for an account
3) Generate an API key (Keep it secret)
    - Can be found under header paramaters
4) Install [XAMPP/LAMPP v8.2+](https://www.apachefriends.org/)
5) Startup Apache and MySQL servers
6) Create a file called `.env` under `include/`
7) Insert the following into the file

    ```.env
    API_KEY = <Your API KEY>
    API_HOST = <Your API Host>
    ```

## Functionality

- List of shows/movies watched
- List of shows/movies user wants to watch
- Review shows/movies watched
- View others reviews on shows/movies

## TODO

- Add input verification for registration
- Add input verification for login
- Add review list under movie details

## The Stack

This website is designed to work with the latest XAMPP/LAMPP stack

- PHP (v8.2<) - Server-side rendering
- MariaDB - Store user generated data and login details
- JS - Client-side dynamism
- GitHub - Collaboration
- HTML 5
- CSS

## Citations

- [php-dotenv](https://github.com/devcoder-xyz/php-dotenv) by F. Michel([@devcoder-xyz](https://github.com/devcoder-xyz))
