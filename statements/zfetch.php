<?php
namespace ZPhalcon\Statements;

use ZPhalcon\ZStatement;

class ZFetch
{
	public static function convert($expr, $indent = 3)
	{
		$result = indent($indent);
		$result .= ZStatement::expr($expr['expr']['left']);
		$result .= ' = ';
		$result .= ZStatement::expr($expr['expr']['right']);
		return $result;
	}

}
