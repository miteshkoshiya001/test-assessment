
<?php

class User
{
    public static $TYPE_STUDENT = "student";
    public static $TYPE_TEACHER = "teacher";
    public static $TYPE_PARENT = "parent";

    private $id;
    private $firstName;
    private $salutation;
    private $lastName;
    private $email;
    private $avatar;
    private $userType;

    public function __construct(array $user)
    {
		$this->firstName = isset($user['firstname']) ? $user['firstname'] : "";
		$this->lastName = isset($user['lastname']) ? $user['lastname'] : "";
		$this->email = isset($user['email']) ? $user['email'] : "";
		$this->salutation = isset($user['salutation']) ? $user['salutation'] : "";
		$this->avatar = isset($user['avatar']) && !empty($user['avatar']) ? "/assets/images/".$user['avatar'] : "/assets/images/default-avatar.png";
		$this->userType = isset($user['user_type']) ? $user['user_type'] : self::$TYPE_STUDENT;
		$this->id = rand(100, 999);
    }

    function getFullName()
    {
        if ($this->userType == self::$TYPE_STUDENT) {
            return $this->firstName.' '.$this->lastName;
        }
        return $this->salutation.' '.$this->firstName.' '.$this->lastName;
    }

	public function getUserTypeList() {
		return [
			self::$TYPE_TEACHER => 'Teacher',
			self::$TYPE_STUDENT => 'Student',
			self::$TYPE_PARENT => 'Parent'
		];
	}

	function getUserId() {
		return $this->id;
	}

	function getEmail() {
		return $this->email;
	}

	function saveUser () {
		if ($this->validate()) {
			die("Hurray!! User saved successfully.");
		}
	}

	public function getUserType() {
		return $this->userType;
	}

	private function validate () {
		if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
			die("Invalid email format");
		}
		if (strpos($this->avatar, ".jpg") === false) {
			die("Invalid profile photo");
		}
		return true;
	}
}

// Demo user 
/* $data = [
	'firstname' => 'John',
	'lastname' => 'Martin',
	'salutation' => 'Doe',
	'email' => 'john.doe@abc.com',
	'avatar' => 'abc.jpg',
	'user_type' => User::$TYPE_STUDENT,
];
$user = new User($data);
echo '<pre>';
print_r($user);
echo "Get full name : ".$user->getFullName();
echo PHP_EOL;
echo "Get user id : ".$user->getUserId();
echo PHP_EOL;
echo "Get email : ".$user->getEmail();
echo PHP_EOL;
echo "Save user : ".PHP_EOL;
$user->saveUser(); */