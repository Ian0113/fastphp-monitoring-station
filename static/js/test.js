function triggerNav() {
    var x = document.getElementById("navb-main");
    if (x.className === "main") {
        x.className += " trig";
    } else {
        x.className = "main";
    }
}

// 當btn按下時 讀取data-modal-btn屬性 連接至modal.id
function addModal(elem) {
    let modal = document.getElementById(elem.getAttribute("data-modal-btn"));
    modal.style.display = "block";
}
// 當modal.id == modal.data-modal時 代表此物件為modal
window.onclick = function (event) {
    if (event.target.id == event.target.getAttribute("data-modal")) {
        event.target.style.display = "none";
    }
}
