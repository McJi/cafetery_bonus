<?
require_once (__DIR__.'/db_conn.php');

$title_bonus = $_POST['title_bonus'];
$bonus_count = $_POST['bonus'];
$user_id = $_POST['user_id'];

$today = date("Y-m-d");
$service_type = 'Начисление';
$sql_history = "INSERT INTO `historyuser`(`user_id`, `service_title`, `service_price`, `date`, `type_history`) VALUES ('$user_id','$title_bonus','$bonus_count','$today', '$service_type')";
    if (mysqli_query($conn, $sql_history)) {
      echo "Новая запись в историю добавлена";
    } else {
          echo "Ошибка: " . $sql_history . "<br>" . mysqli_error($conn);
    }

$sql_get = 'SELECT * FROM `userlist`';

$result;
$user_bonus_count;
$record_bd;

if($result = $conn->query($sql_get)) {
  foreach($result as $row) {
    $user_id_bd = $row['user_id'];
    if($user_id_bd == $user_id) {
      $user_bonus_count = $row['user_bonus_count'];
      $record_bd = (int)$row['id'];
      $bonuses_accrued = (int)$row['bonuses_accrued'];
    }
  }
}
$bonuses_accrued += $bonus_count;
$new_bonus_count = (int)$user_bonus_count + (int)$bonus_count;
echo $new_bonus_count.'<br>';
$sql_update = "UPDATE userlist SET `user_bonus_count`='$new_bonus_count', `bonuses_accrued`='$bonuses_accrued' WHERE id='$record_bd'";
if (mysqli_query($conn, $sql_update)) {
      echo "Данные изменены";
    } else {
          echo "Ошибка: " . $sql_update . "<br>" . mysqli_error($conn);
    }

mysqli_close($conn);