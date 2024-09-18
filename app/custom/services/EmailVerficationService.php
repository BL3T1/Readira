<?php


namespace App\Custom\Services;

use App\Models\User;
use Illuminate\Support\str;
use App\Models\EmailVerficationToken;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EmailVerficationNotification;

 class EmailVerficationService
{
   /**
   * send verfication link to the user
   */

     public function sendVerficationLink(object $user): void
    {
     
    Notification::send($user, new EmailVerficationNotification($this->generateVerficationLink($user->email)));
    }

    /**
     * Resen link with token
     */

     public function resendLink($email){
        $user = User::where('email',$email)->first();
        if($user){
           $this->sendVerficationLink($user);
           return response()->json([
            'status'=>'success',
            'message'=>'verfication linl sent successfully',
           ],200);
        }else{
            return response()->json([
                'status'=>'failed',
                'message'=>'user not found',
            ],404);
        }
     }

   /**
    * check if user has already been verfied
    */
    public function checkIfEmailIsVerified($user)
    {
        if($user->email_verfied_at){
           response()->json([
            'status'=>'failed',
            'message'=>'email has already been verfied',

           ])->send();
           exit;
        }
    }

    /**
     * verify user email
     */
    public function verifyEmail(string $email,string $token){
        $user = User::where('email',$email)->first();
        if(!$user){
            response()->json([
                'status'=>'failed',
                'message'=>'the user not found'
            ])->send();
            exit;
        }
        $this->checkIfEmailIsVerified($user);
        $verifiedToken = $this->verifyToken($email,$token);
        if($user->markEmailAsVerified()){
            $verifiedToken->delete();
            return response()->json([
                'status'=>'success',
                'message'=>'email has been verified successfully',
            ]);
        }else{
          return response()->json([
            'status'=>'failed',
            'message'=>'email verfication failed,please try again later',
          ]);
        }
    }


  /**
   * verify token
   */
   public function verifyToken(string $email,string $token){
    $token = EmailVerficationToken::where('email',$email)->where('token',$token)->first();
    if($token){
      if($token->expired_at>=now()){
        return $token;
      }else{
        $token->delete();
        response()->json([
            'status'=>'failed',
            'message'=>'Token expired',
        ])->send();
        exit;
        }
    }else{
        response()->json([
            'status'=>'faild',
            'message'=>'Invalid token'
        ])->send();
        exit;
    }
   }


    /**
     * generate verfication link
     */

    public function generateVerficationLink(string $email): string
     {
         
         $checkIfTokenExists = EmailVerficationToken::where('email', $email)->first();
         if($checkIfTokenExists) {$checkIfTokenExists->delete();}
         $token = Str::uuid();
         $url = config('app.url'). "?token=".$token . "&email=".$email;
         $saveToken = EmailVerficationToken::create([
             "email"=>$email,
             "token"=>$token,
             "expired_at"=> now()->addMinutes(60),
            ]);
            if($saveToken){
                return $url;
            }
    
     }






}