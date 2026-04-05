<?php 
    require_once __DIR__ . '/general-functions.php';
  
    //getting old records of workouts
    function get_workouts_old_records(){
        $file = get_data_workouts_JSON_path();
        if(!file_exists($file) || filesize($file) === 0){
            return [];
        }

        $old_records = json_decode(file_get_contents($file));
        if($old_records === null){
            return [];
        }
        return $old_records;
    }
    
    //saving workout
    function save_workout(Workout $new_workout){
        //declaring variables
        $data_to_save="";
        $encoded_data="";
        $old_records = get_workouts_old_records();
        $file = get_data_workouts_JSON_path();

        //verifying if file exists
        if(verify_if_JSON_file_exists($file, $new_workout) === "true"){
            return "success";
        }
        if(verify_if_JSON_file_exists($file, $new_workout) === "false"){
            //we add the new workout to the exixsting data
            array_push($old_records, $new_workout);
            $data_to_save = $old_records;
            $encoded_data = get_JSON_file_encoded_data($data_to_save);

            //verifying if tyhe workout is saved successfully
            if(!file_put_contents($file, $encoded_data)){
                return "error";
            }else{
                return "success";
            }
        }
        return "error";

    }

    //getting workouts by user code
    function get_workouts_by_user_code($user_code){
        $old_records = get_workouts_old_records();
        $workouts_by_user_code = array();
        foreach($old_records as $record){
            if(!isset($record->user_code) ||
            !isset($record->workout_name) ||
            !isset($record->workout_exercises) ||
            !isset($record->workout_code)){
                continue;
            }
            if($record->user_code == $user_code){
                array_push($workouts_by_user_code, $record);
            }
        }
        if(empty($workouts_by_user_code)){
            return "error";
        }
        else{
            return $workouts_by_user_code;
        }
    }

    //updating workouts
    function update_workout(Workout $updated_workout){
    $old_records = get_workouts_old_records();
    $file = get_data_workouts_JSON_path();
    $updated = false;

    foreach($old_records as $index => $record){

        if(!isset($record->workout_code)){
            continue;
        }

        if($record->workout_code == $updated_workout->getworkout_code()){

            $old_records[$index]->workout_name = $updated_workout->getworkout_name();
            $old_records[$index]->workout_exercises = $updated_workout->getworkout_exercises();

            $updated = true;
            break;
        }
    }

    if($updated){
        $encoded_data = get_JSON_file_encoded_data($old_records);

        if(!file_put_contents($file, $encoded_data)){
            return "error";
        }

        return "success";
    }

    return "error";
}
?>