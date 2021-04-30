
create table table1 (

                        id int not null auto_increment,
                        config_id int,
                        datetime timestamp not null,
                        ip varchar(20) not null,
                        url_with_in varchar(255) not null,
                        url_on   varchar(255) not null,
                        primary key (id),
                        foreign key (config_id )  references table2 (id)
);
create table table2 (

                        id int not null auto_increment,
                        ip varchar(20) not null,
                        name_browser varchar(40) not null,
                        name_os  varchar(30) not null,
                        primary key (id)
);
