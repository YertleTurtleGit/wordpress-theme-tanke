//@ts-check
"use strict";

const HEADER_LOGO_ELEM = document.getElementById("header-logo");

if (HEADER_LOGO_ELEM != null) {
   window.addEventListener("scroll", scrolled);
   window.addEventListener("resize", scrolled);
}

function scrolled() {
   var lineHeight = window.scrollY * (1 / document.body.scrollHeight) * 50;
   HEADER_LOGO_ELEM.style.height =
      document.documentElement.scrollHeight.toString() + "px";
   HEADER_LOGO_ELEM.style.lineHeight = lineHeight.toString() + "vh";
}

console.log("custom js script loaded.");
