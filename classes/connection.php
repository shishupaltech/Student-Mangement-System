
<?php

class config {

    const MainServerIP = 'localhost';
    const MainLoginName = 'root';
    const MainPassWord = '';
    const MainDatabase = 'recordsofstudents';
    
}

// class Connection extends config {

//     private $Link;

//     function Connection($conntype = "MAIN", $loginname = "", $password = "", $dbname = "") {
//         if (trim($conntype) != "" && trim($loginname) != "" && trim($password) != "" && trim($dbname) != "") {
//             $this->Link = mysql_connect($conntype, $loginname, $password, true)
//                     or die('Error-Could not connect OTHER: ');
//             mysql_select_db($dbname, $this->Link) or die('Error-Could not select database ' . $dbname);
//         } else if ("MAIN" == strtoupper(trim($conntype))) {
//             $this->Link = mysql_connect(self::MainServerIP, self::MainLoginName, self::MainPassWord, true) or die('Error-Could not connect MAIN: ');
//             mysql_select_db(self::MainDatabase, $this->Link) or die('Error-Could not select database MAIN');
//         } else if ("REP" == strtoupper(trim($conntype))) {
//             $this->Link = mysql_connect(self::RepServerIP, self::RepLoginName, self::RepPassWord, true) or die('Error-Could not connect REP: ');
//             mysql_select_db(self::RepDatabase, $this->Link) or die('Error-Could not select database REP');
//         } else if ("RC" == strtoupper(trim($conntype))) {
//             $this->Link = mysql_connect(self::RCaredbip, self::RCareLoginName, self::RCarePassWord, true) or die('Error-Could not connect RC: ');
//             mysql_select_db(self::RCDatabase, $this->Link) or die('Error-Could not select database RC');
//         } else if ("DNS" == strtoupper(trim($conntype))) {
//             $this->Link = mysql_connect(self::DnsServerIP, self::DnsLoginName, "tender", true) or die('#Error:Could not connect MAIN: ');
//             mysql_select_db(self::DnsDatabase, $this->Link) or die('#Error:Could not select database MAIN');
//         } else
//             exit('Error-Invalid connection type. ');
//     }

//     function __destruct() {
//         if ($this->Link)
//             mysql_close($this->Link);
//     }

//     function Execute($query, $errormsg = "") {
//         if ("" == $query)
//             return ("Query Empty.");
//         $result = mysql_query($query, $this->Link) or
//                 die(trim($errormsg) != "" ? $errormsg . mysql_error($this->Link) : 'Error-Query failed: '.$query );
//         return $result;
//     }

//     function fetchAll($query, $errormsg = "") {
//         if ("" == $query)
//             return (array("Query Empty."));
//         $result = mysql_query($query, $this->Link) or
//                 die(trim($errormsg) != "" ? $errormsg : 'Error-Query failed: ' );
//         If (mysql_num_rows($result) <= 0)
//             return (array("No Record Found."));
//         $data = array();
//         while ($srow = mysql_fetch_object($result)) {
//             $data[] = clone($srow);
//         }
//         mysql_free_result($result);
//         return $data;
//     }

//     function fetchArray($query) {
//         if ("" == $query)
//             return (array("Query Empty."));
//         $result = mysql_query($query, $this->Link) or
//                 die(array('Error-Query failed: '));
//         If (mysql_num_rows($result) <= 0)
//             exit(array("No Record Found."));
//         $data = array();
//         while ($srow = mysql_fetch_assoc($result)) {
//             $data[] = clone($srow);
//         }
//         mysql_free_result($result);
//         return $data;
//     }

// }

class ConnPDO extends config {

    public $Link;

    public function __construct($conntype = "MAIN", $loginname = "", $password = "", $dbname = "") {
        if (trim($conntype) != "" && trim($loginname) != "" && trim($password) != "" && trim($dbname) != "") {
            try {
                $this->Link = new PDO("mysql:host=$conntype; dbname=$dbname", $loginname, $password);
            } catch (PDOException $e) {
                exit($e->getMessage());
            }
        } else if ("MAIN" == strtoupper(trim($conntype))) {
            try {
                $this->Link = new PDO("mysql:host=" . self::MainServerIP . "; dbname=" . self::MainDatabase, self::MainLoginName, self::MainPassWord);
            } catch (PDOException $e) {
                exit($e->getMessage());
            }
        } else if ("REP" == strtoupper(trim($conntype))) {
            try {
                $this->Link = new PDO("mysql:host=" . self::RepServerIP . "; dbname=" . self::RepDatabase, self::RepLoginName, self::RepPassWord);
            } catch (PDOException $e) {
                exit($e->getMessage());
            }
        } else if ("RC" == strtoupper(trim($conntype))) {
            try {
                $this->Link = new PDO("mysql:host=" . self::RCServerIP . "; dbname=" . self::RCDatabase, self::RCLoginName, self::RCPassWord);
            } catch (PDOException $e) {
                exit($e->getMessage());
            }
        } else if ("DNS" == strtoupper(trim($conntype))) {
            try {
                $this->Link = new PDO("mysql:host=" . self::DnsServerIP . "; dbname=" . self::DnsDatabase, self::DnsLoginName, self::DnsLoginPassword);
            } catch (PDOException $e) {
                exit($e->getMessage());
            }
        } else
            exit('Error-Invalid connection type. ');
    }

    function __destruct() {
        // if($this->Link)
        //   mysql_close($this->Link);
    }

    function Instance() {
        return $this->Link;
    }

//  while ($row = $res->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) { 
    function Execute($query) {
        if ("" == $query)
            return ("Query Empty.");
        try {
            $stmt = $this->Link->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute() or die("Error-" . print_r($stmt->errorInfo(), true));
            return $stmt;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function fetchArray($query) {
        $sth = $this->Link->prepare($query);
        $sth->execute() or die("Error-" . print_r($sth->errorInfo(), true));
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    function fetchAll($query, $type = PDO::FETCH_OBJ) {
        $sth = $this->Link->prepare($query);
        $sth->execute() or die("Error-" . print_r($sth->errorInfo(), true));
        return $sth->fetchAll($type);
    }

    function fetchColumnArray($query, $columnIndex) {
        $sth = $this->Link->prepare($query);
        $sth->execute() or die("Error-" . print_r($sth->errorInfo(), true));
        $ColumnArray = $sth->fetchAll(PDO::FETCH_COLUMN, $columnIndex);
        return $ColumnArray;
    }

}

$db = new ConnPDO();
$phppara = "";
foreach ($_POST as $key => $para) {
    if (is_array($para))
        continue;
    $phppara .= $key . "=" . $para . "&";
}

//$query_requestlog = "INSERT INTO requestlog (reqmethod ,serverip ,remoteip ,requrl ,phppara ,reqtime) "
//        . "values('" . $_SERVER["REQUEST_METHOD"] . "','" . $_SERVER["SERVER_ADDR"] . "','" . $_SERVER["REMOTE_ADDR"] . "',\"http://" . $_SERVER["SERVER_ADDR"] . $_SERVER["REQUEST_URI"] . "\",\"" . $phppara . "\",now())";
//$db->Execute($query_requestlog);
//unset($query_requestlog);
?>