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

//Edit user
function edit(id) {
    const xhr = new XMLHttpRequest();
    xhr.open("get", `/trip?id=${id}`);
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

//Fill selections
function fillSelectionsOfEditModal(response) {
    const bus_id = document.getElementById("update-bus-id");
    const route_number = document.getElementById("update-route-number");
    const driver_id = document.getElementById("update-driver-id");
    const conductor_id = document.getElementById("update-conductor-id");

    for (let bus of response.buses) {
        const option = document.createElement("option");
        option.value = bus.registration_number;
        option.innerHTML = bus.registration_number;
        bus_id.appendChild(option);
    }

    for (let route of response.routes) {
        const option = document.createElement("option");
        option.value = route.route_number;
        option.innerHTML = route.route_number;
        route_number.appendChild(option);
    }

    for (let driver of response.drivers) {
        const option = document.createElement("option");
        option.value = driver.user_id;
        option.innerHTML = driver.user_id;
        driver_id.appendChild(option);
    }

    for (let conductor of response.conductors) {
        const option = document.createElement("option");
        option.value = conductor.user_id;
        option.innerHTML = conductor.user_id;
        conductor_id.appendChild(option);
    }

    console.log(conductor_id);
    return;
}

//Fill the edit modal
function fillEditModal(response) {
    fillSelectionsOfEditModal(response);
    // return;

    const modal = document.getElementById("trips-edit-modal");
    const errors = modal.querySelectorAll(".error");
    for (let error of errors) {
        error.classList.add("expressway-hide");
        error.innerHTML = "";
    }

    document.getElementById("update-bus-id").value = response.trip.bus_number;
    document.getElementById("update-start-at").value = response.trip.start_at;
    document.getElementById("update-start-from").value =
        response.trip.start_from;
    document.getElementById("update-start-from").value =
        response.trip.start_from;
    document.getElementById("update-destination").value =
        response.trip.destination;
    document.getElementById("update-route-number").value =
        response.trip.route_number;
    document.getElementById("update-driver-id").value = response.trip.driver_id;
    document.getElementById("update-conductor-id").value =
        response.trip.conductor_id;
    document.getElementById("update-trip-id").value = response.trip.id;

    document.getElementById("trips-edit-modal-trigger").click();
}

//update user
function update() {
    let body = {};
    body["bus-id"] = document.getElementById("update-bus-id").value;
    body["start-at"] = document.getElementById("update-start-at").value;
    body["start-from"] = document.getElementById("update-start-from").value;
    body.destination = document.getElementById("update-destination").value;
    body["route-number"] = document.getElementById("update-route-number").value;
    body["driver-id"] = document.getElementById("update-driver-id").value;
    body["conductor-id"] = document.getElementById("update-conductor-id").value;
    body.id = document.getElementById("update-trip-id").value;
    body = JSON.stringify(body);

    console.log(body);

    const xhr = new XMLHttpRequest();
    xhr.open("put", "/trip");
    xhr.onreadystatechange = function () {
        if (this.status == 200 && this.readyState == 4) {
            if (this.responseText == "success") {
                document.getElementById("trips-edit-modal-trigger").click();
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
    if (response["bus-id"] != null) {
        error_tds[0].classList.remove("expressway-hide");
        error_tds[0].innerHTML = response["bus-id"][0];
    }

    if (response["statrt-at"] != null) {
        error_tds[1].classList.remove("expressway-hide");
        error_tds[1].innerHTML = response["statrt-at"][0];
    }

    if (response["start-from"] != null) {
        error_tds[2].classList.remove("expressway-hide");
        error_tds[2].innerHTML = response["start-from"][0];
    }

    if (response.destination != null) {
        error_tds[3].classList.remove("expressway-hide");
        error_tds[3].innerHTML = response.destination[0];
    }

    if (response["route-number"] != null) {
        error_tds[3].classList.remove("expressway-hide");
        error_tds[3].innerHTML = response["route-number"][0];
    }
}

//Delete user
function remove(id) {
    const xhr = new XMLHttpRequest();
    xhr.open("delete", `/trip/${id}`);
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

addFunctionToEditButton();

addFunctionToDeleteButton();

addFunctionToOkButton();

addFunctionToUpdateButton();
