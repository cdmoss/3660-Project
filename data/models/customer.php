class Customer {
    public $id
    public $name
    public $email
    public $phone
    public $address

    public function __construct($name, $email, $phone, $address) {
        $this->$name = $name;
        $this->$email = $email;
        $this->$phone = $phone;
        $this->$address = $address;
    }
}