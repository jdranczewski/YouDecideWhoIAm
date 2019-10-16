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

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>You decide who I am</title>
        <meta name="description" content="You decide who I am">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="main.css">
    </head>
    <body>
        <div id="main">
            <h1>You decide who I am</h1>
            Hi, my name is <b>Jakub Dranczewski</b> (pronounced <i>Yakoob</i>, but make the <i>oo</i> quite short). For the purposes of this Halloween party you are the one to decide who I came as!
            <br><br>
            Put anything into the text field below and it will be added to a pool of virtual 'costumes'. Every so often, my lanyard badge will select one of these randomly and <b>display it as my ID tag</b>.
            <br><br>
            It can be anything, from famous people, through references I probably won't get, to abstract concepts, adjectives, and other whatnots I could potentially be. <b>Get creative!</b>
            <br><br>
            I'll get a smartwatch notification every time a new submission comes through to my badge. If (for whatever contrived reason) you'd like to be notified too, <a href="https://t.me/YouDecideWhoIAm" target="_blank" title="The YDWIA Telegram channel">you can</a>!
            <h2>TL;DR: Put in a thing you want me to be below. My badge will randomly display it.</h2>
            <form action="submit.php" method="post">
                <input type="text" name="text" maxlength="24" id="text-input" placeholder="Type here...">
                <input type="submit" value="Submit" id="submit">
            </form>
        </div>
        <div id="footer">
            <a href="https://www.facebook.com/jakub.dranczewski" target="_blank">My Facebook</a> •
            <a href="https://github.com/jdranczewski/YouDecideWhoIAm" target="_blank">Code on GitHub</a>
            <div id="past">
                I have so far been:
                <?php
                // Select displayed entries
                $sql = "SELECT text FROM submissions WHERE displayed = 1 ORDER BY updated DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $array = [];
                    // Send the text
                    while($row = mysqli_fetch_assoc($result)) {
                        array_push($array, $row["text"]);
                    }
                    echo implode(", ", $array).".";
                } else {
                    echo "no one.";
                }
                ?>
            </div>
        </div>
    </body>
</html>

<?php $conn->close(); ?>
