
CREATE TABLE Users(
    UserId INT AUTO_INCREMENT PRIMARY KEY,
	fName VARCHAR(30) NOT NULL,
    lName VARCHAR(30) NOT NULL,
    username VARCHAR(50) NOT NULL,
    email VARCHAR (50) NOT NULL,
    passwrd VARCHAR(50) NOT NULL,
    country VARCHAR(50) NOT NULL,
    gender VARCHAR (50) NOT NULL
);
CREATE TABLE Styles(
    styleId INT AUTO_INCREMENT ,
    userId INT NOT NULL ,
    size Varchar (10),
    type VARCHAR(20),
    FOREIGN KEY (userId) REFERENCES Users(UserId),
    PRIMARY KEY (styleId,userId)
);
CREATE TABLE Styles_Brands(
    styleId INT not null, 
    brandId INT not null, 
    FOREIGN KEY (styleId) REFERENCES Styles(styleId),
    FOREIGN KEY (brandId) REFERENCES Brands(brandId)
);
CREATE TABLE Brands(
    brandId INT AUTO_INCREMENT PRIMARY KEY,
    brandname varchar(20)
);
CREATE TABLE Styles_Colors(
    styleId INT not null ,
    colorId INT not null,
    FOREIGN KEY (styleId) REFERENCES Styles(styleId),
    FOREIGN KEY (colorId) REFERENCES Colors(colorId)
);
CREATE TABLE Colors(
    colorId INT AUTO_INCREMENT PRIMARY KEY,
    colorname varchar(20)
);

CREATE TABLE Clothes(
    clothesId INT AUTO_INCREMENT PRIMARY KEY,
    userId INT ,
    size varchar(20),
    colorId INT ,
    brandId INT ,
    FOREIGN KEY (userId) REFERENCES Users(UserId),
    FOREIGN KEY (brandId) REFERENCES Brands(brandId),
    FOREIGN KEY (colorId) REFERENCES Colors(colorId)
);
CREATE TABLE Orders(
    orderId INT AUTO_INCREMENT PRIMARY KEY,
    userId INT ,
    package varchar(20),
    orderDate varchar(20),
    price INT,
    FOREIGN KEY (userId) REFERENCES Users(UserId)
);


    INSERT INTO Users(fName, lName, username, email, passwrd, country, gender)
    VALUES  ('Alfredo', 'Salazar', 'test', 'alfred@gmail.com', 'test', 'MX','Male'),
        	('Heiko', 'Scholz', 'squashi', 'heiko@gmail.com', 'heiko', 'MX','Male'),
            ('Pamela', 'Rodriguez', 'test1', 'pamela@gmail.com','test1','MX','Male');

    INSERT INTO Styles(userId, size,type)
    VALUES  ('1', '22', 'formal'),
        	('2', '24', 'sport'),
            ('3', '26', 'vintage');

INSERT INTO Brands(name)
    VALUES  ('Brand1'),
        	('Brand2'),
            ('Brand3'),
            ('Brand4'),
            ('Brand5'),
            ('Brand6');
INSERT INTO Colors(name)
    VALUES  ('Red'),
        	('Green'),
            ('Blue'),
            ('White'),
            ('Yellow'),
            ('Black');


