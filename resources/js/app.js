import "./bootstrap";

document.addEventListener("DOMContentLoaded", () => {
    console.log("DOM Dimuat");
});
document.addEventListener("livewire:navigated", () => {
    console.log("Ternavigasi");
});
