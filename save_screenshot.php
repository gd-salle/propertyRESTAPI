<?php
$imageData = file_get_contents('php://input');

if ($imageData) {
    // Specify directory to save the screenshot
    $filePath = 'C:/Users/gerar/Desktop/requisition_receipt.png';

    // Save image data to file
    if (file_put_contents($filePath, $imageData) !== false) {
        echo 'Screenshot saved successfully on your PC';
    } else {
        echo 'Failed to save screenshot on your PC';
    }
} else {
    echo 'No image data received';
}
