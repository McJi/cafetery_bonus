$(window).keyup(function(e){
	var target = $('.checkbox-btn-group input:focus');
	if (e.keyCode == 9 && $(target).length){
		$(target).parent().addClass('focused');
	}
});
 
$('.checkbox-btn-group input').focusout(function(){
	$(this).parent().removeClass('focused');
});

var array_get_product_info = Array();

$(document).on('change', '.product_item_check', function() {
  var data_pos = $(this).attr('data-pos');
  if(data_pos == 'left') {
    var parent_input = $(this).parent();
    var title_bonus = parent_input[0];
    var price_add = $(this).attr('data-price');
    var price_all = $('#count_bonus').text();
    var summ_price = Number(price_all) + Number(price_add);
    var count_product = $(this).attr('data-productcount');
    var title_product = $(this).attr('data-title');
    var desc_product = $(this).attr('data-desc');
    array_get_product_info[count_product] = title_product + '|' + price_add + '|' + desc_product;
    //проверка достаточности бонусов
    var user_balance = Number($('.bonus').attr('data-balance'));
    if(((user_balance - summ_price) < 0) == true) {
      document.querySelector('.err-block').style.opacity = '1';
    } else {
      document.querySelector('.err-block').style.opacity = '0';
    }
    //
    document.getElementById("count_bonus").innerHTML = summ_price;
    $(this).attr('data-pos', 'right');
    $('.b-block').append(title_bonus);
  } else if(data_pos == 'right') {
    var parent_input = $(this).parent();
    var title_bonus = parent_input[0];
    var price_add = $(this).attr('data-price');
    var price_all = $('#count_bonus').text();
    var summ_price = Number(price_all) - Number(price_add);
    var count_product = $(this).attr('data-productcount');

    array_get_product_info.splice(count_product);
    //проверка достаточности бонусов
    var user_balance = Number($('.bonus').attr('data-balance'));
    if(((user_balance - summ_price) < 0) == true) {
      document.querySelector('.err-block').style.opacity = '1';
    } else {
      document.querySelector('.err-block').style.opacity = '0';
    }
    //
    document.getElementById("count_bonus").innerHTML = summ_price;
    $(this).attr('data-pos', 'left');
    $('.checkbox-btn-group').append(title_bonus);
  }
  
});

$(document).on('click', '.select-list>a', function() {
  var old_type_menu = $('.select-list>a.choose-ser').attr('data-menu');
  console.log(old_type_menu);
  $('.select-list>a.choose-ser').removeClass('choose-ser');
  $(this).toggleClass('choose-ser');
  var type_menu_click = $(this).attr('data-menu');
  console.log(type_menu_click);
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
  }
});

$('.btn-sub').on('click', function() {
  var price_product_all = Number($('#count_bonus').text());
  console.log(price_product_all);
  var user_bonus = Number($('.bonus').attr('data-balance'));
  var user_id = $('.name').attr('data-userid');
  //var json__product = JSON.stringify(array_get_product_info);
  console.log(array_get_product_info);
  if(((user_bonus - price_product_all) > 0) == true) {
    $.post( "https://app.cypherr.ru/benefits_cafeteria/add_services_bd.php", {arr : array_get_product_info, user_id: user_id})
      .done(function( data ) {
        console.log(data);
        
        location.reload();
        
      });
  } else { 
    alert('У вас недостаточно бонусов!');
  }
})

$('.btn_add_bonus').on('click', function() {
  var title_bonus = $('#title_bonus').val();
  var bonus_count = $('#bonus').val();
  var user_id = $('.name').attr('data-userid');
  $.post( "https://app.cypherr.ru/benefits_cafeteria/add_bonus_user.php", {bonus : bonus_count, title_bonus : title_bonus, user_id : user_id})
      .done(function( data ) {
        console.log(data);
        
        location.reload();
        
      });
});

$('.btn_update_profile').on('click', function() {
  var user_id = $('.name').attr('data-userid');
  $.post( "https://app.cypherr.ru/benefits_cafeteria/update_profile.php", {user_id : user_id})
      .done(function( data ) {
        console.log(data);
        
        location.reload();
        
      });
});