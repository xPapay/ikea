IKEA
====
##Installation
 - Install *Docker Engine* by following instructions from [Docker Engine
   installation](https://docs.docker.com/engine/installation/).
 - Install *Docker Compose* by following instructions from [Docker Compose installation](https://docs.docker.com/compose/install/).
 - Clone this repo
 - Change present working directory into downloaded directory e.g. `cd ikea`
 - Run `composer install` to install project's dependencies (If not installed yet, follow instructions at [Composer installation](https://getcomposer.org/doc/00-intro.md), note: php installation required [e.g. `sudo apt-get install php5-cli`]).
 - After installing dependencies, you may need to configure some permissions. Directories within the *storage* and the *bootstrap/cache* directories should be writable by your web server, e.g. `sudo chmod -R 777 storage bootstrap/cache`
 - You can also edit you host file, e.g. `sudo echo "127.0.1.1 ikea">>/etc/hosts`
 - Rename *.env.example* file to *.env*, e.g. `mv .env.example .env`
 - Make necessary configuration inside *.env* file (set database password to: *passwd*)
 - If not installed install *Node.js* by following instructions from [Nodejs.org](https://nodejs.org/en/).
 - Install gulp globally by running `sudo npm install --global gulp`
 - Install npm packages by running `npm install`
 - Run gulp `gulp`
 - Run `sudo docker-compose up -d --build` (at first time it takes a while due to downloading and building an image of the container)
 - Next, open new terminal inside *ikea_web_1* container by running `sudo docker exec -ti ikea_web_1 /bin/bash`
 - This terminal is running inside container, run there following commands to clear the application cache, configuration cache and command to generate application key:
 -`php artisan cache:clear` 
 -`php artisan config:clear`
 -`php artisan key:generate`
 
 - To migrate database run following command: `php artisan migrate`
