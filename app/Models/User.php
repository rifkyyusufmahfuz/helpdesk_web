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
        'username',
        'password',
        'id_role',
        'nip',
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
        return 'username';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */

    public function getAuthIdentifier()
    {
        return $this->username;
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
        return $this->belongsTo(RoleModel::class, 'id_role');
    }

    public function pegawai()
    {
        return $this->belongsTo(PegawaiModel::class, 'nip');
    }

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    public function get_user_by_id($id)
    {
        $user = DB::table('users')
            ->join('roles', 'users.id_role', '=', 'roles.id_role')
            ->select('users.id', 'users.nama', 'users.nip', 'users.id_role', 'roles.nama_role')
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
