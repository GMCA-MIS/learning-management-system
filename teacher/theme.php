<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="quiz.css">
    <title>Quiz Page</title>
</head>
<body>
    <div class="quiz-container">
        <div class="question">
            <h2>Question 1:</h2>
            <p>What is the capital of France?</p>
        </div>
        <div class="options">
            <input type="radio" name="q1" id="q1a" value="a">
            <label for="q1a">A. Paris</label><br>
            <input type="radio" name="q1" id="q1b" value="b">
            <label for="q1b">B. Berlin</label><br>
            <input type="radio" name="q1" id="q1c" value="c">
            <label for="q1c">C. London</label><br>
        </div>
        <button class="next-button">Next</button>
    </div>
</body>
</html>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.quiz-container {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    text-align: left;
    max-width: 400px;
}

.question h2 {
    font-size: 18px;
    margin-bottom: 10px;
}

.options input[type="radio"] {
    margin-right: 10px;
}

.next-button {
    background-color: #007BFF;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
}

.next-button:hover {
    background-color: #0056b3;
}

</style>
