-- we don't know how to generate root <with-no-name> (class Root) :(

grant select on performance_schema.* to 'mysql.session'@localhost;

grant trigger on sys.* to 'mysql.sys'@localhost;

grant audit_abort_exempt, firewall_exempt, select, system_user on *.* to 'mysql.infoschema'@localhost;

grant audit_abort_exempt, authentication_policy_admin, backup_admin, clone_admin, connection_admin, firewall_exempt, persist_ro_variables_admin, session_variables_admin, shutdown, super, system_user, system_variables_admin on *.* to 'mysql.session'@localhost;

grant audit_abort_exempt, firewall_exempt, system_user on *.* to 'mysql.sys'@localhost;

grant alter, alter routine, application_password_admin, audit_abort_exempt, audit_admin, authentication_policy_admin, backup_admin, binlog_admin, binlog_encryption_admin, clone_admin, connection_admin, create, create role, create routine, create tablespace, create temporary tables, create user, create view, delete, drop, drop role, encryption_key_admin, event, execute, file, firewall_exempt, flush_optimizer_costs, flush_status, flush_tables, flush_user_resources, group_replication_admin, group_replication_stream, index, innodb_redo_log_archive, innodb_redo_log_enable, insert, lock tables, passwordless_user_admin, persist_ro_variables_admin, process, references, reload, replication client, replication slave, replication_applier, replication_slave_admin, resource_group_admin, resource_group_user, role_admin, select, sensitive_variables_observer, service_connection_admin, session_variables_admin, set_user_id, show databases, show view, show_routine, shutdown, super, system_user, system_variables_admin, table_encryption_admin, telemetry_log_admin, trigger, update, xa_recover_admin, grant option on *.* to root@localhost;

grant alter, alter routine, create, create routine, create tablespace, create temporary tables, create user, create view, delete, drop, event, execute, file, index, insert, lock tables, process, references, reload, replication client, replication slave, select, show databases, show view, shutdown, super, trigger, update, grant option on *.* to shriyan;

create table categories
(
    id        int auto_increment
        primary key,
    name      varchar(255) not null,
    parent_id int          null,
    constraint categories_categories_id_fk
        foreign key (parent_id) references categories (id)
);

create table masters
(
    id        int auto_increment
        primary key,
    name      varchar(50) not null,
    parent_id int         null,
    constraint masters_ibfk_1
        foreign key (parent_id) references masters (id)
);

create table product_details
(
    id          int auto_increment
        primary key,
    title       varchar(100) null,
    author      varchar(200) null,
    description text         null,
    distributor varchar(20)  null,
    price       int          null,
    image_url   varchar(255) null
);

create table product_categories
(
    id                int auto_increment
        primary key,
    product_detail_id int not null,
    category_id       int not null,
    constraint product_categories_categories_id_fk
        foreign key (category_id) references categories (id),
    constraint product_categories_product_details_id_fk
        foreign key (product_detail_id) references product_details (id)
);

create table product_detail_masters
(
    id                int auto_increment
        primary key,
    product_detail_id int not null,
    master_id         int not null,
    constraint product_detail_masters_masters_id_fk
        foreign key (master_id) references masters (id),
    constraint product_detail_masters_product_details_id_fk
        foreign key (product_detail_id) references product_details (id)
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
    contact_no bigint       not null,
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

