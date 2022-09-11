
<?php 

class QUERY{

    public static function CREATE_TABLE(){
        return file_get_contents('./queries/create_table');
    }

    public static function SELECT_FILENAMES(){
        return file_get_contents('./queries/select_filenames');
    }

    public static function INSERT_RECORD(){
        return file_get_contents('./queries/insert_record');
    }

}



?>