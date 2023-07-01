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

//Add function to update button
function addFunctionToUpdateButton() {
    document.getElementById("update-button").addEventListener("click", update);
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
    const password = document.getElementById("password");
    if (role === "Driver" || role === "Conductor") {
        password.value = "";
        password.disabled = true;
    } else {
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
                generateMessage("Error", "error");
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
    document.getElementById("update-user-id").value = user.user_id;

    document.getElementById("edit-modal-trigger").click();
}

//update user
function update() {
    let body = {};
    body.fname = document.getElementById("update-fname").value;
    body.lname = document.getElementById("update-lname").value;
    body.email = document.getElementById("update-email").value;
    body.role = document.getElementById("update-role").value;
    body.user_id = document.getElementById("update-user-id").value;
    body = JSON.stringify(body);

    const xhr = new XMLHttpRequest();
    xhr.open("post", "/user/update");
    xhr.onreadystatechange = function () {
        if (this.status == 200 && this.readyState == 4) {
            if (this.responseText == "success") {
                document.getElementById("edit-modal-trigger").click();
                generateMessage("Updated Successfully !", "success");
            } else {
                let response = JSON.parse(this.response);
                showErrors(response);
            }
        }
    };

    xhr.setRequestHeader(
        "X-CSRF-TOKEN",
        document.querySelector("meta[name='csrf-token']").content
    );
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(body);
}

//Show errors
function showErrors(response) {
    console.log(response);
    const error_tds = document.getElementsByClassName("error");
    for (let td of error_tds) {
        td.classList.add("expressway-hide");
    }
    if (response.fname != null) {
        error_tds[0].classList.remove("expressway-hide");
        error_tds[0].innerHTML = response.fname[0];
    }

    if (response.lname != null) {
        error_tds[1].classList.remove("expressway-hide");
        error_tds[1].innerHTML = response.lname[0];
    }

    if (response.email != null) {
        error_tds[2].classList.remove("expressway-hide");
        error_tds[2].innerHTML = response.email[0];
    }
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

addFunctionToUpdateButton();
