
//refresh captcha
function refreshCaptcha(img,config,captcha) {
    $.ajax({
        method: 'GET',
        url: APP_URL +  '/get_captcha/' + config,
    }).done(function (response) {
        img.prop('src', response);
        captcha.val('')
    });
 
}