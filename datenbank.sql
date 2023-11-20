create table produkt (
    id int(11) not null auto_increment primary key,
    name varchar(255) not null,
    beschreibung varchar(255) not null,
    price decimal(33,8) not null
);