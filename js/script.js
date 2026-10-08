function confirmBooking() {
    return confirm("Are you sure you want to book this appointment?");
}

function confirmDelete() {
    return confirm("Are you sure you want to delete this?");
}

function validateForm() {
    alert("Form submitted successfully!");
    return true;
}

function validateLogin() {
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;

    if (email == "" || password == "") {
        alert("Please enter email and password");
        return false;
    }

    return true;
}

function validateRegister() {
    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let phone = document.getElementById("phone").value;
    let password = document.getElementById("password").value;

    if (name == "" || email == "" || phone == "" || password == "") {
        alert("Please fill all required fields");
        return false;
    }

    return true;
}