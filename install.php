<?php
    $mysqli = mysqli_connect("localhost", "root", "berni196742");

    if (mysqli_connect_errno($mysqli)) {
        echo "Echec lors de la connexion à MySQL : " . mysqli_connect_error();
    }
    mysqli_query($mysqli, "DROP DATABASE IF EXISTS minishop");
    mysqli_query($mysqli, "CREATE DATABASE minishop");
    mysqli_select_db($mysqli, "minishop");
    $user_creation = "CREATE TABLE `user` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `passwd` VARCHAR(255) NOT NULL,
        `fname` VARCHAR(255),
        `lname` VARCHAR(255),
        `email` VARCHAR(255),
        `address` VARCHAR(255),
        `city` VARCHAR(255),
        `postal_code` INT NOT NULL,
        `phone` VARCHAR (100),
        PRIMARY KEY (`id`)
    )";
    mysqli_query($mysqli, $user_creation);
    $product_creation = "CREATE TABLE `product` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(255) NOT NULL,
        `description` VARCHAR(1024) NOT NULL,
        `img` VARCHAR(1024) DEFAULT 'https://image.ibb.co/jTEH0S/default.png',
        `price` FLOAT  NOT NULL,
        `stock` INT  NOT NULL,
        PRIMARY KEY (`id`)
    )";
    mysqli_query($mysqli, $product_creation) ;

    $categories_creation = "CREATE TABLE `category` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(255) NOT NULL,
        PRIMARY KEY (`id`)
    )";
    mysqli_query($mysqli, $categories_creation);

    $category_map_creation = "CREATE TABLE `category_map` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `product_id` INT NOT NULL,
        `category_id` INT NOT NULL,
        PRIMARY KEY (`id`)
    )";

    mysqli_query($mysqli, $category_map_creation);

    $order_creation = "CREATE TABLE `order` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `user_id` INT NOT NULL,
        `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    )";
    mysqli_query($mysqli, $order_creation);

    $order_item_creation = "CREATE TABLE `order_item` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `order_id` INT NOT NULL,
        `product_id` INT NOT NULL,
        `quantity` INT NOT NULL,
        PRIMARY KEY (`id`)
    )";
    mysqli_query($mysqli, $order_item_creation);
    mysqli_query($mysqli, "ALTER TABLE `category_map` ADD CONSTRAINT `category_map_fk0` FOREIGN KEY (`product_id`) REFERENCES `product`(`id`)  ON UPDATE CASCADE ON DELETE SET NULL");
    mysqli_query($mysqli, "ALTER TABLE `category_map` ADD CONSTRAINT `category_map_fk1` FOREIGN KEY (`category_id`) REFERENCES `category`(`id`) ON UPDATE CASCADE ON DELETE SET NULL");
    mysqli_query($mysqli, "ALTER TABLE `order` ADD CONSTRAINT `order_fk0` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`) ON UPDATE CASCADE ON DELETE CASCADE");
    mysqli_query($mysqli, "ALTER TABLE `order_item` ADD CONSTRAINT `order_item_fk0` FOREIGN KEY (`order_id`) REFERENCES `order`(`id`) ON UPDATE CASCADE ON DELETE CASCADE");
    mysqli_query($mysqli, "ALTER TABLE `order_item` ADD CONSTRAINT `order_item_fk1` FOREIGN KEY (`product_id`) REFERENCES `product`(`id`) ON UPDATE CASCADE ON DELETE CASCADE");

    mysqli_query($mysqli, "INSERT INTO product (name, description, img, price, stock) VALUES ('McLaren MP4/3', 'Moteur Honda 6 cylindres en V Turbo  850 ch 12 000 RPM, Masse : 540 kg, 6 vitesses', 'https://cdn-8.motorsport.com/images/mgl/0oKPyrw0/s8/f1-hungarian-gp-1987-alain-prost-mclaren-mp4-3-tag-porsche.jpg', 484132, 4)"); 
    mysqli_query($mysqli, "INSERT INTO product (name, description, img, price, stock) VALUES ('McLaren MP4/4', 'Moteur Honda 6 cylindres en V Turbo  650 ch 12 000 RPM, Masse : 540 kg, 6 vitesses', 'https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/gettyimages-811385962-1510339287.jpg', 4648456, 4)");
    mysqli_query($mysqli, "INSERT INTO product (name, description, img, price, stock) VALUES ('McLaren MP4/5', 'Moteur Honda V10 675 ch 13 000 RPM, Masse : 505 kg, 6 vitesses', 'http://www.statsf1.com/constructeurs/photos/68/116.jpg', 5464654, 4)");
    mysqli_query($mysqli, "INSERT INTO product (name, description, img, price, stock) VALUES ('McLaren MP4/6', 'Moteur Honda V12 710 ch 13 000 RPM, Masse : 505 kg, 6 vitesses', 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/48/Ayrton_Senna_1991_Monaco.jpg/310px-Ayrton_Senna_1991_Monaco.jpg', 5484131, 4)");
    mysqli_query($mysqli, "INSERT INTO product (name, description, img, price, stock) VALUES ('McLaren MP4/7A', 'Moteur Honda 12 cylindres en V 770 ch 14 500 RPM, Masse : 505 kg, 6 vitesses', 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/73/McLaren_MP4-7_left_Honda_Collection_Hall.jpg/1200px-McLaren_MP4-7_left_Honda_Collection_Hall.jpg', 10000, 4)");
    mysqli_query($mysqli, "INSERT INTO product (name, description, img, price, stock) VALUES ('McLaren MP4/8', 'Moteur Ford-Cosworth v8 630 ch 12 000 RPM, Masse : 505 kg, 6 vitesses', 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/52/Senna%27s_McLaren_MP4-8.jpg/1200px-Senna%27s_McLaren_MP4-8.jpg', 4541231, 4)");
    mysqli_query($mysqli, "INSERT INTO product (name, description, img, price, stock) VALUES ('McLaren MCL32', 'Moteur Honda v6 Hybrid 1000ch 15 000 RPM, Masse: 728kg, 8 vitesses' , 'https://photos2.tf1.fr/660/370/mclaren-f1-mcl32-1-458395-0@1x.jpg', 1051578, 4)");
    mysqli_query($mysqli, "INSERT INTO product (name, description, img, price, stock) VALUES ('RedBull RB4', 'Moteur Renault v8 18 000 RPM , Masse : 605 kg, 7 vitesses', 'https://upload.wikimedia.org/wikipedia/commons/4/4b/Redbull-webber2-spain-2008-lrg.jpg', 1200005, 4)");
    mysqli_query($mysqli, "INSERT INTO product (name, description, img, price, stock) VALUES ('Ferrari F2004', 'Moteur Ferrari v10 19 000 RPM , Masse : 605 kg, 7 vitesses', 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d3/Michael_Schumacher_Ferrari_2004.jpg/310px-Michael_Schumacher_Ferrari_2004.jpg', 4500000, 4)");
    

    mysqli_query($mysqli, "INSERT INTO category (name) VALUE ('Moteur v10')");
    mysqli_query($mysqli, "INSERT INTO category (name) VALUE ('Moteur v8')");
    mysqli_query($mysqli, "INSERT INTO category (name) VALUE ('Moteur v12')");
    mysqli_query($mysqli, "INSERT INTO category (name) VALUE ('Moteur v6 Hybrid')");
    mysqli_query($mysqli, "INSERT INTO category (name) VALUE ('Formule 1')");
    mysqli_query($mysqli, "INSERT INTO category_map (product_id, category_id) VALUE ((SELECT id from product where name = 'McLaren MCL32'), (select id from category where name = 'Moteur v6 Hybrid'))");
    mysqli_query($mysqli, "INSERT INTO category_map (product_id, category_id) VALUE ((SELECT id from product where name = 'McLaren MP4/5'), (select id from category where name = 'Moteur v10')) ");
    mysqli_query($mysqli, "INSERT INTO category_map (product_id, category_id) VALUE ((SELECT id from product where name = 'McLaren MP4/6'), (select id from category where name = 'Moteur v12')) ");
    mysqli_query($mysqli, "INSERT INTO category_map (product_id, category_id) VALUE ((SELECT id from product where name = 'McLaren MP4/8'), (select id from category where name = 'Moteur v8')) ");
    mysqli_query($mysqli, "INSERT INTO category_map (product_id, category_id) VALUE ((SELECT id from product where name = 'RedBull RB4'), (select id from category where name = 'Moteur v8')) ");

    mysqli_query($mysqli, "INSERT INTO category_map (product_id, category_id) VALUE ((SELECT id from product where name = 'Ferrari F2004'), (select id from category where name = 'Moteur v10')) ");

    mysqli_query($mysqli, "INSERT INTO category_map (product_id, category_id) VALUE ((SELECT id from product where name = 'Ferrari F2004'), (select id from category where name = 'Formule 1')) ");
    
    mysqli_query($mysqli, "INSERT INTO category_map (product_id, category_id) VALUE ((SELECT id from product where name = 'McLaren MCL32'), (select id from category where name = 'Formule 1')) ");
    mysqli_query($mysqli, "INSERT INTO category_map (product_id, category_id) VALUE ((SELECT id from product where name = 'McLaren MP4/3'), (select id from category where name = 'Formule 1')) ");
    mysqli_query($mysqli, "INSERT INTO category_map (product_id, category_id) VALUE ((SELECT id from product where name = 'McLaren MP4/4'), (select id from category where name = 'Formule 1')) ");
    mysqli_query($mysqli, "INSERT INTO category_map (product_id, category_id) VALUE ((SELECT id from product where name = 'McLaren MP4/5'), (select id from category where name = 'Formule 1')) ");
    mysqli_query($mysqli, "INSERT INTO category_map (product_id, category_id) VALUE ((SELECT id from product where name = 'McLaren MP4/7A'), (select id from category where name = 'Formule 1')) ");
    mysqli_query($mysqli, "INSERT INTO category_map (product_id, category_id) VALUE ((SELECT id from product where name = 'McLaren MP4/6'), (select id from category where name = 'Formule 1')) ");
    mysqli_query($mysqli, "INSERT INTO category_map (product_id, category_id) VALUE ((SELECT id from product where name = 'McLaren MP4/8'), (select id from category where name = 'Formule 1')) ");
    mysqli_query($mysqli, "INSERT INTO category_map (product_id, category_id) VALUE ((SELECT id from product where name = 'RedBull RB4'), (select id from category where name = 'Formule 1')) ");

    mysqli_query($mysqli, "INSERT INTO user (passwd, fname, lname, email, address, city, postal_code, phone) VALUES ('" . hash('whirlpool', 'admin') . "', 'admin', 'admin', 'admin', 'admin', 'admin', 01, 'admin')");
    mysqli_query($mysqli, "INSERT INTO user (passwd, fname, lname, email, address, city, postal_code, phone) VALUES ('" . hash('whirlpool', 'test') . "', 'test', 'test', 'test', 'test', 'test', 02, 'test')");
    mysqli_close($mysqli);
    echo "<h1>Installation Done</h1>";
?>
