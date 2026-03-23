<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "books";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_name = $_POST['book_name'];
    $genre = $_POST['genre'];
    $price = $_POST['price'];
    $date_of_release = $_POST['date_of_release'];
    
    // Validation
    if (empty($book_name) || empty($genre) || empty($price) || empty($date_of_release)) {
        $error = "All fields are required!";
    } else {
        $sql = "INSERT INTO Books (Book_name, Genre, Price, Date_of_release) 
                VALUES (?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssds", $book_name, $genre, $price, $date_of_release);
        
        if ($stmt->execute()) {
            $message = "Book added successfully! Book ID: " . $conn->insert_id;
        } else {
            $error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .header {
            background-color: #2c3e50;
            color: white;
            padding: 1rem 2rem;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo a {
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }

        .nav-menu a:hover {
            background-color: #3498db;
        }

        .main-content {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #2c3e50;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        .message {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 1rem;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
                gap: 1rem;
            }
            
            .nav-menu {
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }
            
            .main-content {
                margin: 1rem;
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="nav-container">
            <div class="logo">
                <a href="main.php">📚 BookStore</a>
            </div>
            <ul class="nav-menu">
                <li><a href="main.php">Home</a></li>
                <li><a href="add-book.php">Add Book</a></li>
                <li><a href="list-books.php">List Books</a></li>
                <li><a href="search-books.php">Search Books</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-content">
        <h2>Add New Book</h2>
        
        <?php if($message): ?>
            <div class="message success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if($error): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="book_name">Book Name:</label>
                <input type="text" id="book_name" name="book_name" required>
            </div>
            
            <div class="form-group">
                <label for="genre">Genre:</label>
                <select id="genre" name="genre" required>
                    <option value="">Select Genre</option>
                    <option value="Fiction">Fiction</option>
                    <option value="Non-Fiction">Non-Fiction</option>
                    <option value="Science">Science</option>
                    <option value="Technology">Technology</option>
                    <option value="History">History</option>
                    <option value="Biography">Biography</option>
                    <option value="Children">Children</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="price">Price ($):</label>
                <input type="number" step="0.01" id="price" name="price" required>
            </div>
            
            <div class="form-group">
                <label for="date_of_release">Date of Release:</label>
                <input type="date" id="date_of_release" name="date_of_release" required>
            </div>
            
            <button type="submit">Add Book</button>
        </form>
    </main>

    <footer class="footer">
        <p>&copy; 2024 Book Management System</p>
    </footer>
</body>
</html>