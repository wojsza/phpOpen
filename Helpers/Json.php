<?php defined('SYSPATH') or die('No direct script access.');
/**
 * JSON helper class
 *
 *     Examples:
 *     $j = JSON::decode('{"Organization": "Kohana"}'); // Good
 *     $j = JSON::decode("{'Organization': 'Kohana'}"); // Invalid
 *     $j = JSON::decode('{"Organization": "Kohana"}', NULL, 1); // depth stack exceeded
 *
 * @package    Kohana
 * @category   Helpers
 * @author     Igal Alkon <igal.alkon@gmail.com>
 */
class Helper_Json
{
	/**
	 * Returns a string containing the JSON representation of value
	 * Please note:
	 * PHP 5.3.0 - The options parameter was added.
	 * PHP 5.2.1 - Added support for JSON encoding of basic types.
	 *
	 * @static
	 * @param  mixed  $value  This function only works with UTF-8 encoded data
	 * @return string
	 */
	public static function encode($value)
	{
		return json_encode($value);
	}

	/**
	 * Takes a JSON encoded string and converts it into a PHP variable
	 * Please note:
	 * PHP future - The options parameter was added
	 * PHP 5.3.0  - Added the optional depth. The default recursion depth was increased from 128 to 512
	 * PHP 5.2.3  - The nesting limit was increased from 20 to 128
	 *
	 * @static
	 * @throws Kohana_Exception
	 * @param  string  $json      This function only works with UTF-8 encoded data
	 * @param  bool    $to_assoc  When TRUE, returned objects will be converted into associative arrays
	 * @param  int     $depth     User specified recursion depth
	 * @return mixed
	 */
	public static function decode($json, $assoc = FALSE, $depth = 512)
	{
		$result = json_decode($json, $assoc, $depth);

		switch(json_last_error())
		{
			case JSON_ERROR_DEPTH:
				$error = 'Maximum stack depth exceeded';
				break;
			case JSON_ERROR_CTRL_CHAR:
				$error = 'Unexpected control character found';
				break;
			case JSON_ERROR_SYNTAX:
				$error = 'Syntax error';
				break;
			case JSON_ERROR_NONE:
			default:
				$error = '';
		}
		if ( ! empty($error))
		{
			throw new Kohana_Exception('JSON DECODE: :error', array(':error' => $error), E_RECOVERABLE_ERROR);
		}

		return $result;
	}

} // End JSON