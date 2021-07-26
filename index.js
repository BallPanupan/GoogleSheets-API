function menu_1(){
    console.log("click menu of 1");
    document.getElementById("form-x").innerHTML = "";


    //load api to get form
    let form_1 = "";

    document.getElementById("form-x").append("Hello Form");
    
}

function menu_2(){
    console.log("click menu of 2");
    document.getElementById("form-x").innerHTML = "";
    
    document.getElementsByClassName("nav-link").classList.remove("active")

    document.getElementById("menu-2").classList.add("active")
    
}

function menu_3(){
    console.log("click menu of 3");
    document.getElementById("form-x").innerHTML = "";
}

function menu_4(){
    console.log("click menu of 3");
    document.getElementById("form-x").innerHTML = "";
}