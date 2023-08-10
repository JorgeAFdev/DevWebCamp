<?php
namespace Model;

class Package extends ActiveRecord {
    protected static $table = 'packages';
    protected static $columnsDB = ['id', 'name'];

    public $id;
    public $name;
}