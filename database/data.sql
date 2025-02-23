
-- only create table, books and user data sql
-- database name is library

create table if not exists books
(
    BookID int auto_increment
        primary key,
    Title  varchar(50)   not null,
    Author varchar(50)   not null,
    Year   int default 0 not null,
    Amount int           not null
);

create table if not exists users
(
    UserID   int auto_increment
        primary key,
    username varchar(50)  default '' not null,
    password varchar(255) default '' not null,
    role     varchar(50)             not null
);

create table if not exists rents
(
    RentID   int auto_increment
        primary key,
    BookID   int         not null,
    UserID   int         not null,
    Approved varchar(50) null,
    Returned varchar(50) null,
    constraint FK_rents_books
        foreign key (BookID) references books (BookID),
    constraint FK_rents_users
        foreign key (UserID) references users (UserID)
);

INSERT INTO library.books (Title, Author, Year, Amount) VALUES ( 'Lord of the Rings 1', 'J.R.R. Tolkien', 1954, 5);
INSERT INTO library.books (Title, Author, Year, Amount) VALUES ('Clean Code', 'Robert Cecil Martin', 2008, 3);
INSERT INTO library.books (Title, Author, Year, Amount) VALUES ('The Almanack of Naval Ravickant', 'Eric Jorgenson', 2020, 4);
INSERT INTO library.books (Title, Author, Year, Amount) VALUES ( 'Learning PHP, MySQL & JavaScript', 'Robin Nixon', 2015, 3);

INSERT INTO library.users (username, password, role) VALUES ('user', '$2y$12$A0ihQNxWvwew6OFIq6wg3e.oV5PjBV.otqeEVnv8AM0sn1L6sBYjq', 'user');
INSERT INTO library.users (username, password, role) VALUES ('admin', '$2y$12$eTsp0eQgfKYWLCNY.ByXvuRWf2wUP5My8GibnfIT/OH5oxiYCALoa', 'admin');
