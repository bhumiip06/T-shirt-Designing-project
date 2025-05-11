<?php
session_start(); // Start the session to access session variables


if (!isset($_SESSION['user_id'])) {
    http_response_code(401);  // Unauthorized
    header('Content-Type: application/json'); // Send JSON error
    echo json_encode(['error' => 'Unauthorized: User not logged in.']);
    exit;
}
$user_id = $_SESSION['user_id'];

// --- Database Connection ---
include 'connection.php'; 
if ($con->connect_error) {
    http_response_code(500); // Internal Server Error
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Database connection failed: ' . $con->connect_error]);
    exit;
}

// --- Get and Decode Image Data ---
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['image']) || empty($data['image'])) {
     http_response_code(400); // Bad Request
     header('Content-Type: application/json');
     echo json_encode(['error' => 'Missing or empty image data.']);
     exit;
}

$imageData = $data['image'];


if (strpos($imageData, 'data:image/png;base64,') === 0) {
    $imageData = str_replace('data:image/png;base64,', '', $imageData);
} else {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid image format. Only PNG is supported.']);
    exit;
}

$imageData = str_replace(' ', '+', $imageData);
$image = base64_decode($imageData);

if ($image === false) {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Failed to decode base64 image data.']);
    exit;
}


// 1. Filesystem path (using __DIR__ for robustness)
//    Script is in /php/, uploads is ../uploads/
$uploadDirFilesystem = __DIR__ . '/../uploads';

// 2. Web path (Absolute path from web root)
$uploadDirWeb = '/T-shirt-Designing-project/uploads';

// Create a unique filename *once*
$uniqueName = 'design_' . time() . '.png'; 
// Full filesystem path for saving the file
$filePath = $uploadDirFilesystem . '/' . $uniqueName;


if (!is_dir($uploadDirFilesystem)) {
    if (!mkdir($uploadDirFilesystem, 0775, true)) {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode(['error' => "Failed to create upload directory: $uploadDirFilesystem"]);
        $con->close(); 
    }
}
if (!is_writable($uploadDirFilesystem)) {
     http_response_code(500);
     header('Content-Type: application/json');
     echo json_encode(['error' => "Upload directory is not writable: $uploadDirFilesystem. Check server permissions."]);
     $con->close(); 
     exit;
}


// --- Save Image to Server ---

if (file_put_contents($filePath, $image)) {
    
    // --- Construct the Correct Full Image URL ---
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST']; 

    
    // Combine host with the *absolute web path* ($uploadDirWeb) and the unique name
    $imageUrl = $protocol . "://" . $host . $uploadDirWeb . '/' . $uniqueName;
    // This will generate: http://localhost/T-shirt-Designing-project/uploads/design_...png
   
    // Generate a unique design name using current time
    $design_name = 'Custom T-shirt_' . time();

    // --- Save Image URL to Database ---
    $stmt = $con->prepare("INSERT INTO designs (design_data, design_name, user_id) VALUES (?, ?, ?)");
    if ($stmt === false) {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Database prepare statement failed: ' . $con->error]);
        unlink($filePath); 
        $con->close();
        exit;
    }

    $stmt->bind_param("ssi", $imageUrl, $design_name, $user_id); // Storing the CORRECT generated URL

    if ($stmt->execute()) {
        // Success
        $stmt->close();
        $con->close();

        // --- Return the image URL as JSON ---
        header('Content-Type: application/json'); 
        echo json_encode(['url' => $imageUrl]);  

    } else {
        // Handle execute error
        $errorMsg = $stmt->error;
        $stmt->close();
        $con->close();
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Database execute statement failed: ' . $errorMsg]);
        unlink($filePath); 
        exit;
    }

} else {
    // Failed to save file
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['error' => "Failed to save image to $filePath. Check path and permissions."]);
    $con->close();
    exit;
}
?>