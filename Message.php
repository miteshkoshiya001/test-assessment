<?php

require_once 'User.php';

class Message {

	public static $TYPE_MANUAL = "manual";
	public static $TYPE_SYSTEM = "system";
	private $sender;
	private $receiver;
	private $text;
	private $timestamp;
	private $type;

	function __construct(array $message)
	{
		$this->text = isset($message['text']) ? $message['text'] : "";
		$this->type = isset($message['type']) ? $message['type'] : self::$TYPE_SYSTEM;
		$this->timestamp = time();
	}

	function setSender($sender) {
		$this->sender = $sender;
	}

	function setReceiver($receiver) {
		$this->receiver = $receiver;
	}

	function send() {
		switch($this->type) {
			case self::$TYPE_SYSTEM:
					if ($this->sender->getUserType() == User::$TYPE_TEACHER && $this->receiver->getUserType() == User::$TYPE_STUDENT) {
						die("Message sent or saved successfully!");
					} else {
						die("System message can only send Teacher and only to Students.");
					}
				break;
			default:
					if ($this->sender->getUserType() == User::$TYPE_TEACHER) {
						die("Message sent or saved successfully!");
					}

					if (($this->sender->getUserType() == User::$TYPE_PARENT ||
					$this->sender->getUserType() == User::$TYPE_STUDENT) && 
					$this->receiver->getUserType() == User::$TYPE_TEACHER) {
						die("Message sent or saved successfully!");
					}

					if (($this->sender->getUserType() == User::$TYPE_PARENT) && 
					$this->receiver->getUserType() == User::$TYPE_STUDENT) {
						die("Parents can't send message to students");
					}

					if (($this->sender->getUserType() == User::$TYPE_STUDENT) && 
					$this->receiver->getUserType() == User::$TYPE_PARENT) {
						die("Students can't send message to parents");
					}
					break; 
		}
	}

	function getSenderFullName() {
		return $this->sender->getFullName();
	}

	function getReceiverFullName() {
		return $this->receiver->getFullName();
	}

	function getMessage(){
		return $this->text;
	}

	function getType() {
		return $this->type;
	}

	function getTime() {
		return date("Y-m-d H:i:s", $this->timestamp);
	}
}

$senderUser = [
	'firstname' => 'John',
	'lastname' => 'Martin',
	'salutation' => 'Doe',
	'email' => 'john.doe@abc.com',
	'avatar' => 'abc.jpg',
	'user_type' => User::$TYPE_TEACHER,
];

$receiverUser = [
	'firstname' => 'Rica',
	'lastname' => 'Menon',
	'salutation' => 'Sky',
	'email' => 'john.doe@xyz.com',
	'avatar' => '',
	'user_type' => User::$TYPE_PARENT,
];

$messageData = [
	'type' => Message::$TYPE_MANUAL,
	'text' => "Dummy message"
];

// prepare sender
$sender = new User($senderUser);
// prepare receiver
$receiver = new User($receiverUser);

$message = new Message($messageData);

// set sender
$message->setSender($sender);

// set receiver
$message->setReceiver($receiver);

echo '<pre>';
print_r($message);

echo 'Get Sender Full Name: ';
print_r($message->getSenderFullName());
echo PHP_EOL;

echo 'Get Receive Full Name: ';
print_r($message->getReceiverFullName());
echo PHP_EOL;

echo 'Get Message: ';
print_r($message->getMessage());
echo PHP_EOL;

echo 'Get Message Time: ';
print_r($message->getTime());
echo PHP_EOL;

echo 'Get Message Type: ';
print_r($message->getType());
echo PHP_EOL;

echo "\n\n\n\n";
echo 'Sending message...';
print_r($message->send());
echo PHP_EOL;

?>