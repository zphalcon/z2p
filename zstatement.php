<?php
namespace ZPhalcon;

use ZPhalcon\Statements\ZMcall;

class ZStatement
{
	public static function convert($statement, $indent = 2)
	{
		$converter = str_replace('-', '_', $statement['type']);

		$converterName = 'Z' . camelize($converter);
		$converterClass = '\\ZPhalcon\\Statements\\' . $converterName;
		return $converterClass::convert($statement, $indent);
	}

	public static function parameters($statement)
	{
		$result = '';

		if (isset($statement['parameters'])) {
			foreach ($statement['parameters'] as $idx => $parameter) {
				if ($idx > 0) {
					$result .= ', ';
				}
				$result .= static::expr($parameter['parameter']);
			}
		}

		return $result;
	}

	public static function parameterValue($parameter)
	{
		if (isset($parameter['default'])) {
			return ' = ' . static::expr($parameter['default']);
		}
		return '';
	}

	public static function operator($operator)
	{
		$operators = [
			'assign' 		=> '=',
			'incr'   		=> '++',
			'concat-assign' => '.=',
			'add-assign'    => '+=',
			'sub-assign'    => '-=',
			'div-assign'    => '/=',
		];

		if (array_key_exists($operator, $operators)) {
			return $operators[$operator];
		} else {
			throw new \Exception("Unknown operator `{$operator}`");
		}
	}

	public static function expr($expr)
	{
		$exprType = $expr['type'];
		switch ($exprType) {
			case 'require':
				return 'require ' . ZStatement::expr($expr['left']);
			case 'parameter':
				return '$' . $expr['name'];
			case 'empty-array':
				return '[]';
			case 'variable':
				return '$' . $expr['value'];
			case 'property-access':
				return '$' . $expr['left']['value'] . '->' . $expr['right']['value'];
			case 'type-hint':
				return static::expr($expr['right']);
			case 'clone':
				return 'clone ' . ZStatement::expr($expr['left']);
			case 'scall':
				if ($expr['dynamic-class']) {
					$result = '$' . $expr['class'];
				} else {
					$result = $expr['class'];
				}

				if ($expr['dynamic']) {
					$result .= '->' . $expr['name'] . '(';
				} else {
					$result .= '::' . $expr['name'] . '(';
				}

				$result .= ZStatement::parameters($expr);
				$result .= ')';
				return $result;
			case 'mcall':
				$result = ZStatement::expr($expr['variable']);
				$result .= '->' . $expr['name'] . '(';
				$result .= ZStatement::parameters($expr);
				$result .= ')';
				return $result;
			case 'fcall':
				$fname = str_replace('\\\\', '\\', $expr['name']);
				if (!function_exists($fname)) {
					if (!starts_with($fname, '\Sodium')) {
						$util = __DIR__ . '/util.php';
						$content = file_get_contents($util);
						$content .= PHP_EOL . 'function ' . $fname . '() {' . PHP_EOL . PHP_EOL . '}' . PHP_EOL;
						file_put_contents($util, $content);
						throw new \Exception("Function `{$fname}` does not exists, file: `{$expr['file']}`");
					}
				}
				$result = $fname . '(';
				$result .= ZStatement::parameters($expr);
				$result .= ')';
				return $result;
			case 'null':
				return 'null';
			case 'bool':
			case 'double':
			case 'int':
				return $expr['value'];
			case 'char':
			case 'string':
				return '"' . $expr['value'] . '"';
			case 'static-constant-access':
				return $expr['left']['value'] . '::' . $expr['right']['value'];
			case 'cast':
				return '(' . $expr['left'] . ') ' . static::expr($expr['right']);
			case 'concat':
				return static::expr($expr['left']) . ' . ' . static::expr($expr['right']);
			case 'closure':
				$result = 'function(';
				if (isset($expr['left'])) {
					foreach ($expr['left'] as $idx => $parameter) {
						if ($idx > 0) {
							$result .= ', ';
						}
						$result .= static::expr($parameter);
					}
				}
				$result .= ') {' . PHP_EOL;
				if (isset($expr['right'])) {
					foreach ($expr['right'] as $statement) {
						$result .= ZStatement::convert($statement) . PHP_EOL;
					}
				}
				$result .= '}';
				return $result;
			case 'unlikely':
				return static::expr($expr['left']);
			case 'likely':
				return static::expr($expr['left']);
			case 'array':
				$result = '[';
				foreach ($expr['left'] as $idx => $item) {
					if ($idx > 0) {
						$result .= ', ';
					}
					if (isset($item['key'])) {
						$result .= static::expr($item['key']) . ' => ' . static::expr($item['value']);
					} else {
						$result .= static::expr($item['value']);
					}
				}
				$result .= ']';
				return $result;
			case 'new':
				$result = 'new ';
				if ($expr['dynamic']) {
					$result .= '$';
				}
				$result .= $expr['class'] . '(';
				$result .= static::parameters($expr);
				$result .= ')';
				return $result;
			case 'add':
				return static::expr($expr['left']) . ' + ' . static::expr($expr['right']);
			case 'sub':
				return static::expr($expr['left']) . ' - ' . static::expr($expr['right']);
			case 'mul':
				return static::expr($expr['left']) . ' * ' . static::expr($expr['right']);
			case 'div':
				return static::expr($expr['left']) . ' * ' . static::expr($expr['right']);
			case 'mod':
				return static::expr($expr['left']) . ' % ' . static::expr($expr['right']);
			case 'isset':
				return 'isset(' . static::expr($expr['left']) . ')';
			case 'ternary':
				return static::expr($expr['left']) . ' ? ' . static::expr($expr['right']) . ' : ' . static::expr($expr['extra']);
			case 'and':
				return static::expr($expr['left']) . ' && ' . static::expr($expr['right']);
			case 'or':
				return static::expr($expr['left']) . ' || ' . static::expr($expr['right']);
			case 'bitwise_or':
				return static::expr($expr['left']) . ' | ' . static::expr($expr['right']);
			case 'bitwise_and':
				return static::expr($expr['left']) . ' & ' . static::expr($expr['right']);
			case 'bitwise_xor':
				return static::expr($expr['left']) . ' ^ ' . static::expr($expr['right']);
			case 'bitwise_not':
				return static::expr($expr['left']) . ' ~ ' . static::expr($expr['right']);
			case 'bitwise_shiftright':
				return static::expr($expr['left']) . ' >> ' . static::expr($expr['right']);
			case 'bitwise_shiftleft':
				return static::expr($expr['left']) . ' << ' . static::expr($expr['right']);
			case 'empty':
				return 'empty(' . static::expr($expr['left']) . ')';
			case 'not-equals':
				return static::expr($expr['left']) . ' <> ' . static::expr($expr['right']);
			case 'equals':
				return static::expr($expr['left']) . ' == ' . static::expr($expr['right']);
			case 'identical':
				return static::expr($expr['left']) . ' === ' . static::expr($expr['right']);
			case 'not-identical':
				return static::expr($expr['left']) . ' !== ' . static::expr($expr['right']);
			case 'greater':
				return static::expr($expr['left']) . ' > ' . static::expr($expr['right']);
			case 'greater-equal':
				return static::expr($expr['left']) . ' >= ' . static::expr($expr['right']);
			case 'less':
				return static::expr($expr['left']) . ' < ' . static::expr($expr['right']);
			case 'less-equal':
				return static::expr($expr['left']) . ' <= ' . static::expr($expr['right']);
			case 'fetch':
				$result = 'function() { if(isset(' . static::expr($expr['right']) . ')) {';
				$result .= static::expr($expr['left']) . ' = ';
				$result .= static::expr($expr['right']);
				$result .= '; return ' . static::expr($expr['left']) . '; } else { return false; } }()';
				return $result;
			case 'list':
				return static::expr($expr['left']);
			case 'array-access':
				return static::expr($expr['left']) . '[' . static::expr($expr['right']) . ']';
			case 'instanceof':
				return static::expr($expr['left']) . ' instanceof ' . static::expr($expr['right']);
			case 'typeof':
				return 'typeof(' . static::expr($expr['left']) . ')';
			case 'not':
				return '!(' . static::expr($expr['left']) . ')';
			case 'property-dynamic-access':
				return static::expr($expr['left']) . '->' . static::expr($expr['right']);
			case 'static-property-access':
				return $expr['left']['value'] . '::' . $expr['right']['value'];
			case 'constant':
				return $expr['value'];
			default:
				throw new \Exception("Unknown expr type `{$exprType}`");
		}
	}

}
