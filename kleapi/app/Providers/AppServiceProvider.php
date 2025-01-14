<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->runningInConsole()) {
            return;
        }
    
        // Yetkiler oluşturuluyor
        $permissions = [
            'create-post',
            'edit-post',
            'delete-post',
            'view-post',
        ];
    
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    
        // Roller oluşturuluyor
        $roles = [
            'editor' => ['create-post', 'edit-post', 'delete-post', 'view-post'],
            'viewer' => ['view-post'],
        ];
    
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
    
            // Role yetkiler atanıyor
            $role->syncPermissions($rolePermissions);
        }
    }
}
