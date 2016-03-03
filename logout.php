<?php
/**
 * Created by PhpStorm.
 * User: Justin
 * Date: 4/24/2015
 * Time: 8:48 PM
 */

session_start();
$_SESSION['loggedIn'] = false;
session_destroy();