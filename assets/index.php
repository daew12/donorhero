<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Submission</title>
</head>
<body>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate the email address
    if (isset($_POST["email_address"]) && filter_var($_POST["email_address"], FILTER_VALIDATE_EMAIL)) {
        // Sanitize the email address to prevent SQL injection
        $email = htmlspecialchars($_POST["email_address"]);
        
        // Database connection details
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "donorhero_db";

        // Create a connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute the SQL query to insert the email into the database
        $stmt = $conn->prepare("INSERT INTO response_back (email) VALUES (?)");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        // Check if the email is inserted successfully
        if ($stmt->affected_rows > 0) {
            // Email added successfully, show the popup message
            echo '
            <script>
                showPopup("Email added successfully!");
            </script>
            ';
        } else {
            // Unable to add email, show the popup message
            echo '
            <script>
                showPopup("Error: Unable to add email. Please try again later.");
            </script>
            ';
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        // Invalid email address, show the popup message
        echo '
        <script>
            showPopup("Error: Invalid email address. Please enter a valid email.");
        </script>
        ';
    }
}
?>

<form method="post" action="index.php">
    <label for="email_address">Email:</label>
    <input type="email" id="email_address" name="email_address" required>
    <button type="submit">Submit</button>
</form>

<!--BACK TO TOP-->
<a href="#top" class="back-top-btn" aria-label="back to top" data-back-top-btn>
    <ion-icon name="caret-up" aria-hidden="true"></ion-icon>
</a>

<!--custom js link-->
<script src="./assets/js/script.js" defer></script>
<!--ionicon link-->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<script>
    function showPopup(message) {
        alert(message); // You can enhance this to show a styled popup
    }
</script>
</body>
</html>
