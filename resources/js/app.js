import "./bootstrap";
import _ from "lodash";
import "preline";
import "preline/src/plugins/datepicker";
import "preline/src/plugins/overlay";

window._ = _;

document.addEventListener("livewire:navigated", () => {
    window.HSStaticMethods.autoInit();
});

// document.addEventListener("DOMContentLoaded", () => {
//     // Cek apakah global-nya ada
//     console.log("HSOverlay global:", window.HSOverlay);
//     console.log("HSDatepicker global:", window.HSDatepicker);

//     // Programmatic control (contoh)
//     const modalEl = document.getElementById(
//         "hs-vertically-centered-scrollable-modal"
//     );
//     const openBtn = document.getElementById("open-btn");

//     if (modalEl && openBtn && window.HSOverlay) {
//         const modal = new window.HSOverlay(modalEl);
//         openBtn.addEventListener("click", () => modal.open());
//     }
// });
