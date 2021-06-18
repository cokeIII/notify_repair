<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "notify_repair";
// Create connection
$conn = new mysqli($servername, $username, $password,$db);
$conn->set_charset("utf8");