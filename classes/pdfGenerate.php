<?php
include 'connection.php';
include '../TCPDF/tcpdf.php';

class PdfFileDownload{
    private $conn;
    
    public function __construct(){
        $this->conn = new ConnPDO();
        
    }
    public function action(){
        // if(isset($_REQUEST['action']) && $_REQUEST['action']=='generateReport'){
        //     $this->downloadPdfFile();
        // }
        $this->downloadPdfFile();
    }

    function downloadPdfFile(){

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // $host = "localhost";
        // $dbname = "recordsofstudents";
        // $username = "root";
        // $password = "";

        // // Connect to the database
        // $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

        $fromDate = $_POST['from_date'];
        $toDate = $_POST['to_date'];
        $query = "SELECT student_data.student_id,student_data.student_name,student_data.student_email,student_data.student_mobile,student_data.created_at,student_marks.english_marks,student_marks.math_marks,student_marks.hindi_marks,student_marks.physics_marks,student_marks.chemistry_marks,student_marks.grade,student_marks.student_total_marks FROM student_data LEFT JOIN student_marks on student_data.student_id=student_marks.student_id where (DATE(student_data.created_at) BETWEEN '$fromDate' AND '$toDate') AND `status`='active' ";
        $stmt = $this->conn->Execute($query);
        // $stmt->execute();
        $data = $stmt->fetchAll();

        // Set font and add table
        $pdf->SetFont('helvetica', '', 8);
        $pdf->AddPage();

        //Table Headers
        // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'My PDF Header');
        $pdf->Cell(8, 10, 'R_No.', 1, 0, 'C', 0, '', 0);
        $pdf->Cell(20, 10, 'Name', 1, 0, 'C', 0, '', 0);
        $pdf->Cell(25, 10, 'Mobile', 1, 0, 'C', 0, '', 0);
        $pdf->Cell(40, 10, 'Email', 1, 0, 'C', 0, '', 0);
        $pdf->Cell(35, 10, 'Entry Date and Time', 1, 0, 'C', 0, '', 0);
        $pdf->Cell(10, 10, 'E_M', 1, 0, 'C', 0, '', 0);
        $pdf->Cell(10, 10, 'M_M', 1, 0, 'C', 0, '', 0);
        $pdf->Cell(10, 10, 'H_M', 1, 0, 'C', 0, '', 0);
        $pdf->Cell(10,10,'P_H',1, 0, 'C', 0, '', 0);
        $pdf->Cell(10,10,'C_H',1, 0, 'C', 0, '', 0);
        $pdf->Cell(10,10,'Grade',1, 0, 'C', 0, '', 0);
        $pdf->Cell(10,10,'T_M',1, 0, 'C', 0, '', 0);
        $pdf->Ln();

        // Table data
        foreach($data as $row) {
            $pdf->Cell(8, 10, $row['student_id'], 1, 0, 'C', 0, '', 0);
            $pdf->Cell(20, 10, $row['student_name'], 1, 0, 'C', 0, '', 0);
            $pdf->Cell(25, 10, $row['student_mobile'], 1, 0, 'C', 0, '', 0);
            $pdf->Cell(40, 10, $row['student_email'], 1, 0, 'C', 0, '', 0);
            $pdf->Cell(35, 10, $row['created_at'], 1, 0, 'C', 0, '', 0);
            $pdf->Cell(10, 10, (isset($row['english_marks'])?$row['english_marks']:"-"), 1, 0, 'C', 0, '', 0);
            $pdf->Cell(10, 10, (isset($row['math_marks'])?$row['math_marks']:"-"), 1, 0, 'C', 0, '', 0);
            $pdf->Cell(10, 10, (isset($row['hindi_marks'])?$row['hindi_marks']:"-"), 1, 0, 'C', 0, '', 0);
            $pdf->Cell(10, 10,(isset($row['physics_marks'])?$row['physics_marks']:"-"), 1, 0, 'C', 0, '', 0);
            $pdf->Cell(10, 10, (isset($row['chemistry_marks'])?$row['chemistry_marks']:"-"), 1, 0, 'C', 0, '', 0);
            $pdf->Cell(10, 10, (isset($row['grade'])?$row['grade']:"-"), 1, 0, 'C', 0, '', 0);
            $pdf->Cell(10, 10, (isset($row['student_total_marks'])?$row['student_total_marks']:"-"), 1, 0, 'C', 0, '', 0);
            $pdf->Ln();
        }
        ob_end_clean();
        // Output the PDF document
        $pdf->Output('Student Data.pdf', 'D');

    }
}

$pdf = new PdfFileDownload();
$pdf->action();

?>