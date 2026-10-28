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
    public static function querySQL($query, $params = [])
    {
        // Query the database.
        $result = self::$db->execute_query($query, $params);

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

    // Null is stored as an empty string, as the escaping code before prepared statements did
    protected function valuesForDB()
    {
        return array_map(fn($value) => $value ?? '', $this->attributes());
    }

    // Column names and sort directions cannot be placeholders, so they are checked against known values
    protected static function column($column)
    {
        if (!in_array($column, static::$columnsDB, true)) {
            throw new \InvalidArgumentException("Unknown column: $column");
        }
        return $column;
    }

    protected static function direction($order)
    {
        $order = strtoupper($order);
        if ($order !== 'ASC' && $order !== 'DESC') {
            throw new \InvalidArgumentException("Invalid sort direction: $order");
        }
        return $order;
    }

    // Build "col1 = ? AND col2 = ?" for an array of column => value
    protected static function conditions($array)
    {
        $conditions = [];
        foreach (array_keys($array) as $column) {
            $conditions[] = static::column($column) . " = ?";
        }
        return join(' AND ', $conditions);
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
        $query = "SELECT * FROM " . static::$table . " ORDER BY id " . static::direction($order);
        $result = self::querySQL($query);
        return $result;
    }

    // Search for a record by its ID
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$table  . " WHERE id = ?";
        $result = self::querySQL($query, [$id]);
        return array_shift($result);
    }

    // Get records with a limit
    public static function get($limit)
    {
        $query = "SELECT * FROM " . static::$table . " ORDER BY id DESC" . " LIMIT " . (int) $limit;
        $result = self::querySQL($query);
        return $result;
    }

    // Paginate Records
    public static function paginate($per_page, $offset)
    {
        $query = "SELECT * FROM " . static::$table . " ORDER BY id DESC LIMIT " . (int) $per_page . " OFFSET " . (int) $offset;
        $result = self::querySQL($query);
        return $result;
    }

    // Find a record by column and value
    public static function where($column, $value)
    {
        $query = "SELECT * FROM " . static::$table  . " WHERE " . static::column($column) . " = ?";
        $result = self::querySQL($query, [$value]);
        return array_shift($result);
    }

    // Return the records in a specific order
    public static function order($column, $order)
    {
        $query = "SELECT * FROM " . static::$table  . " ORDER BY " . static::column($column) . " " . static::direction($order);
        $result = self::querySQL($query);
        return $result;
    }

    // Return the records in a specific order and limit
    public static function orderLimit($column, $order, $limit)
    {
        $query = "SELECT * FROM " . static::$table  . " ORDER BY " . static::column($column) . " " . static::direction($order) . " LIMIT " . (int) $limit;
        $result = self::querySQL($query);
        return $result;
    }

    // Find a record by Multiple options
    public static function whereArray($array = [])
    {
        $query = "SELECT * FROM " . static::$table  . " WHERE " . static::conditions($array);
        $result = self::querySQL($query, array_values($array));
        return $result;
    }

    // Get Total Records
    public static function total($column = '', $value = '')
    {
        $query = "SELECT COUNT(*) FROM " . static::$table;
        $params = [];

        if ($column) {
            $query .= " WHERE " . static::column($column) . " = ?";
            $params[] = $value;
        }
        $result = self::$db->execute_query($query, $params);
        $total = $result->fetch_array();

        return array_shift($total);
    }

    // Get Total Records with Array Where
    public static function totalArray($array = [])
    {
        $query = "SELECT COUNT(*) FROM " . static::$table . " WHERE " . static::conditions($array);
        $result = self::$db->execute_query($query, array_values($array));
        $total = $result->fetch_array();
        return array_shift($total);
    }

    // Create a new record
    public function create()
    {
        $attributes = $this->valuesForDB();

        // Insert into the database
        $query = " INSERT INTO " . static::$table . " ( ";
        $query .= join(', ', array_keys($attributes));
        $query .= " ) VALUES (";
        $query .= join(', ', array_fill(0, count($attributes), '?'));
        $query .= ") ";

        // query results
        $result = self::$db->execute_query($query, array_values($attributes));
        return [
            'result' =>  $result,
            'id' => self::$db->insert_id
        ];
    }

    // Update record
    public function update()
    {
        $attributes = $this->valuesForDB();

        // Iterate to add each field from the database
        $valores = [];
        foreach (array_keys($attributes) as $key) {
            $valores[] = "{$key} = ?";
        }

        // SQL query
        $query = "UPDATE " . static::$table . " SET ";
        $query .=  join(', ', $valores);
        $query .= " WHERE id = ? ";
        $query .= " LIMIT 1 ";

        // Update BD
        $result = self::$db->execute_query($query, [...array_values($attributes), $this->id]);
        return $result;
    }

    // Delete a record by its id
    public function delete()
    {
        $query = "DELETE FROM "  . static::$table . " WHERE id = ? LIMIT 1";
        $result = self::$db->execute_query($query, [$this->id]);
        return $result;
    }
}
