<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "ehr";
$link = mysqli_connect($server, $username, $password) or die("Cannot connect to server");
$sql = "CREATE DATABASE ehr";

$selectDB = mysqli_select_db($link,$database) or die("Cannot connect to database database");
