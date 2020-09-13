<?php
/**
 * @table Users
 * @index id_user
 */
class User extends BasedObject
{
    /**
     * @column nom
     */
    public $name;
    /**
     * @salted
     */
    public $pass;
    /**
     * @type integer
     * @column mon_age
     */
    public $age;
}


?>