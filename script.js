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
