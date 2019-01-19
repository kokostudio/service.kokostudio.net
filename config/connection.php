<?php
  $dbhost = 'localhost';
  $dbname = 'kokostudio_serv';
  $dbchar = 'utf8';
  $dbuser = 'kokostudio_serv';
  $dbpass = 'pluems';

  $options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
	PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"   //แก้ปัญหา ภาษาไทย ?????
  ];

  try {

    $host = "mysql:host={$dbhost};dbname={$dbname};charset={$dbchar}";
    $dbcon = new PDO($host, $dbuser, $dbpass, $options);

    // echo "Connect Successfully. Host info: " . 
    // $dbcon->getAttribute(constant("PDO::ATTR_CONNECTION_STATUS"));

  } catch (PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
  }


?>