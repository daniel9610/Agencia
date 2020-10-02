<?php
   
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Redirect;
use Socialite;
use Auth;
use Exception;
use App\User;
   
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
   
    use AuthenticatesUsers;
   
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
   
    public function redirectToGoogle()
    {
        $parameters = ['access_type'=>'offline'];
        return Socialite::driver('google')->scopes(["https://www.googleapis.com/auth/drive"]
        )->with($parameters)->redirect();
    }
   
    public function handleGoogleCallback()
    {
        $userLogin = Socialite::driver('google')->user();
        $user = User::updateOrCreate(
            ['email'=>$userLogin->email],
            ['refresh_token'=> $userLogin->token,
            'name' => $userLogin->name
        ]);
        Auth::login($user, true);
        return redirect()->to('/splash');
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'email';
        if(auth()->attempt(array($fieldType => $input['email'], 'password' => $input['password'])))
        {
            return Redirect::to('splash');
        }else{
            return Redirect::to('login')
                ->with('error','Usuario/Correo Electronico y/o contraseña errados.');
        }

    }

    public function logout(Request $request){
        session('g_token', '');
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}