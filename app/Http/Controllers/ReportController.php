<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\UIHelper;
use DB;

class ReportController extends Controller
{
    public function generateExcelReport(){
        $all = DB::collection('applicants')->orderBy('registered', 'asc')->get();

        // Create new Spreadsheet object
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('DestinyUI')
                ->setTitle('DestinyUI')
                ->setSubject('DestinyUI')
                ->setDescription('DestinyUI data');

        // Set header
        $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1', 'คำนำหน้าชื่อ')
                ->setCellValue('B1', 'ชื่อ')
                ->setCellValue('C1', 'นามสกุล')
                ->setCellValue('D1', 'เลขประจำตัวประชาชน')
                ->setCellValue('E1', 'email')
                ->setCellValue('F1', 'เบอร์โทรศัพท์')
                ->setCellValue('G1', 'โรงเรียนชั้นม.2')
                ->setCellValue('H1', 'จังหวัดโรงเรียนชั้นม.2')
                ->setCellValue('I1', 'โรงเรียนชั้นม.3')
                ->setCellValue('J1', 'จังหวัดโรงเรียนชั้นม.3');

        for($i=2;$i<=count($all); $i++){
            // Set data
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, isset($all[$i-2]['title']) ? UIHelper::formatTitle($all[$i-2]['title']) : 'ไม่มีข้อมูล')
                ->setCellValue('B'.$i, isset($all[$i-2]['fname']) ? $all[$i-2]['fname'] : 'ไม่มีข้อมูล')
                ->setCellValue('C'.$i, isset($all[$i-2]['lname']) ? $all[$i-2]['lname'] : 'ไม่มีข้อมูล')
                ->setCellValueExplicit('D'.$i, isset($all[$i-2]['citizen_id']) ? $all[$i-2]['citizen_id'] : 'ไม่มีข้อมูล', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValue('E'.$i, isset($all[$i-2]['email']) ? $all[$i-2]['email'] : 'ไม่มีข้อมูล')
                ->setCellValueExplicit('F'.$i, isset($all[$i-2]['phone']) ? $all[$i-2]['phone'] : 'ไม่มีข้อมูล', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING)
                ->setCellValue('G'.$i, isset($all[$i-2]['school2']) ? $all[$i-2]['school2'] : 'ไม่มีข้อมูล')
                ->setCellValue('H'.$i, isset($all[$i-2]['school2_province']) ? $all[$i-2]['school2_province'] : 'ไม่มีข้อมูล')
                ->setCellValue('I'.$i, isset($all[$i-2]['school']) ? $all[$i-2]['school'] : 'ไม่มีข้อมูล')
                ->setCellValue('J'.$i, isset($all[$i-2]['school_province']) ? $all[$i-2]['school_province'] : 'ไม่มีข้อมูล');
        }

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle((string) time());

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Set filename and path

        $path = storage_path('DestinyUI.xlsx');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Excel2007');
        $writer->save($path);

        $spreadsheet->disconnectWorksheets();

        return $path;
    }
}
