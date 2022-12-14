function ajaxFilter() {
    $(".loading-mask").show();
    var filter_inputs = $("#product_filter").serialize();
    $.ajax({
        url: $("#product_filter").attr('action'),
        method: 'GET',
        data: filter_inputs,
        success: function (result) {
            $('#catalog-section').html(result);
            $(".loading-mask").hide();

            var urlPath = $("#product_filter").attr('action') + "?" + filter_inputs;
            window.history.pushState({}, "", urlPath);
        }
    });
}

function markPropertySelected(property) {
    $(property).parent().parent().find('a.selected').removeClass('selected');
    $(property).addClass('selected');
}

function collectSelectedProps(clicked_a) {
    markPropertySelected(clicked_a);
    var selected_props = {};

    $('.offers-props ul').each(function ($num, $obj) {
        var property_id = $($obj).attr('data-property-id');
        var value_id = $($obj).find('a.selected').attr('data-value-id');
        selected_props[property_id] = value_id;
    });
    return selected_props;
}

function ajaxOfferProps(props, product_id, is_modal) {

    $.ajax({
        url: "/catalog/offers/"+product_id,
        method: 'GET',
        data: {offer_properties: props, modal: is_modal},
        success: function (result) {
            $('.ajax-offer-block').html(result);
        }
    });
}

$('body').on('change', 'ul.sidebar__list input', function () {
    ajaxFilter();
});

$('body').on('click', '#send-filter', function (e) {
    e.preventDefault();
    ajaxFilter();
});


$('body').on('click', '.htc__product__details__inner .offers-props li a.active', function (e) {
    e.preventDefault();
    var selected_props = collectSelectedProps(this);
    ajaxOfferProps(selected_props, $('.product-information').attr('data-product-id'), 0);
});

$('body').on('click', '#productModal .offers-props li a.active', function (e) {
    e.preventDefault();
    var selected_props = collectSelectedProps(this);
    ajaxOfferProps(selected_props, $('.product-information').attr('data-product-id'), 1);
});


function putToCart(id, quantity, buy_btn) {

    $.ajax({
        url: '/sale/cart/put',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {id: id, quantity: quantity},
        success: function (responce) {
            if (responce['status'] === 'ok') {
                if(buy_btn !== undefined){
                    buy_btn.removeClass('buy-btn');
                    buy_btn.html('in cart');
                    buy_btn.addClass('in-cart');
                    buy_btn.attr('href', '/sale/cart');
                    buy_btn.attr('title', 'in cart');
                    $('.product-action-wrap').remove();
                }
            }
        }
    });

}

function updateLineCart(id, quantity, change_area) {
    if(quantity <= 0){
        quantity = 1;
    }

    $.ajax({
        url: '/sale/cart/update',
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {id: id, quantity: quantity},
        success: function (responce) {
            change_area.html(responce['line']);
            $('.order-total .amount').html(responce['total']);
        }
    });
}

function deleteFromCart(id, product_block) {
    $.ajax({
        url: '/sale/cart/delete',
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {id: id},
        success: function (responce) {
            if (responce['status'] === 'ok') {
                product_block.remove();
                $('.ajax-total-price').html(responce['total']);
            }
        }
    });
}

function refreshTopCart() {
    $.ajax({
        url: '/sale/cart',
        method: 'GET',
        success: function (result) {
            $('.top-cart').html(result);
        }
    });
}


$("body").on('click', '.buy-btn', function (event) {
    event.preventDefault();
    var offer_id = $(this).attr('data-id');
    var quantity = $(this).parents('.offer-block').find("input[name='quantity']").val();
    if (quantity === undefined) {
        quantity = 1;
    }
    putToCart(offer_id, quantity, $(this));

});

$("body").on('click', '.remove-from-cart', function (event) {
    event.preventDefault();

    var product_id = $(this).attr('data-id');
    var product_block = $(this).parents('.cart-line');
    deleteFromCart(product_id, product_block);

});

$("body").on('change', '.product-quantity input', function (event) {
    var product_id = $(this).attr('data-id');
    var quantity = $(this).val();
    var item_line = $(this).parents('tr');
    updateLineCart(product_id, quantity, item_line);

});


/*------------------------------------
  Shopping Cart Area
--------------------------------------*/

$('.cart__menu').on('click', function () {
    $('.shopping__cart').addClass('shopping__cart__on');
    $('.body__overlay').addClass('is-visible');
    refreshTopCart();
});

$('body').on('click', '.offsetmenu__close__btn', function () {
    $('.shopping__cart').removeClass('shopping__cart__on');
    $('.body__overlay').removeClass('is-visible');
    $('.top-cart').html('<div class="loader-gif">\n' +
        '                <img src="/storage/images/system/loader.gif" alt="">\n' +
        '            </div>');
});

$('#productModal').on('show.bs.modal', function (event) {

    var url = $(event.relatedTarget).attr('data-product-url');

    $.ajax({
            url: url,
            method: 'GET',
            success: function (modal_content) {
                $(event.currentTarget).find('.modal-body').html(modal_content);
            }
        });
});

$('#productModal').on('hidden.bs.modal', function (event) {
    $(event.currentTarget).find('.modal-body').html('<div class="loader-gif">\n' +
        '                <img style="margin: 70px" src="/storage/images/system/loader.gif" alt="">\n' +
        '            </div>');
});
