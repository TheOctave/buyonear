<?php
class Product {
	public static function getProducts(){
		$query = "SELECT * FROM product";
		$products = getData($query, "all");
		return $products;
	}
	public static function getProduct($id_product){
		$query = "SELECT * FROM product WHERE product_id = $id_product";
		$product = getData($query, "one");
		return $product;
	}

	public static function createProduct($product_name, $seller, $photo, $price, $docid){
		$query = "INSERT INTO product (product_name, seller, photo, price, docid) VALUES (\"$product_name\", \"$seller\", \"$photo\", \"$price\", \"$docid\" )";
		$product = postData($query, "insert");
		return $product;
	}

	public static function updateProduct($product_id, $product_name, $seller, $photo){
		$query = "UPDATE product SET product_name = \"$product_name\", seller = \"$seller\", photo = \"$photo\" WHERE product_id = $product_id";
		$rows = postData($query, "update");
		return $rows;
	}
	public static function deleteProduct($product_id){
		$query = "DELETE product WHERE product_id = $product_id";
		$rows = postData($query, "delete");
		return $rows;
	}
}
?>
