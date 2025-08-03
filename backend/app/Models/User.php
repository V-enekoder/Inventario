<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\User
 *
 * (Aquí pueden haber otras líneas @property, etc.)
 *
 * @method bool isAdmin() // <-- ¡AÑADE ESTA LÍNEA!
 * @method bool hasRole(string $role) // Esta es la que añadimos antes
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $table = 'users';

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
        //return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function hasRole(string $role): bool
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function profiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'profile_users');
    }

    public function hasProfile(string $profile): bool
    {
        return $this->profiles()->where('name', $profile)->exists();
    }

    public function assignProfile($profileId)
    {
        $this->profiles()->syncWithoutDetaching([$profileId]);
    }

    public function revokeProfile($profileId)
    {
        $this->profiles()->detach($profileId);
    }

    /**
     * Atribui a função de administrador (role 'admin') a um usuário.
     *
     * @return void
     */
    public function assignAdminRole()
    {
        $adminRoleId = Role::where('name', 'admin')->value('id');
        $this->roles()->syncWithoutDetaching([$adminRoleId]);
    }

    /**
     * Revoga a função de administrador (role 'admin') de um usuário.
     *
     * @return void
     */
    public function revokeAdminRole()
    {
        $adminRoleId = Role::where('name', 'admin')->value('id');
        $this->roles()->detach($adminRoleId);
    }

    public function isAdmin(): bool
    {
        // El ID del rol de administrador, asumimos que es 1.
        $adminRoleId = 1;

        // Consulta directa a la tabla pivote 'role_user'.
        // El método `exists()` devuelve true si encuentra al menos una fila, false si no.
        return DB::table('role_user')
            ->where('user_id', $this->id)
            ->where('role_id', $adminRoleId)
            ->exists();
    }
}
