<?php
require_once 'config.php';

// Connect to MySQL database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch existing notes from the database
$sql = "SELECT * FROM notes";
$result = $conn->query($sql);

// Display notes
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes App</title>
    <style>
        /* CSS Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-top: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        li {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }
        h2 {
            margin-top: 0;
            color: #666;
        }
        img {
            max-width: 250px; /* Set maximum width for images */
            height: auto; /* Maintain aspect ratio */
            display: block; /* Avoid inline spacing issues */
            margin-top: 10px; /* Add spacing below images */
        }
        a {
            color: #007bff;
            text-decoration: none;
            margin-left: 10px;
        }
        a:hover {
            text-decoration: underline;
        }
        form {
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 0 20px; /* Add padding for better mobile layout */
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        textarea {
            width: calc(100% - 22px); /* Adjust width to accommodate padding and border */
            padding: 5px;
            margin-bottom: 10px;
            box-sizing: border-box; /* Include padding and border in the width calculation */
        }
        input[type="file"] {
            margin-top: 5px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box; /* Include padding and border in the width calculation */
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Notes</h1>
    <ul>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<li>";
            echo "<h2>" . $row["title"] . "</h2>";
            echo "<p>" . $row["content"] . "</p>";
            if ($row["image_url"]) {
                echo "<img src='" . $row["image_url"] . "' alt='Note Image'>";
            }
            echo "<a href='delete.php?id=" . $row["id"] . "'>Delete</a>";
            echo "</li>";
        }
    } else {
        echo "No notes found.";
    }
    ?>
    </ul>

    <h2 style="padding: 0 20px;">Add Note</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label>Title:</label>
        <input type="text" name="title" required><br>
        <label>Content:</label><br>
        <textarea name="content" rows="4" cols="50"></textarea><br>
        <label>Image:</label>
        <input type="file" name="image" accept="image/*"><br>
        <input type="submit" value="Add Note">
    </form>
</body>
</html>

<?php
$conn->close();
?>
