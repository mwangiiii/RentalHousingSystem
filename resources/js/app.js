import './bootstrap';

import 'intl-tel-input/build/css/intlTelInput.css';
import intlTelInput from 'intl-tel-input';

// Initialize intl-tel-input on DOMContentLoaded
document.addEventListener("DOMContentLoaded", function() {
    var input = document.querySelector("#phone_number");

    // input.dispatchEvent(new Event('input'));

    if (input) {
        var iti = intlTelInput(input, {
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                fetch('https://ipinfo.io/json', { cache: 'reload' })
                    .then(response => response.json())
                    .then(data => {
                        var countryCode = (data && data.country) ? data.country : "us";
                        callback(countryCode);
                    })
                    .catch(() => {
                        callback('us');
                    });
            },
            // Path to utils.js
            utilsScript: '/node_modules/intl-tel-input/build/js/utils.js' // Path to utils.js
        });

        // Ensure the full phone number is set on form submission
        var form = input.closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                var fullNumber = iti.getNumber();
                input.value = fullNumber;
                console.log('Full phone number:', fullNumber); // Debug line
                console.log('Input value before submission:', input.value); // Debug line
                // console.log('Full phone number:', fullNumber); // Debug line
            });
        }
    }
});

//Duration of the success message
document.addEventListener('DOMContentLoaded', function() {
    var successBanner = document.getElementById('success-banner');
    if (successBanner) {
        setTimeout(function() {
            successBanner.style.display = 'none';
        }, 1000); // 1000 milliseconds = 1 seconds
    }
});
