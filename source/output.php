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

class Output extends Command
{
	const name = '(output)';

	private $output;
	private $error;

	public function initialize ()
	{
		$this->output = '';
		$this->error  = '';
	}

	public function read ($number)
	{
		return null;
	}

	public function readLine ()
	{
		return null;
	}

	public function out ($text)
	{
		$this->output .= $text;
	}

	public function err ($text)
	{
		$this->error .= $text;
	}

	public function output ()
	{
		return $this->output;
	}

	public function error ()
	{
		return $this->error;
	}
}

?>
