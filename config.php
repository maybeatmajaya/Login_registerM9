<?php
$host = 'localhost';
$dbname = 'user_detail';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

function registerUser($email, $password, $fullname) {
    global $pdo;
    $level = 2; 
    $stmt = $pdo->prepare("INSERT INTO user_detail (user_email, user_password, user_fullname, level) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$email, $password, $fullname, $level]);
}

function loginUser($email, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM user_detail WHERE user_email = ? AND user_password = ?");
    $stmt->execute([$email, $password]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAllUsers() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM user_detail");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateUser($id, $email, $fullname, $level) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE user_detail SET user_email = ?, user_fullname = ?, level = ? WHERE id = ?");
    return $stmt->execute([$email, $fullname, $level, $id]);
}

function deleteUser($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM user_detail WHERE id = ?");
    return $stmt->execute([$id]);
}
