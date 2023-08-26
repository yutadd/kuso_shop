-- データベースを作成する
CREATE DATABASE KUSO_SHOP;

-- データベースを使用する
USE KUSO_SHOP;

-- 商品情報テーブルを作成する
CREATE TABLE Product (
    ProductID INT PRIMARY KEY,
    ProductName VARCHAR(50),
    Price INT,
    Description VARCHAR(255),
    DeleteDate DATE
);

-- 顧客情報テーブルを作成する
CREATE TABLE Customer (
    CustomerID INT PRIMARY KEY,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    Email unique VARCHAR(50),
    Phone VARCHAR(20),
    DeleteDate DATE
);

-- 注文情報テーブルを作成する
CREATE TABLE ProductOrder(
    OrderID INT PRIMARY KEY,
    CustomerID INT,
    OrderDate DATE,
    TotalAmount INT,
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID),
    CancelDate Date
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