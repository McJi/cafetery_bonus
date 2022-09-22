<?php
require_once (__DIR__.'/crest.php');
require_once (__DIR__.'/db_conn.php');
$sql_section_get = 'SELECT * FROM `administration`';
if($result = $conn->query($sql_section_get)) {
  foreach($result as $row) {
    $section_id_main = $row['section_main_id'];
    $install_date = explode('|', $row['install_date']);
  }
};
$product_section = CRest::call(
  'crm.productsection.list',
  [
    'filter' => [
      'SECTION_ID' => $section_id_main
    ]
  ]
);
$i = 1;
$users_get = CRest::call(
  'user.get',
  [
    'FILTER' => [
      'ACTIVE' => '1'
    ]
  ]
);
$depart_get = CRest::call(
  'department.get',
  [

  ]
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="css/font-awesome.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="css/main.css">
</head>
<body id="app">

<!--header-->

<div class="d-flex header">
  <div class="col-3 logo">
    <span class="logo-text">Кафетерий льгот</span>
  </div>
  <div class="col-2">
    <div class="select-list">
      <a href="#" class="choose-ser" data-menu="main-blok"><i class="fa fa-shopping-basket" aria-hidden="true"></i>Выбрать услугу</a>
    </div>
  </div>
  <div class="col-2">
    <div class="select-list">
      <a href="#" data-menu="my_services"><i class="fa fa-table" aria-hidden="true"></i>Мои запросы</a>
    </div>
  </div>
  <div class="col-2">
    <div class="select-list">
      <a href="#" data-menu="my_profile"><i class="fa fa-user-o" aria-hidden="true"></i> Профиль</a>
    </div>
  </div>
  <div class="col-3 user_name">
    <div class="nick">
      <div class="name" data-userid="">
        <span id="name"></span>
      </div>
      <div class="bonus" data-balance="">
        <i class="fa fa-money" aria-hidden="true"></i>
        <span></span>
      </div>
    </div>
  </div>
</div>
<div class="main-blok d-flex active">
    <div class="left-block">
        <div class="avail-ser">Доступные услуги</div>
        <div class="checkbox-btn-group">
          <?$j = 0;?>
          <?foreach($product_section['result'] as $item):?>
            <?if($item['NAME'] == 'Бонусы'):?>

            <? else:?>
              <div class="section_product" data-id="<? echo $j;?>">
                <div class="section_product_h4">
                  <?echo $item['NAME']?>
                </div>
              </div>
              <div class="section_product_item_content"  data-id="<? echo $j;?>">
                <?
                  $get_product_info = CRest::call(
                    'crm.product.list',
                    [
                      'filter' => [
                        'SECTION_ID' => $item['ID']
                      ],
                      'select' => [
                        'ID',
                        'NAME',
                        'PRICE',
                        'DESCRIPTION'
                      ]
                    ]
                  );
                ?>
                <?foreach($get_product_info['result'] as $product_item):?>
                  <div class="product_item" data-productcount="<? echo $i;?>" data-sectionid="<? echo $j;?>">
                    <div class="product_desc_item">
                       <p class="product_item_title"><?echo $product_item['NAME']?></p>
                      <p class="product_item_price"><?echo $product_item['PRICE']?> бонусов</p>
                    </div>
                    <div class="btn_full_info">Подробнее</div>
                    <div class="btn_product_item btn_product_item" data-modal="none" data-category="<?echo $item['NAME']?>"  data-sectionid="<? echo $j;?>" data-productcount="<? echo $i;?>" data-pos="left" data-productid="<?echo $product_item['ID']?>" data-producttitle="<?echo $product_item['NAME']?>" data-productprice="<?echo $product_item['PRICE']?>" data-productdesc="<?echo $product_item['DESCRIPTION']?>">Добавить</div>
                    <div class="modal_product_item">
                      <h3 class="product_modal_title"><?echo $product_item['NAME']?></h3>
                      <p class="product_modal_desc"><?echo $product_item['DESCRIPTION']?></p>
                      <p class="product_modal_price"><?echo $product_item['PRICE']?></p>
                      <div class="btn_product_item btn_product_item_modal"  data-category="<?echo $item['NAME']?>" data-modal="modal"  data-sectionid="<? echo $j;?>" data-productcount="<? echo $i;?>" data-pos="left" data-productid="<?echo $product_item['ID']?>" data-producttitle="<?echo $product_item['NAME']?>" data-productprice="<?echo $product_item['PRICE']?>" data-productdesc="<?echo $product_item['DESCRIPTION']?>">Добавить</div>
                      <div class="modal_exit_btn">
                        <i class="fa fa-times" aria-hidden="true"></i>
                      </div>
                    </div>
                  </div>
                  <? $i++;?>
                <?endforeach;?>
              </div>
            <? endif;?>
            <? $j++;?>
          <?endforeach;?>
        </div>
    </div>
    <div class="right-block">
        <div class="right-text"><i class="fa fa-check-square-o" aria-hidden="true"></i>Выбранные услуги</div>
            <div class="b-block d-flex">
                
            </div>
            <div class="t-block d-flex">
                <div class="result">Общая сумма</div>
                <div class="all-bonus">
                  <div id="count_bonus" >
                    0
                  </div> <span> бонусов</span> 
                </div>
            </div>
            <div class="err-block d-flex" style="opacity: 0;">
                Недостаточно бонусов для оплаты
            </div>
            <button class="btn-sub">Подтвердить</button>
    </div>    
</div>

<div class="my_services  d-flex">
  <h2>
    Мои услуги
  </h2>
  <div class="services_content" id="services_content">
      
  </div>
</div>


<div class="user_profile  d-flex">
  <div class="user_profile_content">
    
  </div>
  <div class="history">
    <div class="filter_user_history">
      <h4>Фильтры истории</h4>
      <div class="filter">
        <div class="filter_type_select">
          <label for="filter_type">Выберите тип</label>
          <select name="filter_type" id="filter_type">
            <option value="Все">Все</option>
            <option value="Списание">Списание</option>
            <option value="Начисление">Начисление</option>
          </select>
        </div>
        <div class="filter_category_select"> 
          <label for="filter_category">Выберите категорию</label>
          <select name="filter_category" id="filter_category">
            <option value="Все">Все</option>
          <?foreach($product_section['result'] as $item):?>
            <?if($item['NAME'] == 'Бонусы'):?>

            <? else:?>
              <option value="<?echo $item['NAME']?>"><?echo $item['NAME']?></option>
            <? endif;?>
          <?endforeach;?>  
          </select>
        </div>
      </div>
    </div>
    <div class="user_history">
      <h3><i class="fa fa-history" aria-hidden="true"></i> История бонусов</h3>
      <div class="user_history_content">
        
      </div>
    </div>
  </div>
</div> 

<div class="admin_panel  d-flex">
  <h2>
    Админка
  </h2>
  <div class="admin_menu">
    <div class="admin_menu_item active_admin_item" data-adminmenu="moderate_request_bonus">Модерация запросов</div>
    <div class="admin_menu_item" data-adminmenu="add_bonus">Управление бонусами</div>
    <div class="admin_menu_item" data-adminmenu="add_user">Добавить пользователя</div>
    <div class="admin_menu_item" data-adminmenu="analitics">Аналитика</div>
    <div class="admin_menu_item" data-adminmenu="settings">Настройки</div>
  </div>

  <div class="admin_menu_content active_admin" data-adminmenu="moderate_request_bonus">
    <h4 class="moderate">Модерация</h4>
    <div class="moderate_menu">
      <div class="moderate_menu_item active_moderate" data-moderate="current_requests">Текущие</div>
      <div class="moderate_menu_item" data-moderate="accept_requests">Одобренные</div>
      <div class="moderate_menu_item" data-moderate="rejected_requests">Отклоненные</div>
    </div>
    <div class="moderate_content active_moderate_content" data-moderate="current_requests">

    </div>
    <div class="moderate_content" data-moderate="accept_requests">

    </div>
    <div class="moderate_content" data-moderate="rejected_requests">

    </div>
  </div>
  
  <div class="admin_menu_content" data-adminmenu="add_bonus">
    <div class="admin_add_bonus_left">
      <h4 style="width:100%; text-align:center;">Начисление бонусов</h4>
      <div class="add_user_block">
        <span class="user_selected"> </span>
        <span class="user_add_more">
          <a href="#" class="user_add_more_text">Добавить</a>
          <div class="modal_change_user" style="display: none;">
              <div class="modal_block">
                <?php 
                  $sql_user_get = 'SELECT * FROM `userlist`';
                ?>
                <? if($result = $conn->query($sql_user_get)):?>
                  <? foreach($result as $row):?>
                    <div class="user_change_item">
                      <? if(!empty($row['user_photo']) == true):?>
                        <div class="modal_img" style="background-image:url(<?=$row['user_photo']?>);"></div>
                      <? else:?>
                        <div class="modal_img" style="background-image:url(img/icon.svg);"></div>
                      <? endif;?>
                      <p data-id="<? echo $row['user_id']?>"><? echo $row['user_name']?></p>
                      <div class="btn_change_user">Выбрать</div>
                    </div>
                  <? endforeach;?>
                <? endif;?>
                <div class="btn_close_popup"></div>
              </div>
              
          </div>
        </span>
      </div>
      <label for="title_bonus">Укажите причину начисления</label>
      <input type="text" id="title_bonus" class="bonus_input">
      <label for="bonus">Укажите кол-во бонусов</label>
      <input type="text" id="bonus" class="bonus_input">
      <div class="btn_add_bonus">Добавить бонусы</div>
    </div>
    <div class="admin_del_bonus_right">
      <h4 style="width:100%; text-align:center;">Списание бонусов</h4>
      <div class="btn_add_user delete">Выбрать сотрудника</div>
      <label for="title_bonus_del">Укажите причину списания</label>
      <input type="text" id="title_bonus_del" class="bonus_input">
      <label for="bonus">Укажите кол-во бонусов</label>
      <input type="text" id="bonus_del" class="bonus_input">
      <div class="btn_del_bonus">Списать бонусы</div>
    </div>
  </div>

  <div class="admin_menu_content" data-adminmenu="add_user">
    <h4 class="h4_add_user">Добавление пользователей</h4>
    <div class="add_user_left">
      <select name="users_add" id="users_add" multiple>
        <? foreach($users_get['result'] as $user):?>
          <option value="<? echo $user['ID']?>"><? echo $user['NAME'].' '.$user['LAST_NAME']?></option>
        <? endforeach;?>
      </select>
      <div class="btn_add_users" data-add="user">Добавить</div>
    </div>
    <div class="add_depart_right">
      <select name="depart_add" id="depart_add" multiple>
        <?foreach($depart_get['result'] as $depart):?>
          <option value="<?echo $depart['ID']?>"><?echo $depart['NAME']?></option>
        <?endforeach;?>
      </select>
      <div class="btn_add_users_depart" data-add="depart">Добавить</div>
    </div>
  </div>
  <div class="admin_menu_content" data-adminmenu="analitics">
    <div class="analitics_menu">
      <div class="analitic_item active_analitic_item" data-analitics="get_info_for_user">Информация по пользователям</div>
      <div class="analitic_item" data-analitics="report_bonus">Отчет по бонусам</div>
      <div class="analitic_item" data-analitics="get_info_bonus">Отчет по использованию бонусов</div>
    </div>

    <div class="analitics_item_container active_analitic_item_container" data-analitics="get_info_for_user">
      <h4 class="info_user_h4">Информация по пользователям</h4>
      <div class="content_isers_info"></div>
    </div>

    <div class="analitics_item_container" data-analitics="report_bonus">
      <div id="chartContainer" style="height: 370px; width: 100%;"></div>
      <table class="report_bonus" style="
    width: 100%;">
        <thead style="border-bottom: 1px solid #000;text-align: center;">
          <tr>
            <td>Категория</td>
            <td>Потрачено бонусов</td>
            <td>Процент от общей суммы</td>
          </tr>
        </thead>
        <tbody class="table_category">

        </tbody>
      </table>
    </div>

    <div class="analitics_item_container" data-analitics="get_info_bonus">
      <h4 class="info_user_h4">Отчет по использованию бонусов</h4>
      <select name="users_get" id="users_get">
        <? foreach($users_get['result'] as $user):?>
          <option value="<? echo $user['ID']?>"><? echo $user['NAME'].' '.$user['LAST_NAME']?></option>
        <? endforeach;?>
      </select>

      <select name="get_period" id="get_period" class="get_period">
        <option value="year" selected>Выбрать формат</option>
        <option value="year">За год</option>
        <option value="month">За месяц</option>
        <!--<option value="period">Период</option>-->
      </select>
      
      <select name="get_year" id="get_year" class="get_year hidden">
        <?
          $today = explode('|', date('m|Y'));
          $date_year = (int)$today[1] - (int)$install_date[1];
          if($date_year == 0) {
            echo '<option value="'.(int)$install_date[1].'">'.(int)$install_date[1].'</option>';
          } else {
            for($y = (int)$today[1]; $y >= (int)$install_date[1];) {
              
                echo '<option value="'.$y.'">'.$y.'</option>';
              
              $y--;
            }
          }
        ?>
      </select>      
      <input class="date_year_today" type="hidden" value="<? echo (int)$today[1];?>">
      
      <select name="get_month" id="get_month" class="get_month hidden">
        <?
          $today = explode('|', date('m|Y'));
          $date_year = (int)$today[1] - (int)$install_date[1];
          $date_month = (int)$today[0] - (int)$install_date[0];
          
            for($m = (int)$install_date[0]; $m <= (int)$today[0]; $m++) {
              $selected = ' ';
              if($m == 01) {
                $name_m = 'Январь';
                $selected = 'selected';
              } else if($m == 02) {
                $name_m = 'Февраль';
              } else if($m == 03) {
                $name_m = 'Март';
              } else if($m == 04) {
                $name_m = 'Апрель';
              } else if($m == 05) {
                $name_m = 'Май';
              } else if($m == 06) {
                $name_m = 'Июнь';
              } else if($m == 07) {
                $name_m = 'Июль';
              } else if((string)$m == '08') {
                $name_m = 'Август';
              } else if((string)$m == '09') {
                $name_m = 'Сентябрь';
              } else if($m == 10) {
                $name_m = 'Октябрь';
              } else if($m == 11) {
                $name_m = 'Ноябрь';
              } else if($m == 12) {
                $name_m = 'Декабрь';
              }

              echo '<option value="'.$m.'">'.$name_m.'</option>';
            }
        ?>
      </select>
      <input class="date_month_today" type="hidden" value="<? echo  (int)$today[0];?>">
      <input class="date_month" type="hidden" value="<? echo (int)$install_date[0];?>">
      <div class="btn_get_info_report hidden">
        Получить
      </div>

      <div id="chartContainerUser" style="height: 370px; width: 100%;"></div>

      <div class="report_user_table" style="width: 100%;">
        
      </div>    
    </div>
  </div>
  
  <div class="admin_menu_content" data-adminmenu="settings">
    <h4 style="width: 100%;text-align: center;">Настройки</h4>
    <div class="setting_menu">
      <div class="setting_item_menu active" data-setting="setting_user">Настройка пользователей</div>
      <div class="setting_item_menu" data-setting="setting_services">Управление услугами</div>
      <div class="setting_item_menu" data-setting="setting_2">Настройка 2</div>
      <div class="setting_item_menu" data-setting="setting_3">Настройка 3</div>
    </div>

    <div class="setting_item_content active" data-setting="setting_user" style="width: 100%;">
      <h5 style="width: 100%;text-align: center;margin: 20px auto;">Настройка пользователей</h5>
      <?php 
        $sql_section_get = 'SELECT * FROM `userlist`';
      ?>
      <? if($result = $conn->query($sql_section_get)):?>
        <? foreach($result as $row):?>
          <div class="user_item">
            <div class="user_name"><? echo $row['user_name']?></div>
            <div class="user_role" data-user="<? echo $row['user_id']?>">
              <? if($row['this_admin'] == 'admin'):?>
                Администратор
            </div>
            <div class="btn_user_setting" data-admin="del_admin" data-user="<? echo $row['user_id']?>">Забрать права</div>
              <? elseif($row['this_admin'] == 'no'):?>
                Пользователь
            </div>
            <div class="btn_user_setting" data-admin="add_admin" data-user="<? echo $row['user_id']?>">Сделать администратором</div>
              <? endif;?>
          </div>
        <? endforeach;?>
      <? endif;?>
    </div>
    <div class="setting_item_content" data-setting="setting_services" style="width: 100%;">
      <h5 style="width: 100%;text-align: center;margin: 20px auto;">Управление услугами</h5>
      <div class="settings_services_menu">
        <div class="settings_services_menu_item active" data-servicesitem="add_services">Добавление услуги</div>
        <div class="settings_services_menu_item" data-servicesitem="edit_services">Редактирование услуг</div>
        <div class="settings_services_menu_item" data-servicesitem="edit_section">Управление разделами</div>
      </div>

      <div class="settings_services_content active" data-servicesitem="add_services">

      </div>
      <div class="settings_services_content" data-servicesitem="edit_services">
        <ul id="accordeon_services_item">
          <?
            $get_product_info_service = CRest::call(
              'crm.product.list',
              [
                'select' => [
                  'ID',
                  'NAME',
                  'PRICE',
                  'DESCRIPTION',
                  'SECTION_ID'
                ]
              ]
            );
            $k = 0;
          ?>
          <?foreach($get_product_info_service['result'] as $product_item):?>
            <? if($k < 1):?>
              <li class="services_main_block" data-count="<? echo $k;?>">
                <p class="head_services_item" data-count="<? echo $k;?>"><?echo $product_item['NAME']?></p>
                <div class="hidden_services_item active_services_item">
                  <ul id="accordeon_services_title">
                    <li >
                      <p class="head_services_title">Изменить название</p>
                      <div class="hidden_services_title">
                        <label for="input_services_title">Введите значение</label>
                        <input type="text" data-count="<? echo $k;?>" id="input_services_title" class="input_services_title" value="<?echo $product_item['NAME']?>">
                      </div>
                    </li>
                  </ul>
                  <ul id="accordeon_services_price">
                    <li>
                      <p class="head_services_price">Изменить стоимость</p>
                      <div class="hidden_services_price">
                        <label for="input_services_price">Введите значение</label>
                        <input type="text" id="input_services_price" class="input_services_price" data-count="<? echo $k;?>" value="<?echo $product_item['PRICE']?>">
                      </div>
                    </li>
                  </ul>
                  <ul id="accordeon_services_description">
                    <li>
                      <p class="head_services_description">Изменить описание</p>
                      <div class="hidden_services_description">
                        <label for="input_services_description">Введите значение</label>
                        <textarea type="text" row="15" cols="105" id="input_services_description" data-count="<? echo $k;?>" class="input_services_description"><?echo $product_item['DESCRIPTION']?></textarea>
                      </div>
                    </li>
                  </ul>
                  <div class="accordeon_services_select">
                    <label for="change_section_services">Выберите раздел</label>
                    <select name="change_section_services" data-count="<? echo $k;?>" id="change_section_services" data-section="<? echo $product_item['SECTION_ID']; ?>">
                      <?
                        $product_section_services = CRest::call(
                          'crm.productsection.list',
                          [
                            'filter' => [
                              'SECTION_ID' => $section_id_main
                            ]
                          ]
                        );
                      ?>
                      <?foreach($product_section['result'] as $item):?>
                        
                        <?if($item['NAME'] == 'Бонусы'):?>

                        <? else:?>
                          <? if((int)$product_item['SECTION_ID'] == (int)$item['ID']):?>
                            <option value="<? echo $item['ID'];?>" selected><? echo $item['NAME'];?></option>
                          <? else:?>
                            <option value="<? echo $item['ID'];?>"><? echo $item['NAME'];?></option>
                          <? endif;?>
                        <? endif;?>
                      <? endforeach;?>                
                    </select>
                  </div>
                  
                  <div class="btn_save_edit_services" data-product="<? echo $product_item['ID'];?>" data-count="<? echo $k;?>">Сохранить</div>
                </div>
              </li>
              <? $k++;?>
            <? else: ?>
              <li class="services_main_block" data-count="<? echo $k;?>">
                <p class="head_services_item" data-count="<? echo $k;?>"><?echo $product_item['NAME']?></p>
                <div class="hidden_services_item">
                  <ul id="accordeon_services_title">
                    <li >
                      <p class="head_services_title">Изменить название</p>
                      <div class="hidden_services_title">
                        <label for="input_services_title">Введите значение</label>
                        <input type="text" data-count="<? echo $k;?>" id="input_services_title" class="input_services_title" value="<?echo $product_item['NAME']?>">
                      </div>
                    </li>
                  </ul>
                  <ul id="accordeon_services_price">
                    <li>
                      <p class="head_services_price">Изменить стоимость</p>
                      <div class="hidden_services_price">
                        <label for="input_services_price">Введите значение</label>
                        <input type="text" data-count="<? echo $k;?>" id="input_services_price" class="input_services_price" value="<?echo $product_item['PRICE']?>">
                      </div>
                    </li>
                  </ul>
                  <ul id="accordeon_services_description">
                    <li>
                      <p class="head_services_description">Изменить описание</p>
                      <div class="hidden_services_description">
                        <label for="input_services_description">Введите значение</label>
                        <textarea type="text" data-count="<? echo $k;?>" row="15" cols="105" id="input_services_description" class="input_services_description"><?echo $product_item['DESCRIPTION']?></textarea>
                      </div>
                    </li>
                  </ul>
                  <div class="accordeon_services_select">
                    <label for="change_section_services">Выберите раздел</label>
                    <select name="change_section_services" data-count="<? echo $k;?>" id="change_section_services">
                      <?
                        $product_section_services = CRest::call(
                          'crm.productsection.list',
                          [
                            'filter' => [
                              'SECTION_ID' => $section_id_main
                            ]
                          ]
                        );
                      ?>

                      <?foreach($product_section['result'] as $item):?>
                        <?if($item['NAME'] == 'Бонусы'):?>

                        <? else:?>
                          <? if((int)$product_item['SECTION_ID'] == (int)$item['ID']):?>
                            <option value="<? echo $item['ID'];?>" selected><? echo $item['NAME'];?></option>
                          <? else:?>
                            <option value="<? echo $item['ID'];?>"><? echo $item['NAME'];?></option>
                          <? endif;?>
                        <? endif;?>
                      <? endforeach;?>                
                    </select>
                  </div>

                  <div class="btn_save_edit_services" data-product="<? echo $product_item['ID'];?>" data-count="<? echo $k;?>">Сохранить</div>
                </div>
              </li>
              <? $k++;?>
            <? endif;?>
          
          <? endforeach;?>
        </ul>
      </div>

      <div class="settings_services_content" data-servicesitem="edit_section">
      
    </div>
    <div class="setting_item_content" data-setting="setting_2" style="width: 100%;">
      <h5 style="width: 100%;text-align: center;margin: 20px auto;">Настройка 2</h5>
    </div>
    <div class="setting_item_content" data-setting="setting_3" style="width: 100%;">
      <h5 style="width: 100%;text-align: center;margin: 20px auto;">Настройка 3</h5>
    </div>
  </div>
</div>

  <div class="row spinner hidden">
    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12" style="text-align: center">
      <i class="fa fa-spinner fa-spin fa-5x fa-fw"></i>
    </div>
  </div>
  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="//api.bitrix24.com/api/v1/"></script>
  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  <script>
    $(document).ready(function () {
      $('.section_product_item_content').eq(0).addClass('section_active');
      $('.section_product').eq(0).addClass('active');
          $.post( "https://<? echo $_REQUEST['DOMAIN']?>/rest/user.current.xml?auth=<? echo $_REQUEST['AUTH_ID']?>", {})
            .done(function( result ) {
              console.log(result);
              try {
                var name = result.getElementsByTagName("NAME")[0].childNodes[0].nodeValue;
              } catch(err) {
                var name = '';
              }
              try {
                var last_name = result.getElementsByTagName("LAST_NAME")[0].childNodes[0].nodeValue;
              } catch(err) {
                var last_name = ' ';
              }
              try {
                var user_id = result.getElementsByTagName("ID")[0].childNodes[0].nodeValue;
              } catch(err) {
                var user_id = 'none';
              }
              if(user_id != 'none') {
                $.post( "https://app.cypherr.ru/benefits_cafeteria/check_admin.php", {user_id: user_id})
                  .done(function( result ) {
                    console.log(result);
                    if(result == 'ok') {
                      console.log('Администратор');
                      $('.header>.col-3.user_name').remove();
                      $('.header').append('<div class="col-2"><div class="select-list"><a href="#" data-menu="admin_panel"><i class="fa fa-bomb" aria-hidden="true"></i> Админка</a></div></div>');
                      $('.header').append('<div class="col-2"><div class="nick"><div class="name" data-userid=""><span id="name"></span></div><div class="bonus" data-balance=""><i class="fa fa-money" aria-hidden="true"></i> <span> </span></div></div></div>');
                      $('.header>.col-3').removeClass('col-3');
                      $('.header>.logo').addClass('col-2');
                    }
                    var user_name = name + ' ' + last_name;
                    console.log(user_name);
                    $('.name>span').append(user_name);
                    $('.name').attr('data-userid', user_id);
                    $.post( "https://app.cypherr.ru/benefits_cafeteria/get_bd_user.php", {user_id : user_id})
                      .done(function( data ) {
                        $('.bonus>span').append(data + ' бонусов');
                        $('.bonus').attr('data-balance', data);
                        var type_bonus = 'Все';
                        var filter_category = 'Все';
                        $.post( "https://app.cypherr.ru/benefits_cafeteria/get_history.php", {user_id : user_id, type_bonus: type_bonus, filter_category: filter_category})
                          .done(function( data ) {
                            $('.user_history_content').append(data);
                          }); 
                      }); 
                  });
              }             
            });
        });
  </script>
  <script src="js/common.js"></script>
</body>
</html>