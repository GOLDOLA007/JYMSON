<?php 
    class Workout{

        //attributes
          private string $workout_name="";
          private array $exercises=array();
          private string $workout_code="";
          private string $user_code="";

        //constructor]
        public function __construct(
            string $workout_name,
            string $workout_email,
            string $workout_password,
            string $workout_code
        ){
            $this->workout_name = $workout_name;
            $this->workout_email = $workout_email;
            $this->workout_password = $workout_password;
            $this->workout_code = $workout_code;
        }

         //set functions
        public function setworkout_name($workout_name){
            $this->workout_name = $workout_name;
        }
        public function setworkout_email($workout_email){
            $this->workout_email = $workout_email;
        }
        public function setworkout_password($workout_password){
            $this->workout_password = $workout_password;
        }
        public function setworkout_code($workout_code){
            $this->workout_code = $workout_code;
        }

        //get functions
        public function getworkout_name(){
            return $this->workout_name;
        }
        public function getworkout_email(){
            return $this->workout_email;
        }
        public function getworkout_password(){
            return $this->workout_password;
        }
        public function getworkout_code(){
            return $this->workout_code;
        }          
    }
?>