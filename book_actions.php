<?php
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

// Retrieve form data
$bookId = isset($_POST['bookId']) ? intval($_POST['bookId']) : null;
$action = isset($_POST['action']) ? $_POST['action'] : null;

// Validate Book ID
if (!$bookId || $bookId <= 0) {
    header("Location: error.php?error=" . urlencode("Invalid Book ID. It must be a positive number."));
    exit;
}

// Check if Book ID exists
$sql_check = "SELECT * FROM books_db WHERE book_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("i", $bookId);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows === 0) {
    $stmt_check->close();
    header("Location: error.php?error=" . urlencode("Book ID not found in the database."));
    exit;
}

$stmt_check->close();

// Process action
if ($action === "update") {
    // Retrieve update form fields
    $bookTitle = trim($_POST['bookTitle'] ?? '');
    $bookCategory = trim($_POST['bookCategory'] ?? '');
    $bookAuthor = trim($_POST['bookAuthor'] ?? '');
    $bookISBN = intval($_POST['bookISBN'] ?? 0);
    $bookCopies = intval($_POST['bookCopies'] ?? 0);

    // Validate update inputs
    if (!$bookTitle || !$bookCategory || !$bookAuthor || $bookISBN <= 0 || $bookCopies < 0) {
        header("Location: error.php?error=" . urlencode("All fields must be valid. Check Title, Category, Author, ISBN, and Copies."));
        exit;
    }

    // Update query
    $sql_update = "UPDATE books_db 
                   SET Title = ?, Category = ?, Author = ?, ISBN = ?, Available = ? 
                   WHERE book_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssiii", $bookTitle, $bookCategory, $bookAuthor, $bookISBN, $bookCopies, $bookId);

    if ($stmt_update->execute()) {
        header("Location: index.php?message=" . urlencode("Book updated successfully."));
    } else {
        header("Location: error.php?error=" . urlencode("Error updating book: " . $stmt_update->error));
    }

    $stmt_update->close();
} elseif ($action === "delete") {
    // Delete query
    $sql_delete = "DELETE FROM books_db WHERE book_id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $bookId);

    if ($stmt_delete->execute()) {
        header("Location: index.php?message=" . urlencode("Book deleted successfully."));
    } else {
        header("Location: error.php?error=" . urlencode("Error deleting book: " . $stmt_delete->error));
    }

    $stmt_delete->close();
} else {
    header("Location: error.php?error=" . urlencode("Invalid action."));
}

$conn->close();
?>
