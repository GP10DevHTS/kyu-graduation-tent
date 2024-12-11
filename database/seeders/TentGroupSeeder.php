<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class TentGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groupName = "Tent#" . date('Y');

        // Create or fetch the CEO user
        $creator = User::firstOrCreate(
            ['email' => 'ceo@ajjitechsystems.net'],
            [
                'name' => 'AjjiTech CEO',
                'password' => Hash::make('kalikali'),
            ]
        );

        // Create or fetch the group
        $group = Group::firstOrCreate([
            'name' => $groupName,
        ], [
            'description' => "Chat group for the class of " . date('Y'),
            'is_public' => true,
            'creator_id' => $creator->id,
            'uuid' => (string) Str::uuid(),
        ]);

        // Get all users created this year
        $currentYear = date('Y');
        $users = User::whereYear('created_at', $currentYear)->get();

        // Attach users to the group
        $users->each(function ($user) use ($group) {
            GroupUser::firstOrCreate([
                'group_id' => $group->id,
                'user_id' => $user->id
            ]);
        });
    }
}
