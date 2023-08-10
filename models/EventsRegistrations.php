<?php
namespace Model;

class EventsRegistrations extends ActiveRecord {
    protected static $table = 'events_registrations';
    protected static $columnsDB = ['id', 'event_id', 'registration_id'];

    public $id;
    public $event_id;
    public $registration_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->event_id = $args['event_id'] ?? '';
        $this->registration_id = $args['registration_id'] ?? '';
    }
}