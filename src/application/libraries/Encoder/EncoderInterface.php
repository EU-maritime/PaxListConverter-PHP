<?php

/**
 * Created by PhpStorm.
 * User: wis
 * Date: 22/07/16
 * Time: 13:31
 */
interface EncoderInterface
{
	public function encode($data);
	public function prepareData($data);
}
