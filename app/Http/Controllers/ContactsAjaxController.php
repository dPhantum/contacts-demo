<?php

namespace App\Http\Controllers;

use App\ACTrack;
use App\Contact;
use App\Http\Requests\ContactsRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class ContactsAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Keep the monkeys out from using ajax methods in browser
        if(!$request->ajax()){
            return view('auth/login');
        }
        $user = Auth::user();
        $input = $request->all();
        ACTrack::send(array(
            "event" => "search_contact",
            "data" => $input["target"]
        ));

        //return print_r($request,true);
        $target = str_replace(' ','%',$input["target"]);

        $contacts = $user->contacts()
            ->where('user_id', '=', $user->id)
            ->where(function($query) use ($target) {
                $query->where('name', 'LIKE', "%$target%")
                    ->orWhere('phone', 'LIKE', "%$target%")
                    ->orWhere('email', 'LIKE', "%$target%");
            })->paginate(7);

        return view('contact-list')->with('contacts',$contacts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ContactsRequest $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactsRequest $request)
    {
        $input = $request->all();
        ACTrack::send(array(
            "event" => "add_contact",
            "data" => $input["name"]
        ));

        if(!$request->ajax()){
            //return view('auth/login');
            abort(403,"That action is not permitted, go somewhere else and play!");
        }
        $user = Auth::user();

        $contact = $user->contacts()->create($request->all());

        return response()->json($contact);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContactsRequest $request, $id)
    {
        $formData = $request->all();

        ACTrack::send(array(
            "event" => "edit_contact",
            "data" => "Update of user: ".$formData["name"]
        ));

        if(!$request->ajax()){
            return view('auth/login');
        }
        $user = Auth::user();
        $contact = $user->contacts()
            ->whereUserId($user->id)
            ->whereId($id)->first()->update($formData);

        return response()->json($contact);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        ACTrack::send(array(
            "event" => "deleted_contact",
            "data" => "Delete of user: ".$id
        ));

        if(!$request->ajax()){
            return view('auth/login');
        }
        $user = Auth::user();
        $contact = $user->contacts()
            ->whereUserId($user->id)
            ->whereId($id)->first()->delete();
        return response()->json($contact);
    }
}
