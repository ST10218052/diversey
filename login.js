document.getElementById('login_form').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent form submission
  
  var username = document.getElementById('username').value;
  var password = document.getElementById('password').value;
  
  // Dummy authentication - Replace with actual authentication logic
  if (username === 'user123' && password === 'password') {
    // Set the logged in status in localStorage
    localStorage.setItem('isLoggedIn', 'true');
    alert('Login successful!');
    window.location.href = 'checkout.html'; // Redirect to index page
  } else {
    alert('Invalid username or password. Please try again.');

  }
});







