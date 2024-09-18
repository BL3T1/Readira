<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Report;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phoneNumber',
        'description',
        'profilePhoto',
        'active',
        'wallet',
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
        'password' => 'hashed',
    ];
        // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function favorites(): BelongsToMany
    {
        return $this -> belongsToMany(User::class, 'favorites');
    }
    public function comments(): HasMany
    {
        return $this -> hasMany(Comment::class);
    }
    public function progress(): BelongsToMany
    {
        return $this -> belongsToMany(Progress::class);
    }
    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class, 'collection_users');
    }
    public function books(): HasMany
    {
        return $this -> hasMany(Book::class);
    }
    public function rates(): HasMany
    {
        return $this->hasMany(Rate::class);
    }

    public function  reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function like(): HasMany
    {
        return $this -> hasMany(Like::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(BookMark::class);
    }
}
