
function ajaxFilter(){
    $(".loading-mask").show();
    var filter_inputs = $("#product_filter").serialize();
    $.ajax({
        url: $("#product_filter").attr('action'),
        method: 'GET',
        data: filter_inputs,
        success: function (result){
            $('#catalog-section').html(result);
            $(".loading-mask").hide();

            var urlPath = $("#product_filter").attr('action') + "?" + filter_inputs;
            window.history.pushState({},"", urlPath);
        }
    });
}

function markPropertySelected(property){
    $(property).parent().parent().find('a.selected').removeClass('selected');
    $(property).addClass('selected');
}

function collectSelectedProps(clicked_a){
    markPropertySelected(clicked_a);
    var selected_props = {};

    $('.offers-props ul').each(function ($num, $obj) {
        var property_id = $($obj).attr('data-property-id');
        var value_id = $($obj).find('a.selected').attr('data-value-id');
        selected_props[property_id] = value_id;
    });
    return selected_props;
}

function ajaxOfferProps(props, url){

    console.log(props);

    $.ajax({
        url: url,
        method: 'GET',
        data: {offer_properties: props},
        success: function (result){
            $('.ajax-skin').html(result);
        }
    });
}

$('body').on('change', 'ul.sidebar__list input', function() {
    ajaxFilter();
});

$('body').on('click', '#send-filter', function(e) {
    e.preventDefault();
    ajaxFilter();
});


$('body').on('click', '.offers-props li a.active', function(e) {
    e.preventDefault();
    var selected_props = collectSelectedProps(this);
    ajaxOfferProps(selected_props, $('.offers-props').attr('data-ajax-url'));
});
