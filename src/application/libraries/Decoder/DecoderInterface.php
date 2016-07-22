<?php

/**
 * Created by PhpStorm.
 * User: wis
 * Date: 22/07/16
 * Time: 13:31
 */
interface DecoderInterface
{
	public function decode($data);
	public function prepareData($data);
}
