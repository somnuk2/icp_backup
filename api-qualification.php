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
    $member_id          = (int)$request_data->member_id;
    $qualification_name = "'". $request_data->qualification_name ."'";
    // $data = array(
    //     ":member_id" => $request_data->member_id,
    //     ":qualification_name" => $request_data->qualification_name,
    // );
    $query = "INSERT INTO qualification (member_id,qualification_name) 
              VALUES($member_id , $qualification_name)";
    $statement = $connect->prepare($query);
    $statement->execute($data);
    $output = array(" message " => " Insert Complete ");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
} else if ($request_data->action == "getall") {
    // echo " getAllUser ";
    $query = "SELECT * FROM qa_plane_career as qa_pc
              INNER JOIN qualification as qa ON qa_pc.qualification_id = qa.qualification_id
              INNER JOIN plan_career as pc ON qa_pc.plan_career_id = pc.Plan_Career_id
              INNER JOIN career as ca ON pc.Career_id = ca.career_id";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
} else if ($request_data->action == "edit") {
    $query = "SELECT * FROM qualification WHERE qualificationId = $request_data->qualificationId";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data['qualificationId'] = $row['qualificationId'];
        $data['planCareerId'] = $row['planCareerId'];
        $data['skill'] = $row['skill'];
        $data['level'] = $row['level'];
        $data['goal'] = $row['goal'];
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
} else if ($request_data->action == "update") {
    $data = array(
        ":qualificationId" => $request_data->qualificationId,
        ":planCareerId" => $request_data->planCareerId,
        ":skill" => $request_data->skill,
        ":level" => $request_data->level,
        ":goal" => $request_data->goal
    );
    $query = "UPDATE qualification 
    SET 
        qualificationId=:qualificationId,
        planCareerId=:planCareerId,
        skill=:skill,
        level=:level,
        goal=:goal
    WHERE qualificationId=:qualificationId";
    $statement = $connect->prepare($query);
    $statement->execute($data);
    $output = array("message" => "Update Complete");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
} else if ($request_data->action == "delete") {
    $query = "DELETE FROM qualification WHERE qualificationId = $request_data->qualificationId";
    $statement = $connect->prepare($query);
    $statement->execute();
    $output = array("message" => "Delete Complete");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
}
