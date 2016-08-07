<?php

/**
 * Created by PhpStorm.
 * User: wis
 * Date: 22/07/16
 * Time: 13:31
 */
interface FilterInterface
{
	/**
	 * @param $data
	 * @return mixed
	 */
	public function filter($data);
}
