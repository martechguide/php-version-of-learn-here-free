<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

$batchId = $_GET['id'] ?? null;
if (!$batchId) {
    header('Location: index.php');
    exit;
}

$batch = getBatch($batchId);
if (!$batch) {
    header('Location: index.php');
    exit;
}

$subjects = getSubjectsByBatch($batchId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($batch['name']); ?> - Learn Here Free</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
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
                    <a href="index.php" class="flex items-center text-gray-600 hover:text-gray-900 mr-4">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Home
                    </a>
                    <i class="fas fa-graduation-cap text-blue-600 text-2xl mr-3"></i>
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900"><?php echo htmlspecialchars($batch['name']); ?></h1>
                        <p class="text-sm text-gray-600">Learning Batch</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Batch Description -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4"><?php echo htmlspecialchars($batch['name']); ?></h2>
            <?php if (!empty($batch['description'])): ?>
                <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($batch['description']); ?></p>
            <?php endif; ?>
            <div class="flex items-center space-x-6 text-sm text-gray-500">
                <span class="flex items-center">
                    <i class="fas fa-book mr-2"></i>
                    <?php echo count($subjects); ?> Subjects
                </span>
                <span class="flex items-center">
                    <i class="fas fa-play-circle mr-2"></i>
                    <?php echo getVideoCount($batchId); ?> Videos
                </span>
            </div>
        </div>

        <!-- Subjects Grid -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Available Subjects</h3>
        </div>

        <?php if (!empty($subjects)): ?>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($subjects as $subject): ?>
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 card-hover">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-3">
                                <h4 class="text-lg font-semibold text-gray-900">
                                    <?php echo htmlspecialchars($subject['name']); ?>
                                </h4>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            </div>
                            
                            <?php if (!empty($subject['description'])): ?>
                                <p class="text-gray-600 text-sm mb-4">
                                    <?php echo htmlspecialchars($subject['description']); ?>
                                </p>
                            <?php endif; ?>
                            
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-500">
                                    <span class="flex items-center">
                                        <i class="fas fa-play-circle mr-1"></i>
                                        <?php 
                                        $videoCount = 0;
                                        $videos = getVideosBySubject($subject['id']);
                                        $videoCount = count($videos);
                                        echo $videoCount; 
                                        ?> Videos
                                    </span>
                                </div>
                                <a href="subject.php?id=<?php echo $subject['id']; ?>" 
                                   class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 transition-colors">
                                    View Videos
                                    <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-book text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No subjects available</h3>
                <p class="text-gray-600">Subjects will be added soon!</p>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>