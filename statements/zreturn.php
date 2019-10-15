<?php
namespace ZPhalcon\Statements;

use ZPhalcon\ZStatement;

class ZReturn
{
	public static function convert($expr, $indent = 3)
	{
		$result = indent($indent) . 'return ';
		if (isset($expr['expr'])) {
			$result .= ZStatement::expr($expr['expr']);
		}
		$result .= ';';
		return $result;
	}

}
