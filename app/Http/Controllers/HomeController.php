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
        $user = Auth::user();

        ACTrack::addContact(array(
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone
        ));

        ACTrack::send(array(
            'event' => 'load_contact_list',
            'data' => 'listing of contacts'
        ));

        $contacts = $user->contacts()
            ->whereUserId($user->id)
            ->orderBy('name', 'asc')
            ->paginate(7);

        return view('contacts')->with('contacts',$contacts);
    }
}
