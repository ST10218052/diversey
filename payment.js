document.getElementById('checkout').addEventListener('click', function() {
  // Check if the user is logged in
  var isLoggedIn = localStorage.getItem('isLoggedIn');
  if (isLoggedIn == 'true') {
    alert('Please log in before prong with payment.');
    window.location.href = 'Login.php'; // Redirect to login page
  } else {
    // User is logged in, proceed with payment
    alert('Procced with payment');
    window.location.href = 'checkout.php'; // Redirect to login page
   
  }
});