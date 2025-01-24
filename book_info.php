<?php
// Database connection
// Database connection
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "books";

try {
    $conn = new mysqli($db_server, $db_user, $db_pass, $db_name);
} catch (mysqli_sql_exception $e) {
    die("Database connection error: " . $e->getMessage());
}

// Initialize error message variable
$error_message = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $bookTitle = $_POST['bookTitleInfo'];
    $category = $_POST['bookTitle'];
    $author = $_POST['bookAuthor'];
    $isbn = $_POST['isbn'];
    $copies = $_POST['count'];

    // Validation checks
    if (is_numeric($bookTitle)) {
        $error_message .= "Book title cannot be a number.<br>";
    }
    if (is_numeric($author)) {
        $error_message .= "Author name cannot be a number.<br>";
    }
    if (!ctype_digit($copies) || (int)$copies <= 0) {
        $error_message .= "Available copies must be a positive whole number greater than 0.<br>";
    }
    if (!ctype_digit($isbn) || (int)$isbn <= 0) {
        $error_message .= "ISBN must be a positive whole number greater than 0.<br>";
    }

    // If validation fails, redirect to error.php with the error message
    if (!empty($error_message)) {
        header("Location: error.php?error=" . urlencode($error_message));
        exit;
    }

    // If validation passes, insert into database
    $stmt = $conn->prepare("INSERT INTO books_db (`Title`, `Category`, `Author`, `ISBN`, `Available`) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $bookTitle, $category, $author, $isbn, $copies);

    if ($stmt->execute()) {
        // Redirect back to index.php to reload the page and display data
        header("Location: index.php");
        exit;
    } else {
        $error_message = "Error adding book: " . htmlspecialchars($stmt->error);
        header("Location: error.php?error=" . urlencode($error_message));
        exit;
    }

    $stmt->close();
}

$conn->close();
?>
