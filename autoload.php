<?php
require_once(__DIR__ . '/util.php');

spl_autoload_register(function ($class) {
	if (strpos($class, "ZPhalcon") === 0 || strpos($class, "\ZPhalcon") === 0) {
		include (__DIR__ . '/../' . uncamelize($class) . '.php');
	}
});
