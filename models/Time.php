<?php
namespace Model;

class Time extends ActiveRecord {
    protected static $table = 'times';
    protected static $columnsDB = ['id', 'time'];

    public $id;
    public $time;
}