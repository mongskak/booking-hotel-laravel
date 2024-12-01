<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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
        ];
    }
    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }
    public function employeeInfo()
    {
        $employee = $this->employee; // Mengambil relasi Employee yang sudah didefinisikan

        if (!$employee) {
            return null;
        }

        return (object) [
            'name' => $employee->name,
            'email' => $this->email, // Email dari User
            'role' => $employee->role,
        ];
    }

    public function hasRole()
    {
        $employee = $this->employee;
        // dd($employee)
        return (object)[
            'hasManager' => $employee->role == 'manager',
            'hasStaf' => $employee->role == 'staf'
        ];
    }
}
