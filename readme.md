# Heimdall

Heimdall watches over the internet and let's you know if something noteworthy happens.

## How to run

Requirements for running this locally are:

- Docker (tested with v19.03.8)
- Ubuntu (tested with 20.04)

#### Steps:

- Setup the backend .env file. Follow the instructions in the file.
```
cp ./backend/.env.example ./backend/.env
```   
- Create a network with:
```
docker network create heimdall-global
```
- Spin up the docker containers with the command below. This will create a php, 
    nginx, postgres and frontend container. The front-end container 
    automatically builds the frontend and triggers a rebuild when files change.
```
docker-compose up
``` 
- Open a new terminal tab and exec into the php container. 
```
docker-compose exec -u php php bash
```
- For the backend we manually need to install depencencies, generate a key, 
    migrate the database and seed it:
```
composer install \
 && php artisan key:generate \
 && php artisan migrate:fresh --seed
```
- The frontend is accessible on: http://127.12.1.1:3000/
- The backend is accessible on: http://127.12.1.1/

#### Optional steps

- Add this to your host file: 
```
127.12.1.1 heimdall.local
```
- The frontend is now accessible on: http://heimdall.local:3000/
- The backend is now accessible on: http://heimdall.local/
- That looks a bit nicer :)

## Database diagram: 
https://app.diagrams.net/#G1gX2SlT6ayrsmtyJyJGoaQMoiMYClfyh2

## Todo / Refactor ideas:

- rename Scan to Check. Because a Watcher Checks a Trigger to find out if the trigger needs to be triggered. These checks are stored so you can see what happened in the past.
- Merge functionality of Triggers into a Watcher. It seems most watchers only will have one trigger.
- Add a mailhog docker container for local development 

## how to:

- https://swapnil.dev/blog/authentication-in-nuxtjs-using-laravel-sanctum/
