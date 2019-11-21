<?php 

namespace Models;
    
    class Movie{
        private $id;
        private $title;
        private $lenght;
        private $language;
        private $image;
        private $overview;
        private $background;

        public function __construct($id,$title,$lenght,$language,$image,$overview,$background){
            $this->id = $id;
            $this->title = $title;
            $this->lenght = $lenght;
            $this->language = $language;
            $this->image = $image;
            $this->overview = $overview;
            $this->background = $background;
        }

        public function getTitle()
        {
                return $this->title;
        }
        public function setTitle($title)
        {
                $this->title = $title;

                return $this;
        }

        public function getLenght()
        {
                return $this->lenght;
        }
        public function setLenght($lenght)
        {
                $this->lenght = $lenght;

                return $this;
        }

        public function getLanguage()
        {
                return $this->language;
        }
        public function setLanguage($language)
        {
                $this->language = $language;

                return $this;
        }

        public function getImage()
        {
                return $this->image;
        }
        public function setImage($image)
        {
                $this->image = $image;

                return $this;
        }

        public function getId()
        {
                return $this->id;
        }
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        public function getOverview()
        {
                return $this->overview;
        }
        public function setOverview($overview)
        {
                $this->overview = $overview;

                return $this;
        }

        /**
         * Get the value of background
         */ 
        public function getBackground()
        {
                return $this->background;
        }

        /**
         * Set the value of background
         *
         * @return  self
         */ 
        public function setBackground($background)
        {
                $this->background = $background;

                return $this;
        }
    }

?>