<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\TestSuite\Fixture\TestFixture;

class UsersFixture extends TestFixture
{
    public function init(): void
    {
        $hash = (new DefaultPasswordHasher())->hash('password');
        $this->records = [
            ['email' => 'alice@example.com', 'password' => $hash, 'name' => 'Alice', 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')],
        ];
        parent::init();
    }
}
