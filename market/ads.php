<?php
//получчение данных о пользователе из базы данных
session_start();

header('Content-Type: application/json');

$dbc = mysqli_connect('localhost', 'root', '', 'market');
$query = "SELECT * FROM market ORDER BY date DESC";
$result = mysqli_query($dbc, $query);

$ads = [];
while ($row = mysqli_fetch_assoc($result)) {    
    $ads[] = $row;
}

echo json_encode($ads);
mysqli_close($dbc);
?>



