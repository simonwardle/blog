<?php


/**
 * Auth
 * 
 * Login and logout
 */
class Auth
{
    /**
     * Returns the user authentication status
     *
     * @return boolean True if the user is logged in, false otherwise
     */
    public static function isLoggedIn()
    {
        return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
    }

    /**
     * Requires user to be logged in, stopping with Not authorized message
     *
     * @return void
     */
    public static function requiresLogin()
    {
        if (!static::isLoggedIn()) {
            die('Not authorized!');
        }
    }

    /**
     * login using the session
     *
     * @return void
     */
    public static function login()
    {
        session_regenerate_id(true);

        $_SESSION['is_logged_in'] = true;
    }
    
    /**
     * logout using the session
     *
     * @return void
     */
    public static function logout()
    {
        $_SESSION = array();
        
        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
    }
}
