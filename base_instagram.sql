create database
    if not exists base_instagram;

use base_instagram;

create table
    if not exists users (
        id int auto_increment not null,
        role varchar(255),
        name varchar(255),
        surname varchar(255),
        nick varchar(255),
        email varchar(255),
        password varchar(255),
        image varchar(255),
        created_at datetime,
        updated_at datetime,
        remember_token varchar(255),
        constraint pk_users primary key (id)
    ) engine = InnoDb;

create table
    if not exists images (
        id int auto_increment not null,
        user_id int,
        image_path varchar(255),
        description text,
        created_at datetime,
        updated_at datetime,
        constraint pk_images primary key (id),
        constraint fk_images_users foreign key (user_id) references users(id)
    ) engine = InnoDb;

create table
    if not exists comments (
        id int auto_increment not null,
        user_id int,
        image_id int,
        content text,
        created_at datetime,
        updated_at datetime,
        constraint pk_comments primary key (id),
        constraint fk_comments_users foreign key (user_id) references users(id),
        constraint fk_comments_images foreign key (image_id) references images(id)
    ) engine = InnoDb;

create table
    if not exists likes (
        id int auto_increment not null,
        user_id int,
        image_id int,
        created_at datetime,
        updated_at datetime,
        constraint pk_likes primary key (id),
        constraint fk_likes_users foreign key (user_id) references users(id),
        constraint fk_likes_images foreign key (image_id) references images(id)
    ) engine = innoDb;