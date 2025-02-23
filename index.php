<?php include_once 'includes/header.php'; ?>

<main>
    <!-- Hero Section -->
    <section class="hero">
        <!-- Your existing hero HTML -->
    </section>

    <!-- Features Section -->
    <?php
    include_once 'config/database.php';
    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT * FROM outsource_payments";
    $stmt = $db->prepare($query);
    $stmt->execute();
    ?>

    <section class="features">
        <div class="container">
            <h2>Outsource payment collection</h2>
            <p class="subtitle">Simple and flexible access to cash flow from all of your invoices.</p>
            
            <div class="features-grid">
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <!-- Icon based on database value -->
                        </div>
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Task Manager Section -->
    <section class="task-manager">
        <!-- Your existing task manager HTML -->
    </section>

    <!-- Contact Form Section -->
    <section class="contact">
        <!-- Your existing contact form HTML -->
    </section>
</main>

<?php include_once 'includes/footer.php'; ?>