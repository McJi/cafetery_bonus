<?
require_once (__DIR__.'/db_conn.php');

$random_id_product = $_POST['random_id_product'];

 $sql = "UPDATE `serviceslist` SET `status_mod`='2' WHERE random_id_product='$random_id_product'";
  if (mysqli_query($conn, $sql)) {
    echo "Новая запись добавлена";
  } else {
    echo "Ошибка: " . $sql . "<br>" . mysqli_error($conn);
  }

$sql_update_moder = "UPDATE moderate_service SET status_mod='2' WHERE random_id_product='$random_id_product'";
if (mysqli_query($conn, $sql_update_moder)) {
  echo "Данные изменены";
  } else {
    echo "Ошибка: " . $sql_update_moder . "<br>" . mysqli_error($conn);
  }

mysqli_close($conn);