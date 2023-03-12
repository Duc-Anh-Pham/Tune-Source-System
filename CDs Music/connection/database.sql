create database msw;

use msw;

-- tables in this database: album, category, store, customer, 
-- staff, bill, billdetail
create table category
(
	categoryID int auto_increment primary key,
    categoryName varchar(50) not null unique
);
-- insert data
insert into category (categoryName) values
('Pop'), ('Rock'), ('Hip-hop'), ('Jazz'), 
('Classical'), ('Dance'), ('Blues'), 
('Soul'),('Country'),('World Music');
select * from category;

create table album
(
	albumID int not null primary key,
    albumName varchar(50) not null,
    categoryID int,
    albumImage varchar(20) null,
    albumDetails varchar(500) null,
	albumPrice int not null,
    constraint fk_album FOREIGN KEY (categoryID) references category(categoryID)
);

insert into album values
(1, 'Lover', 1 ,'product01.jpg', 'Most sold albums. ', 230.000), 
(2, 'Appetite for Destruction', 2, 'product02.jpg', 'albums are selling well.', 276.000),
(3, 'To Pimp a Butterfly', 3, 'product03.jpg', 'albums are on sale. ', 322.000),
(4, ' A Love Supreme', 4, 'product04.jpg', 'Old albums with new designs ', 345.000),
(5, 'Discovery', 5, 'product05.jpg', 'New albums are hot.',  253.000),
(6, 'The Four Seasons', 6, 'product06.jpg', 'albums are on sale.', 207.000),
(7, 'Texas Flood', 7, 'product07.jpg', 'Old albums with new designs.',  299.000),
(8, 'Songs in the Key of Life', 8, 'product08.jpg', 'Old albums with new designs.', 368.000),
(9, 'Red Headed Stranger', 9, 'product09.jpg', 'albums are on sale.', 184.000),
(10, 'Buena Vista Social Club', 10, 'product10.jpg', 'albums are selling well.', 391.000);
select * from album;

-- create table author
-- (
-- 	authorID int not null primary key,
--     authorName varchar(50),
--     albumID int not null,
--     constraint fk_author FOREIGN KEY (albumID) references album(albumID)
-- );
-- insert into author value
-- (1, 'Taylor Swift', 'SP1'), (2, 'Guns N Roses', 'SP2'), (3, 'Kendrick Lamar', 'SP3'), (4, 'Coltrane', 'SP4'), (5, 'Daft Punk', 'SP5'),
-- (6, 'Antonio Vivaldi', 'SP6'), (7, 'Stevie Ray Vaughan and Double Trouble', 'SP7'), (8, 'Stevie Wonder', 'SP8'), (9, 'Willie Nelson', 'SP9'), 
-- (10, 'Buena Vista Social Club', 'SP10');
-- select * from author;

create table manager
(
	managerID 		varchar(15) not null primary key,
    managerPass 		varchar(20) not null,
    managerFullname 	varchar(50) not null,
    managerEmail 		varchar(50) not null,
    managerPhoto 		varchar(50) not null,
	albumID int null,
    numberphone int,
    Address varchar(200),
    constraint fk_manager foreign key (albumID) references album(albumID)
);

insert into manager values
('Administrator1', '1234', 'Pham Duc Anh', 'ducanh04022003@gmail.com', 'user1.jpg', null, null, null),
('Administrator2', '1234', 'Pham Minh Anh', 'minhanh04022003@gmail.com', 'user2.jpg', null, null, null),
('Administrator3', '1234', 'Pham Vy Anh', 'vyanh04022003@gmail.com', 'user3.jpg', null, null, null);

select * from manager;

create table customers
(
	customerID 			varchar(50) not null primary key,
    customerPass 		varchar(20) not null,
    customerFullName	varchar(50) not null,
    customerEmail 		varchar(50) not null,
    customerPhoto 		varchar(50) null,
    numberphone 		int null, 
    Address	varchar(200),
    albumID int not null,
    constraint fk_customers foreign key (albumID) references album(albumID)
);

select * from customers;

create table cart
(	
    albumID int not null, 
    quantity int not null, 
    defaultPrice varchar(50) not null,
	constraint fk_cart FOREIGN KEY (albumID) references album(albumID)
);
select * from cart;


create table checkout
(	
	customerID varchar(50) not null primary key,
    AddressLine1	varchar(100) not null,
    Country			varchar(50) not null,
    City			varchar(50) not null,
    State			varchar(50) not null,
    ZIPCode			varchar(50) not null,
    constraint fk_checkout FOREIGN KEY (customerID) references customers(customerID)
);
select * from checkout;

create table customerManager
(
	managerID varchar(15) not null,
    customerID Varchar(50) not null,
	constraint fk_CM1 FOREIGN KEY (managerID) references manager(managerID),
	constraint fk_CM2 FOREIGN KEY (customerID) references customers(customerID)

);

create table giftCard 
(
	giftCardID varchar(20) not null primary key,
    customerID varchar(50) not null,
    albumID int not null,
	constraint fk_giftCard1 FOREIGN KEY (customerID) references customers(customerID),
	constraint fk_giftCard2 FOREIGN KEY (albumID) references album(albumID)
);
select * from giftCard;

create table giftCardAccount 
(
	giftCardID varchar(20) not null,
    managerID varchar(15) not null,
    constraint fk_GC1 FOREIGN KEY (managerID) references manager(managerID),
	constraint fk_GC2 FOREIGN KEY (giftCardID) references giftCard(giftCardID)
);

create table updateAccount	
(
	updateID varchar(50) not null Primary key,
    customerID varchar(50) not null,
    versionName varchar(50),   	
    constraint fk_update FOREIGN KEY (customerID) references customers(customerID)
);
select * from updateAccount;

create table purchase 
(
	purchaseID varchar(20) not null primary key,
    giftCardID varchar(20) not null,
    updateID varchar(50) not null,
    constraint fk_Pur1 foreign key (giftCardID) references giftCard(giftCardID),
	constraint fk_Pur2 foreign key (updateID) references updateAccount(updateID)
);
select * from purchase;


create table updateManager
(
	managerID 	varchar(15) not null, 
    updateID varchar(50) not null, 	 
	constraint fk_Upmanager1 FOREIGN KEY (managerID) references manager(managerID),
	constraint fk_Upmanager2 FOREIGN KEY (updateID) references updateAccount(updateID)
);
select * from updateManager;	
