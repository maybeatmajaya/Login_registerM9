<?php
// functions.php
function registerUser($email, $password, $fullname) {
    global $pdo;
    $level = 2; // Assuming regular users get level 2
    $stmt = $pdo->prepare("INSERT INTO user_detail (user_email, user_password, user_fullname, level) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$email, $password, $fullname, $level]);
}

function loginUser($email, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM user_detail WHERE user_email = ? AND user_password = ?");
    $stmt->execute([$email, $password]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>