<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management System</title>
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
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .logo a {
            color: white;
            text-decoration: none;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }

        .nav-menu a:hover {
            background-color: #3498db;
            color: white;
        }

        .main-content {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .hero {
            text-align: center;
            padding: 3rem 0;
        }

        .hero h1 {
            color: #2c3e50;
            margin-bottom: 1rem;
            font-size: 2.5rem;
        }

        .hero p {
            color: #7f8c8d;
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .feature-card {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .feature-card h3 {
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: #7f8c8d;
            margin-bottom: 1rem;
        }

        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .footer {
            background-color: #2c3e50;
            color: white;
            padding: 2rem;
            margin-top: 2rem;
            text-align: center;
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
        <div class="hero">
            <h1>Welcome to Book Management System</h1>
            <p>Manage your book collection efficiently</p>
        </div>

        <div class="features">
            <div class="feature-card">
                <h3>📖 Add New Books</h3>
                <p>Easily add new books to your collection with complete details</p>
                <a href="add-book.php" class="btn">Add Book</a>
            </div>

            <div class="feature-card">
                <h3>📚 View All Books</h3>
                <p>Browse through your entire book collection</p>
                <a href="list-books.php" class="btn">View Books</a>
            </div>

            <div class="feature-card">
                <h3>🔍 Search Books</h3>
                <p>Find specific books by name, genre, or author</p>
                <a href="search-books.php" class="btn">Search Books</a>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2024 Book Management System. All rights reserved.</p>
    </footer>
</body>
</html>