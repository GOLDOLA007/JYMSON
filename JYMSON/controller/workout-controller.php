<?php 
    require_once __DIR__ . '/functions/workouts-functions.php';
    require_once __DIR__ . '/../model/Workout.php';
    
    function controller_save_workout(Workout $new_workout){
        if(save_workout($new_workout) === "success"){
            return "success";
        }else{
            return "error";
        }
    }

    function controller_get_workouts_by_user_code($user_code){
        $workouts = get_workouts_by_user_code($user_code);
        if($workouts === "error"){
            return "error";
        }else{
            return $workouts;
        }
    }

    function controller_update_workout(Workout $updated_workout){
        if(update_workout($updated_workout) === "error"){
            return "error";
        }else{
            $_SESSION['message'] = 'Workout updated successfully.';
            return "success";
        }
    }

?>