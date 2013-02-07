DROP TABLE IF EXISTS locations;

DROP TABLE IF EXISTS comments;


CREATE TABLE locations(
id INT AUTO_INCREMENT,
name VARCHAR(250) NOT NULL,
createdAt DATE, 
PRIMARY KEY(id)
)ENGINE= InnoDB;

CREATE TABLE comments (
id INT AUTO_INCREMENT,
idLocation INT NOT NULL ,
username VARCHAR(15) NOT NULL,
body VARCHAR(250) NOT NULL,
createdAt DATE ,
PRIMARY KEY(id),
FOREIGN KEY (`idLocation`) REFERENCES `locations` (`id`)
)ENGINE = InnoDB;

