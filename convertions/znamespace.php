<?php
namespace ZPhalcon\Convertions;

class ZNamespace
{
	public static function convert($namespace, $indent = 0)
	{
		return indent($indent) . 'namespace ' . $namespace['name'] . ';' . PHP_EOL . PHP_EOL;
	}

}
