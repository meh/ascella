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

final class Parser
{
	private $string;
	private $position;

	function parse ($string)
	{
		$result = array();
		$this->reset($string);

		while ($value = $this->next()) {
			$result[] = $value;
		}

		return $result;
	}

	private function next ()
	{
		$this->ignore();

		if ($this->eof()) {
			return false;
		}

		$result = '';

		while (!$this->eof() && !$this->ignore¿()) {
			if ($this->string¿()) {
				$result .= $this->string();
			}
			else {
				$result .= $this->current();

				$this->seek(1);
			}
		}

		return $result;
	}

	private function string¿ ()
	{
		return in_array($this->current(), array('"', "'"));
	}

	private function string ()
	{
		if (!$this->string¿()) {
			return false;
		}

		$result = '';
		$end    = $this->current();
		$this->seek(1);

		while ($this->current() != $end) {
			$result .= $this->current();

			if ($this->current() == '\\') {
				$this->seek(1);
				$result .= $this->current();
			}

			$this->seek(1);

			if ($this->eof()) {
				throw new Exception("missing closing `$end`");
			}
		}

		$this->seek(1);

		return $result;
	}

	private function ignore¿ ()
	{
		return in_array($this->current(), array(' ', "\n", "\t", "\r"));
	}

	private function ignore ()
	{
		while (!$this->eof() && $this->ignore¿()) {
			$this->seek(1);
		}
	}

	private function current ()
	{
		return $this->string[$this->position];
	}

	private function seek ($n)
	{
		return $this->position += $n;
	}

	private function after ($n)
	{
		return $this->string[$this->position + $n];
	}

	private function substr ($start, $length)
	{
		return substr($this->position + $start, $length);
	}

	private function remaining ()
	{
		return strlen($this->string) - $this->position;
	}

	private function eof ()
	{
		return $this->position >= strlen($this->string);
	}

	private function reset ($string)
	{
		$this->string   = $string;
		$this->position = 0;
	}
}

?>
