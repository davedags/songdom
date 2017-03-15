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
- ng build --environment=prod --target=prod --aot
- Serve doc root (apache or nginx) from dist folder
- ln -s dist/api src/api

##MySQL Database
If desired, follow these steps to use persistent storage for lyric results
- In mysql: create database [yourdatabase]
- In mysql: Create a user and grant permissions to read/write/create
- Command Line: mysql -f < backend_src/db/initial.sql
- Copy backend_src/config/.env.example to backend_src/config/.env and set db credentials
