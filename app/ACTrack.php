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
}