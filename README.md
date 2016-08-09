# eBuy

eBuy is an auction website that aims to implement the various features included in eBay. It was developed with the ScotchBox Vagrant LAMP stack.

## Features

* Users can register with the system and create accounts.
* Users have roles of seller or buyer with different privileges.
* Sellers can create auctions for particular items, setting suitable conditions and features of the items including the item description, categorisation, starting price, reserve price and end date.
* Buyers can search the system for particular kinds of item being auctioned and can browse and visually re-arrange listings of items within categories.
* Buyers can bid for items and see other buyers’ bids. The system will manage the auction until the set end time and award the item to the highest bidder. The system confirms to both the winner and seller of an auction its outcome.
* Buyers can watch auctions on items and receive emailed updates on bids on those items including notifications when they are outbid.
* Sellers can receive reports on the progress of the auction through to completion and how much viewing traffic their auction items have had.
* Buyers and sellers have visible ratings aggregated from the feedback on their participation in auctions.

## How To Use

1. Create an account as a buyer or a seller.
2. If you are a seller, you can now create as many auctions as you wish.
3. If you are a buyer, you can bid on as many auctions as you wish.
4. Once an auction expires, the highest bidder wins the item.

## Setup

1. Download your favorite LAMP stack. We used the [ScotchBox Vagrant LAMP stack] (https://box.scotch.io/). Their website also includes detailed information on how to setup Vagrant.
2. Clone the repo to the working directory of your LAMP stack.
3. Connect to the MySQL database using your tool of choice, and execute the [ebay_clone.sql] (https://github.com/alessfg/ebuy/blob/master/ebay_clone.sql) script. You can uncomment the test data found at the end of the script if you wish to begin the database with some data.
4. Open the localhost port in your favorite browser.
5. You should be greeted with the eBuy login screen.

## Notes

* No actual money or items are involved in the auction.
* There is no fake currency implemented, buyers can always bid for any given item and sellers never get payed at the end of an auction.

## Credit

This website was created by Alessandro Fael, Ambroise Laurent, and Dhruv Ghulati as part of their Database and Information Management Systems course for the UCL MSc in Computer Science.
