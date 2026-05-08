<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TagsFixture
 */
class TagsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            ['name' => 'bug', 'created' => date('Y-m-d H:i:s')],
            ['name' => 'feature', 'created' => date('Y-m-d H:i:s')],
        ];
        parent::init();
    }
}
