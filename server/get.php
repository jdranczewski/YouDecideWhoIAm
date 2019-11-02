<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "YouDecideWhoIAm";
// Reguire a token as a GET parameter for verification
$token = "token";
if ($_GET["token"] !== $token) {
    die("Token authentication failed!\n2");
}

// Establish a connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "\n2");
}

// Select a random entry
$sql = "SELECT id, text FROM submissions WHERE displayed = 0 ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);

// echo the text if at least one entry returned
if ($result->num_rows > 0) {
    // Send the text
    while($row = mysqli_fetch_assoc($result)) {
        $text = $row["text"];
        $id  = $row["id"];
        echo $text;
    }
    echo "\n10";

    // Update the 'displayed' flag
    $sql = "UPDATE submissions SET displayed = 1 WHERE id = ".$id;
    $conn->query($sql);

    // Send an update to a Telegram Channel of choice
    // More details here: https://medium.com/@xabaras/sending-a-message-to-a-telegram-channel-the-easy-way-eb0a0b32968
    $telegram_bot_token = "token";
    $channel_name = "@handle";
    $url = "https://api.telegram.org/bot$telegram_bot_token/sendMessage?chat_id=$channel_name&text=$text";
    file_get_contents($url);
} else {
    // Fallback if no submissions left
    echo "Tabula rasa!\nSubmit your idea\n2";
}

// Echo out a delay in minutes before the next response should be requested

$conn->close();
?>
