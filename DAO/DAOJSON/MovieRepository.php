<?php namespace DAO;

    use DAO\IRepository as IRepository;
    use Models\Movie as Movie;

    class MovieRepository implements IRepository
    {
        private $movieList = array();

        public function DeleteAll(){
            $this->movieList = null;
            $this->SaveData();
        }

        public function Add($newMovie){
            $this->RetrieveData();
            array_push($this->movieList,$newMovie);
            $this->SaveData();
        }

        public function GetAll(){
            $this->RetrieveData();
            return $this->movieList;
        }

        public function Delete($id){
            $this->RetrieveData();
            $newList = array();
            foreach($this->movieList as $value){
                if($value->getId() != $id){
                    array_push($newList,$value);
                }
            }
            $this->movieList = $newList;
            $this->SaveData();
        }

        private function SaveData() {
            $arrayToEncode = array();
            
            
            foreach($this->movieList as $user)
            {
                $valuesArray["id"] = $user->getId();
                $valuesArray["title"] = $user->getTitle();
                $valuesArray["runtime"] = $user->getLenght();
                $valuesArray["original_language"] = $user->getLanguage();
                $valuesArray["backdrop_path"] = $user->getImage();
                $valuesArray["overview"] = $user->getOverview();
 
                array_push($arrayToEncode, $valuesArray);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            $jsonPath = $this->GetJsonFilePath();
            
            file_put_contents($jsonPath, $jsonContent);
        }

        private function RetrieveData() {
            
            $this->movieList = array();
            $jsonPath = $this->GetJsonFilePath();
                
            $jsonContent = file_get_contents($jsonPath);

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            if(is_array($arrayToDecode)){
                foreach($arrayToDecode as $valuesArray)
                {
    
                    $movie = new Movie($valuesArray["id"], $valuesArray["title"], $valuesArray["runtime"], $valuesArray["original_language"], $valuesArray["backdrop_path"],$valuesArray["overview"]);
    
                    array_push($this->movieList, $movie);
    
                }
            }

        }

        public function getById($id) {
            $this->RetrieveData();
            foreach ($this->movieList as $key => $movie) {
                if($movie->getId() == $id) {
                    return $movie;
                }
            }
        }

        function GetJsonFilePath(){

            $initialPath = "Data/jMovie.json";
            
            if(file_exists($initialPath)){
                $jsonFilePath = $initialPath;
            }else{
                $jsonFilePath = "../".$initialPath;
            }
            
            $jsonFilePath = ROOT."Data/jMovie.json"; //METER ESTO ARRIBA PARA SIMPLIFICAR

            return $jsonFilePath;
        }

        function retrieveDataApi(){
            $cont = 0;
            $response = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?page=1&language=en-US&api_key=bf47253392bc9b0762556be7b49ab033");
            $array = ($response) ? json_decode($response, true) : array();
            $this->deleteNotNowPlaying($array);
            foreach($array as $value){
                if(is_array($value)){
                    foreach($value as $aux){
                        if(is_array($aux)){
                            if(!$this->getById($aux['id'])){
                                $data = file_get_contents("https://api.themoviedb.org/3/movie/".$aux['id']."?language=en-US&api_key=bf47253392bc9b0762556be7b49ab033");
                                $movie = ($data) ? json_decode($data, true) : array();
                                $newMovie = new Movie($movie["id"],$movie["title"],$movie["runtime"],$movie["original_language"],$movie["poster_path"],$movie['overview']);
                                $this->add($newMovie);
                            }
                        }
                    }
                }
            }
        }

        function deleteNotNowPlaying($array){
            $all = $this->GetAll();
            $flag = false;
            foreach($all as $valueR){
                foreach($array as $value){
                    if(is_array($value)){
                        foreach($value as $aux){
                            if(is_array($aux)){
                                if($valueR->getId() == $aux['id']){
                                    $flag = true;
                                    break;
                                }else{
                                    $flag = false;
                                }
                            }
                        }
                    }
                    if($flag)
                        break;
                }
                if(!$flag){
                    $this->delete($valueR->getId());
                }
            }
        }



    }
?>