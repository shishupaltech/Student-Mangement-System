<form action="assignment.php" method="post">
  <input type="text" name="input_string" placeholder="Enter Your String">
  <input type="text" name="char" placeholder="Enter Character">
  <input type="submit" value="Submit">
</form>

<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $string = $_POST["input_string"];
    $char = $_POST["char"];
    // echo $input_string;
    // echo $char;
  $find ="Character is not found in '${string}'." ;
  $countCharacter=0;
  $indexArr=[];
 
  // finding the character in string
  // s - 1;
  // o - 2;
  // n - 3;
  // u - 4;
  // -5;
  // c - 6;
  // h - 7;
  // a - 8;
  // u - 9;
  // d - 10;
  // h - 11;
  // a - 12;
  // r - 13;
  // y - 14;
  for($i=strlen($string)-1;$i>=0;$i--){
    
  		// condition for check given character is present or not
  		if($string[$i]==$char){
         $find="Character '$char' is found in '${string}'.";
         // storing the indexes of given character in store 
         // countCharacter is working of counting character which is given by user 			 //	along with index in array.
         $indexArr[$countCharacter++] = $i;
         }
	}
    echo "${find} </br>";
    echo "Gieven character '$char' frequency is =  ";
    echo "$countCharacter in given string  '$string'.</br>";
    echo "Character is present at indexes which are = ";
    if (isset($indexArr)) {
        foreach ($indexArr as $val)
            echo $val . ", ";
    }

  }
?>

