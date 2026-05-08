<?php
declare(strict_types=1);

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Migrations\AbstractSeed;

class UsersSeed extends AbstractSeed
{
    public function run(): void
    {
        $hasher = new DefaultPasswordHasher();
        $password = $hasher->hash('password');

        $data = [
            ['id' => 1, 'email' => 'alice@example.com', 'password' => $password, 'name' => 'Alice'],
            ['id' => 2, 'email' => 'bob@example.com',   'password' => $password, 'name' => 'Bob'],
            ['id' => 3, 'email' => 'carol@example.com', 'password' => $password, 'name' => 'Carol'],
            ['id' => 4, 'email' => 'dave@example.com',  'password' => $password, 'name' => 'Dave'],
            ['id' => 5, 'email' => 'eve@example.com',   'password' => $password, 'name' => 'Eve'],
        ];

        $this->execute('TRUNCATE TABLE users RESTART IDENTITY CASCADE');
        $this->table('users')->insert($data)->saveData();
    }
}
