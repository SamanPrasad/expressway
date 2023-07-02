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
    document
        .getElementsByClassName("update-button")[0]
        .addEventListener("click", update);
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
    document
        .getElementsByClassName("ok-btn")[0]
        .addEventListener("click", function () {
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
    const errors = modal.querySelectorAll(".error");
    for (let error of errors) {
        error.classList.add("expressway-hide");
        error.innerHTML = "";
    }

    document.getElementById("update-fname").value = response.first_name;
    document.getElementById("update-lname").value = response.last_name;
    document.getElementById("update-email").value = response.email;
    document.getElementById("update-user-id").value = response.user_id;

    document.getElementById("edit-modal-trigger").click();
}

//update user
function update() {
    let body = {};
    body.fname = document.getElementById("update-fname").value;
    body.lname = document.getElementById("update-lname").value;
    body.email = document.getElementById("update-email").value;
    body.user_id = document.getElementById("update-user-id").value;
    body = JSON.stringify(body);

    const xhr = new XMLHttpRequest();
    xhr.open("put", "/user");
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
    const content = document.getElementsByClassName("message-content")[0];
    const btn = document.getElementsByClassName("ok-btn")[0];

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

    document.getElementsByClassName("message-modal-trigger")[0].click();
}

addFunctionToRoleSelection();

addFunctionToEditButton();

addFunctionToDeleteButton();

addFunctionToOkButton();

addFunctionToUpdateButton();
