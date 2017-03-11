<?php
 require_once "config.php";
 global $db_config;

 // header("Content-Type: text/json");

 try {
     $pdo = new PDO("mysql:host=".$db_config['host'].";dbname=".$db_config['veritabani_adi'] ."",
         $db_config['user'],
         $db_config['pass'],
         array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

 }catch (PDOException $PDOException){
     die("Mysql bağlantısı başarısız oldu.");
 }



