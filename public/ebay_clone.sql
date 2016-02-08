-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2016-02-05 23:09:08.594




-- tables
-- Table Auction
CREATE TABLE Auction (
    auction_id int  NOT NULL,
    start_price decimal(8,2)  NOT NULL,
    reserve_price decimal(8,2)  NOT NULL,
    end_price decimal(8,2)  NOT NULL,
    current_bid decimal(8,2)  NOT NULL,
    start_time time  NOT NULL,
    end_time time  NOT NULL,
    viewings int  NOT NULL,
    item_id int  NOT NULL,
    user_id int  NOT NULL,
    CONSTRAINT Auction_pk PRIMARY KEY (auction_id)
);

-- Table Bids
CREATE TABLE Bids (
    bid_id int  NOT NULL,
    user_id int  NOT NULL,
    auction_id int  NOT NULL,
    bid_price decimal(8,2)  NOT NULL,
    CONSTRAINT Bids_pk PRIMARY KEY (bid_id)
);

-- Table Item
CREATE TABLE Item (
    item_id int  NOT NULL,
    item_picture varchar(255)  NOT NULL,
    name varchar(127)  NOT NULL,
    category varchar(31)  NOT NULL,
    features varchar(255)  NOT NULL,
    description varchar(255)  NOT NULL,
    state varchar(63)  NOT NULL,
    CONSTRAINT Item_pk PRIMARY KEY (item_id)
);

-- Table Roles
CREATE TABLE Roles (
    role_id int  NOT NULL,
    role varchar(15)  NOT NULL,
    CONSTRAINT Roles_pk PRIMARY KEY (role_id)
);

-- Table Users
CREATE TABLE Users (
    user_id int  NOT NULL,
    username varchar(31)  NOT NULL,
    password varchar(31)  NOT NULL,
    profile_picture varchar(255)  NOT NULL,
    first_name varchar(31)  NOT NULL,
    last_name varchar(31)  NOT NULL,
    email varchar(63)  NOT NULL,
    birthdate date  NOT NULL,
    rating int  NOT NULL,
    role_id int  NOT NULL,
    CONSTRAINT Users_pk PRIMARY KEY (user_id)
);





-- foreign keys
-- Reference:  Auction_Bids (table: Bids)

ALTER TABLE Bids ADD CONSTRAINT Auction_Bids FOREIGN KEY Auction_Bids (auction_id)
    REFERENCES Auction (auction_id);
-- Reference:  Auction_Item (table: Auction)

ALTER TABLE Auction ADD CONSTRAINT Auction_Item FOREIGN KEY Auction_Item (item_id)
    REFERENCES Item (item_id);
-- Reference:  Auction_Users (table: Auction)

ALTER TABLE Auction ADD CONSTRAINT Auction_Users FOREIGN KEY Auction_Users (user_id)
    REFERENCES Users (user_id);
-- Reference:  Users_Bids (table: Bids)

ALTER TABLE Bids ADD CONSTRAINT Users_Bids FOREIGN KEY Users_Bids (user_id)
    REFERENCES Users (user_id);
-- Reference:  Users_Roles (table: Users)

ALTER TABLE Users ADD CONSTRAINT Users_Roles FOREIGN KEY Users_Roles (role_id)
    REFERENCES Roles (role_id);



-- End of file.

