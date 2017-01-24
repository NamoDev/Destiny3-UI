<?php

namespace App;

use Exception;

class UIHelper{
    public static function formatTitle($title, $langague = 'tha'){
        if(is_numeric($title)){
            switch($title){
              // 0,2 is male - 1,3 is female - 4 shouldn't really be defined:
                case 0:
                    if($langague == 'eng'){
                        return 'Mr.';
                    }

                    return 'ด.ช.';
                break;
                case 1:
                    if($langague == 'eng'){
                        return 'Ms.';
                    }

                    return 'ด.ญ.';
                break;
                case 2:
                    if($langague == 'eng'){
                        return 'Mr.';
                    }

                    return 'นาย';
                break;
                case 3:
                    if($langague == 'eng'){
                        return 'Ms.';
                    }

                    return 'นางสาว';
                break;
                default:
                    throw new \Exception("What the gender?");
                break;
            }
        }else{
            return $title;
        }
    }

    public static function formatFileName($filename){
        $thai = [
            'image' => 'รูปถ่าย',
            'citizen_card' => 'บัตรประจำตัวประชาชน',
            'transcript' => 'ใบ ปพ.1',
            'student_hr' => 'สำเนาทะเบียนบ้าน',
            'gradecert' => 'ใบรับรองผลการเรียน',
        ];

        if(isset($thai[$filename])){
            return $thai[$filename];
        }else{
            throw new Exception('Unexpected file name');
        }
    }

    public static function formatPlan($plan_id){
        $converter = [
            1 => "ภาษา-ฝรั่งเศส",
            2 => "ภาษา-เยอรมัน",
            3 => "ภาษา-ญี่ปุ่น",
            4 => "ภาษา-คณิต",
            5 => "วิทย์-คณิต",
            7 => "ภาษา-สเปน",
            8 => "ภาษา-จีน",
        ];

        return $converter[$plan_id];
    }

    public static function formatSubject($subject){
        $string = explode('_', $subject);

        $converter = [
            'science' => 'วิทยาศาสตร์',
            'math' => 'คณิตศาสตร์',
            'english' => 'ภาษาอังกฤษ',
            'thai' => 'ภาษาไทย',
            'social' => 'สังคม',
            'basic' => 'พื้นฐาน',
            'advanced' => 'เพิ่มเติม',
        ];

        return $converter[$string[0]].' '.$converter[$string[1]];
    }
}
