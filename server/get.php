<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "YouDecideWhoIAm";

// Establish a connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select a random entry
$sql = "SELECT id, text FROM submissions WHERE displayed = 0 ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);

// echo the text if at least one entry returned
if ($result->num_rows > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo $row["text"];
        $id  = $row["id"];
    }
    $sql = "UPDATE submissions SET displayed = 1 WHERE id = ".$id;
    $conn->query($sql);
} else {
    // Fallback if no submissions left
    echo "Tabula rasa\nSubmit your own ideas!";
}

?>
