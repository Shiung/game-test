<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
use JWTAuth;
use Socialite;
use Illuminate\Http\Request;
use Redirect;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard/admin';
    protected $redirectAfterLogout = '/dashboard/auth/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout', 'getLogout']);
        //$this->middleware('jwt.auth', ['except' => ['auth']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'name.required' => '請填寫名稱！',
            'email.required'=>'請填寫信箱！',
            'password.required'=>'請填寫密碼！',
            'password.confirmed'=>'請確認密碼！',
            'username.confirmed'=>'請填寫帳號！',
        ];

        return Validator::make($data, [
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ],$messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function getFailedLoginMessage()
    {
        return '帳號或密碼錯誤';
    }


   /* public function login(Request $request)
    {
        $messages = ['email.required'=>'請填寫信箱！','password.required'=>'請填寫密碼！'];
      
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ],$messages);

        if ($validator->fails()) {
            return redirect('dashboard/auth/login')
                        ->withErrors($validator)
                        ->withInput();

       }else{

            //先判斷有沒有密碼
            $user=User::where('email', $request->email )->first();
            if($user->password==''){
                return redirect('dashboard/auth/login')
                        ->withErrors('請用臉書登入');
            }else{
                $userdata = array(
                    'email' => $request->email,
                    'password' => $request->password
                );
                // doing login.

                if (Auth::attempt($userdata)) {
                    return Redirect::intended('/');

                }
                else{
                    // if any error send back with message.
                    return redirect('dashboard/auth/login')
                        ->withErrors('帳號或密碼錯誤');
                } 

            }

            
       }

    }

*/

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $facebookUser
     * @return User
     */
    private function findOrCreateUser($facebookUser)
    {
        //先檢查有沒有某email存在
        $user=User::where('email', $facebookUser->email)->first();

        if (!$user) {

               return User::create([
                'name' => $facebookUser->name,
                'email' => $facebookUser->email,
                'facebook_id' => $facebookUser->id,
                'avatar' => $facebookUser->avatar
            ]);
        }
        else
        {
            User::where('email', $facebookUser->email)->update(array('facebook_id' => $facebookUser->id,'avatar' => $facebookUser->avatar));
            
        }
        $new_user=User::where('facebook_id',$facebookUser->id)->first();
        return $new_user;

    }


}
