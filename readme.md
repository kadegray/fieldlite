
# Setup

## api

### build and compose

Build

    ./docker-compose build

> Note: On OSX you may get this error "mkmf.rb can't find header files". This resolved it for me https://github.com/EugenMayer/docker-sync/issues/679#issuecomment-534074764


Compose

    ./docker-compose


### api URL
http://localhost:1000/api

### container bash
    docker container list
    docker exec -it fieldlite_api bash

## database

### connection details
    ip: 127.0.0.1
    port: 33061
    username: root
    password: root
    database name: fieldlite

### import schema
Create a database with the name fieldlite and import /database_schema.sql

## frontend

### build and serve
    cd frontend
    npm i
    npm install -g @angular/cli
    ng serve --open

### frontend URL
http://localhost:4200/