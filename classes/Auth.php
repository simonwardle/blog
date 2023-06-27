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
}
