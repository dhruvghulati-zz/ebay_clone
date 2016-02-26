-- Change root password
SET PASSWORD FOR 'root'@'localhost' = PASSWORD('DatabaseMasters');
SET PASSWORD FOR 'root'@'127.0.0.1' = PASSWORD('DatabaseMasters');
SET PASSWORD FOR 'root'@'::1' = PASSWORD('DatabaseMasters');

-- Delete previous copies of DB
DROP DATABASE IF EXISTS scotchbox;
DROP DATABASE IF EXISTS ebay_clone;

-- Create new DB
CREATE DATABASE ebay_clone
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

GRANT SELECT, UPDATE, INSERT, DELETE
  ON ebay_clone.*
  TO 'ebay_admin'@'localhost'
  IDENTIFIED BY '192837465';

-- Use DB
USE ebay_clone;

-- Tables
-- Table Auction
CREATE TABLE Auction (
  auction_id    INT           NOT NULL AUTO_INCREMENT,
  start_price   DECIMAL(8, 2) NOT NULL,
  reserve_price DECIMAL(8, 2) NOT NULL,
  end_price     DECIMAL(8, 2) NOT NULL,
  current_bid   DECIMAL(8, 2) NOT NULL,
  start_time    TIME          NOT NULL,
  end_time      TIME          NOT NULL,
  viewings      INT           NOT NULL,
  item_id       INT           NOT NULL,
  user_id       INT           NOT NULL,
  CONSTRAINT Auction_pk PRIMARY KEY (auction_id)
);

-- Table Bids
CREATE TABLE Bids (
  bid_id     INT           NOT NULL AUTO_INCREMENT,
  user_id    INT           NOT NULL,
  auction_id INT           NOT NULL,
  bid_price  DECIMAL(8, 2) NOT NULL,
  CONSTRAINT Bids_pk PRIMARY KEY (bid_id)
);

-- Table Category
CREATE TABLE Category (
  category_id INT         NOT NULL  AUTO_INCREMENT,
  category    VARCHAR(63) NOT NULL,
  CONSTRAINT Category_pk PRIMARY KEY (category_id)
);

-- Table Item
CREATE TABLE Item (
  item_id      INT          NOT NULL AUTO_INCREMENT,
  item_picture VARCHAR(255) NOT NULL,
  name         VARCHAR(127) NOT NULL,
  features     VARCHAR(255) NOT NULL,
  item_category        VARCHAR(63)  NOT NULL,
  category_id  INT          NOT NULL,
  CONSTRAINT Item_pk PRIMARY KEY (item_id)
);

-- Table Roles
CREATE TABLE Roles (
  role_id INT         NOT NULL  AUTO_INCREMENT,
  role    VARCHAR(15) NOT NULL,
  CONSTRAINT Roles_pk PRIMARY KEY (role_id)
);

-- Table Users
CREATE TABLE Users (
  user_id         INT          NOT NULL  AUTO_INCREMENT,
  username        VARCHAR(31)  NOT NULL,
  password        VARCHAR(31)  NOT NULL,
  profile_picture VARCHAR(255) NOT NULL,
  first_name      VARCHAR(31)  NOT NULL,
  last_name       VARCHAR(31)  NOT NULL,
  email           VARCHAR(63)  NOT NULL,
  birthdate       DATE         NOT NULL,
  rating          INT          NOT NULL,
  role_id         INT          NOT NULL,
  CONSTRAINT Users_pk PRIMARY KEY (user_id)
);

-- Foreign Keys

-- Reference:  Auction_Bids (table: Bids)
ALTER TABLE Bids ADD CONSTRAINT Auction_Bids FOREIGN KEY Auction_Bids (auction_id)
  REFERENCES Auction (auction_id);

-- Reference:  Auction_Item (table: Auction)
ALTER TABLE Auction ADD CONSTRAINT Auction_Item FOREIGN KEY Auction_Item (item_id)
  REFERENCES Item (item_id);

-- Reference:  Auction_Users (table: Auction)
ALTER TABLE Auction ADD CONSTRAINT Auction_Users FOREIGN KEY Auction_Users (user_id)
  REFERENCES Users (user_id);

-- Reference:  Category_Item (table: Item)
ALTER TABLE Item ADD CONSTRAINT Category_Item FOREIGN KEY Category_Item (category_id)
  REFERENCES Category (category_id);

-- Reference:  Users_Bids (table: Bids)
ALTER TABLE Bids ADD CONSTRAINT Users_Bids FOREIGN KEY Users_Bids (user_id)
  REFERENCES Users (user_id);

-- Reference:  Users_Roles (table: Users)
ALTER TABLE Users ADD CONSTRAINT Users_Roles FOREIGN KEY Users_Roles (role_id)
  REFERENCES Roles (role_id);

-- Insert Data

INSERT INTO Roles (role) VALUES ('Buyer'), ('Seller');
INSERT INTO Category (category) VALUES ('Antiques'), ('Art'), ('Baby'), ('Books, Comics & Magazines'),
  ('Business, Office & Industrial'), ('Cameras & Photography'), ('Cars, Motorcycles & Vehicles'),
  ('Clothes, Shoes & Accessories'), ('Coins'), ('Collectables'), ('Computers/Tablets & Networking'),
  ('Crafts'), ('Dolls & Bears'), ('DVDs, Films & TV'), ('Events Tickets'), ('Garden & Patio'), ('Health & Beauty'),
  ('Holidays & Travel'), ('Home, Furniture & DIY'), ('Jewellery & Watches'), ('Mobile Phones & Communication'),
  ('Music'), ('Musical Instruments'), ('Pet Supplies'), ('Pottery, Porcelain & Glass'), ('Property'),
  ('Sound & Vision'), ('Sporting Goods'), ('Sports Memorabilia'), ('Stamps'), ('Toys & Games'),
  ('Vehicle Parts & Accessories'), ('Video Games & Consoles'), ('Wholesale & Job Lots'), ('Everything Else');

-- End of file.