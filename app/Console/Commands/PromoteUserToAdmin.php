<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:promote-user-to-admin {email}')]
#[Description('Promote an existing user to administrator')]
class PromoteUserToAdmin extends Command
{
    public function handle(): int
    {
        $user = User::query()->where('email', $this->argument('email'))->first();

        if ($user === null) {
            $this->components->error('No user exists with that email address.');

            return self::FAILURE;
        }

        $user->update(['role' => 'admin']);

        $this->components->info("{$user->email} is now an administrator.");

        return self::SUCCESS;
    }
}
