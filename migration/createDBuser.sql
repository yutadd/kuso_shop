use kuso_shop;
CREATE USER 'weak_user'@'localhost' IDENTIFIED BY '';
/*after execute init.sql*/
GRANT ALL ON kuso_shop.* TO 'weak_user'@'localhost';
