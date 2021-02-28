<?php

namespace Models;

use Utilities\BasedObject;
use Utilities\SoftDelete;

/**
 * @table User
 */
class User extends BasedObject
{
    use SoftDelete;
    public $id;
    /**
     * @salted
     * @hidden
     */
    public $password;
    public $email;
    public $photo;
    public $remember_token;
    public $name="Utilisateur";
}


?>