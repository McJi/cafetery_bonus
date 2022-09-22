<?
require_once (__DIR__.'/db_conn.php');

$user_id = $_POST['user_id'];
$user_rights = $_POST['user_rights'];

if($user_rights == 'del_admin') {
  $sql_update_profile = "UPDATE `userlist` SET `this_admin`='no' WHERE user_id='$user_id'";
  if (mysqli_query($conn, $sql_update_profile)) {
    echo "Данные изменены";
  } else {
    echo "Ошибка: " . $sql_update_profile . "<br>" . mysqli_error($conn);
  }

  mysqli_close($conn);
} else if($user_rights == 'add_admin') {
  $sql_update_profile = "UPDATE `userlist` SET `this_admin`='admin' WHERE user_id='$user_id'";
  if (mysqli_query($conn, $sql_update_profile)) {
    echo "Данные изменены";
  } else {
    echo "Ошибка: " . $sql_update_profile . "<br>" . mysqli_error($conn);
  }

  mysqli_close($conn);
}