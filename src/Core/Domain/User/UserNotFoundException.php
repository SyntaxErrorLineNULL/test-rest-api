<?php
declare(strict_types=1);

namespace App\Core\Domain\User;

use App\Core\Domain\DomainException\DomainRecordNotFoundException;

class UserNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The user you requested does not exist.';
}
