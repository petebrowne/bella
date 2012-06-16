<?php

class Unit
{
	public static function micro_time() {
		$temp = explode(" ", microtime());
		return bcadd($temp[0], $temp[1], 6);
	}
}