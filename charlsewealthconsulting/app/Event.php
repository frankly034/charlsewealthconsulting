<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class Event extends Model
{
    protected static $client;
    protected $remote_events;
    protected $new_event = false;
    
    protected $fillable = ['name_text', 'description_text', 'id_eventbrite', 'url', 'start_local', 'end_local', 'created', 'changed', 'capacity', 'status', 'is_free', 'logo_url'];

    public function image_galleries(){
        return $this->hasMany('App\ImageGallery');
    }

    // Would initialize an Event() fetched from eventbrite
    public static function initializeEvent ($event) {
        $new_event = new static();
        foreach($new_event->fillable as $field){
            if( strpos($field, '_') && $field != 'is_free'){
                if(substr($field, 0, 3) === 'id_'){
                    $new_event->$field = $event['id'];
                } else {
                    $field_array = explode('_',$field);
                    $new_event->$field = $event[$field_array[0]][$field_array[1]];
                }
            } else {
                if($field == "created" || $field == "changed"){
                    $event[$field] = strtotime($event[$field]);
                }
                $new_event->$field = $event[$field];
            }
        }
        return $new_event;
    }

    // Fetch and initialize an Event() fetched from eventbrite
    public static function fetchEvents(){
        static::$client = new Client(
            [
                'base_uri' => env('EVENTBRITE_FETCH_EVENTS_URL'),
                'headers' => [
                    'Authorization' => env('EVENTBRITE_PERSONAL_OAUTH_TOKEN'),
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json'
                ]
            ]
        );

        $request = static::$client->request('GET','');
        $response = json_decode($request->getBody(), true);
        $remote_events = $response['events'];
        $event_objects = [];
        
        foreach ($remote_events as $field => $event){
            $event_objects[] = static::initializeEvent($event);
        }
        return $event_objects;
    }

    //Saves updated events from eventbrite, ignores unchanged events
    public static function updateEvents() {
        $events = static::fetchEvents();
        foreach($events as $event){            
            if($db_event = $event->isUpdatable()){
                $event = $db_event;
            }
            if($db_event === false) continue;
            $event->save();
        }
        return true;
    }

    // Returns true for changed events, false for unchanged events and null for non-existent events
    public function isUpdatable(){
        $db_event = static::where('id_eventbrite',$this->id_eventbrite)->get()->shift();
        if($db_event){
            if ($db_event->changed != $this->changed){
                $db_event->setObjAttributes($this);
                return $db_event;
            }
            return false;
        }
        return null;
    }

    // Fills the object attributes with attributes of the object passed in
    public function setObjAttributes ($obj) {
        foreach ($this->fillable as $field){
            if($obj->$field){
                $this->$field = $obj->$field;
            }
        }
    }

}
