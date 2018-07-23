<?php
use Illuminate\Support\Facades\Input;

/*
    |--------------------------------------------------------------------------
    |  忘記密碼、登入、簡訊認證
    |--------------------------------------------------------------------------        
*/
/*登入*/
Route::group(['prefix' => '/auth','middleware'=> ['web.status']], function() {
    //使用者規章
    Route::get('/agreement', ['as' => 'front.login.agreement','uses'=>'Front\AuthController@agreement']);
    
    Route::get('/login', ['as' => 'front.login.index','uses'=>'Front\AuthController@getLogin']);
    Route::post('/login', ['as' => 'front.login.process','uses'=>'Front\AuthController@login']);

    //登出
    Route::get('/logout', ['as' => 'front.logout.process','uses'=>'Front\AuthController@logout']);

    //忘記密碼
    Route::get('/forget-password', ['as' => 'front.forget-password.index','uses'=>'Front\AuthController@forgetPwdIndex']);
    Route::post('/forget-password', ['as' => 'front.forget-password.process','uses'=>'Front\AuthController@forgetPwdProcess']);

});

/*取得登入驗證碼*/
Route::get('/get_captcha/{config?}', function (\Mews\Captcha\Captcha $captcha, $config = 'default') {
    return $captcha->src($config);
});