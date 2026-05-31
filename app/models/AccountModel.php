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

public function hasAdmin() {
	$query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE role = 'admin'";
	$stmt = $this->conn->prepare($query);
	$stmt->execute();
	return $stmt->fetchColumn() > 0;
}
public function save($email, $password, $role = 'user') {
	if ($this->getAccountByUsername($email)) {
return false;
}
	$query = "INSERT INTO " . $this->table_name . " SET username=:username,
fullname=:fullname, password=:password, role=:role";
$stmt = $this->conn->prepare($query);
	$email = htmlspecialchars(strip_tags($email));
$fullName = '';
	// Use bcrypt with increased cost for stronger hashing
	$password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
$role = htmlspecialchars(strip_tags($role));
	$stmt->bindParam(":username", $email);
$stmt->bindParam(":fullname", $fullName);
$stmt->bindParam(":password", $password);
$stmt->bindParam(":role", $role);
return $stmt->execute();
}
}
?>