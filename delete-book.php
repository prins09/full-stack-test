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

if ($book_id > 0) {
    $sql = "DELETE FROM Books WHERE Book_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);
    
    if ($stmt->execute()) {
        header("Location: list-books.php?message=deleted");
    } else {
        header("Location: list-books.php?error=delete_failed");
    }
    $stmt->close();
} else {
    header("Location: list-books.php");
}

$conn->close();
exit();
?>