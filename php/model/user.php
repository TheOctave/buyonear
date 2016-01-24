<?php
class User {
	public function getUsers(){
		$query = "SELECT * FROM users";
		$users = getData($query, "all");
		return $users;
	}

	public function getUser($id){
		$query = "SELECT * FROM users WHERE id = $id";
		$user = getData($query, "one");
		return $user;
	}

	public function createUser($oauth_provider, $oauth_uid, $username, $email){
		$query = "INSERT INTO users (oauth_provider, oauth_uid, username, email ) VALUES (\"$oauth_provider\", \"$oauth_uid\", \"$username\", \"$email\")";
		$user = productData($query, "insert");
		return $user;
	}

	public function updateUser($id, $oauth_provider, $oauth_uid, $username, $email){
		$query = "UPDATE users SET oauth_provider = \"$oauth_provider\", oauth_uid = \"$oauth_uid\", username = \"$username\",  email = \"$email\" WHERE id = $id";
		$rows = productData($query, "update");
		return $rows;
	}
	public function deleteUser($id){
		$query = "DELETE users WHERE id = $id";
		$rows = productData($query, "delete");
		return $rows;
	}
}
?>