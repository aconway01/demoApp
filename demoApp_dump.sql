-- MySQL dump 10.13  Distrib 8.0.13, for macos10.14 (x86_64)
--
-- Host: localhost    Database: thewelcomecard
-- ------------------------------------------------------
-- Server version	8.0.13

DROP DATABASE IF EXISTS demoApp;
CREATE DATABASE demoApp;

USE demoApp;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `password` varchar(64) NOT NULL,

  PRIMARY KEY (`user_id`)
);
