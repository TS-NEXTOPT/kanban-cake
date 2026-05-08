<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\IdentityInterface as AuthnIdentityInterface;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Authorization\AuthorizationServiceInterface;
use Authorization\IdentityInterface as AuthIdentityInterface;
use Authorization\Policy\ResultInterface;
use Cake\ORM\Entity;

class User extends Entity implements AuthIdentityInterface, AuthnIdentityInterface
{
    protected array $_accessible = [
        'email' => true,
        'password' => true,
        'name' => true,
        'created' => true,
        'modified' => true,
    ];

    protected array $_hidden = ['password'];

    protected ?AuthorizationServiceInterface $authorization = null;

    protected function _setPassword(string $password): ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
        return null;
    }

    public function can(string $action, mixed $resource): bool
    {
        return $this->authorization->can($this, $action, $resource);
    }

    public function canResult(string $action, mixed $resource): ResultInterface
    {
        return $this->authorization->canResult($this, $action, $resource);
    }

    public function applyScope(string $action, mixed $resource, mixed ...$optionalArgs): mixed
    {
        return $this->authorization->applyScope($this, $action, $resource, ...$optionalArgs);
    }

    public function getOriginalData(): \ArrayAccess|array
    {
        return $this;
    }

    public function setAuthorization(AuthorizationServiceInterface $service): static
    {
        $this->authorization = $service;
        return $this;
    }

    public function getIdentifier(): int
    {
        return $this->id;
    }
}
