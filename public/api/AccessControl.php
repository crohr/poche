<?php
use \Luracast\Restler\iAuthenticate;
use \Luracast\Restler\Resources;

class AccessControl implements iAuthenticate
{
    public static $requires = 'user';
    public static $role = 'user';

    public function __isAllowed()
    {
        if (!isset($_GET['user_id']) 
            || !isset($_GET['key'])) {
            return false;
        }

        $dp = new DB_PDO_Sqlite();
        if (!$user_role = $dp->getApiById($_GET['user_id'], $_GET['key'])) {
            return false;
        }

        $roles = array($_GET['key'] => $user_role['value']);

        static::$role = $roles[$_GET['key']];
        Resources::$accessControlFunction = 'AccessControl::verifyAccess';
        return static::$requires == static::$role || static::$role == 'admin';
    }

    /**
     * @access private
     */
    public static function verifyAccess(array $m)
    {
        $requires =
            isset($m['class']['AccessControl']['properties']['requires'])
                ? $m['class']['AccessControl']['properties']['requires']
                : false;
        return $requires
            ? static::$role == 'admin' || static::$role == $requires
            : true;
    }
}
