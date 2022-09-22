<?
require_once (__DIR__.'/crest.php');
require_once (__DIR__.'/db_conn.php');

$sql = "SELECT * FROM `userlist`";


$result;
$arr_users = [];
$arr_users[] = '<table style="width:100%; border-bottom: 1px solid #000; margin-bottom: 20px;">
<thead class="analitics_user_container_title">
  <tr>
    <td>ID
    </td>
    <td>ФИО
    </td>
    <td>Кол-во бонусов
    </td>
    <td>Дата принятия на работу
    </td>
    <td>Дата добавления в бонусную программу
    </td>
    <td>Пользователь добавивший
    </td>
    <td>Бонусов потрачено
    </td>
    <td>Бонусов получено
    </td>
  </tr>
  </thead>
<tbody>';
if($result = $conn->query($sql)) {
  foreach($result as $row) {
    $user_id = $row['user_id'];
    $user_name = $row['user_name'];
    $user_bonus_count = $row['user_bonus_count'];
    $experience = $row['experience'];
    $user_date_add = $row['user_date_add'];
    $admin_name = $row['admin_name'];
    $bonuses_accrued = $row['bonuses_accrued'];
    $bonuses_written_off = $row['bonuses_written_off'];
    $arr_users[] = '<tr class="analitics_user_item">
      <td>'.$user_id.'
      </td>
      <td>'.$user_name.'
      </td>
      <td>'.$user_bonus_count.'
      </td>
      <td>'.$experience.'
      </td>
      <td>'.$user_date_add.'
      </td>
      <td>'.$admin_name.'
      </td>
      <td>'.$bonuses_written_off.'
      </td>
      <td>'.$bonuses_accrued.'
      </td>
    </tr>';
  }
  $arr_users[] ='</tbody></table>';
} 
$str_users = implode($arr_users);
echo $str_users;