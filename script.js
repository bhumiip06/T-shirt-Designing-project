/*let inputEl=document.querySelector("input");
let showEl=document.querySelector(".fa-eye");
let hideEl=document.querySelector(".fa-eye-slash");

showEl.addEventListener("click",() =>{
    inputEl.type="text";
    hideEl.classList.remove("hide");
    showEl.classList.add("hide");
})

hideEl.addEventListener("click" ,() =>{
    inputEl.type="password";
    hideEl.classList.add("hide");
    showEl.classList.remove("hide");
})*/

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
