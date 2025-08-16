<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

$subjectId = $_GET['id'] ?? null;
if (!$subjectId) {
    header('Location: index.php');
    exit;
}

$subject = getSubject($subjectId);
if (!$subject) {
    header('Location: index.php');
    exit;
}

$batch = getBatch($subject['batch_id']);
$videos = getVideosBySubject($subjectId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($subject['name']); ?> - Learn Here Free</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .video-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; }
        .video-container iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
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
                    <a href="batch.php?id=<?php echo $subject['batch_id']; ?>" class="flex items-center text-gray-600 hover:text-gray-900 mr-4">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to <?php echo htmlspecialchars($batch['name']); ?>
                    </a>
                    <i class="fas fa-book text-blue-600 text-2xl mr-3"></i>
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900"><?php echo htmlspecialchars($subject['name']); ?></h1>
                        <p class="text-sm text-gray-600">Subject Videos</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Subject Description -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4"><?php echo htmlspecialchars($subject['name']); ?></h2>
            <?php if (!empty($subject['description'])): ?>
                <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($subject['description']); ?></p>
            <?php endif; ?>
            <div class="flex items-center space-x-6 text-sm text-gray-500">
                <span class="flex items-center">
                    <i class="fas fa-play-circle mr-2"></i>
                    <?php echo count($videos); ?> Videos
                </span>
                <span class="flex items-center">
                    <i class="fas fa-graduation-cap mr-2"></i>
                    <?php echo htmlspecialchars($batch['name']); ?>
                </span>
            </div>
        </div>

        <!-- Videos Grid -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Video Lectures</h3>
        </div>

        <?php if (!empty($videos)): ?>
            <div class="grid md:grid-cols-2 gap-6">
                <?php foreach ($videos as $video): ?>
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 card-hover">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">
                                <?php echo htmlspecialchars($video['title']); ?>
                            </h4>
                            
                            <?php if (!empty($video['description'])): ?>
                                <p class="text-gray-600 text-sm mb-4">
                                    <?php echo htmlspecialchars($video['description']); ?>
                                </p>
                            <?php endif; ?>
                            
                            <?php if (!empty($video['youtube_url'])): ?>
                                <div class="video-container mb-4">
                                    <iframe 
                                        src="https://www.youtube-nocookie.com/embed/<?php echo htmlspecialchars($video['video_id']); ?>?rel=0&modestbranding=1" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            <?php endif; ?>
                            
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <?php if ($video['duration']): ?>
                                    <span class="flex items-center">
                                        <i class="fas fa-clock mr-1"></i>
                                        <?php echo gmdate("H:i:s", $video['duration']); ?>
                                    </span>
                                <?php endif; ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Available
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-video text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No videos available</h3>
                <p class="text-gray-600">Video lectures will be added soon!</p>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>