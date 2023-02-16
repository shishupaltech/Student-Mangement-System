<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP & Javascript Fetch CRUD</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/responsive.css">
    <script src="js/jquery.js"></script>
    <script src="js/ajax-file.js?1"></script>
   
</head>
<body>
    
    <div  class=" info-upper-bg-img">
        <div class="infor-upper-color">
            <h1>Information About The Students</h1>
        </div>
    </div>
    <div id="main">
        <!-- <div id="header">
            <h2>CRUD OPERATION USING AJAX & PHP  </h2>
            <div id="search-bar">
                <label>Search : </label>
                <input type="text" id="search" onkeyup="load_search()" autocomplete="off">
            </div>
        </div> -->
        <div id="table-data">
            <!-- <h3>All Records</h3> -->
            <button class="generate_report"  id="generateReport" >Generate Report</button>
            <button class="add_new"  id="addStudentModal">Add New</button>
            <table class="table" border="1" width="100%" cellspacing="0" cellpadding="10px">
                <thead>
                    <tr>
                        <th width="60px">SN.</th>
                        <th >St_Roll_No</th>
                        <th >St_Name</th>
                        <th >St_Email</th>
                        <th >St_Mobile</th>
                        <th >total_marks</th>
                        <th >Grade</th>
                        <th>Date&Time</th>
                        <th width="90px">Marks</th>
                        <th width="90px">Edit</th>
                        <th width="90px">Delete</th>
                        
                    </tr>
                </thead>
                <tbody id="tbody">
                    
                </tbody>
            </table>
        </div>
        <div id="error-message"></div>
        <div id="success-message"></div>

                        

    </div>
    <!-- modal for show add new -->
    <div id="addModal">
        <div id="modal-form">
            <h2>Add New Record Of Student</h2>
            <form method="POST" id="addModal-form">
                <table cellpadding="10px" width="100%" id="add-form">
                    <tr>
                        <td width="90px">Name</td>
                        <td><input type="text" id='fname' required></td>
                    </tr>
                    
                    <tr>
                        <td width="90px">Email</td>
                        <td><input type="text" id='email' required></td>
                    </tr>
                    <tr>
                        <td width="90px">Mobile</td>
                        <td><input type="text" id='mobile' required></td>
                    </tr>
                    <tr>
                        <td width="90px">Pincode</td>
                        <td><input type="text" id='pincode' autocomplete="new_password" onblur="getPincode()" required></td>
                    </tr>
                    <tr>
                        <td width="90px">City</td>
                        <td><input type="text" id='city' disabled placeholder="City" required></td>
                    </tr>
                    <tr>
                        <td width="90px">State</td>
                        <td><input type="text" id='state' disabled placeholder="State" required></td>
                    </tr>
                    <tr>
                        <td width="90px"><label for="adhar_card_front">Adhar Card Front Image</label></td>
                        <td><input type="file" class="form-control" id="adhar_card_front" name="adhar_card_front" required></td>
                    </tr>
                    <tr>
                        <td width="90px"><label for="adhar_card_back">Adhar Card Back Image</label></td>
                        <td><input type="file" class="form-control" id="adhar_card_back" name="adhar_card_back" required></td>
                    </tr>
                    <tr>
                        <td width="90px"><label for="pancard">Pancard Image</label></td>
                        <td><input type="file" class="form-control" id="pancard" name="pancard" required></td>
                    </tr>
                        
                    <tr>
                        <td></td>
                        <td><button type="button"  id='new-submit'>Save me</button></td>
                    </tr>   
                </table>
            </form>
            <div id="close-btn" class="hide_modal" onclick="hide_modal()">X</div>
        </div>
    </div>

    <!-- madal for show edit  -->
    <div id="modal">
        <div id="modal-form">
            <h2>Edit Form</h2>
            <form method="POST">
                <table cellpadding="10px" width="100%" id="edit-form">
                    <tr>
                        <td width='90px'>Name</td>
                        <td>
                            <input type='text' id='edit-fname' autocomplete="off">
                            <input type = 'text' id='edit-id' hidden>
                        </td>
                    </tr>
                    <!-- <tr>
                        <td width='90px'>Roll No</td>
                        <td>
                            <input type='text' id='edit-roll_no' autocomplete="off">
                            
                        </td>
                    </tr> -->
                    <tr>
                        <td width='90px'>Email</td>
                        <td>
                            <input type='text' id='edit-email' autocomplete="off">
                            
                        </td>
                    </tr>
                    <tr>
                        <td width='90px'>Mobile</td>
                        <td>
                            <input type='text' id='edit-mobile' autocomplete="off">
                           
                        </td>
                    </tr>
                    <tr>
                        <td width="90px"><label for="adhar_card_front">Adhar Card Front Image</label></td>
                        <td><input type="file" class="form-control" id="adhar_card_front" name="adhar_card_front"></td>
                    </tr>
                    <tr>
                        <td width="90px"><label for="adhar_card_back">Adhar Card Back Image</label></td>
                        <td><input type="file" class="form-control" id="adhar_card_back" name="adhar_card_back"></td>
                    </tr>
                    <tr>
                        <td width="90px"><label for="pancard">Pancard Image</label></td>
                        <td><input type="file" class="form-control" id="pancard" name="pancard"></td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td><button type="button" onclick='modify_data()' id='edit-submit'>Update</button></td>
                    </tr>  
                </table>
            </form >
            <div id="close-btn" class="hide_modal" onclick="hide_modal()">X<div>
            </div>
            </div>

        </div>
    </div>


    <div id="addMarksModal">
        <div id="modal-form">
            <h2>Add Marks Of Students</h2>
            <form method="POST" id="addModal-form">
                <table cellpadding="10px" width="100%" id="add-form">
                    <tr>
                        <td width="90px">Physics</td>
                        <td>
                            <input type="text" id='physics-marks'>
                            <input type = 'number' id='add-id' hidden>
                        </td>
                    </tr>
                    <tr>
                        <td width="90px">Chemistry</td>
                        <td><input type="text" id='chemistry-marks'></td>
                    </tr>
                    <tr>
                        <td width="90px">Mathematics</td>
                        <td><input type="text" id='mathematics-marks'></td>
                    </tr>
                    <tr>
                        <td width="90px">English</td>
                        <td><input type="text" id='english-marks'></td>
                    </tr>
                    <tr>
                        <td width="90px">Hindi</td>
                        <td><input type="text" id='hindi-marks'></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="text" onclick='add_Marks()' id='marks-submit'>Add Marks</button></td>
                    </tr>   
                </table>
            </form>
            <div id="close-btn" class="hide_modal" onclick="hide_modal()">X</div>
        </div>
    </div>

    <!-- Modal for the date to and from -->
    <div id="dateModal">
        <div id="modal-form">
            <h2>Generate Report </h2>
            <form method="POST" action="classes/pdfGenerate.php" id="generatePdf" >
                <table cellpadding="10px" width="100%" id="add-form">
                    <tr>
                        <td width="90px">from date</td>
                        <td><input type="date"  name = "from_date" id='to_date'></td>
                    </tr>
                    <tr>
                        <td width="90px">to date</td>
                        <td><input type="date" name="to_date"  id='from_date'></td>
                    </tr>
                    
                    
                        
                    <!-- <tr>
                        <td><button type="submit"  id='generate-pdf' >Generate Pdf</button></td>
                        <td><button type="submit"  id='generate-excel' formaction="classes/excelGenerate.php">Generate Excel</button></td>
                    </tr>    -->
                </table>
                <div id="button-div">

                    <button type="submit"  id='generate-pdf' >Generate Pdf</button>
                    <button type="submit"  id='generate-excel' formaction="classes/excelGenerate.php">Generate Excel</button>
                </div>
            </form>
            <div id="close-btn" class="hide_modal" onclick="hide_modal()">X</div>
        </div>
    </div>

    
    
 <!-- modal for the pop images -->
 <div id="imgModal">
        <div id="modal-form-img">
            <div id="showImg">
            <img  alt="buttonpng" border="0" />
            </div>
            
            
            <div id="close-btn" class="hide_modal" onclick="hide_modal()">X</div>
        </div>
    </div>
 <!-- modal for the docs  -->
 <div class="info-upper-bg-img">
        <div class="infor-upper-color">
            <h1>All The Documents Of The Student</h1>
        </div>
    </div>
    <div id="container main">
        
        <div id="table-data">
            <h3>All Documents Of Students</h3>
            
            <table class="table" border="1" width="100%" cellspacing="0" cellpadding="10px">
                <thead>
                    <tr>
                        <th width="60px">SR.</th>
                       
                        <th >St_Roll_No</th>
                        <th >AadharCardFront</th>
                        <th >AadharCardFrontView</th>
                        <th >AadharCardBack</th>
                        <th >AadharCardBackView</th>
                        <th >Pancard</th>    
                        <th >PancardView</th>    
                    </tr>
                </thead>
                <tbody id="tbody_docs" >
                    
                </tbody>
            </table>
        </div>
        <div id="error-message"></div>
        <div id="success-message"></div>
</div>
    <h3><span class="span">Note*</span> Grade is calculated on the basis of percentage</h3>
    <div class="footer">
        <p>Author: Shishupal Singh</p>
        <p><a href="">codeshishupal@gmail.com</a></p>
    </div>
    

</body>
</html>
