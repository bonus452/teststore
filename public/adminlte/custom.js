function rolleUpOffer(offer) {
    if (!$(offer).hasClass('rolled-up')) {
        $(offer).addClass("rolled-up");
        replaceInputToText(offer);
    }
}

function rolleDownOffer(offer) {
    if ($(offer).hasClass('rolled-up')) {
        $(offer).removeClass("rolled-up");
        replaceTextToInput(offer);
    }
}

function replaceInputToText(context) {

    $(context).find(".article input").hide();
    $(context).find(".price input").hide();

    var article = $(context).find(".article input").val();
    var price = $(context).find(".price input").val();

    $(context).find(".article .text-value").html(article);
    $(context).find(".price .text-value").html(price);

    $(context).find(".article .text-value").show();
    $(context).find(".price .text-value").show();
}

function replaceTextToInput(context) {

    $(context).find(".article input").show();
    $(context).find(".price input").show();

    $(context).find(".article .text-value").hide();
    $(context).find(".price .text-value").hide();
}

function setActiveOfferBlock(offer) {
    $(".offer-block").each(function () {
        rolleUpOffer(this);
    });
    rolleDownOffer(offer);
}

function checkDeleteOfferButton() {
    if ($('.offer-block').length === 1) {
        $(".delete-btn").remove();
    } else if ($(".offer-block .delete-btn").length !== $('.offer-block').length) {
        $(".offer-block .offer-main").each(function (i, elem) {
            if ($(elem).find(".delete-btn").length === 0) {
                $(elem).append("<button class='btn btn-block btn-danger btn-sm delete-btn'>X</button>");
            }
        });
    }
}

function showErrorInPopup(text) {
    $(".error-box").html('<div class="alert alert-danger alert-dismissible dublicate-prop-error">\n' +
        '    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>\n' +
        text +
        '</div>');
}

function checkDublicateProperties(property) {
    $result = true;
    $(".offer-block:not(.rolled-up) .offer-props .prop-name").each(function (i, item) {
        if ($(item).html() === property) {
            $result = false;
            return false;
        }
    });
    return $result;
}


function setProperty(property) {
    $.ajax({
        url: "/admin/catalog/set-property",
        method: "POST",
        async: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {property_name: property},
        success: function (html){
            $(".offer-block:not(.rolled-up) .offer-props table .tr-btn-add-prop").before(html);
        }
    });
}

function setInputNamesForOffers(){
    $('.offer-block').each(function (offer_num, offer){
        $(offer).find("input.article").attr('name', 'offers['+offer_num+'][article]');
        $(offer).find("input.price").attr('name', 'offers['+offer_num+'][price]');
        $(offer).find("input.offer-id").attr('name', 'offers['+offer_num+'][id]');

        $(offer).find(".prop-tr").each(function (prop_num, prop_tr){
            var prop_id = $(prop_tr).find("input").attr('data-prop-id');
            $(prop_tr).find("input").attr('name', 'offers['+offer_num+'][properties]['+prop_id+']');
            var list_id = 'list-values'+offer_num+prop_id;
            $(prop_tr).find("input").attr('list', list_id);
            $(prop_tr).find(".list-values").attr('list', list_id);
        });
    });
}

$(document).ready(function () {
    $(".nav-treeview .nav-link, .nav-link").each(function () {
        var location2 = window.location.protocol + '//' + window.location.host + window.location.pathname;
        var link = this.href;
        if (link == location2) {
            $(this).addClass('active');
            $(this).parent().parent().parent().addClass('menu-is-opening menu-open');

        }
    });

    $(".offers-block").on("click", ".offer-block.rolled-up", function () {
        setActiveOfferBlock(this);
        return false;
    });

    $(".offers-block").on("click", ".delete-btn", function () {
        $(this).parent().parent().remove();
        checkDeleteOfferButton();
        setInputNamesForOffers();
        return false;
    });

    $(".offers-block").on("click", ".delete-btn-prop", function () {
        $(this).parent().parent().remove();
        return false;
    });

    $(".new-offer").on("click", function () {
        var prev_block = $(this).prev().clone();
        $(this).before(prev_block);

        var focus_block = $(".offer-block").last();
        setActiveOfferBlock(focus_block);
        checkDeleteOfferButton();
        setInputNamesForOffers();

        $(focus_block).find("input[type='text']").val("");
        $(focus_block).find("input[type='number']").val("");
        $(focus_block).find("input.offer-id").remove();
        $(focus_block).find(".list-values span").show();
    });

    $('body').on("click", ".btn-add-prop-popup", function () {
        var prop_name = $("#property_name").val();

        if (prop_name === '') {
            showErrorInPopup('You must select some property.');
            return;
        } else if (checkDublicateProperties(prop_name) === false) {
            showErrorInPopup('This property already exists in the offer.');
            return;
        }

        setProperty(prop_name);
        setInputNamesForOffers();

        var event = new CustomEvent('closePopup');
        document.dispatchEvent(event);

    });

    /*-------------------------------------dinamic dropdown-box----------------------*/

    $('body').on("click", ".btn-add-prop", function () {
        $(this).ekkoLightbox({
            width: 100,
            onShown: function () {
                var lightbox = this;
                document.addEventListener('closePopup', function () {
                    lightbox.close();
                });
            }
        });
    });

    $('body').on('click', 'input[list]', function (event) {
        event.preventDefault();
        var str = $(this).val();
        $('div[list=' + $(this).attr('list') + '] span').each(function (k, obj) {
            if ($(this).html().toLowerCase().indexOf(str.toLowerCase()) < 0) {
                $(this).hide();
            }
        })
        $('div[list=' + $(this).attr('list') + ']').toggle(100);
        $(this).focus();
    })

    $('body').on('blur', 'input[list]', function (event) {
        event.preventDefault();
        var list = $(this).attr('list');
        setTimeout(function () {
            $('div[list=' + list + ']').hide(100);
        }, 100);
    })

    $('body').on('click', 'div[list] span', function (event) {
        event.preventDefault();
        var list = $(this).parent().attr('list');
        var item = $(this).html();
        $('input[list=' + list + ']').val(item);
        $('div[list=' + list + ']').hide(100);
    })

    $('body').on('keyup', 'input[list]', function (event) {
        event.preventDefault();
        var list = $(this).attr('list');
        var divList = $('div[list=' + $(this).attr('list') + ']');
        if (event.which == 27) { // esc
            $(divList).hide(200);
            $(this).focus();
        } else if (event.which == 13) { // enter
            if ($('div[list=' + list + '] span:visible').length == 1) {
                var str = $('div[list=' + list + '] span:visible').html();
                $('input[list=' + list + ']').val(str);
                $('div[list=' + list + ']').hide(100);
            }
        } else if (event.which == 9) { // tab
            $('div[list]').hide();
        } else {
            $('div[list=' + list + ']').show(100);
            var str = $(this).val();
            $('div[list=' + $(this).attr('list') + '] span').each(function () {
                if ($(this).html().toLowerCase().indexOf(str.toLowerCase()) < 0) {
                    $(this).hide(200);
                } else {
                    $(this).show(200);
                }
            })
        }
    })

});
