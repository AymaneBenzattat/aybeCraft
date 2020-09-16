<?php
/**
 * @index id_user
 * @table Users
 */
class User extends BasedObject
{
    /**
     * @column user_id
     */
    public $id;
    /**
     * @column username
     */
    public $name;
    /**
     * @salted
     * @column password
     */
    public $pass;
    /**
     * @var number
     * @column mon_age
     * @not null
     */
    public $age=13;
}


?>