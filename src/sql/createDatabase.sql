Create Database hornusserstatistiken;
use hornusserstatistiken;

Create Table Webcodes(
    webcode varchar(255) NOT NULL UNIQUE,
    vereinsname varchar(255) NOT NULL UNIQUE
);


INSERT INTO `webcodes`(`webcode`, `vereinsname`) VALUES ("biel","Biel-Schwadernau");
INSERT INTO `webcodes`(`webcode`, `vereinsname`) VALUES ("obergerlafingen","Obergerlafingen");
INSERT INTO `webcodes`(`webcode`, `vereinsname`) VALUES ("test","Test");