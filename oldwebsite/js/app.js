/*!
 * Bootstrap v3.3.7 (http://getbootstrap.com)
 * Copyright 2011-2017 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */

/*!
 * Generated using the Bootstrap Customizer (https://getbootstrap.com/docs/3.3/customize/?id=523a6460ef8c046acc7513e82cf3b2f7)
 * Config saved to config.json and https://gist.github.com/523a6460ef8c046acc7513e82cf3b2f7
 */
if("undefined"==typeof jQuery)throw new Error("Bootstrap's JavaScript requires jQuery");+function(t){"use strict";var n=t.fn.jquery.split(" ")[0].split(".");if(n[0]<2&&n[1]<9||1==n[0]&&9==n[1]&&n[2]<1||n[0]>3)throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher, but lower than version 4")}(jQuery),+function(t){"use strict";function n(n){var e=n.attr("data-target");e||(e=n.attr("href"),e=e&&/#[A-Za-z]/.test(e)&&e.replace(/.*(?=#[^\s]*$)/,""));var i=e&&t(e);return i&&i.length?i:n.parent()}function e(e){e&&3===e.which||(t(r).remove(),t(o).each(function(){var i=t(this),r=n(i),o={relatedTarget:this};r.hasClass("open")&&(e&&"click"==e.type&&/input|textarea/i.test(e.target.tagName)&&t.contains(r[0],e.target)||(r.trigger(e=t.Event("hide.bs.dropdown",o)),e.isDefaultPrevented()||(i.attr("aria-expanded","false"),r.removeClass("open").trigger(t.Event("hidden.bs.dropdown",o)))))}))}function i(n){return this.each(function(){var e=t(this),i=e.data("bs.dropdown");i||e.data("bs.dropdown",i=new a(this)),"string"==typeof n&&i[n].call(e)})}var r=".dropdown-backdrop",o='[data-toggle="dropdown"]',a=function(n){t(n).on("click.bs.dropdown",this.toggle)};a.VERSION="3.3.7",a.prototype.toggle=function(i){var r=t(this);if(!r.is(".disabled, :disabled")){var o=n(r),a=o.hasClass("open");if(e(),!a){"ontouchstart"in document.documentElement&&!o.closest(".navbar-nav").length&&t(document.createElement("div")).addClass("dropdown-backdrop").insertAfter(t(this)).on("click",e);var s={relatedTarget:this};if(o.trigger(i=t.Event("show.bs.dropdown",s)),i.isDefaultPrevented())return;r.trigger("focus").attr("aria-expanded","true"),o.toggleClass("open").trigger(t.Event("shown.bs.dropdown",s))}return!1}},a.prototype.keydown=function(e){if(/(38|40|27|32)/.test(e.which)&&!/input|textarea/i.test(e.target.tagName)){var i=t(this);if(e.preventDefault(),e.stopPropagation(),!i.is(".disabled, :disabled")){var r=n(i),a=r.hasClass("open");if(!a&&27!=e.which||a&&27==e.which)return 27==e.which&&r.find(o).trigger("focus"),i.trigger("click");var s=" li:not(.disabled):visible a",d=r.find(".dropdown-menu"+s);if(d.length){var l=d.index(e.target);38==e.which&&l>0&&l--,40==e.which&&l<d.length-1&&l++,~l||(l=0),d.eq(l).trigger("focus")}}}};var s=t.fn.dropdown;t.fn.dropdown=i,t.fn.dropdown.Constructor=a,t.fn.dropdown.noConflict=function(){return t.fn.dropdown=s,this},t(document).on("click.bs.dropdown.data-api",e).on("click.bs.dropdown.data-api",".dropdown form",function(t){t.stopPropagation()}).on("click.bs.dropdown.data-api",o,a.prototype.toggle).on("keydown.bs.dropdown.data-api",o,a.prototype.keydown).on("keydown.bs.dropdown.data-api",".dropdown-menu",a.prototype.keydown)}(jQuery),+function(t){"use strict";function n(n){var e,i=n.attr("data-target")||(e=n.attr("href"))&&e.replace(/.*(?=#[^\s]+$)/,"");return t(i)}function e(n){return this.each(function(){var e=t(this),r=e.data("bs.collapse"),o=t.extend({},i.DEFAULTS,e.data(),"object"==typeof n&&n);!r&&o.toggle&&/show|hide/.test(n)&&(o.toggle=!1),r||e.data("bs.collapse",r=new i(this,o)),"string"==typeof n&&r[n]()})}var i=function(n,e){this.$element=t(n),this.options=t.extend({},i.DEFAULTS,e),this.$trigger=t('[data-toggle="collapse"][href="#'+n.id+'"],[data-toggle="collapse"][data-target="#'+n.id+'"]'),this.transitioning=null,this.options.parent?this.$parent=this.getParent():this.addAriaAndCollapsedClass(this.$element,this.$trigger),this.options.toggle&&this.toggle()};i.VERSION="3.3.7",i.TRANSITION_DURATION=350,i.DEFAULTS={toggle:!0},i.prototype.dimension=function(){var t=this.$element.hasClass("width");return t?"width":"height"},i.prototype.show=function(){if(!this.transitioning&&!this.$element.hasClass("in")){var n,r=this.$parent&&this.$parent.children(".panel").children(".in, .collapsing");if(!(r&&r.length&&(n=r.data("bs.collapse"),n&&n.transitioning))){var o=t.Event("show.bs.collapse");if(this.$element.trigger(o),!o.isDefaultPrevented()){r&&r.length&&(e.call(r,"hide"),n||r.data("bs.collapse",null));var a=this.dimension();this.$element.removeClass("collapse").addClass("collapsing")[a](0).attr("aria-expanded",!0),this.$trigger.removeClass("collapsed").attr("aria-expanded",!0),this.transitioning=1;var s=function(){this.$element.removeClass("collapsing").addClass("collapse in")[a](""),this.transitioning=0,this.$element.trigger("shown.bs.collapse")};if(!t.support.transition)return s.call(this);var d=t.camelCase(["scroll",a].join("-"));this.$element.one("bsTransitionEnd",t.proxy(s,this)).emulateTransitionEnd(i.TRANSITION_DURATION)[a](this.$element[0][d])}}}},i.prototype.hide=function(){if(!this.transitioning&&this.$element.hasClass("in")){var n=t.Event("hide.bs.collapse");if(this.$element.trigger(n),!n.isDefaultPrevented()){var e=this.dimension();this.$element[e](this.$element[e]())[0].offsetHeight,this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded",!1),this.$trigger.addClass("collapsed").attr("aria-expanded",!1),this.transitioning=1;var r=function(){this.transitioning=0,this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse")};return t.support.transition?void this.$element[e](0).one("bsTransitionEnd",t.proxy(r,this)).emulateTransitionEnd(i.TRANSITION_DURATION):r.call(this)}}},i.prototype.toggle=function(){this[this.$element.hasClass("in")?"hide":"show"]()},i.prototype.getParent=function(){return t(this.options.parent).find('[data-toggle="collapse"][data-parent="'+this.options.parent+'"]').each(t.proxy(function(e,i){var r=t(i);this.addAriaAndCollapsedClass(n(r),r)},this)).end()},i.prototype.addAriaAndCollapsedClass=function(t,n){var e=t.hasClass("in");t.attr("aria-expanded",e),n.toggleClass("collapsed",!e).attr("aria-expanded",e)};var r=t.fn.collapse;t.fn.collapse=e,t.fn.collapse.Constructor=i,t.fn.collapse.noConflict=function(){return t.fn.collapse=r,this},t(document).on("click.bs.collapse.data-api",'[data-toggle="collapse"]',function(i){var r=t(this);r.attr("data-target")||i.preventDefault();var o=n(r),a=o.data("bs.collapse"),s=a?"toggle":r.data();e.call(o,s)})}(jQuery),+function(t){"use strict";function n(){var t=document.createElement("bootstrap"),n={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"};for(var e in n)if(void 0!==t.style[e])return{end:n[e]};return!1}t.fn.emulateTransitionEnd=function(n){var e=!1,i=this;t(this).one("bsTransitionEnd",function(){e=!0});var r=function(){e||t(i).trigger(t.support.transition.end)};return setTimeout(r,n),this},t(function(){t.support.transition=n(),t.support.transition&&(t.event.special.bsTransitionEnd={bindType:t.support.transition.end,delegateType:t.support.transition.end,handle:function(n){return t(n.target).is(this)?n.handleObj.handler.apply(this,arguments):void 0}})})}(jQuery);

/*!
 hey, [be]Lazy.js - v1.8.2 - 2016.10.25
 A fast, small and dependency free lazy load script (https://github.com/dinbror/blazy)
 (c) Bjoern Klinggaard - @bklinggaard - http://dinbror.dk/blazy
 */
(function(q, m){"function" === typeof define && define.amd?define(m):"object" === typeof exports?module.exports = m():q.Blazy = m()})(this, function(){function q(b){var c = b._util; c.elements = E(b.options); c.count = c.elements.length; c.destroyed && (c.destroyed = !1, b.options.container && l(b.options.container, function(a){n(a, "scroll", c.validateT)}), n(window, "resize", c.saveViewportOffsetT), n(window, "resize", c.validateT), n(window, "scroll", c.validateT)); m(b)}function m(b){for (var c = b._util, a = 0; a < c.count; a++){var d = c.elements[a], e; a:{var g = d; e = b.options; var p = g.getBoundingClientRect(); if (e.container && y && (g = g.closest(e.containerClass))){g = g.getBoundingClientRect(); e = r(g, f)?r(p, {top:g.top - e.offset, right:g.right + e.offset, bottom:g.bottom + e.offset, left:g.left - e.offset}):!1; break a}e = r(p, f)}if (e || t(d, b.options.successClass))b.load(d), c.elements.splice(a, 1), c.count--, a--}0 === c.count && b.destroy()}function r(b, c){return b.right >= c.left && b.bottom >= c.top && b.left <= c.right && b.top <= c.bottom}function z(b, c, a){if (!t(b, a.successClass) && (c || a.loadInvisible || 0 < b.offsetWidth && 0 < b.offsetHeight))if (c = b.getAttribute(u) || b.getAttribute(a.src)){c = c.split(a.separator); var d = c[A && 1 < c.length?1:0], e = b.getAttribute(a.srcset), g = "img" === b.nodeName.toLowerCase(), p = (c = b.parentNode) && "picture" === c.nodeName.toLowerCase(); if (g || void 0 === b.src){var h = new Image, w = function(){a.error && a.error(b, "invalid"); v(b, a.errorClass); k(h, "error", w); k(h, "load", f)}, f = function(){g?p || B(b, d, e):b.style.backgroundImage = 'url("' + d + '")'; x(b, a); k(h, "load", f); k(h, "error", w)}; p && (h = b, l(c.getElementsByTagName("source"), function(b){var c = a.srcset, e = b.getAttribute(c); e && (b.setAttribute("srcset", e), b.removeAttribute(c))})); n(h, "error", w); n(h, "load", f); B(h, d, e)} else b.src = d, x(b, a)} else"video" === b.nodeName.toLowerCase()?(l(b.getElementsByTagName("source"), function(b){var c = a.src, e = b.getAttribute(c); e && (b.setAttribute("src", e), b.removeAttribute(c))}), b.load(), x(b, a)):(a.error && a.error(b, "missing"), v(b, a.errorClass))}function x(b, c){v(b, c.successClass); c.success && c.success(b); b.removeAttribute(c.src); b.removeAttribute(c.srcset); l(c.breakpoints, function(a){b.removeAttribute(a.src)})}function B(b, c, a){a && b.setAttribute("srcset", a); b.src = c}function t(b, c){return - 1 !== (" " + b.className + " ").indexOf(" " + c + " ")}function v(b, c){t(b, c) || (b.className += " " + c)}function E(b){var c = []; b = b.root.querySelectorAll(b.selector); for (var a = b.length; a--; c.unshift(b[a])); return c}function C(b){f.bottom = (window.innerHeight || document.documentElement.clientHeight) + b; f.right = (window.innerWidth || document.documentElement.clientWidth) + b}function n(b, c, a){b.attachEvent?b.attachEvent && b.attachEvent("on" + c, a):b.addEventListener(c, a, {capture:!1, passive:!0})}function k(b, c, a){b.detachEvent?b.detachEvent && b.detachEvent("on" + c, a):b.removeEventListener(c, a, {capture:!1, passive:!0})}function l(b, c){if (b && c)for (var a = b.length, d = 0; d < a && !1 !== c(b[d], d); d++); }function D(b, c, a){var d = 0; return function(){var e = + new Date; e - d < c || (d = e, b.apply(a, arguments))}}var u, f, A, y; return function(b){if (!document.querySelectorAll){var c = document.createStyleSheet(); document.querySelectorAll = function(a, b, d, h, f){f = document.all; b = []; a = a.replace(/\[for\b/gi, "[htmlFor").split(","); for (d = a.length; d--; ){c.addRule(a[d], "k:v"); for (h = f.length; h--; )f[h].currentStyle.k && b.push(f[h]); c.removeRule(0)}return b}}var a = this, d = a._util = {}; d.elements = []; d.destroyed = !0; a.options = b || {}; a.options.error = a.options.error || !1; a.options.offset = a.options.offset || 100; a.options.root = a.options.root || document; a.options.success = a.options.success || !1; a.options.selector = a.options.selector || ".b-lazy"; a.options.separator = a.options.separator || "|"; a.options.containerClass = a.options.container; a.options.container = a.options.containerClass?document.querySelectorAll(a.options.containerClass):!1; a.options.errorClass = a.options.errorClass || "b-error"; a.options.breakpoints = a.options.breakpoints || !1; a.options.loadInvisible = a.options.loadInvisible || !1; a.options.successClass = a.options.successClass || "b-loaded"; a.options.validateDelay = a.options.validateDelay || 25; a.options.saveViewportOffsetDelay = a.options.saveViewportOffsetDelay || 50; a.options.srcset = a.options.srcset || "data-srcset"; a.options.src = u = a.options.src || "data-src"; y = Element.prototype.closest; A = 1 < window.devicePixelRatio; f = {}; f.top = 0 - a.options.offset; f.left = 0 - a.options.offset; a.revalidate = function(){q(a)}; a.load = function(a, b){var c = this.options; void 0 === a.length?z(a, b, c):l(a, function(a){z(a, b, c)})}; a.destroy = function(){var a = this._util; this.options.container && l(this.options.container, function(b){k(b, "scroll", a.validateT)}); k(window, "scroll", a.validateT); k(window, "resize", a.validateT); k(window, "resize", a.saveViewportOffsetT); a.count = 0; a.elements.length = 0; a.destroyed = !0}; d.validateT = D(function(){m(a)}, a.options.validateDelay, a); d.saveViewportOffsetT = D(function(){C(a.options.offset)}, a.options.saveViewportOffsetDelay, a); C(a.options.offset); l(a.options.breakpoints, function(a){if (a.width >= window.screen.width)return u = a.src, !1}); setTimeout(function(){q(a)})}});

/*$(".b-lazy").each(function(index, item){
    var elem$ = $(item);
    var src = elem$.attr("data-src");
    var newSrc = "/image.php?w="+elem$.width()+"&h="+elem$.height()+"&img="+src;
    elem$.attr("data-src", newSrc);
});*/

var bLazy = new Blazy({
        // Options
        });
 
function postResized(item) {
    var postElem = $(item);
    var contentElem = $(".text-container", item);
    var readmoreElem = $(".readmore", item);
    var hide = false;
    hide = (postElem.height() >= contentElem.height());
    //console.log("postHeight="+postElem.height()+", contentElem.height="+contentElem.height()+"; hide="+hide);
    //console.log(contentElem);
    if(hide) readmoreElem.hide();
    else readmoreElem.show();
}
 
$(document).ready(function() {
    $(".post").each(function(index, item) {
        postResized(item);
    });
});

$(window).on('load', function() {
    $(".post").each(function(index, item) {
        postResized(item);
    });
});

$(window).on('resize', function() {
    $(".post").each(function(index, item) {
        postResized(item);
    });
});

/*
 * E-mail protection:
 */

$(document).ready(function() {
    $(".addr-protection").each(function(index, item) {
        $(item).text(atob($(item).data('enc')));
        $(item).data('enc', '');
        $(item).removeClass('addr-protection');
    });
});

/*$(document).ready(function() {
    $('*').filter(function(){
        var position = $(this).css('position');
        return position === 'relative';
    }).each(function(index, item) {
        $(item).css('-webkit-transform', 'translate3d(0,0,0)');
        console.log($(item).css('webkit-transform'));
    });
});*/