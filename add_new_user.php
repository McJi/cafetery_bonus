<?
require_once (__DIR__.'/crest.php');
require_once (__DIR__.'/db_conn.php');

$user_add = $_POST['user_add'];
$admin_id = $_POST['admin_id'];

  $get_info_admin = CRest::call(
    'user.get',
    [
      'ID' => $admin_id
    ]
  );

    $admin_id_for_user_add = $admin_id;
    $admin_name = $get_info_admin['result'][0]['NAME'] .' '. $get_info_admin['result'][0]['LAST_NAME'];

if($user_add == 'user') {
  $user_add_id = $_POST['user_add_id'];

  foreach($user_add_id as $value){

    $get_info_user = CRest::call(
      'user.get',
      [
        'FILTER' => [
          'ID' => $value,
          'ACTIVE' => '1'
        ]
      ]
    );
    
    $user_name = $get_info_user['result'][0]['NAME'] .' '. $get_info_user['result'][0]['LAST_NAME'];
    $user_gender = $get_info_user['result'][0]['PERSONAL_GENDER'];
    $user_photo = $get_info_user['result'][0]['PERSONAL_PHOTO'];
    $user_phone = $get_info_user['result'][0]['WORK_PHONE'];
    $user_email = $get_info_user['result'][0]['EMAIL'];
    $user_birthday = explode('T', $get_info_user['result'][0]['PERSONAL_BIRTHDAY']);
    $user_depart = $get_info_user['result'][0]['UF_DEPARTMENT'][0];
    $experience = explode('T', $get_info_user['result'][0]['UF_EMPLOYMENT_DATE']);
    $user_bonus_count = 15000;
    $user_date_add = date('Y-m-d');
    

    $sql = "INSERT INTO `userlist` (`user_id`, `user_name`, `user_gender`, `user_photo`, `user_phone`, `user_email`, `user_birthday`, `user_depart`, `experience`, `user_bonus_count`, `user_date_add`, `admin_id_for_user_add`, `admin_name`, `this_admin`) VALUES ('$value','$user_name','$user_gender','$user_photo','$user_phone','$user_email','$user_birthday[0]','$user_depart','$experience[0]','$user_bonus_count','$user_date_add','$admin_id_for_user_add', '$admin_name', 'no')";

    if (mysqli_query($conn, $sql)) {
        echo "Новая запись в историю добавлена";
      } else {
            echo "Ошибка: " . $sql . "<br>" . mysqli_error($conn);
      }
  }
} else if($user_add == 'depart') {
  $user_depart = $_POST['depart_add_id'];

  foreach($user_depart as $id) {
    echo $id;

    $get_info_user = CRest::call(
      'user.get',
      [
        'FILTER' => [
          'ACTIVE' => '1',
          'UF_DEPARTMENT' => $user_depart
        ]
      ]
    );
    foreach($get_info_user['result'] as $user_info) {
      $user_id = $user_info['ID'];
      $user_name = $user_info['NAME'] .' '. $user_info['LAST_NAME'];
      $user_gender = $user_info['PERSONAL_GENDER'];
      $user_photo = $user_info['PERSONAL_PHOTO'];
      $user_phone = $user_info['WORK_PHONE'];
      $user_email = $user_info['EMAIL'];
      $user_birthday = explode('T', $user_info['PERSONAL_BIRTHDAY']);
      $user_depart = $user_info['UF_DEPARTMENT'][0];
      $experience = explode('T', $user_info['UF_EMPLOYMENT_DATE']);
      $user_bonus_count = 15000;
      $user_date_add = date('Y-m-d');
      
      $sql = "INSERT INTO `userlist` (`user_id`, `user_name`, `user_gender`, `user_photo`, `user_phone`, `user_email`, `user_birthday`, `user_depart`, `experience`, `user_bonus_count`, `user_date_add`, `admin_id_for_user_add`, `admin_name`, `this_admin`) VALUES ('$user_id','$user_name','$user_gender','$user_photo','$user_phone','$user_email','$user_birthday[0]','$user_depart','$experience[0]','$user_bonus_count','$user_date_add','$admin_id_for_user_add', '$admin_name', 'no')";

      if (mysqli_query($conn, $sql)) {
          echo "Новая запись в историю добавлена";
        } else {
              echo "Ошибка: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    
  } 
}

