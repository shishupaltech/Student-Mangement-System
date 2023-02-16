var img_Aadhar_Card_Front_Base64;
var img_Aadhar_Card_Back_Base64;
var imgPancard_Base64;
var fileSize;
var maxfileSize = 300;
$(document).ready(function (e) {
  $("input[type = file][name = adhar_card_front]").change(function () {
    // alert("11");
    fileSize = this.files[0].size / 1024;
    // alert(121);
    if (!checkImage(this.files[0].name)) {
      // alert(12);
      alert(this.files[0].name + " :- Is Not Valid Image..");
      $(this).val("");
      img_Aadhar_Card_Front_Base64 = "";
      $("#bteimgPreview").attr("src", "./images/userprofile.jpg");
    } else if (fileSize > maxfileSize) {
      // alert(123);
      alert(
        "File size should be less than or equal to " + maxfileSize + " kb."
      );
      $(this).val("");
      img_Aadhar_Card_Front_Base64 = "";
    } else {
      // alert("1234");
      readURLFront(this);
    }
  });
  $("input[type = file][name = adhar_card_back]").change(function () {
    // alert("11");
    fileSize = this.files[0].size / 1024;
    // alert(121);
    if (!checkImage(this.files[0].name)) {
      alert(12);
      alert(this.files[0].name + " :- Is Not Valid Image..");
      $(this).val("");
      img_Aadhar_Card_Back_Base64 = "";
      $("#bteimgPreview").attr("src", "./images/userprofile.jpg");
    } else if (fileSize > maxfileSize) {
      // alert(123);
      Alert(
        "File size should be less than or equal to " + maxfileSize + " kb."
      );
      $(this).val("");
      img_Aadhar_Card_Back_Base64 = "";
    } else {
      // alert("1234");
      readURLBack(this);
    }
  });
  $("input[type = file][name = pancard]").change(function () {
    // alert("11");
    fileSize = this.files[0].size / 1024;
    alert(121);
    if (!checkImage(this.files[0].name)) {
      // alert(12);
      alert(this.files[0].name + " :- Is Not Valid Image..");
      $(this).val("");
      imgPancard_Base64 = "";
      $("#bteimgPreview").attr("src", "./images/userprofile.jpg");
    } else if (fileSize > maxfileSize) {
      // alert(123);
      Alert(
        "File size should be less than or equal to " + maxfileSize + " kb."
      );
      $(this).val("");
      imgPancard_Base64 = "";
    } else {
      // alert("1234");
      readURLPanCard(this);
    }
  });
  $("#addStudentModal").click(function () {
    $("#addModal").css({ display: "block" });
    // console.log("shishupal");
  });

  $("#generateReport").click(function (e) {
    {
      e.preventDefault();
      $("#dateModal").css({ display: "block" });
    }
  });


  $("#new-submit").click(function () {
    // alert(img_Aadhar_Card_Back_Base64);
    // alert(img_Aadhar_Card_Front_Base64);
    // alert(imgPancard_Base64);
    var name = $("#fname").val();
    // alert(name);
    var email = $("#email").val();
    // alert(email);
    var mobile = $("#mobile").val();
    // alert(mobile);
    var pincode = $("#pincode").val();
    // alert(pincode);
    var city = $("#city").val();
    // alert(city);
    var state = $("#state").val();
    // alert(state);

    var action = "addStudentData";
    var formData = new FormData();
    formData.append("action", action);
    formData.append("name", name);
    formData.append("email", email);
    formData.append("mobile", mobile);
    formData.append("pincode", pincode);
    formData.append("city", city);
    formData.append("state", state);

    formData.append("adharCardFront", img_Aadhar_Card_Front_Base64);
    formData.append("adharCardBack", img_Aadhar_Card_Back_Base64);
    formData.append("pancard", imgPancard_Base64);
    if (name == "") {
      alert("Please Enter  Name");
      return false;
    }
    if (email == "") {
      alert("Please Enter Email id");
      return false;
    }
    if (mobile == "") {
      alert("Please Enter mobile");
      return false;
    } else {
      $.ajax({
        type: "POST",
        url: "classes/StudentDataController.php",
        //call storeinfodata.php to store form data
        processData: false,
        contentType: false,
        data: formData,
        success: function (response) {
          console.log(response);
          if (response) {
            show_message("success", "Data is Inserted Successfully");
            loadTable();
            $("#addModal").css({ display: "none" });
            document.getElementById("addModal-form").reset();
            show_message("success", "Data is submitted successfully");
          } else {
            show_message("error", "Data is submitted successfully");
          }
        },
      });
    }
    return false;
  });
});

function hide_modal() {
//   console.log("shishupal isngh fromalkdjf");
  $("#addModal").css({ display: "none" });
  $("#modal").css({ display: "none" });
  $("#addMarksModal").css({ display: "none" });
  formReset();

  $("#dateModal").css({ display: "none" });
  $("#imgModal").css({display:"none"});

}
function formReset() {
  document.getElementById("physics-marks").value = "";
  document.getElementById("chemistry-marks").value = "";
  document.getElementById("mathematics-marks").value = "";
  document.getElementById("english-marks").value = "";
  document.getElementById("hindi-marks").value = "";

  document.getElementById("from_date").value = "";
  document.getElementById("to_date").value = "";
  document.getElementById("city").value ="";
  document.getElementById("state").value="";
  document.getElementById("pincode").value ="";


}
function checkImage(fileName) {
  var extension = ["png", "gif", "jpeg", "jpg"];
  var n = fileName.substring(fileName.lastIndexOf(".") + 1);
  var name = fileName;
  return extension.includes(n.toLowerCase());
}

function readURLFront(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      img_Aadhar_Card_Front_Base64 = e.target.result;
      
    };

    reader.readAsDataURL(input.files[0]);
  }
}
function readURLBack(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      img_Aadhar_Card_Back_Base64 = e.target.result;
     
    };

    reader.readAsDataURL(input.files[0]);
  }
}
function readURLPanCard(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      imgPancard_Base64 = e.target.result;
      
    };

    reader.readAsDataURL(input.files[0]);
  }
}
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      imgPancard_Base64 = e.target.result;
     
    };

    reader.readAsDataURL(input.files[0]);
  }
}

function loadTable() {
  var tr = "";
  var action = "getData";

  $.ajax({
    url: "classes/StudentDataController.php",
    type: "GET",
    data: {
      action: action,
    },
    datatype: JSON,
    success: function (data1) {
      console.log(data);
      var data = JSON.parse(data1);
      console.log(data);

      var count = 1;
      for (var i = 0; i < data.length; i++) {

        tr += `<tr>
                <td align="right">${count++}</td>
                <td align="right">${data[i].student_id}</td>
                <td align="center">${data[i].student_name}</td>
                <td align="center">${data[i].student_email}</td>
                <td align="right">${data[i].student_mobile}</td>
                <td align="right">${
                  !(data[i].student_total_marks === null)
                    ? data[i].student_total_marks
                    : "-"
                }</td>  
                
                <td align="center">${
                  !(data[i].grade === null) ? data[i].grade : "-"
                }</td>
                <td align="center">${data[i].created_at_formatted}</td>
                 
                <td align="center"><button class="edit-btn"  onclick="AddMarks(${
                  data[i].student_id
                })
                ">Marks</button></td>
                <td align="center"><button class="edit-btn"  onclick="edidtRecord(${
                  data[i].student_id
                })
                ">Edit</button></td>
                <td align="center"><button class="delete-btn" onclick="deletetRecord(${
                  data[i].student_id
                })
                ">Delete</button></td>
            </tr>`;
      }

      $("#tbody").html(tr);
    },
  }).catch((error) => {
    show_message("error", "can't fetch data");
  });
  loadTableForDocs();
}
loadTable();

function AadharFrontView(id){
    $("#imgModal").css({display:"block"});
    var action = "aadharFrontView";
    $.ajax({
        url: "classes/StudentDataController.php",
        type: "GET",
        data:{
            action:action,
            id:id
        },
        success:function(response){
            console.log(response);
            var data = JSON.parse(response);
            console.log(data);
            // $("img").attr("src", data);
            $("#showImg img").attr("src", data[0].adhar_front);
            // rawResponse = unescape(encodeURIComponent(data));

            // // create an image
            // var outputImg = document.createElement('img');
            // outputImg.src = data[0].front_adhar;
            // document.getElementById("showImg").appendChild(outputImg);
        }
    })
    
}
function AadharBackView(id){
    // alert("AadharBackView" + id);
    $("#imgModal").css({display:"block"});
    var action = "aadharBackView";
    $.ajax({
        url: "classes/StudentDataController.php",
        type: "GET",
        data:{
            action:action,
            id:id
        },
        success:function(response){
            console.log(response);
            var data = JSON.parse(response);
            console.log(data);
            // $("img").attr("src", data);
            $("#showImg img").attr("src", data[0].adhar_back);
            // rawResponse = unescape(encodeURIComponent(data));

            // // create an image
            // var outputImg = document.createElement('img');
            // outputImg.src = data[0].front_adhar;
            // document.getElementById("showImg").appendChild(outputImg);
        }
    })
}
function PanCardView(id){
    // alert("PanCardView" + id);
    
    $("#imgModal").css({display:"block"});
    var action = "panCardView";
    $.ajax({
        url: "classes/StudentDataController.php",
        type: "GET",
        data:{
            action:action,
            id:id
        },
        success:function(response){
            console.log(response);
            var data = JSON.parse(response);
            console.log(data);
            // $("img").attr("src", data);
            $("#showImg img").attr("src", data[0].adhar_back);
            // rawResponse = unescape(encodeURIComponent(data));

            // // create an image
            // var outputImg = document.createElement('img');
            // outputImg.src = data[0].front_adhar;
            // document.getElementById("showImg").appendChild(outputImg);
        }
    })
}
function loadTableForDocs() {
  var tr = "";
  var action = "getDataForDocs";

  $.ajax({
    url: "classes/StudentDataController.php",
    type: "GET",
    data: {
      action: action,
    },
    datatype: JSON,
    success: function (data) {
      data = JSON.parse(data);
      // console.log(data);

      var count = 1;
      for (var i = 0; i < data.length; i++) {
        tr += `<tr>
            <td align="center">${count++}</td>
            <td align="center">${data[i].student_id}</td>`;

        if (data[i].adhar_front !== null) {
          tr += `<td align="center"><a class="delete-btn" href='${data[i].adhar_front}' download>Download</a></td>`;
          tr+=`<td align="center" ><button class="edit-btn"  onclick="AadharFrontView(${
          data[i].student_id})">View</button></td>`
        } else {
          tr += `<td align="center">-</td>`;
          tr += `<td align="center">-</td>`;
        }
        

        if (data[i].adhar_back !== null) {
          tr += `<td align="center"><a class="delete-btn" href='${data[i].adhar_back}' download>Download</a></td>`;
          tr+=`<td align="center"><button class="edit-btn"  onclick="AadharBackView(${
           data[i].student_id})">View</button></td>`
        } else {
          tr += `<td align="center">-</td>`;
          tr += `<td align="center">-</td>`;
        }
        
        if (data[i].pancard !== null) {
          console.log(`${data[i].pancard}`);
          tr += `<td align="center"><a class="delete-btn" href='${data[i].pancard}' download>Download</a></td>`;
          tr+=`<td align="center"><button class="edit-btn"  onclick="PanCardView(${
          data[i].student_id})">View</button></td>`;
        } else {
          tr += `<td align="center">-</td>`;
          tr += `<td align="center">-</td>`;
        }
        
        tr += `</tr>`;
      }

      $("#tbody_docs").html(tr);
    },
  }).catch((error) => {
    show_message("error", "can't fetch data");
  });
}

function generate_reprt() {
  $("#dateModal").css({ display: "block" });
  var to_date = $("#to_date").val();
  var from_data = $("#from_date").val();
}
function Generate_Pdf_Report() {
  var to_date = $("#to_date").val();
  var from_date = $("#from_date").val();
  console.log(to_date, from_date);

  if (to_date == "" || from_date == "") {
    alert("All fields are required");
    return;
  }
  var tr = "";
  var action = "generate_pdf_report";
  $.ajax({
    url: "classes/pdfGenerate.php",
    type: "POST",
    data: {
      action: action,
      to_date: to_date,
      from_date: from_date,
    },
    datatype: JSON,
    success: function (data) {
      // console.log(data);
      $("#myreport").innerHTML = data;
    },
  }).catch((error) => {
    show_message("error", "can't fetch data");
  });
}

function Generate_Excel_Report() {
  console.log("Excel Report");
}
function edidtRecord(id) {
//   console.log(id);
  
        $("#modal").css({ display: "block" });
        var action = "fetchIdData";
        $.ajax({
            type: "POST",
            url: "classes/StudentDataController.php",
            //call storeinfodata.php to store form data
            data: {
            id: id,
            action: action,
            },
            success: function (respose) {
            var data = JSON.parse(respose);
            console.log(data);
            for (var i in data) {
                document.getElementById("edit-id").value = data[i].student_id;

                document.getElementById("edit-fname").value = data[i].student_name;
                // document.getElementById('edit-roll_no').value = data[i].student_roll_no;
                document.getElementById("edit-email").value = data[i].student_email;
                document.getElementById("edit-mobile").value = data[i].student_mobile;
            }
            },
        }).catch((error) => {
            show_message("error", "can't fetch data");
        });
    
}

function modify_data() {
    // alert(imgPancard_Base64);
    // alert(img_Aadhar_Card_Back_Base64);
    // alert(img_Aadhar_Card_Front_Base64);
    if (confirm("Are you sure,you want to update this record")){
          var st_id = $("#edit-id").val();
          var name = $("#edit-fname").val();

          var email = $("#edit-email").val();
          var mobile = $("#edit-mobile").val();

          console.log(st_id, name, email, mobile);
        //   formData.append("adharCardFront", img_Aadhar_Card_Front_Base64);
        //     formData.append("adharCardBack", img_Aadhar_Card_Back_Base64);
        //     formData.append("pancard", imgPancard_Base64);

          if (name === "" || email === "" || mobile == "") {
            alert("Please fill all the Fields");
            return false;
          } else {
            var action = "updataData";
            $.ajax({
              type: "POST",
              url: "classes/StudentDataController.php",
              //call storeinfodata.php to store form data
              data: {
                action: action,
                id: st_id,
                name: name,
                email: email,
                mobile: mobile,
                adharCardFront: img_Aadhar_Card_Front_Base64,
                adharCardBack: img_Aadhar_Card_Back_Base64,
                pancard:imgPancard_Base64
                  
              },
              success: function (response) {
                $("#modal").css({ display: "none" });

                show_message("success", "data successfully edit");

                loadTable();
              },
            });
          }
        }
}

function deletetRecord(id) {
  if (confirm("Are you sure want to Delete this record")) {
    console.log(id);
    var action = "deleteData";
    $.ajax({
      type: "POST",
      url: "classes/StudentDataController.php",

      data: {
        id: id,
        action: action,
      },
      success: function (respose) {
        show_message("succes", "Data deleted is successfully");
        loadTable();
      },
    }).catch((error) => {
      show_message("error", "can't fetch data");
    });
  }
  loadTableForDocs();
}

function AddMarks(id) {
  $("#addMarksModal").css({ display: "block" });
  // console.log(id);
  document.getElementById("add-id").value = id;
}

function add_Marks() {
  var physics_marks = $("#physics-marks").val();
  var chemistry_marks = $("#chemistry-marks").val();
  var mathematics_marks = $("#mathematics-marks").val();
  var english_marks = $("#english-marks").val();
  var st_id = $("#add-id").val();
  var hindi_marks = $("#hindi-marks").val();
  console.log(
    physics_marks,
    chemistry_marks,
    mathematics_marks,
    hindi_marks,
    english_marks,
    st_id
  );

  if (
    physics_marks === "" ||
    chemistry_marks === "" ||
    mathematics_marks === "" ||
    english_marks == "" ||
    st_id === "" ||
    hindi_marks === ""
  ) {
    alert("Please fill all the Fields");
    return false;
  } else {
    var action = "addMarks";
    $.ajax({
      type: "POST",
      url: "classes/StudentDataController.php",

      data: {
        id: st_id,

        action: action,
        cm: chemistry_marks,
        pm: physics_marks,
        mm: mathematics_marks,
        em: english_marks,
        hm: hindi_marks,
      },
      success: function (respose) {
        

        show_message("success", "Marks is added successfully");
        loadTable();
      }
    }).catch((error) => {
      show_message("error", "can't fetch data");
    });
  }
}
function getPincode(){
  // alert("han okay");
  // document.getElementById("city").value = "agra";
  // document.getElementById("state").value="uttar pradesh";
  // var pincode = document.getElementById("pincode").value;
  var pincode = $("#pincode").val();
  // alert(pincode);
  if(pincode===''){
    document.getElementById("city").value ="";
    document.getElementById("state").value="";
  }else{
    var action ="getStateAndCityByPincode";
    $.ajax({
        type: "POST",
        url: "classes/StudentDataController.php",
        //call storeinfodata.php to store form data
        data:{
        action: action,
        pincode:pincode,
        },
        success:function(data){
          // console.log(data);
          
          if(JSON.parse(data)=='no'){
            alert(`your pincode is wrong ${pincode} `);
            document.getElementById("city").value ="";
            document.getElementById("state").value="";
            document.getElementById("pincode").value ="";
            return;
          }
          else{
          var getData = JSON.parse(data);
          console.log(getData);
          if(getData.state=='Uttar Pradesh' || getData.state=='Maharashtra'){
            alert(`state not allowed for ${getData.state}`);
            document.getElementById("pincode").value ="";
            return;
          }
          document.getElementById("city").value =getData.city;
          document.getElementById("state").value=getData.state;}
        }
    })
  }
}

function show_message(type, text) {
  if (type == "error") {
    var message_box = document.getElementById("error-message");
  } else {
    var message_box = document.getElementById("success-message");
  }
  message_box.innerHTML = text;
  message_box.style.display = "block";
  setTimeout(function () {
    message_box.style.display = "none";
  }, 3000);
}
