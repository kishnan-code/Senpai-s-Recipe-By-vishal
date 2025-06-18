<?php
include 'db_c.php'; 


session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        
        echo "🚨 Username or email already exists! Please try again. 💔";
    } else {
        // If username and email are not in use, insert the new user
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password_hashed);

        if ($stmt->execute()) {
            // After successful registration, set session variables
            $_SESSION['id'] = $conn->insert_id;  
            $_SESSION['username'] = $username;

            // Redirect to add_recipe page
            header("Location: comments.php");
            exit(); // Always call exit() after header redirect to prevent further script execution
        } else {
            echo "Oops! Something went wrong. 😔 Please try again.";
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎉 Register - Be a Senpai Member! 🍰</title>
    <style>
        body {
            font-family: 'Lobster', cursive;
            background-color: #f8f8f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            display: flex;
            justify-content: center; 
            align-items: center;
            padding: 15px 20px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        header .logo {
            position: absolute;
            left: 20px;
        }
        header .logo img {
            width: 80px; 
            height: 80px; 
            border-radius: 50%; 
            object-fit: cover;
        }
        header .heading h1 {
            font-size: 2rem; 
            color: #333; 
            font-weight: 700;
            text-align: center;
            margin-left: 100px; 
            flex-grow: 1;
        }
        h1 {
            text-align: center;
            color: #333;
            font-size: 2.5em;
            margin-top: 20px;
        }

        .container {
            max-width: 800px;     
            width: 100%;          
            margin: 0 auto;       
            padding: 20px;       
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .registration-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fef9ec; /* Soft yellow background */
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.8rem;
            color:#333;
            font-weight: 600;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 1.1rem;
            color: #333;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .error-message {
            color: #e74c3c;
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
        }

        .success-message {
            color: #2ecc71;
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>
<header>
    <nav>
        <div class="logo">
            <!-- Logo image -->
            <img src="photos/logo.jpg" alt="Senpai's Recipes Logo">
        </div>
        <div class="heading">
            <h1>🎉 Register and Join the Senpai Community 🍰</h1>
        </div>
    </nav>
</header>

<div class="registration-container">
    <h2>Sign Up Now! </h2>
    <form action="user.php" method="POST">
        <label for="username">Username </label>
        <input type="text" id="username" name="username" required>
        <label for="email">Email </label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password </label>
        <input type="password" id="password" name="password" required>
        <input type="submit" value="Register Now ✨">
    </form>

    <!-- Display error or success message -->
    <?php if (isset($error)): ?>
        <div class="error-message">
            <?= $error; ?>
        </div>
    <?php endif; ?>

    <!-- You can display success message here -->
    <!--<div class="success-message">
        🎉 Congratulations! You are now a part of the Senpai family! ❤️
    </div> 

</div>

</body>

</html>
