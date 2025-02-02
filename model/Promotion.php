<?php
class PromotionModel {
    private $db;

    public function __construct() {
        $this->db = new mysqli('localhost', 'root', '', 'ecommerce');
    }

    public function insertNewDiscountForProduct($name) {
        // Fetch product_id from the products table
        $query = "SELECT product_id FROM products WHERE name = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $product_id = $row['product_id'];
            $discount_percentage = 0; // Default discount
            $start_date = date('Y-m-d'); // Set default start date
            $end_date = date('Y-m-d', strtotime('+7 days')); // Example: 7-day promotion

            // Insert into promotions table with valid columns
            $query2 = "INSERT INTO promotions (product_id, discount_percentage, start_date, end_date) 
                       VALUES (?, ?, ?, ?)";
            $stmt2 = $this->db->prepare($query2);
            $stmt2->bind_param("iiss", $product_id, $discount_percentage, $start_date, $end_date);
            $stmt2->execute();
        } else {
            throw new Exception("Product not found.");
        }
    }

}
?>
