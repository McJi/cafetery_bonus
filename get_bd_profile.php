<?
require_once (__DIR__.'/db_conn.php');

$user_id = $_POST['user_id'];

$sql = "SELECT * FROM `userlist`";// WHERE `user_id={$user_id}`";
$result;
$user_profile;
if($result = $conn->query($sql)) {
  foreach($result as $row) {
    $user_id_bd = $row['user_id'];
    if($user_id_bd == $user_id) {
      $gender = $row['user_gender'];
      if($gender == 'M') {
        $gender_icon = '<i class="fa fa-mars" aria-hidden="true"></i>';
        $icon_name_gender =  '<i class="fa fa-male" aria-hidden="true"></i>';
        $gender = 'Мужской';
      } else if($gender == 'F'){
        $gender_icon = '<i class="fa fa-venus" aria-hidden="true"></i>';
        $icon_name_gender =  '<i class="fa fa-female" aria-hidden="true"></i>';
        $gender = 'Женский';
      } else {
        $gender_icon = '<i class="fa fa-genderless" aria-hidden="true"></i>';
        $icon_name_gender =  '<i class="fa fa-user" aria-hidden="true"></i>';
        $gender = 'Не указан';
      }
      $user_birthday = date($row['user_birthday']);
      $var_birth = new DateTime($user_birthday);
      $user_birthday = $var_birth->format('d.m.Y');
      $experience = date($row['experience']);
      $var_exp = new DateTime($experience);
      $experience = $var_exp->format('d.m.Y');
      
      $user_profile = '
      
            <div class="wrapper_profile">
                <div class="profile_right">
                    <div class="image_block">
                      <img src="'.$row['user_photo'].'">
                    </div>
                </div>
              <div class="profile_left">
                  <div class="profile_section">
                      <div class="profile_title">Контактная информация</div>
                      <div class="profile_info">
                          <div class="name_profile">
                              <div class="title_profile">
                              '.$icon_name_gender.'ФИО: 
                              </div>
                              <span>'.$row['user_name'].'</span>
                          </div>     
                          <div class="gender_profile">
                              <div class="title_profile">
                              '.$gender_icon.'Пол: 
                              </div>
                              <span>'.$gender.'</span>
                          </div>     
                          <div class="phone_profile">
                              <div class="title_profile">
                              <i class="fa fa-phone" aria-hidden="true"></i>Телефон:  
                              </div>
                              <span>'.$row['user_phone'].'</span>
                          </div>      
                          <div class="email_profile">
                              <div class="title_profile">
                              <i class="fa fa-envelope-o" aria-hidden="true"></i>E-mail: 
                              </div>
                              <span>'.$row['user_email'].'</span>
                          </div>      
                          <div class="experience_profile">
                              <div class="title_profile">
                              <i class="fa fa-gamepad" aria-hidden="true"></i>Дата принятия на работу: 
                              </div>
                              <span>'.$experience.'</span>
                          </div>
                          <div class="experience_profile">
                            <div class="title_profile">
                            <i class="fa fa-gamepad" aria-hidden="true"></i>Дата рождения: 
                            </div>
                            <span>'.$user_birthday.'</span>
                        </div>      
                          <div class="bonus_profile">
                              <div class="title_profile">
                              <i class="fa fa-money" aria-hidden="true"></i>Кол-во бонусов:
                              </div>
                              <span> '.$row['user_bonus_count'].' бонусов</span>
                          </div>
                          <div class="btn_update_profile">
                              <i class="fa fa-refresh" aria-hidden="true"></i>Обновить данные профиля
                          </div>
                      </div>
                  </div>
              </div>
            </div>
        
        
      ';
    }
  }
} 

echo $user_profile;