// All validation of website is here 


// Cancel Notification functionality
const cancelBtn = document.getElementById('cancel-notification');
const notifyDiv = document.getElementById('notify');

if (cancelBtn && notifyDiv) {
    // Add a click event listener to the cancel button
    cancelBtn.addEventListener('click', () => {
        // Hide the notification div
        notifyDiv.style.display = 'none';
    });
}



// Function to check if the email is valid
function isValidEmail(email) {
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return emailPattern.test(email);
}


// login form validation
let loginForm = document.getElementById('login-form');

if (loginForm) {
    document.getElementById('login-form').addEventListener('submit', function (event) {
        // Prevent form submission
        event.preventDefault();

        let isValid = true;

        // Get input values
        const userName = document.getElementById('user_name').value.trim();
        const password = document.getElementById('password').value.trim();

        // Clear previous error messages
        document.getElementById('user_name_error').textContent = '';
        document.getElementById('password_error').textContent = '';

        // Validate User Name
        if (userName === '') {
            isValid = false;
            document.getElementById('user_name_error').textContent = 'User Name is required.';
        }

        // Validate Password
        let passwordErrorMessage = '';
        if (password === '') {
            isValid = false;
            passwordErrorMessage = 'Password is required.';
        } else if (password.length < 8) {
            isValid = false;
            passwordErrorMessage = 'Password must be at least 8 characters.';
        } else if (password.length > 10) {
            isValid = false;
            passwordErrorMessage = 'Password must be no more than 10 characters.';
        }

        // If there was any password validation error, update the error message display
        document.getElementById('password_error').textContent = passwordErrorMessage;


        // If all validations pass, submit the form
        if (isValid) {
            this.submit();
        }
    });
}


// forget password form validation
let forgotPasswordForm = document.getElementById('forgotPasswordForm');

if (forgotPasswordForm) {
    forgotPasswordForm.addEventListener('submit', function (event) {
        // Prevent form submission
        event.preventDefault();
        // prompt();

        let isValid = true;

        // Get email value
        const email = document.getElementById('email').value.trim();

        // Clear previous error message
        document.getElementById('email_error').textContent = '';
        let emailErrorMessage = '';

        // Validate Email
        if (email === '') {
            isValid = false;
            emailErrorMessage = 'Email is required.';
        } else if (!isValidEmail(email)) {
            isValid = false;
            emailErrorMessage = 'Please enter a valid email address.';
        }

        // If there was any error, update the error message display
        document.getElementById('email_error').textContent = emailErrorMessage;

        // If form is valid, submit the form
        if (isValid) {
            this.submit();
        }
    });
}




// Register form validation

let registerForm = document.getElementById('registerForm');
if (registerForm) {
    registerForm.addEventListener('submit', function (event) {
        event.preventDefault();

        let isValid = true;

        // Clear all errors
        document.getElementById('name_error').textContent = '';
        document.getElementById('user_name_error').textContent = '';
        document.getElementById('email_error').textContent = '';
        document.getElementById('mb_number_error').textContent = '';
        document.getElementById('cpassword_error').textContent = '';
        document.getElementById('password_error').textContent = '';
        document.getElementById('gender_error').textContent = '';

        // Form Inputs
        const name = document.getElementById('name').value.trim();
        const userName = document.getElementById('user_name').value.trim();
        const email = document.getElementById('email').value.trim();
        const mobileNumber = document.getElementById('mb-number').value.trim();
        const password = document.getElementById('cpassword').value.trim();
        const confirmPassword = document.getElementById('password').value.trim();
        const gender = document.querySelector('input[name="gender"]:checked');

        // Validate each input
        if (name === '') {
            isValid = false;
            document.getElementById('name_error').textContent = 'Name is required.';
        }
        if (userName === '') {
            isValid = false;
            document.getElementById('user_name_error').textContent = 'User name is required.';
        }
        if (email === '' || !/\S+@\S+\.\S+/.test(email)) {
            isValid = false;
            document.getElementById('email_error').textContent = 'A valid email is required.';
        }
        if (mobileNumber === '' || !/^\d{10}$/.test(mobileNumber)) {
            isValid = false;
            document.getElementById('mb_number_error').textContent = 'Enter a valid 10-digit number.';
        }
        if (password === '' || password.length < 8) {
            isValid = false;
            document.getElementById('cpassword_error').textContent = 'Password must be at least 8 characters.';
        }
        if (confirmPassword !== password) {
            isValid = false;
            document.getElementById('password_error').textContent = 'Passwords do not match.';
        }
        if (!gender) {
            isValid = false;
            document.getElementById('gender_error').textContent = 'Please select a gender.';
        }

        // Submit form if valid
        if (isValid) {
            this.submit();
        }
    });
}


// Reset password form validation

const resetPasswordForm = document.getElementById('resetPasswordForm');
console.log(resetPasswordForm);

if (resetPasswordForm) {

    resetPasswordForm.addEventListener('submit', function (e) {
        console.log('clicked');

        e.preventDefault();
        let isValid = true;

        const passwordInput = document.getElementById('password');
        const cpasswordInput = document.getElementById('cpassword');
        const passwordError = document.getElementById('password_error');
        const cpasswordError = document.getElementById('cpassword_error');


        // Clear previous error messages
        passwordError.textContent = '';
        cpasswordError.textContent = '';

        const password = passwordInput.value.trim();
        const cpassword = cpasswordInput.value.trim();

        console.log(password, cpassword);
        // Validate New Password
        if (password === '') {
            isValid = false;
            passwordError.textContent = 'Password is required.';
        } else if (password.length < 8) {
            isValid = false;
            passwordError.textContent = 'Password must be at least 8 characters.';
        } else if (password.length > 10) {
            isValid = false;
            passwordError.textContent = 'Password must be no more than 10 characters.';
        }

        // Validate Confirm Password
        if (cpassword === '') {
            isValid = false;
            cpasswordError.textContent = 'Please confirm your password.';
        } else if (cpassword !== password) {
            isValid = false;
            cpasswordError.textContent = 'Passwords do not match.';
        }
        console.log('form validated');

        // Submit form if valid
        if (isValid) {
            this.submit();
        }
    });

}
