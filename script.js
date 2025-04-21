const form =document.querySelector("form");

form.addEventListener("submit",(e) => {
    e.preventDefault;
 //do nothing if form not validated
    if(!validateForm(form)) return;
})

const validateForm =(from) => {
    let valid=true;
    //check for empty fields
    let name =form.querySelector
}



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

        //create a new Fabric.js canvas and center objects by default
        const canvas = new fabric.Canvas("tshirt-canvas");

        fabric.Image.fromURL('images/t-shirt template.jpg', function(img) {
            img.scaleToWidth(canvas.width);
            canvas.setBackgroundImage(img, function() {
                // Lock background
                canvas.backgroundImage.selectable = false;
                canvas.backgroundImage.evented = false;
                
                canvas.renderAll();

                // Now safe to export
                const dataURL = canvas.toDataURL({
                    format: 'png',
                    quality: 1
                });
            }, {
                originX: 'left',
                originY: 'top'
           });
        });
        //cliparts
        const clipartImages=[
            "cliparts/clipart1.png",
            "cliparts/clipart2.png",
            "cliparts/clipart3.png",
            "cliparts/clipart4.png",
            "cliparts/clipart5.png",
            "cliparts/clipart6.png",
            "cliparts/clipart7.png",
            "cliparts/clipart8.png",
            "cliparts/clipart9.png",
            "cliparts/clipart10.png",
            "cliparts/clipart11.png",
            "cliparts/clipart12.png",
            "cliparts/clipart13.png",
            "cliparts/clipart14.png",
            "cliparts/clipart15.png",
            "cliparts/clipart16.png",
            "cliparts/clipart17.png",
            "cliparts/clipart18.png",
            "cliparts/clipart19.png",
            "cliparts/clipart20.png"
        ];

        const gallery=document.querySelector(".clipart-gallery");
        clipartImages.forEach(clipart=>{
            const imgElement=document.createElement("img");
            imgElement.src =clipart;
            imgElement.alt="Clipart";
            imgElement.onclick=() =>insertClipart(clipart);
            gallery.appendChild(imgElement);
        });

        function insertClipart(clipartPath) {
            fabric.Image.fromURL(clipartPath, function(img) {
                const canvasWidth=canvas.width;
                const canvasHeight=canvas.height;

                const scaleX = canvasWidth / img.width;
                const scaleY = canvasHeight / img.height;
                const scale = Math.min(scaleX, scaleY);

                img.scale(scale);  // Scale the image to fit the canvas

                // Calculate the center position (canvas center minus half of the image width/height)
                const centerX = (canvasWidth - img.width * img.scaleX) / 2;
                const centerY = (canvasHeight - img.height * img.scaleY) / 2;

                // Set the image's position to the center
                img.set({
                    left: centerX,
                    top: centerY
                });

                // Add the image to the canvas
                canvas.add(img);
                canvas.setActiveObject(img);
                canvas.renderAll(); 
            });
        }

        // listen for textbox insertion 
        document.getElementById("addText").addEventListener('click', function(){
            const text = new fabric.Textbox('Your Text Here', {
                fontsize: 30,
                fill: 'black',
                left: 100,
                top: 100,
                width: 200,
                selectionColor:"rgba(0,0,0,0.5)",
                fontFamily:"Calibri"
            });
            canvas.add(text);
            canvas.setActiveObject(text);
            
            // Listen for font change
            document.getElementById("fontSelect").addEventListener('change', function () {
                var activeObject = canvas.getActiveObject();
                if(activeObject && activeObject.type === 'textbox') {
                    activeObject.set({ fontFamily: this.value });
                    canvas.renderAll();//update canvas rendering
                }
            });

            //listen for text color change
            document.getElementById("color").addEventListener("change", function(){
                var activeObject=canvas.getActiveObject();
                console.log("Active Object:",activeObject);
                if(activeObject && activeObject.type === 'textbox') {
                    activeObject.set({fill: this.value});
                    canvas.renderAll();//update canvas rendering
                }
            });

            //listen for font size change
            document.getElementById("fontSize").addEventListener("change", function(){
                var activeObject=canvas.getActiveObject();
                console.log("Active Object: ",activeObject);
                if(activeObject && activeObject.type==='textbox') {
                    activeObject.set({fontSize: this.value});
                    canvas.renderAll();//update canvas rendering
                }
            });

            //listen for font style change
            document.getElementById("fontStyle").addEventListener("change", function(){
                var activeObject=canvas.getActiveObject();
                console.log("Active Object:",activeObject);
                if(activeObject && activeObject.type === 'textbox') {
                    activeObject.set({fontStyle: this.value});
                    canvas.renderAll();//update canvas rendering
                }
            });

        });

        //listen for image upload
       document.getElementById("imageupload") .addEventListener('change',function(event){
            // var activeObject=canvas.getActiveObject();
            const file =event.target.files[0]; //to get the selected image file
            if(file){
                const reader=new FileReader();
                reader.onload =function(e){
                    const imageUrl =e.target.result;// to get the data url of image

                    //create a fabric.js image from the url and add it to the canvas
                    fabric.Image.fromURL(imageUrl,function(img){
                        const canvasWidth=canvas.width;
                        const canvasHeight=canvas.height;

                        //calculating the scale factor to make the image smaller than the canvas 
                        const scaleX=canvasWidth/img.width;
                        const scaleY=canvasHeight/img.height;
                        const scale=Math.min(scaleX,scaleY);//calculete the smaller scale factor to fit the image within the canvas

                        img.scale(scale);

                        //for positioning the image in the center
                        img.set({
                            left:(canvasWidth-img.width)/2,
                            top: (canvasHeight-img.height)/2,
                          
                        });
                        //finally adding the image to the canvas
                        canvas.add(img);
                        canvas.renderAll(); //update canvas rendering

                    });
                };
                reader.readAsDataURL(file);
            }
       });

        //delete icon for deleting selected object
        const deleteIcon=document.getElementById('delete-icon');

        canvas.on('selection:created',showDeleteIcon);
        canvas.on('selection:updated',showDeleteIcon);
        canvas.on('selection:cleared',()=>{
            deleteIcon.style.display='none';
        });

        //function for showing delete icon
        function showDeleteIcon(e) {
            const activeObject = e.selected[0];
            if (activeObject) {
                const canvasRect = canvas.getElement().getBoundingClientRect();
                const objectCoords = canvas.getAbsoluteCoords(activeObject);
                
                deleteIcon.style.left = `${canvasRect.left + objectCoords.left + activeObject.width * activeObject.scaleX}px`;
                deleteIcon.style.top = `${canvasRect.top + objectCoords.top - 20}px`;
                deleteIcon.style.display = 'block';
            }
        }

        fabric.Canvas.prototype.getAbsoluteCoords = function(object) {
            return {
                left: object.left * this.getZoom() + this.viewportTransform[4],
                top: object.top * this.getZoom() + this.viewportTransform[5]
            };
        };

        deleteIcon.addEventListener('click', function() {
            const activeObject = canvas.getActiveObject();
            if (activeObject) {
                canvas.remove(activeObject);
                canvas.discardActiveObject();
                deleteIcon.style.display = 'none';
                canvas.requestRenderAll();
            }
        });
        //clears the whole canvas
        document.getElementById("clearDesign").addEventListener('click', function(){
                canvas.clear();
            });

            //function for downloading designs
            function saveDesign(){
                const link=document.createElement('a');
                link.download='tshirt_design.png';
                link.href=canvas.toDataURL('image/png');
                link.click();
                
            }
            //download design 
            document.getElementById("downloadDesign").addEventListener("click", function() {
            // Remove active selection before downloading to avoid borders
            canvas.discardActiveObject();
            canvas.renderAll();

            const dataURL = canvas.toDataURL({
                format: "png",
                quality: 1.0
            });

            // Create a temporary anchor to trigger the download
            const link = document.createElement("a");
            link.href = dataURL;
            link.download = "tshirt_design.png";
            link.click();
        });



