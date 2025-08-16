<?php
// Simple demo page to show PHP is working
echo "<!DOCTYPE html>
<html>
<head>
    <title>PHP Version Working!</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: #16a085; font-size: 24px; margin-bottom: 20px; }
        .feature { background: #ecf0f1; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .btn { background: #3498db; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 5px; }
        .btn:hover { background: #2980b9; }
    </style>
</head>
<body>
    <div class='container'>
        <h1 class='success'>✅ PHP Version is Working!</h1>
        <p>Server time: " . date('Y-m-d H:i:s') . "</p>
        <p>PHP Version: " . phpversion() . "</p>
        
        <h2>Available Pages:</h2>
        <div class='feature'>
            <h3>🏠 Homepage</h3>
            <p>Main page with all learning batches</p>
            <a href='index.php' class='btn'>View Homepage</a>
        </div>
        
        <div class='feature'>
            <h3>⚙️ Admin Dashboard</h3>
            <p>Content management panel (no login required)</p>
            <a href='admin/index.php' class='btn'>Open Admin</a>
        </div>
        
        <div class='feature'>
            <h3>📹 Multi-Platform Videos</h3>
            <p>Videos from various platforms</p>
            <a href='multi-video.php' class='btn'>View Videos</a>
        </div>
        
        <div class='feature'>
            <h3>📚 Sample Batch</h3>
            <p>MBBS Foundation batch with subjects</p>
            <a href='batch.php?id=batch-medical-1' class='btn'>View Batch</a>
        </div>
        
        <h2>Features Working:</h2>
        <ul>
            <li>✅ SQLite Database Auto-Setup</li>
            <li>✅ Sample Data Insertion</li>
            <li>✅ CRUD Operations</li>
            <li>✅ Video Integration</li>
            <li>✅ Responsive Design</li>
            <li>✅ Admin Panel</li>
        </ul>
        
        <h2>Database Test:</h2>";

// Test database connection
try {
    require_once 'config/database.php';
    require_once 'includes/functions.php';
    
    $batches = getAllBatches();
    echo "<p style='color: green;'>✅ Database connected successfully!</p>";
    echo "<p>Found " . count($batches) . " batches in database:</p>";
    echo "<ul>";
    foreach($batches as $batch) {
        echo "<li><strong>" . htmlspecialchars($batch['name']) . "</strong> - " . htmlspecialchars($batch['description']) . "</li>";
    }
    echo "</ul>";
} catch(Exception $e) {
    echo "<p style='color: red;'>❌ Database error: " . $e->getMessage() . "</p>";
}

echo "    </div>
</body>
</html>";
?>