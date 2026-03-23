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

$book_id = isset($_GET['id']) ? $_GET['id'] : 0;

$sql = "SELECT * FROM Books WHERE Book_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if (!$book) {
    header("Location: list-books.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($book['Book_name']); ?> - Book Details</title>
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

        .book-details {
            margin-bottom: 2rem;
        }

        .detail-row {
            display: flex;
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }

        .detail-label {
            font-weight: bold;
            width: 150px;
            color: #2c3e50;
        }

        .detail-value {
            flex: 1;
            color: #7f8c8d;
        }

        .actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
        }

        .btn-back {
            background-color: #95a5a6;
            color: white;
        }

        .btn-delete {
            background-color: #e74c3c;
            color: white;
        }

        .btn-back:hover {
            background-color: #7f8c8d;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        .footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top: 2rem;
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
            
            .detail-row {
                flex-direction: column;
            }
            
            .detail-label {
                width: 100%;
                margin-bottom: 0.5rem;
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
        <h2>Book Details</h2>
        
        <div class="book-details">
            <div class="detail-row">
                <div class="detail-label">Book ID:</div>
                <div class="detail-value"><?php echo $book['Book_id']; ?></div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Book Name:</div>
                <div class="detail-value"><?php echo htmlspecialchars($book['Book_name']); ?></div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Genre:</div>
                <div class="detail-value"><?php echo $book['Genre']; ?></div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Price:</div>
                <div class="detail-value">$<?php echo number_format($book['Price'], 2); ?></div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Release Date:</div>
                <div class="detail-value"><?php echo date('F d, Y', strtotime($book['Date_of_release'])); ?></div>
            </div>
        </div>
        
        <div class="actions">
            <a href="list-books.php" class="btn btn-back">Back to List</a>
            <a href="delete-book.php?id=<?php echo $book['Book_id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this book?')">Delete Book</a>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2024 Book Management System</p>
    </footer>
</body>
</html>

<?php $conn->close(); ?>