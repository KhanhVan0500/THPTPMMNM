<?php
class AccountModel {
    private $conn;
    private $table_name = "account";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAccountByUsername($username) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :email LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getAccountById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getAccountByVerificationToken($token) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE verification_token = :token LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":token", $token);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getAccountByResetToken($token) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE reset_token = :token AND reset_token_expires_at >= NOW() LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":token", $token);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getAccountByRememberToken($token) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE remember_token = :token LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":token", $token);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function hasAdmin() {
        $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE role = 'admin'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function save($email, $password, $role = 'user', $fullname = '', $verificationToken = null) {
        if ($this->getAccountByUsername($email)) {
            return false;
        }

        $query = "INSERT INTO " . $this->table_name . " SET username = :username,
            fullname = :fullname,
            password = :password,
            role = :role,
            phone = :phone,
            address = :address,
            verification_token = :verification_token";

        $stmt = $this->conn->prepare($query);
        $email = htmlspecialchars(strip_tags($email));
        $fullname = htmlspecialchars(strip_tags($fullname));
        $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        $role = htmlspecialchars(strip_tags($role));
        $phone = null;
        $address = null;

        $stmt->bindParam(":username", $email);
        $stmt->bindParam(":fullname", $fullname);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":address", $address);
        $stmt->bindParam(":verification_token", $verificationToken);

        return $stmt->execute();
    }

    public function updateProfile($username, $fullname, $phone = null, $address = null, $avatar = null) {
        $query = "UPDATE " . $this->table_name . " SET fullname = :fullname";
        if ($avatar !== null) {
            $query .= ", avatar = :avatar";
        }
        $query .= " WHERE username = :username";

        $stmt = $this->conn->prepare($query);
        $fullname = htmlspecialchars(strip_tags($fullname));
        $stmt->bindParam(":fullname", $fullname);
        if ($avatar !== null) {
            $stmt->bindParam(":avatar", $avatar);
        }
        $stmt->bindParam(":username", $username);
        
        if (!$stmt->execute()) {
            return false;
        }

        // Try to update phone and address if columns exist
        if ($phone !== null || $address !== null) {
            try {
                $updateQuery = "UPDATE " . $this->table_name . " SET ";
                $updates = [];
                if ($phone !== null) {
                    $updates[] = "phone = :phone";
                }
                if ($address !== null) {
                    $updates[] = "address = :address";
                }
                $updateQuery .= implode(", ", $updates) . " WHERE username = :username";
                
                $stmt2 = $this->conn->prepare($updateQuery);
                if ($phone !== null) {
                    $phone = htmlspecialchars(strip_tags($phone));
                    $stmt2->bindParam(":phone", $phone);
                }
                if ($address !== null) {
                    $address = htmlspecialchars(strip_tags($address));
                    $stmt2->bindParam(":address", $address);
                }
                $stmt2->bindParam(":username", $username);
                $stmt2->execute();
            } catch (Exception $e) {
                // Columns don't exist yet, silently skip
            }
        }

        return true;
    }

    public function updatePassword($username, $password) {
        $query = "UPDATE " . $this->table_name . " SET password = :password WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":username", $username);
        return $stmt->execute();
    }

    public function setVerificationToken($username, $token) {
        $query = "UPDATE " . $this->table_name . " SET verification_token = :token WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":username", $username);
        return $stmt->execute();
    }

    public function verifyEmail($token) {
        $account = $this->getAccountByVerificationToken($token);
        if (!$account) {
            return false;
        }

        $query = "UPDATE " . $this->table_name . " SET email_verified = 1, verification_token = NULL WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $account->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function createResetToken($username, $token, $expiresAt) {
        $query = "UPDATE " . $this->table_name . " SET reset_token = :token, reset_token_expires_at = :expires WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":expires", $expiresAt);
        $stmt->bindParam(":username", $username);
        return $stmt->execute();
    }

    public function clearResetToken($username) {
        $query = "UPDATE " . $this->table_name . " SET reset_token = NULL, reset_token_expires_at = NULL WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        return $stmt->execute();
    }

    public function setRememberToken($username, $token) {
        $query = "UPDATE " . $this->table_name . " SET remember_token = :token WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":username", $username);
        return $stmt->execute();
    }

    public function clearRememberToken($username) {
        $query = "UPDATE " . $this->table_name . " SET remember_token = NULL WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        return $stmt->execute();
    }

    public function getAllUsers() {
        $query = "SELECT id, username, fullname, role, email_verified, is_locked, avatar FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        if (!$stmt->execute()) {
            return [];
        }
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $users === false ? [] : $users;
    }

    public function setLockById($id, $locked) {
        $query = "UPDATE " . $this->table_name . " SET is_locked = :locked WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":locked", $locked, PDO::PARAM_INT);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
