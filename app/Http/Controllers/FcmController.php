<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class FcmController extends Controller
{
    public function saveToken(Request $request){
        $existing = DB::select('select token from fcm_tokens where user_id = ?', [$request['id']]);
        if(empty($existing)){
            DB::insert('insert into fcm_tokens (token, user_id) values (?, ?)', [$request['token'], $request['id']]);
        }else{
            DB::update('update fcm_tokens set token = ? where user_id = ?', [$request['token'], $request['id']]);
        }

    }

    public function deleteToken(Request $request){
        DB::delete('delete from fcm_tokens where user_id = ?', [$request['id']]);
    }

    public function sendNotificationToEmployer($job){
        $title = "Nova prijava na posao ";
        $body = "Ukupni broj prijavljenih: ".count($job->applications);
        $token = DB::select('select token from fcm_tokens where user_id = ?',[$job->user_id]);
        $this->sendNotificationToAll($token[0]->token,$title,$body,$job,"to","employer");

    }

    public function getAllTokens(){
        $tokens = DB::select('select token from fcm_tokens');
        $arr = [];

        foreach($tokens as $token){
            array_push($arr,$token->token);
        }
        return $arr;
    }

    public function sendNotificationToAll($tokens,$title,$body,$jobData,$keyWord = "registration_ids",$type = "student"){

    define( 'API_ACCESS_KEY', 'AAAAHlz__l0:APA91bER9gvnn9ACc3gZEWNkyNs9vBIdFOAwtbKRC58QDfHFAHCwsXH1CxEI3RUSoMbLAMdtZoD9X3JcB99gQbWse8KgyWSEqAgfPZot3dqj6iQhGAZePd0VXRCaxNELpRVnmdmgjwk0' );
    $data = array($keyWord => $tokens, "notification" => array( "title" => $title, "body" => $body,"job" => $jobData, "type"=>$type),
                                        "data"=> array( "title" => $title, "body" => $body, "job" =>$jobData, "type"=>$type));

    $data_string = json_encode($data,JSON_UNESCAPED_UNICODE);
    //echo "The Json Data : ".$data_string;
    $headers = array ( 'Authorization: key=' . API_ACCESS_KEY, 'Content-Type: application/json' );
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, $data_string);
    $result = curl_exec($ch);
    curl_close ($ch);
    //echo "The Result : ".$result;
    }
}
