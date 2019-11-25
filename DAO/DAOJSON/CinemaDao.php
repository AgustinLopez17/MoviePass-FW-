<?php namespace DAO\DAOJSON;

    use DAO\IRepository as IRepository;
    use Models\Cinema as Cinema;
    use DAO\DAODB\IDao;
    class CinemaDao implements IDao
    {
        private $cinemaList = array();

        
        public function create($newCinema){
            $this->RetrieveData();
            array_push($this->cinemaList,$newCinema);
            $this->SaveData();
        }

        public function update($id,$capacity,$ticket_value,$available){
            $cinema = $this->read($id);
        }

        public function readAll(){
            $this->RetrieveData();
            return $this->cinemaList;
        }

        public function delete($id){
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
                $valuesArray['id'] = $cinema->getId();
                $valuesArray["name"] = $cinema->getName();
                $valuesArray["address"] = $cinema->getAddress();
                $valuesArray["capacity"] = $cinema->getCapacity();
                $valuesArray["ticket_value"] = $cinema->getTicket_value();
                $valuesArray["available"] = $cinema->getAvailable();
                array_push($arrayToEncode, $valuesArray);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            $jsonPath = $this->GetJsonFilePath();
            
            file_put_contents($jsonPath, $jsonContent);
        }

        private function mapear() {
            
            $this->cinemaList = array();
            $jsonPath = $this->GetJsonFilePath();
                
            $jsonContent = file_get_contents($jsonPath);

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            if(is_array($arrayToDecode)){
                foreach($arrayToDecode as $valuesArray)
                {
    
                    $cinema = new Cinema($valuesArray["id"],$valuesArray["name"], $valuesArray["address"], $valuesArray["capacity"], $valuesArray["ticket_value"],$valuesArray["available"]);
    
                    array_push($this->cinemaList, $cinema);
    
                }
            }

        }

        public function read($id) {
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