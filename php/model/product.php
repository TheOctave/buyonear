<?php
class Product {
	public function getProducts(){
		$query = "SELECT * FROM product";
		$products = getData($query, "all");
		return $products;
	}
	public function getProduct($id_product){
		$query = "SELECT * FROM product WHERE product_id = $id_product";
		$product = getData($query, "one");
		return $product;
	}

	public function createProduct($product_name, $seller, $photo){
		$query = "INSERT INTO product (product_name, seller, photo) VALUES (\"$product_name\", \"$seller\", \"$photo\")";
		$product = productData($query, "insert");
		return $product;
	}

	public function updateProduct($product_id, $product_name, $seller, $photo){
		$query = "UPDATE product SET product_name = \"$product_name\", seller = \"$seller\", photo = \"$photo\" WHERE product_id = $product_id";
		$rows = productData($query, "update");
		return $rows;
	}
	public function deleteProduct($product_id){
		$query = "DELETE product WHERE product_id = $product_id";
		$rows = productData($query, "delete");
		return $rows;
	}
}
?>