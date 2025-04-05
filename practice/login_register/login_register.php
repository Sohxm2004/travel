<?php
session_start();
require_once 'config.php';

// Registration Handler
if (isset($_POST['register'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $conn->real_escape_string($_POST['role']); // No default - comes from form

    $checkEmail = $conn->query("SELECT email FROM users WHERE email = '$email'");
    
    if ($checkEmail->num_rows > 0) {
        $_SESSION['register_error'] = 'Email is already registered!';
        $_SESSION['active_form'] = 'register';
    } else {
        $conn->query("INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')");
        
        $newUser = $conn->query("SELECT * FROM users WHERE email = '$email'")->fetch_assoc();
        
        // Set session variables (no defaults)
        $_SESSION['user_id'] = $newUser['id'];
        $_SESSION['name'] = $newUser['name'];
        $_SESSION['email'] = $newUser['email'];
        $_SESSION['role'] = $newUser['role']; // Exact role from DB
        
        // Redirect based on actual role
        header("Location: ".($newUser['role'] === 'admin' ? 'admin_page.php' : 'user_page.php'));
        exit();
    }
    header("Location: index.php");
    exit();
}

// Login Handler
if (isset($_POST['login'])) {   
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            // Set exact session values from database
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            
            header("Location: ".($user['role'] === 'admin' ? 'admin_page.php' : 'user_page.php'));
            exit();
        }
    }

    $_SESSION['login_error'] = 'Incorrect email or password';
    $_SESSION['active_form'] = 'login';
    header("Location: index.php");
    exit();
}

$conn->close();
?>