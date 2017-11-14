<?php

namespace App\Http\Controllers;
use App\ACTrack;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*
        site_logout
        site_register
        site_sso_sign_in
        */
        ACTrack::send(array(
            'event' => 'load_contact_list',
            'data' => 'listing of contacts'
        ));
        $user = Auth::user();

        $contacts = $user->contacts()
            ->whereUserId($user->id)
            ->orderBy('name', 'asc')
            ->paginate(7);

        return view('contacts')->with('contacts',$contacts);
    }
}
