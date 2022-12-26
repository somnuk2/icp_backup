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
    $qa_plan_career_id=(int) $request_data->qa_plan_career_id;
    $development_id=(int) $request_data->development_id;
    $frequency_id=(int) $request_data->frequency_id;
    $importance_id=(int) $request_data->importance_id;

    $plan_title="'".$request_data->plan_title."'";
    $plan_channel="'".$request_data->plan_channel."'";
    $plan_start_date="'".$request_data->plan_start_date."'";
    $plan_end_date="'".$request_data->plan_end_date."'";

    $query = "INSERT INTO plan (qa_plan_career_id,
                                development_id,
                                frequency_id,
                                importance_id,
                                plan_title,
                                plan_channel,
                                plan_start_date,
                                plan_end_date
                                ) 
                 VALUES($qa_plan_career_id,
                        $development_id,
                        $frequency_id,
                        $importance_id,
                        $plan_title,
                        $plan_channel,
                        $plan_start_date,
                        $plan_end_date
                        );";
    $statement = $connect->prepare($query);
    $statement->execute($data);
    $output = array(" message " => " Insert Complete ");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
} 
else if ($request_data->action == "getall") {
    $query = "SELECT * FROM plan as pla
        INNER JOIN qa_plan_career as qap ON pla.qa_plan_career_id = qap.qa_plan_career_id  
        INNER JOIN qualification  as qua ON qap.qualification_id = qua.qualification_id  
        INNER JOIN development    as dev ON pla.development_id = dev.development_id
        INNER JOIN frequency      as fre ON pla.frequency_id = fre.frequency_id
        INNER JOIN importance     as imp ON pla.importance_id = imp.importance_id
        ORDER BY pla.plan_id ASC
        ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
} 
else if ($request_data->action == "getAll") {
    // echo " getAllUser ";
    $query = "SELECT * FROM qa_plane_career as qa_pc
              INNER JOIN qualification as qa ON qa_pc.qualification_id = qa.qualification_id
              INNER JOIN plan_career as pc ON qa_pc.plan_career_id = pc.Plan_Career_id
              INNER JOIN career as ca ON pc.Career_id = ca.career_id
              ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
}
else if ($request_data->action == "edit") {
    $plan_id=(int) $request_data->plan_id;

    $query = "SELECT * FROM plan as pla
            INNER JOIN qa_plan_career as qap ON pla.qa_plan_career_id = qap.qa_plan_career_id
            INNER JOIN plan_career    as plc ON qap.plan_career_id = plc.plan_career_id
            INNER JOIN career         as car ON plc.career_id = car.career_id
            INNER JOIN qualification  as qua ON qap.qualification_id = qua.qualification_id  
            INNER JOIN development    as dev ON pla.development_id = dev.development_id
            INNER JOIN frequency      as fre ON pla.frequency_id = fre.frequency_id
            INNER JOIN importance     as imp ON pla.importance_id = imp.importance_id 
            WHERE pla.plan_id =  $plan_id
            ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data['plan_id'] = $row['plan_id'];
        $data['qa_plan_career_id'] = $row['qa_plan_career_id'];
        $data['qualification_name'] = $row['qualification_name'];
        $data['plan_career_id'] = $row['plan_career_id'];
        $data['career_name'] = $row['career_name'];
        

        $data['development_id'] = $row['development_id'];
        $data['development_name'] = $row['development_name'];
        $data['frequency_id'] = $row['frequency_id'];
        $data['frequency_name'] = $row['frequency_name'];
        $data['importance_id'] = $row['importance_id'];
        $data['importance_name'] = $row['importance_name'];

        $data['plan_title'] = $row['plan_title'];
        $data['plan_channel'] = $row['plan_channel'];
        $data['plan_start_date'] = $row['plan_start_date'];
        $data['plan_end_date'] = $row['plan_end_date'];
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
} 
else if ($request_data->action == "update") {
    $plan_id=(int) $request_data->plan_id;
    $qa_plan_career_id=(int) $request_data->qa_plan_career_id;
    $development_id=(int) $request_data->development_id;
    $frequency_id=(int) $request_data->frequency_id;
    $importance_id=(int) $request_data->importance_id;

    $plan_title="'".$request_data->plan_title."'";
    $plan_channel="'".$request_data->plan_channel."'";
    $plan_start_date="'".$request_data->plan_start_date."'";
    $plan_end_date="'".$request_data->plan_end_date."'";

    $query = "UPDATE plan 
                SET 
                    qa_plan_career_id=$qa_plan_career_id,
                    development_id=$development_id,
                    frequency_id=$frequency_id,
                    importance_id=$importance_id,
                    plan_title=$plan_title,
                    plan_channel=$plan_channel,
                    plan_start_date=$plan_start_date,
                    plan_end_date=$plan_end_date
                WHERE plan_id=$plan_id
                ;";
    $statement = $connect->prepare($query);
    $statement->execute($data);
    $output = array("message" => "Update Complete");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
} 
else if ($request_data->action == "delete") {
    $plan_id=(int) $request_data->plan_id;
    $query = "DELETE FROM plan WHERE plan_id =  $plan_id";
    $statement = $connect->prepare($query);
    $statement->execute();
    $output = array("message" => "Delete Complete");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
}
else if ($request_data->action == "getDevelopment") {
    $query = "SELECT * FROM development as dev
        ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
} 
else if ($request_data->action == "getImportance") {
    $query = "SELECT * FROM importance as imp
        ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
} 
else if ($request_data->action == "getFrequency") {
    $query = "SELECT * FROM frequency as fre
        ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
} 
else if ($request_data->action == "get_plan_by_qa_plan_career_id") {
    $qa_plan_career_id      = (int) $request_data->qa_plan_career_id;
    $query = "SELECT * FROM plan as pla
                   INNER JOIN qa_plan_career as qpc ON pla.qa_plan_career_id = qpc.qa_plan_career_id
                   INNER JOIN development    as dev ON pla.development_id = dev.development_id
                   INNER JOIN importance     as imp ON pla.importance_id = imp.importance_id
                   INNER JOIN frequency      as fre ON pla.frequency_id = fre.frequency_id
                   WHERE pla.qa_plan_career_id = $qa_plan_career_id
    ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
}
?>