<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'create_batch':
            $name = sanitizeInput($_POST['name']);
            $description = sanitizeInput($_POST['description']);
            $orderIndex = (int)($_POST['orderIndex'] ?? 0);
            
            if (createBatch($name, $description, $orderIndex)) {
                echo json_encode(['success' => true, 'message' => 'Batch created successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create batch']);
            }
            exit;
            
        case 'create_subject':
            $name = sanitizeInput($_POST['name']);
            $batchId = sanitizeInput($_POST['batchId']);
            $description = sanitizeInput($_POST['description']);
            $orderIndex = (int)($_POST['orderIndex'] ?? 0);
            
            if (createSubject($name, $batchId, null, $description, $orderIndex)) {
                echo json_encode(['success' => true, 'message' => 'Subject created successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create subject']);
            }
            exit;
            
        case 'create_video':
            $title = sanitizeInput($_POST['title']);
            $batchId = sanitizeInput($_POST['batchId']);
            $subjectId = sanitizeInput($_POST['subjectId']);
            $description = sanitizeInput($_POST['description']);
            $youtubeUrl = sanitizeInput($_POST['youtubeUrl']);
            $duration = (int)($_POST['duration'] ?? 0);
            $orderIndex = (int)($_POST['orderIndex'] ?? 0);
            
            $videoId = extractYouTubeId($youtubeUrl);
            
            if (createVideo($title, $batchId, $subjectId, $description, $youtubeUrl, $videoId, $duration, $orderIndex)) {
                echo json_encode(['success' => true, 'message' => 'Video created successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create video']);
            }
            exit;
            
        case 'delete_batch':
            $id = sanitizeInput($_POST['id']);
            if (deleteBatch($id)) {
                echo json_encode(['success' => true, 'message' => 'Batch deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete batch']);
            }
            exit;
    }
}

// Get data for display
$batches = getAllBatches();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Learn Here Free</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .tab-button.active { border-bottom: 2px solid #3B82F6; color: #3B82F6; }
    </style>
</head>
<body class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <i class="fas fa-graduation-cap text-blue-600 text-2xl mr-3"></i>
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Admin Dashboard</h1>
                        <p class="text-sm text-gray-600">Manage content and settings</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="../index.php" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-home mr-2"></i>Back to Site
                    </a>
                    <div class="flex items-center space-x-2">
                        <span class="px-2 py-1 bg-gray-200 text-gray-800 text-xs rounded">Admin</span>
                        <span class="text-sm text-gray-600">Admin User</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg">
            <!-- Tabs -->
            <div class="border-b border-gray-200 px-6">
                <nav class="flex space-x-8">
                    <button class="tab-button active py-4 px-1 border-b-2 font-medium text-sm" data-tab="batches">
                        <i class="fas fa-layer-group mr-2"></i>Batches
                    </button>
                    <button class="tab-button py-4 px-1 border-b-2 font-medium text-sm text-gray-500 hover:text-gray-700" data-tab="subjects">
                        <i class="fas fa-book mr-2"></i>Subjects
                    </button>
                    <button class="tab-button py-4 px-1 border-b-2 font-medium text-sm text-gray-500 hover:text-gray-700" data-tab="videos">
                        <i class="fas fa-video mr-2"></i>Videos
                    </button>
                </nav>
            </div>

            <!-- Batches Tab -->
            <div id="batches" class="tab-content active p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-medium text-gray-900">Manage Batches</h2>
                    <button onclick="showCreateBatchModal()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Create Batch
                    </button>
                </div>

                <div class="grid gap-4">
                    <?php foreach ($batches as $batch): ?>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900"><?php echo htmlspecialchars($batch['name']); ?></h3>
                                    <?php if ($batch['description']): ?>
                                        <p class="text-gray-600 mt-1"><?php echo htmlspecialchars($batch['description']); ?></p>
                                    <?php endif; ?>
                                    <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                        <span><i class="fas fa-book mr-1"></i><?php echo getSubjectCount($batch['id']); ?> Subjects</span>
                                        <span><i class="fas fa-video mr-1"></i><?php echo getVideoCount($batch['id']); ?> Videos</span>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button onclick="deleteBatch('<?php echo $batch['id']; ?>')" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Subjects Tab -->
            <div id="subjects" class="tab-content p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-medium text-gray-900">Manage Subjects</h2>
                    <button onclick="showCreateSubjectModal()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Create Subject
                    </button>
                </div>

                <div class="text-gray-600">
                    <p>Subject management interface will be displayed here.</p>
                </div>
            </div>

            <!-- Videos Tab -->
            <div id="videos" class="tab-content p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-medium text-gray-900">Manage Videos</h2>
                    <button onclick="showCreateVideoModal()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Create Video
                    </button>
                </div>

                <div class="text-gray-600">
                    <p>Video management interface will be displayed here.</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Modals -->
    <!-- Create Batch Modal -->
    <div id="createBatchModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Create New Batch</h3>
                <form id="createBatchForm">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Batch Name</label>
                        <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" class="w-full px-3 py-2 border border-gray-300 rounded-md" rows="3"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Order Index</label>
                        <input type="number" name="orderIndex" value="0" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="hideCreateBatchModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Tab functionality
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                const tabId = button.getAttribute('data-tab');
                
                // Remove active class from all tabs and buttons
                document.querySelectorAll('.tab-button').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked button and corresponding content
                button.classList.add('active');
                document.getElementById(tabId).classList.add('active');
            });
        });

        // Modal functions
        function showCreateBatchModal() {
            document.getElementById('createBatchModal').classList.remove('hidden');
        }

        function hideCreateBatchModal() {
            document.getElementById('createBatchModal').classList.add('hidden');
            document.getElementById('createBatchForm').reset();
        }

        function showCreateSubjectModal() {
            alert('Subject creation modal will be implemented');
        }

        function showCreateVideoModal() {
            alert('Video creation modal will be implemented');
        }

        // Form submission
        document.getElementById('createBatchForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            formData.append('action', 'create_batch');
            
            try {
                const response = await fetch('index.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('Batch created successfully!');
                    hideCreateBatchModal();
                    location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                alert('Error creating batch');
            }
        });

        // Delete batch
        async function deleteBatch(id) {
            if (!confirm('Are you sure you want to delete this batch?')) return;
            
            const formData = new FormData();
            formData.append('action', 'delete_batch');
            formData.append('id', id);
            
            try {
                const response = await fetch('index.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('Batch deleted successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                alert('Error deleting batch');
            }
        }
    </script>
</body>
</html>