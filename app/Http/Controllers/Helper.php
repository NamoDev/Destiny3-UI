<?php

/*
|
| DestinyUI 3.0
| (C) 2016 TUDT
|
| Helper functions (a.k.a. "UI cheats")
|
*/

namespace App\Http\Controllers;

use Applicant;
use DB;
use Session;

class Helper extends Controller {
	
	public static function checkStepCompletion(int $step) {
		try {
			$applicantData = DB::collection("applicants")->where("citizenid", Session::get("applicant_citizen_id"))->first();
			if (in_array($step, $applicantData['steps_completed'])) {
				return true;
			} else {
				return false;
			}
		} catch (\Throwable $whatever) {
			return false;
		}
	}
	
	public static function formatCitizenIDforDisplay(string $citizenID) {
		try {
			$splitted = str_split($citizenID);
			
			return $splitted[0] . " - " . $splitted[1] . $splitted[2] . $splitted[3] . $splitted[4] . " - " . $splitted[5] . $splitted[6] . $splitted[7] . $splitted[8] . $splitted[9] . " - " . $splitted[10] . $splitted[11] . " - " . $splitted[12];
		} catch (\Throwable $wtf) {
			return $citizenID;
		}
		
	}
	
	public static function printQuotaSelectBox($id = NULL) {
		$A = array(
			'ความสามารถพิเศษด้านวิชาการ',
			'ความสามารถพิเศษด้านกีฬา',
			'ความสามารถพิเศษด้านศิลปะ ดนตรี และนาฎศิลป์'
		);
		if (is_null($id)) {
			for ($I = 0; $I <= 2; $I++) {
				echo '<optgroup label="' . $A[$I] . '">';
				switch ($I) {
					case 0:
						$num = array(
							'คณิตศาสตร์',
							'วิทยาศาสตร์',
							'คอมพิวเตอร์'
						);
						for ($i = 1; $i <= 3; $i++) {
							echo '<option value="' . $i . '">' . $num[$i - 1] . '</option>';
						}
						break;
					case 1:
						$num = array(
							'เทนนิส',
							'ว่ายน้ำ',
							'กอล์ฟ',
							'ยิงปืน',
							'เทเบิลเทนนิส',
							'เทควันโด',
							'ยิมนาสติกลีลา',
							'แบดมินตัน',
							'ฟุตบอล',
							'บาสเกตบอล',
							'วอลเล่ย์บอล(ชาย)'
						);
						for ($i = 4; $i <= 14; $i++) {
							echo '<option value="' . $i . '">' . $num[$i - 4] . '</option>';
						}
						break;
					case 2:
						$num = array(
							'นาฏศิลป์',
							'ศิลปะ',
							'ดนตรีไทย-ขลุ่ยเพียงออ',
							'ดนตรีไทย-ขับร้องเพลงไทยเดิม',
							'ดนตรีไทย-ขิม',
							'ดนตรีไทย-เครื่องหนัง',
							'ดนตรีไทย-ฆ้องวงใหญ่',
							'ดนตรีไทย-จะเข้',
							'ดนตรีไทย-ซอด้วง',
							'ดนตรีไทย-ซอสามสาย',
							'ดนตรีไทย-ซออู้',
							'ดนตรีไทย-ระนาดทุ้ม',
							'ดนตรีไทย-ระนาดเอก',
							'ดนตรีสากล-กีตาร์ไฟฟ้า',
							'ดนตรีสากล-กีตาร์เบสไฟฟ้า',
							'ดนตรีสากล-คีย์บอร์ด',
							'ดนตรีสากล-กลองชุด',
							'ดนตรีสากล-ขับร้องเพลงไทยสากล',
							'ดุริยางค์-Alto Saxophone',
							'ดุริยางค์-Clarinet',
							'ดุริยางค์-Flute',
							'ดุริยางค์-French Horn',
							'ดุริยางค์-Oboe',
							'ดุริยางค์-Percussion',
							'ดุริยางค์-Piccolo',
							'ดุริยางค์-Tenor Saxophone',
							'ดุริยางค์-Trombone',
							'ดุริยางค์-Trumpet',
							'ดุริยางค์-Tuba',
							'ดุริยางค์-อื่นๆ'
						);
						for ($i = 15; $i <= 44; $i++) {
							echo '<option value="' . $i . '">' . $num[$i - 15] . '</option>';
						}
						break;
				}
				echo '</optgroup>';
			}
		} else {
			/*
			if($i!=99){
			echo '<option value="99">นักเรียนโควตาจังหวัด สพม.</option>';
			}else{
			echo '<option value="99" selected> นักเรียนโควตาจังหวัด สพม.</option>';
			}
			*/
			for ($I = 0; $I <= 2; $I++) {
				echo '<optgroup label="' . $A[$I] . '">';
				switch ($I) {
					case 0:
						for ($i = 1; $i <= 3; $i++) {
							$num = array(
								'คณิตศาสตร์',
								'วิทยาศาสตร์',
								'คอมพิวเตอร์'
							);
							if ($i != $id) {
								echo '<option value="' . $i . '">' . $num[$i - 1] . '</option>';
							} else {
								echo '<option value="' . $i . '" selected>' . $num[$i - 1] . '</option>';
							}
						}
						break;
					case 1:
						for ($i = 4; $i <= 14; $i++) {
							$num = array(
								'เทนนิส',
								'ว่ายน้ำ',
								'กอล์ฟ',
								'ยิงปืน',
								'เทเบิลเทนนิส',
								'เทควันโด',
								'ยิมนาสติกลีลา',
								'แบดมินตัน',
								'ฟุตบอล',
								'บาสเกตบอล',
								'วอลเล่ย์บอล(ชาย)'
							);
							if ($i != $id) {
								echo '<option value="' . $i . '">' . $num[$i - 4] . '</option>';
							} else {
								echo '<option value="' . $i . '" selected>' . $num[$i - 4] . '</option>';
							}
						}
						break;
					case 2:
						for ($i = 15; $i <= 44; $i++) {
							$num = array(
								'นาฏศิลป์',
								'ศิลปะ',
								'ดนตรีไทย-ขลุ่ยเพียงออ',
								'ดนตรีไทย-ขับร้องเพลงไทยเดิม',
								'ดนตรีไทย-ขิม',
								'ดนตรีไทย-เครื่องหนัง',
								'ดนตรีไทย-ฆ้องวงใหญ่',
								'ดนตรีไทย-จะเข้',
								'ดนตรีไทย-ซอด้วง',
								'ดนตรีไทย-ซอสามสาย',
								'ดนตรีไทย-ซออู้',
								'ดนตรีไทย-ระนาดทุ้ม',
								'ดนตรีไทย-ระนาดเอก',
								'ดนตรีสากล-กีตาร์ไฟฟ้า',
								'ดนตรีสากล-กีตาร์เบสไฟฟ้า',
								'ดนตรีสากล-คีย์บอร์ด',
								'ดนตรีสากล-กลองชุด',
								'ดนตรีสากล-ขับร้องเพลงไทยสากล',
								'ดุริยางค์-Alto Saxophone',
								'ดุริยางค์-Clarinet',
								'ดุริยางค์-Flute',
								'ดุริยางค์-French Horn',
								'ดุริยางค์-Oboe',
								'ดุริยางค์-Percussion',
								'ดุริยางค์-Piccolo',
								'ดุริยางค์-Tenor Saxophone',
								'ดุริยางค์-Trombone',
								'ดุริยางค์-Trumpet',
								'ดุริยางค์-Tuba',
								'ดุริยางค์-อื่นๆ'
							);
							if ($i != $id) {
								echo '<option value="' . $i . '">' . $num[$i - 15] . '</option>';
							} else {
								echo '<option value="' . $i . '" selected>' . $num[$i - 15] . '</option>';
							}
						}
						break;
				}
				echo '</optgroup>';
			}
		}
	}
	
	public static function voiceLines() {
		$index = rand(0, 4);
		$lines = [
			"*Beep boop*",
			"Houston, we have a problem.",
			"Oh, let's break it down!",
			"Just in time.",
			"Aw, rubbish!"
		];
		
		try {
			return $lines[$index];
		} catch (\Throwable $wait_what) {
			return $lines[0];
		}
	}
	
}
