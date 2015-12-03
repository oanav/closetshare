pop.extend = function (el, opt) {
    for (var name in opt)
        el[name] = opt[name];
    return el;
}
pop.responsive = function (options) {
    defaults = { 'selector': '#responsive-trigger' };
    options = $.extend(defaults, options);
    if ($(options.selector).is(':visible')) {
        return true;
    }
    return false;
}
pop.toggleClass = function (element, destination, isObject) {
    var $selector = $('[' + element + ']');
    $selector.click(function (event) {
        var thatClass = $(this).attr(element);
        var thatDestination;
        if (typeof (isObject) != "undefined") {
            var thatDestination = $(destination);
        } else {
            var thatDestination = $($(this).attr(destination));
        }
        thatDestination.toggleClass(thatClass);
        event.preventDefault();
        return;
    });
}
pop.photoUploader = function (selector, options) {
    defaults = { 'max': 4 };
    options = $.extend(defaults, options);
    pop.photoUploaderActions($(selector), options);
}
pop.addPhotoUploader = function (max) {
    if (max < $('input[name="' + $(this).attr('name') + '"]').length + $('.photos_div').length) {
        var $image = $('<input type="file" name="photos[]">');
        pop.photoUploaderActions(image);
        $('#post-photos').append($image);
    }
}
pop.removePhotoUploader = function () {
    //removeAndAdd
},
        pop.photoUploaderActions = function ($element, options) {
            $element.on('change', function () {
                var input = $(this)[0];
                $(this).next('img').remove();
                $image = $('<img />');
                $image.insertAfter($element);
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $image.attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    $image.remove();
                }
            });
        }

function createPlaceHolder($element) {
    var $wrapper = $('<div class="has-placeholder ' + $element.attr('class') + '" />');
    $element.wrap($wrapper);
    var $label = $('<label/>');

    $label.append($element.attr('placeholder').replace(/^\s*/gm, ''));
    if ($element.attr('value').length > 0) {
        $label.css('display', 'none');
    }
    $element.removeAttr('placeholder');

    $element.before($label);
    $element.bind('remove', function () {
        $wrapper.remove();
    });
}

function selectUi(thatSelect) {
    var uiSelect = $('<a href="#" class="select-box-trigger"></a>');
    var uiSelectIcon = $('<span class="select-box-icon"></span>');
    var uiSelected = $('<span class="select-box-label">' + thatSelect.find("option:selected").text().replace(/^\s*/gm, '') + '</span>');
    var uiWrap = $('<div class="select-box ' + thatSelect.attr('class') + '" />');

    thatSelect.css('filter', 'alpha(opacity=40)').css('opacity', '0');
    thatSelect.wrap(uiWrap);


    uiSelect.append(uiSelected).append(uiSelectIcon);
    thatSelect.parent().append(uiSelect);
    uiSelect.click(function () {
        return false;
    });
    thatSelect.on('focus', function () {
        thatSelect.parent().addClass('select-box-focus');
    });
    thatSelect.on('blur', function () {
        thatSelect.parent().removeClass('select-box-focus');
    });
    thatSelect.change(function () {
        str = thatSelect.find('option:selected').text().replace(/^\s*/gm, '');
        uiSelected.text(str);
    });
    thatSelect.bind('removed', function () {
        thatSelect.parent().remove();
    });
}

$(document).ready(function (event) {
    //OK
    $('.r-list h1 span').click(function () {
        if (pop.responsive()) {
            var $parent = $(this).parent().parent();
            if ($parent.hasClass('active')) {
                $parent.removeClass('active');
                $(this).find('i').removeClass('fa-caret-down');
                $(this).find('i').addClass('fa-caret-right');
            } else {
                $parent.addClass('active');
                $(this).find('i').removeClass('fa-caret-right');
                $(this).find('i').addClass('fa-caret-down');
            }
            return false;
        }
    });

    //OK
    pop.toggleClass('data-bclass-toggle', 'body', true);
    //OK
    /*$('.doublebutton a').click(function (event) {
     var thisParent = $(this).parent();
     if($(this).hasClass('grid-button')){
     thisParent.addClass('active');
     $('#listing-card-list').addClass('listing-grid');
     } else {
     thisParent.removeClass('active');
     $('#listing-card-list').removeClass('listing-grid');
     }
     if (history.pushState) {
     window.history.pushState($('title').text(), $('title').text(), $(this).prop('href'));
     }
     event.preventDefault();
     return;
     });*/



    $(".opt_delete_account a").click(function () {
        confirmDelete('#dialog-delete-account', pop.base_url + '?page=user&action=delete&id=' + pop.user.id + '&secret=' + pop.user.secret);
    });

    /////// STARTS PLACE HOLDER
    $('body').on('focus', '.has-placeholder input, .has-placeholder textarea', function () {
        var placeholder = $(this).prev();
        var thatInput = $(this);

        if (thatInput.parents('.has-placeholder').not('.input-file')) {
            placeholder.hide();
        }
    });
    $('body').on('blur', '.has-placeholder input, .has-placeholder textarea', function () {
        var placeholder = $(this).prev();
        var thatInput = $(this);

        if (thatInput.parents('.has-placeholder').not('.input-file')) {
            if (thatInput.val() == '') {
                placeholder.show();
            }
        }
    });

    $('body').on('click touchstart', '.has-placeholder label', function () {
        var placeholder = $(this)
        var thatInput = $(this).parents('.has-placeholder').find('input, textarea');
        if (thatInput.attr('disabled') != 'disabled') {
            placeholder.hide();
            thatInput.focus();
        }
    });

    $('input[placeholder]').each(function () {
        createPlaceHolder($(this));
    });

    $('body').on("created", '[name^="select_"]', function (evt) {
        selectUi($(this));
    });

    $('select').each(function () {
        selectUi($(this));
    });

    $('.flashmessage .ico-close').click(function () {
        $(this).parents('.flashmessage').remove();
    });
    $('#mask_as_form select').on('change', function () {
        $('#mask_as_form').submit();
        $('#mask_as_form').submit();
    });
    $(".img-fit").imagefill();


    var offset = 250;
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > offset) {
            jQuery('.back-to-top').css({bottom: 20});
        } else {
            jQuery('.back-to-top').css({bottom: -50});
        }
    });

    jQuery('.back-to-top').click(function (event) {
        event.preventDefault();
        jQuery('html, body').animate({ scrollTop: 0 }, 500);
        return false;
    })

    if (typeof $.fancybox == 'function') {
        $("a.fancybox").fancybox({
            openEffect: 'none',
            closeEffect: 'none',
            nextEffect: 'fade',
            prevEffect: 'fade',
            loop: false,
            helpers: {
                title: {
                    type: 'inside'
                }
            },
            tpl: {
                prev: '<a title="' + pop.fancybox_prev + '" class="fancybox-nav fancybox-prev"><span></span></a>',
                next: '<a title="' + pop.fancybox_next + '" class="fancybox-nav fancybox-next"><span></span></a>',
                closeBtn: '<a title="' + pop.fancybox_closeBtn + '" class="fancybox-item fancybox-close" href="javascript:;"></a>'
            }
        });

        $(".main-photo").on('click', function (e) {
            e.preventDefault();
            $("a.fancybox").first().click();
        });
    }
    setInterval("pop_selectui_plugins()", 200);
});

function pop_selectui_plugins() {
    $('select:not(div.select-box>select)').each(function () {
        selectUi($(this));
    });
}

function formReset($form) {
    $form.find("input:text").val('');
    $form.find('input:radio, input:checkbox')
        .removeAttr('checked').removeAttr('selected');
}

function confirmDelete(dialog_id, redirect_url) {
    $(dialog_id).dialog('option', 'buttons',
            [
               {
                   text: pop.langs.delete,
                   click: function () {
                       window.location = redirect_url;// pop.base_url + '?page=user&action=delete&id=' + pop.user.id  + '&secret=' + pop.user.secret;
                   }
               },
               {
                   text: pop.langs.cancel,
                   click: function () {
                       $(this).dialog("close");
                   }
               }
            ]
       );
    $(dialog_id).dialog('open');
}