<?php

class IndexTest extends TestCase{
    public function test_go_to_create_account(){
        $this->visit('/')
             ->click('สมัครใหม่')
             ->seePageIs('/application/begin');
    }

    public function test_register(){
        $this->visit('/application/begin')
             ->select('นาย', 'title')
             ->type('ทดสอบ', 'fname')
             ->type('ระบบ', 'lname')
             ->type('test', 'fname_en')
             ->type('system', 'lname_en')
             ->type('3705826578503', 'citizenid')
             ->select('1', 'birthdate')
             ->select('มกราคม', 'birthmonth')
             ->select('2559', 'birthyear');
    }

    public function test_login(){
        $this->visit('/')
             ->type('1111111111119', 'login_name')
             ->type('1234', 'login_password')
             ->press('เข้าสู่ระบบ')
             ->seePageIs('/application/home');
    }
}
