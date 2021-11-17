Create Database hornusserstatistiken;
use hornusserstatistiken;

Create Table Webcodes(
    webcode varchar(255) NOT NULL UNIQUE,
    vereinsname varchar(255) NOT NULL UNIQUE
);
