<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['data'])) {
        $uploadDir = 'uploads/';
        $originalName = $_FILES['data']['name'];

        // Checa se veio um nome customizado pelo campo POST 'name'
        if (isset($_POST['name'])) {
            $customName = $_POST['name'];
            $customName = preg_replace('/[^a-zA-Z0-9-\.]/', '', $customName); // substitui caracteres inválidos por _
            $customName = preg_replace('/+/', '', $customName); // remove múltiplos underscores consecutivos
            $customName = trim($customName, '_'); // remove underscores do início/fim
        } else {
            $customName = $originalName;
        }

        $filePath = $uploadDir . $customName;

        if (move_uploaded_file($_FILES['data']['tmp_name'], $filePath)) {
            echo json_encode([
                'success' => true,
                'url' => 'https://maluhhpigatti.com/uploads/' . $customName
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'Failed to move file'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'No file uploaded'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Invalid request method'
    ]);
}
