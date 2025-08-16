<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Get all batches for homepage
$batches = getAllBatches();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn Here Free - Educational Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .grid-medium { grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <i class="fas fa-graduation-cap text-blue-600 text-2xl mr-3"></i>
                    <h1 class="text-xl font-semibold text-gray-900">Learn Here Free</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Navigation Links -->
                    <nav class="hidden md:flex items-center space-x-6">
                        <a href="admin/" class="flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors">
                            <i class="fas fa-cog text-sm"></i>
                            <span class="text-sm font-medium">Content Management</span>
                        </a>
                        <a href="multi-video.php" class="flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors">
                            <i class="fas fa-database text-sm"></i>
                            <span class="text-sm font-medium">Multi-Platform Videos</span>
                        </a>
                    </nav>
                    
                    <div class="flex items-center space-x-3">
                        <div class="text-sm text-gray-600">
                            <span>Guest User</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Welcome back!</h2>
                    <p class="text-gray-600">Choose your learning path</p>
                </div>
            </div>
        </div>

        <!-- Video Batches Section -->
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Video Learning Batches</h3>
        </div>

        <?php if (!empty($batches)): ?>
            <div class="grid grid-medium gap-6">
                <?php foreach ($batches as $batch): ?>
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 card-hover">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                        <?php echo htmlspecialchars($batch['name']); ?>
                                    </h3>
                                    <?php if (!empty($batch['description'])): ?>
                                        <p class="text-gray-600 text-sm mb-3">
                                            <?php echo htmlspecialchars($batch['description']); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                                <div class="ml-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Active
                                    </span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <span class="flex items-center">
                                        <i class="fas fa-book mr-1"></i>
                                        <?php echo getSubjectCount($batch['id']); ?> Subjects
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-play-circle mr-1"></i>
                                        <?php echo getVideoCount($batch['id']); ?> Videos
                                    </span>
                                </div>
                                <a href="batch.php?id=<?php echo $batch['id']; ?>" 
                                   class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 transition-colors">
                                    Start Learning
                                    <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-graduation-cap text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No learning batches available</h3>
                <p class="text-gray-600">Check back later for new content!</p>
            </div>
        <?php endif; ?>
    </main>

    <script>
        // Add any interactive functionality here
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Learn Here Free PHP Version Loaded');
        });
    </script>
</body>
</html>