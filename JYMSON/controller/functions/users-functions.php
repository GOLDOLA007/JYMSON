<?php 
    require_once __DIR__ . '/general-functions.php';
    require_once __DIR__ . '/../../model/User.php';

    //get old records
    function get_users_old_records(){
        $file = get_data_users_JSON_path();
        if(!file_exists($file) || filesize($file) === 0){
            return [];
        }

        $old_records = json_decode(file_get_contents($file));
        if($old_records === null){
            return [];
        }

        return $old_records;
    }
    //get JSON file encoded data
    function get_JSON_file_encoded_data($data_to_save){
        $encoded_data = json_encode($data_to_save, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return $encoded_data;
    }

    //getting user name by email
    function get_user_name_by_email($email){
        $old_records = get_users_old_records();
        foreach($old_records as $record){
            if(!isset($record->user_email) || 
            !isset($record->user_name)){
                continue;
            }
            if($record->user_email == $email){
                return $record->user_name;
            }
        }
        return null;
    }

    //getting code user by email
    function get_code_user_by_email($email){
        $old_records = get_users_old_records();
        foreach($old_records as $record){
            if(!isset($record->user_email) || 
            !isset($record->user_code)){
                continue;
            }
            if($record->user_email == $email){
                return $record->user_code;
            }
        }
        return null;
    }

    //search user
    function search_user(User $user){
    
        $old_records = get_users_old_records();

        if($_SESSION["current_process"] === "Login"){
            foreach($old_records as $record){
                if(!isset($record->user_email) ||
                !isset($record->user_password)){
                    continue;
                }
                if($record->user_email == $user->getUser_email() &&
                $record->user_password == $user->getUser_password()){
                    return "success";
                }
            }
        }
        if($_SESSION["current_process"] === "Signup"){
             foreach($old_records as $record){
                if(!isset($record->user_email)){
                    continue;
                }
                if($record->user_email === $user->getUser_email()){
                    return "success";
                }
            }
        }
        return "error";
    }

    //save user
    function save_user(User $new_user){
        //declaring variables
        $data_to_save = "";
        $encoded_data = "";
        $old_records = get_users_old_records();
        $file = get_data_users_JSON_path();
        
        //verifying if file exists
        if(verify_if_JSON_file_exists($file, $new_user) === "true"){
            return "success";
        }
        if(verify_if_JSON_file_exists($file, $new_user) === "false"){
            //if file already exists, we will check if the user already exists in the file
            if(search_user($new_user) === "success"){
                return "error";
            }
            if(search_user($new_user) === "error"){
                //we add the new user to the existing data
                array_push($old_records, $new_user);
                $data_to_save = $old_records;
                
                $encoded_data = get_JSON_file_encoded_data($data_to_save);    
                //virifying if the data is saved successfully
                if(!file_put_contents($file, $encoded_data, LOCK_EX)){
                    return "error";
                }else{
                    return "success";
                }
            }
        }
        return "error";

    }

?>
