<script type="text/javascript">
    $(document).ready(function () {
        /*-------------------------------
      19. Price Slider Active
    --------------------------------*/
        $("#slider-range").slider({
            range: true,
            min: Number($("#amount").attr('data-min-price')),
            max: Number($("#amount").attr('data-max-price')),
            values: [$("#price_min").val(), $("#price_max").val()],
            slide: function (event, ui) {
                $("#price_min").val(ui.values[0]);
                $("#price_max").val(ui.values[1]);
                $("#amount").html("$" + numberFormat(ui.values[0]) + " - $" + numberFormat(ui.values[1]));
            },
            stop: function (event, ui) {
                ajaxFilter();
            }
        });

        $("#amount").html("$" + numberFormat($("#slider-range").slider("values", 0)) +
            " - $" + numberFormat($("#slider-range").slider("values", 1)));
    });

</script>
