<?
require_once (__DIR__.'/db_conn.php');

$user_id = $_POST['user_id'];
$summ_price = $_POST['product_price'];
$title_product = $_POST['product_name'];
$desc_product =$_POST['product_desc'];
$product_category = $_POST['product_category'];
$status = $_POST['status'];
$bd_id = $_POST['bd_id'];
$random_id_product = $_POST['random_id_product'];

    $sql = "UPDATE `serviceslist` SET `status_mod`='1' WHERE random_id_product='$random_id_product'";
    if (mysqli_query($conn, $sql)) {
      echo "Новая запись добавлена";
    } else {
          echo "Ошибка: " . $sql . "<br>" . mysqli_error($conn);
    }
    $today = date("Y-m-d");
    $service_type = 'Списание';
    $sql_history = "INSERT INTO `historyuser` (`user_id`, `service_title`, `service_price`, `date`, `type_history`, `product_category`) VALUES ('$user_id','$title_product','$summ_price','$today', '$service_type', '$product_category')";
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
      $bonuses_written_off = (int)$row['bonuses_written_off'];
    }
  }
}

$bonuses_written_off += $summ_price;
$new_bonus_count = (int)$user_bonus_count - (int)$summ_price;
echo $new_bonus_count.'<br>';
$sql_update = "UPDATE userlist SET `user_bonus_count`='$new_bonus_count', `bonuses_written_off`='$bonuses_written_off' WHERE id='$record_bd'";
if (mysqli_query($conn, $sql_update)) {
      echo "Данные изменены";
    } else {
          echo "Ошибка: " . $sql_update . "<br>" . mysqli_error($conn);
    }

$sql_update_moder = "UPDATE moderate_service SET status_mod='1' WHERE id='$bd_id'";
if (mysqli_query($conn, $sql_update_moder)) {
      echo "Данные изменены";
    } else {
          echo "Ошибка: " . $sql_update_moder . "<br>" . mysqli_error($conn);
    }

mysqli_close($conn);
