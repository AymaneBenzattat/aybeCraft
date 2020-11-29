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
     * @column password
     */
    public $passsword;
    /**
     * @var email
     */
    /**
     * @column email
     */
    public $username;
    public $photo="default.jpg";
    public $name="Utilisateur";
    public $used_storage=0;
    public $total_storage=0;
    public $user_type="user";
}


?>