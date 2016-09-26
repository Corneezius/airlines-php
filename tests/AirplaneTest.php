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
    }
?>
