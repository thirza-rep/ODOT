<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ──────────────── Permissions ────────────────

        $permissions = [
            // User Management
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',

            // Branch Management
            'branch.view',
            'branch.create',
            'branch.edit',
            'branch.delete',

            // Category Management
            'category.view',
            'category.create',
            'category.edit',
            'category.delete',

            // Product / Stock Management
            'product.view',
            'product.create',
            'product.edit',
            'product.delete',
            'stock.view',
            'stock.adjust',

            // POS / Kasir
            'pos.access',
            'pos.process_sale',
            'pos.cancel_order',

            // Reports / Statistik
            'report.view',
            'report.export',

            // Settings
            'setting.view',
            'setting.edit',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ──────────────── Roles ────────────────

        // Pemilik (Owner): Full access to everything
        $ownerRole = Role::firstOrCreate(['name' => 'pemilik']);
        $ownerRole->syncPermissions(Permission::all());

        // Admin: Full access to user management, inventory, & system config
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'user.view', 'user.create', 'user.edit', 'user.delete',
            'branch.view', 'branch.create', 'branch.edit', 'branch.delete',
            'category.view', 'category.create', 'category.edit', 'category.delete',
            'product.view', 'product.create', 'product.edit', 'product.delete',
            'stock.view', 'stock.adjust',
            'report.view', 'report.export',
            'setting.view', 'setting.edit',
        ]);

        // Kasir (Staff): POS only
        $kasirRole = Role::firstOrCreate(['name' => 'kasir']);
        $kasirRole->givePermissionTo([
            'pos.access', 'pos.process_sale', 'pos.cancel_order',
            'product.view', // Needed to see products in POS
        ]);
    }
}
