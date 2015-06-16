<?php

namespace TJ\Notifications\Service;

class NotificationService
{
    private $config;

    public function __construct($config = array())
    {
        $this->config = array_merge(
            array(
                'backend' => 'localhost:6379',
                'queue_pre' => "notifications.queue"
            ),
            $config
        );

        try {
            $this->setBackend($this->config['backend']);
        } catch (Exception $e) {
            trigger_error("Not set backend to Resque: ". $e->getMessage(), E_USER_ERROR);
        }
    }

    public function setBackend($backend)
    {
        // TODO set exception if $backend == null
        return Resque::setBackend($backend);
    }

    // Send notification to queue
    // TODO discussion function name "enqueue", "send"...
    public function enqueue($queue, $object)
    {
        $queue = $this->_getQueueName($queue);
        $type = get_class($object);

        try {
            Resque::enqueue($queue, $type, $object);
        } catch (Exception $e) {
            trigger_error("Not enqueue data to Resque: ". $e->getMessage(), E_USER_ERROR);
        }

    }

    private function _getQueueName($queue)
    {
        return $queue .$this->config['queue_pre'];
    }
}

?>
