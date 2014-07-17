<?php
use PhpAmqpLib\Connection\AMQPConnection;

class queue {
	private static $instance = null;
	private $connection = null;
	private $channel = null;

	public static function instance() {
		if (self::$instance == null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		require_once __DIR__.'/libs/php-amqplib-2.4.0/vendor/autoload.php';
		$this->connection = new AMQPConnection('localhost', '5672', 'guest', 'guest', '/');
	}

	public function asynchronous_write() {
		if (!$this->connection) return;
		if ($this->channel == null) {
			$this->channel = $this->connection->channel();
		}
	}
}

ob_start('foo');
echo 'bar';

function foo($content, $mode = 5) {
	queue::instance()->asynchronous_write();
	return $content;
}
exit;