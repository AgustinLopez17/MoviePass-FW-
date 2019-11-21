<?php
    namespace Models;
    class Genres{
        
        private $id_genre;
        private $name_genre;

        public function __construct($id_genre,$name_genre = null){
            $this->id_genre = $id_genre;
            $this->name_genre = $name_genre;
        }

        public function getName_genre()
        {
                return $this->name_genre;
        }
        public function setName_genre($name_genre)
        {
                $this->name_genre = $name_genre;

                return $this;
        }

        public function getId_genre()
        {
                return $this->id_genre;
        }
        public function setId_genre($id_genre)
        {
                $this->id_genre = $id_genre;

                return $this;
        }
    }


?>