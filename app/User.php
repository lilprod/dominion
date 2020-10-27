<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use App\Order;
use App\Payment;
use App\Delivery;
use App\Alert;
use App\Notification;

class User extends Authenticatable
{
    use HasRoles,Notifiable,HasApiTokens;

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','firstname','phone_number','username', 'address', 'profile_picture','role_id', 'firebase_token','lang','is_activated','code',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::needsRehash($password) ? Hash::make($password) : $password;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function alerts()
    {
        return Alert::where('receiver_id', $this->id)->get();
    }

    

    public function orders()
    {
      return $this->hasMany(Order::class);
    }

    public function mynotifications()
    {
        return Notification::where('receiver_id', $this->id)
                            ->where('status', 0)
                            ->orderBy('id', 'DESC')
                            ->get();
    }

    public function myunreadnotifications()
    {
        return Notification::where('receiver_id', $this->id)
                            ->where('status', 1)
                            ->orderBy('id', 'DESC')
                            ->get();
    }

    public function mypendingorders()
    {
        return Order::where('client_userid', $this->id)
                     ->whereNotIn('status', array(2))
                     ->orderBy('id', 'DESC')
                     ->get();
    }

    public function myorders()
    {
        return Order::where('client_userid', $this->id)
                     ->where('status', 2)
                     ->orderBy('id', 'DESC')
                     ->get();
    }

    public function orderstopay()
    {
        return Order::where('client_userid', $this->id)
                     ->where('status', 1)
                     ->orderBy('id', 'DESC')
                     ->get();
    }

    public function pendingorders()
    {
        return Order::where('collector_userid', $this->id)
                     ->where('status', 1)
                     ->orderBy('id', 'DESC')
                     ->get();
    }

    public function mycollectorders()
    {
        return Order::where('collector_userid', $this->id)
                      ->where('status', 2)
                      ->orderBy('id', 'DESC')
                      ->get();
    }

    public function payments()
    {
      return $this->hasMany(Payment::class);
    }

    public function mypayments()
    {
        return Payment::where('client_userid', $this->id)
                        ->orderBy('id', 'DESC')
                        ->get();
    }

    public function deliveries()
    {
      return $this->hasMany(Delivery::class);
    }

    public function mydeliveries()
    {
      return Delivery::where('client_userid', $this->id)
                     ->where('status', 1)
                     ->orderBy('id', 'DESC')
                     ->get();
    }

    public function mypendingdeliveries()
    {
      return Delivery::where('client_userid', $this->id)
                       ->where('status', 0)
                       ->orderBy('id', 'DESC')
                       ->get();
    }

    public function pendingdeliveries()
    {
        return Delivery::where('collector_userid', $this->id)
                     ->where('status', 0)
                     ->orderBy('id', 'DESC')
                     ->get();
    }

    public function mycloseddeliveries()
    {
      return Delivery::where('collector_userid', $this->id)
                      ->where('status', 1)
                      ->orderBy('id', 'DESC')
                      ->get();
    }
}
