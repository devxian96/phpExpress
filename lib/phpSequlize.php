<?php
// phpSequelize ORM
class Sequelize
{
    public function __construct($sqla)
    {
        //SQL Connection
        $this->sqla = $sqla;
    }

    public static function options($options, $noCount = true)
    {
        $query = ' WHERE `deletedAt` IS NULL ';

        // where
        if (property_exists($options, 'where')) {
            foreach ($options->where as $key => $value) {
                if ($value == '') {
                    break;
                } else if ($key == 'gt') {
                    foreach ($value as $keyGT => $valueGT) {
                        $query .= " AND `$keyGT` > '$valueGT' ";
                    }
                } else if ($key == 'gte') {
                    foreach ($value as $keyGTE => $valueGTE) {
                        $query .= " AND `$keyGTE` >= '$valueGTE' ";
                    }
                } else if ($key == 'lt') {
                    foreach ($value as $keyLT => $valueLT) {
                        $query .= " AND `$keyLT` < '$valueLT' ";
                    }
                } else if ($key == 'lte') {
                    foreach ($value as $keyLTE => $valueLTE) {
                        $query .= " AND `$keyLTE` <= '$valueLTE' ";
                    }
                } else if ($key == 'or') {
                    foreach ($value as $keyLTE => $valueLTE) {
                        $query .= " OR `$keyLTE` = '$valueLTE' ";
                    }
                } else if ($key == 'or like' && $value != '') {
                    $query .= " AND (";
                    foreach ($value as $keyLTE => $valueLTE) {
                        $query .= " `$keyLTE` LIKE '%$valueLTE%' OR ";
                    }
                    $query = substr($query, 0, -3);
                    $query .= ") ";
                } else if ($key == 'and like' && $value != '') {
                    $query .= " AND (";
                    foreach ($value as $keyLTE => $valueLTE) {
                        $query .= " `$keyLTE` LIKE '%$valueLTE%' AND ";
                    }
                    $query = substr($query, 0, -3);
                    $query .= ") ";
                } else {
                    $query .= " AND `$key` ='$value' ";
                }
            }
        }

        // master
        if (property_exists($options, 'master')) {
            $query .= " AND ( 1 = 1";
            foreach ($options->master as $key => $value) {
                if ($value == '') {
                    break;
                } else if ($key == 'gt') {
                    foreach ($value as $keyGT => $valueGT) {
                        $query .= " `$keyGT` > $valueGT ";
                    }
                } else if ($key == 'gte') {
                    foreach ($value as $keyGTE => $valueGTE) {
                        $query .= " AND `$keyGTE` >= $valueGTE ";
                    }
                } else if ($key == 'lt') {
                    foreach ($value as $keyLT => $valueLT) {
                        $query .= " AND `$keyLT` < $valueLT ";
                    }
                } else if ($key == 'lte') {
                    foreach ($value as $keyLTE => $valueLTE) {
                        $query .= " AND `$keyLTE` <= $valueLTE ";
                    }
                } else if ($key == 'or') {
                    foreach ($value as $keyLTE => $valueLTE) {
                        $query .= " OR `$keyLTE` = $valueLTE ";
                    }
                } else {
                    $query .= " AND `$key` =$value ";
                }
            }
            $query .= " ) ";
        }

        //order DESC/ASC
        if (property_exists($options, 'order') && $noCount == true) {
            $query .= ' ORDER BY ';
            foreach ($options->order as $value) {
                $query .= $value . ', ';
            }
            $query = substr($query, 0, -2);
        }

        // limit - in offset
        if (property_exists($options, 'limit') && $noCount == true) {
            if ($options->limit == '') {
                $query .= ' LIMIT 20';
            } else {
                $query .= ' LIMIT ' . $options->limit;
            }

            // offset
            if (property_exists($options, 'offset')) {
                if ($options->offset == '') {
                    $query .= ' OFFSET 0';
                } else {
                    $query .= ' OFFSET ' . $options->offset;
                }
            }
        }

        return $query;
    }

    public static function attributesCount($options)
    {
        $query = '';

        // attributes
        if (property_exists($options, 'attributes')) {
            // distinct
            if (property_exists($options, 'distinct')) {
                $query .= 'COUNT(distinct ' . $options->attributes . ') ';
            } else {
                $query .= 'COUNT(' . $options->attributes . ') ';
            }
        } else {
            $query .= 'COUNT(*) ';
        }
        return $query;
    }

    public static function attributes($options)
    {
        $query = '';

        // distinct
        if (property_exists($options, 'distinct')) {
            $query .= "distinct ";
        }

        // attributes
        if (property_exists($options, 'attributes')) {
            foreach ($options->attributes as $value) {
                $query .= $value . ', ';
            }
            $query = substr($query, 0, -2);
        } else {
            $query = "*";
        }
        return $query;
    }

    public static function insertOptions($options)
    {
        $now = date("Y-m-d H:i:s");
        $key = "`createdAt`, `updatedAt`, ";
        $value = "'$now', '$now', ";

        // key
        foreach ($options as $keyIn => $valueIn) {
            $key .= '`' . $keyIn . '`, ';
            $value .= '\'' . $valueIn . '\', ';
        }
        $key = substr($key, 0, -2);
        $value = substr($value, 0, -2);

        return '(' . $key . ') VALUES(' . $value . ')';
    }

    public static function updateOptions($options)
    {
        $now = date("Y-m-d H:i:s");
        $query = "`updatedAt` = '$now', ";

        // key
        foreach ($options as $key => $value) {
            $query .= '`' . $key . '` = \'' . $value . '\', ';
        }
        $query = substr($query, 0, -2);

        return $query;
    }

    // SELECT
    public function findOne($table, $options)
    {
        try {
            $optionQuery = sql::options($options);
            $attributesQuery = sql::attributes($options);
            $data = sql_query("SELECT $attributesQuery FROM `$table` $optionQuery LIMIT 1", $this->sqla);
            return $data->fetch_array(MYSQLI_ASSOC);
        } catch (Exception $e) {
            return null;
        }
    }

    public function findAll($table, $options)
    {
        try {
            $optionQuery = sql::options($options);
            $attributesQuery = sql::attributes($options);
            // echo "SELECT $attributesQuery FROM `$table` $optionQuery\n";
            $data = sql_query("SELECT $attributesQuery FROM `$table` $optionQuery", $this->sqla);
            $result = null;
            while ($rowJson = $data->fetch_array(MYSQLI_ASSOC)) {
                $result[] = $rowJson;
            }

            return $result;
        } catch (Exception $e) {
            return null;
        }
    }

    public function count($table, $options)
    {
        try {
            $optionQueryCount = sql::options($options, false);
            $attributesQuery = sql::attributesCount($options);
            // echo "SELECT $attributesQuery FROM `$table` $optionQueryCount\n";
            $data = sql_query("SELECT $attributesQuery FROM `$table` $optionQueryCount", $this->sqla);

            return $data->fetch_array(MYSQLI_ASSOC);
        } catch (Exception $e) {
            return null;
        }
    }

    public function findAndCount($table, $options)
    {
        try {
            $optionQueryCount = sql::options($options, false);
            $optionQuery = sql::options($options);
            $attributesQuery = sql::attributes($options);
            // echo "SELECT COUNT(*) FROM `$table` $optionQuery\n";
            // echo "SELECT $attributesQuery FROM `$table` $optionQuery\n";
            $count = sql_query("SELECT COUNT(*) FROM `$table` $optionQueryCount", $this->sqla);
            $data = sql_query("SELECT $attributesQuery FROM `$table` $optionQuery", $this->sqla);
            $countResult = $count->fetch_array(MYSQLI_ASSOC);
            $result = null;
            while ($rowJson = $data->fetch_array(MYSQLI_ASSOC)) {
                $result[] = $rowJson;
            }

            return (object) ['count' => $countResult['COUNT(*)'], 'data' => $result];
        } catch (Exception $e) {
            return null;
        }
    }

    // INSERT
    public function create($table, $options)
    {
        $insertQuery = sql::insertOptions($options);
        // echo "INSERT INTO `$table` $insertQuery\n";
        sql_query("INSERT INTO `$table` $insertQuery", $this->sqla);
        return mysqli_insert_id($this->sqla);
    }

    // UPDATE
    public function update($table, $data, $options)
    {
        $optionQuery = sql::options($options);
        $updateOptions = sql::updateOptions($data);
        // echo "UPDATE `$table` SET $updateOptions $optionQuery\n";
        sql_query("UPDATE `$table` SET $updateOptions $optionQuery", $this->sqla);
    }

    // DELETE
    public function destory($table, $options)
    {
        $now = date("Y-m-d H:i:s");
        $optionQuery = sql::options($options);
        sql_query("UPDATE `$table` SET `deletedAt` = '$now' $optionQuery", $this->sqla);
    }
}
