<?php

use core\classes\Database;

// load session
session_start();

// load config.php
require_once('../config.php');

// load classes from autoload
require_once('../vendor/autoload.php');

// load routing system
require_once('../core/routes.php');