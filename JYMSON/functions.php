<?php 
    function saveUser($name, $email, $password){
        //accessing the json file
        $file = __DIR__ . "/messages.json";
        
        //defining the new user in a array
        $new_user = array(
            "name" => $name,
            "email" => $email,
            "password" => $password
        );

        //checking if the file is empty or doesn't exist, if it is empty we will create a new array with the new user as the first record, if it is not empty we will decode the existing data and add a new user to the existing data
        if(!file_exists($file) || filesize($file) == 0){    
            //if the file is empty, we create a new array with the new user as the first record
            $first_record = array($new_user);
            $data_to_save = $first_record;
        }else{
            //if the file is not empty, we decode the existing data and add a new user to the existing data
            $old_records = json_decode(file_get_contents($file));
            //we add the new user to the existing data
            array_push($old_records, $new_user);
            $data_to_save = $old_records;
        }
        
        //saving the data to the file
        $encoded_data = json_encode($data_to_save, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        //we will verify if the data is saved successfully or not
        //About LOCK_EX: This prevents other processes from reading or writing to the file simultaneously, ensuring data integrity in concurrent scenarios.
        if(!file_put_contents($file, $encoded_data, LOCK_EX)){
            return "error";
        }else{
            return "success";
        }

    }

    function search_user($name, $email, $password){
        
    }
?>