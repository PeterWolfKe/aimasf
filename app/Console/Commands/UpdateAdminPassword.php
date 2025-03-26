<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UpdateAdminPassword extends Command
{
    protected $signature = 'admin:update-password {password}';
    protected $description = 'Update the password for admin@admin.com';

    public function handle()
    {
        $newPassword = $this->argument('password');

        $updated = DB::table('users')
            ->where('email', 'admin@admin.com')
            ->update(['password' => Hash::make($newPassword)]);

        if ($updated) {
            $this->info('Admin password updated successfully.');
        } else {
            $this->error('Failed to update admin password.');
        }
    }
}
