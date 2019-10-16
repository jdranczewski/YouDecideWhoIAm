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
$error = "";
if ($_POST["text"] == "") {
    $error = "submission empty";
    header( "refresh:10;url=index.php" );
} else if (strlen($_POST["text"]) > 24) {
    $error = "submission too long (24 characters is the limit)";
    header( "refresh:10;url=index.php" );
} else {
    $sql = "INSERT INTO submissions (text) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_POST["text"]);
    $stmt->execute();
    if ($stmt->error) {
        $error = $stmt->error;
    }
    $stmt->close();
    header( "refresh:5;url=index.php" );
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
        <div id="main">
            Thank you for submitting <b>"<?php echo $_POST["text"]?>"</b>!<br><br>
            <?php
            if ($error != "") {
                echo "<b>Unfortunately, there was an error with your submission: </b>".$error.".<br><br>";
            }
            ?>
            You will be redirected to the home page in a few seconds, where you can make a new submission!<br><br>
            <a href="index.php">Go back!</a>
        </div>
    </body>
</html>

<?php $conn->close(); ?>
