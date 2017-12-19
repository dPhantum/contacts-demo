<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use App\ACTrack;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        // Not using scopes here but they can be applied
        // as such ->setScopes(['scope1', 'scope2'])->redirect();
        // also including additional parameters use the with method:
        // ->with(['hd' => 'example.com'])->redirect();
        
        return Socialite::driver($provider)->redirect();
        
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        if (empty($provider)){
            Session::flash('error','We\'re sorry your request was not undestood');
            return view('login');
        }
        $user = Socialite::driver($provider)->user();

        // Some values that were doing nothing with currently
        //$data['expiresIn'] = $expiresIn = $user->expiresIn;
        //$data['tokenSecret'] = $user->tokenSecret;
        //$data['refreshToken'] = $refreshToken = $user->refreshToken;
        // not always provided

        ACTrack::send(array(
            'event' => 'site_sso_sign_in',
            'data' => $provider
        ));

        // All Providers
        if ($user->token)
            $data['authenticator_token'] = $user->token;
        if ($user->getId())
            $data['authenticator_user_id'] = $user->getId();
        if ($user->getNickname())
            $data['nickname'] = $user->getNickname();
        if ($user->getName())
            $data['name'] = $user->getName();
        if ($user->getEmail())
            $data['email'] = $user->getEmail();
        if ($user->getAvatar())
            $data['avatar_file'] = $user->getAvatar();
        $data['password'] = $provider;
        $data['authenticator'] = $provider;

        if (empty($data['name']) && !empty($data['nickname'])){
            $data['name'] = $data['nickname'];
        }
        if (!empty($data['email'])) {

            $data['last_login'] = date('Y-m-d H:i:s');
            // NOTE: Could also use firstOrNew() to add the email if not existing....
            $dbUser = User::where('email','=', $data['email'])->first();
            if ($dbUser && $dbUser->active){
                $dbUser->authenticator = $provider;
                $dbUser->last_login = $data['last_login'];
                $dbUser->save();
                // then update the user if found
                Auth::login($dbUser);
                $_SESSION["Authorized"]=TRUE;
            }
            else if ($dbUser && !$dbUser->active){
                Session::flash('error','Your account has been locked. Please contact support for assistance.');
                return view('auth/login');
            }
            else if (empty($dbUser)) {
                // if not found then create a guest user
                $user = User::create($data);
                Auth::login($user);
                $_SESSION["Authorized"]=TRUE;
            }
            else {
                // This should never happen, but safety nets are needed for Murphy's Law
                // time to raise a little Cain here
                Session::flash('error','We\'re sorry there were problems processing your login credentials. Please try to login again.');
                return view('auth/login');
            }


        }
        else {
            // failure to login without email
            Session::flash("error",'Minimally you need an email defined for authentication using '.ucfirst($provider).".");
            return view('auth/login');
        }


        return redirect()->intended();


    }




}
