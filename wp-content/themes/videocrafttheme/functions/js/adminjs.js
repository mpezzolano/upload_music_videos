jQuery(document).ready(function ($) {
    var flip = 0;
    $('#expand_options').click(function () {
        if (flip == 0) {
            flip = 1;
            $('#of_container #of-nav').hide();
            $('#of_container #content').width(755);
            $('#of_container .group').add('#of_container .group h2').show();
            $(this).text('[-]');
        } else {
            flip = 0;
            $('#of_container #of-nav').show();
            $('#of_container #content').width(595);
            $('#of_container .group').add('#of_container .group h2').hide();
            $('#of_container .group:first').show();
            $('#of_container #of-nav li').removeClass('current');
            $('#of_container #of-nav li:first').addClass('current');
            $(this).text('[+]');
        }

    });
    $('.group').hide();
    $('.group:first').fadeIn();
    $('.group .collapsed').each(function () {
        $(this).find('input:checked').parent().parent().parent().nextAll().each(
                function () {
                    if ($(this).hasClass('last')) {
                        $(this).removeClass('hidden');
                        return false;
                    }
                    $(this).filter('.hidden').removeClass('hidden');
                });
    });
    $('.group .collapsed input:checkbox').click(unhideHidden);
    function unhideHidden() {
        if ($(this).attr('checked')) {
            $(this).parent().parent().parent().nextAll().removeClass('hidden');
        }
        else {
            $(this).parent().parent().parent().nextAll().each(
                    function () {
                        if ($(this).filter('.last').length) {
                            $(this).addClass('hidden');
                            return false;
                        }
                        $(this).addClass('hidden');
                    });
        }
    }

    $('.of-radio-img-img').click(function () {
        $(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
        $(this).addClass('of-radio-img-selected');
    });
    $('.of-radio-img-label').hide();
    $('.of-radio-img-img').show();
    $('.of-radio-img-radio').hide();
    $('#of-nav li:first').addClass('current');
    $('#of-nav li a').click(function (evt) {

        $('#of-nav li').removeClass('current');
        $(this).parent().addClass('current');
        var clicked_group = $(this).attr('href');
        $('.group').hide();
        $(clicked_group).fadeIn();
        evt.preventDefault();
    });
    if (adminobj.is_reset == 'true') {

        var reset_popup = $('#of-popup-reset');
        reset_popup.fadeIn();
        window.setTimeout(function () {
            reset_popup.fadeOut();
        }, 2000);
        //alert(response);

    }

    //Update Message popup
    $.fn.center = function () {
        this.animate({"top": ($(window).height() - this.height() - 200) / 2 + $(window).scrollTop() + "px"}, 100);
        this.css("left", 250);
        return this;
    }


    $('#of-popup-save').center();
    $('#of-popup-reset').center();
    $(window).scroll(function () {

        $('#of-popup-save').center();
        $('#of-popup-reset').center();
    });
    //AJAX Upload
    $('.image_upload_button').each(function () {

        var clickedObject = $(this);
        var clickedID = $(this).attr('id');
        new AjaxUpload(clickedID, {
            action: adminobj.ajaxurl,
            name: clickedID, // File upload name
            data: {// Additional data to send
                action: 'of_ajax_post_action',
                type: 'upload',
                data: clickedID,
                option_nonce: $('#videocraft_option_nonce').val()
            },
            autoSubmit: true, // Submit file after selection
            responseType: false,
            onChange: function (file, extension) {
            },
            onSubmit: function (file, extension) {
                clickedObject.text('Uploading'); // change button text, when user selects file	
                this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
                interval = window.setInterval(function () {
                    var text = clickedObject.text();
                    if (text.length < 13) {
                        clickedObject.text(text + '.');
                    }
                    else {
                        clickedObject.text('Uploading');
                    }
                }, 200);
            },
            onComplete: function (file, response) {
                var data = JSON.parse(response);
                window.clearInterval(interval);
                clickedObject.text('Upload Image');
                this.enable(); // enable upload button

                // If there was an error
                if (data.error) {
                    var buildReturn = '<span class="upload-error">' + data.error + '</span>';
                    $(".upload-error").remove();
                    clickedObject.parent().after(buildReturn);
                } else {
                    var buildReturn = '<img class="hide of-option-image" id="image_' + clickedID + '" src="' + data.url + '" alt="" />';
                    $(".upload-error").remove();
                    $("#image_" + clickedID).remove();
                    clickedObject.parent().after(buildReturn);
                    $('img#image_' + clickedID).fadeIn();
                    clickedObject.next('span').fadeIn();
                    clickedObject.parent().prev('input').val(data.url);
                }
            }
        });
    });
    //AJAX Remove (clear option value)
    $('.image_reset_button').click(function () {

        var clickedObject = $(this);
        var clickedID = $(this).attr('id');
        var theID = $(this).attr('title');
        var ajax_url = adminobj.ajaxurl;
        var data = {
            action: 'of_ajax_post_action',
            type: 'image_reset',
            data: theID,
            option_nonce: $('#videocraft_option_nonce').val()
        };
        $.post(ajax_url, data, function (response) {
            var image_to_remove = $('#image_' + theID);
            var button_to_hide = $('#reset_' + theID);
            image_to_remove.fadeOut(500, function () {
                $(this).remove();
            });
            button_to_hide.fadeOut();
            clickedObject.parent().prev('input').val('');
        });
        return false;
    });
    //Save everything else
    $('#ofform').submit(function () {

        function newValues() {
            var serializedValues = $("#ofform").serialize();
            return serializedValues;
        }
        $(":checkbox, :radio").click(newValues);
        $("select").change(newValues);
        $('.ajax-loading-img').fadeIn();
        var serializedReturn = newValues();
        var ajax_url = adminobj.ajaxurl;
        //var data = {data : serializedReturn};
        var data = {
            type: adminobj.ajax_type,
            action: 'of_ajax_post_action',
            data: serializedReturn,
            option_nonce: $('#videocraft_option_nonce').val()
        };
        $.post(ajax_url, data, function (response) {
            console.log(response);
            var success = $('#of-popup-save');
            var loading = $('.ajax-loading-img');
            loading.fadeOut();
            success.fadeIn();
            window.setTimeout(function () {
                success.fadeOut();
            }, 2000);
        });
        return false;
    });
});