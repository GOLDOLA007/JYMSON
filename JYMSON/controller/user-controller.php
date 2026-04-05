<?php 
    require_once __DIR__ . '/../model/User.php';
    require_once __DIR__ . '/functions/users-functions.php';

    function controller_save_user(User $new_user){
        if(save_user($new_user) === "success"){
            return "success";
        }
        else{
            return "error";
        }
    }

    function controller_search_user(User $user){
        if(search_user($user) === "success"){
            return "success";
        }
        else{
            return "error";
        }
    }

    function controller_get_name_user_by_email(){
        return get_user_name_by_email($_SESSION["user_email"] ?? '');
    }

    function controller_get_code_user_by_email(){
        return get_code_user_by_email($_SESSION["user_email"] ?? '');
    }

?>