 <?php include "models/query-result.php" ?> 
 <?php include "../Modules/logging.php" ?> 
 <?php include "validation.php" ?> 

<?php
    define("SERVER_ERROR_MSG", "A server error occured. Reload the page and try again, or contact the administrator of this site.");

    enum TABLE: string {
        case CUSTOMERS = 'customers';
        case STOCK = 'stock';
        case INVOICES = 'invoices';
        case LINE_ITEMS = 'lineitems';
    }

    class Db {
    // connection object
    private static $instance = null;
    private $pdo;

    // error array
    private $errors = array();

    // constructor creates new connection and stores it locally in $this->pdo
    public function __construct() {
        $host = 'localhost';
        $db   = '3660_project_comp_repair';
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
            $this->pdo = new PDO($connString, $user, $pass, $options);
        } catch (PDOException $e) {
            $error_msg = $e->getMessage();
            logError($error_msg);
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Db();
        }

        return self::$instance;
    }

    // *** CUSTOMERS ***
    public function getAll($table) {
        $result = new QueryResult();

        if (!validTable($table)) {
            logError("An invalid table was passed to db->getAll: $table");
            $result->errors[] = SERVER_ERROR_MSG;
            return $result;
        }

        try {
            $result->data = $this->pdo->query('select * from ' . $table);
        }
        catch (PDOException $e) {
            logError($e->getMessage(), (int)$e->getCode());
            $result->errors[] = SERVER_ERROR_MSG;;
        }

        return $result;
    }

    public function getSingleById($table, $id) {
        $result = new QueryResult();

        if (!validTable($table)) {
            logError("An invalid table was passed to db->getSingleByID: $table");
            $result->errors[] = SERVER_ERROR_MSG;
            return $result;
        }

        if (is_null($id)) {
            logError("Can't retrieve single record from $table, no ID was provided");
            $result->errors[] = SERVER_ERROR_MSG;
            return $result;
        }
        try {
            $result->data = $this->pdo->prepare('select * from ' . $table . ' where id = :id');
            $result->data->bindParam(':id', $id);
            $result->data->execute();
        }
        catch (PDOException $e) {
            logError($e->getMessage(), (int)$e->getCode());
            $result->errors[] = SERVER_ERROR_MSG;
        }

        return $result;
    }

    public function addCustomer($name, $email, $phone, $address) {
        $result = new QueryResult();

        validateCustomer($result, $name, $email, $phone, $address);

        if (count($result->errors) == 0) {
            try {
                $sql = "insert into customers (name, email, phone, address) values (:name, :email, :phone, :address)";
                $result->data = $this->pdo->prepare($sql);
                $result->data->bindParam(':name', $name);
                $result->data->bindParam(':email', $email);
                $result->data->bindParam(':phone', $phone);
                $result->data->bindParam(':address', $address);
                $result->data->execute();
            }
            catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
                $result->errors[] = SERVER_ERROR_MSG;
            }
        }

        return $result;
    }

    public function editCustomer($id, $name, $email, $phone, $address) {
        $result = new QueryResult();

        validateCustomer($result, $name, $email, $phone, $address);

        if (count($result->errors) == 0) {
            try {
                $sql = "update customers set name = :name, email = :email, phone = :phone, address = :address where id = :id";
                $result->data = $this->pdo->prepare($sql);
                $result->data->bindParam(':name', $name);
                $result->data->bindParam(':email', $email);
                $result->data->bindParam(':phone', $phone);
                $result->data->bindParam(':address', $address);
                $result->data->bindParam(':id', $id);
                $result->data->execute();
            }
            catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
                $result->errors[] = SERVER_ERROR_MSG;
            }
        }

        return $result;
    }

    public function deleteCustomer($id) {
        $result = new QueryResult();

        try {
            $sql = "delete from customers where id = :id";
            $result->data = $this->pdo->prepare($sql);
            $result->data->bindParam(':id', $id);
            $result->data->execute();
        }
        catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
            $result->errors[] = SERVER_ERROR_MSG;
        }

        return $result;
    }
    // *** END CUSTOMERS ***

    // *** STOCK ***
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
}

?>

