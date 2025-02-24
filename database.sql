create table product_details
(
    id        int auto_increment
        primary key,
    title     varchar(100) null,
    author    varchar(200) null,
    publisher varchar(200) null,
    isbn      varchar(20)  null,
    price     int          null,
    image_url varchar(255) null
);

create table products
(
    id                int auto_increment
        primary key,
    status            enum ('SOLD', 'AVAILABLE', 'DAMAGED') default 'AVAILABLE'       null,
    product_detail_id int                                                             not null,
    created_date      timestamp                             default CURRENT_TIMESTAMP null,
    updated_date      timestamp                                                       null on update CURRENT_TIMESTAMP,
    constraint products_ibfk_1
        foreign key (product_detail_id) references product_details (id)
);

create index book_detail_id
    on products (product_detail_id);

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
    password   varchar(100) not null,
    role_id    int          null,
    address    varchar(50)  not null,
    contact_no int          not null,
    constraint users_ibfk_1
        foreign key (role_id) references roles (id)
);

create table payments
(
    id              int auto_increment
        primary key,
    total_cost      int not null,
    delivery_charge int null,
    user_id         int not null,
    constraint payment_user_id_user_id_fk
        foreign key (user_id) references users (id)
);

create table payment_details
(
    id         int auto_increment
        primary key,
    product_id int null,
    payment_id int null,
    constraint payment_details_ibfk_1
        foreign key (payment_id) references payments (id),
    constraint payment_details_ibfk_2
        foreign key (product_id) references products (id)
);

create index book_id
    on payment_details (product_id);

create index payment_id
    on payment_details (payment_id);

create index role
    on users (role_id);

