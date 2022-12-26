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
    $plan_career_id = (int) $request_data->plan_career_id;
    $qualification_id = (int) $request_data->qualification_id;
    $level_id = (int) $request_data->level_id;
    $target_id = (int) $request_data->target_id;

    $query = "INSERT INTO qa_plan_career (plan_career_id, qualification_id, level_id, target_id) 
              VALUES($plan_career_id,$qualification_id,$level_id,$target_id)
              ;";
    $statement = $connect->prepare($query);
    $statement->execute($data);
    $output = array(" message " => " Insert Complete ");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
} 
else if ($request_data->action == "getall") {
    // echo " getAllUser ";
    $query = "SELECT * FROM career_qualification";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
}
else if ($request_data->action == "getAll") {
    // echo " getAllUser ";
    $query = "SELECT * FROM 
              qa_plan_career           as qpc
              INNER JOIN plan_career   as pca ON qpc.plan_career_id = pca.plan_career_id
              INNER JOIN career        as car ON pca.career_id = car.career_id
              INNER JOIN qualification as qua ON qpc.qualification_id = qua.qualification_id
              INNER JOIN level         as lev ON qpc.level_id = lev.level_id
              INNER JOIN target        as tar ON qpc.target_id = tar.target_id
              ORDER BY qpc.qa_plan_career_id asc
    ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
}
else if ($request_data->action == "getEmpCareer1") {
    $query = "SELECT pc.Plan_Career_id, emp.id, pc.Name_Plan_Career
    FROM employee as emp 
    INNER JOIN plan_career as pc ON pc.Employee_id = emp.id
    WHERE emp.id = $request_data->employee_id 
    ORDER BY pc.Plan_Career_id asc";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
}
else if ($request_data->action == "getEmpCareer") {
    $query = "SELECT * FROM employee as em 
    INNER JOIN plan_career as pc ON em.id = pc.employee_id
    INNER JOIN career as ca ON pc.Career_id = ca.career_id

    -- WHERE pc.Employee_id = $request_data->employee_id 
    ORDER BY pc.Career_id asc";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
}
else if ($request_data->action == "getCareerQualifiation") {
    $query = "SELECT * FROM qualification as qua
                       INNER JOIN member  as mem ON qua.member_id = mem.member_id";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
}
else if ($request_data->action == "getCareer_Qualifiation") {
    $query = "SELECT *
    FROM qualification as q 
    WHERE q.planCareerId = $request_data->career_id 
    ORDER BY q.qualificationId asc";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
}
else if ($request_data->action == "getPlanCareer") {
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
else if ($request_data->action == "edit") {
    $qa_plan_career_id = (int)$request_data->qa_plan_career_id;
    $query = "SELECT * FROM qa_plan_career AS qap
              INNER JOIN plan_career       AS pla ON qap.plan_career_id = pla.plan_career_id
              INNER JOIN career            AS car ON pla.career_id = car.career_id
              INNER JOIN qualification     AS qua ON qap.qualification_id = qua.qualification_id
              INNER JOIN level             AS lev ON qap.level_id = lev.level_id
              INNER JOIN target            AS tar ON qap.target_id = tar.target_id
              WHERE qa_plan_career_id = $qa_plan_career_id
              ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data['qa_plan_career_id'] = $row['qa_plan_career_id'];
        $data['plan_career_id'] = $row['plan_career_id'];
        $data['career_id'] = $row['career_id'];
        $data['career_name'] = $row['career_name'];
        $data['qualification_id'] = $row['qualification_id'];
        $data['qualification_name'] = $row['qualification_name'];
        $data['level_id'] = $row['level_id'];
        $data['level_name'] = $row['level_name'];
        $data['target_id'] = $row['target_id'];
        $data['target_name'] = $row['target_name'];
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
} 
else if ($request_data->action == "update") {
    $qa_plan_career_id  = (int) $request_data->qa_plan_career_id;
    $plan_career_id     = (int) $request_data->plan_career_id;
    $qualification_id   = (int) $request_data->qualification_id;
    $level_id           = (int) $request_data->level_id;
    $target_id          = (int) $request_data->target_id;

    $query = "UPDATE qa_plan_career 
              SET 
                    plan_career_id=$plan_career_id,
                    qualification_id=$qualification_id,
                    level_id=$level_id,
                    target_id=$target_id
              WHERE qa_plan_career_id = $qa_plan_career_id
              ;";
    $statement = $connect->prepare($query);
    $statement->execute($data);
    $output = array("message" => "Update Complete");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
} 
else if ($request_data->action == "delete") {
    $qa_plan_career_id = (int) $request_data->qa_plan_career_id;
    $query = "DELETE FROM qa_plan_career
              WHERE qa_plan_career_id = $qa_plan_career_id
              ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $output = array("message" => "Delete Complete");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
}
else if ($request_data->action == "getTarget") {
    $query = "SELECT * FROM target";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}
else if ($request_data->action == "getLevel") {
    $query = "SELECT * FROM level";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}
else if ($request_data->action == "get_qa_plan_career_by_plan_career_id") {
    $plan_career_id = (int) $request_data->plan_career_id;
    $query = "SELECT * FROM qa_plan_career as qpc
                INNER JOIN plan_career   as pla ON qpc.plan_career_id = pla.plan_career_id
                INNER JOIN career        as car ON pla.career_id = car.career_id
                INNER JOIN qualification as qua ON qpc.qualification_id = qua.qualification_id
                INNER JOIN level         as lev ON qpc.level_id = lev.level_id
                INNER JOIN target        as tar ON qpc.target_id = tar.target_id
                WHERE  qpc.plan_career_id = $plan_career_id
                GROUP BY qua.qualification_id
    ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
}
else if ($request_data->action == "get_qa_plan_career_by_qualification_id") {
    $plan_career_id = (int) $request_data->plan_career_id;
    $qualification_id = (int) $request_data->qualification_id;
    $query = "SELECT * FROM qa_plan_career as qpc
                INNER JOIN plan_career   as pla ON qpc.plan_career_id = pla.plan_career_id
                INNER JOIN career        as car ON pla.career_id = car.career_id
                INNER JOIN qualification as qua ON qpc.qualification_id = qua.qualification_id
                INNER JOIN level         as lev ON qpc.level_id = lev.level_id
                INNER JOIN target        as tar ON qpc.target_id = tar.target_id
                WHERE  (qpc.plan_career_id = $plan_career_id) AND (qpc.qualification_id = $qualification_id)
                GROUP BY qua.qualification_id
    ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
}

?>