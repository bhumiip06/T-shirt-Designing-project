const EyeIcon=document.getElementById('eye-icon');

const password_Field=document.getElementById('password');

EyeIcon.addEventListener('click',()=>{
    if(password_Field.type ==="password"){
        password_Field.type="text";
        EyeIcon.classList.remove('fa-eye');
        EyeIcon.classList.add('fa-eye-slash');
    }
    else{
        password_Field.type="password";
        EyeIcon.classList.remove('fa-eye-slash');
        EyeIcon.classList.add('fa-eye');
    }
});

// const Eyeicon=document.getElementById('eye_icon');

// const passwordfield=document.getElementById('confirm-password');

// Eyeicon.addEventListener('click',()=>{
//     if(passwordfield.type ==="password"){
//         passwordfield.type="text";
//         EyeIcon.classList.remove('fa-eye');
//         EyeIcon.classList.add('fa-eye-slash');
//     }
//     else{
//         passwordfield.type="password";
//         EyeIcon.classList.remove('fa-eye-slash');
//         EyeIcon.classList.add('fa-eye');
//     }
// });

const eyeIcon=document.getElementById('eye');

const passwordField=document.getElementById('login_password');

eyeIcon.addEventListener('click',()=>{
    if(passwordField.type ==="password"){
        passwordField.type="text";
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    }
    else{
        passwordField.type="password";
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
});

const signUpButton=document.getElementById('signUpButton');
const signInButton=document.getElementById('signInButton');
const signInForm=document.getElementById('Sign In');
const signUpForm=document.getElementById('Sign Up');
// const loginButton = document.getElementById("login_button");
/*const sign_UpButton=document.getElementById("signup_button");*/


// loginButton.addEventListener('click',()=>{
//     console.log("button clicked")
//     const form = document.querySelectorAll("input");
//     const emailid = document.getElementById("login_email");
//     const passwordid = document.getElementById("login_password");
//     sendLoginData(emailid.value, passwordid.value);
// })

// async function sendLoginData(username, password) {
//     const url = "http://localhost/my-api"; // Ensure this matches your API endpoint
//     const data = { username, password };

//     try {
//         const response = await fetch(url, {
//             method: "POST",
//             headers: {
//                 "Content-Type": "application/json"
//             },
//             body: JSON.stringify(data)
//         });

//         const result = await response.json();
//         console.log("Response:", result);

//         if (response.ok) {
//             alert("Login successful!"); // Replace with actual logic
//         } else {
//             alert("Error: " + result.error);
//         }
//     } catch (error) {
//         console.error("Request failed:", error);
//         alert("Failed to connect to the server.");
//     }
// }

signUpButton.addEventListener('click',function(){
    signInForm.style.display="none";
    signUpForm.style.display="block";
})
signInButton.addEventListener('click',function(){
    signInForm.style.display="block";
    signUpForm.style.display="none";
})


