<?php

    class Admin {
        private int $adminId = 0;

        private string $pseudo = "";

        private string $email = "";

        private string $password = "";
    
        public function getId(){return $this->adminId;}
        public function setId($adminId){$this->adminId = $adminId;}
    
        public function getPseudo(){return $this->pseudo;}
        public function setPseudo($pseudo){$this->pseudo = $pseudo;}
    
        public function getEmail(){return $this->email;}
        public function setEmail($email){$this->email = $email;}
    
        public function getPassword(){return $this->password;}
        public function setPassword($password){$this->password = $password;}


}

    