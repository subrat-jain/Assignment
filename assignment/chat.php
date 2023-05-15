<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chatbot</title>
    <script>
        const conversation = document.getElementById("conversation");
        const messageForm = document.getElementById("message-form");
        const messageInput = document.getElementById("message-input");
    
        messageForm.addEventListener("submit", (event) => {
            event.preventDefault();
            const userMessage = messageInput.value;
            messageInput.value = "";
            conversation.innerHTML += `<div class="user-message">${userMessage}</div>`;
            fetch("chatbot.php", {
                method: "POST",
                body: new FormData(messageForm)
            }).then(response => response.text())
              .then(data => {
                  conversation.innerHTML += `<div class="bot-message">${data}</div>`;
              })
              .catch(error => {
                  console.error(error);
              });
        });
    </script>
</head>
<body>
<?php
// define common questions and answers
$faq = array(
    "What is the application form deadline for exam A?" => "The application form deadline for exam A is June 30th.",
    "What is the application form deadline for exam B?" => "The application form deadline for exam B is July 31st.",
    // add more FAQs here
);

// process user input
if(isset($_POST["message"])) {
    $user_input = strtolower(trim($_POST["message"]));

    // search for matching FAQ
    foreach($faq as $question => $answer) {
        $normalized_question = strtolower(trim($question));
        if(strpos($user_input, $normalized_question) !== false) {
            echo $answer;
            exit;
        }
    }

    // if no matching FAQ found, show default message
    echo "I'm sorry, I don't understand your question. Please try again or contact us for assistance.";
    exit;
}
?>
    <div id="chatbot">
        <div id="conversation">
            <div class="bot-message">Hello, how can I assist you today?</div>
        </div>
        <form id="message-form" method="post" action="">
            <input type="text" id="message-input" name="message" placeholder="Type your message here...">
            <button type="submit" id="send-button">Send</button>
        </form>
    </div>
</body>
</html>