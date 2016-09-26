<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/City.php";

    $server = 'mysql:host=localhost:8889;dbname=airline_planner_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class CityTest extends PHPUnit_Framework_TestCase
    {
      protected function tearDown()
      {
         City::deleteAll();
      }

        function test_getId()
        {
            //Arrange
            $id = 1;
            $name = "Johannesburg";
            $test_city= new City($name, $id);

            //Act
            $result = $test_city->getId();

            //Assert
            $this->assertEquals($id, $result);

        }

        function test_getName()
        {
            //Arrange
            $id = 1;
            $name = "Ulaanbaatar";
            $test_city = new City($name, $id);

            //Act
            $result = $test_city->getName();

            //Assert
            $this->assertEquals($name, $result);

        }

        function test_setName()
        {
            //Arrange
            $id = 1;
            $name = "Medellin";
            $test_city = new City($name, $id);
            $new_name = "Memphis";

            //Act
            $test_city->setName($new_name);
            $result = $test_city->getName();

            //Assert
            $this->assertEquals($new_name, $result);
        }

        function test_save()
        {
            //Arrange
            $id = null;
            $name = "Philadelphia";
            $test_city = new City($name, $id);
            $test_city->save();

            //Act
            $result = City::getAll();

            //Assert
            $this->assertEquals($test_city, $result[0]);
        }

        function test_getAll()
        {
            //Arrange

            $name = "Honolulu";
            $name2 = "Buenos Aires";
            $test_city = new City($name);
            $test_city->save();
            $test_city2 = new City($name2);
            $test_city2->save();

            //Act
            $result = City::getAll();

            //Assert
            $this->assertEquals([$test_city, $test_city2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            // create more than one task
            $name = "Dhaka";
            $name2 = "Bangkok";
            $test_city = new City($name);
            $test_city->save();
            $test_city2 = new City($name2);
            $test_city2->save();

            //Act
            City::deleteAll();
            $result = City::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
          // Arrange
          $name = "Memphis";
          $test_city = new City($name);
          $test_city->save();

          // Act
          $result = City::find($test_city->getId());

          //
          $this->assertEquals($test_city, $result);
        }

        function test_AddAirplane()
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
            $test_city->addAirplane($test_airplane);

            //ASSERT
            $this->assertEquals($test_city->getAirplanes(), [$test_airplane]);
        }

        function testGetAirplanes()
        {
            //Arrange
            $airplane_name = "Air Force 1";
            $id = 1;
            $test_airplane = new Airplane($airplane_name, $id);
            $test_airplane->save();

            $airplane_name2 = "Raptor";
            $id2 = 2;
            $test_airplane2 = new Airplane($airplane_name2, $id2);
            $test_airplane2->save();

            $city_name = "Riyadh";
            $id3 = 3;
            $test_city = new City($city_name, $id3);
            $test_city->save();

            //Act
            $test_city->addAirplane($test_airplane);
            $test_city->addAirplane($test_airplane2);

            //Assert
            $this->assertEquals($test_city->getAirplanes(), [$test_airplane, $test_airplane2]);
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
            $test_city->addAirplane($test_plane);
            $test_city->delete();

            //Assert
            $this->assertEquals([], $test_city->getAirplanes());
        }
    }
?>
