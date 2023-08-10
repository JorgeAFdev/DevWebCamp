<?php
namespace Model;

class EventSchedule extends ActiveRecord {
    protected static $table = 'events';
    protected static $columnsDB = ['id', 'category_id', 'day_id', 'time_id'];

    public $id;
    public $category_id;
    public $day_id;
    public $time_id;
}