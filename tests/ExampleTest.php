<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;

class ExampleTest extends TestCase
{
    //停用中介層
    use WithoutMiddleware;

    //在特定函式裡停用中介層： $this->withoutMiddleware();
   
    /**
     * 點擊<a>是否進入正確頁面
     *
     * @return void
     */
    public function testClickAndShowPage()
    {
        $this->visit('/')
             ->click('注册 Register')
             ->seePageIs('/auth/register');
    }

    /**
     * 表單打字&按下確認，是否出現正確文字
     *
     * select($value, $elementName) 選單
     * check($elementName) 勾選
     * attach($pathToFile, $elementName) 附加檔案
     * @return void
     */
    public function testFormSubmit()
    {
        $this->visit('/')
             ->type('admin', 'username')
             ->press('登入')
             ->see('请填写密码')
             ->see('请填写验证码');
    }

    /**
     * 測試json文字
     *
     * seeJsonEquals  完全匹配
     * @return void
     */
    public function testJsonText()
    {
        $this->visit('/json')
             ->seeJson([
                 'name' => 'Amy',
             ]);
    }

    /**
     * 指定登入某使用者
     *
     * 帶上session： withSession(['foo' => 'bar'])
     * @return void
     */
    public function testWithUser()
    {
        $user = User::find(59);
        $this->actingAs($user)
             ->visit('/member-center')
             ->see($user->name);
    }
}
