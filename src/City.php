<?php

    class City
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function getId()
        {
          return $this->id;
        }

        function getName()
        {
          return $this->name;
        }

        function setName($new_name)
        {
          $this->name = (string) $new_name;
        }

        static function find($search_id)
        {

          $found_name = null;
          $names = City::getAll();
          foreach($names as $name) {
            $name_id = $name->getId();
            if ($name_id == $search_id) {
              $found_name = $name;
            }
          }
          return $found_name;
        }

        function save()
        {
          $GLOBALS['DB']->exec("INSERT INTO cities (name) VALUES ('{$this->getName()}');");
          $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_cities = $GLOBALS['DB']->query("SELECT * FROM cities;");
            $cities = array();
            foreach($returned_cities as $city) {
                $name = $city['name'];
                $id = $city['id'];
                $new_city = new City ($name, $id);
                array_push($cities, $new_city);
            }
            return $cities;
        }

        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM cities;");
        }

        function addAirplane($new_airplane)
        {
            $GLOBALS['DB']->exec("INSERT INTO flights (airplane_id, city_id) VALUES ({$new_airplane->getId()}, {$this->getId()});");
        }

        function getAirplanes()
        {
            $sql_command = "SELECT airplane_id FROM flights WHERE city_id = {$this->getId()};";

            $query = $GLOBALS['DB']->query($sql_command);
            $airplane_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $airplanes = array();
            foreach($airplane_ids as $id) {
                $airplane_id = $id['airplane_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM airplanes WHERE id = {$airplane_id};");
                $returned_airplane = $result->fetchAll(PDO::FETCH_ASSOC);

                $airplane_name = $returned_airplane[0]['name'];
                $id = $returned_airplane[0]['id'];
                $new_airplane = new Airplane($airplane_name, $id);
                array_push($airplanes, $new_airplane);
            }
            return $airplanes;
        }
        function delete ()
        {
          $GLOBALS['DB']->exec("DELETE FROM cities WHERE id = {$this->getId()};");
          $GLOBALS['DB']->exec("DELETE FROM flights WHERE city_id = {$this->getId()};");
        }
    }

?>
