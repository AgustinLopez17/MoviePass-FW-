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
                    id_movie int,
                    constraint pks_shows primary key (id_show),
                    constraint fk_shows_id_cinema foreign key (id_cinema) references Cinemas(id_cinema),
                    constraint fk_shows_id_movie foreign key (id_movie) references Movies(id_movie)
);

create table purchase(
                    id_purchase int auto_increment not null,
                    purchase_day date,
                    q_tickets int,
                    total float,
                    discount float,
                    dni int,
                    CONSTRAINT pk_id_purchase PRIMARY KEY (id_purchase),
                    CONSTRAINT fk_dni FOREIGN KEY (dni) references users(dni)
);

create table tickets(
                    id_ticket int auto_increment,
                    ticket_number varchar(3),
                    qr_code blob,
                    id_show int,
                    id_purchase int,
                    constraint pk_id_ticket primary key (id_ticket),
                    constraint fk_id_purchase foreign key (id_purchase) references purchase (id_purchase),
                    constraint fk_id_show foreign key (id_show) references shows (id_show)
);


UPDATE shows SET show_date = '2019-11-01 22:05' WHERE id_show = 1;


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

call moviepass.createMT(:name,:adress,:available,:numberOfCinemas,:priceDefault);