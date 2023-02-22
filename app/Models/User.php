<?php

namespace App\Models;

use App\Libraries\Ultilities;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
//    protected $fillable = [
//        'name',
//        'email',
//        'password',
//        'code'
//    ];
    protected $guarded = [];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUserByEmail($email)
    {
        return $this->where('email', Ultilities::clearXSS($email))->first();
    }

    public function createNewUser($request)
    {
        try {
            DB::beginTransaction();
            $data = [
              'email' => Ultilities::clearXSS($request->email),
              'password' => bcrypt(Ultilities::clearXSS($request->password)),
            ];

            $newUser = $this->create($data);
            DB::commit();
            return $newUser;
        } catch (\Exception $ex) {
            DB::rollBack();
            return $ex;
        }
    }

    public function updateUserCode($code)
    {
//        $code = 1111;
        $data = [
            'code' => bcrypt($code),
            'sent_at' => date('Y-m-d H:i:s')
        ];

        return $this->update($data);
    }
}
