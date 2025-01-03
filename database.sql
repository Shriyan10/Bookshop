create table book_details
(
    id        int auto_increment
        primary key,
    title     varchar(100) null,
    author    varchar(200) null,
    publisher varchar(200) null,
    isbn      varchar(20)  null,
    price     int(10)      null
);

create table books
(
    id             int auto_increment
        primary key,
    status         enum ('SOLD', 'AVAILABLE', 'DAMAGED') default 'AVAILABLE' null,
    book_detail_id int                                                       not null,
    constraint books_ibfk_1
        foreign key (book_detail_id) references book_details (id)
);

create index book_detail_id
    on books (book_detail_id);

create table roles
(
    id   int auto_increment
        primary key,
    name varchar(10) null
);

create table users
(
    id         int auto_increment
        primary key,
    first_name varchar(50)  not null,
    last_name  varchar(50)  not null,
    email      varchar(100) not null,
    password   varchar(10)  not null,
    role_id    int          null,
    address    varchar(50)  not null,
    contact_no int(10)      not null,
    constraint users_ibfk_1
        foreign key (role_id) references roles (id)
);

create table payments
(
    id              int auto_increment
        primary key,
    total_cost      int(10) not null,
    delivery_charge int(12) null,
    user_id         int     not null,
    constraint payment_user_id_user_id_fk
        foreign key (user_id) references users (id)
);

create table payment_details
(
    id         int auto_increment
        primary key,
    book_id    int null,
    payment_id int null,
    constraint payment_details_ibfk_1
        foreign key (payment_id) references payments (id),
    constraint payment_details_ibfk_2
        foreign key (book_id) references books (id)
);

create index book_id
    on payment_details (book_id);

create index payment_id
    on payment_details (payment_id);

create index role
    on users (role_id);

