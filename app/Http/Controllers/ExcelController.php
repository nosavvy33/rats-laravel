<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

use App\SampleLine as Registro;

class ExcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spreadsheet = new Spreadsheet();
// Set document properties
$spreadsheet->getProperties()->setCreator('Maarten Balliauw')
    ->setLastModifiedBy('Maarten Balliauw')
    ->setTitle('Office 2007 XLSX Test Document')
    ->setSubject('Office 2007 XLSX Test Document')
    ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
    ->setKeywords('office 2007 openxml php')
    ->setCategory('Test result file');

 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1','id')
            ->setCellValue('B1','point_id')
            ->setCellValue('C1','sample_id')
            ->setCellValue('D1','status')
            ->setCellValue('E1','state')
            ->setCellValue('F1','created_at')
            ->setCellValue('G1','updated_at')
            ->setCellValue('H1','recebado')
            ->setCellValue('I1','user_id')
            ->setCellValue('J1','captura');
        $i = 2;
        $data = Registro::all();
        foreach ($data as $value) {
//| id | point_id | sample_id | status            | state      | created_at          | updated_at          | recebado | user_id | captura |
            //echo $value["captura"]."</br>";
            $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.$i,$value["id"])
            ->setCellValue('B'.$i,$value["point_id"])
            ->setCellValue('C'.$i,$value["sample_id"])
            ->setCellValue('D'.$i,$value["status"])
            ->setCellValue('E'.$i,$value["state"])
            ->setCellValue('F'.$i,$value["created_at"])
            ->setCellValue('G'.$i,$value["updated_at"])
            ->setCellValue('H'.$i,$value["recebado"])
            ->setCellValue('I'.$i,$value["user_id"])
            ->setCellValue('J'.$i,$value["captura"]);
        $i++;
        }

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Simple');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="01simple.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
