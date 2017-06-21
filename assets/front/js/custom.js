/*global $, console, alert*/
$(function () {
    'use strict';
   
    // Adjusting The Header Height
    var docHeight = $(window).height();

    $('.top-header').height(docHeight);
    $('.header-size').height((3*docHeight) / 4);
    $('#resHeaderTitle').css({"padding-top": ($(".header-size").height()  - $('#resHeaderTitle').height()) / 2});
    
    //Some Settings On Scrolling
    $(window).on('scroll', function () {
       
        var scTop = $(document).scrollTop(),
            nav = $('.main-nav'),
            // determining the next section of header in different pages
            nxtSecOffset = $('.nxtSecOffset').offset().top;
        
        // Making The Nav Fixed
        if (scTop >= nxtSecOffset) {
            nav.addClass('fixed');
        
        }
        
        // Making The nav Unfixed
        if (scTop < nxtSecOffset){
            nav.removeClass('fixed');
        }	
    });

    
    //Bootstrap Tooltip Trigger
    $('[data-toggle="tooltip"]').tooltip();
    
    // //Nice Scroll Plugin
    $("html").niceScroll();

    if ($('#dateTimePicker').length)
    {
        // date time picker
        $('#dateTimePicker').datetimepicker();

        var currentDateTime = new Date();
        jQuery('#dateTimePicker').datetimepicker({
          format:'Y-m-d H:i:00',
          minDate: currentDateTime 
        });
    }


    // disable entering date and time by user 
    $('#dateTimePicker').keypress(function(e) {e.preventDefault()});


    // Add meals to order via ajax
    $(document).on('click', '.order_meal', function(e) {
        e.preventDefault();

        var reqUrl = 'orderMeal.php',
            _this = $(this),
            meal_id = _this.data('meal_id'),
            sentData = {};

            if (typeof(meal_id) !== 'undefined'){
                sentData['meal_id'] = meal_id;
            }
            
        // ajax function
        $.ajax({
            url: reqUrl,
            type: 'GET',
            data: sentData,
            dataType: 'json'
        })
        .done(function(data) {
            // check login
            if (data.check === 'not logged') 
            {
                alert('You have to login first');
            }
            if (data.check === 'logged') {
                if (data.added === 'true')
                    $('span.badge').text(data.counter);
                 else {
                    alert ('You have already ordered this meal!');
                }
            }
        })
    });


    // prevent user to enter the number by himself
    $('.quantity').keypress(function(e) { e.preventDefault(); });

    // increment number of meal 
    $('.incr-btn').click(function(e) {
        e.preventDefault();
        // increment/decrement link
        var _this = $(this);

        $(this).siblings('.quantity').val(function(i, oldVal) {
            var count = oldVal;
            // increment
            if (_this.text() == '+') 
            {
                if (count < 50)
                    return ++oldVal;
              
                return oldVal;
            } 
            // decrement
            else if (_this.text() == '–') 
            {
                if (count > 1)
                    return --oldVal;
              
                return oldVal;
            }  
        });
    });

    // calculate order total price
    var total_price = 0;
    // check if there was ordered meals
    if ($('.quantity').length > 0)
    {
        var shippingFees = $('#sippingFees').text(2);

        function calculateTotalPrice() {
            $('.quantity').each(function() {
               
                let mealQuant = $(this).val(),
                mealPrice = $(this).parents('.item-count').siblings('.item-price').children('h4').text();

                total_price += (parseInt(mealPrice) * parseInt(mealQuant));
            });
            return total_price;
        }

        $('#totalPrice').text(calculateTotalPrice());

        $('a.incr-btn').click(function() {
            total_price = 0;
            $('#totalPrice').text(calculateTotalPrice())
        });



        // delete order meal
        // delete by id with ajax
        $('.deleteMealBtn').click(function (e)
        {
            // prevent page loading on link clicking
            e.preventDefault();
            // assign this button [link] to a varible and get its id
            var deleteBtn = $(this),
                // item id to delete
                item_id = deleteBtn.attr('id');

            // data object to be sent with request
            var dataObj = {};
            dataObj['meal_id'] = item_id;
            

            // check if admin confirmed deleting
            if (confirm('Are you sure?'))
            {
                // ajax function
               $.ajax({
                    url: 'order_session.php',
                    type: 'POST',
                    data: dataObj,
                    dataType: 'json'
                })
                .done(function(data) {
                    // remove data row from DOM
                    if (data.delete == 'deleted') {
                        deleteBtn.parent().parent().fadeOut('100', function() {
                            $(this).remove();
                        });

                        $('span.badge').text(data.count);

                        let item_remove = deleteBtn.parents('.item-remove');

                        let deletedMealPrice = item_remove.siblings('.item-price').children('h4').text(),
                            deletedMealQuant = item_remove.siblings('.item-count').children('.count-input').children('.quantity').val();

                        total_price -= (parseInt(deletedMealQuant) * parseInt(deletedMealPrice));
                        $('#totalPrice').text(total_price);

                        if (data.count == 0)
                        {
                            $('.cart-buttons a').addClass('disabled').css({
                                backgroundColor: '#868282'
                            });
                            $('.cart-buttons a').click(function(e){e.preventDefault()});
                        }
                    }

                })
            }
        });


        // confirm order
        if (!$('#confirm').hasClass('disabled'))
        {
            $('#checkout').addClass('disabled');
            $('#confirm').click(function(e) {
                e.preventDefault();

                var mealsInfoArr = [],
                    mealsIdsArr = [],
                    mealsQuantitiesArr = []; 

                $('.quantity').each(function() 
                {
                    let mealQuant = $(this).val(),
                    mealId = $(this).parents('.item-count').siblings('.item-remove').children('a').attr('id');

                    mealsIdsArr.push(mealId);
                    mealsQuantitiesArr.push(mealQuant);   
                });

                mealsInfoArr.push(mealsIdsArr);
                mealsInfoArr.push(mealsQuantitiesArr);
                mealsInfoArr.push(parseInt($('#totalPrice').text()));

                var sent_order = {order_info: mealsInfoArr};

                $.ajax({
                    url: 'order_session.php',
                    type: 'POST',
                    data: sent_order,
                    dataType: 'json'
                })
                .done(function(data){
                    if (data.done === 'done'){
                        $('.cart-table').slideUp('700');
                        $('#confirm').remove();
                        $('#checkout').removeClass('disabled');
                    }

                })
            });
        }

        // checkout order
        $('#checkout').css({backgroundColor: '#333'});

        $('#checkout').mouseover(function() {
            $(this).css({backgroundColor: '#fd5c63'});
        }).mouseleave(function() {
            $(this).css({backgroundColor: '#333'});
        });

        $('#checkout').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: 'addorder.php',
                type: 'POST',
                data: {checkout: 'checkout'},
                dataType: 'json',
            })
            .done(function(data) {
                if (data.order_meals == 'done')
                { 
                    $('.badge').text(data.counter);
                    $('#checkout').fadeOut('300', function(){
                        $('#result').text('Your order is ready!');
                    });
                }
            })
        })
    } 
    else
    {
        $('.cart-buttons a').addClass('disabled').css({
            backgroundColor: '#868282'
        });
        
        $('.cart-buttons a').click(function(e){e.preventDefault()});
    }


    // check login function for reservation
    $('.notLoggedBtn').click(function(e)
    {
        e.preventDefault();
        alert('You have to login first!');
    });

});
        
