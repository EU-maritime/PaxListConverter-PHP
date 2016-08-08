<?php
require_once LIBRARIES.'Encoder/EncoderInterface.php';
/**
 * Created by PhpStorm.
 * User: EU-maritime/PaxListConverter
 * Date: 22/07/16
 * Time: 13:32
 */
class HtmlEncoder implements EncoderInterface
{
	/**
	 * @param $data
	 * @return mixed
	 */
	public function encode ($data)
	{
		$html = $this->prepareData($data);
		return $html;
	}

	/**
	 * @param $data
	 * @return mixed
	 */
	private function prepareData($data)
	{
		if (is_array($data)) {
			$html = '<hr>';
			$html .= '<table border="1">';
			$header = $data[0];
			echo '<tr>';
			foreach ($header as $k => $v){
				$html .= '<th>'.$k.'</th>';
			}
			echo '</tr>';
			foreach ($data as $row) {
				$html .= '<tr>';
				foreach ($row as $v) {
					$html .= '<td>' . $v . '</td>';
				}
				$html .= '</tr>';
			}
			$html .= '</table>';
		} else {
			$html = '<h2>No valid data found</h2>';
		}
		return $html;
	}
}
