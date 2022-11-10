<?php include "models/query-result.php" ?> 
<?php include "../Modules/logging.php" ?> 

<?php
    define("SERVER_ERROR_MSG", "A server error occured. Reload the page and try again, or contact the administrator of this site.");

    enum TABLE: string {
        case CUSTOMERS = 'customers';
        case STOCK = 'stock';
        case INVOICES = 'invoices';
        case LINE_ITEMS = 'lineitems';
    }

    class Db {

    // *** PRIVATE MEMBERS ***
    private static $instance = null;
    private $pdo;
    private $errors = array();

    private function validTable($table) {
        return TABLE::tryFrom($table) != null;
    }

    private function validEmail($email) {
        return preg_match('/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email) == 1;
    }

    private function validPhone($phone) {
        return preg_match('/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/', $phone) == 1;
    }

    private function validateCustomer(&$result, $name, $email, $phone, $address) {
        if (is_null($name)) {
            $result->errors[] = 'A name was not provided.';
        }

        if (!Db::validEmail($email) || is_null($email)) {
            $result->errors[] = 'A valid email was not provided.';
        }

        if (!Db::validPhone($phone) || is_null($phone)) {
            $result->errors[] = 'A valid phone number was not provided.';
        }

        if (strlen($address) > 100) {
            $result->errors[] = 'The provided address exceeded maximum length.';
        }
    }

    private function validateStock(&$result, $name, $current_price, $qty) {
        if (is_null($name)) {
            $result->errors[] = 'A name was not provided.';
        }

        if (is_null($current_price) || !is_numeric($current_price) || $current_price < 0) {
            $result->errors[] = 'A valid price was not provided.';
        }

        if (is_null($qty) || !is_numeric($qty) || $qty < 0) {
            $result->errors[] = 'A valid quantity was not provided.';
        }
    }

    private function existingRecordInTableHasId($table, $id) {
        if (!Db::validTable($table)) {
            return false;
        }

        $validateCustomerQuery = $this->pdo->prepare('select * from ' . $table . ' where id = :id');
        $validateCustomerQuery->bindParam(':id', $id);
        $validateCustomerQuery->execute();

        return $validateCustomerQuery->rowCount() > 0;
    }

    private function validateInvoice(&$result, $label, $customerId) {
        // validate label
        if (is_null($label)) {
            $result->errors[] = 'A valid label was not provided.';
        }

        // validate customer id
        if (is_null($customerId)) {
            $result->errors[] = 'A valid customer id was not provided.';
        }
        // validate that given customer exists
        elseif (!Db::existingRecordInTableHasId("customers", $customerId)) { 
            $result->errors[] = 'There are no customers with that id.';
        }
    }

    private function validateLineItem(&$result, $stockId, $invoiceId, $qty, $price) {
        if (!Db::existingRecordInTableHasId("stock", $stockId)) {
            $result->errors[] = 'There are no stock items with that id.';
        }

        if (!Db::existingRecordInTableHasId("invoices", $invoiceId)) {
            $result->errors[] = 'There are no invoices with that id.';
        }

        if (!is_null($qty) || !is_int($qty) || $qty < 1) {
            $result->errors[] = 'A valid quantity was not provided.';
        }

        if (is_null($price) || !is_float($price) || $price < 0) {
            $result->errors[] = 'A valid price was not provided.';
        }
    }

    // *** END PRIVATE MEMBERS ***

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

    // *** GENERIC OPERATIONS ***
    public function getAll($table) {
        $result = new QueryResult();

        if (!$this->validTable($table)) {
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

        if (!$this->validTable($table)) {
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

    public function delete($table, $id) {
        $result = new QueryResult();

        if (!$this->validTable($table)) {
            logError("An invalid table was passed to db->getSingleByID: $table");
            $result->errors[] = SERVER_ERROR_MSG;
            return $result;
        }

        if (is_null($id)) {
            logError("Can't delete from $table, no ID was provided");
            $result->errors[] = SERVER_ERROR_MSG;
            return $result;
        }

        try {
            $sql = "delete from " . $table . "where id = :id";
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
    // *** END GENERIC OPERATIONS ***

    // *** CUSTOMERS ***
    public function addCustomer($name, $email, $phone, $address) {
        $result = new QueryResult();

        $this->validateCustomer($result, $name, $email, $phone, $address);

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

        $this->validateCustomer($result, $name, $email, $phone, $address);

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
    public function addNewStockItem($name, $current_price, $qty) {
        $result = new QueryResult();

        $this->validateStock($result, $name, $current_price, $qty);

        if (count($result->errors) == 0) {
            try {
                $sql = "insert into stock (name, current_price, qty) values (:name, :current_price, :qty)";
                $result->data = $this->pdo->prepare($sql);
                $result->data->bindParam(':name', $name);
                $result->data->bindParam(':current_price', $current_price);
                $result->data->bindParam(':qty', $qty);
                $result->data->execute();
            }
            catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
                $result->errors[] = SERVER_ERROR_MSG;
            }
        }

        return $result;
    }

    public function editStockItem($id, $name, $current_price, $qty) {
        $result = new QueryResult();


        $this->validateStock($result, $name, $current_price, $qty);

        if (count($result->errors) == 0) {
            try {
                $sql = "update stock set name = :name, current_price = :current_price, qty = :qty where id = :id";
                $result->data = $this->pdo->prepare($sql);
                $result->data->bindParam(':name', $name);
                $result->data->bindParam(':current_price', $current_price);
                $result->data->bindParam(':qty', $qty);
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

    public function deleteStockItem($id) {
        $result = new QueryResult();

        try {
            $sql = "delete from stock where id = :id";
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
    // *** END STOCK ***

    // *** INVOICE **
    public function getInvoicesByCustomer($customerId) {
        $result = new QueryResult();

        if (count($result->errors) == 0) {
            try {
                $sql = "select * from invoices where customer_id = :customer_id";
                $result->data = $this->pdo->prepare($sql);
                $result->data->bindParam(':customer_id', $customerId);
                $result->data->execute();
            }
            catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
                $result->errors[] = SERVER_ERROR_MSG;
            }
        }

        return $result;
    }

    public function addInvoice($label, $customerId, $cleared) {
        $result = new QueryResult();

        $this->validateInvoice($result, $label, $customerId);

        if (count($result->errors) == 0) {
            try {
                $sql = "insert into invoices (label, customer_id, cleared) values (:label, :customer_id, :cleared)";
                $result->data = $this->pdo->prepare($sql);
                $result->data->bindParam(':label', $label);
                $result->data->bindParam(':customer_id', $customerId);
                $_cleared = isset($cleared) ? $cleared : false;
                $result->data->bindParam(':cleared', $cleared);
                
                $result->data->execute();
            }
            catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
                $result->errors[] = SERVER_ERROR_MSG;
            }
        }

        return $result;
    }

    public function editInvoice($id, $label, $cleared, $customerId) {
        $result = new QueryResult();

        $this->validateInvoice($result, $label, $customerId);

        if (count($result->errors) == 0) {
            try {
                $sql = "update invoices set label = :label, customer_id = :customer_id, cleared = :cleared where id = :id";
                $result->data = $this->pdo->prepare($sql); 
                $result->data->bindParam(':label', $label);
                $result->data->bindParam(':customer_id', $customerId);
                $result->data->bindParam(':cleared', $cleared);
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

    public function deleteInvoice($id) {
        $result = new QueryResult();

        try {
            $sql = "delete from invoices where id = :id";
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
    // *** END INVOICE ***

    // *** LINE ITEMS ***
    public function addLineItem($stockId, $invoiceId, $label, $qty, $price) {
        $result = new QueryResult();

        $this->validateLineItem($stockId, $invoiceId, $label,  $qty, $price);

        if (count($result->errors) == 0) {
            try {
                $label = is_null($label) ? '' : $label;
                $sql = "insert into lineitems (stock_id, invoice_id, label, qty, price) values (:stock_id, :invoice_id, :label, :qty, :price)";
                $result->data = $this->pdo->prepare($sql);
                $result->data->bindParam(':stock_id', $stockId);
                $result->data->bindParam(':invoice_id', $invoiceId);
                $result->data->bindParam(':label', $label);
                $result->data->bindParam(':qty', $qty);
                $result->data->bindParam(':price', $price);
                $result->data->execute();
            }
            catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
                $result->errors[] = SERVER_ERROR_MSG;
            }
        }

        return $result;
    }

    public function deleteLineItem($stockId, $invoiceId) {
        $result = new QueryResult();
        if (is_null($stockId)) {
            $result->errors[] = "A valid stock id was not provided";
        }
        if (is_null($invoiceId)) {
            $result->errors[] = "A valid invoice id was not provided";
        }

        if (count($result->errors) == 0) {
            try {
                $sql = "delete from lineitems where stock_id = :stock_id and invoice_id = :invoice_id";
                $result->data = $this->pdo->prepare($sql);
                $result->data->bindParam(':stock_id', $stockId);
                $result->data->bindParam(':invoice_id', $invoiceId);
                $result->data->execute();
            }
            catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
                $result->errors[] = SERVER_ERROR_MSG;
            }
        }

    }
    // *** ENDLINE ITEMS ***
}

?>

