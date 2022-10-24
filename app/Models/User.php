<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


/**
 * @OA\Schema(
 * title="User",
 * description="User model",
 *       @OA\Property(
 *           property="id",
 *           type="int"
 *       ),
 *       @OA\Property(
 *           property="name",
 *           type="string"
 *       ),
 *       @OA\Property(
 *           property="email",
 *           type="string"
 *       ),
 *       @OA\Property(
 *           property="password",
 *           type="string"
 *       ),
 * @OA\Xml( * name="User" * )
 *  )
 **/
class User extends Authenticatable
{
    use  HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
    ];

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
    /**
     * Find the user instance for the given username.
     *
     * @param  string  $username
     * @return \App\Models\User
     */
    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }
    public function files()
    {
        return $this->belongsToMany(FileSystem::class, 'user_files', 'user_id', 'file_id');
    }
    public function Clients()
    {
        return $this->hasMany(Client::class, 'user_id','id');
    }
}
