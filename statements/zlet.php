<?php
namespace ZPhalcon\Statements;

use ZPhalcon\ZStatement;

class ZLet
{
	public static function convert($expr, $indent = 3)
	{
		$result = '';
		foreach ($expr['assignments'] as $assignment) {
			$result .= indent($indent);
			$assignmentType = $assignment['assign-type'];
			switch ($assignmentType) {
				case 'object-property':
					$result .= '$' . $assignment['variable'] . '->' . $assignment['property'];
					$result .= ' ' . ZStatement::operator($assignment['operator']);
					$result .= ' ' . ZStatement::expr($assignment['expr']);
					$result .= ';' .PHP_EOL;
					break;
				case 'variable':
					$result .= '$' . $assignment['variable'];
					$result .= ' ' . ZStatement::operator($assignment['operator']);
					$result .= ' ' . ZStatement::expr($assignment['expr']);
					$result .= ';' .PHP_EOL;
					break;
				case 'variable-append':
					$result .= '$' . $assignment['variable'];
					$result .= ' ' . ZStatement::operator($assignment['operator']);
					$result .= ' ' . ZStatement::expr($assignment['expr']);
					$result .= ';' .PHP_EOL;
					break;
				case 'object-property-append':
					$result .= '$' . $assignment['variable'] . '->' . $assignment['property'] . '[]';
					$result .= ' ' . ZStatement::operator($assignment['operator']);
					$result .= ' ' . ZStatement::expr($assignment['expr']);
					$result .= ';' .PHP_EOL;
					break;
				case 'variable-dynamic-object-property':
					$result .= '$' . $assignment['variable'] . '->{$' . $assignment['property'] . "}";
					$result .= ' ' . ZStatement::operator($assignment['operator']);
					$result .= ' ' . ZStatement::expr($assignment['expr']);
					$result .= ';' .PHP_EOL;
					break;
				case 'dynamic-variable':
					$result .= '$$' . $assignment['variable'];
					$result .= ' ' . ZStatement::operator($assignment['operator']);
					$result .= ' ' . ZStatement::expr($assignment['expr']);
					$result .= ';' .PHP_EOL;
					break;
				case 'object-property-array-index':
					$result .= '$' . $assignment['variable'] . '[' . ZStatement::expr($assignment['index-expr'][0]) . ']';
					$result .= ' ' . ZStatement::operator($assignment['operator']);
					$result .= ' ' . ZStatement::expr($assignment['expr']);
					$result .= ';' .PHP_EOL;
					break;
				case 'object-property-array-index-append':
					$result .= '$' . $assignment['variable'] . '->' . $assignment['property'];
					$result .= '[' . ZStatement::expr($assignment['index-expr'][0]) . ']';
					$result .= ' ' . ZStatement::operator($assignment['operator']);
					$result .= ' ' . ZStatement::expr($assignment['expr']);
					$result .= ';' .PHP_EOL;
					break;
				case 'static-property-array-index':
					$result .= $assignment['variable'] . '::' . ZStatement::expr($assignment['index-expr'][0]);
					$result .= ' ' . ZStatement::operator($assignment['operator']);
					$result .= ' ' . ZStatement::expr($assignment['expr']);
					$result .= ';' .PHP_EOL;
					break;
				case 'string-dynamic-object-property':
					$result .= '$' . $assignment['variable'] . '->{' . $assignment['property'] . '}';
					$result .= ' ' . ZStatement::operator($assignment['operator']);
					$result .= ' ' . ZStatement::expr($assignment['expr']);
					$result .= ';' .PHP_EOL;
					break;
				case 'array-index-append':
					$result .= '$' . $assignment['variable'] . '[' . ZStatement::expr($assignment['index-expr'][0]) . '][]';
					$result .= ' ' . ZStatement::operator($assignment['operator']);
					$result .= ' ' . ZStatement::expr($assignment['expr']);
					$result .= ';' .PHP_EOL;
					break;
				case 'static-property':
					$result .= $assignment['variable'] . '::' . $assignment['property'];
					$result .= ' ' . ZStatement::operator($assignment['operator']);
					$result .= ' ' . ZStatement::expr($assignment['expr']);
					$result .= ';' .PHP_EOL;
					break;
				case 'array-index':
					$result .= '$' . $assignment['variable'] . '[' . ZStatement::expr($assignment['index-expr'][0]) . ']';
					$result .= ' ' . ZStatement::operator($assignment['operator']);
					$result .= ' ' . ZStatement::expr($assignment['expr']);
					$result .= ';' .PHP_EOL;
					break;
				case 'object-property-incr':
					$result .= '$' . $assignment['variable'] . '->' . $assignment['property'] . '++;';
					break;
				case 'object-property-decr':
					$result .= '$' . $assignment['variable'] . '->' . $assignment['property'] . '--;';
					break;
				case 'incr':
					$result .= '$' . $assignment['variable'];
					$result .= '++;' .PHP_EOL;
					break;
				case 'decr':
					$result .= '$' . $assignment['variable'];
					$result .= '--;' .PHP_EOL;
					break;
				default:
					throw new \Exception("Unknown assignment `{$assignmentType}`");
					break;
			}
		}

		return $result;
	}

}
