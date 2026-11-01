<?php 
require_once 'includes/db.php'; 

// Fetch the 4 most recently added products for the "Just Arrived" section
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 4");
$recent_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// This tells the navbar to use the solid white background
$use_solid_nav = true; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blume | Official Store</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="page-with-nav">

    <?php include 'includes/navbar.php'; ?>

    <header class="blume-hero">
        <video autoplay loop muted playsinline>
            <source src="assets/hero.mp4" type="video/mp4">
        </video>
        <div class="blume-hero-overlay"></div>
        <div class="blume-hero-content">
            <h1 class="serif-font" style="font-size: 48px; margin-bottom: 24px; letter-spacing: 0.05em; margin-top: 0;">In Full Blume</h1>
            <a href="shop.php" style="border: 1px solid white; padding: 12px 32px; font-size: 12px; letter-spacing: 0.1em; text-decoration: none; color: white; transition: 0.3s;" onmouseover="this.style.backgroundColor='white'; this.style.color='black';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='white';">DISCOVER</a>
        </div>
    </header>

    <main class="blume-container">
        <h2 class="serif-font" style="font-size: 30px; margin-bottom: 32px; font-style: italic; font-weight: normal; margin-top: 0;">Just Arrived</h2>
        
        <div class="blume-shop-grid">
            <?php foreach($recent_products as $product): ?>
                <a href="product.php?id=<?php echo $product['id']; ?>" class="blume-product-link">
                    <div class="blume-image-box">
                        <?php $has_secondary = !empty($product['image_url_2']); ?>
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($product['name']); ?>"
                             class="blume-img-primary <?php echo $has_secondary ? 'has-hover-img' : 'no-hover-img'; ?>">
                        
                        <?php if($has_secondary): ?>
                            <img src="<?php echo htmlspecialchars($product['image_url_2']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?> Alternate"
                                 class="blume-img-secondary">
                        <?php endif; ?>
                    </div>
                    <div class="blume-product-info">
                        <span class="title"><?php echo htmlspecialchars($product['name']); ?></span>
                        <span class="price">$<?php echo htmlspecialchars($product['price']); ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>