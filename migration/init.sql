-- データベースを作成する
CREATE DATABASE KUSO_SHOP;

-- データベースを使用する
USE KUSO_SHOP;

-- 商品情報テーブルを作成する
CREATE TABLE Product (
    ProductID INT PRIMARY KEY AUTO_INCREMENT,
    ProductName VARCHAR(50),
    Price INT,
    Description VARCHAR(255),
    DeleteDate VARCHAR(11)
);

-- 顧客情報テーブルを作成する
CREATE TABLE Customer (
    PostCode VARCHAR(8),
    CreditNumber VARCHAR(16),
    AddressLine VARCHAR(255),
    CustomerID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    Email VARCHAR(50) unique,
    Phone VARCHAR(20),
    DeleteDate VARCHAR(11)
);

-- カート
CREATE TABLE Cart(
    CustomerID INT,
    ProductID INT,
    Count INT,
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID),
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID),
    CancelDate VARCHAR(11)
);
-- 注文情報テーブルを作成する(OrderだとSQLの予約語なのでこの名前にしとる)。
CREATE TABLE ProductOrder(
    PaymentMethod INT,
    OrderID INT PRIMARY KEY,
    CustomerID INT,
    OrderDate VARCHAR(11),
    AddressLine VARCHAR(255),
    TotalAmount INT,
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID),
    CancelDate VARCHAR(11)
);

-- パスワード保存用のテーブルを作成する
CREATE TABLE Password (
    CustomerID INT PRIMARY KEY,
    PasswordHash CHAR(60) BINARY,
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID)
);
-- ログイン試行回数記録用のテーブルを作成する
CREATE TABLE LoginAttempt (
    AttemptID INT PRIMARY KEY AUTO_INCREMENT,
    CustomerID INT,
    AttemptTime DATETIME,
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID)
);