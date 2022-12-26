<?php
function cors()
{
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }
    // echo "You have CORS!";
}

cors();

$request_data = json_decode(file_get_contents("php://input"));
$data = array();
$servername = "localhost";
$username = "u486700931_root";
$password = "B^&AVvb7g";
$database = "u486700931_icp";

try {
        $connect = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully"; 
    } catch(PDOException $e) {    
        echo "Connection failed: " . $e->getMessage();
    }

if ($request_data->action == "insert") {
    echo " insert ";
    $data = array(
        ":member_id" => $request_data->member_id,
        ":full_name" => $request_data->full_name,
        ":email" => $request_data->email,
        ":password" => $request_data->password,
        ":status" => $request_data->status
    );
    $query = "INSERT INTO member (member_id,
                                  full_name,email,password,status) 
              VALUES(:member_id,:full_name,:email,:password,:status)";
    $statement = $connect->prepare($query);
    $statement->execute($data);
    $output = array(" message " => " Insert Complete ");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
} else if ($request_data->action == "getall") {
    $query = "SELECT * FROM member";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
} else if ($request_data->action == "checkMember") {
    $query = "SELECT member_id,full_name,status FROM member 
              WHERE email= '" . $request_data->user . "' 
              AND password='" . $request_data->pass . "';";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
} else if ($request_data->action == "edit") {
    $query = "SELECT * FROM member WHERE member_id = $request_data->id";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data['member_id'] = $row['member_id'];
        $data['full_name'] = $row['full_name'];
        $data['email'] = $row['email'];
        $data['password'] = $row['password'];
        $data['status'] = $row['status'];
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
} else if ($request_data->action == "update") {
    $data = array(
        ":member_id" => $request_data->member_id,
        ":full_name" => $request_data->full_name,
        ":email" => $request_data->email,
        ":password" => $request_data->password,
        ":status" => $request_data->status,
    );
    $query = "UPDATE member 
    SET 
        member_id=:member_id,
        full_name=:full_name,
        email=:email,
        password=:password,
 	status=:status
    WHERE member_id = :member_id";
    $statement = $connect->prepare($query);
    $statement->execute($data);
    $output = array("message" => "Update Complete");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
} else if ($request_data->action == "delete") {
    $query = "DELETE FROM member 
    WHERE member_id = $request_data->id";
    $statement = $connect->prepare($query);
    $statement->execute();
    $output = array("message" => "Delete Complete");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
}
?>