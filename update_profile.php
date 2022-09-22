<?
require_once (__DIR__.'/crest.php');
require_once (__DIR__.'/db_conn.php');

$user_id = $_POST['user_id'];


$sql_get = 'SELECT * FROM `userlist`';
$record_bd;

if($result = $conn->query($sql_get)) {
  foreach($result as $row) {
    $user_id_bd = $row['user_id'];
    if($user_id_bd == $user_id) {
      $user_name_bd = $row['user_name'];
      $user_gender_bd = $row['user_gender'];
      $user_photo_bd = $row['user_photo'];
      $user_phone_bd = $row['user_phone'];
      $user_email_bd = $row['user_email'];
      $record_bd = (int)$row['id'];
      $user_get = CRest::call(
        'user.get',
        [
          'ID' => $user_id
        ]
      );

      echo '<pre>'; print_r($user_get); echo '</pre>';

      if((!empty($user_get['result'][0]['NAME']) == true) || !empty($user_get['result'][0]['SECOND_NAME']) == true || !empty($user_get['result'][0]['LAST_NAME']) == true) {
        $user_name = $user_get['result'][0]['LAST_NAME'] . ' ' . $user_get['result'][0]['NAME'] . ' ' . $user_get['result'][0]['SECOND_NAME'];
      } else {
        $user_name = $user_name_bd;
      }


      if(!empty($user_get['result'][0]['PERSONAL_GENDER']) == true) {
        $user_gender = $user_get['result'][0]['PERSONAL_GENDER'];
      } else {
        $user_gender = $user_gender_bd;
      }

      if(!empty($user_get['result'][0]['PERSONAL_PHOTO']) == true) {
        $user_photo = $user_get['result'][0]['PERSONAL_PHOTO'];
      } else {
        $user_photo = $user_photo_bd;
      }

      if(!empty($user_get['result'][0]['PERSONAL_PHONE']) == true) {
        $user_phone = $user_get['result'][0]['PERSONAL_PHONE'];
      } else {
        $user_phone = $user_phone_bd;
      }

      if(!empty($user_get['result'][0]['EMAIL']) == true) {
        $user_email = $user_get['result'][0]['EMAIL'];
      } else {
        $user_email = $user_email_bd;
      }

      $user_birthday = explode('T', $user_get['result'][0]['PERSONAL_BIRTHDAY']);
      echo $user_birthday.'|';
      $user_depart = $user_get['result'][0]['UF_DEPARTMENT'][0];
      echo $user_depart.'|';
      $experience = explode('T', $user_get['result'][0]['UF_EMPLOYMENT_DATE']);
      echo $experience.'|';


      $sql_update_profile = "UPDATE `userlist` SET `user_id`='$user_id',`user_name`='$user_name',`user_gender`='$user_gender',`user_photo`='$user_photo',`user_phone`='$user_phone',`user_email`='$user_email', `user_birthday`='$user_birthday[0]',`user_depart`='$user_depart',`experience`='$experience[0]' WHERE id='$record_bd'";

      if (mysqli_query($conn, $sql_update_profile)) {
            echo "Данные изменены";
            echo $user_get['result']['PERSONAL_GENDER'];
          } else {
                echo "Ошибка: " . $sql_update_profile . "<br>" . mysqli_error($conn);
          }

      mysqli_close($conn);
    }
  }
}

