import './bootstrap';
import * as bootstrap from 'bootstrap';
import * as simplebar from 'simplebar';

"use strict";

/**
 * jQueryRepeater
 */
$(document).ready(function () {
    $.fn.repeater = function (e) {
        var n = $.extend({
            structure: [],
            items: [],
            repeatElement: "structure",
            createElement: "createElement",
            removeElement: "removeElement",
            containerElement: "containerElement"
        }, e);
        this.find("#" + n.createElement).click(function () {
            var e = $("#" + n.repeatElement).clone(),
                t = e.find(":input"),
                r = [];
            $.each(t, function (e, n) {
                r.push({
                    id: $(n).attr("id-" + e),
                    value: ""
                }), $(n).attr("name", $(n).attr("name"))
            }), e.find("." + n.removeElement).click(function () {
                $(this).parent("div").parent("div").parent("div").remove(), void 0 !== n.onRemove && n.onRemove()
            }), e.show(), e.appendTo("#" + n.containerElement), void 0 !== n.onShow && n.onShow(), n.items.push(r)
        })
    }
});

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
