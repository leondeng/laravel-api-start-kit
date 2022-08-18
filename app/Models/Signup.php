<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Jobs\CheckSignupWebsite;

class Signup extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_IN_PROGRESS = 0;
    const STATUS_VERIFICATION_SENT = 1;
    const STATUS_COMPLETED = 2;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'web_site',
    ];

    protected $hidden = [
        'id',
        'user_id',
    ];

    protected $casts = [
        'web_site_unreachable' => 'bool',
    ];

    protected static function boot()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });

        static::saved(function ($model) {
            if (
                !empty($model->signup_website) &&
                $model->signup_website !== $model->getOriginal('signup_website')
            ) {
                CheckSignupWebsite::dispatch($model);
            }
        });

        parent::boot();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return $this->uuid;
    }
}
