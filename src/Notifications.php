<?php
namespace Notifications;

class Notifications {

    private $config;
    private static $backend;

    public function __construct($config = array()) {
        $this->config = array_merge(
                            array( 'backend' => 'localhost:6379',
                                   'queue_pre' => "notifications-queue"
                               ), $config);
        try {
            self::$backend = $this->config['backend'];
            self::setBackend(self::$backend);
        } catch (Exception $e) {
            trigger_error("Not set backend to Resque: ". $e->getMessage(), E_USER_ERROR);
        }
    }

    public static function setBackend($backend) {
        // TODO set exception if $backend == null
        return Resque::setBackend($backend);
    }

    // Send notification to queue
    // TODO discussion function name "enqueue", "send"...
    public static function enqueue($queue, $object) {
        $queue = self::_getQueueName($queue);
        $type = get_class($object);

        try {
            Resque::enqueue($queue, $type, $object);
        } catch (Exception $e) {
            trigger_error("Not enqueue data to Resque: ". $e->getMessage(), E_USER_ERROR);
        }

    }

    private static function _getQueueName($queue) {
        return $queue .$this->config['queue_pre'];
    }


}

?>
