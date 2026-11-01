<?php 
session_start();
if (empty($_SESSION['cart'])) {
    header("Location: shop.php");
    exit;
}

$cart_total = 0;
foreach ($_SESSION['cart'] as $item) {
    $cart_total += $item['price'] * $item['quantity'];
}

// Tells the navbar to use the solid white background
$use_solid_nav = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout | Blume</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="page-with-nav">
    <?php include 'includes/navbar.php'; ?>

    <main class="blume-container">
        <h1 class="serif-font blume-title" style="text-align: center; margin-bottom: 48px;">Checkout</h1>
        
        <div class="grid-2">
            <!-- Shipping Form -->
            <div>
                <h2 class="serif-font blume-form-title">Shipping Details</h2>
                <form action="process_order.php" method="POST" id="checkoutForm" onsubmit="return validateForm()">
                    
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" id="full_name" name="full_name" value="<?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : ''; ?>">
                        <span class="error-message" id="nameError">Please enter your full name.</span>
                    </div>
                    
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" id="email" name="email" value="<?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : ''; ?>">
                        <span class="error-message" id="emailError">Please enter a valid email format.</span>
                    </div>
                    
                    <div class="form-group">
                        <label>Phone Number</label>
                        <!-- Restricts typing to only numbers and max 8 characters -->
                        <input type="text" id="phone" name="phone" maxlength="8" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <span class="error-message" id="phoneError">Please enter exactly 8 digits (numbers only).</span>
                    </div>
                    
                    <div class="form-group">
                        <label>Shipping Address</label>
                        <textarea id="address" name="address" rows="4"></textarea>
                        <span class="error-message" id="addressError">Please enter your address.</span>
                    </div>

                    <button type="submit" class="btn-primary" style="margin-top: 32px;">REVIEW MOCK-UP DESIGN</button>
                </form>
            </div>

            <!-- Order Summary Table -->
            <div>
                <h2 class="serif-font blume-form-title">Order Summary</h2>
                <table class="blume-checkout-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th style="text-align: center;">Qty</th>
                            <th style="text-align: right;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $item): ?>
                            <tr>
                                <td>
                                    <?php echo htmlspecialchars($item['name']); ?><br>
                                    <span style="font-size: 11px; color: #666; text-transform: uppercase; letter-spacing: 0.05em;">
                                        Size: <?php echo htmlspecialchars($item['size'] ?? 'Standard'); ?> | Color: <?php echo htmlspecialchars($item['color'] ?? 'Standard'); ?>
                                    </span>
                                </td>
                                <td style="text-align: center;"><?php echo $item['quantity']; ?></td>
                                <td style="text-align: right;">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div style="margin-top: 24px; text-align: right; font-size: 16px; font-weight: bold; letter-spacing: 0.1em;">
                    TOTAL: $<?php echo number_format($cart_total, 2); ?>
                </div>
            </div>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>

    <!-- Client-Side JavaScript Validation -->
    <script>
    function validateForm() {
        let isValid = true;
        
        const name = document.getElementById('full_name').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const address = document.getElementById('address').value.trim();

        // Reset all error messages
        document.querySelectorAll('.error-message').forEach(e => e.style.display = 'none');

        // 1. Name Validation
        if (name === "") {
            document.getElementById('nameError').style.display = 'block';
            isValid = false;
        }
        
        // 2. Strict Email Validation
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === "" || !emailPattern.test(email)) {
            document.getElementById('emailError').style.display = 'block';
            isValid = false;
        }

        // 3. Strict Phone Validation (exactly 8 digits)
        const phonePattern = /^\d{8}$/;
        if (phone === "" || !phonePattern.test(phone)) {
            document.getElementById('phoneError').style.display = 'block';
            isValid = false;
        }

        // 4. Address Validation
        if (address === "") {
            document.getElementById('addressError').style.display = 'block';
            isValid = false;
        }

        return isValid;
    }
    </script>
</body>
</html>