<?php 
    class User implements JsonSerializable{

        //attributes
        private string $user_name="";
        private string $user_email="";
        private string $user_password="";
        private string $user_code="";

        //constructor
        public function __construct(
            string $user_name,
            string $user_email,
            string $user_password,
            string $user_code
        ){
            $this->user_name = $user_name;
            $this->user_email = $user_email;
            $this->user_password = $user_password;
            $this->user_code = $user_code;
        }

        //set functions
        public function setUser_name($user_name){
            $this->user_name = $user_name;
        }
        public function setUser_email($user_email){
            $this->user_email = $user_email;
        }
        public function setUser_password($user_password){
            $this->user_password = $user_password;
        }
        public function setUser_code($user_code){
            $this->user_code = $user_code;
        }

        //get functions
        public function getUser_name(){
            return $this->user_name;
        }
        public function getUser_email(){
            return $this->user_email;
        }
        public function getUser_password(){
            return $this->user_password;
        }
        public function getUser_code(){
            return $this->user_code;
        }

        public function jsonSerialize(): mixed{
            return [
                'user_name' => $this->user_name,
                'user_email' => $this->user_email,
                'user_password' => $this->user_password,
                'user_code' => $this->user_code,
            ];
        }
           
    }
?>