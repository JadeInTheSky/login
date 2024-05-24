<?php
    class Database {
        private static $instance = null;
        private $pdo;

        private function __construct() {
            $dsn = 'mysql:host=localhost;dbname=loginDB;charset=utf8';
            $username = '';
            $password = '';
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];
            $this->pdo = new PDO($dsn, $username, $password, $options);
        }

        public static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new Database();
            }
            return self::$instance;
        }

        public function getConnection() {
            return $this->pdo;
        }
    }
    #Try connecting to database
    try {#note: make better status css
        $pdo = Database::getInstance()->getConnection();
        $status_css = "database-successful";
        $status = "Database: Connected!";
        #echo "<p>Connected successfully</p>";
    } catch (PDOException $e) {
        $status_css = "database-failed";
        $status = "Database: Connection failed: " . $e->getMessage();
        #echo "Connection failed: " . $e->getMessage();
    }

    #Button handler
    if(isset($_POST['action']) && $_POST['action'] == 'button-login' && isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $result = login($username, $password);
        echo "$result";
    }
    
    if(isset($_POST['action']) && $_POST['action'] == 'button-register'){#note: add field value check
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $result = register($username, $email, $password);
        echo "$result";
    }

    #Functions
    function login($usr, $pwd) {
        try{
            $pdo = Database::getInstance()->getConnection();
            $query = $pdo->prepare("SELECT username, password_hash, salt, lastlogin from users WHERE username = :username");
            $query->bindParam(':username', $usr, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) == 0){
                return "Username or password incorrect. please try again.";
            } else {
                $row = $result[0];

                if ($row['password_hash'] == $pwd){
                    $lastlogin = $row['lastlogin'];
                    $query = $pdo->prepare("UPDATE users SET lastlogin = NOW() WHERE username = :username");
                    $query->bindParam(":username", $usr, PDO::PARAM_STR);
                    $query->execute();
                    return "Successfully logged in as '$usr', last login was $lastlogin";
                } else {
                    return "Username or password incorrect. please try again.";
                }
            }
        } catch (PDOException $e) {
            return "Failed: " . $e->getMessage();
        }
        
    }

    function register($usr, $email, $pwd) {#note: add email format verification
        $chk = accCheck($usr, $email, 2);
        $pdo = Database::getInstance()->getConnection();
        if ($chk == false){
            $salt = bin2hex(random_bytes(16));
            $query = $pdo->prepare("INSERT INTO users (username, password_hash, salt, email, accountType, registered, lastlogin) VALUES (:username, :password_hash, :salt, :email, 'user', NOW(), NOW());");
            $query->bindParam(":username", $usr, PDO::PARAM_STR);
            $query->bindParam(":password_hash", $pwd, PDO::PARAM_STR);
            $query->bindParam(":email", $email, PDO::PARAM_STR);
            $query->bindParam(":salt", $salt, PDO::PARAM_STR);
            $query->execute();

            if (accCheck($usr, $email, 1) == true){
                return "account has successfully been created. you can now login";
            } else {
                return "an error occured. please try again.";
            }
        }
    }

    function accCheck($usr, $email, $type) {
        $pdo = Database::getInstance()->getConnection();
        #checks if user already exists (username & email)
        $query = $pdo->prepare("SELECT username, email FROM users WHERE username = :username or email = :email");
        $query->bindParam(":username", $usr, PDO::PARAM_STR);
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) == 0){
            return false;
        } elseif (count($result) != 0 and $type == 2) { #
            $row = $result[0];
            if ($row['username'] == $usr) {
                echo "username '$usr' is already in use. please choose a different username.";
            } elseif ($row['email'] == $email) {
                echo "email '$email' is already in use. please choose a different email.";
            }
        } else {
            return true;
        }
    }

    function genSalt($length = 10) {
        return bin2hex(random_bytes($length));
    }
?>