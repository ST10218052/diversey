
<?php
session_start();
 include 'connect.php'; // Assuming you have a separate file for database connection
 
 $sql = "SELECT * FROM messages ORDER BY created_at ASC";
 $result = $conn->query($sql);
 
 $messages = [];
 while ($row = $result->fetch_assoc()) {
     $messages[] = $row;
 }
 
 echo json_encode($messages);
 ?>
 



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    
    <link rel="stylesheet" href="style1.css">
    <style>
    *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    text-decoration: none;
    border: none;
    outline: none;
    scroll-behavior: smooth;
    font-family: "Poppins",sans-serif;
   ;
}
#chatbox {
    align-items: center
    
    width: 600px;
    height: 80%;
    border: 1px solid #ccc;
    padding: 10px;
    overflow-y: scroll;
}
.message {
    margin-bottom: 10px;
    box-sizing: border-box;
    border-color: blue;
   
    display: inline-block;
    padding: 1rem 2.8rem;
    background-color:rgb(224, 224, 237);
    border-radius: 4rem;
    font-size: 1.6rem;
    color: var(--main-color);
    border: 2px solid transparent;
    
    font-weight: 250;
    transition: 0.3s ease-in-out;
    cursor: pointer;
}
.user {
    text-align: right;
    color: blue;
}
.admin {
    text-align: left;
    color: green;
}
.email{
    margin-bottom: 20px;
}
section{
    min-height: 100vh;
    padding: 10rem 9% 10rem;
    
    }</style>
    <title>Products | Diversey Inc</title>
</head>
<body>


    <main>
 
   
    <div id="chatbox">

    <?php
while ($row = $result->fetch_assoc()) {
  ?>
<div class="icon">
                    <i class="fas fa-user"></i><div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                </div>
<div class="user">
<div class="icon">
                    <i class="fas fa-user"></i>
                </div>
    <div class="emailB">
    <p><?=$row['email'];?></p>
    </div>
<br>
<br>
<div class="message">
    <p><?=$row['message'];?></p>
</div>
</div>


<?php  echo json_encode($messages);}?>
<form id="chatForm" >
    <input type="hidden" name="user_type" value="user"> <!-- Adjust as needed -->
    <input type="text" name="message" id="messageInput" placeholder="Type your message..." autocomplete="off">
    <button type="submit">Send</button>
</form>

    </div>
<script>    
    function fetchMessages() {
        fetch('get_messages.php')
            .then(response => response.json())
            .then(messages => {
                const chatbox = document.getElementById('chatbox');
                chatbox.innerHTML = '';
                messages.forEach(message => {
                    const messageElement = document.createElement('div');
                    messageElement.classList.add('message', message.user_type);
                    messageElement.textContent = message.username + ': ' + message.message;
                    chatbox.appendChild(messageElement);
                });
                chatbox.scrollTop = chatbox.scrollHeight; // Scroll to bottom
            });
    }

    document.getElementById('chatForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        fetch('send_message.php', {
            method: 'POST',
            body: formData
        }).then(() => {
            document.getElementById('messageInput').value = ''; // Clear input
            fetchMessages(); // Refresh messages
        });
    });

    // Fetch messages every 2 seconds
   
    fetchMessages(); // Initial fetch
</script>


    </main>

   
</body>
</html>


