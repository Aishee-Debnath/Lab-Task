<?php
#database connection
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "books";

try {
    #connect to the database
    $conn = new mysqli($db_server, $db_user, $db_pass, $db_name);
} catch (mysqli_sql_exception $e) {
    echo "Database connection error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Information</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="body">
    <!-- ID Section -->
    <div style="text-align: center;">
        <img src="./img/iD.png" alt="Your ID">
    </div>

    <!-- Text Column Section Start -->
    <div class="text-columns">
        <div class="text-box-F1" id="book-container">
            <h2 class="see-more-container">Books Info</h2>
            <div class="book-list">
                <?php
                $sql = "SELECT Title, Category, Author, ISBN, Available FROM books_db ORDER BY book_id ASC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="book-item">';
                        echo '<strong>Title:</strong> ' . htmlspecialchars($row['Title']) . '<br>';
                        echo '<strong>Category:</strong> ' . htmlspecialchars($row['Category']) . '<br>';
                        echo '<strong>Author:</strong> ' . htmlspecialchars($row['Author']) . '<br>';
                        echo '<strong>ISBN:</strong> ' . htmlspecialchars($row['ISBN']) . '<br>';
                        echo '<strong>Available Copies:</strong> ' . htmlspecialchars($row['Available']) . '<br>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Sorry,There is No books available.</p>';
                }
                ?>
            </div>
        </div>

        <!-- Book Update and Delete Section -->

        <div class="update-box">
            <form action="book_actions.php" method="post" id="book-form">
                <label for="bookId">Book ID :</label>
                <input type="number" id="bookId" name="bookId" placeholder="Enter book ID" style="width: 700px;" required>

                <label for="bookTitle">Book Title:</label>
                <input type="text" id="bookTitle" name="bookTitle" placeholder="Enter book title" style="width: 700px;">

                <label for="bookCategory">Book Category:</label>
                <select id="bookCategory" name="bookCategory" style="width: 700px;">
                    <option value="" disabled selected>Select a book Category</option>
                    <option value="Bangla">Bangla</option>
                    <option value="English">English</option>
                    <option value="Math">Math</option>
                    <option value="Science">Science</option>
                    <option value="Information System">Information System</option>
                </select>

                <label for="bookAuthor">Author:</label>
                <input type="text" id="bookAuthor" name="bookAuthor" placeholder="Enter book author" style="width: 700px;">

                <label for="bookISBN">ISBN:</label>
                <input type="number" id="bookISBN" name="bookISBN" placeholder="Enter ISBN" style="width: 700px;">

                <label for="bookCopies">Available Copies:</label>
                <input type="text" id="bookCopies" name="bookCopies" placeholder="Enter number of copies" style="width: 700px;">
                </br>

                <button class="book-update" type="submit" name="action" value="update">Update Book</button>
                <button class="delet-book" type="submit" name="action" value="delete">Delete Book</button>
            </form>
        </div>

        <div class="text-box">


            <div class="token-container">
                <!-- Left Section: Token List -->
                <div class="token-list-container">
                    <h3>Tokens</h3>
                    <ul id="tokenList">
                        <li>20% Discount</li>
                        <li>30% Discount</li>
                        <li>40% Discount</li>
                        <li>50% Discount</li>
                    </ul>
                </div>

                <!-- Right Section: Selected Token Display -->
                <div class="selected-box" id="selectedBox">
                    <h3>You Have Selected </h3>
                    <p id="selectedToken">None</p>
                    <button id="submitToken" style="margin-top: 20px;">Apply Token</button>
                </div>
            </div>
        </div>

        <!-- Image Column Section Start -->
        <div class="image-column">
            <div class="image-box">
                <img src="./img/fstimg.jpg" alt="First Image">
            </div>
            <div class="image-box">
                <img src="./img/secimg.jpg" alt="Second Image">
            </div>
            <div class="image-box">
                <img src="./img/thirdpic.jpg" alt="Third Image">
            </div>
        </div>
        <!-- Image Column Section End -->

        <!-- Form and Description Section Start -->
        <div class="form-section">
            <div class="form-box">
                <form action="process.php" method="post">
                    <label for="studentName">Your Name:</label>
                    <input type="text" id="studentName" name="studentName" placeholder="Enter your name">

                    <label for="studentEmail">Your Email:</label>
                    <input type="email" id="studentEmail" name="studentEmail" placeholder="Enter your email">

                    <label for="studentID">Student ID:</label>
                    <input type="text" id="studentID" name="studentID" placeholder="Enter your student ID">

                    <label for="bookTitle">Book Title:</label>
                    <input type="text" id="bookTitle" name="bookTitle" placeholder="Enter book title">

                    <label for="bookCategory">Book Category:</label>
                    <select id="bookCategory" name="bookCategory">
                        <option value="" disabled selected>Select a book Category</option>
                        <option value="Bangla">Bangla</option>
                        <option value="English">English</option>
                        <option value="Math">Math</option>
                        <option value="Science">Science</option>
                        <option value="Information System">Information System</option>
                    </select>

                    <label for="borrowDate">Borrow Date:</label>
                    <input type="date" id="borrowDate" name="borrowDate">

                    <label for="returnDate">Return Date:</label>
                    <input type="date" id="returnDate" name="returnDate">

                    <label for="token">Token:</label>
                    <input type="text" id="token" name="token" placeholder=" Please Select a token" readonly>

                    <label for="fees">Fees (Optional):</label>
                    <input type="number" id="fees" name="fees" min="0" step="0.01" placeholder="Enter fees">

                    <label for="paid">Paid:</label>
                    <select id="paid" name="paid">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>

                    <input type="submit" value="Place order">
                </form>
            </div>

            <div class="book_info">
                <form action="Add_books_info.php" method="post">
                    <label for="bookTitleInfo">Book Title:</label>
                    <input type="text" id="bookTitleInfo" name="bookTitleInfo" placeholder="Enter book title">

                    <label for="category">Book Category:</label>
                    <select id="bookTitle" name="bookTitle">
                        <option value="" disabled selected>Select a Book Category</option>
                        <option value="Bangla">Bangla</option>
                        <option value="English">English</option>
                        <option value="Math">Math</option>
                        <option value="Science">Science</option>
                        <option value="Information System">Information System</option>
                    </select>

                    <label for="bookAuthor">Author Name:</label>
                    <input type="text" id="bookAuthor" name="bookAuthor" placeholder="Enter author name">

                    <label for="isbn">ISBN Number:</label>
                    <input type="number" id="isbn" name="isbn" placeholder="Enter ISBN">

                    <label for="count">Copies:</label>
                    <input type="text" id="count" name="count" min="1" placeholder="Enter number of copies">

                    <input type="submit" value="Add Book Info">
                </form>
            </div>
        </div>

        <script>
            const tokenList = document.getElementById('tokenList');
            const selectedTokenDisplay = document.getElementById('selectedToken');
            const submitButton = document.getElementById('submitToken');
            const tokenInput = document.getElementById('token');
            let selectedToken = null;
            let isTokenLocked = false;

            // Add click event listener for each token
            tokenList.addEventListener('click', (event) => {
                if (isTokenLocked) {
                    alert("You have already submitted a token. You can't change it.");
                    return;
                }

                if (event.target.tagName === 'LI') {
                    selectedToken = event.target.textContent;
                    selectedTokenDisplay.textContent = selectedToken;
                }
            });

            // Submit button event listener
            submitButton.addEventListener('click', () => {
                if (!selectedToken) {
                    alert("Please select a token first.");
                    return;
                }
                if (isTokenLocked) {
                    alert("Token has already been submitted.");
                    return;
                }

                // Replace token input value
                tokenInput.value = selectedToken;
                tokenInput.readOnly = true; // Make the token input non-editable
                isTokenLocked = true; // Lock the selection after submission
                alert(`Token '${selectedToken}' has been submitted.`);
            });
        </script>

</body>

</html>