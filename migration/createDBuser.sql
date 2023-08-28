CREATE USER 'weak_user'@'localhost' IDENTIFIED BY 'goat is dead';
/*after execute init.sql*/
GRANT ALL ON kuso_shop.* TO 'weak_user'@'localhost';
