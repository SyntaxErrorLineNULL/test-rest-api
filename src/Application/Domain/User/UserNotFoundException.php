<?php
declare(strict_types=1);

namespace App\Application\Domain\User;

use App\Application\Domain\DomainException\DomainRecordNotFoundException;

class UserNotFoundException extends DomainRecordNotFoundException
{
    public  $message = 'The user you requested does not exist.';
}
