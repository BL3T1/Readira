<?php

namespace App\Http\Controllers\Api\Auth;

use App\Custom\Services\EmailVerficationService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ActivationRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Requests\Auth\ResendEmailVerficationLinkRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\verifyEmailRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
   public function __construct(private EmailVerficationService $service){}

/**
 * admin login method
 */
  public function login_Admin(LoginRequest $request){
   if($request->email == 'admin@gmail.com'){
    $token = auth()->attempt($request->validated());
    if($token){
        return $this->responseWithToken($token,auth()->user());
    }
    else{
        return response()->json([
            'status'=>'failed',
            'message'=>'Invalid credentials',
        ],401);
    }
   }else{
    return response()->json([
        'status'=>'failed',
        'message'=>'you are not allowed to login as admin'
    ],401);
   }
  }


/**
 * login method
 */
  public function login(LoginRequest $request){
    $token = auth()->attempt($request->validated());
    if($token){
        return $this->responseWithToken($token,auth()->user());
    }else{
        return response()->json([
            'status'=>'failed',
            'message'=>'Invalid credentials',
        ],401);
    }
  }
  /**
   * resend verfication link
   */
    public function resendEmailVerficationLink(ResendEmailVerficationLinkRequest $request){
        return $this->service->resendLink($request->email);
    }
  /**
   * verfiy user email
   */
  public function verifyUserEmail(verifyEmailRequest $request){
    return $this->service->verifyEmail($request->email,$request->token);
  }
 /**
     * register method
     *
     */
 public function register(RegistrationRequest $request)
{
    if ($request->has('profilePhoto')) {
        $fileName = time() . rand(1111, 111111) . '.' . $request->profilePhoto->extension();
        ($request->profilePhoto)->move(public_path() . '/storage/user/photo', $fileName);
        $imagePaht =  $fileName;

    }
   $user = User::create([
    'profilePhoto' => $imagePaht,
    'name'=>$request->name,
    'email'=>$request->email,
    'phoneNumber'=>$request->phoneNumber,
    'password'=>$request->password,
    'description'=>$request->description,
   ]);

   if($user){
   // $this->service->sendVerficationLink($user);
    $token = auth()->login($user);
    return $this->responseWithToken($token,$user);
   }else{
    return response()->json([
        'status'=>'failed',
        'message'=>'An error occure while trying to create user',
    ],500);
   }

}
 /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);

    }


    public function blockUser(ActivationRequest $request)
    {

        $users=user::find($request->user_id);
        if(!$users){
            return response()->json([
                'message'=>'the user not found'
                ],404);
        }

        if($users){
            if($users->active==true){
            $users->active=false;
            $users->save();
            return response()->json([
                'status'=>'success',
                'message'=>'the user has blocked',
                'user status'=>$users->active,
            ],201);

            }else{
            $users->active=true;
            $users->save();
            return response()->json([
                'status'=>'success',
                'message'=>'the user has Unblocked',
                'user status'=>$users->active,
            ],201);

            }
        }
    }
 /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        $users= Auth::user()->with('book')->first();
        return response()->json([
            'message'=>'success',
            'profile'=>$users,

        ]);
    }

    public function findUser(Request $request){

        $user = User::With('book')->find($request->id);
        return response()->json([
            'user'=>$user
        ]);
    }


    public function resetPassword(ResetPasswordRequest $request){
    $user= User::where('email',$request->email)->first();
       //$this->service->sendVerficationLink($user);
       if($user){
        $user->password=$request->new_password;
        $user->save();
        $token = Auth()->Login($user);
        return $this->responseWithToken($token,$user);
       }else{
        return response()->json([
            'status'=>'failed',
            'message'=>'An error occure while trying to reset password',
        ],500);

       }
    }


    public function responseWithToken($token,$user)
{
    return response()->json([
        'status'=>'success',
        'user'=>$user,
        'userPhoto'=>$user->profilePhoto,
        'access_token'=>$token,
        'expires_in' => auth()->factory()->getTTL() * 60*60,
        'type'=>'bearer',
    ]);
}


// public function test(Request $request){
//     $book = Book::where('id',$request->id);
//     $author = $book->author->name;
//     return response()->json([
//     'book'=>'gfghgfhf',
//     ]);

// }
}
