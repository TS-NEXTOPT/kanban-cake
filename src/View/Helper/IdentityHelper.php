<?php
declare(strict_types=1);

namespace App\View\Helper;

use Authentication\View\Helper\IdentityHelper as BaseIdentityHelper;

class IdentityHelper extends BaseIdentityHelper
{
    public function can(string $action, mixed $resource): bool
    {
        if ($this->_identity === null) {
            return false;
        }

        return $this->_identity->can($action, $resource);
    }
}
