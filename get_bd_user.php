<?
require_once (__DIR__.'/db_conn.php');

$user_id = $_POST['user_id'];

$sql = "SELECT * FROM `userlist`";// WHERE `user_id={$user_id}`";
$result;
$user_bonus_count;
if($result = $conn->query($sql)) {
  foreach($result as $row) {
    $user_id_bd = $row['user_id'];
    if($user_id_bd == $user_id) {
      $user_bonus_count = $row['user_bonus_count'];
    }
  }
} 
echo $user_bonus_count;



