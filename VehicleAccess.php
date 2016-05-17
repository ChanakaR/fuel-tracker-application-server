<?php

/**
 * Created by PhpStorm.
 * User: bmCSoft
 * Date: 2016-03-26
 * Time: 10:11 PM
 */

require_once ("./JsonMessages.php");
require_once ("./Access.php");

class VehicleAccess implements Access
{
    private $db =null;
    private $connection = null;

    public function __construct()
    {
        require_once(__DIR__.'/DBConnection.php');
        $this->db = new DBConnection();
        $this->connection = $this->db->openConnection();
    }

    public function insertRow($data_array){
        if($this->connection != null){
            if(mysqli_query($this->connection,"INSERT INTO vehicle (licence_plate,make,model,year,fuel_type,v_class) VALUES ('$data_array[lplate]','$data_array[make]','$data_array[model]','$data_array[year]','$data_array[ftype]','$data_array[v_class]');")){
                return OPERATION_SUCCESS;
            }else{
                return OPERATION_UNSUCCESSFUL;
            }
        }else{
            return CONNECTION_ERROR;
        }

    }

    public function updateRow($data_array){
        if($this->connection != null){
            if(mysqli_query($this->connection,"UPDATE vehicle SET licence_plate = '$data_array[lplate]',make='$data_array[make]',model='$data_array[model]',year='$data_array[year]',fuel_type='$data_array[ftype]',v_class='$data_array[v_class]' WHERE id='$data_array[v_id]';")){
                return OPERATION_SUCCESS;
            }else{
                return OPERATION_UNSUCCESSFUL;
            }
        }else{
            return CONNECTION_ERROR;
        }
    }

    public function deleteRow($data_array){
        if($this->connection != null){
            if(mysqli_query($this->connection,"DELETE FROM vehicle WHERE id='$data_array[v_id]';")){
                return OPERATION_SUCCESS;
            }else{
                return OPERATION_UNSUCCESSFUL;
            }
        }else{
            return CONNECTION_ERROR;
        }
    }

    /*
     * return a json
     *  {   error_code : CODE,
     *      message : JSON_DATA
     *  }
     *
     */
    public function selectAll(){
        if($this->connection != null){
            $query = "SELECT * FROM vehicle ";
            $result = $this->connection->query($query);
            $vehicle_array = array();
            while($row =mysqli_fetch_assoc($result))
            {
                $vehicle_array[] = $row;
            }
            $json_data = json_encode($vehicle_array,true);
            $response_json = '{
                            "error_code" : "0",
                            "message" : '.$json_data.'
                          }';
            $this->disconnect();
            return $response_json;
        }else{
            return CONNECTION_ERROR;
        }
    }

    public function disconnect(){
        if($this->db != null){
            $this->db->closeConnection($this->connection);
        }
    }

    public function select($data_array)
    {
        // TODO: Implement select() method.
    }
}