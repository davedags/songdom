# Songdom

Lyrics Search Engine, Ad Free

-- Angular 2, angular-cli, and PHP Backend

##Development Environment Process (JIT)

- Clone Repository
- composer install
- npm install
- ng serve (to start angular app)
- cd src/api && php -S localhost:8080 (to start php api backend)
- Note: You can modify the expected api server url in src/app/environments/environment.ts

##Production Build Process (AOT)

- Clone Repository
- composer install
- npm install
- ng build --environment=prod
- Serve doc root (apache or nginx) from dist folder
- ln -s dist/api src/api