<?php

class Select{


    public $query = "SELECT * FROM event_database WHERE";





    function column($column){
        return "{$this->query} {$column}";
    }    


    function ge($val){
        return "{$this->query} >= {$val}";
    }
    function le($val){
        return "{$this->query} <= {$val}";
    }

   

    function groupCondition(...$conditions){



    }


    function or(){
        return " OR ";
    }


    function and(){
        return " AND ";
    }



}
