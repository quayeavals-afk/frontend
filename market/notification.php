<?php
// notification.php - ничего лишнего, только JSON

$user_id = $_GET['user_id'] ?? 0;


$dbc = mysqli_connect('localhost', 'root', '', 'market');
$query = "SELECT * FROM chats Where ((buyer_id  = $user_id and seller_id != $user_id) or (buyer_id  != $user_id and seller_id = $user_id) )";
$result = mysqli_query($dbc, $query);





if ($result && mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $response[] = $row; // саммив из строк таблицы в массив
        
    }
} 



header('Content-Type: application/json');
echo json_encode($response);
?>