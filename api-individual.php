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
    $individual_id      = (int)$request_data->individual_id;
    // ข้อมูลส่วนตัว
    $member_id          = (int)$request_data->member_id;
    $birthday           = "'". $request_data->birthday ."'";
    $card_id            = "'". $request_data->card_id ."'";
    $telephone          = "'". $request_data->telephone ."'";
    // ข้อมูลการศึกษา
    $department_id      = (int)$request_data->department_id;
    $is_graduate        = (int)$request_data->is_graduate;
    $date               = "'". $request_data->date ."'";
    $year               = "'". $request_data->year ."'";
    // ข้อมูลความพิการ
    $is_disability      = (int)$request_data->is_disability;
    $disability_id      = (int)$request_data->disability_id;
    $dis_description    = "'". $request_data->dis_description ."'";
    // ข้อมูลโครงการ
    $project_id         = (int)$request_data->project_id;

    $query = "INSERT INTO individual (member_id, birthday, card_id, telephone,
                                      department_id, is_graduate, date, year, 
                                      disability_id, dis_description,
                                      project_id
                                    ) 
                             VALUES  ($member_id, $birthday, $card_id, $telephone,
                                      $department_id, $is_graduate, $date, $year, 
                                      $disability_id, $dis_description,
                                      $project_id
                                    )";
    $statement = $connect->prepare($query);
    $statement->execute($data);
    $output = array(" message " => " Insert Complete ");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
} else if ($request_data->action == "getall") {
    $query = "SELECT * FROM individual as ind
              INNER JOIN member     as mem  ON ind.member_id = mem.member_id
              INNER JOIN project    as pro  ON ind.project_id = pro.project_id
              INNER JOIN disability as dis  ON ind.disability_id = dis.disability_id
              INNER JOIN department as dep  ON ind.department_id = dep.department_id
              INNER JOIN degree     as deg  ON dep.degree_id = deg.degree_id
              INNER JOIN faculty    as fac  ON deg.faculty_id = fac.faculty_id
              INNER JOIN institute  as ins  ON fac.institute_id = ins.institute_id
              ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
}else if ($request_data->action == "edit") {
    $individual_id = (int)$request_data->individual_id;
    
    $query = "SELECT * FROM individual  as  ind
                INNER JOIN project      as  pro  ON ind.project_id = pro.project_id
                INNER JOIN disability   as  dis  ON ind.disability_id = dis.disability_id
                INNER JOIN department   as  dep  ON ind.department_id = dep.department_id
                INNER JOIN degree       as  deg  ON dep.degree_id = deg.degree_id
                INNER JOIN faculty      as  fac  ON deg.faculty_id = fac.faculty_id
                INNER JOIN institute    as  ins  ON fac.institute_id = ins.institute_id
                WHERE individual_id = $individual_id
    ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data['individual_id'] = $row['individual_id'];
        // ข้อมูลส่วนตัว
        $data['member_id'] = $row['member_id'];
        $data['birthday'] = $row['birthday'];
        $data['card_id'] = $row['card_id'];
        $data['telephone'] = $row['telephone'];
        // ข้อมูลการศึกษา
        $data['institute_id'] = $row['institute_id'];
        $data['institute_name'] = $row['institute_name'];
        $data['faculty_id'] = $row['faculty_id'];
        $data['faculty_name'] = $row['faculty_name'];
        $data['degree_id'] = $row['degree_id'];
        $data['degree_name'] = $row['degree_name'];
        $data['department_id'] = $row['department_id'];
        $data['department_name'] = $row['department_name'];
        $data['is_graduate'] = $row['is_graduate'];
        $data['date'] = $row['date'];
        $data['year'] = $row['year'];
        // ข้อมูลความพิการ
        $data['is_disability'] = $row['is_disability'];
        $data['disability_id'] = $row['disability_id'];
        $data['disability_name'] = $row['disability_name'];
        $data['dis_description'] = $row['dis_description'];
        // ข้อมูลโครงการ
        $data['project_id'] = $row['project_id'];
        $data['project_name'] = $row['project_name'];
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    
} else if ($request_data->action == "update") {
    $individual_id      = (int)$request_data->individual_id;
    // ข้อมูลส่วนตัว
    $member_id          = (int)$request_data->member_id;
    $birthday           = "'". $request_data->birthday ."'";
    $card_id            = "'". $request_data->card_id ."'";
    $telephone          = "'". $request_data->telephone ."'";
    // ข้อมูลการศึกษา
    $department_id      = (int)$request_data->department_id;
    $is_graduate        = (int)$request_data->is_graduate;
    $date               = "'". $request_data->date ."'";
    $year               = "'". $request_data->year ."'";
    // ข้อมูลความพิการ
    $is_disability      = (int)$request_data->is_disability;
    $disability_id      = (int)$request_data->disability_id;
    $dis_description    = "'". $request_data->dis_description ."'";
    // ข้อมูลโครงการ
    $project_id         = (int)$request_data->project_id;
    $query = "UPDATE individual 
        SET 
            individual_id=$individual_id,
            -- ข้อมูลส่วนตัว
            member_id=$member_id,
            birthday=$birthday,
            card_id=$card_id ,
            telephone=$telephone,
            -- ข้อมูลการศึกษา
            department_id=$department_id,
            is_graduate=$is_graduate,
            date=$date ,
            year=$year,
            -- ข้อมูลความพิการ
            is_disability=$is_disability,
            disability_id=$disability_id,
            dis_description=$dis_description ,
            -- ข้อมูลโครงการ
            project_id=$project_id
        WHERE individual_id=$individual_id
        ;";
    $statement = $connect->prepare($query);
    $statement->execute($data);
    $output = array("message" => "Update Complete");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
} else if ($request_data->action == "delete") {
    $individual_id = (int)$request_data->individual_id;
    $query = "DELETE FROM individual WHERE individual_id = $individual_id
    ;";
    $statement = $connect->prepare($query);
    $statement->execute();
    $output = array("message" => "Delete Complete");
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
}
?>