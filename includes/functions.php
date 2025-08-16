<?php
// Common functions for the application

function getAllBatches() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM batches WHERE is_active = 1 ORDER BY order_index, created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll();
}

function getBatch($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM batches WHERE id = ? AND is_active = 1");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getSubjectsByBatch($batchId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM subjects WHERE batch_id = ? AND is_active = 1 ORDER BY order_index, created_at");
    $stmt->execute([$batchId]);
    return $stmt->fetchAll();
}

function getVideosBySubject($subjectId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM videos WHERE subject_id = ? AND is_active = 1 ORDER BY order_index, created_at");
    $stmt->execute([$subjectId]);
    return $stmt->fetchAll();
}

function getVideosByBatch($batchId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM videos WHERE batch_id = ? AND is_active = 1 ORDER BY order_index, created_at");
    $stmt->execute([$batchId]);
    return $stmt->fetchAll();
}

function getSubjectCount($batchId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM subjects WHERE batch_id = ? AND is_active = 1");
    $stmt->execute([$batchId]);
    return $stmt->fetchColumn();
}

function getVideoCount($batchId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM videos WHERE batch_id = ? AND is_active = 1");
    $stmt->execute([$batchId]);
    return $stmt->fetchColumn();
}

function getSubject($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM subjects WHERE id = ? AND is_active = 1");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getVideo($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM videos WHERE id = ? AND is_active = 1");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getAllMultiPlatformVideos() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM multi_platform_videos WHERE is_active = 1 ORDER BY order_index, created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll();
}

function getMultiPlatformVideo($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM multi_platform_videos WHERE id = ? AND is_active = 1");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function createBatch($name, $description = null, $orderIndex = 0) {
    global $pdo;
    $id = 'batch-' . uniqid();
    $stmt = $pdo->prepare("INSERT INTO batches (id, name, description, order_index) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$id, $name, $description, $orderIndex]);
}

function createSubject($name, $batchId, $courseId = null, $description = null, $orderIndex = 0) {
    global $pdo;
    $id = 'subject-' . uniqid();
    $stmt = $pdo->prepare("INSERT INTO subjects (id, name, batch_id, course_id, description, order_index) VALUES (?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$id, $name, $batchId, $courseId, $description, $orderIndex]);
}

function createVideo($title, $batchId, $subjectId = null, $description = null, $youtubeUrl = null, $videoId = null, $duration = null, $orderIndex = 0) {
    global $pdo;
    $id = 'video-' . uniqid();
    $stmt = $pdo->prepare("INSERT INTO videos (id, title, batch_id, subject_id, description, youtube_url, video_id, duration, order_index) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$id, $title, $batchId, $subjectId, $description, $youtubeUrl, $videoId, $duration, $orderIndex]);
}

function createMultiPlatformVideo($title, $platform, $videoId, $videoUrl, $description = null, $duration = null, $subjectId = null, $batchId = null, $orderIndex = 0) {
    global $pdo;
    $id = 'multi-video-' . uniqid();
    $stmt = $pdo->prepare("INSERT INTO multi_platform_videos (id, title, platform, video_id, video_url, description, duration, subject_id, batch_id, order_index) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$id, $title, $platform, $videoId, $videoUrl, $description, $duration, $subjectId, $batchId, $orderIndex]);
}

function updateBatch($id, $name, $description = null, $orderIndex = null) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE batches SET name = ?, description = ?, order_index = COALESCE(?, order_index) WHERE id = ?");
    return $stmt->execute([$name, $description, $orderIndex, $id]);
}

function deleteBatch($id) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE batches SET is_active = 0 WHERE id = ?");
    return $stmt->execute([$id]);
}

function extractYouTubeId($url) {
    $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
    preg_match($pattern, $url, $matches);
    return isset($matches[1]) ? $matches[1] : false;
}

function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function generateId($prefix = 'item') {
    return $prefix . '-' . uniqid() . '-' . time();
}

// Insert sample data if tables are empty
function insertSampleData() {
    global $pdo;
    
    // Check if data already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM batches");
    $stmt->execute();
    $count = $stmt->fetchColumn();
    
    if ($count == 0) {
        // Insert sample batches
        $batches = [
            ['batch-medical-1', 'MBBS Foundation', 'Complete medical foundation course for MBBS students', 0],
            ['batch-engineering-1', 'Engineering Basics', 'Fundamental engineering concepts and principles', 1],
            ['batch-science-1', 'Science Fundamentals', 'Core science subjects for students', 2]
        ];
        
        foreach ($batches as $batch) {
            $stmt = $pdo->prepare("INSERT INTO batches (id, name, description, order_index) VALUES (?, ?, ?, ?)");
            $stmt->execute($batch);
        }
        
        // Insert sample subjects
        $subjects = [
            ['subject-anatomy-1', 'batch-medical-1', null, 'Human Anatomy', 'Study of human body structure', 0],
            ['subject-physiology-1', 'batch-medical-1', null, 'Human Physiology', 'Study of body functions', 1],
            ['subject-math-1', 'batch-engineering-1', null, 'Engineering Mathematics', 'Mathematical foundations for engineers', 0],
            ['subject-physics-1', 'batch-science-1', null, 'Physics Fundamentals', 'Basic physics concepts', 0]
        ];
        
        foreach ($subjects as $subject) {
            $stmt = $pdo->prepare("INSERT INTO subjects (id, batch_id, course_id, name, description, order_index) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute($subject);
        }
        
        // Insert sample videos
        $videos = [
            ['video-intro-anatomy', 'subject-anatomy-1', 'batch-medical-1', 'Introduction to Anatomy', 'Basic introduction to human anatomy', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'dQw4w9WgXcQ', 600, 0],
            ['video-skeletal-system', 'subject-anatomy-1', 'batch-medical-1', 'Skeletal System', 'Overview of human skeletal system', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'dQw4w9WgXcQ', 900, 1],
            ['video-intro-physiology', 'subject-physiology-1', 'batch-medical-1', 'Introduction to Physiology', 'Basic physiology concepts', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'dQw4w9WgXcQ', 720, 0]
        ];
        
        foreach ($videos as $video) {
            $stmt = $pdo->prepare("INSERT INTO videos (id, subject_id, batch_id, title, description, youtube_url, video_id, duration, order_index) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute($video);
        }
    }
}

// Initialize sample data
insertSampleData();
?>