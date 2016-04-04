-- Change root password
-- Hidden input

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
    auction_id int  NOT NULL  AUTO_INCREMENT,
    start_price decimal(8,2)  NOT NULL,
    reserve_price decimal(8,2)  NOT NULL,
    current_bid decimal(8,2)  NOT NULL,
    start_time datetime  NOT NULL,
    duration_id int  NOT NULL,
    end_time datetime  NOT NULL,
    viewings int  NOT NULL  DEFAULT 0,
    win_confirmed bool  NOT NULL,
    item_id int  NOT NULL,
    user_id int  NOT NULL,
    CONSTRAINT Auction_pk PRIMARY KEY (auction_id)
);

-- Table Bids
CREATE TABLE Bids (
    bid_id int  NOT NULL  AUTO_INCREMENT,
    user_id int  NOT NULL,
    auction_id int  NOT NULL,
    bid_price decimal(8,2)  NOT NULL,
    bid_time datetime  NOT NULL,
    CONSTRAINT Bids_pk PRIMARY KEY (bid_id)
);

-- Table Category
CREATE TABLE Category (
    category_id int  NOT NULL  AUTO_INCREMENT,
    category varchar(63)  NOT NULL,
    CONSTRAINT Category_pk PRIMARY KEY (category_id)
);

-- Table Duration
CREATE TABLE Duration (
    duration_id int  NOT NULL  AUTO_INCREMENT,
    duration int  NOT NULL,
    CONSTRAINT Duration_pk PRIMARY KEY (duration_id)
);

-- Table Item
CREATE TABLE Item (
    item_id int  NOT NULL  AUTO_INCREMENT,
    item_picture varchar(255)  NOT NULL,
    label varchar(127)  NOT NULL,
    description varchar(255)  NOT NULL,
    state_id int  NOT NULL,
    category_id int  NOT NULL,
    CONSTRAINT Item_pk PRIMARY KEY (item_id)
);

-- Table Ratings
CREATE TABLE Rating (
    sender_id int  NOT NULL,
    receiver_id int  NOT NULL,
    rating_value int  NOT NULL,
    CONSTRAINT Ratings_pk PRIMARY KEY (sender_id,receiver_id)
);

-- Table Roles
CREATE TABLE Roles (
    role_id int  NOT NULL  AUTO_INCREMENT,
    role varchar(15)  NOT NULL,
    CONSTRAINT Roles_pk PRIMARY KEY (role_id)
);

-- Table State
CREATE TABLE State (
    state_id int  NOT NULL  AUTO_INCREMENT,
    state varchar(63)  NOT NULL,
    CONSTRAINT State_pk PRIMARY KEY (state_id)
);

-- Table Users
CREATE TABLE Users (
    user_id int  NOT NULL  AUTO_INCREMENT,
    username varchar(31)  NOT NULL,
    passwd varchar(40)  NOT NULL,
    profile_picture varchar(255)  NOT NULL,
    first_name varchar(31)  NOT NULL,
    last_name varchar(31)  NOT NULL,
    email varchar(63)  NOT NULL,
    birthdate date  NOT NULL,
    rating_count int  NOT NULL,
    rating decimal(3,2)  NOT NULL  DEFAULT 0,
    role_id int  NOT NULL  DEFAULT 0,
    CONSTRAINT Users_pk PRIMARY KEY (user_id)
);

-- Table Watch
CREATE TABLE Watch (
    user_id int  NOT NULL,
    auction_id int  NOT NULL,
    CONSTRAINT Watch_pk PRIMARY KEY (user_id,auction_id)
);


-- Foreign keys

-- Reference:  Auction_Bids (table: Bids)
ALTER TABLE Bids ADD CONSTRAINT Auction_Bids FOREIGN KEY Auction_Bids (auction_id)
    REFERENCES Auction (auction_id);

-- Reference:  Auction_Duration (table: Auction)
ALTER TABLE Auction ADD CONSTRAINT Auction_Duration FOREIGN KEY Auction_Duration (duration_id)
    REFERENCES Duration (duration_id);

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

-- Reference:  Ratings_Users (table: Ratings)
ALTER TABLE Rating ADD CONSTRAINT Rating_Users FOREIGN KEY Rating_Users (sender_id)
    REFERENCES Users (user_id);

-- Reference:  Users_Bids (table: Bids)
ALTER TABLE Bids ADD CONSTRAINT Users_Bids FOREIGN KEY Users_Bids (user_id)
    REFERENCES Users (user_id);

-- Reference:  Users_Roles (table: Users)
ALTER TABLE Users ADD CONSTRAINT Users_Roles FOREIGN KEY Users_Roles (role_id)
    REFERENCES Roles (role_id);

-- Reference:  Users_Watch (table: Watch)
ALTER TABLE Watch ADD CONSTRAINT Users_Watch FOREIGN KEY Users_Watch (user_id)
    REFERENCES Users (user_id);

-- Reference:  Watch_Auction (table: Watch)
ALTER TABLE Watch ADD CONSTRAINT Watch_Auction FOREIGN KEY Watch_Auction (auction_id)
    REFERENCES Auction (auction_id);

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

INSERT INTO Duration (duration) VALUES (1), (3), (5), (7), (10);

-- Sample Data: Test User
# INSERT INTO Users (username, passwd, first_name, last_name, email, birthdate, rating, role_id)
# VALUES ('test', '1234', 'test', 'user', 'test@test.com', '1978-11-11', 5, 1);
# INSERT INTO Users (username, passwd, first_name, last_name, email, birthdate, rating, role_id)
# VALUES ('test1', '123', 'test1', 'user1', 'test1@test.com', '1989-12-03', 3, 2);
# INSERT INTO Users (username, passwd, first_name, last_name, email, birthdate, rating, role_id)
# VALUES ('test2', 'testy', 'test2', 'user2', 'test2@test.com', '1924-12-03', 4.56, 2);
# INSERT INTO Users (username, passwd, first_name, last_name, email, birthdate, rating, role_id)
# VALUES ('test3', 'testy1', 'test3', 'user3', 'test3@test.com', '1990-12-03', 3.5, 2);

-- Sample Data: Test Items
# INSERT INTO Item (label, description, item_picture, category_id, state_id) VALUES ('Hard Drive', 'Big Capacity', 'uploads/item/hdd.jpg', 11, 2);
# INSERT INTO Item (label, description, item_picture, category_id, state_id) VALUES ('Bouncy Ball', 'Really Bouncy', 'uploads/item/ball.jpg', 12, 1);
# INSERT INTO Item (label, description, item_picture, category_id, state_id) VALUES ('Fiat Leon', 'Really Fast', 'uploads/item/fiat leon.jpg', 7, 5);
# INSERT INTO Item (label, description, item_picture, category_id, state_id) VALUES ('Nike Fly Knit Shoes', 'Comfortable', 'uploads/item/nike.jpg', 8, 4);

-- Sample Data: Test Auctions
# INSERT INTO Auction (start_price, reserve_price, current_bid, start_time, duration_id, end_time, viewings, item_id, user_id) VALUES (50.00, 20.00, 24.00, '2016-11-11 13:23:44', 1, '2016-11-28 15:45:44', 46, 1, 2);
# INSERT INTO Auction (start_price, reserve_price, current_bid, start_time, duration_id, end_time, viewings, item_id, user_id) VALUES (10.32, 45.92, 56.89, '2016-08-23 16:23:44', 2, '2016-08-28 16:12:44', 12, 3, 2);
# INSERT INTO Auction (start_price, reserve_price, current_bid, start_time, duration_id, end_time, viewings, item_id, user_id) VALUES (45.95, 64.00, 96.78, '2016-06-22 09:13:23', 1, '2016-06-25 09:13:23', 3783, 1, 3);
# INSERT INTO Auction (start_price, reserve_price, current_bid, start_time, duration_id, end_time, viewings, item_id, user_id) VALUES (55.99, 40.00, 89.99, '2016-06-21 11:30:10', 2, '2016-06-23 11:30:10', 123, 4, 3);
# INSERT INTO Auction (start_price, reserve_price, current_bid, start_time, duration_id, end_time, viewings, item_id, user_id) VALUES (12.78, 23.67, 34.89, '2016-05-11 13:02:44', 3, '2016-05-12 13:08:44', 2455, 3, 4);
# INSERT INTO Auction (start_price, reserve_price, current_bid, start_time, duration_id, end_time, viewings, item_id, user_id) VALUES (12.45, 45.92, 23.67, '2016-04-10 10:15:00', 4, '2016-04-13 10:15:00', 7891, 2, 4);

-- Sample Data: Test Bids



-- End of file.