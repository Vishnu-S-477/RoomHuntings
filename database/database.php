<?php
class database{
    public static $db_servername = 'mysql.selfmade.ninja';
    public static $db_username = 'poovarasi';
    public static $db_password = 'poovarasi@2003';
    public static $db_name;
    public static $connection = null;

    public static function connection(){
      if(self::$connection == null){
         $conn = new mysqli(self::$db_servername,self::$db_username,self::$db_password,self::$db_name);
         if($conn->connect_error){
            echo("Error in Database Connection Error: $conn->connect_error");
         }
         else{
            echo('success');
            return self::$connection = $conn;
            
         }
      }
      else{
        echo('success');
        return self::$connection;
    
      }
    }
}

?>