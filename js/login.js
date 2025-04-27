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

signUpButton.addEventListener('click',function(){
    signInForm.style.display="none";
    signUpForm.style.display="block";
})
signInButton.addEventListener('click',function(){
    signInForm.style.display="block";
    signUpForm.style.display="none";
})
