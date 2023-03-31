<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nip',
        'nama',
        'password',
        'role_id',
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
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'nip';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */

    public function getAuthIdentifier()
    {
        return $this->nip;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    // inverse one to Many ke tabel role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function findForPassport($username)
    {
        return $this->where('nip', $username)->first();
    }

    public function get_user_by_id($id)
    {
        $user = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.id', 'users.nama', 'users.nip', 'users.role_id', 'roles.role_name')
            ->where('users.id', '=', $id)
            ->first();
        return $user;
    }

    //Tambah Data User
    public function insert_datauser($data)
    {
        if (DB::table('users')->insert($data)) {
            return true;
        } else {
            return false;
        }
    }

    // Update data user
    public function update_user($data, $id)
    {
        if (DB::table('users')->where('id', $id)->update($data)) {
            return true;
        } else {
            return false;
        }
    }


    //Delete Data User
    public function delete_datauser($id)
    {
        if (DB::table('users')->where('id', $id)->delete()) {
            return true;
        } else {
            return false;
        }
    }
}
