<?php include "../models/customer.php" ?> 
<?php include "../models/invoice.php" ?> 
<?php include "../models/stock.php" ?> 
<?php include "../models/line-item.php" ?> 

<?php
    class Db {
    // connection object
    private $pdo;

    // constructor creates new connection and stores it locally in $pdo
    public function __construct() {
        $host = 'localhost';
        $db   = 'test';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';
        $connString = "mysql:host=$host;dbname=$db;charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

		try {
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    // *** CUSTOMERS ***
    public function getCustomers() {
        return $pdo->query('select * from customers');

    }

    public function getCustomerById($id) {
        if ($is_null) {
            throw new Exception("No ID was provided");
        }
        $pdo->prepare('select * from customers where ');
    }

    public function addCustomer($name, $email, $phone, $address) {
        if (!validEmail($email)) {
            
        }

        $sql = "insert into customers (name, email, phone, address) values (:name, :email, :phone, :address";
        $query = $pdo->prepare($sql);

        $query->bindParam(':name', $name);
    }

    public function editCustomer() {

    }

    public function deleteCustomer() {

    }
    // *** END CUSTOMERS ***

    // *** STOCK ***
    public function getStockItems() {
        
    }

    public function getStockById() {
        
    }
    

    public function addNewStockItem() {

    }

    public function editStockItem() {

    }

    public function deleteStockItem() {

    }
    // *** END STOCK ***

    // *** INVOICE ***
    public function getInvoices() {

    }

    public function getInvoiceById($id) {
        
    }
    

    public function getInvoicesByCustomer($custId) {

    }

    public function addInvoice() {

    }

    public function editInvoice() {

    }

    public function deleteInvoice() {

    }
    // *** END INVOICE ***

    // *** LINE ITEMS ***
    public function addLineItem() {

    }

    public function deleteLineItem() {

    }
    // *** ENDLINE ITEMS ***

    // *** helpers ***
    private function validEmail($email) {
        if (preg_match('/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email) == 1) {
            return true;
        }

        return false;
    }
}


?>

