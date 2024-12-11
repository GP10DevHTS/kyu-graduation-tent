<?php

namespace App\Actions\Fortify;

use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Str;


class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $newuser = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $ceo = User::firstOrCreate([
            'email' => 'ceo@ajjitechsystems.net',
        ], [
            'name' => 'AjjiTech CEO',
            'password' => Hash::make('kalikali'),
        ]);

        $group = Group::firstOrCreate([
            'name' => 'Tent#' . date('Y'),
        ], [
            'description' => "Chat group for the class of " . date('Y'),
            'is_public' => true,
            'uuid' => (string) Str::uuid(),
            'creator_id' => $ceo->id,
        ]);

        GroupUser::create([
            'group_id' => $group->id,
            'user_id' => $newuser->id
        ]);

        return $newuser;
    }
}
