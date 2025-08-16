<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

$multiPlatformVideos = getAllMultiPlatformVideos();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Platform Videos - Learn Here Free</title>
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
                    <a href="index.php" class="flex items-center text-gray-600 hover:text-gray-900 mr-4">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Home
                    </a>
                    <i class="fas fa-database text-blue-600 text-2xl mr-3"></i>
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Multi-Platform Videos</h1>
                        <p class="text-sm text-gray-600">Videos from various platforms</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="admin/" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-cog mr-2"></i>Admin Panel
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Description -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Multi-Platform Video Collection</h2>
            <p class="text-gray-600 mb-4">Access educational content from YouTube, Vimeo, and other video platforms in one place.</p>
            <div class="flex items-center space-x-6 text-sm text-gray-500">
                <span class="flex items-center">
                    <i class="fas fa-play-circle mr-2"></i>
                    <?php echo count($multiPlatformVideos); ?> Videos Available
                </span>
                <span class="flex items-center">
                    <i class="fas fa-globe mr-2"></i>
                    Multiple Platforms
                </span>
            </div>
        </div>

        <!-- Videos Grid -->
        <?php if (!empty($multiPlatformVideos)): ?>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($multiPlatformVideos as $video): ?>
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 card-hover">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-3">
                                <h4 class="text-lg font-semibold text-gray-900">
                                    <?php echo htmlspecialchars($video['title']); ?>
                                </h4>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    <?php echo $video['platform'] === 'youtube' ? 'bg-red-100 text-red-800' : 
                                               ($video['platform'] === 'vimeo' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'); ?>">
                                    <?php echo ucfirst($video['platform']); ?>
                                </span>
                            </div>
                            
                            <?php if (!empty($video['description'])): ?>
                                <p class="text-gray-600 text-sm mb-4">
                                    <?php echo htmlspecialchars($video['description']); ?>
                                </p>
                            <?php endif; ?>
                            
                            <!-- Video Player -->
                            <div class="video-container mb-4">
                                <?php if ($video['platform'] === 'youtube'): ?>
                                    <iframe 
                                        src="https://www.youtube-nocookie.com/embed/<?php echo htmlspecialchars($video['video_id']); ?>?rel=0&modestbranding=1" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                    </iframe>
                                <?php elseif ($video['platform'] === 'vimeo'): ?>
                                    <iframe 
                                        src="https://player.vimeo.com/video/<?php echo htmlspecialchars($video['video_id']); ?>?title=0&byline=0&portrait=0" 
                                        frameborder="0" 
                                        allow="autoplay; fullscreen; picture-in-picture" 
                                        allowfullscreen>
                                    </iframe>
                                <?php else: ?>
                                    <div class="flex items-center justify-center h-full bg-gray-100">
                                        <div class="text-center">
                                            <i class="fas fa-play-circle text-gray-400 text-4xl mb-2"></i>
                                            <p class="text-gray-600">Video player not available</p>
                                            <a href="<?php echo htmlspecialchars($video['video_url']); ?>" target="_blank" 
                                               class="text-blue-600 hover:text-blue-800 text-sm">
                                                Watch on <?php echo ucfirst($video['platform']); ?>
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <?php if ($video['duration']): ?>
                                    <span class="flex items-center">
                                        <i class="fas fa-clock mr-1"></i>
                                        <?php echo gmdate("H:i:s", $video['duration']); ?>
                                    </span>
                                <?php else: ?>
                                    <span></span>
                                <?php endif; ?>
                                <a href="<?php echo htmlspecialchars($video['video_url']); ?>" target="_blank" 
                                   class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-external-link-alt mr-1"></i>
                                    Open Original
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-video text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No multi-platform videos available</h3>
                <p class="text-gray-600">Multi-platform videos will be added soon!</p>
                <a href="admin/" class="inline-flex items-center px-4 py-2 mt-4 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Add Videos (Admin)
                </a>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>