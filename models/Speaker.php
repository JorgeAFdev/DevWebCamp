<?php
namespace Model;

class Speaker extends ActiveRecord {
    protected static $table = 'speakers';
    protected static $columnsDB = ['id', 'name','surname', 'city', 'country', 'image', 'tags', 'socials'];

    public $id;
    public $name;
    public $surname;
    public $city;
    public $country;
    public $image;
    public $tags;
    public $socials;
    

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->surname = $args['surname'] ?? '';
        $this->city = $args['city'] ?? '';
        $this->country = $args['country'] ?? '';
        $this->image = $args['image'] ?? '';
        $this->tags = $args['tags'] ?? '';
        $this->socials = '';
    }

    public function validate() {
        if(!$this->name) {
            self::$alerts['error']['name'] = 'Speaker Name is required';
        }
        if(!$this->surname) {
            self::$alerts['error']['surname'] = 'Speaker Surname is required';
        }
        if(!$this->city) {
            self::$alerts['error']['city'] = 'The city field is required';
        }
        if(!$this->country) {
            self::$alerts['error']['country'] = 'The Country Field is required';
        }
        if(!$this->image) {
            self::$alerts['error']['image'] = 'Image is required';
        }
        if(!$this->tags) {
            self::$alerts['error']['tags'] = 'The areas field is required';
        }
        return self::$alerts;
    }
}