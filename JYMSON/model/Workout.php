<?php 

    require_once __DIR__ . '/../controller/functions/general-functions.php';
    require_once __DIR__ . '/User.php';

    class Workout  extends User implements JsonSerializable{

        //attributes
          private string $workout_name="";
          public array $workout_exercises=array(
            [
                'name' => '',
                'weight' => '',
                'reps' => '',
                'sets' => ''
            ]
        );
        private string $workout_code="";
        private string $user_code="";

        //constructor]
        public function __construct(
            string $workout_name,
            array $workout_exercises,
            string $user_code,
            string $workout_code
        ){
            $this->workout_name = $workout_name;
            $this->workout_exercises = $workout_exercises;
            $this->user_code = $user_code;
            $this->workout_code = $workout_code;
        }

         //set functions
        public function setworkout_name($workout_name){
            $this->workout_name = $workout_name;
        }
        public function setworkout_exercises($workout_exercises){
            $this->workout_exercises = $workout_exercises;
        }
        public function setworkout_code($workout_code){
            $this->workout_code = $workout_code;
        }

        //get functions
        public function getworkout_name(){
            return $this->workout_name;
        }
        public function getworkout_code(){
            return $this->workout_code;
        }
        public function getworkout_exercises(){
            return $this->workout_exercises;
        }
        
        public function getUser_code(){
            return $this->user_code;
        }
        
        //JSON structure
        public function jsonSerialize(): mixed{
            return [
                'workout_name' => $this->workout_name,
                'workout_code' => $this->workout_code,
                'workout_exercises' => $this->workout_exercises,
                'user_code' => $this->user_code
            ];
        }
    }
?>