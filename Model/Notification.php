<?php

namespace TJ\Notifications\Model;

class Notification
{
    public $type;
    public $owner_id;
    public $message;
    public $object;
    public $object_type;

    public function __construct($type, $owner_id, $message, $object
    ) {
        $this->type = $type;
        $this->owner_id = $owner_id;
        $this->message = $message;
        $this->object = $object;
        $this->object_type = get_class($object);
    }
}
?>
