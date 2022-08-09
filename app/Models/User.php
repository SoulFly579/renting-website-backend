<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Jobs\QueuedVerifyEmailJob;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles,MustVerifyEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'tckn',
        'phone_number',
        'credit',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        "tckn",
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->password = Hash::make($model->password);
        });
    }

    /**
     * Override method for the queue verification mail
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        //dispactches the job to the queue passing it this User object
        QueuedVerifyEmailJob::dispatch($this);
    }

    public function products()
    {
        return $this->hasMany(Product::class,"user_id","id");
    }

    public function shopping_session()
    {
        return $this->hasOne(ShoppingSession::class,"user_id","id");
    }

    public function cart()
    {
        return $this->shopping_session()->with("cart");
    }
}
