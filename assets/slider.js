!function i(c,n,o){function s(r,e){if(!n[r]){if(!c[r]){var t="function"==typeof require&&require;if(!e&&t)return t(r,!0);if(u)return u(r,!0);throw(t=new Error("Cannot find module '"+r+"'")).code="MODULE_NOT_FOUND",t}t=n[r]={exports:{}},c[r][0].call(t.exports,function(e){return s(c[r][1][e]||e)},t,t.exports,i,c,n,o)}return n[r].exports}for(var u="function"==typeof require&&require,e=0;e<o.length;e++)s(o[e]);return s}({1:[function(e,r,t){"use strict";function i(e){var r=document.querySelector(".ac-slider--view__slides.is-active"),t=Array.from(n).indexOf(r)+e+e,e=document.querySelector(".ac-slider--view__slides:nth-child(".concat(t,")"));u<t&&(e=document.querySelector(".ac-slider--view__slides:nth-child(1)")),e=e=0==t?document.querySelector(".ac-slider--view__slides:nth-child(".concat(u,")")):e,r.classList.remove("is-active"),e.classList.add("is-active"),c.setAttribute("style","transform:translateX(-"+e.offsetLeft+"px)")}var c=document.querySelector(".ac-slider--view > ul"),n=document.querySelectorAll(".ac-slider--view__slides"),o=document.querySelector(".ac-slider--arrows__left"),s=document.querySelector(".ac-slider--arrows__right"),u=n.length;s.addEventListener("click",function(){return i(1)}),o.addEventListener("click",function(){return i(0)})},{}]},{},[1]);
//# sourceMappingURL=slider.js.map