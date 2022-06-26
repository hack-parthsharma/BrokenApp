<?php
$servername = "localhost";
$username = "root";
$password = "BrokenApp";
$dbname = "BrokenApp";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error) . " \n";
}

$sql = "DROP DATABASE IF EXISTS BrokenApp";
if ($conn->query($sql) === TRUE) {
    echo "Drop Database successfully \n";
} else {
    echo "Error dropping database: " . $conn->error . " \n";
}

// Create database
$sql = "CREATE DATABASE BrokenApp";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully \n";
} else {
    echo "Error creating database: " . $conn->error . " \n";
}

$conn->close();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error) . " \n";
}

$sql = "CREATE TABLE users (user_id int(6),first_name varchar(15),last_name varchar(15), user varchar(15), password varchar(32), PRIMARY KEY (user_id));";
if ($conn->query($sql) === TRUE) {
    echo "Table users created successfully \n";
} else {
    echo "Error creating users Table: " . $conn->error . " \n";
}

$sql = "INSERT INTO users VALUES
        ('1','admin','admin','admin',MD5('password')),
        ('2','Gordon','Brown','gordonb',MD5('abc123')),
        ('3','Hack','Me','1337',MD5('charley')),
        ('4','Pablo','Picasso','pablo',MD5('letmein')),
        ('5','Bob','Smith','smithy',MD5('password'));";

if ($conn->query($sql) === TRUE) {
    echo "Insert data successfully \n";
} else {
    echo "Error Inserting data: " . $conn->error . " \n";
}

$sql = "CREATE TABLE posts (comment_id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT, comment varchar(300), name varchar(100), PRIMARY KEY (comment_id));";

if ($conn->query($sql) === TRUE) {
    echo "create table posts successfully \n";
} else {
    echo "Error creating table posts: " . $conn->error . " \n";
}

$sql = "INSERT INTO posts VALUES ('1','This is a test comment.','test');";
if ($conn->query($sql) === TRUE) {
    echo "Insert data successfully \n";
} else {
    echo "Error Inserting data: " . $conn->error . " \n";
}

$conn->close();
?>
