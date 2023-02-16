<?php
include 'connection.php';
require_once '../PHPExcel/Classes/PHPExcel.php';
require_once '../PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

class ExcelFileDownload{
    private $conn;

    public function __construct(){
        $this->conn = new ConnPDO();
    }

    public function action(){
        $this->downloadExcelFile();
    }

    function downloadExcelFile(){
        // include 'connection.php';

        
        

        // $fromDate = $_POST['fromDateValue'];
        // $toDate = $_POST['toDateValue'];
        $fromDate = $_POST['from_date'];
        $toDate = $_POST['to_date'];
       



        $query = "SELECT student_data.student_id,student_data.student_name,student_data.student_email,student_data.student_mobile,student_data.created_at,student_marks.english_marks,student_marks.math_marks,student_marks.hindi_marks,student_marks.physics_marks,student_marks.chemistry_marks,student_marks.grade,student_marks.student_total_marks FROM student_data LEFT JOIN student_marks on student_data.student_id=student_marks.student_id where (DATE(student_data.created_at) BETWEEN '$fromDate' AND '$toDate') AND `status`='active' ";
        $result = $this->conn->Execute($query);
        $data = $result->fetchAll();

        $objPHP = new PHPExcel();
        
        $objPHP->setActiveSheetIndex(0);
        

        $rowcount = 1;
        $objPHP->getActiveSheet()->setCellValue('A' . $rowcount, "ID");
        $objPHP->getActiveSheet()->setCellValue('B' . $rowcount, "Name");
        $objPHP->getActiveSheet()->setCellValue('C' . $rowcount, "Mobile");
        $objPHP->getActiveSheet()->freezePane('C'.$rowcount);
        $objPHP->getActiveSheet()->setCellValue('D' . $rowcount, "Email");
        $objPHP->getActiveSheet()->setCellValue('E' . $rowcount, "Entry DateTime");
        $objPHP->getActiveSheet()->setCellValue('F' . $rowcount, "English_Marks");
        $objPHP->getActiveSheet()->setCellValue('G' . $rowcount, "Math_Marks");
        $objPHP->getActiveSheet()->setCellValue('H' . $rowcount, "Hindi_Marks");
        $objPHP->getActiveSheet()->setCellValue('I' . $rowcount, "Physics_Marks");
        $objPHP->getActiveSheet()->setCellValue('J' . $rowcount, "Chemistry_Marks");
        $objPHP->getActiveSheet()->setCellValue('K' . $rowcount, "Grade");
        $objPHP->getActiveSheet()->setCellValue('L' . $rowcount, "Total_Marks");
        
        $objPHP->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHP->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHP->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHP->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHP->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHP->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHP->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHP->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHP->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHP->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHP->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $objPHP->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $objPHP->getActiveSheet()->mergeCells('A1:B1');

        // Set cell value
        $objPHP->getActiveSheet()->setCellValue('A1', 'Merged Cell');
        
        //Setting Background Color and text align = center
        $objPHP->getActiveSheet()->getStyle('A1:L1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00ff');
        $objPHP->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $rowcount++;

        foreach ($data as $rows){
            $objPHP->getActiveSheet()->setCellValue('A' . $rowcount, $rows['student_id']);
            $objPHP->getActiveSheet()->setCellValue('B' . $rowcount, $rows['student_name']);
            $objPHP->getActiveSheet()->setCellValue('C' . $rowcount, $rows['student_mobile']);
            $objPHP->getActiveSheet()->setCellValue('D' . $rowcount, $rows['student_email']);
            $objPHP->getActiveSheet()->setCellValue('E' . $rowcount, $rows['created_at']);
            $objPHP->getActiveSheet()->setCellValue('F' . $rowcount, (isset($rows['english_marks'])?$rows['english_marks']:"-"));
$objPHP->getActiveSheet()->setCellValue('G' . $rowcount, (isset($rows['math_marks'])?$rows['math_marks']:"-"));
$objPHP->getActiveSheet()->setCellValue('H' . $rowcount, (isset($rows['hindi_marks'])?$rows['hindi_marks']:"-"));
$objPHP->getActiveSheet()->setCellValue('I' . $rowcount, (isset($rows['physics_marks'])?$rows['physics_marks']:"-"));
$objPHP->getActiveSheet()->setCellValue('J' . $rowcount, (isset($rows['chemistry_marks'])?$rows['chemistry_marks']:"-"));
$objPHP->getActiveSheet()->setCellValue('K' . $rowcount, (isset($rows['grade'])?$rows['grade']:"-"));
$objPHP->getActiveSheet()->setCellValue('L' . $rowcount, (isset($rows['student_total_marks'])?$rows['student_total_marks']:"-"));
            
            // Setting background color and text align = right, center
            $objPHP->getActiveSheet()->getStyle("A" . $rowcount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHP->getActiveSheet()->getStyle("C" . $rowcount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHP->getActiveSheet()->getStyle("E" . $rowcount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHP->getActiveSheet()->getStyle("B" . $rowcount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHP->getActiveSheet()->getStyle("D" . $rowcount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHP->getActiveSheet()->getStyle("F" . $rowcount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHP->getActiveSheet()->getStyle("G" . $rowcount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHP->getActiveSheet()->getStyle("H" . $rowcount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHP->getActiveSheet()->getStyle("I" . $rowcount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHP->getActiveSheet()->getStyle("J" . $rowcount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHP->getActiveSheet()->getStyle("K" . $rowcount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHP->getActiveSheet()->getStyle("L" . $rowcount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHP->getActiveSheet()->getStyle('A' . $rowcount)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ff00ffff');
            $objPHP->getActiveSheet()->getStyle('C' . $rowcount)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ff00ffff');
            $objPHP->getActiveSheet()->getStyle('E' . $rowcount)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ff00ffff');
            $objPHP->getActiveSheet()->getStyle('B' . $rowcount)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00ced1ff');
            $objPHP->getActiveSheet()->getStyle('D' . $rowcount)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00ced1ff');
            $objPHP->getActiveSheet()->getStyle('F' . $rowcount)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffffeeff');
            $objPHP->getActiveSheet()->getStyle('G' . $rowcount)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('fa8072ff');
            $objPHP->getActiveSheet()->getStyle('H' . $rowcount)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffffeeff');
            $objPHP->getActiveSheet()->getStyle('I' . $rowcount)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('fa8072ff');
            $objPHP->getActiveSheet()->getStyle('J' . $rowcount)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffffeeff');
            $objPHP->getActiveSheet()->getStyle('K' . $rowcount)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('fa8072ff');
            $objPHP->getActiveSheet()->getStyle('L' . $rowcount)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ffffeef8');
            $rowcount++;
        }

        $writer = new PHPExcel_Writer_Excel2007($objPHP);
        ob_end_clean();
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=datafile.xls");
        $writer->save('php://output');
        exit;
    }
}

$xls = new ExcelFileDownload();
$xls->action();

?>