<?php
session_start();
include 'db_c.php';  

// Fetch all comments
$sql = "SELECT U_comments.id, U_comments.comment, U_comments.likes, U_comments.dislikes, users.username, U_comments.user_id 
        FROM U_comments
        JOIN users ON U_comments.user_id = users.id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Handle like/dislike actions
if (isset($_GET['like_comment_id'])) {
    $comment_id = $_GET['like_comment_id'];
    $stmt = $conn->prepare("UPDATE U_comments SET likes = likes + 1 WHERE id = ?");
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();
}

if (isset($_GET['dislike_comment_id'])) {
    $comment_id = $_GET['dislike_comment_id'];
    $stmt = $conn->prepare("UPDATE U_comments SET dislikes = dislikes + 1 WHERE id = ?");
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Comments</title>
    <style> 
   <style> 
    body {
        font-family: 'Lobster', cursive;
        background-color: #f9f9f9;
        margin: 0;
        padding: 0;
    }
    header {
            display: flex;
            justify-content: center; 
            align-items: center;
            padding: 10px 20px;
            background-color: #fff;
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
            font-size: 1.8rem; 
            color: #333; 
            font-weight: 700;
            text-align: center;
            margin-left: 100px; 
            flex-grow: 1;
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

    .comment {
        background-color: #f1f1f1;
        padding: 18px;
        border-radius: 10px;
        margin-bottom: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
    }

    .comment strong {
        color: #3498db;
        font-size: 16px;
    }

    .comment p {
        font-size: 16px;
        color: #555;
    }

    .comment-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }

    .like-dislike {
        cursor: pointer;
        color: #3498db;
        font-weight: bold;
        text-decoration: none; /* No underline */
    }

    .like-dislike:hover {
        color: #2980b9;
    }

    .delete {
        cursor: pointer;
        color: #e74c3c;
        font-weight: bold;
        text-decoration: none; /* No underline */
    }

    .delete:hover {
        color: #333;
    }

    .comment-buttons a {
        padding: 5px 10px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .comment-buttons a:hover {
        background-color: #ecf0f1;
    }

</style>
<bodyy>
<header>
    <nav>
        <div class="logo">
           
            <img src="photos/logo.jpg" alt="Senpai's Recipes Logo">
        </div>
        <div class="heading">
            <h1>Recipe Reviews! ✨</h1>
        </div>
    </nav>
</header>
<div class="container">

   
    
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='comment'>";
            echo "<strong>" . $row['username'] . "</strong><br>";
            echo "<p>" . $row['comment'] . "</p>";
            echo "<div class='comment-buttons'>";
           
            echo "<a href='?like_comment_id=" . $row['id'] . "' class='like-dislike'>👍 Like (" . $row['likes'] . ")</a>";
           
            echo "<a href='?dislike_comment_id=" . $row['id'] . "' class='like-dislike'>👎 Dislike (" . $row['dislikes'] . ")</a>";
            
            
            if ($row['user_id'] == $_SESSION['id']) {
                echo "<a href='?delete_comment_id=" . $row['id'] . "' class='delete'>❌ Delete</a>";
            }
            echo "</div></div>";
        }
    } else {
        echo "<p>No comments yet.</p>";
    }
    ?>

</div>
</body>
</html>
