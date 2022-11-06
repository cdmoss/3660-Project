<?php include "../models/customer.php" ?> 
<?php include "../models/invoice.php" ?> 
<?php include "../models/stock.php" ?> 
<?php include "../models/line-item.php" ?> 
<?php include "../models/query-result.php" ?> 

<?php
    class Db {
    // connection object
    private $pdo;

    // error array
    private $errors;

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
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
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
        $result = new QueryResult();

        validateCustomer($result, $name, $email, $phone, $address);

        if (count($result->errors == 0)) {
            try {
                $sql = "insert into customers (name, email, phone, address) values (:name, :email, :phone, :address";
                $query = $pdo->prepare($sql);
                $query->bindParam(':name', $name);
                $query->bindParam(':email', $email);
                $query->bindParam(':phone', $phone);
                $query->bindParam(':address', $address);
                $query->execute();
                $result->data = $query;
            }
            catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
                $result->errors[] = "A server error occured. Reload the page and try again, or contact the administrator of this site.";
            }
        }

        return $result;
    }

    public function editCustomer($id, $name, $email, $phone, $address) {
        $result = new QueryResult();

        validateCustomer($result, $name, $email, $phone, $address);

        if (count($result->errors == 0)) {
            try {
                $sql = "update customers set name = :name, email = :email, phone = :phone, address = :address where id = :id";
                $query = $pdo->prepare($sql);
                $query->bindParam(':name', $name);
                $query->bindParam(':email', $email);
                $query->bindParam(':phone', $phone);
                $query->bindParam(':address', $address);
                $query->bindParam(':id', $id);
                $query->execute();
            }
            catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
                $result->errors[] = "A server error occured. Reload the page and try again, or contact the administrator of this site.";
            }
        }

        return $result;
    }

    public function deleteCustomer($id) {
        $result = new QueryResult();

        try {
            $sql = "delete from customers id = :id";
            $query = $pdo->prepare($sql);
            $query->bindParam(':id', $id);
            $query->execute();
        }
        catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
            $result->errors[] = "A server error occured. Reload the page and try again, or contact the administrator of this site.";
        }

        return $result;
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
    private function validateCustomer(&$result, $name, $email, $phone, $address) {
        

        if (is_null($name)) {
            $result->errors[] = 'A name was not provided.';
        }

        if (!validEmail($email) || is_null($email)) {
            $result->errors[] = 'A valid email was not provided.';
        }

        if (!validPhone($phone) || is_null($phone)) {
            $result->errors[] = 'A valid phone number was not provided.';
        }

        if (strlen($address) > 100) {
            $result->errors[] = 'The provided address exceeded maximum length.';
        }
    }

    private function validEmail($email) {
        if (preg_match('/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email) == 1) {
            return true;
        }
        
        return false;
    }

    private function validPhone($phone) {
        if (preg_match('^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$', $phone) == 1) {
            return true;
        }

        return false;
    }
}


?>

