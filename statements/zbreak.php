<?php
namespace ZPhalcon\Statements;

class ZBreak
{
	public static function convert($expr, $indent = 3)
	{
		$result = indent($indent) . 'break;' . PHP_EOL;
		return $result;
	}

}
