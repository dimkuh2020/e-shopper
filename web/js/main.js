/*price range*/

 $('#sl2').slider();

	//установка скорости выпадания меню категорий
	$('.catalog').dcAccordion({
		speed: 300
	});

	//показ модальной корзины
	function showCart(cart){
		$('#cart .modal-body').html(cart); //добавляем внутри .modal-body 
		$('#cart').modal(); // выводим модально
	}

	function getCart(){ // показ корзины через навбар
		$.ajax({
			url: '/cart/show',
			type: 'GET',
			success: function(res){
				if(!res) alert('Ошибка!');
				showCart(res);	// показ модального окна корзины			
			},
			error: function(){
				alert('Error!!!');
			}
		});
		return false;
	}

	//удаление одного товара по Х
	$('#cart .modal-body').on('click', '.del-item', function(){ // вытягиваем $id ис атрибута data-id в  ссылке Х на удаление одного товара по классу del-item
		var id = $(this).data('id');
		$.ajax({
			url: '/cart/del-item',
			data: {id: id},
			type: 'GET',
			success: function(res){
				if(!res) alert('Ошибка!');				
				showCart(res);	// показ модального окна корзины			
			},
			error: function(){
				alert('Error!!!');
			}
		});
	});
	
	//кнопка "Очистить корзину"
	function clearCart(){
		$.ajax({
			url: '/cart/clear',
			type: 'GET',
			success: function(res){
				if(!res) alert('Ошибка!');
				showCart(res);	// показ модального окна корзины			
			},
			error: function(){
				alert('Error!!!');
			}
		});
	}

	//кнопка "Добавить в корзину"  в т.ч для карточки товара
	$('.add-to-cart').on('click', function(e){  // скрипт добавления в корзину товара через ajax
		e.preventDefault();
		var id = $(this).data('id'); // получение id товара через арибут data-id="<?=$hits->id?>" в <html>
		var qty = $('#qty').val(); // получение количества товаров ро id из карточки товара
		$.ajax({
			url: '/cart/add',
			data: {id: id, qty: qty},
			type: 'GET',
			success: function(res){
				if(!res) alert('Ошибка!');
				//console.log(res);
				showCart(res);	// показ модального окна корзины			
			},
			error: function(){
				alert('Error!!!');
			}
		});
	});


	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};	
		
/*scroll to top*/

$(document).ready(function(){
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});
