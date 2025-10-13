<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Cms\Article;
use App\Models\Cms\Author;
use App\Models\Cms\Page;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    use HasPermissions;
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    /**
     * Get the pages that belong to this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Page, User>
     */
    public function pages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        /** @var \Illuminate\Database\Eloquent\Relations\HasMany<Page, User> */
        return $this->hasMany(Page::class, 'user_id');
    }

    /**
     * Get the articles that belong to this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Article, User>
     */
    public function articles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        /** @var \Illuminate\Database\Eloquent\Relations\HasMany<Post, User> */
        return $this->hasMany(Article::class, 'user_id');
    }

    /**
     * Get the author record associated with the user (one-to-one).
     */
    public function author(): HasOne
    {
        return $this->hasOne(Author::class, 'user_id');
    }

    public function isAdmin(): bool
    {
        return $this->hasAnyRole(['super_admin', 'admin']);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    // Add relationship to Cart
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }
}
