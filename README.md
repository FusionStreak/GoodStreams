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

## MovieDatabase API

We are using the *[MoviesDatabase](https://rapidapi.com/SAdrian/api/moviesdatabase)* from RapidAPI.

### How to access

1) Go to <https://rapidapi.com/SAdrian/api/moviesdatabase>
2) Create/Login for an account
3) Generate an API key (Keep it secret)
    - Can be found under header paramaters
4) Create a file called `.env` under `include/`
5) Insert the following into the file

    ```.env
    API_KEY = <Your API KEY>
    API_HOST = <Your API Host>
    ```

6) Do not put single or double quotes around either value

## Functionality

- List of shows/movies watched
- List of shows/movies user wants to watch
- Review shows/movies watched
- View others reviews on shows/movies

## The Stack

- PHP - Server-side rendering
- MariaDB - store user generated data and login details
- JS - Client-side dynamism
- GitHub - Collaboration
- HTML/CSS

## Citations

- [php-dotenv](https://github.com/devcoder-xyz/php-dotenv) by F. Michel([@devcoder-xyz](https://github.com/devcoder-xyz))
