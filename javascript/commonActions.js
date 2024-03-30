$(document).ready(function(){
 $(".navShowHide").on("click", function(){
  var main = $("#mainSectionContainer");
  var nav = $("#sideNavContainer");
  if(main.hasClass("leftpadding")){
    nav.hide();
   }
   else{
    nav.show();
    }
    main.toggleClass("leftpadding")
 });
 
});
function notSignedIn() {
  alert("You must be signed in to perform this action");
}

function WalletContainer() {
  var cont = document.getElementById('WalletContainer');
  var value = cont.style.getPropertyValue('visibility');

  cont.classList.toggle('Wallethidden');
  
  
};

function updateBalance() {
  // Send an AJAX request to the PHP file that updates the balance
  $.ajax({
      url: 'ajax/update_balance.php',
      success: function(data) {
          // Update the value of the balance element with the updated value
          $('#balance').text('Balance: ' + data);
      }
  });
}

// Call the updateBalance function every 1 second
setInterval(updateBalance, 1000);

function getImagePreview(event){
  var image =URL.createObjectURL(event.target.files[0]);
  var imagediv = document.getElementById('Preview');
  var newimg = document.createElement('img');
  newimg.src=image;
  imagediv.appendChild(newimg);
}
function getImagePre(event) {
  var image = URL.createObjectURL(event.target.files[0]);
  var imagediv = document.getElementsByClassName('profileImage')[0];

  if (imagediv && imagediv.tagName === 'IMG') {
    imagediv.src = image;
    setTimeout(function() {
      confirmFileSelection(event);
  }, 400);
    
  }
}

function confirmFileSelection(event) {
  var fileInput = event.target;
  if (fileInput.files && fileInput.files.length > 0) {
    if (confirm('Are you sure you want to select this file?')) {
      document.getElementById('profileForm').submit();
      
    }
  }
}

function showFileInput() {
  var fileInput = document.getElementById("file");
  fileInput.style.visibility = "visible";
}

function hideFileInput() {
  var fileInput = document.getElementById("file");
  fileInput.style.visibility = "hidden";
}

function withdraw(balance){
  
  let withdraw = document.getElementById("withdrawbutton");
  if (balance>0) {
    window.location.href = "withdraw.php"
  }else{
    alert("No balance to withdraw");
  }
}

window.addEventListener('load', function () {
  const currencySwitch = document.getElementById('currencySwitch');
  const usdSymbol = document.querySelector('.symbol.b i');
  const storedCurrency = getCookie('currency');

  if (storedCurrency) {
    currencySwitch.checked = (storedCurrency === 'USD');
    updateCurrencySymbol();
  }

  // Add event listener for switch change
  currencySwitch.addEventListener('change', function () {
    updateCurrencySymbol();
    // Save the selected currency in cookies
    setCookie('currency', currencySwitch.checked ? 'USD' : 'INR', 7);
  });

  // Function to update the displayed currency symbol and apply bouncing animation
  function updateCurrencySymbol() {
const usdSymbol = document.querySelector('.symbol.b i');
const rupSymbol = document.querySelector('.symbol.a i');

if (currencySwitch.checked) {
  usdSymbol.classList.add('bounce');
  rupSymbol.classList.remove('bounce');
  rupSymbol.classList.add('hidden');
  usdSymbol.classList.remove('hidden');
} else {
  
  usdSymbol.classList.remove('bounce');
  rupSymbol.classList.add('bounce');
  usdSymbol.classList.add('hidden');
  rupSymbol.classList.remove('hidden');
  
}
}

  // Function to set a cookie
  function setCookie(name, value, days) {
    const date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    const expires = "expires=" + date.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
  }

  // Function to get the value of a cookie
  function getCookie(name) {
    const cookieName = name + "=";
    const cookies = document.cookie.split(';');
    for (let i = 0; i < cookies.length; i++) {
      let cookie = cookies[i].trim();
      if (cookie.indexOf(cookieName) === 0) {
        return cookie.substring(cookieName.length, cookie.length);
      }
    }
    return null;
  }
});






