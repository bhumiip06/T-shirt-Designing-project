<<<<<<< HEAD
const eyeIcon=document.getElementById('eye');

const passwordField=document.getElementById('password');

eyeIcon.addEventListener('click',()=>{
    if(passwordField.type ==="password" && passwordField.value){
        passwordField.type="text";
        eyeIcon.classList.remove('fa-eye')
        eyeIcon.classList.add('fa-eye')
        eyeIcon.classList.add('fa-eye-slash')
    }
    else{
        passwordField.type="password";
        eyeIcon.classList.remove('fa-eye-slash')
        eyeIcon.classList.add('fa-eye')
    }
});
=======
let inputEl=document.getElementById("login_password");
let showEl=document.querySelector(".fa-eye");
let hideEl=document.querySelector(".fa-eye-slash");

showEl.addEventListener("click",() =>{
    inputEl.type="password";
    hideEl.classList.remove("hide");
    showEl.classList.add("hide");
    
})

hideEl.addEventListener("click" ,() =>{
    inputEl.type="text";
    hideEl.classList.add("hide");
    showEl.classList.remove("hide");
    // console.log(inputEl);
})
>>>>>>> 0b6697018430470c4bf1dfd763ff027c2ffa9aec

const signUpButton=document.getElementById('signUpButton');
const signInButton=document.getElementById('signInButton');
const signInForm=document.getElementById('Sign In');
const signUpForm=document.getElementById('Sign Up');
const loginButton = document.getElementById("login_button");
/*const sign_UpButton=document.getElementById("signup_button");*/


loginButton.addEventListener('click',()=>{
    console.log("button clicked")
    const form = document.querySelectorAll("input");
    const emailid = document.getElementById("login_email");
    const passwordid = document.getElementById("login_password");
    sendLoginData(emailid.value, passwordid.value);
})

async function sendLoginData(username, password) {
    const url = "http://localhost/my-api"; // Ensure this matches your API endpoint
    const data = { username, password };

    try {
        const response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        console.log("Response:", result);

        if (response.ok) {
            alert("Login successful!"); // Replace with actual logic
        } else {
            alert("Error: " + result.error);
        }
    } catch (error) {
        console.error("Request failed:", error);
        alert("Failed to connect to the server.");
    }
}

signUpButton.addEventListener('click',function(){
    signInForm.style.display="none";
    signUpForm.style.display="block";
})
signInButton.addEventListener('click',function(){
    signInForm.style.display="block";
    signUpForm.style.display="none";
})


