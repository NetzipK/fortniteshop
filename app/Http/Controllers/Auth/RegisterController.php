<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use Sichikawa\LaravelSendgridDriver\Transport\SendgridTransport;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'epic_id' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        Mail::send([], [], function (Message $message) use ($data) {
            $message
                ->to($data['email'])
                ->embedData(Sendgrid::sgEncode([
                    'personalizations' => [
                        [
                            'dynamic_template_data' => [
                                'user' => $data['name'],
                            ],
                        ],
                    ],
                    'template_id' => 'd-247d28368e5c43e69671be98a8af3b78'
                ]), SendgridTransport::SMTP_API_NAME);
        });
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'epic_id' => $data['epic_id'],
            'discord_id' => $data['discord_id'],
            'platform' => $data['platform'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
