<?php


class H {

public $mysqli;
public $database;


    public function __construct($database)
    {
        $this->database = $database;
        $this->open_connection();
    }

    function open_connection()
    {

        if(!$this->mysqli){

            $this->mysqli = new mysqli( 'localhost', 'root', 'secret', $this->database);
             $this->mysqli->set_charset("utf8");
        }

    }


    public function query($SQL, $column_index_array = null)
    {
        $retorno = [];


        $result = $this->mysqli->query($SQL);

        while($line = $result->fetch_assoc()) {

            if($column_index_array) {
                $retorno[$line[$column_index_array]] = $line;
            }else{
                $retorno[] = $line;
            }

        }


        return $retorno;
    }



    public function getTables()
    {
        $SQL = "
            SELECT
                table_name,
                table_comment 
            FROM
                INFORMATION_SCHEMA.TABLES 
            WHERE
                table_schema='{$this->database}' 

        ";

        $aux = $this->query($SQL);

        $retorno = [];

        for ($i = 0; $i < count($aux); $i++) {

            $retorno[] = [
                'id' => $i+1,
                'table' => $aux[$i]['table_name'],
                'comment' => $aux[$i]['table_comment'],
                'columns' => $this->getColumns($aux[$i]['table_name']),
            ];

        }

        return $retorno;
    }


    public function getColumns($table)
    {

        $SQL = "
            SELECT
                COLUMNS.TABLE_NAME 'table',
                COLUMNS.COLUMN_NAME 'column',
                COLUMNS.ORDINAL_POSITION 'position',
                COLUMNS.COLUMN_DEFAULT 'default',
                COLUMNS.IS_NULLABLE 'nullable',
                COLUMNS.DATA_TYPE 'type',
                COLUMNS.CHARACTER_MAXIMUM_LENGTH 'char_max',
                CONCAT(COLUMNS.NUMERIC_PRECISION, ',', COLUMNS.NUMERIC_SCALE) 'num_max',
                COLUMNS.DATETIME_PRECISION 'date_max',
                COLUMNS.COLUMN_KEY 'column_type',
                COLUMNS.EXTRA 'extra',
                COLUMNS.COLUMN_COMMENT 'comment',
                KEY_COLUMN_USAGE.REFERENCED_TABLE_NAME 'foreignkey'
                
            FROM
                INFORMATION_SCHEMA.COLUMNS
                
                LEFT JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE ON
                KEY_COLUMN_USAGE.COLUMN_NAME = COLUMNS.COLUMN_NAME
                AND 
                KEY_COLUMN_USAGE.REFERENCED_TABLE_SCHEMA = COLUMNS.TABLE_SCHEMA
                AND
                KEY_COLUMN_USAGE.TABLE_NAME = COLUMNS.TABLE_NAME 
                
            WHERE
                COLUMNS.TABLE_SCHEMA = '{$this->database}'
                AND
                COLUMNS.TABLE_NAME = '{$table}'
        ";

        $aux = $this->query($SQL);


        $retorno = [];


        foreach ($aux as $key => $value) {

            $aux_column = [
                'description' => $value['column'],
                'type' => $value['type'],
                'size' => $this->get_size($value),
                'nullable' => ($value['nullable'] == 'YES') ? 'Sim' : 'Não',
                'key' => $this->get_type_key($value),
                'comment' => $value['comment'],
            ];

            $retorno[$value['column']] = $aux_column;

        }

        return $retorno;
    }


    private function get_size($array)
    {

        $type = $array['type'];

        $aux = "";

        switch ($type) {

            case 'varchar':
            case 'char':
            case 'text':
            case 'longtext':
                $aux = $array['char_max'];
                break;

            case  'time':
            case  'datetime':
            case  'timestamp':
                $aux = ($array['date_max']) ? $array['date_max'] : '-';
                break;

            default:
                $aux = $array['num_max'];

        }

        return $aux;

    }

    private function get_type_key($array)
    {

        if($array['column_type'] == "PRI")
            return "PK";

        elseif(!empty($array['foreignkey']))
            return "FK";

        else return "-";

    }

}

