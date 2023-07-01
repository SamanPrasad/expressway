//Add function to role selection
function addFunctionToRoleSelection() {
    document.getElementById("role").addEventListener("change", function () {
        activateInputFields(event);
    });
}

//Add function to edit button
function addFunctionToEditButton() {
    let edit_btns = document.getElementsByClassName("edit");
    for (let btn of edit_btns) {
        btn.addEventListener("click", function () {
            edit(btn.dataset.id);
        });
    }
}

//Add function to delete button
function addFunctionToDeleteButton() {
    let edit_btns = document.getElementsByClassName("delete");
    for (let btn of edit_btns) {
        btn.addEventListener("click", function () {
            remove(btn.dataset.id);
        });
    }
}

//Add function to ok button of modal
function addFunctionToOkButton() {
    document.getElementById("ok-btn").addEventListener("click", function () {
        location.reload();
    });
}

//Activate inputfields based on the role
function activateInputFields(event) {
    const role = event.currentTarget.value;
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    if (role === "Driver" || role === "Conductor") {
        email.value = "";
        email.disabled = true;
        password.value = "";
        password.disabled = true;
    } else {
        email.disabled = false;
        password.disabled = false;
    }
}

//Edit user
function edit(id) {
    const xhr = new XMLHttpRequest();
    xhr.open("get", `/user?id=${id}`);
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                let response = JSON.parse(this.response);
                fillEditModal(response);
            } catch (e) {
                console.log("error");
            }
        }
    };
    xhr.setRequestHeader(
        "X-CSRF-TOKEN",
        document.querySelector("meta[name='csrf-token']").content
    );
    xhr.send();
}

//Fill the edit modal
function fillEditModal(response) {
    const modal = document.getElementById("edit-modal");
    const user = response.user;
    const roles = response.roles;

    console.log(roles);
    console.log(user);

    const roles_select = document.getElementById("update-role");
    roles_select.innerHTML = "";
    for (let role of roles) {
        const option = document.createElement("option");
        option.value = role;
        option.innerHTML = role;
        if (user.role === role) {
            option.selected = true;
        }
        roles_select.appendChild(option);
    }

    document.getElementById("update-fname").value = user.first_name;
    document.getElementById("update-lname").value = user.last_name;
    document.getElementById("update-email").value = user.email;
    document.getElementById("update-email").value = user.email;

    document.getElementById("edit-modal-trigger").click();
}

//Delete user
function remove(id) {
    const xhr = new XMLHttpRequest();
    xhr.open("delete", `/user/${id}`);
    xhr.onreadystatechange = function () {
        if (this.status == 200 && this.readyState == 4) {
            if (this.responseText == "success") {
                generateMessage("Deleted Successfully !", "success");
            }
        } else {
            generateMessage("Error occured !", "error");
            console.log(this.responseText);
        }
    };
    xhr.setRequestHeader(
        "x-CSRF-TOKEN",
        document.querySelector("meta[name='csrf-token'").content
    );
    xhr.send();
}

//Generate message
function generateMessage(message, status) {
    const content = document.getElementById("exampleModalLabel");
    const btn = document.getElementById("ok-btn");

    content.innerText = message;

    if (status === "success") {
        content.classList.remove("expressway-error");
        content.classList.add("expressway-success");
        btn.classList.remove("btn-danger");
        btn.classList.add("btn-success");
    } else {
        content.classList.add("expressway-error");
        content.classList.remove("expressway-success");
        btn.classList.add("btn-danger");
        btn.classList.remove("btn-success");
    }

    document.getElementById("message-modal-trigger").click();
}

addFunctionToRoleSelection();

addFunctionToEditButton();

addFunctionToDeleteButton();

addFunctionToOkButton();
