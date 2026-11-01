<?php
session_start();
// Connect to the database to securely get prices
require_once 'includes/db.php'; 

// Handle ADD TO CART
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    $size = $_POST['size'] ?? 'Standard'; 
    $color = $_POST['color'] ?? 'Standard'; 

    // Fetch secure product details directly from the database
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if this exact product + size + color combination is already in the cart
        $item_exists = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product_id && $item['size'] == $size && $item['color'] == $color) {
                $item['quantity'] += $quantity; 
                $item_exists = true;
                break;
            }
        }

        // If it's a new combination, add it to the cart array
        if (!$item_exists) {
            $_SESSION['cart'][] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image_url'],
                'quantity' => $quantity,
                'size' => $size,
                'color' => $color
            ];
        }
    }

    // Send the user seamlessly back to the page they were just on
    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'shop.php'));
    exit;
}

// 3. Handle item quantity updates and removal
if (isset($_POST['action']) && isset($_POST['cart_key'])) {
    $action = $_POST['action'];
    $cart_key = $_POST['cart_key']; // Use the exact array index
    
    if (isset($_SESSION['cart'][$cart_key])) {
        if ($action == 'increase') {
            $_SESSION['cart'][$cart_key]['quantity'] += 1;
        } elseif ($action == 'decrease') {
            $_SESSION['cart'][$cart_key]['quantity'] -= 1;
            if ($_SESSION['cart'][$cart_key]['quantity'] <= 0) {
                unset($_SESSION['cart'][$cart_key]);
            }
        } elseif ($action == 'remove') {
            unset($_SESSION['cart'][$cart_key]);
        }
    }
    
    // Re-index the array so there are no empty gaps
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    $_SESSION['keep_cart_open'] = true; 
    
    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'shop.php'));
    exit;
}


// Fallback redirect (Fixes the blank screen if accessed directly)
header("Location: shop.php");
exit;
?>