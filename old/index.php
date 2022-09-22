<?php
require_once (__DIR__.'/crest.php');


$get_product_info = CRest::call(
  'crm.product.list',
  [
    'select' => [
      'ID',
      'NAME',
      'PRICE',
      'DESCRIPTION'
    ]
  ]
);
$i = 1;
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
<?php echo '<pre>'; print_r($_REQUEST); echo '</pre>'; ?>
<!--header-->


<div class="d-flex header">
  <div class="col-3 logo">
    <span class="logo-text">Барахолка</span>
  </div>
  <div class="col-2">
    <div class="select-list">
      <a href="#" class="choose-ser" data-menu="main-blok"><i class="fa fa-shopping-basket" aria-hidden="true"></i>Выбрать услугу</a>
    </div>
  </div>
  <div class="col-2">
    <div class="select-list">
      <a href="#" data-menu="my_services"><i class="fa fa-table" aria-hidden="true"></i>Мои услуги</a>
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
          <?foreach($get_product_info['result'] as $item):?>
          <label>
            <input type="checkbox" class="product_item_check" data-productcount = "<? echo $i;?>" data-title="<?echo $item['NAME'] ?>" data-desc="<?echo $item['DESCRIPTION'] ?>" data-price="<?echo $item['PRICE'] ?>" data-pos="left">
            <div class="view_bonus_list" data-idproduct = "<?echo $item['ID'] ?>">
              <p class="view_bonus_list_title"><?echo $item['NAME'] ?></p>
              <p class="view_bonus_list_price"><span><?echo $item['PRICE'] ?></span> баллов</p>
            </div>
            <div class="item-block">
              <div class="item-list"><?echo $item['NAME'] ?></div>
              <div class="item-bonus">
                Стоимость услуги: <?echo $item['PRICE'] ?> бонусов
              </div>
              <div class="item-desc"><?echo $item['DESCRIPTION'] ?></div>
            </div>
          </label>
          <? $i++;?>
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

  <div class="services_content">

  </div>
</div>


<div class="user_profile  d-flex">
  <h2>
    Профиль
  </h2>

  <div class="user_profile_content">
    
  </div>

  <div class="btn_update_profile"><i class="fa fa-refresh" aria-hidden="true"></i>Обновить данные профиля</div>

  <div class="user_history">
    <h3><i class="fa fa-history" aria-hidden="true"></i> История списания бонусов</h3>
    <div class="user_history_content">
      <div class="history_container_title">
        <p>Название услуги</p>
        <p>Стоимость услуги</p>
        <p>Дата получения</p>
        <p>Тип</p>
      </div>
      <div class="history_container">
        
      </div>
    </div>
  </div>
</div> 

<div class="admin_panel  d-flex">
  <h2>
    Админка
  </h2>

  <div class="add_bonus">
    <label for="title_bonus">Укажите причину начисления</label>
    <input type="text" id="title_bonus">
    <label for="bonus">Укажите кол-во бонусов</label>
    <input type="text" id="bonus">
    <div class="btn_add_bonus">Добавить бонусы</div>
  </div>
</div>



  <div class="row spinner hidden">
    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12" style="text-align: center">
      <i class="fa fa-spinner fa-spin fa-5x fa-fw"></i>
    </div>
  </div>

  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="//api.bitrix24.com/api/v1/"></script>

  <script>
    $(document).ready(function () {
      console.log('<? echo $_REQUEST['AUTH_ID']?>');
      //Проверка наличия админки у пользователя
       $.post( "https://<? echo $_REQUEST['DOMAIN']?>/rest/user.admin.json?auth=<? echo $_REQUEST['AUTH_ID']?>", {})
        .done(function( result ) {
          
          if(result['result'] == true) {
            console.log('Администратор');
            $('.header>.col-3.user_name').remove();
            $('.header').append('<div class="col-2"><div class="select-list"><a href="#" data-menu="admin_panel"><i class="fa fa-bomb" aria-hidden="true"></i> Админка</a></div></div>');
            $('.header').append('<div class="col-2"><div class="nick"><div class="name" data-userid=""><span id="name"></span></div><div class="bonus" data-balance=""><i class="fa fa-money" aria-hidden="true"></i> <span> </span></div></div></div>');
            $('.header>.col-3').removeClass('col-3');
            $('.header>.logo').addClass('col-2');
          }

          //Получение данных пользователя запустившего приложение
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
              
              var user_name = name + ' ' + last_name;
              
              $('.name>span').append(user_name);
              $('.name').attr('data-userid', user_id);
              $.post( "https://app.cypherr.ru/benefits_cafeteria/get_bd_user.php", {user_id : user_id})
                .done(function( data ) {
                  $('.bonus>span').append(data + ' бонусов');
                  $('.bonus').attr('data-balance', data);
                  $.post( "https://app.cypherr.ru/benefits_cafeteria/get_history.php", {user_id : user_id})
                    .done(function( data ) {
                      $('.history_container').append(data);
                    }); 
                });                
            });
        });
    });
  </script>
  <script src="js/common.js"></script>
</body>
</html>