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
    $self_assessment_date   = "'". $request_data->self_assessment_date ."'";
    $qa_plan_career_id      = (int) $request_data->qa_plan_career_id;
    $perform_id             = (int) $request_data->perform_id;

    $query = "INSERT INTO self_assessment (self_assessment_date,
                          qa_plan_career_id, perform_id) 
              VALUES($self_assessment_date,
                     $qa_plan_career_id, $perform_id)
             ;";

    $statement = $connect->prepare($query);
    $statement->execute($data);
    $output = array(" message " => " Insert Complete ");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
} 
else if ($request_data->action == "getall") {
    $query = "SELECT * FROM self_assessment
             ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
}
else if ($request_data->action == "getAll") {
    $query = "SELECT * FROM self_assessment as sef
                   INNER JOIN qa_plan_career as qpc ON sef.qa_plan_career_id = qpc.qa_plan_career_id
                   INNER JOIN qualification  as qua ON qpc.qualification_id = qua.qualification_id
                   INNER JOIN plan_career    as pla ON qpc.plan_career_id = pla.plan_career_id
                   INNER JOIN career         as car ON pla.career_id = car.career_id
                   INNER JOIN target         as tar ON qpc.target_id = tar.target_id
                   INNER JOIN perform        as per ON sef.perform_id = per.perform_id

    ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
}
else if ($request_data->action == "get_self_aassessment_by_qa_plan_career_id") {
    $qa_plan_career_id      = (int) $request_data->qa_plan_career_id;
    $query = "SELECT * FROM self_assessment as sef
                   INNER JOIN qa_plan_career as qpc ON sef.qa_plan_career_id = qpc.qa_plan_career_id
                   INNER JOIN qualification  as qua ON qpc.qualification_id = qua.qualification_id
                   INNER JOIN plan_career    as pla ON qpc.plan_career_id = pla.plan_career_id
                   INNER JOIN career         as car ON pla.career_id = car.career_id
                   INNER JOIN target         as tar ON qpc.target_id = tar.target_id
                   INNER JOIN perform        as per ON sef.perform_id = per.perform_id
                   WHERE sef.qa_plan_career_id = $qa_plan_career_id
    ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
}
else if ($request_data->action == "edit") {
    $self_assessment_id     = (int) $request_data->self_assessment_id;
    $query = "SELECT * FROM self_assessment as sef
              INNER JOIN qa_plan_career as qpc ON sef.qa_plan_career_id = qpc.qa_plan_career_id
              WHERE self_assessment_id = $self_assessment_id
              ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data['self_assessment_id']     = $row['self_assessment_id'];
        $data['plan_career_id']         = $row['plan_career_id'];
        $data['self_assessment_date']   = $row['self_assessment_date'];
        $data['qa_plan_career_id']      = $row['qa_plan_career_id'];
        $data['perform_id']             = $row['perform_id'];
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
} 
else if ($request_data->action == "update") {
    $self_assessment_id     = (int) $request_data->self_assessment_id;
    $self_assessment_date   = "'". $request_data->self_assessment_date ."'";
    $qa_plan_career_id      = (int) $request_data->qa_plan_career_id;
    $perform_id             = (int) $request_data->perform_id;
    $query = "UPDATE self_assessment 
              SET 
                    qa_plan_career_id       = $qa_plan_career_id,
                    self_assessment_date    = $self_assessment_date,
                    perform_id              = $perform_id 
              WHERE self_assessment_id = $self_assessment_id
             ;";
    $statement = $connect->prepare($query);
    $statement->execute($data);
    $output = array("message" => "Update Complete");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
} 
else if ($request_data->action == "delete") {
    $query = "DELETE FROM self_assessment 
              WHERE self_assessment_id = $request_data->self_assessment_id
              ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    $output = array("message" => "Delete Complete");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
}
else if ($request_data->action == "getPerform") {
    $query = "SELECT * FROM perform 
             ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}