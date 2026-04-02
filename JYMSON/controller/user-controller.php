<?php 
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

?>