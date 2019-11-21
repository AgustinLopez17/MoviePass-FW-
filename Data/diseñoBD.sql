create database MoviePass;
use MoviePass;

CREATE TABLE users(
                    name varchar(50),
                    surname varchar(50),
                    DNI int not null,
                    email varchar(50),
                    pass varchar(50),
                    user_group int not null,
                    CONSTRAINT pk_dni PRIMARY KEY (dni),
                    CONSTRAINT unq_email UNIQUE (email)
);


create table movieTheater(
                    id_movieTheater int auto_increment,
                    name varchar(20),
                    available int,
                    adress varchar(20),
                    numberOfCinemas int,
                    constraint pk_id_movieTheater primary key (id_movieTheater),
                    constraint unq_name UNIQUE (name)
);

create table cinemas(
                    id_cinema int auto_increment,
                    id_movieTheater int,
                    number_cinema int,
                    capacity int not null,
                    ticket_value int not null,
                    available int not null,
                    constraint pk_id_cinema primary key (id_cinema),
                    constraint fk_id_movieTheater foreign key (id_movieTheater) references movieTheater(id_movieTheater)
);

create table movies(
                    id_movie int,
                    title varchar(20),
                    lenght int,
                    language varchar(10),
                    image text,
                    overview text,
                    background text,
                    constraint pk_id_movie primary key (id_movie)
);

create table genre(
                    id_genre int,
                    genre varchar(50),
                    CONSTRAINT pk_id_genre PRIMARY KEY (id_genre)
);

create table genre_x_movie(
                    id_genre int,
                    id_movie int,
                    CONSTRAINT pk_genre_x_movie PRIMARY KEY (id_genre,id_movie),
                    CONSTRAINT fk_genre_x_movie_id_genre FOREIGN KEY (id_genre) references Genre(id_genre),
                    CONSTRAINT fk_genre_x_movie_id_movie FOREIGN KEY (id_movie) references Movies(id_movie)
);

create table shows(
                    id_show int auto_increment,
                    show_date datetime,
                    id_cinema int,
                    id_movieTheater int,
                    id_movie int,


                    total_tickets int,
                    ticket_price int,
                    tickets_sold int,



                    constraint pks_shows primary key (id_show),
                    constraint fk_shows_id_cinema foreign key (id_cinema) references Cinemas(id_cinema),
                    constraint fk_shows_id_movie foreign key (id_movie) references Movies(id_movie),
                    constraint fk_shows_id_movieTheater foreign key (id_movieTheater) references movieTheater(id_movieTheater)
);
                                   
create table purchases(
                    id_purchase int auto_increment,
                    purchased_tickets int,
                    date_purchase varchar(15),
                    discount int,
                    qr mediumblob,
                    DNI int,
                    constraint pk_purchases primary key(id_purchase),
                    constraint fk_purchases_users foreign key(DNI) references users(DNI)
);

create table tickets(
                    id_ticket int auto_increment,
                    tk_number int,
                    id_purchase int,
                    id_show int,
                    constraint pk_tickets primary key(id_ticket),
                    constraint fk_tickets_showtimes foreign key(id_show) references shows(id_show),
                    constraint fk_tickets_purchases foreign key(id_purchase) references purchases(id_purchase)
);

DROP PROCEDURE IFEXIST(createMT);
DELIMITER $$
CREATE PROCEDURE createMT(IN Iname varchar(20), IN Iadress varchar(20),IN Iavailable int, IN InumberOfCinemas int, IN IpriceDefault int)
    BEGIN
        DECLARE vIdMT int DEFAULT -1;
        DECLARE vNumberOfCinemas int DEFAULT 1;
        INSERT INTO movieTheater(name,adress,available,numberOfCinemas) VALUES (Iname,Iadress,Iavailable,InumberOfCinemas);
        set vIdMt = last_insert_id();
        WHILE vNumberOfCinemas <= InumberOfCinemas DO 
            INSERT INTO cinemas (id_movieTheater,number_cinema,capacity,ticket_value,available) VALUES (vIdMt,vNumberOfCinemas,0,IpriceDefault,0);
            SET vNumberOfCinemas = vNumberOfCinemas+1;
        END WHILE;
    END $$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE createTicketsAndPurchase(IN Iid_show int,IN Itk_number int, IN InumberOfTickets int,IN Idate_purchase date, IN Idiscount int, IN Iqr mediumblob, IN Idni int)
    BEGIN
        DECLARE vLastId int default -1;
        INSERT INTO purchases(purchased_tickets,date_purchase,discount,qr,dni) VALUES (InumberOfTickets,Idate_purchase,Idiscount,Iqr,Idni);
        set vLastId = last_insert_id();
        DECLARE vAux int DEFAULT 0;
        WHILE vAux < numberOfTickets DO
            INSERT INTO tickets(tk_number,id_purchase,id_show) VALUES (Itk_number,vLastId,Iid_show);
        END WHILE;
    END $$
DELIMITER ;


call moviepass.createMT(:name,:adress,:available,:numberOfCinemas,:priceDefault);