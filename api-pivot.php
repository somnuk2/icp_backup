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

if ($request_data->action == "getall") {
    $query = "SELECT emp.id,emp.name,emp.study_faculty,emp.university,emp.disability_type,
    pc.Name_Plan_Career,q.skill,q.level,q.goal,p.doing,p.leaning,sa.month,sa.assessment
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

if ($request_data->action == "getEmployees" && $request_data->id > 0) {
    $query = "SELECT emp.id,emp.name,emp.study_faculty,emp.university,emp.disability_type
        FROM employee as emp
        WHERE emp.id = $request_data->id 
        ORDER BY emp.id asc";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }

    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
}

if ($request_data->action == "getPlanCareer" && $request_data->employeeId > 0) {
    $query = "SELECT emp.id,emp.name,emp.study_faculty,emp.university,emp.disability_type,
        pc.Plan_Career_id, pc.Name_Plan_Career
        FROM employee as emp 
        INNER JOIN plan_career as pc ON pc.Employee_id = emp.id
        WHERE emp.id = $request_data->employeeId 
        ORDER BY emp.id asc";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
}

if ($request_data->action == "getQualification") {
    $query = "";
    if ($request_data->Plan_Career_id == "ALL") {
        $query = "SELECT q.qualificationId,emp.name,emp.study_faculty,emp.university,emp.disability_type,
        pc.plan_career_id, pc.Name_Plan_Career,q.skill,q.level,q.goal
        FROM employee as emp 
        INNER JOIN plan_career as pc ON pc.Employee_id = emp.id
        INNER JOIN qualification as q ON q.planCareerId = pc.Plan_Career_id
        ORDER BY q.qualificationId asc";
    } else if ($request_data->Plan_Career_id > 0) {
        $query = "SELECT q.qualificationId,emp.name,emp.study_faculty,emp.university,emp.disability_type,
        pc.plan_career_id, pc.Name_Plan_Career,q.skill,q.level,q.goal
        FROM employee as emp 
        INNER JOIN plan_career as pc ON pc.Employee_id = emp.id
        INNER JOIN qualification as q ON q.planCareerId = pc.Plan_Career_id
        WHERE pc.Plan_Career_id = $request_data->Plan_Career_id 
        ORDER BY q.qualificationId asc";
    }

    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
}

if ($request_data->action == "getPlan") {
    if($request_data->qualificationId=="ALL"){
        $query = "SELECT p.planId, q.qualificationId, emp.name,q.skill,p.doing,p.leaning
        FROM employee as emp
        INNER JOIN plan_career as pc ON pc.Employee_id = emp.id
        INNER JOIN qualification as q ON q.planCareerId = pc.Plan_Career_id
        INNER JOIN plan as p ON p.qualificationId = q.qualificationId
        ORDER BY q.qualificationId asc";
    }else if($request_data->qualificationId>0){
        $query = "SELECT p.planId, q.qualificationId, emp.name,q.skill,p.doing,p.leaning
        FROM employee as emp
        INNER JOIN plan_career as pc ON pc.Employee_id = emp.id
        INNER JOIN qualification as q ON q.planCareerId = pc.Plan_Career_id
        INNER JOIN plan as p ON p.qualificationId = q.qualificationId
        WHERE q.qualificationId = $request_data->qualificationId 
        ORDER BY q.qualificationId asc";
    }
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
}

if ($request_data->action == "getAssessment") {
    if($request_data->qualificationId=="ALL"){
        $query = "SELECT sa.selfAssessmentId, q.qualificationId, emp.name,q.skill,q.level,q.goal,sa.month,sa.assessment
        FROM employee as emp 
        INNER JOIN plan_career as pc ON pc.Employee_id = emp.id
        INNER JOIN qualification as q ON q.planCareerId = pc.Plan_Career_id
        INNER JOIN self_assessment as sa ON sa.qualificationId = q.qualificationId
        ORDER BY sa.qualificationId ASC,sa.selfAssessmentId ASC;";
    }else if($request_data->qualificationId>0){
        $query = "SELECT sa.selfAssessmentId, q.qualificationId, emp.name,q.skill,q.level,q.goal,sa.month,sa.assessment
        FROM employee as emp 
        INNER JOIN plan_career as pc ON pc.Employee_id = emp.id
        INNER JOIN qualification as q ON q.planCareerId = pc.Plan_Career_id
        INNER JOIN self_assessment as sa ON sa.qualificationId = q.qualificationId
        WHERE q.qualificationId = $request_data->qualificationId
        ORDER BY sa.qualificationId ASC ,sa.selfAssessmentId ASC;";      
    }
    $statement = $connect->prepare($query);
    $statement->execute();
    $data = array();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        // $data[] = $row;
        $e = array(
            "selfAssessmentId" => $selfAssessmentId,
            "qualificationId" => $qualificationId,
            "name" => $name,
            "skill" => $skill,
            "level" => $level,
            "goal" => $goal,
            "month" => $month,
            "assessment" => $assessment
        );
        array_push($data, $e);
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
}

if ($request_data->action == "getAllAssessment") {
    $query = "SELECT sa.selfAssessmentId, q.qualificationId, emp.name,q.skill,q.level,q.goal,sa.month,sa.assessment
    FROM employee as emp 
    INNER JOIN plan_career as pc ON pc.Employee_id = emp.id
    INNER JOIN qualification as q ON q.planCareerId = pc.Plan_Career_id
    INNER JOIN self_assessment as sa ON sa.qualificationId = q.qualificationId
    ORDER BY sa.selfAssessmentId asc";
    $statement = $connect->prepare($query);
    $statement->execute();
    $data = array();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        // $data[] = $row;
        $e = array(
            "selfAssessmentId" => $selfAssessmentId,
            "qualificationId" => $qualificationId,
            "name" => $name,
            "skill" => $skill,
            "level" => $level,
            "goal" => $goal,
            "month" => $month,
            "assessment" => $assessment
        );
        array_push($data, $e);
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
}
