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

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Get total records
$total_result = $conn->query("SELECT COUNT(*) as total FROM Books");
$total_rows = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

// Fetch books
$sql = "SELECT * FROM Books ORDER BY Book_id DESC LIMIT $start, $limit";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Books</title>
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
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }

        .books-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        .books-table th,
        .books-table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .books-table th {
            background-color: #3498db;
            color: white;
        }

        .books-table tr:hover {
            background-color: #f5f5f5;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-view {
            background-color: #3498db;
            color: white;
            padding: 0.25rem 0.5rem;
            text-decoration: none;
            border-radius: 3px;
            font-size: 0.875rem;
        }

        .btn-delete {
            background-color: #e74c3c;
            color: white;
            padding: 0.25rem 0.5rem;
            text-decoration: none;
            border-radius: 3px;
            font-size: 0.875rem;
        }

        .btn-view:hover {
            background-color: #2980b9;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .pagination a {
            padding: 0.5rem 1rem;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .pagination a:hover {
            background-color: #2980b9;
        }

        .pagination .active {
            background-color: #2c3e50;
        }

        .no-books {
            text-align: center;
            padding: 2rem;
            color: #7f8c8d;
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
            
            .books-table {
                font-size: 0.875rem;
            }
            
            .action-buttons {
                flex-direction: column;
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
        <h2>Book Collection</h2>
        
        <?php if($result->num_rows > 0): ?>
            <table class="books-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Book Name</th>
                        <th>Genre</th>
                        <th>Price</th>
                        <th>Release Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['Book_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['Book_name']); ?></td>
                        <td><?php echo $row['Genre']; ?></td>
                        <td>$<?php echo number_format($row['Price'], 2); ?></td>
                        <td><?php echo date('M d, Y', strtotime($row['Date_of_release'])); ?></td>
                        <td class="action-buttons">
                            <a href="book-details.php?id=<?php echo $row['Book_id']; ?>" class="btn-view">View</a>
                            <a href="delete-book.php?id=<?php echo $row['Book_id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this book?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            
            <?php if($total_pages > 1): ?>
                <div class="pagination">
                    <?php for($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" class="<?php echo ($page == $i) ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
            
        <?php else: ?>
            <div class="no-books">
                <p>No books found in the database.</p>
                <a href="add-book.php" class="btn-view" style="display: inline-block; margin-top: 1rem;">Add Your First Book</a>
            </div>
        <?php endif; ?>
    </main>

    <footer class="footer">
        <p>&copy; 2024 Book Management System</p>
    </footer>
</body>
</html>

<?php $conn->close(); ?>