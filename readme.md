
# Setup

## api

### build and compose

Docker Sync is used to keep changed files synced with the container. I use it to get around file system performance issues between OSX and the containers. https://docker-sync.readthedocs.io/en/latest/getting-started/installation.html

    gem install docker-sync
    brew install unison


If you have trouble installing unison i recomend installing the app and on opening it installing the commandline app. https://github.com/bcpierce00/unison/releases


This will build

    ./docker-compose

> Note: On OSX you may get this error "mkmf.rb can't find header files". This resolved it for me https://github.com/EugenMayer/docker-sync/issues/679#issuecomment-534074764


Repeat this command after the build to compose it

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
    ng serve

### frontend URL
http://localhost:4200/