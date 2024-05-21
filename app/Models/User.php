<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'active' => 'boolean',
        ];
    }

    /*
    @var int $id
    @var bool $active
    @return array<string, mixed>
    */
    public static function updateActive(int $id, bool $active = false): array
    {
        $user = User::find($id);
        $exists = $user instanceof User;
        $updated = false;
        if ($exists) {
            if ($active !== $user->active) {
                $user->active = $active;
                $user->save();
                $updated = true;
            }
        }
        $result = ['id' => $id, 'updated' => $updated, 'exists' => $exists];
        if ($exists) {
            $result['user'] = $user;
        }
        return $result;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

}
