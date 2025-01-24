<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .error-container {
            text-align: center;
            padding: 20px;
            border: 1px solid #ff4d4d;
            background-color: #ffe6e6;
            border-radius: 8px;
            max-width: 500px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .error-container h2 {
            color: #ff4d4d;
            margin: 0 0 10px;
        }

        .error-container p {
            color: #333;
            margin: 0 0 20px;
            font-size: 1.1em;
        }

        .error-container a {
            color: #ffffff;
            background-color: #ff4d4d;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1em;
        }

        .error-container a:hover {
            background-color: #e60000;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h2>Error</h2>
        <p><?php echo htmlspecialchars($_GET['error'] ?? "An unknown error occurred."); ?></p>
        <a href="index.php">Go Back</a>
    </div>
</body>
</html>
