<?php
/**
 * Created by PhpStorm.
 * User: paul
 * Date: 11/14/17
 * Time: 6:39 AM
 */

namespace App;

use Illuminate\Support\Facades\Auth;

class ACTrack
{

    const ACTIVECAMPAIGN_URL = "https://bigbrightideas.activehosted.com.api-us1.com";
    const ACTIVECAMPAIGN_API_KEY = "796fb723506a9865650f63e96a4b2bd24fb8e4c9";
    const TRACK_ACTID = "649208955";
    const TRACK_KEY = "796fb723506a9865650f63e96a4b2bd24fb8e4c9";
    const CONTACTS_API_KEY = "853389282679f60b2aa2280d2fd09b158f6bcf9b709b25878d31c9144d306ba1f2586e7c";
    const CONTACTS_URL ="https://bigbrightideas.api-us1.com";
    /**
     * Used to send tracking events to ActiveCampaign
     * @param array $log
     * @return bool
     * Events to track:
     *      add_contact
     *      add_contact_option
     *      delete_contact_option
     *      deleted_contact
     *      edit_contact
     *      edit_contact_option
     *      search_contact
     *      site_logout
     *      site_register
     *      site_sso_sign_in
     *
     * @example:
     *      ACTrack::send(array(
     *          'event' => 'add_contact_option',
     *          'data' => 'Some meaningful data here'
     *      ));
     */

    public static function send($log = array()){

        if (empty($log))
            return false;
        try {

            if (Auth::check()){
                $user = Auth::user();
                $user->events()->create($log);
                $email = Auth::user()->email;
            }
            else
                $email ='';

            $ac = new \ActiveCampaign(self::ACTIVECAMPAIGN_URL, self::ACTIVECAMPAIGN_API_KEY);

            $ac->track_actid = self::TRACK_ACTID;
            $ac->track_key = self::TRACK_KEY;

            $ac->track_email = $email;
            $data = array(
                "event" => $log["event"], // "abandoned_cart", etc.
                "eventdata" => $log["data"]
            );
            $response = $ac->api("tracking/log", $data);

            if (!$response->success) {
                error_log("ACTIVE CAMPAIGN ERROR: " . print_r($response, true));
                return false;
            }
            error_log("AC LOG: ".print_r($response,true));
        }
        catch (Exception $e){
            error_log("AC ERROR: ".$e->getMessage());
            return false;
        }
        return true;

    }


    public static function addContact($contact = array()){
        // By default, this sample code is designed to get the result from your ActiveCampaign installation and print out the result
        $url = self::CONTACTS_URL;

        $nameSplit = explode(" ", $contact["name"]);

        if (count($nameSplit)==3) {
            $contact["first_name"] = $nameSplit[0];
            $contact["last_name"] = $nameSplit[2];
        }
        else if (count($nameSplit)==2){
            $contact["first_name"] = $nameSplit[0];
            $contact["last_name"] = $nameSplit[1];
        }
        else {
            $contact["first_name"] = $nameSplit[0];
            if (!empty($nameSplit[1]))
                $contact["last_name"] = $nameSplit[1];
            else
                $contact["last_name"]='';
        }

        $params = array(

            // the API Key can be found on the "Your Settings" page under the "API" tab.
            // replace this with your API Key
            'api_key'      => self::CONTACTS_API_KEY,

            // this is the action that adds a contact
            'api_action'   => 'contact_sync',

            'api_output'   => 'json',
        );

        // here we define the data we are posting in order to perform an update
        $post = array(
            'email'                    => $contact['email'],
            'first_name'               => $contact['first_name'],
            'last_name'                => $contact['last_name'],
            //'ip4'                    => '127.0.0.1',
            'phone'                    => $contact['phone'],
            'orgname'                  => '',
            'tags'                     => 'api',

            // use the folowing only if status=1
            'instantresponders[123]' => 0, // set to 0 to if you don't want to sent instant autoresponders
        );

        // This section takes the input fields and converts them to the proper format
        $query = "";
        foreach( $params as $key => $value )
            $query .= urlencode($key) . '=' . urlencode($value) . '&';
        $query = rtrim($query, '& ');

        // This section takes the input data and converts it to the proper format
        $data = "";
        foreach( $post as $key => $value )
            $data .= urlencode($key) . '=' . urlencode($value) . '&';
        $data = rtrim($data, '& ');

        // clean up the url
        $url = rtrim($url, '/ ');

        // This sample code uses the CURL library for php to establish a connection,
        // submit your request, and show (print out) the response.
        if ( !function_exists('curl_init') ) {
            error_log('Error: ActiveCampain Contact create fail: '.
                (print_r($contact,true)));
            return false;
            //die('CURL not supported. (introduced in PHP 4.0.2)');
        }
        // If JSON is used, check if json_decode is present (PHP 5.2.0+)
        if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
            //die('JSON not supported. (introduced in PHP 5.2.0)');
            error_log('Error: ActiveCampain Contact missing Curl functionality: '.
                (print_r($contact,true)));
            return false;
        }

        // define a final API request - GET
        $api = $url . '/admin/api.php?' . $query;

        $request = curl_init($api); // initiate curl object
        curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
        curl_setopt($request, CURLOPT_POSTFIELDS, $data); // use HTTP POST to send form data
        //curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
        curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

        $response = (string)curl_exec($request); // execute curl post and store results in $response

        // additional options may be required depending upon your server configuration
        // you can find documentation on curl options at http://www.php.net/curl_setopt
        curl_close($request); // close curl object

        if ( !$response ) {
            //die('Nothing was returned. Do you have a connection to Email Marketing server?');
            error_log('Error: ActiveCampain Contact bad response: '.(print_r($contact,true)).
                " ".print_r(json_decode($response),true));
            return false;
        }

        // This line takes the response and breaks it into an array using:
        // JSON decoder
        // $result = json_decode($response);

        return true;
    }
}