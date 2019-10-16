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

// Prepare the statement and insert value into the db
if ($_POST["text"] !== "") {
    $sql = "INSERT INTO submissions (text) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_POST["text"]);
    $stmt->execute();
    if ($stmt->error) {
        echo "Error: ".$stmt->error;
    } else {
        header( "refresh:5;url=index.php" );
    }
    $stmt->close();
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>YDWIA - Thanks for your submission!</title>
        <meta name="description" content="YDWIA - Thanks for your submission!">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="main.css">
    </head>
    <body>
        Thank you for submitting <?php echo $_POST["text"]?>!<br><br>
        You will be redirected to the home page in a few seconds, where you can make a new submission!
    </body>
</html>

<?php $conn->close(); ?>
