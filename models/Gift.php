<?php
namespace Model;

class Gift extends ActiveRecord {
    protected static $table = 'gifts';
    protected static $columnsDB = ['id', 'name',];

    public $id;
    public $name;
}