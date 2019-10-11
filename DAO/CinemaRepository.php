<?php namespace DAO;
    use DAO\IRepository as IRepository;
    use Models\Cinema as Cinema;

    class CinemaRepository implements IRepository
    {
        private $cinemaList = array();

        public function DeleteAll(){
            $this->cinemaList = null;
            $this->SaveData();
        }

        public function Add($newCinema){
            $this->RetrieveData();
            array_push($this->cinemaList,$newCinema);
            $this->SaveData();
        }

        public function GetAll(){
            $this->RetrieveData();
            return $this->cinemaList;
        }

        public function Delete($adress){
            $this->RetrieveData();
            $newList = array();
            foreach($this->cinemaList as $value){
                if($value->getId() != $adress){
                    array_push($newList,$value);
                }
            }
            $this->cinemaList = $newList;
            $this->SaveData();
        }

        private function SaveData() {
            $arrayToEncode = array();
            
            
            foreach($this->cinemaList as $cinema)
            {
                $valuesArray["name"] = $cinema->getName();
                $valuesArray["address"] = $cinema->getAddress();
                $valuesArray["capacity"] = $cinema->getCapacity();
                $valuesArray["ticket_value"] = $cinema->getTicket_value();
 
                array_push($arrayToEncode, $valuesArray);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            $jsonPath = $this->GetJsonFilePath();
            
            file_put_contents($jsonPath, $jsonContent);
        }

        private function RetrieveData() {
            
            $this->cinemaList = array();
            $jsonPath = $this->GetJsonFilePath();
                
            $jsonContent = file_get_contents($jsonPath);

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            if(is_array($arrayToDecode)){
                foreach($arrayToDecode as $valuesArray)
                {
    
                    $cinema = new Cinema($valuesArray["name"], $valuesArray["address"], $valuesArray["capacity"], $valuesArray["ticket_value"]);
    
                    array_push($this->cinemaList, $cinema);
    
                }
            }

        }

        public function getById($id) {
            $this->RetrieveData();
            foreach ($this->cinemaList as $key => $cinema) {
                if($cinema->getId() == $id) {
                    return $cinema;
                }
            }
        }

        function GetJsonFilePath(){

            $initialPath = "Data/jCinema.json";
            
            if(file_exists($initialPath)){
                $jsonFilePath = $initialPath;
            }else{
                $jsonFilePath = "../".$initialPath;
            }
            
            $jsonFilePath = ROOT."Data/jCinema.json"; //METER ESTO ARRIBA PARA SIMPLIFICAR

            return $jsonFilePath;
        }

    }




?>