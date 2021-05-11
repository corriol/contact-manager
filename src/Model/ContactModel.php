<?php
namespace App\Model;

use App\Core\Model;
use App\Core\Entity;
use App\Entity\Contact;
use PDO;


class ContactModel extends Model
{
    public function __construct(PDO $pdo, string $tableName = "contact", string $className = Contact::class)
    {
        parent::__construct($pdo, $tableName, $className);
    }

    public function validate(Entity $entity): array
    {
        // TODO: Implement validate() method.
    }
}