<?php

namespace App\Models;

use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // <-- Eloquent Model
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements HasTenants
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function clinics(): BelongsToMany
    {
        // pivot: clinic_user (clinic_id, user_id) varsayılır
        return $this->belongsToMany(Clinic::class);
    }

    /**
     * Filament'in HasTenants sözleşmesi:
     * getTenants(Panel $panel): Collection
     */
    public function getTenants(Panel $panel): Collection
    {
        // Eager-loaded collection yerine ilişki üzerinden çekmek daha güvenli
        return $this->clinics()->get();
    }

    /**
     * Filament'in HasTenants sözleşmesi:
     * canAccessTenant(\Illuminate\Database\Eloquent\Model $tenant): bool
     */
    public function canAccessTenant(Model $tenant): bool
    {
        // $tenant bir Clinic modeli olmalı
        return $this->clinics()
            ->whereKey($tenant->getKey())
            ->exists();
        // Alternatif: return $this->clinics->contains($tenant); (koleksiyon yüklenmişse)
    }
}
