// declaring and initialising variables
let uname=document.getElementById("username");
let pwd=document.getElementById("password");
let email=document.getElementById("email");
let name=document.getElementById("name");
let dept=document.getElementById("department");
let yos=document.getElementById("year");


let signupBtn=document.getElementById("signupBtn");

signupBtn.addEventListener("click",function(event){
    let uvalue=uname.value;
    let pvalue=pwd.value;
    let evalue=email.value;
    let nvalue=name.value;
    let dvalue=dept.value;
    let yvalue=yos.value;

    var file = document.getElementById('profile-pic').files[0];
    // check if uvalue and pvalue are not empty
    if(!uvalue || !pvalue || !evalue || !nvalue || !dvalue || !yvalue){
        alert("Please donot leave any field empty!");
        event.preventDefault(); 
    }
    else if(!validateEmail(evalue)){
        alert("Please enter a valid Sahyadri email address!");
        event.preventDefault(); 
    }
    else if(!validatePassword(pvalue)){
        alert("Please enter a password with atleast 8 charcters with atleast 1 uppercase,1 lowercase,1 special character");   
        event.preventDefault();  
    }
    else if (file.size > 1000000) {
        alert("Please upload a file less than 1MB!");
        event.preventDefault(); 

        }
}
);

// validation of password and email
function validatePassword(password){
        const regex2 = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/;

        if (!regex2.test(password)) {
        return false;
        }
        else {
        return true;
        }

    }

    function validateEmail(email){
        const regex1= /^[a-zA-Z0-9.-]+@sahyadri\.edu\.in$/;

        if (!regex1.test(email)) {
        return false;
        }
        else {
        return true;
        }

    }