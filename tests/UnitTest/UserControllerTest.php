<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserControllerTest extends TestCase{
    public function test_create_account(){
        $response = $this->call('POST', '/api/v1/applicant/data', array(

        ));
    }

    public function test_login(){

    }

    public function test_logout(){

    }

    public function test_update_applicant_data(){

    }

    public function test_update_parent_information(){
        $param = array(
            'father_title' => 'นาย',
            'father_fname' => 'ลอง',
            'father_lname' => 'ระบบ',
            'father_phone' => '0888888888',
            'father_occupation' => '',
            'father_dead' => 1,
            'mother_title' => 'นาง',
            'mother_fname' => 'ทดลอง',
            'mother_lname' => 'ระบบ',
            'mother_phone' => '0877777777',
            'mother_occupation' => 'สอบ',
            'mother_dead' => 0,
            'has_guardian' => 0,
            'staying_with' => 2,
            'guardian_title' => '',
            'guardian_fname' => '',
            'guardian_lname' => '',
            'guardian_phone' => '',
            'guardian_occupation' => '',
            'guardian_relation' => '',
        );

        $response = $this->call('POST', '/api/v1/applicant/parent_info', $param)
                         ->withSession(array(
                             ''
                         ));

        $this->assertEquals(200, $response->status());
    }
}
