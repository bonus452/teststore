
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

$('body').on('change', 'ul.sidebar__list input', function() {
    ajaxFilter();
});

$('body').on('click', '#send-filter', function(e) {
    e.preventDefault();
    ajaxFilter();
});


