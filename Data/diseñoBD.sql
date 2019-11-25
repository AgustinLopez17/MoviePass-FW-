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
                    id_show int,
                    date_purchase date,
                    discount int,
                    qr varchar(200),
                    DNI int,
                    amount int,
                    constraint pk_purchases primary key(id_purchase),
                    constraint fk_purchases_users foreign key(DNI) references users(DNI),
                    constraint fk_purchases_id_show foreign key(id_show) references shows(id_show)
);

create table tickets(
                    id_ticket int auto_increment,
                    tk_code varchar(30),
                    id_purchase int,
                    id_show int,
                    constraint pk_tickets primary key(id_ticket),
                    constraint fk_tickets_purchases foreign key(id_purchase) references purchases(id_purchase),
                    constraint fk_tickets_id_show foreign key(id_show) references shows(id_show)
);


DELIMITER $$
CREATE PROCEDURE createMT(IN Iname varchar(20), IN Iadress varchar(20),IN Iavailable int, IN InumberOfCinemas int, IN IpriceDefault int, IN IcapacityDefault int)
    BEGIN
        DECLARE vIdMT int DEFAULT -1;
        DECLARE vNumberOfCinemas int DEFAULT 1;
        INSERT INTO movieTheater(name,adress,available,numberOfCinemas) VALUES (Iname,Iadress,Iavailable,InumberOfCinemas);
        set vIdMt = last_insert_id();
        WHILE vNumberOfCinemas <= InumberOfCinemas DO 
            INSERT INTO cinemas (id_movieTheater,number_cinema,capacity,ticket_value,available) VALUES (vIdMt,vNumberOfCinemas,IcapacityDefault,IpriceDefault,1);
            SET vNumberOfCinemas = vNumberOfCinemas+1;
        END WHILE;
    END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE createTicketsAndPurchase(IN Iid_show int,IN Itk_code varchar(30), IN InumberOfTickets int,IN Idate_purchase date, IN Idiscount int, IN Iqr varchar(200), IN Idni int, IN Iamount int)
    BEGIN
        DECLARE vLastId int DEFAULT -1;
        DECLARE vAux int DEFAULT 0;
        INSERT INTO purchases(purchased_tickets,id_show,date_purchase,discount,qr,DNI,amount) VALUES (InumberOfTickets,Iid_show,Idate_purchase,Idiscount,Iqr,Idni,Iamount);
        set vLastId = last_insert_id();
        WHILE vAux < InumberOfTickets DO
            INSERT INTO tickets(tk_code,id_purchase,id_show) VALUES (Itk_code,vLastId,Iid_show);
            set vAux = vAux+1;
        END WHILE;
    END $$
DELIMITER ;


call moviepass.createMT(:name,:adress,:available,:numberOfCinemas,:priceDefault);


SELECT
    s.id_show,s.show_date,s.id_cinema,s.id_movieTheater,s.id_movie,s.total_tickets,s.ticket_price,s.tickets_sold
FROM
    shows s
INNER JOIN
    purchases p 
ON
    s.id_show = p.id_show
INNER JOIN
    movieTheater mt
ON
    s.id_movieTheater = mt.id_movieTheater
GROUP BY s.id_show;