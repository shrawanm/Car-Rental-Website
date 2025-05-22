<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $userMessage = trim($_POST['message'] ?? '');
    $apiKey = 'AIzaSyD9BB5pVH8fXwTBK1ldPI9dtFGdBxQUOjg'; // API Key
    if (empty($userMessage)) {
        echo json_encode(['reply' => 'Missing message.']);
        exit;
    }

    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $apiKey;
    
    //car-only responses with greeting handling
    $prompt = "You are an expert AI that only talks about cars. 
If the user's message is a greeting like 'hi', 'hello', or 'hey', respond with a friendly car-themed greeting. 
For example: 'Hi! Ready to chat about cars?' 
If the user's message is not related to cars, reply strictly with: 
'I can only talk about cars. Let's discuss vehicles, engines, models, or anything automobile-related!' 
Never answer questions outside of this domain. 
User said: \"$userMessage\"";

    $postData = json_encode([
        'contents' => [[
            'parts' => [[ 'text' => $prompt ]]
        ]]
    ]);

    $headers = [
        'Content-Type: application/json'
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        echo json_encode(['reply' => 'Error: ' . $error]);
        exit;
    }

    $responseData = json_decode($response, true);
    $botReply = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? 'No valid response.';

    // Valid car-related and greeting keywords
    $carKeywords = [
        // Car-related terms
        'car', 'vehicle', 'engine', 'automobile', 'SUV', 'sedan', 'hatchback', 'brake',
        'transmission', 'wheel', 'motor', 'horsepower', 'tyre', 'fuel', 'mileage',
        'speed', 'dashboard', 'torque', 'gearbox', 'diesel', 'petrol', 'electric', 'hybrid',

        // Popular car brands
        'Toyota', 'Honda', 'Ford', 'BMW', 'Mercedes', 'Audi', 'Chevrolet', 'Kia', 'Hyundai',
        'Volkswagen', 'Nissan', 'Mazda', 'Jeep', 'Lexus', 'Porsche', 'Tesla', 'Ferrari',
        'Lamborghini', 'Subaru', 'Jaguar', 'Bugatti', 'McLaren', 'Rolls-Royce', 'Mini','hyundai', 'koenigsegg',

        // Greetings
        'hi', 'hello', 'hey', 'greetings'
    ];

    $isAllowedResponse = false;

    foreach ($carKeywords as $keyword) {
        if (stripos($botReply, $keyword) !== false) {
            $isAllowedResponse = true;
            break;
        }
    }

    //Force fallback if not about cars or greetings
    if (!$isAllowedResponse) {
        $botReply = "I can only talk about cars. Let's discuss vehicles, engines, models, or anything automobile-related!";
    }

    echo json_encode(['reply' => $botReply]);
}
?>
