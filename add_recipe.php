<?php
// Include the database connection file
include('db_c.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $category = $_POST['category'];
    $image_url = $_POST['image_url'];
    $sql = "INSERT INTO recipes (title, ingredients, instructions, category, image_url) 
            VALUES ('$title', '$ingredients', '$instructions', '$category', '$image_url')";

    if (mysqli_query($conn, $sql)) {
        echo "New recipe added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe</title>
</head>
 <style>
 body {
            font-family: 'Arial', sans-serif;
            background-color: #fef8e4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            display: flex;
            justify-content: center; /* Centers the heading in the header */
            align-items: center; /* Vertically centers the items */
            padding: 10px 20px;
            background-color: #fff; /* Adjust the background color if needed */
        }
        header .logo {
            position: absolute; /* Position logo at the left side */
            left: 20px; /* Adjust the left position */
        }
        header .logo img {
            width: 80px; /* Adjust logo width */
            height: 80px; /* Adjust logo height */
            border-radius: 50%; /* Circular logo */
            object-fit: cover; /* Ensures the image fits properly inside the circle */
        }
        header .heading h1 {
            font-size: 1.8rem; /* Adjust font size for the heading */
            color: #333; /* Adjust text color */
            font-weight: 700; /* Bold heading */
            text-align: center; /* Centers the text */
            margin-left: 100px; /* Optional: Adds space for the logo */
            flex-grow: 1; /* Ensures the heading section takes up remaining space */
        }


        h1 {
            text-align: center;
            color: #e74c3c;
            font-size: 2.5em;
            margin-top: 20px;
        }

        /* Container for content */
        /* Container for content */
        .container {
            max-width: 800px;     /* Limit the maximum width */
            width: 100%;          /* Make the container responsive */
            margin: 0 auto;       /* Center the container horizontally */
            padding: 20px;        /* Optional: Add some padding for content spacing */
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
<body>

<header>
        <nav>
            <div class="logo">
                <!-- Logo image -->
                <img src="photos/logo.jpg" alt="Senpai's Recipes Logo">
            </div>
            <div class="heading">
            <h1>Welcome, <?php echo $_SESSION['username']; ?>! Add your recipe:</h1>
            </div>
        </nav>
    </header>
    <div class="container">
    <form action="add_recipe.php" method="POST">
        <label for="title">Recipe Title:</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="ingredients">Ingredients:</label><br>
        <textarea id="ingredients" name="ingredients" rows="8"  required></textarea><br><br>

        <label for="instructions">Instructions:</label><br>
        <textarea id="instructions" name="instructions" rows="8"  required></textarea><br><br>

        <label for="category">Category:</label>
        <select id="category" name="category">
            <option value="Dessert">Dessert</option>
            <option value="Main Course">Main Course</option>
            <option value="Appetizer">Appetizer</option>
        </select><br><br>

        <label for="image_url">Recipe Image URL (Optional):</label>
        <input type="text" id="image_url" name="image_url"><br><br>

        <input type="submit" value="Add Recipe">
    </form>
</div>

</body>
</html>
