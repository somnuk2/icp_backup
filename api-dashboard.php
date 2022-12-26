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
    
// if ($request_data->action == "insert") {
//     echo " insert ";
//     $data = array(
//         ":planId" => $request_data->planId, 
//         ":qualificationId" => $request_data->qualificationId, 
//         ":doing" => $request_data->doing,
//         ":leaning" => $request_data->leaning
//     );
//     $query = "INSERT INTO plan (planId,
//                                 qualificationId,
//                                 doing,
//                                 leaning) 
//                  VALUES(:planId,
//                         :qualificationId,
//                         :doing,
//                         :leaning)";

                        
//     $statement = $connect->prepare($query);
//     $statement->execute($data);
//     $output = array(" message " => " Insert Complete ");
//     echo json_encode($output);
// } else 
// $query = "SELECT emp.*, pc.*, q.*, p.*, sa.*
// INNER JOIN qualification as q ON q.planCareerId = pc.planCareerId
// INNER JOIN plan as p ON p.qualificationId = q.qualificationId
// INNER JOIN self_assessment as sa ON sa.planId = p.planId
//id,name,study_faculty,university,disability_type

if ($request_data->action == "getall") {
    $query = "SELECT emp.*, pc.*, q.*, p.*, sa.*
    FROM employee as emp 
    INNER JOIN plan_career as pc ON pc.Employee_id = emp.id
    INNER JOIN qualification as q ON q.planCareerId = pc.Plan_Career_id
    INNER JOIN plan as p ON p.qualificationId = q.qualificationId
    INNER JOIN self_assessment as sa ON sa.qualificationId = q.qualificationId
    ORDER BY emp.id asc";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
} 
// else if ($request_data->action == "edit") {
//     $query = "SELECT * FROM plan WHERE planId = $request_data->planId";
//     $statement = $connect->prepare($query);
//     $statement->execute();
//     while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
//         $data['planId'] = $row['planId'];
//         $data['qualificationId'] = $row['qualificationId'];
//         $data['doing'] = $row['doing'];
//         $data['leaning'] = $row['leaning'];
//     }
//     echo json_encode($data);
// } else if ($request_data->action == "update") {
//     $data = array(
//         ":planId" => $request_data->planId,
//         ":qualificationId" => $request_data->qualificationId,
//         ":doing" => $request_data->doing,
//         ":leaning" => $request_data->leaning,
//     );
//     $query = "UPDATE plan 
//     SET 
//         planId=:planId,
//         qualificationId=:qualificationId,
//         doing=:doing,
//         leaning=:leaning
//     WHERE planId=:planId";
//     $statement = $connect->prepare($query);
//     $statement->execute($data);
//     $output = array("message" => "Update Complete");
//     echo json_encode($output);
// } else if ($request_data->action == "delete") {
//     $query = "DELETE FROM plan WHERE planId = $request_data->planId";
//     $statement = $connect->prepare($query);
//     $statement->execute();
//     $output = array("message" => "Delete Complete");
//     echo json_encode($output);
// }
?>
