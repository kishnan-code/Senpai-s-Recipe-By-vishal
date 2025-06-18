<?php
// Database credentials
$servername = "localhost";
$username = "root";  // default XAMPP username
$password = "";  // default XAMPP password
$dbname = "r_db";  // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch the first 6 rows of data from the table
$sql = "SELECT * FROM recipes LIMIT 6";  // Adding LIMIT 6 to fetch the first 6 records
$result = $conn->query($sql);

// Create an array of images (manually assigned)
$image_paths = [
    'g_fc.jpg',  // Image for the first recipe
    'undhiyu.jpg',  // Image for the second recipe
    'bis_bath.jpg', 
    's_makki_roti.jpg',
    'p_bhaji.jpg',
    'phaga.jpeg',
];

// Create an array of recipe detail links (example URLs, these should be dynamically generated or fetched from the database)
$recipe_links = [
    'r1.html',  // Link for the first recipe
    'r2.html',  // Link for the second recipe
    'r3.html', 
    'r4.html',
    'r5.html',
    'r6.html',
];

$image_index = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Details</title>
    <style>
        /* Basic Reset */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
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

        
        /* Center content */
        .container {
            max-width: 1200px;
            margin: 0 auto;  /* Centers the container horizontally */
            padding: 40px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 2.5em;
        }

        .recipe-card {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Automatically adjust the number of columns */
            gap: 40px; /* Space between items in the grid */
            justify-items: center;  /* Centers items in the grid */
            margin-top: 20px;
            padding-left: 5px; /* Adds padding on the left side */
            padding-right: 5px;
        }

        .recipe-card .card {
            background-color: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            padding: 30px;
            transition: transform 0.3s ease;
        }

        .recipe-card .card:hover {
            transform: translateY(-10px);
        }

        /* Image styling */
        .card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 8px; /* Adjust the border radius for rounded corners */
        }

        /* Title and Text */
        .card .title {
            font-size: 1.8em;
            font-weight: bold;
            margin-top: 15px;
            color: #333;
        }

        .card .description {
            margin-top: 10px;
            color: #666;
            font-size: 1.1em;
        }

        /* Category and Cuisine */
        .card .category, .card .cuisine {
            margin-top: 15px;
            font-weight: bold;
            color: #4CAF50;
        }

        /* Video Link */
        .card .video-url {
            margin-top: 10px;
            text-align: center;
        }

        .card .video-url a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #FF5722;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .card .video-url a:hover {
            background-color: #FF3D00;
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
                <h1>Senpai's Main Course Recipes!</h1>
            </div>
        </nav>
    </header>
    <br>
    <div class="container">
        <div class="recipe-card">
            <?php
            // Check if there are results
            if ($result->num_rows > 0) {
                $image_index = 0;  // Initialize the image index

                // Output each row
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="card">
                        <!-- Link to the recipe details page -->
                        <a href="recipes/<?php echo $recipe_links[$image_index]; ?>" class="recipe-link">
                            <!-- Recipe Image -->
                            <img src="photos/<?php echo $image_paths[$image_index]; ?>" alt="Recipe Image">
                        </a>
                        
                        <!-- Recipe Title -->
                        <div class="title"><?php echo htmlspecialchars($row['title']); ?></div>

                        <!-- Recipe Description -->
                        <div class="description"><?php echo htmlspecialchars($row['description']); ?></div>

                        <!-- Recipe Category -->
                        <div class="category">Category: <?php echo htmlspecialchars($row['category']); ?></div>
                        
                        <!-- Recipe Cuisine -->
                        <div class="cuisine">Cuisine: <?php echo htmlspecialchars($row['cuisine']); ?></div>
                    </div>
                    <?php
                    $image_index++;  // Move to the next image in the array
                    if ($image_index >= count($image_paths)) {
                        $image_index = 0;  // If there are more recipes than images, start again
                    }
                }
            } else {
                echo "<p>No data found</p>";
            }
            ?>
        </div>
    </div>

<?php
// Close the connection
$conn->close();
?>
</body>
</html>
