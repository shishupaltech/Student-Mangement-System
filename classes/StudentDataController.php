<?php 
    
    include 'connection.php';
    class StudentDataController{
        private $conn;
        public function __construct(){
            $this->conn = new ConnPDO();
            if(isset($_REQUEST['action']) && $_REQUEST['action']=='getData'){
                $this->fetchStudentData();
            }
            else if(isset($_REQUEST['action']) && $_REQUEST['action']=='getDataForDocs'){
                $this->getDataForDocs();
            }
        }

            public function action(){
            
            if(isset($_REQUEST['action']) && $_REQUEST['action']=='addStudentData'){
                $this->addStudentData();    
            }
            
            elseif(isset($_REQUEST['action']) && $_REQUEST['action']=='fetchIdData'){
                $this->fetchIdData();
            }
            elseif(isset($_REQUEST['action']) && $_REQUEST['action']=='updataData'){
                $this->updateData();
            }
            elseif(isset($_REQUEST['action']) && $_REQUEST['action']=='deleteData'){
                $this->deleteData();
            }
            elseif(isset($_REQUEST['action']) && $_REQUEST['action']=='addMarks'){
                $this->addMarks();
            }
            elseif(isset($_REQUEST['action']) && $_REQUEST['action']=='generate_pdf_report'){
                $this->generate_pdf_report();
            }
            elseif(isset($_REQUEST['action']) && $_REQUEST['action']=='aadharFrontView'){
                $this->aadharFrontView();
            }
            elseif(isset($_REQUEST['action']) && $_REQUEST['action']=='aadharBackView'){
                $this->aadharBackView();
            }
            elseif(isset($_REQUEST['action']) && $_REQUEST['action']=='panCardView'){
                $this->aadharBackView();
            }
            elseif(isset($_REQUEST['action']) && $_REQUEST['action']=='getStateAndCityByPincode'){
                $this->getStateAndCityByPincode();
            }
            
            else if(isset($_POST['action'])&& $_POST['action'] == 'deleteStudentData'){
                $this->deleteStudentData();
            }
            else if(isset($_POST['action'])&& $_POST['action']=='updateStudentData'){
                // $this->updateStudentData();
            }
        }

        public function aadharFrontView(){
            $img_id = $_GET['id'];
            $sql = "SELECT adhar_front FROM student_docs WHERE student_docs.student_id = {$img_id} ";
            $result = $this->conn->Execute($sql);
                
                 if($result->rowCount()>0)
                 {
                    $data = [];
                    while($row=$result->fetch(PDO::FETCH_ASSOC,PDO::FETCH_ORI_NEXT)){
                        $data[]=$row;
                    }
                    exit(json_encode($data)); 
                 }else{
                    $data['empty']=['empty'];
                    exit(json_encode($data));
                 }


        }
        public function aadharBackView(){
            $img_id = $_GET['id'];
            $sql = "SELECT adhar_back FROM student_docs WHERE student_docs.student_id = {$img_id} ";
            $result = $this->conn->Execute($sql);
                
                 if($result->rowCount()>0)
                 {
                    $data = [];
                    while($row=$result->fetch(PDO::FETCH_ASSOC,PDO::FETCH_ORI_NEXT)){
                        $data[]=$row;
                    }
                    exit(json_encode($data)); 
                 }else{
                    $data['empty']=['empty'];
                    exit(json_encode($data));
                 }
        }
        public function panCardView(){
            $img_id = $_GET['id'];
            $sql = "SELECT pancard FROM student_docs WHERE student_docs.student_id = {$img_id} ";
            $result = $this->conn->Execute($sql);
                
                 if($result->rowCount()>0)
                 {
                    $data = [];
                    while($row=$result->fetch(PDO::FETCH_ASSOC,PDO::FETCH_ORI_NEXT)){
                        $data[]=$row;
                    }
                    exit(json_encode($data)); 
                 }else{
                    $data['empty']=['empty'];
                    exit(json_encode($data));
                 }
        }

        public function addStudentData(){
            // exit(print_r($_POST));
                $name = $_POST['name'];
                $mobile = $_POST['mobile'];
                $email = $_POST['email'];
                $pincode = $_POST['pincode'];
                $city = $_POST['city'];
                $state = $_POST['state'];
                $address = $city . " " . $state;
        echo $name;
        echo $mobile;
        echo $email;
        echo $pincode;
        // echo $city;
        echo $address;
        

                $sql = "INSERT INTO `student_data`(`student_name`,`student_email`,`student_mobile`,`student_pincode`,`student_address`)VALUE('{$name}','{$email}','{$mobile}','{$pincode}','{$address}')";
                $this->conn->Execute($sql);
                $query="SELECT LAST_INSERT_ID()";
                $result=$this->conn->Execute($query);
                if($result->rowCount()>0){
                    $data=[];
                    while($row=$result->fetch(PDO::FETCH_ASSOC,PDO::FETCH_ORI_NEXT)){
                        $data[]=$row;
                    }
                    
                }
                

                $last_id = $data[0]["LAST_INSERT_ID()"];
                // exit(print_r($last_id));
                $adhar_card_front=$_POST['adharCardFront'];
                    $adhar_card_back =$_POST['adharCardBack']; 
                    $pancard = $_POST['pancard'];

                    $sql = "INSERT INTO `student_docs`(`student_id`,`adhar_front`,`adhar_back`,`pancard`)Values('{$last_id}','{$adhar_card_front}','{$adhar_card_back}','{$pancard}
                    ')";
                    if ($this->conn->Execute($sql)) {
                        echo "Images stored successfully";
                        } else {
                        echo "Error storing images";
                        }

               
                  
        }
        public function fetchStudentData(){
                $sql = "SELECT student_data.student_id,student_data.student_name,student_data.student_email,
                student_data.student_pincode,student_data.student_address,student_data.student_mobile,student_marks.grade,student_marks.student_total_marks,
                DATE_FORMAT(student_data.created_at, '%m-%d-%Y %H:%i:%s') as created_at_formatted
                FROM student_data
                LEFT JOIN student_marks
                ON student_data.student_id = student_marks.student_id 
                WHERE status='active' 
                ORDER BY student_data.student_id";

                $result = $this->conn->Execute($sql);
                
                 if($result->rowCount()>0)
                 {
                    $data = [];
                    while($row=$result->fetch(PDO::FETCH_ASSOC,PDO::FETCH_ORI_NEXT)){
                        $data[]=$row;
                    }
                    exit(json_encode($data)); 
                 }else{
                    $data['empty']=['empty'];
                    exit(json_encode($data));
                 }
                 getDataForDocs();
                
        }
        public function fetchIdData(){
             // Selecting Database
                
                $id = $_POST['id'];
                
                $sql ="SELECT * FROM `student_data` WHERE `student_id`='{$id}'";

                
                $result = $this->conn->Execute($sql);
                
                 if($result->rowCount()>0)
                 {
                    $data = [];
                    while($row = $result->fetch(PDO::FETCH_ASSOC,PDO::FETCH_ORI_NEXT)){
                        $data[] = $row;
                    }
                    exit(json_encode($data));
                 }else{
                    $data['empty']=['empty'];
                    exit(json_encode($data));

                 }
                

        } 

        public function updateData(){
            
            $st_id = $_POST['id'];
            $Name = $_POST['name'];
            
            $email = $_POST['email'];
            $mobile = $_POST['mobile'];

            $adhar_card_front=$_POST['adharCardFront'];
            $adhar_card_back=$_POST['adharCardBack'];
            $pancard = $_POST['pancard'];

            echo $st_id." ".$Name." "." ".$email." ".$mobile;

            // updating data with
            $sql = "UPDATE  `student_data` SET `student_name`='{$Name}',`student_email`='{$email}',`student_mobile`='{$mobile}' WHERE `student_id`='{$st_id}'";
            $this->conn->Execute($sql);


            // UPDATING DATA FOR DOCS 
            $sql1 = "UPDATE `student_docs` SET `student_id`='{$st_id}',`adhar_front`='{$adhar_card_front}',
            `adhar_back`='{$adhar_card_back}',`pancard`='{$pancard}' WHERE `student_id`='{$st_id}'";

            if($this->conn->Execute($sql1)){
                $response=[
                    'status'=>"ok",
                    'success'=>true,
                    'message'=>'Record Updated'
                ];
                exist(json_encode($response));
            }
            else{
                $response=[
                    'status'=>"ok",
                    'success'=>true,
                    'message'=>'Record Not Updated'
                ];
                exist(json_encode($response));
            }
        
        
        }

        public function deleteData(){
            $id=$_POST['id'];
            $status = 'inactive';
            $sql = "UPDATE `student_data` SET `status`= '$status' WHERE   `student_id`='$id'";

            if($this->conn->Execute($sql)){
                $response=[
                    'status'=>'ok',
                    'success'=>true,
                    'message'=>'Record DELETED successfully!'

                ];
                exit(json_encode($response));
            }else{
                $response=[
                    'status'=>'ok',
                    'success'=>true,
                    'message'=>'Record Not DELETED successfully!'

                ];
                exit(json_encode($response));   
            }

            
        }
        public function addMarks()
        {

            $id = $_POST['id'];
            $cm =$_POST['cm'];
            $pm =$_POST['pm'];
            $mm =$_POST['mm'];
            $hm =$_POST['hm'];
            $em =$_POST['em'];
            $total_marks = $cm+$pm+$mm+$hm+$em;
            $percent = $total_marks/5;
            $grade="";
            if($percent>=90.0 && $percent<=100.0){
                $grade='A';
            }
            else if($percent>=80.0 && $percent<=89.0){
                $grade='B';
            }
            else if($percent>=70.0 && $percent<=79.0){
                $grade='C';
            }
            else if($percent>=60.0 && $percent<=70.0){
                $grade='D';
            }
            else {
                $grade='F';
            }

                $insert= "INSERT INTO `student_marks`(`student_id`,`english_marks`,`math_marks`,`hindi_marks`,`physics_marks`,`chemistry_marks`,`grade`,`student_total_marks`) 
                values ('{$id}','{$em}','{$mm}','{$hm}','{$pm}','{$cm}','{$grade}','{$total_marks}')"; 

                if($this->conn->Execute($insert)){
                    $response=[
                        'status'=>"ok",
                        'success'=>true,
                        'message'=>'Marks entered successfully'
                    ];
                    exit(json_encode($response));
                }
                else{
                    $response = [
                        'status'=>'ok',
                        'success'=>false,
                        'message'=>'Marks not entered'
                    ];
                    exit(json_encode($response));
                }
                
               
         
            

        }
        public function generate_pdf_report(){
           
            $to_date=$_POST['to_date'];
            $from_date = $_POST['from_date'];

            echo $to_date;
            echo $from_date;
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $host = "localhost";
            $dbname = "practice_db";
            $username = "root";
            $password = "";

            // Connect to the database
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);


            $query = "SELECT * FROM student_data where (DATE(created_at) BETWEEN '$from_date' AND '$to_date')";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $data = $stmt->fetchAll();

            // Set font and add table
            $pdf->SetFont('helvetica', '', 10);
            $pdf->AddPage();

            //Table Headers
            $pdf->Cell(10, 10, 'ID', 1, 0, 'C', 0, '', 0);
            $pdf->Cell(40, 10, 'Name', 1, 0, 'C', 0, '', 0);
            $pdf->Cell(15, 10, 'Roll No.', 1, 0, 'C', 0, '', 0);
            $pdf->Cell(30, 10, 'Mobile', 1, 0, 'C', 0, '', 0);
            $pdf->Cell(65, 10, 'Email', 1, 0, 'C', 0, '', 0);
            $pdf->Cell(39, 10, 'Entry Date and Time', 1, 0, 'C', 0, '', 0);
            $pdf->Ln();

            // Table data
            foreach($data as $row) {
                $pdf->Cell(10, 10, $row['id'], 1, 0, 'C', 0, '', 0);
                $pdf->Cell(40, 10, $row['name'], 1, 0, 'C', 0, '', 0);
                $pdf->Cell(15, 10, $row['rollno'], 1, 0, 'C', 0, '', 0);
                $pdf->Cell(30, 10, $row['mobile'], 1, 0, 'C', 0, '', 0);
                $pdf->Cell(65, 10, $row['email'], 1, 0, 'C', 0, '', 0);
                $pdf->Cell(39, 10, $row['entry_datetime'], 1, 0, 'C', 0, '', 0);
                $pdf->Ln();
            }

        // Output the PDF document
        $pdf->Output('Student Data.pdf', 'D');

            
        }

        public function getDataForDocs(){
            $sql = "SELECT student_data.student_id,student_docs.adhar_front,student_docs.adhar_back,student_docs.pancard
            FROM student_data
            LEFT JOIN student_docs
            ON student_data.student_id = student_docs.student_id
            WHERE status ='active'";
            $result = $this->conn->Execute($sql);
            
             if($result->rowCount()>0)
             {
                $data = [];
                while($row=$result->fetch(PDO::FETCH_ASSOC,PDO::FETCH_ORI_NEXT)){
                    $data[] = $row;
                }
                exit(json_encode($data));
             }else{
                $data['empty']=['empty'];
                exit(json_encode($data));
            }
            
        }

        public function getStateAndCityByPincode(){
        
        $pincode = $_POST['pincode'];
        $data = file_get_contents('http://postalpincode.in/api/pincode/' . $pincode);
        // echo $data;
        $data = json_decode($data);
        // echo '<pre>';
        // print_r($data);
        if(isset($data->PostOffice['0'])){
            // print_r($data->PostOffice['0']);
            $arr['city'] = $data->PostOffice['0']->District;
            $arr['state'] = $data->PostOffice['0']->State;
            // print_r($arr);
            echo json_encode($arr);
        }else{
            echo json_encode('no');
        }


        }
    }

    $sdc=new StudentDataController();
    $sdc->action();


?> 

