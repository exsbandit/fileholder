<?php

//action.php
$connect = new PDO("mysql:host=localhost;dbname=vuetest", "root", "");
$received_data = json_decode(file_get_contents("php://input"));
$data = array();

if($received_data->action == 'fetchlast')
{
 $query = "
 SELECT
    app.*,
    lng.name as lngname
FROM applications app
LEFT JOIN language lng ON lng.id = app.language
WHERE app.appdate >= DATE(NOW()) - INTERVAL 7 DAY AND app.appdate <= DATE(NOW())
 ORDER BY appdate DESC
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 while($row = $statement->fetch(PDO::FETCH_ASSOC))
 {
  $data[] = $row;
 }
 echo json_encode($data);
}

if($received_data->action == 'export')
{
 $query = "
 SELECT
    app.*,
    lng.name as lngname
FROM applications app
LEFT JOIN language lng ON lng.id = app.language
WHERE app.appdate >= DATE(NOW()) - INTERVAL 7 DAY AND app.appdate <= DATE(NOW())
 ORDER BY appdate DESC
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 

 while($row = $statement->fetch(PDO::FETCH_ASSOC))
 {
    if (array_key_exists($row['reference'], $data)) {
        if (array_key_exists($row['lngname'], $data[$row['reference']])) {
            array_push($data[$row['reference']][$row['lngname']], $row);
        } else {
            $data[$row['reference']][$row['lngname']] = array();
            array_push($data[$row['reference']][$row['lngname']], $row);
        }
    } else {
        $data[$row['reference']] = array();
        $data[$row['reference']][$row['lngname']] = array();
        array_push($data[$row['reference']][$row['lngname']], $row);
    }
 }
 echo json_encode($data);
}

if($received_data->action == 'fetchall')
{
 $query = "
 SELECT
    app.*,
    lng.name as lngname
FROM applications app
LEFT JOIN language lng ON lng.id = app.language

 ORDER BY id DESC
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 while($row = $statement->fetch(PDO::FETCH_ASSOC))
 {
  $data[] = $row;
 }
 echo json_encode($data);
}
if($received_data->action == 'insert')
{
 $data = array(
  ':first_name' => $received_data->firstName,
  ':last_name' => $received_data->lastName,
  ':phone' => $received_data->phoneNumber,
  ':email' => $received_data->emailAddress,
  ':language' => $received_data->language,
  ':message' => $received_data->message,
  ':reference' => $received_data->reference,
 );

 $query = "
 INSERT INTO applications
 (name, lastname, phone, email, message, language, reference, appdate) 
 VALUES (:first_name, :last_name, :phone, :email, :message, :language, :reference, NOW())
 ";

 $statement = $connect->prepare($query);

 $statement->execute($data);

 $output = array(
  'message' => 'Data Inserted'
 );

 echo json_encode($output);
}
if($received_data->action == 'fetchSingle')
{
 $query = "
 SELECT * FROM tbl_sample 
 WHERE id = '".$received_data->id."'
 ";

 $statement = $connect->prepare($query);

 $statement->execute();

 $result = $statement->fetchAll();

 foreach($result as $row)
 {
  $data['id'] = $row['id'];
  $data['first_name'] = $row['first_name'];
  $data['last_name'] = $row['last_name'];
 }

 echo json_encode($data);
}
if($received_data->action == 'update')
{
 $data = array(
  ':first_name' => $received_data->firstName,
  ':last_name' => $received_data->lastName,
  ':id'   => $received_data->hiddenId
 );

 $query = "
 UPDATE tbl_sample 
 SET first_name = :first_name, 
 last_name = :last_name 
 WHERE id = :id
 ";

 $statement = $connect->prepare($query);

 $statement->execute($data);

 $output = array(
  'message' => 'Data Updated'
 );

 echo json_encode($output);
}

if($received_data->action == 'delete')
{
 $query = "
 DELETE FROM tbl_sample 
 WHERE id = '".$received_data->id."'
 ";

 $statement = $connect->prepare($query);

 $statement->execute();

 $output = array(
  'message' => 'Data Deleted'
 );

 echo json_encode($output);
}

if($received_data->action == 'language')
{
 $query = "
 SELECT * FROM language 
 ORDER BY name ASC
 ";

 $statement = $connect->prepare($query);

 $statement->execute();
 
 while($row = $statement->fetch(PDO::FETCH_ASSOC))
 {
  $data[] = $row;
 }
 
 echo json_encode($data);

}

if($received_data->action == 'checkmail')
{
    if($received_data->email != '')
    {
        $is_available = true;
        $query = "
        SELECT * FROM applications 
        WHERE email = '".$received_data->email."'
        ";

        $statement = $connect->prepare($query);

        $statement->execute();

        $total_row = $statement->rowCount();

        if($total_row > 0)
        { 
            $is_available = false;
        }

        $data = array(
            'is_available'  => $is_available
        );
    } else {
        $data = array(
            'is_available'  => $is_available
        );
    }
    echo json_encode($data);
}

if($received_data->action == 'entercountry')
{
    // reading json file
$json = file_get_contents('countrycodes.json');
//converting json object to php associative array
$jsondata = json_decode($json, true);

// processing the array of objects
    $sql = 'INSERT INTO countrycodes (id, name, dial_code, code) VALUES ';
    $insertQuery = '';
    
    foreach ($jsondata as $key => $countrycodes) {
      $insertQuery .= '(' . ($key+1) . ',"' . $countrycodes["name"] . '","' . $countrycodes["dial_code"] .'","' . $countrycodes["code"] . '"),';
    }
    $insertQuery = substr($insertQuery, 0, -1);

    if (!empty($insertQuery)) {
        $sql .= $insertQuery;
        $statement = $connect->prepare($sql);

        $statement->execute();

        $output = array(
            'message' => 'Data Inserted'
        );
        
        echo json_encode($output);
    }   
}

?>
