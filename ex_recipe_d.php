<?php

$servername = "localhost";
$username = "root";  
$password = ""; 
$dbname = "r_db";  

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM recipes";  
$result = $conn->query($sql);


$image_paths = [
    'g_fc.jpg',  
    'undhiyu.jpg',  
    'bis_bath.jpg', 
    's_makki_roti.jpg',
    'p_bhaji.jpg',
    'phaga.jpeg',
    'assam_khar.webp',
    'gulati_kebab.jpg',
    'vada_pav.jpg',
    'rogan-josh.jpg',
    'kachori.jpg',
    'dhokla.jpg',
    'mysore_park.jpg',
    'payasam.jpg',
    'puran_poli.jpg',
    'mishti_doi.jpg',
    'jalebi.jpg',
    'ghevar.jpg',
];


$recipe_links = [
    'r1.html',  
    'r2.html',  
    'r3.html', 
    'r4.html',
    'r5.html',
    'r6.html',
    'r7.html',
    'r8.html',
    'r9.html',
    'r10.html',
    'r11.html',
    'r12.html',
    'r13.html',
    'r14.html',
    'r15.html',
    'r16.html',
    'r17.html',
    'r18.html',
];

$image_index = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>"Recipe Details"</title>
    <style>
      
        body {
            font-family:'Lobster',cursive;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
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
            max-width: 1200px;
            margin: 0 auto;  
            padding: 40px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 2.5em;
        }

        .recipe-card {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); 
            gap: 40px; 
            justify-items: center;
            margin-top: 20px;
            padding-left: 5px; 
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


        .card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 8px; 
        }


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

        
        .card .category, .card .cuisine {
            margin-top: 15px;
            font-weight: bold;
            color: #4CAF50;
        }


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
            <h1>!Welcome to Senpai's Recipes Collections!</h1>
        </div>
    </nav>
</header>


    <div class="container">
        <div class="recipe-card">
            <?php
            
            if ($result->num_rows > 0) {
                $image_index = 0;  

                
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="card">
                        
                        <a href="recipes/<?php echo $recipe_links[$image_index]; ?>" class="recipe-link">

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
