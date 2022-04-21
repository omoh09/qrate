<?php

namespace App;

// use HasApiTokens;
use App\Notifications\MailResetPasswordNotification;
use DarkGhostHunter\Laraguard\Contracts\TwoFactorAuthenticatable;
use DarkGhostHunter\Laraguard\TwoFactorAuthentication;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method static whereRole(int $int)
 * @method static where(string $string, string $string1, int $int)
 */
class User extends Authenticatable implements MustVerifyEmail ,TwoFactorAuthenticatable
{
    use HasApiTokens, Notifiable;
    use TwoFactorAuthentication;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // hidden variable
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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['referral_link'];

    /**
     * Get the user's referral link.
     *
     * @return string
     */
    public function getReferralLinkAttribute()
    {
        return $this->referral_link = route('register.api', ['ref' => $this->username]);
    }

    public function role()
    {
        return $this->belongsTo(Role::class,'role');
    }

    public function preferredCategories(){
       return $this->belongsToMany(Categories::class,'user_preferred_category','user_id','category_id');
    }

    public function artworkCategories(){
        return $this->belongsToMany(Categories::class,'artist_work_category','user_id','category_id');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token));
    }

    public function catalogue()
    {
        return $this->hasOne(Catalogue::class,'user_id');
    }

    public function followers()
    {
      return $this->belongsToMany(User::class,'follow','user_followed_id','user_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class,'follow','user_id','user_followed_id');
    }

    public function artworks()
    {
        return $this->hasMany(Artworks::class);
    }

    public function artSupplies()
    {
        return $this->hasMany(ArtSupply::class);
    }

    public function profilePicture()
    {
        return $this->morphMany(File::class,'owner');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class,'user_id')->where('bought','=',false);
    }

    public function liked()
    {
        return $this->hasMany(Likes::class,'user_id');
    }

    //TODO  make this gallery artworks
    public function artists()
    {
        return $this->belongsToMany(User::class,'featured_artists','user_id','artist_id');
    }

    public function photos()
    {
        return $this->hasOne(Photos::class,'user_id','id');
    }

    public function artworksCollection()
    {
        return $this->hasMany(Collection::class,'user_id','id');
    }

    public function checkouts()
    {
        return $this->hasMany(Checkouts::class,'user_id','id');
    }

    public function verifyTable()
    {
        return $this->hasOne(EmailVerification::class,'user_id');
    }
    
    public function exhibitions()
    {
        return $this->hasMany(Exhibition::class,'user_id','id');
    }

    public function bid()
    {
        return $this->hasMany(Bid::class,'user_id','id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class,'user_id','id');
    }

    public function deliveryAddress()
    {
        return $this->hasMany(DeliveryAddress::class,'user_id','id');
    }

    public function exhibitionsAttended()
    {
        return $this->belongsToMany(Exhibition::class,'exhibitions_users','user_id','exhibition_id');
    }

    public function exhibitionsCheckout()
    {
        return $this->hasMany(ExhibitionCheckout::class,'user_id');
    }

}
