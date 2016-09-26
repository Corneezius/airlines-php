<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Airplane.php";

    $server = 'mysql:host=localhost:8889;dbname=airline_planner_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class AirplaneTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
           Airplane::deleteAll();
           City::deleteAll();
        }

        function test_getId()
        {
            //Arrange
            $id = 1;
            $name = "Jumbo Jet 757";
            $test_airplane = new Airplane($name, $id);

            //Act
            $result = $test_airplane->getId();

            //Assert
            $this->assertEquals($id, $result);

        }

        function test_getName()
        {
            //Arrange
            $id = 1;
            $name = "Jumbo Jet 757";
            $test_airplane = new Airplane($name, $id);

            //Act
            $result = $test_airplane->getName();

            //Assert
            $this->assertEquals($name, $result);

        }

        function test_setName()
        {
            //Arrange
            $id = 1;
            $name = "Jumbo Jet 757";
            $test_airplane = new Airplane($name, $id);
            $new_name = "Soul Plane";

            //Act
            $test_airplane->setName($new_name);
            $result = $test_airplane->getName();

            //Assert
            $this->assertEquals($new_name, $result);

        }

        function test_save()
        {
            //Arrange
            $id = null;
            $name = "Boeing 747";
            $test_airplane = new Airplane($name, $id);
            $test_airplane->save();

            //Act
            $result = Airplane::getAll();

            //Assert
            $this->assertEquals($test_airplane, $result[0]);
        }

        function test_getAll()
        {
            //Arrange

            $name = "Air Force 1";
            $name2 = "B-52";
            $test_airplane = new Airplane($name);
            $test_airplane->save();
            $test_airplane2 = new Airplane($name2);
            $test_airplane2->save();

            //Act
            $result = Airplane::getAll();

            //Assert
            $this->assertEquals([$test_airplane, $test_airplane2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            // create more than one task
            $name = "Air Force 2";
            $name2 = "F-22";
            $test_airplane = new Airplane($name);
            $test_airplane->save();
            $test_airplane2 = new Airplane($name2);
            $test_airplane2->save();

            //Act
            Airplane::deleteAll();
            $result = Airplane::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
          // Arrange
          $name = "Raptor";
          $test_airplane = new Airplane($name);
          $test_airplane->save();

          // Act
          $result = Airplane::find($test_airplane->getId());


          // Assert
          $this->assertEquals($test_airplane, $result);
        }

        function test_AddCity()
        {
            //ARRANGE
            $airplane_name = "Raptor 777";
            $id = 1;
            $test_airplane = new Airplane($airplane_name, $id);
            $test_airplane->save();

            $city_name = "Damascus";
            $id2 = 2;
            $test_city = new City($city_name, $id2);
            $test_city->save();

            //ACT
            $test_airplane->addCity($test_city);

            //ASSERT
            $this->assertEquals($test_airplane->getCities(), [$test_city]);
        }

        function testGetCities()
        {
            //Arrange
            $airplane_name = "Air Force 1";
            $id = 1;
            $test_airplane = new Airplane($airplane_name, $id);
            $test_airplane->save();

            $city_name = "Istambul";
            $id2 = 2;
            $test_city = new City($city_name, $id2);
            $test_city->save();

            $city_name2 = "Santa Marta";
            $id3 = 3;
            $test_city2 = new City($city_name2, $id3);
            $test_city2->save();

            //Act
            $test_airplane->addCity($test_city);
            $test_airplane->addCity($test_city2);

            //Assert
            $this->assertEquals($test_airplane->getCities(), [$test_city, $test_city2]);
        }

        function testDelete()
        {
            //Arrange
            $name = "Metal Bird";
            $id = 1;
            $test_plane = new Airplane($name, $id);
            $test_plane->save();

            $city_name = "Sausalito";
            $id2 = 2;
            $test_city = new City($city_name, $id2);
            $test_city->save();

            //Act
            $test_plane->addCity($test_city);
            $test_plane->delete();

            //Assert
            $this->assertEquals([], $test_plane->getCities());
        }
    }
?>
