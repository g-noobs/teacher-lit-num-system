<?php 
// This is will be used upload files to the server
// at the same time save the file path to the database
//will manage POST jquery ajax from file jquerTopic.php

include_once "../../../Database/SanitizeCrudClass.php";
include_once "../../../Database/ColumnCountClass.php";
include_once "../../../Database/CommonValidationClass.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //check if the form fields is empty including file input
    if(isset($_POST['topic_name']) && isset($_POST['topic_desc']) && isset($_POST['btnId'])){
        $topic_name = trim($_POST['topic_name']);
        $topic_desc = $_POST['topic_desc'];
        $lesson_id = $_POST['btnId'];

        //get the topic id with zeros
        $topic_count = new ColumnCountClass();
        $topic_id = "TPC". $topic_count->columnCountWhere("topic_id","tbl_topic");

        $currentDate = new DateTime();
        $date_added = $currentDate->format('Y-m-d H:i:s');

        $table = "tbl_topic";
        $addTopic = new SanitizeCrudClass();
        $query = "INSERT INTO $table(topic_id, topic_name, topic_description, topic_status, lesson_id,date_added) VALUES (?,?,?,?,?,?)";
        $params = array($topic_id, $topic_name, $topic_desc, 1, $lesson_id, $date_added);
        
        //Check if there is duplicate in tbl_topic  
        $check = new CommonValidationClass();
        $data = $topic_name;
        $column = 'topic_name';
        $isDuplicate = $check -> validateOneColumn($table, $column, $data);

        if($isDuplicate){
            try{
                $addTopic->executePreState($query,$params);
                
            } catch (mysqli_sql_exception $e) {
                if ($e->getCode() == 1062) {
                    // Duplicate entry
                    $response = array("error" => $data." already exists. Please try again");
                    echo json_encode($response);  
                    exit();
                } else {
                    // Some other error
                    $response = array("error"=> $e->getMessage());
                    echo json_encode($response);
                    throw $e;
                }
            }
            //add a catch for foreign key constraits fails
            catch(Exception $e){
                $response = array("error"=> $e->getMessage());
                echo json_encode($response);
            }

        }
        else{
            echo $data." is already exists. Please try again";
        }
        // if add Topic is successfull proceed with the file upload
        if($addTopic->getLastError() === null){
            //Handle multiple file uploads
            $fileCount = count($_FILES['file']['name']);
            
            $uploadFiles = array();

            //place the file name, tempname and traget path in an array, using for loop
            for($i=0; $i < $fileCount; $i++){
                $fileName = $_FILES["file"]["name"][$i];
                $tempName = $_FILES["file"]["tmp_name"][$i];

                //set allowed file extensions
                $pathinfo = pathinfo($fileName);
                $base = $pathinfo["filename"];
                $fileExtension = $pathinfo["extension"];

                //replace all non-alphanumeric characters with an underscore
                $base = preg_replace("/[^a-zA-Z0-9]/", "_", $base);
                $fileName = $base . "." . $fileExtension;

                //set the target path or Folder depends on file extension
                include_once "../../../CommonPHPClass/DirModClass.php";
                $dirMod = new DirModClass();
                $subDirectoryFolder = $dirMod->modSubDirecPath($fileExtension);


                //upload directory to Folder Media plus the subdirectoryFolder
                $uploadDir = "../../../Media/".$subDirectoryFolder;

                //Check if directory exists, if not create it
                if(!file_exists($uploadDir)){
                    mkdir($uploadDir, 0755, true);
                }
                
                //Destination Where to Save the file
                $destination = $uploadDir."/". $fileName;

                // add numbers to duplicate file names
                $j = 1;
                while(file_exists($destination)){
                    $fileName = $base . "($j)." . $fileExtension;
                    $destination = $uploadDir."/". $fileName;
                    $j++;
                }
                

                // Depends on the $subDirectoryFolder return value. Convert to lowercase then remove letter 's'
                //this could be video, audio, image, document, others
                $file_type = str_replace('s', '', strtolower($subDirectoryFolder));
                
                //set table
                $table = "tbl_".$file_type;

                $columnCount = new ColumnCountClass();
                // Get the first 3 characters and convert them to uppercase
                $id_initial = strtoupper(substr($subDirectoryFolder, 0, 3));
                $file_id = $id_initial. $columnCount->columnCountWhere($file_type."_id",$table);

                // get current or today's date
                // !This will be the saved directory path to the database where file can be access
                $file_access_path = "https://tagakauloedu.com/Media/".$subDirectoryFolder ."/". $fileName;

                $currentDate = new DateTime();
                $updloadDate  = $currentDate->format('Y-m-d H:i:s');

                $values = array(
                    $file_type."_id" => $file_id,
                    $file_type."_name" => $fileName,
                    $file_type."_path" => $file_access_path,
                    "upload_date" => $updloadDate,
                    "topic_id" => $topic_id
                );
                
                //automatically store implode array keys from array $values
                $columns = implode(', ', array_keys($values));

                //automatically store corresponding number of placeholders from array $values
                $placeholders = implode(', ', array_fill(0, count($values), '?'));

                // place all array values to the parameter
                $params = array_values($values);

                $query = "INSERT INTO $table($columns) VALUES ($placeholders)";

                $addFileInfo = new SanitizeCrudClass();
                $addFileInfo->executePreState($query,$params);
                // $This will be the saved directory path to the database where file can be access
                
                // proceed on uploading files if there is no error on adding the file path to the databse
                if($addFileInfo->getLastError() === null){
                    //? Move the uploaded file to the directory
                    if(move_uploaded_file($tempName, $destination)){
                        $uploadFiles[] = $destination;
                    }
                }
                else{
                    $response = array(
                        "error" => "Error on adding file path to the database"
                    );
                    echo json_encode($response);
                }
            }
            //Adding Successfully
            $response = array("success" => "Successfully Added");
            echo json_encode($response);
        }else{
            $response = array("error" => "Error on adding topic");
            echo json_encode($response);
        } 
    }else{
        $response = array("error" => "Please fill up all the fields");
        echo json_encode($response);
    }
}else{
    $response = array("error" => "POSSIBLE POST ISSUE");
    echo json_encode($response);
}
?>