<?
require_once (__DIR__.'/db_conn.php');

$user_id = $_POST['user_id'];

$sql_user_get = 'SELECT * FROM `userlist`';
if($result = $conn->query($sql_user_get)) {
  foreach($result as $row) {
    if((int)$row['user_id'] == (int)$user_id) {
      if($row['this_admin'] == 'admin') {
        echo 'ok';
      }
    }
  }
}