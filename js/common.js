$(window).keyup(function(e){
	var target = $('.checkbox-btn-group input:focus');
	if (e.keyCode == 9 && $(target).length){
		$(target).parent().addClass('focused');
	}
});
 
$('.checkbox-btn-group input').focusout(function(){
	$(this).parent().removeClass('focused');
});

$(document).on('click', '.section_product', function() {
  $('.section_product.active').removeClass('active');
  $('.section_product_item_content.section_active').removeClass('section_active');

  $(this).addClass('active');
  var data_id = Number($(this).attr('data-id'));
  $('.section_product_item_content').eq(data_id).addClass('section_active');
});

$(document).on('click', '.btn_full_info', function() {
  $(this).eq(0).parent().eq(0).children().eq(3).addClass('modal_active');
});

$(document).on('click', '.modal_exit_btn', function() {
  $('.modal_product_item.modal_active').toggleClass('modal_active');
});



var array_get_product_info = Array();

$(document).on('click', '.btn_product_item', function() {
  var position_product = $(this).attr('data-pos')
  if(position_product == 'left') {
    var data_modal = $(this).attr('data-modal');
    if(data_modal == "modal") {
      $(this).parent().eq(0).parent().eq(0).css('box-shadow', '0px 0px 10px 3px rgb(33 127 222 / 74%)');
      $(this).parent().eq(0).parent().eq(0).children().eq(2).text('Добавлено');
      var product_title = $(this).attr('data-producttitle');
      var product_price = $(this).attr('data-productprice');
      var product_desc = $(this).attr('data-productdesc');
      var product_id = $(this).attr('data-productid');
      var product_category = $(this).attr('data-category');
      var total_price = Number($('#count_bonus').text()) + Number(product_price);
      var balance_user = $('.bonus').attr('data-balance');
      
      $('#count_bonus').text(total_price);

      var product_count = $(this).attr('data-productcount');
      var section_count = $(this).attr('data-sectionid');
      $('.b-block').append('<div class="selected_product" data-productprice="'+product_price+'" data-category="'+product_category+'" data-producttitle="'+product_title+'" data-productid="'+product_id+'" data-productdesc="'+product_desc+'" data-productcount="'+product_count+'" data-sectionid="'+section_count+'"><p>'+product_title+'</p><p>'+product_price+'</p></div>');
      $(this).text('Добавлено');

      array_get_product_info[product_count] = product_title + '|' + product_price + '|' + product_desc + '|' + product_category;
      console.log(array_get_product_info);
      if((Number(balance_user) - Number(total_price) < 0) == true) {
        $('.err-block').css('opacity', '1');
      } else {
        $('.err-block').css('opacity', '0');
      }

    } else if(data_modal == 'none') {
      $(this).parent().eq(0).css('box-shadow', '0px 0px 10px 3px rgb(33 127 222 / 74%)');

      var product_title = $(this).attr('data-producttitle');
      var product_price = $(this).attr('data-productprice');
      var product_desc = $(this).attr('data-productdesc');
      var product_id = $(this).attr('data-productid');
      var product_category = $(this).attr('data-category');
      var total_price = Number($('#count_bonus').text()) + Number(product_price);
      var balance_user = $('.bonus').attr('data-balance');
      
      $('#count_bonus').text(total_price);
      var product_count = $(this).attr('data-productcount');
      var section_count = $(this).attr('data-sectionid');
      $('.b-block').append('<div class="selected_product" data-productprice="'+product_price+'" data-category="'+product_category+'" data-producttitle="'+product_title+'" data-productid="'+product_id+'" data-productdesc="'+product_desc+'" data-productcount="'+product_count+'" data-sectionid="'+section_count+'"><p>'+product_title+'</p><p>'+product_price+' бонусов</p></div>');
      $(this).text('Добавлено');

      array_get_product_info[product_count] = product_title + '|' + product_price + '|' + product_desc + '|' + product_category;
      $(this).parent().eq(0).children().eq(3).children().eq(3).text('Добавлено');

      if((Number(balance_user) - Number(total_price) < 0) == true) {
        $('.err-block').css('opacity', '1');
      } else {
        $('.err-block').css('opacity', '0');
      }
    }
    $(this).parent().eq(0).children().eq(3).children().eq(3).attr('data-pos', 'right');
    $(this).attr('data-pos', 'right');
  } else if(position_product == 'right') {
    alert('Товар уже добавлен в корзину')
  }
});

$(document).on('click', '.selected_product', function() {
  
  var product_section = $(this).attr('data-sectionid');
  var product_count = $(this).attr('data-productcount');
  var product_price = $(this).attr('data-productprice');
  var balance_user = $('.bonus').attr('data-balance');
  $('.product_item[data-sectionid="' + product_section+'"][data-productcount="' + product_count +'"]').css('box-shadow', 'none');

  $('.product_item[data-sectionid="' + product_section+'"][data-productcount="' + product_count +'"]').children().eq(2).text('Добавить');

  $('.product_item[data-sectionid="' + product_section+'"][data-productcount="' + product_count +'"]').children().eq(2).attr('data-pos', 'left');

  $('.product_item[data-sectionid="' + product_section+'"][data-productcount="' + product_count +'"]').children().eq(3).children().eq(3).text('Добавить');

  $('.product_item[data-sectionid="' + product_section+'"][data-productcount="' + product_count +'"]').children().eq(3).children().eq(3).attr('data-pos', 'left');

  var total_price = Number($('#count_bonus').text()) - Number(product_price);
  if((Number(balance_user) - Number(total_price) < 0) == true) {
    $('.err-block').css('opacity', '1');
  } else {
    $('.err-block').css('opacity', '0');
  }
  array_get_product_info.splice(product_count);
  $('#count_bonus').text(total_price);
  $(this).remove();
});


$(document).on('click', '.select-list>a', function() {
  var old_type_menu = $('.select-list>a.choose-ser').attr('data-menu');
  $('.select-list>a.choose-ser').removeClass('choose-ser');
  $(this).toggleClass('choose-ser');
  var type_menu_click = $(this).attr('data-menu');
  if(type_menu_click == 'main-blok') {
    if(old_type_menu == 'main-blok') {

    } else if(old_type_menu == 'my_services') {
      $('.my_services').removeClass('active');
      $('.main-blok').addClass('active');
    } else if(old_type_menu == 'my_profile') {
      $('.user_profile').removeClass('active');
      $('.main-blok').addClass('active');
    } else if(old_type_menu == 'admin_panel') {
      $('.admin_panel').removeClass('active');
      $('.main-blok').addClass('active');
    }
  } else if(type_menu_click == 'my_services') {
    if(old_type_menu == 'main-blok') {
      $('.main-blok').removeClass('active');
      $('.my_services').addClass('active');
    } else if(old_type_menu == 'my_services') {
      
    } else if(old_type_menu == 'my_profile') {
      $('.user_profile').removeClass('active');
      $('.my_services').addClass('active');
    } else if(old_type_menu == 'admin_panel') {
      $('.admin_panel').removeClass('active');
      $('.my_services').addClass('active');
    }
    $('.services_content>label').remove();
    var user_id = $('.name').attr('data-userid');
    $.post( "https://app.cypherr.ru/benefits_cafeteria/get_bd_product.php", {user_id : user_id})
      .done(function( data ) {
        $('.services_content').children().remove();
        $('.services_content').append(data);
      });
  } else if(type_menu_click == 'my_profile') {
    if(old_type_menu == 'main-blok') {
      $('.main-blok').removeClass('active');
      $('.user_profile').addClass('active');
    } else if(old_type_menu == 'my_services') {
      $('.my_services').removeClass('active');
      $('.user_profile').addClass('active');
    } else if(old_type_menu == 'my_profile') {

    } else if(old_type_menu == 'admin_panel') {
      $('.admin_panel').removeClass('active');
      $('.user_profile').addClass('active');
    } 

    $('.wrapper_profile').remove();
    var user_id = $('.name').attr('data-userid');
    $.post( "https://app.cypherr.ru/benefits_cafeteria/get_bd_profile.php", {user_id : user_id})
      .done(function( data ) {
        $('.user_profile_content').append(data);
      });
  } else if(type_menu_click == 'admin_panel') {
    if(old_type_menu == 'main-blok') {
      $('.main-blok').removeClass('active');
      $('.admin_panel').addClass('active');
    } else if(old_type_menu == 'my_services') {
      $('.my_services').removeClass('active');
      $('.admin_panel').addClass('active');
    } else if(old_type_menu == 'my_profile') {
      $('.user_profile').removeClass('active');
      $('.admin_panel').addClass('active');
    } else if(old_type_menu == 'admin_panel') {

    }
    $('.moderate_content[data-moderate="current_requests"]').children().remove();
    var domain = BX24.getDomain();
    var data_modarate = 'current_requests';
    $.post( "https://app.cypherr.ru/benefits_cafeteria/get_bd_moderate.php", {domain: domain, data_modarate:data_modarate})
      .done(function( data ) {
        $('.moderate_content[data-moderate="current_requests"]').append(data);
      });
  }
});

$(document).on('click', '.moderate_menu_item', function() {
  var data_modarate = $(this).attr('data-moderate');

  $('.moderate_menu_item.active_moderate').removeClass('active_moderate');
  $('.moderate_content.active_moderate_content').removeClass('active_moderate_content');

  $(this).addClass('active_moderate');
  $('.moderate_content[data-moderate="'+data_modarate+'"]').addClass('active_moderate_content');

  $('.moderate_content[data-moderate="'+data_modarate+'"]').children().remove();
    var domain = BX24.getDomain();
    $.post( "https://app.cypherr.ru/benefits_cafeteria/get_bd_moderate.php", {domain: domain, data_modarate: data_modarate})
      .done(function( data ) {
        $('.moderate_content[data-moderate="'+data_modarate+'"]').append(data);
      });
});

$(document).on('click', '.analitic_item', function() {
  var data_analitics = $(this).attr('data-analitics');

  $('.analitic_item.active_analitic_item').removeClass('active_analitic_item');
  $('.analitics_item_container.active_analitic_item_container').removeClass('active_analitic_item_container');

  $(this).addClass('active_analitic_item');
  $('.analitics_item_container[data-analitics="'+data_analitics+'"]').addClass('active_analitic_item_container');

  
  if(data_analitics == 'get_info_for_user') {
    $('.content_isers_info').children().remove();
    var domain = BX24.getDomain();
    $.post( "https://app.cypherr.ru/benefits_cafeteria/get_bd_user_admin.php", {})
      .done(function( data ) {
        $('.content_isers_info').append(data);
      });
  } else if(data_analitics == 'report_bonus') {
    $('.table_category').children().remove();
    $.post( "https://app.cypherr.ru/benefits_cafeteria/bonus_report_diagramm.php", {})
      .done(function( data ) {
        console.log(data);
        var data_points = JSON.parse(data);
        console.log(data_points);
        var chart = new CanvasJS.Chart("chartContainer", {
          animationEnabled: true,
          title: {
            text: "Диаграмма использования услуг"
          },
          data: [{
            type: "pie",
            startAngle: 240,
            yValueFormatString: "##0.00\"%\"",
            indexLabel: "{label} {y}",
            dataPoints: data_points
          }]
        });
        chart.render();
      });
      $.post( "https://app.cypherr.ru/benefits_cafeteria/bonus_report_table.php", {})
      .done(function( data ) {
        $('.table_category').append(data);
      });
  }
    
});

$('.btn-sub').on('click', function() {
  var price_product_all = Number($('#count_bonus').text());
  console.log(price_product_all);
  var user_bonus = Number($('.bonus').attr('data-balance'));
  var user_name = $('#name').text();
  var user_id = $('.name').attr('data-userid');
  var moderator = $('#name').text();
  if(((user_bonus - price_product_all) > 0) == true) {
    $.post( "https://app.cypherr.ru/benefits_cafeteria/add_services_moderate.php", {arr : array_get_product_info, user_name: user_name, user_id: user_id, moderator: moderator})
      .done(function( data ) {
        location.reload();
      });
  } else { 
    alert('У вас недостаточно бонусов!');
  }
});

//moderate
$(document).on('click', '.accept_moderate', function() {
  console.log('test');
  var product_name = $(this).attr('data-servtitle');
  var product_price = $(this).attr('data-servprice');
  var product_desc = $(this).attr('data-servdesc');
  var status = $(this).attr('data-status');
  var user_id = $(this).attr('data-userid');
  var product_category = $(this).attr('data-servcategory');
  var bd_id = $(this).attr('data-bdid');
  var random_id_product = $(this).attr('data-random');
  
    $.post( "https://app.cypherr.ru/benefits_cafeteria/add_services_bd.php", {product_name: product_name, product_price: product_price, product_desc: product_desc, product_category: product_category, bd_id: bd_id, random_id_product: random_id_product, user_id: user_id, status: status})
      .done(function( data ) {
        location.reload();
      });
  
});

$(document).on('click', '.accept_moderate_modal', function() {
  var product_name = $(this).attr('data-servtitle');
  var product_price = $(this).attr('data-servprice');
  var product_desc = $(this).attr('data-servdesc');
  var status = $(this).attr('data-status');
  var user_id = $(this).attr('data-userid');
  var product_category = $(this).attr('data-servcategory');
  var bd_id = $(this).attr('data-bdid');
  var random_id_product = $(this).attr('data-random');
  
    $.post( "https://app.cypherr.ru/benefits_cafeteria/add_services_bd.php", {product_name: product_name, product_price: product_price, product_desc: product_desc, product_category: product_category, bd_id: bd_id, random_id_product: random_id_product, user_id: user_id, status: status})
      .done(function( data ) {
        location.reload();
      });
});

$(document).on('click', '.cancel_moder', function() {
  var random_id_product = $(this).attr('data-random');
  $.post( "https://app.cypherr.ru/benefits_cafeteria/cancel_moderate.php", { random_id_product: random_id_product})
      .done(function( data ) {
        location.reload();
      });
});

$(document).on('click', '.cancel_moder_modal', function() {
  var random_id_product = $(this).attr('data-random');
  $.post( "https://app.cypherr.ru/benefits_cafeteria/cancel_moderate.php", { random_id_product: random_id_product})
      .done(function( data ) {
        location.reload();
      });
});

//
$('.btn_add_bonus').on('click', function() {
  var title_bonus = $('#title_bonus').val();
  var bonus_count = $('#bonus').val();
  var user_id = $('.user_name_sel').attr('data-id');
  console.log(user_id);
  $.post( "https://app.cypherr.ru/benefits_cafeteria/add_bonus_user.php", {bonus : bonus_count, title_bonus : title_bonus, user_id : user_id})
      .done(function( data ) {
        location.reload();
      });
});

$(document).on('click', '.btn_update_profile', function() {
  var user_id = $('.name').attr('data-userid');
  $.post( "https://app.cypherr.ru/benefits_cafeteria/update_profile.php", {user_id : user_id})
      .done(function( data ) {
        location.reload();
      });
});

$(document).on('click', '.btn_services_modal', function() {
  $(this).parent().eq(0).children().eq(5).addClass('active_services_modal');
});

$(document).on('click', '.btn_services_modal_close', function() {
  $(this).parent().eq(0).removeClass('active_services_modal');
});

$(document).on('change', '#filter_type', function() {
  var user_id = $('.name').attr('data-userid');
  var filter_category = $('#filter_category').find(':selected').val();
  var type_bonus = $(this).find(':selected').val();
  $.post( "https://app.cypherr.ru/benefits_cafeteria/get_history.php", {user_id : user_id, type_bonus: type_bonus, filter_category: filter_category})
    .done(function( data ) {
      $('.user_history_content').children().remove();
      $('.user_history_content').append(data);
    });
});

$(document).on('change', '#filter_category', function() {
  var user_id = $('.name').attr('data-userid');
  var type_bonus = $('#filter_type').find(':selected').val();
  var filter_category = $(this).find(':selected').val();
  $.post( "https://app.cypherr.ru/benefits_cafeteria/get_history.php", {user_id : user_id, type_bonus: type_bonus, filter_category: filter_category})
    .done(function( data ) {
      $('.user_history_content').children().remove();
      $('.user_history_content').append(data);
    });
});

$(document).on('click', '.admin_menu_item', function() {
  var data_admin_menu = $(this).attr('data-adminmenu');
  
  $('.admin_menu_item.active_admin_item').removeClass('active_admin_item');
  $(this).addClass('active_admin_item');

  $('.admin_menu_content.active_admin').removeClass('active_admin');

  $('.admin_menu_content[data-adminmenu="'+data_admin_menu+'"]').addClass('active_admin');

  if(data_admin_menu == 'moderate_request_bonus') {
    $('.moderate_content').children().remove();
    var domain = BX24.getDomain();
    $.post( "https://app.cypherr.ru/benefits_cafeteria/get_bd_moderate.php", {domain: domain})
      .done(function( data ) {
        $('.moderate_content').append(data);
      });
  } else if(data_admin_menu == 'analitics') {
    $('.content_isers_info').children().remove();
    $.post( "https://app.cypherr.ru/benefits_cafeteria/get_bd_user_admin.php", {})
      .done(function( data ) {
        $('.content_isers_info').append(data);
      });
  };
});

$(document).on('click', '.btn_add_users', function() {
  var user_add = $(this).attr('data-add');
  var user_add_id = $('#users_add').val();
  var admin_id = $('.name').attr('data-userid');
  console.log(user_add_id);
  $.post( "https://app.cypherr.ru/benefits_cafeteria/add_new_user.php", {user_add_id: user_add_id, admin_id: admin_id, user_add: user_add})
      .done(function( data ) {
        location.reload();
      });
});

$(document).on('click', '.btn_add_users_depart', function() {
  var depart_add_id = $('#depart_add').val();
  var user_add = $(this).attr('data-add');
  var admin_id = $('.name').attr('data-userid');
  $.post( "https://app.cypherr.ru/benefits_cafeteria/add_new_user.php", {depart_add_id: depart_add_id, admin_id: admin_id, user_add: user_add})
      .done(function( data ) {
        location.reload();
      });
});

$(document).on('click', '.btn_moderate_modal', function() {
  $(this).parent().eq(0).children().eq(7).addClass('active_moderate_modal');
});

$(document).on('click', '.btn_moderate_modal_close', function() {
  $(this).parent().eq(0).removeClass('active_moderate_modal');
});
//Аналитика отчет по использованию
$('#get_period').on('change', function() {
  if($(this).find(':selected').val() == 'year') {
    $('.get_year').removeClass('hidden');
    $('.get_month').addClass('hidden');
    $('.btn_get_info_report').removeClass('hidden');
  } else if($(this).find(':selected').val() == 'month') {
    $('.get_year').removeClass('hidden');
    $('.get_month').removeClass('hidden');
    $('.btn_get_info_report').removeClass('hidden');
  } else if($(this).find(':selected').val() == 'period') {
    $('.get_year').addClass('hidden');
    $('.get_month').addClass('hidden');
    alert('Не тыкай сюда');
  }
});

$('#get_year').on('change', function() {
  console.log();
  console.log($(this).find(':selected').val());
  console.log($('.date_year_today').val());
  if(Number($(this).find(':selected').val()) != Number($('.date_year_today').val())) {
    $('.get_month').children().remove();
    $('.get_month').append('<option value="1">Январь</option><option value="2">Февраль</option><option value="3">Март</option><option value="4">Апрель</option><option value="5">Май</option><option value="6">Июнь</option><option value="7">Июль</option><option value="8">Август</option><option value="9">Сентябрь</option><option value="10">Октябрь</option><option value="11">Ноябрь</option><option value="12">Декабрь</option>')
  } else if (Number($(this).find(':selected').val()) == Number($('.date_year_today').val())){
    var arr_option_month = Array();

    for(var m = Number($('.date_month').val()); m <= Number($('.date_month_today').val()); m++) {
      var selected = ' ';
      if(m == 01) {
        var name_m = 'Январь';
        selected = 'selected';
      } else if(m == 02) {
        var name_m = 'Февраль';
      } else if(m == 03) {
        var name_m = 'Март';
      } else if(m == 04) {
        var name_m = 'Апрель';
      } else if(m == 05) {
        var name_m = 'Май';
      } else if(m == 06) {
        var name_m = 'Июнь';
      } else if(m == 07) {
        var name_m = 'Июль';
      } else if(m == 08) {
        var name_m = 'Август';
      } else if(m == 09) {
        var name_m = 'Сентябрь';
      } else if($m == 10) {
        var name_m = 'Октябрь';
      } else if($m == 11) {
        var name_m = 'Ноябрь';
      } else if($m == 12) {
        var name_m = 'Декабрь';
      }

      arr_option_month.push('<option value="'+m+'" '+selected+'>'+name_m+'</option>');
    }
    $('.get_month').children().remove();
    console.log(arr_option_month)
    var str_option = arr_option_month.join(' ')
    console.log(str_option)
    $('.get_month').append(str_option)
  }
});


$('.btn_get_info_report').on('click', function() {
  var user_id = $('#users_get').find(':selected').val();
  var user_name = $('#users_get').find(':selected').text();
  var period = $('#get_period').find(':selected').val();
  console.log(user_id);
  console.log(user_name);
  console.log(period);
  if(period == 'year') {
    var year = $('#get_year').find(':selected').val();
    console.log(year);
  } else if( period == 'month') {
    var year = $('#get_year').find(':selected').val();
    var month = $('#get_month').find(':selected').val();
    console.log(year);
    console.log(month);
    console.log(month.length);
    if(month.length < 2) {
      month = '0' + month;
      console.log(month);
    }
    
  }
  $('.report_user_table').children().remove();
    $.post( "https://app.cypherr.ru/benefits_cafeteria/report_user_diagramm.php", {user_id: user_id, period: period, year: year, month: month})
      .done(function( data ) {
        if((data == '') == false) {
          var data_points = JSON.parse(data);
          var chart = new CanvasJS.Chart("chartContainerUser", {
            animationEnabled: true,
            title: {
              text: "Диаграмма использования услуг "+user_name+""
            },
            data: [{
              type: "pie",
              startAngle: 240,
              yValueFormatString: "##0.00\"%\"",
              indexLabel: "{label} {y}",
              dataPoints: data_points
            }]
          });
          chart.render();
        } else {
          //$('#chartContainerUser').children().remove();
          var chart = new CanvasJS.Chart("chartContainerUser", {
            animationEnabled: true,
            title: {
              text: "Диаграмма использования услуг "+user_name+""
            },
            data: [{
              type: "pie",
              startAngle: 240,
              yValueFormatString: "##0.00\"%\"",
              indexLabel: "{label} {y}",
              dataPoints: [{label: "Услуг нет", y: 0}]
            }]
          });
          chart.render();
        }
      });
      $.post( "https://app.cypherr.ru/benefits_cafeteria/report_user_table.php", {user_id: user_id, period: period, year: year, month: month})
      .done(function( data ) {
        $('.report_user_table').append(data);
      });
});

$(document).on('click', '.btn_user_setting', function() {
  var user_rights = $(this).attr('data-admin');
  var user_id = $(this).attr('data-user');
  console.log(user_rights);
  console.log(user_id);
  $.post( "https://app.cypherr.ru/benefits_cafeteria/update_user_rights.php", {user_id: user_id, user_rights: user_rights})
    .done(function( data ) {
      
    });
    
  if(user_rights == 'add_admin') {
    $(this).attr('data-admin', 'del_admin');
    $(this).text('Забрать права');
    $('.user_role[data-user="'+user_id+'"]').text('Администратор');
  } else if(user_rights == 'del_admin') {
    $(this).attr('data-admin', 'add_admin');
    $(this).text('Сделать администратором');
    $('.user_role[data-user="'+user_id+'"]').text('Пользователь');
  }
});

$(document).on('click', '.user_add_more_text', function() {
  console.log($(this));
  $('.modal_change_user').css('display', 'block');
});

$(document).on('click', '.btn_change_user', function() {

  $('.modal_change_user').css('display', 'none');
  $('.user_selected').children().remove();
  $('.user_selected').append('<span class="user_name_sel" data-id="' + $(this).parent().children().eq(1).attr('data-id') + '">' + $(this).parent().children().eq(1).text() + '</span><span class="user_close"></span>');
  $('.user_add_more_text').text('Сменить');
});

$(document).on('click', '.user_close', function() {
  $(this).parent().children().remove();
  $('.user_add_more_text').text('Добавить');
});

$(document).on('click', '.btn_close_popup', function() {
  $('.modal_change_user').css('display', 'none');
});

$(document).on('click', '.setting_item_menu', function() {
  var data_setting = $(this).attr('data-setting');
  console.log(data_setting);

  $('.setting_item_menu.active').removeClass('active');
  $('.setting_item_content.active').removeClass('active');

  $(this).addClass('active');
  $('.setting_item_content[data-setting="'+ data_setting +'"]').addClass('active');
});

$(document).on('click', '.settings_services_menu_item', function() {
  var data_set_item = $(this).attr('data-servicesitem');
  console.log(data_set_item);

  $('.settings_services_menu_item.active').removeClass('active');
  $('.settings_services_content.active').removeClass('active');

  $(this).addClass('active');
  $('.settings_services_content[data-servicesitem="'+ data_set_item +'"]').addClass('active');
});

$(document).ready(function() {
	$('#accordeon_services_item .head_services_item').on('click', servicesItem);
  $('#accordeon_services_title .head_services_title').on('click', servicesTitle);
  $('#accordeon_services_price .head_services_price').on('click', servicesPrice);
  $('#accordeon_services_description .head_services_description').on('click', servicesDescription);
});

function servicesItem(){
  $('#accordeon_services_item .hidden_services_item').not($(this).next());
  $(this).next().toggleClass("active_services_item");
}

function servicesTitle(){
  $('#accordeon_services_title .hidden_services_title').not($(this).next());
  $(this).next().toggleClass("active_services_title");
}

function servicesPrice(){
  $('#accordeon_services_price .hidden_services_price').not($(this).next());
  $(this).next().toggleClass("active_services_price");
}

function servicesDescription(){
  $('#accordeon_services_description .hidden_services_description').not($(this).next());
  $(this).next().toggleClass("active_services_description");
}

$(document).on('click', '.btn_save_edit_services', function() {
  var data_count = $(this).attr('data-count');
  console.log(data_count);
  var name_service = $('.input_services_title[data-count="'+data_count+'"]').val();
  console.log(name_service);
  var price_service = $('.input_services_price[data-count="'+data_count+'"]').val();
  console.log(price_service);
  var description_service = $('.input_services_description[data-count="'+data_count+'"]').text();
  console.log(description_service);
  var section_service = $('#change_section_services[data-count="'+data_count+'"]').find(':selected').val();
  console.log(section_service);
  var product_id = $(this).attr('data-product');
  $('.head_services_item[data-count="'+data_count+'"]').text(name_service);

  $.post( "https://app.cypherr.ru/benefits_cafeteria/edit_product_service.php", {name_service: name_service, price_service: price_service, description_service: description_service, section_service: section_service, product_id: product_id})
    .done(function( data ) {
      alert('Красава! Продукт изменен.')
      console.log(data);
    });
  
})


