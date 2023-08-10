<?php
namespace Model;

class Event extends ActiveRecord {
    protected static $table = 'events';
    protected static $columnsDB = ['id', 'name','description', 'spots', 'category_id', 'day_id', 'time_id', 'speaker_id'];

    public $id;
    public $name;
    public $description;
    public $spots;
    public $category_id;
    public $day_id;
    public $time_id;
    public $speaker_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->description = $args['description'] ?? '';
        $this->spots = $args['spots'] ?? '';
        $this->category_id = $args['category_id'] ?? '';
        $this->day_id = $args['day_id'] ?? '';
        $this->time_id = $args['time_id'] ?? '';
        $this->speaker_id = $args['speaker_id'] ?? '';
    }

    // Validation messages for creating an event
    public function validate() {
        if(!$this->name) {
            self::$alerts['error']['name'] = 'The name is required';
        }
        if(!$this->description) {
            self::$alerts['error']['description'] = 'The description is required';
        }
        if(!$this->category_id  || !filter_var($this->category_id, FILTER_VALIDATE_INT)) {
            self::$alerts['error']['category'] = 'Choose a Category';
        }
        if(!$this->day_id  || !filter_var($this->day_id, FILTER_VALIDATE_INT)) {
            self::$alerts['error']['day'] = 'Choose the Event Day';
        }
        if(!$this->time_id  || !filter_var($this->time_id, FILTER_VALIDATE_INT)) {
            self::$alerts['error']['time'] = 'Choose the Event Time';
        }
        if(!$this->speaker_id || !filter_var($this->speaker_id, FILTER_VALIDATE_INT) ) {
            self::$alerts['error']['speaker'] = 'Select the person in charge of the event';
        }
        if(!$this->spots  || !filter_var($this->spots, FILTER_VALIDATE_INT)) {
            self::$alerts['error']['spots'] = 'Add a number of Available Places';
        }
        return self::$alerts;
    }
}

