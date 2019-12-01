
# Setup

## api

### build and compose
    ./docker-compose build
    ./docker-compose

### api URL
http://localhost:1000/api

### container bash
    docker container list
    docker exec -it fieldlite_api_1 bash

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
    ng serve

### frontend URL
http://localhost:4200/