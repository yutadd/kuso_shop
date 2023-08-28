CREATE USER weak_user IDENTIFIED BY 'goat is dead';
/*after execute init.sql*/
GRANT ALL ON kuso_shop.* TO 'weakuser'@'localhost';
