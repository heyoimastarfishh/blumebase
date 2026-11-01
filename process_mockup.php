<?php
require_once 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'])) {
    $order_id = (int)$_POST['order_id'];
    $changes = htmlspecialchars(trim($_POST['design_changes'] ?? 'No changes'));

    // Update the order with the final customer changes
    $stmt = $pdo->prepare("UPDATE orders SET design_changes = ? WHERE id = ?");
    $stmt->execute([$changes, $order_id]);

    // Send final local server email update
    $email_body = "Order #$order_id finalized. Design changes noted: $changes";
    file_put_contents("email_logs.txt", "Subject: Order Finalized\nBody: $email_body\n\n", FILE_APPEND);

    header("Location: order_success.php");
    exit;
}
?>