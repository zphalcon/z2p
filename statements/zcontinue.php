<?php
namespace ZPhalcon\Statements;

class ZContinue
{
	public static function convert($expr, $indent = 3)
	{
		$result = indent($indent) . 'continue;' . PHP_EOL;
		return $result;
	}

}
