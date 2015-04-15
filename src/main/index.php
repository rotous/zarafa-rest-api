<?php
/**
 * This file serves as the main entry point of the API. All request will be redirected to this script.
 * The script will start the API app and pass control to the app controller.
 */

 // Define some functions to help the application
require_once('includes/bootstrap.php');

// Give control to the main controller
$mainController = new MainController();
