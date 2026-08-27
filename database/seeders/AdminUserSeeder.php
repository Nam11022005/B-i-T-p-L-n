<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AdminUserSeeder extends Seeder
{
public function run(): void
{
// Sử dụng updateOrCreate để tránh lỗi trùng lặp khi chạy lệnh seed nhiều lần
User::updateOrCreate(
['email' => 'admin@gmail.com'],
[
'name' => 'Admin User',
'password' => Hash::make('admin123'),
'role' => 'admin',
'email_verified_at' => now(),
]
);
}
}