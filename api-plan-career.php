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
    $plan_career_id = (int)$request_data->plan_career_id;
    // ผู้สร้างชื่ออาชีพ
    $member_id      = (int)$request_data->member_id;
    // ชื่ออาชีพ
    $career_id      = (int)$request_data->career_id;
    // วันเริ่มแผนอาชีพ + วันสิ้นสุดแผนอาชีพ
    $start_date     = "'". $request_data->start_date ."'";
    $end_date       = "'". $request_data->end_date ."'";
    // $data = array(
    //     ":plan_career_id" => $request_data->plan_career_id,
    //     ":member_id" => $request_data->member_id,
    //     ":career_id" => $request_data->career_id,
    //     ":start_date" => $request_data->start_date,
    //     ":end_date" => $request_data->end_date,
    // );
    $query = "INSERT INTO plan_career (plan_career_id,
                                    member_id,
                                    career_id,
                                    start_date,
                                    end_date) 
                                    VALUES($plan_career_id,
                                    $member_id,
                                    $career_id,
                                    $start_date,
                                    $end_date)
                                    ;";
    $statement = $connect->prepare($query);
    $statement->execute($data);
    $output = array(" message " => " Insert Complete ");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
} 
// else if ($request_data->action == "getAll") {
//     $query = "SELECT * FROM plan_career;";
//     $statement = $connect->prepare($query);
//     $statement->execute();
//     while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
//         $data[] = $row;
//     }
//     echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
// }
else if ($request_data->action == "getAll") {
    $query = "SELECT * FROM plan_career as pla
                      INNER JOIN career as car ON pla.career_id=car.career_id
                      ORDER BY pla.career_id asc;";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);

}
else if ($request_data->action == "getall") {
    $query = "SELECT * FROM plan_career";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
} 
else if ($request_data->action == "edit") {
    $query = "SELECT * FROM plan_career as pla
                      INNER JOIN career as car ON pla.career_id = car.career_id
                      WHERE pla.plan_career_id = $request_data->plan_career_id
              ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data['plan_career_id'] = $row['plan_career_id'];
        $data['member_id'] = $row['member_id'];
        $data['career_id'] = $row['career_id'];
        $data['start_date'] = $row['start_date'];
        $data['end_date'] = $row['end_date'];
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
} 
else if ($request_data->action == "update") {
    $plan_career_id = (int)$request_data->plan_career_id;
    // ผู้สร้างชื่ออาชีพ
    $member_id      = (int)$request_data->member_id;
     // ชื่ออาชีพ
    $career_id      = (int)$request_data->career_id;
    // วันเริ่มแผนอาชีพ + วันสิ้นสุดแผนอาชีพ
    $start_date     = "'". $request_data->start_date ."'";
    $end_date       = "'". $request_data->end_date ."'";

    $query = "UPDATE plan_career SET
                member_id=$member_id,
                career_id=$career_id,
                start_date=$start_date,
                end_date=$end_date
              WHERE plan_career_id=$plan_career_id
             ;";
    print_r($query);
    $statement = $connect->prepare($query);
    $statement->execute($data);
    $output = array("message" => "Update Complete");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
} 
else if ($request_data->action == "delete") {
    $query = "DELETE FROM plan_career WHERE plan_career_id = $request_data->plan_career_id";
    $statement = $connect->prepare($query);
    $statement->execute();
    $output = array("message" => "Delete Complete");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
}
else if ($request_data->action == "get_plan_career_by_member_id") {
    $member_id = (int)$request_data->member_id;
    $query = "SELECT * FROM plan_career as pla
                       INNER JOIN career as car ON pla.career_id=car.career_id
                       WHERE pla.member_id=$member_id
                      ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);

}
?>