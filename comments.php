<?php
session_start();
include 'db_c.php';  

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: user.php");
    exit();
}

// Handle comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];  // Get the logged-in user's ID
    $comment = $_POST['comment'];

    if (!empty($comment)) {
        // Insert the general comment into the database
        $stmt = $conn->prepare("INSERT INTO U_comments (user_id, comment) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $comment);

        if ($stmt->execute()) {
            // Redirect to the homepage after comment submission
            header("Location: s11.html");  // Redirect to homepage (you can change 'index.php' to any homepage file)
            exit();  // Always call exit after header redirect
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Please enter a comment!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Comment</title>
    <style>
        body {
            font-family: 'Lobster', cursive;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #f4f4f9;
            color: #333;
            padding: 15px;
            text-align: center;
        }

        header nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header .logo {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        header nav a {
            color: #333;
            text-decoration: none;
            margin: 0 15px;
        }

        header nav a:hover {
            text-decoration: underline;
        }
        header .logo img {
            width: 90px; 
            height: 68px; 
            border-radius: 90%; 
            object-fit: cover;
            display: block;
            margin: 0 auto;
        }
        header .logo {
            padding: 0px;
        }




        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #8e44ad;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
            font-size: 16px;
            font-family: 'Arial', sans-serif;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
        .success-message {
            text-align: center;
            font-size: 18px;
            color: #2ecc71;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
<header>
        <nav>
            <div class="logo">
                <img src="photos/logo.jpg" alt="Senpai's Recipes Logo">
            </div>
    </nav>
    </header>


   
    <?php if (isset($_SESSION['id'])): ?>
    <header>
        <nav>
            <div class="heading">
        <h2>Leave Your Comment! 💬</h2>
    </div>
    </nav>
    </header>
        <form method="POST" action="">
            <textarea name="comment" rows="4" placeholder="Write your comment..."></textarea><br>
            <input type="submit" value="Submit Comment ✨">
        </form>
    <?php else: ?>
        <p>You need to be logged in to add a comment. <a href="login.php">Login here</a></p>
    <?php endif; ?>

   
    <?php if (isset($stmt) && $stmt->execute()): ?>
        <div class="success-message">
            Thank you for your comment! 😊 You will be redirected shortly...
        </div>
    <?php endif; ?>

</div>

</body>
</html>
