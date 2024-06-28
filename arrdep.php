<?php
// Establish database connection
$conn = mysqli_connect("localhost", "root", "", "timetable");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
$Arrivaltime = "";
$Departuretime="";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get search criteria from form
    $Arrivaltime = $_POST["Arrivaltime"];
    $Departuretime=$_POST["Departuretime"];

    // Prepare SQL statement to search for trains
   $sql="SELECT start.trainName, search.TrainNo, search.stationCode, search.Arrivaltime, search.sourceStationName, search.DestinationStationName
FROM start
INNER JOIN search ON start.TrainNo = search.TrainNo
WHERE  search.Arrivaltime >= ? AND search.Departuretime <= ?";

echo "Arrivaltime: " . $Arrivaltime . "<br>";
echo "Departuretime: " . $Departuretime. "<br>";
    
    // Prepare and bind parameters
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $Arrivaltime,$Departuretime);
    
    // Execute SQL statement
    mysqli_stmt_execute($stmt);

    // Get result set
    $result = mysqli_stmt_get_result($stmt);
    // Check if there are any results
    if (mysqli_num_rows($result) > 0) {
        echo "<style>";
        echo ".train-info { border: 1px solid #ccc; padding: 10px; margin: 10px 0; }";
        echo ".train-number { font-weight: bold; color: blue; }";
        echo ".station-code { font-weight: bold; color: green;margin:30px }";
        echo ".arrival-time { font-style: bold; color: orange;margin:30px }";
        echo ".train-name { font-style: bold; color: orange;margin:30px }";
        echo ".source-station { font-style: bold; color: orange;margin:30px }";
        echo ".dest-station { font-style: bold; color: orange;margin:30px }";
        echo "</style>";
        echo "<div class='train-info'>";
        // Output data of the train
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<p><span class='train-number'>Train Number:</span> " . $row["TrainNo"] . " <span class='station-code'>Station Code:</span> " . $row["stationCode"] . " <span class='arrival-time'>Arrival:</span> " . $row["Arrivaltime"] . " <span class='train-name'>Train Name:</span> " . $row["trainName"] . "<span class='source-station'>Source station:</span> " . $row["sourceStationName"] . "<span class='dest-station'>Destination station:</span> " . $row["DestinationStationName"] . "</p>";
        }
        echo "</div>";
    } else {
        echo "No train found for the given train arrival and departure time";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

// Close database connection
mysqli_close($conn);

