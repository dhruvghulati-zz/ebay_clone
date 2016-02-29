-- Change root password
SET PASSWORD FOR 'root'@'localhost' = PASSWORD ('DatabaseMasters');
SET PASSWORD FOR 'root'@'127.0.0.1' = PASSWORD ('DatabaseMasters');
SET PASSWORD FOR 'root'@'::1' = PASSWORD ('DatabaseMasters');

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
  auction_id    INT           NOT NULL  AUTO_INCREMENT,
  start_price   DECIMAL(8, 2) NOT NULL,
  reserve_price DECIMAL(8, 2) NOT NULL,
  current_bid   DECIMAL(8, 2) NOT NULL,
  start_time    DATETIME      NOT NULL,
  end_time      DATETIME      NOT NULL,
  viewings      INT           NOT NULL,
  item_id       INT           NOT NULL,
  user_id       INT           NOT NULL,
  CONSTRAINT Auction_pk PRIMARY KEY (auction_id)
);

-- Table Bids
CREATE TABLE Bids (
  bid_id     INT           NOT NULL  AUTO_INCREMENT,
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
  item_id          INT          NOT NULL  AUTO_INCREMENT,
  item_picture     VARCHAR(255) NOT NULL,
  label            VARCHAR(127) NOT NULL,
  description      VARCHAR(255) NOT NULL,
  state_id         INT          NOT NULL,
  category_id      INT          NOT NULL,
  CONSTRAINT Item_pk PRIMARY KEY (item_id)
);

-- Table Roles
CREATE TABLE Roles (
  role_id INT         NOT NULL  AUTO_INCREMENT,
  role    VARCHAR(15) NOT NULL,
  CONSTRAINT Roles_pk PRIMARY KEY (role_id)
);

-- Table State
CREATE TABLE State (
  state_id INT         NOT NULL  AUTO_INCREMENT,
  state    VARCHAR(63) NOT NULL,
  CONSTRAINT State_pk PRIMARY KEY (state_id)
);

-- Table Users
CREATE TABLE Users (
  user_id         INT          NOT NULL  AUTO_INCREMENT,
  username        VARCHAR(31)  NOT NULL,
  passwd		  VARCHAR(40)  NOT NULL,
  profile_picture VARCHAR(255) NOT NULL,
  first_name      VARCHAR(31)  NOT NULL,
  last_name       VARCHAR(31)  NOT NULL,
  email           VARCHAR(63)  NOT NULL,
  birthdate       DATE         NOT NULL,
  rating          DECIMAL          NOT NULL DEFAULT 0.00,
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

-- Reference:  Item_condition_id (table: Item)
ALTER TABLE Item ADD CONSTRAINT Item_condition_id FOREIGN KEY Item_condition_id (state_id)
  REFERENCES State (state_id);

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

INSERT INTO State (state) VALUES ('Brand New'), ('Like New'), ('Very Good'), ('Good'), ('Acceptable');

-- Sample Data: Test User
INSERT INTO Users (username, password, first_name, last_name, email, birthdate, rating, role_id)
VALUES ('test', '1234', 'test', 'user', 'test@test.com', '1978-11-11', 5, 1);
INSERT INTO Users (username, password, first_name, last_name, email, birthdate, rating, role_id)
VALUES ('test1', '123', 'test1', 'user1', 'test1@test.com', '1989-12-03', 3, 2);
INSERT INTO Users (username, password, first_name, last_name, email, birthdate, rating, role_id)
VALUES ('test2', 'testy', 'test2', 'user2', 'test2@test.com', '1924-12-03', 4.56, 2);
INSERT INTO Users (username, password, first_name, last_name, email, birthdate, rating, role_id)
VALUES ('test3', 'testy1', 'test3', 'user3', 'test3@test.com', '1990-12-03', 3.5, 2);

-- Sample Data: Test Items
INSERT INTO Item (name, features, item_category, state, category_id, state_id) VALUES ('Hard Drive', 'Big Capacity','Computers/Tablets & Networking','Like New', 11, 2);
INSERT INTO Item (name, features, item_category, state, category_id, state_id) VALUES ('Bouncy Ball', 'Really Bouncy', 'Crafts','Brand New',12, 1);
INSERT INTO Item (name, features, item_category, state, category_id, state_id) VALUES ('Fiat Leon', 'Really Fast','Cars, Motorcycles & Vehicles','Acceptable', 7, 5);
INSERT INTO Item (name, features, item_category, state, category_id, state_id) VALUES ('Nike Fly Knit Shoes', 'Comfortable','Clothes, Shoes & Accessories','Good', 8, 4);

-- Sample Data: Test Auctions
INSERT INTO `Auction`(`start_price`, `reserve_price`,`current_bid`, `start_time`, `end_time`, `viewings`, `item_id`, `user_id`) VALUES (50.00, 20.00,24.00,'2008-11-11 13:23:44','2008-11-28 15:45:44',46,1,2)
INSERT INTO `Auction`(`start_price`, `reserve_price`,`current_bid`, `start_time`, `end_time`, `viewings`, `item_id`, `user_id`) VALUES (10.32, 45.92,56.89,'2012-08-23 16:23:44','2012-08-28 16:12:44',12,3,2)

-- End of file.