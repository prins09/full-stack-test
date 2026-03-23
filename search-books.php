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

$search_results = null;
$search_term = "";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $search_term = $_GET['search'];
    $search_term = "%" . $search_term . "%";
    
    $sql = "SELECT * FROM Books WHERE Book_name LIKE ? OR Genre LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $search_term, $search_term);
    $stmt->execute();
    $search_results = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books</title>
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

        .search-form {
            margin-bottom: 2rem;
        }

        .search-box {
            display: flex;
            gap: 1rem;
        }

        .search-input {
            flex: 1;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .search-btn {
            padding: 0.75rem 1.5rem;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .search-btn:hover {
            background-color: #2980b9;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .results-table th,
        .results-table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .results-table th {
            background-color: #3498db;
            color: white;
        }

        .results-table tr:hover {
            background-color: #f5f5f5;
        }

        .btn-view {
            background-color: #3498db;
            color: white;
            padding: 0.25rem 0.5rem;
            text-decoration: none;
            border-radius: 3px;
            font-size: 0.875rem;
        }

        .btn-view:hover {
            background-color: #2980b9;
        }

        .no-results {
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
            
            .search-box {
                flex-direction: column;
            }
            
            .results-table {
                font-size: 0.875rem;
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
        <h2>Search Books</h2>
        
        <div class="search-form">
            <form method="GET" action="">
                <div class="search-box">
                    <input type="text" name="search" class="search-input" placeholder="Search by book name or genre..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                    <button type="submit" class="search-btn">Search</button>
                </div>
            </form>
        </div>
        
        <?php if ($search_results !== null): ?>
            <h3>Search Results for "<?php echo htmlspecialchars($_GET['search']); ?>"</h3>
            
            <?php if ($search_results->num_rows > 0): ?>
                <table class="results-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Book Name</th>
                            <th>Genre</th>
                            <th>Price</th>
                            <th>Release Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $search_results->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['Book_id']; ?></td>
                            <td><?php echo htmlspecialchars($row['Book_name']); ?></td>
                            <td><?php echo $row['Genre']; ?></td>
                            <td>$<?php echo number_format($row['Price'], 2); ?></td>
                            <td><?php echo date('M d, Y', strtotime($row['Date_of_release'])); ?></td>
                            <td>
                                <a href="book-details.php?id=<?php echo $row['Book_id']; ?>" class="btn-view">View Details</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-results">
                    <p>No books found matching your search criteria.</p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <footer class="footer">
        <p>&copy; 2024 Book Management System</p>
    </footer>
</body>
</html>

<?php $conn->close(); ?>