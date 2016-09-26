<?php

    class Airplane
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

        function save()
        {
          $GLOBALS['DB']->exec("INSERT INTO airplanes (name) VALUES ('{$this->getName()}');");
          $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_airplanes = $GLOBALS['DB']->query("SELECT * FROM airplanes;");
            $airplanes = array();
            foreach($returned_airplanes as $airplane) {
                $name = $airplane['name'];
                $id = $airplane['id'];
                $new_plane = new Airplane ($name, $id);
                array_push($airplanes, $new_plane);
            }
            return $airplanes;
        }

        static function find($search_id)
        {

          $found_name = null;
          $names = Airplane::getAll();
          foreach($names as $name) {
            $name_id = $name->getId();
            if ($name_id == $search_id) {
              $found_name = $name;
            }
          }
          return $found_name;
        }

        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM airplanes;");
        }

        function addCity($new_city)
        {
            $GLOBALS['DB']->exec("INSERT INTO flights (airplane_id, city_id) VALUES ({$this->getId()}, {$new_city->getId()});");
        }

        function getCities()
        {
            $sql_command = "SELECT city_id FROM flights WHERE airplane_id = {$this->getId()};";

            $query = $GLOBALS['DB']->query($sql_command);
            $city_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $cities = array();
            foreach($city_ids as $id) {
                $city_id = $id['city_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM cities WHERE id = {$city_id};");
                $returned_city = $result->fetchAll(PDO::FETCH_ASSOC);

                $city_name = $returned_city[0]['name'];
                $id = $returned_city[0]['id'];
                $new_city = new City($city_name, $id);
                array_push($cities, $new_city);
            }
            return $cities;
        }
        function delete()
        {
          $GLOBALS['DB']->exec("DELETE FROM airplanes WHERE id = {$this->getId()};");
          $GLOBALS['DB']->exec("DELETE FROM flights WHERE airplane_id = {$this->getId()};");
        }
    }

?>
