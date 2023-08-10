<?php

namespace Model;

class ActiveRecord
{

    // Database
    protected static $db;
    protected static $table = '';
    protected static $columnsDB = [];
    public $id;

    // Alerts and messages
    protected static $alerts = [];

    // Define the connection to the database
    public static function setDB($database)
    {
        self::$db = $database;
    }

    public static function setAlert($type, $key, $message)
    {
        static::$alerts[$type][$key] = $message;
    }

    // Validation
    public static function getAlerts()
    {
        return static::$alerts;
    }

    // SQL query to create an object in memory
    public static function querySQL($query)
    {
        // Query the database.
        $result = self::$db->query($query);

        // Iterate the results 
        $array = [];
        while ($record = $result->fetch_assoc()) {
            $array[] = static::createObject($record);
        }

        // Free up memory
        $result->free();

        // Return the results
        return $array;
    }

    // Create an object in memory equal to the database
    protected static function createObject($record)
    {
        $object = new static;

        foreach ($record as $key => $value) {
            if (property_exists($object, $key)) {
                $object->$key = $value;
            }
        }
        return $object;
    }

    // Identify and join the attributes of the database
    public function attributes()
    {
        $attributes = [];
        foreach (static::$columnsDB as $column) {
            if ($column === 'id') continue;
            $attributes[$column] = $this->$column;
        }
        return $attributes;
    }

    // Sanitize data before saving to DB
    public function sanitizeAttributes()
    {
        $attributes = $this->attributes();
        $sanitized = [];
        foreach ($attributes as $key => $value) {
            $sanitized[$key] = is_null($value) ? '' : self::$db->escape_string($value);
        }
        return $sanitized;
    }

    // Synchronize DB with Objects in memory
    public function synchronize($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    // Records - CRUD
    public function save()
    {
        $result = '';
        if (!is_null($this->id)) {
            // Update
            $result = $this->update();
        } else {
            // Create
            $result = $this->create();
        }
        return $result;
    }

    // All records
    public static function all($order = 'DESC')
    {
        $query = "SELECT * FROM " . static::$table . " ORDER BY id " . $order;
        $result = self::querySQL($query);
        return $result;
    }

    // Search for a record by its ID
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$table  . " WHERE id = " . $id;
        $result = self::querySQL($query);
        return array_shift($result);
    }

    // Get records with a limit
    public static function get($limit)
    {
        $query = "SELECT * FROM " . static::$table . " ORDER BY id DESC" . " LIMIT " . $limit;
        $result = self::querySQL($query);
        return $result;
    }

    // Paginate Records
    public static function paginate($per_page, $offset)
    {
        $query = "SELECT * FROM " . static::$table . " ORDER BY id DESC LIMIT " . $per_page . " OFFSET " . $offset;
        $result = self::querySQL($query);
        return $result;
    }

    // Find a record by column and value
    public static function where($column, $value)
    {
        $query = "SELECT * FROM " . static::$table  . " WHERE $column = '" . $value . "'";
        $result = self::querySQL($query);
        return array_shift($result);
    }

    // Return the records in a specific order
    public static function order($column, $order)
    {
        $query = "SELECT * FROM " . static::$table  . " ORDER BY $column " . $order;
        $result = self::querySQL($query);
        return $result;
    }

    // Return the records in a specific order and limit
    public static function orderLimit($column, $order, $limit)
    {
        $query = "SELECT * FROM " . static::$table  . " ORDER BY $column " . $order . " LIMIT " . $limit;
        $result = self::querySQL($query);
        return $result;
    }

    // Find a record by Multiple options
    public static function whereArray($array = [])
    {
        $query = "SELECT * FROM " . static::$table  . " WHERE ";
        foreach ($array as $key => $value) {
            if ($key == array_key_last($array)) {
                $query .= " " . $key . " = '" . $value . "'";
            } else {
                $query .= " " . $key . " = '" . $value . "' AND ";
            }
        }
        $result = self::querySQL($query);
        return $result;
    }

    // Get Total Records
    public static function total($column = '', $value = '')
    {
        $query = "SELECT COUNT(*) FROM " . static::$table;

        if ($column) {
            $query .= " WHERE " . $column . " = " . $value;
        }
        $result = self::$db->query($query);
        $total = $result->fetch_array();

        return array_shift($total);
    }

    // Get Total Records with Array Where
    public static function totalArray($array = [])
    {
        $query = "SELECT COUNT(*) FROM " . static::$table . " WHERE ";
        foreach ($array as $key => $value) {
            if ($key == array_key_last($array)) {
                $query .= " " . $key . " = '" . $value . "'";
            } else {
                $query .= " " . $key . " = '" . $value . "' AND ";
            }
        }
        $result = self::$db->query($query);
        $total = $result->fetch_array();
        return array_shift($total);
    }

    // Create a new record
    public function create()
    {
        // Sanitize the data
        $attributes = $this->sanitizeAttributes();

        // Insert into the database
        $query = " INSERT INTO " . static::$table . " ( ";
        $query .= join(', ', array_keys($attributes));
        $query .= " ) VALUES ('";
        $query .= join("', '", array_values($attributes));
        $query .= " ') ";

        // return json_encode(['query' => $query]);

        // query results
        $result = self::$db->query($query);
        return [
            'result' =>  $result,
            'id' => self::$db->insert_id
        ];
    }

    // Update record
    public function update()
    {
        // sanitize the data
        $attributes = $this->sanitizeAttributes();

        // Iterate to add each field from the database
        $valores = [];
        foreach ($attributes as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        // SQL query
        $query = "UPDATE " . static::$table . " SET ";
        $query .=  join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        // Update BD
        $result = self::$db->query($query);
        return $result;
    }

    // Delete a record by its id
    public function delete()
    {
        $query = "DELETE FROM "  . static::$table . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $result = self::$db->query($query);
        return $result;
    }
}
