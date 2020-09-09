<?php
    class Compact
    {

        public static function test($id,$cat,$user)
        {
            echo "id: ".$id.", cat: ".$cat.", user: ".$user;
        }

        public static function test2($id)
        {
            echo "id: ".$id;
            echo "<br><form method='POST' action='../form/777'><input type='text' name='lol'><input type='submit'></form>";
        }

        public static function test3($id)
        {
            echo "id: ".$id.", post=".$_POST["lol"];
        }
        
    }
?>