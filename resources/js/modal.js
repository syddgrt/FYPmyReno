function openModal() {
    var modal = document.getElementById("collaborationModal");
    modal.classList.remove("hidden");
}

function closeModal() {
    var modal = document.getElementById("collaborationModal");
    modal.classList.add("hidden");
}

window.onclick = function(event) {
    var modal = document.getElementById("collaborationModal");
    if (event.target == modal) {
        modal.classList.add("hidden");
    }
}
