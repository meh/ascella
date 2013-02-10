<?php
/*
 *           DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 *                   Version 2, December 2004
 *
 *           DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 *  TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 *
 *  0. You just DO WHAT THE FUCK YOU WANT TO.
 *********************************************************************/

abstract class Command
{
	static public function all ()
	{
		$result = array();

		foreach (get_declared_classes() as $class) {
			if (is_subclass_of($class, 'Command')) {
				$result[] = $class;
			}
		}

		return $result;
	}

	static public function get ($name)
	{
		foreach (self::all() as $command) {
			if ($command::name == $name) {
				return $command;
			}
		}

		return null;
	}

	private $previous;
	private $next;
	private $arguments;
	
	public function __construct ($previous, $next, $arguments)
	{
		$this->previous  = $previous;
		$this->next      = $next;
		$this->arguments = $arguments;

		$this->initialize();
	}

	public function program ()
	{
		return constant(get_class($this) . '::name');
	}

	public function arguments ()
	{
		return $this->arguments;
	}

	abstract public function initialize ();
	
	abstract public function read ($number);
	abstract public function readLine ();
	
	abstract public function out ($text);
	abstract public function err ($text);
}

?>
