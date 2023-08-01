import './bootstrap';
import * as bootstrap from 'bootstrap';
import * as simplebar from 'simplebar';

"use strict";

if (document.body.classList.contains('.panel')) {
    /*
     * Sidebar
     */
    const sidebar = document.querySelector(".sidebar");
    const closeBtn = document.querySelector(".close");
    const sidebarBtn = document.querySelector(".menu-toggle");

    sidebarBtn.addEventListener("click", () => {
        sidebar.classList.toggle("toggled");
    });

    closeBtn.addEventListener("click", () => {
        sidebar.classList.toggle("toggled");
    });

    /*
     * Go To Top
     */
    let topBtn = document.getElementById("back-to-top");

    window.onscroll = function () {
        scrollFunction()
    };

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            topBtn.classList.add("show");
        } else {
            topBtn.classList.remove("show");
        }
    }
    topBtn.addEventListener("click", () => {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    });

}
