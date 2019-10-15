<?php
namespace ZPhalcon\Convertions;

class ZUse
{
	public static function convert($use, $indent = 0)
	{
		$result = '';
		foreach ($use['aliases'] as $alias) {
			$result .= indent($indent) . 'use ' . $alias['name'];
			if (isset($alias['alias'])) {
				$result .= ' as ' . $alias['alias'];
			}
			$result .= ';' . PHP_EOL;
		}
		return $result;
	}

}
