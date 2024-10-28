"use strict";
function _classCallCheck(t, e) {
    if (!(t instanceof e))
        throw new TypeError("Cannot call a class as a function");
}
function _defineProperties(t, e) {
    for (var s = 0; s < e.length; s++) {
        var i = e[s];
        (i.enumerable = i.enumerable || !1),
            (i.configurable = !0),
            "value" in i && (i.writable = !0),
            Object.defineProperty(t, i.key, i);
    }
}
function _createClass(t, e, s) {
    return (
        e && _defineProperties(t.prototype, e),
        s && _defineProperties(t, s),
        Object.defineProperty(t, "prototype", { writable: !1 }),
        t
    );
}
var Wizard = (function () {
    function s(t) {
        var e =
            1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : {};
        _classCallCheck(this, s),
            t instanceof HTMLElement
                ? (this.wizard = t)
                : (this.wizard = document.querySelector(t)),
            (this.validate = null !== (t = e.validate) && void 0 !== t && t),
            (this.buttons = null !== (t = e.buttons) && void 0 !== t && t),
            (this.progress = null !== (e = e.progress) && void 0 !== e && e),
            this.initOptions(),
            this.initEventListener();
    }
    return (
        _createClass(s, [
            {
                key: "initOptions",
                value: function () {
                    (this.selectedIndex = 0),
                        (this.progressBar = this.progress
                            ? this.wizard.querySelector(
                                  ".tab-content .progress .progress-bar"
                              )
                            : null),
                        (this.navItems =
                            this.wizard.querySelectorAll("ul li.nav-item a")),
                        (this.tabPans = this.wizard.querySelectorAll(
                            ".tab-content .tab-pane"
                        )),
                        this.initButtons(),
                        this.showTabSelectedTab();
                },
            },
            {
                key: "initButtons",
                value: function () {
                    this.buttons
                        ? ((this.prevBtn = this.wizard.querySelector(
                              ".tab-content .button-previous"
                          )),
                          (this.nextBtn = this.wizard.querySelector(
                              ".tab-content .button-next"
                          )),
                          (this.firstBtn = this.wizard.querySelector(
                              ".tab-content .button-first"
                          )),
                          (this.lastBtn = this.wizard.querySelector(
                              ".tab-content .button-last"
                          )))
                        : ((this.prevBtn = this.wizard.querySelector(
                              ".tab-content .previous a"
                          )),
                          (this.nextBtn = this.wizard.querySelector(
                              ".tab-content .next a"
                          )),
                          (this.firstBtn = this.wizard.querySelector(
                              ".tab-content .first a"
                          )),
                          (this.lastBtn = this.wizard.querySelector(
                              ".tab-content .last a"
                          )));
                },
            },
            {
                key: "initEventListener",
                value: function () {
                    var s = this;
                    this.prevBtn &&
                        this.prevBtn.addEventListener("click", function (t) {
                            t.preventDefault(),
                                0 < s.selectedIndex &&
                                    s.validateForm() &&
                                    (s.selectedIndex--, s.showTabSelectedTab());
                        }),
                        this.nextBtn &&
                            this.nextBtn.addEventListener(
                                "click",
                                function (t) {
                                    t.preventDefault(),
                                        s.selectedIndex <
                                            s.navItems.length - 1 &&
                                            s.validateForm() &&
                                            (s.selectedIndex++,
                                            s.showTabSelectedTab());
                                }
                            ),
                        this.firstBtn &&
                            this.firstBtn.addEventListener(
                                "click",
                                function (t) {
                                    t.preventDefault(),
                                        0 !== s.selectedIndex &&
                                            s.validateForm() &&
                                            ((s.selectedIndex = 0),
                                            s.showTabSelectedTab());
                                }
                            ),
                        this.lastBtn &&
                            this.lastBtn.addEventListener(
                                "click",
                                function (t) {
                                    t.preventDefault(),
                                        s.selectedIndex !==
                                            s.navItems.length - 1 &&
                                            s.validateForm() &&
                                            ((s.selectedIndex =
                                                s.navItems.length - 1),
                                            s.showTabSelectedTab());
                                }
                            ),
                        this.navItems.forEach(function (t, e) {
                            t.addEventListener("click", function () {
                                (s.selectedIndex = e),
                                    s.validateForm() && s.showTabSelectedTab();
                            });
                        });
                },
            },
            {
                key: "showTabSelectedTab",
                value: function () {
                    new bootstrap.Tab(this.navItems[this.selectedIndex]).show(),
                        this.progressBar &&
                            (this.progressBar.style.width =
                                (
                                    ((this.selectedIndex + 1) /
                                        this.navItems.length) *
                                    100
                                ).toString() + "%"),
                        this.changeBtnStyle();
                },
            },
            {
                key: "changeBtnStyle",
                value: function () {
                    this.nextBtn.classList.remove("disabled"),
                        this.prevBtn.classList.remove("disabled"),
                        0 === this.selectedIndex
                            ? this.prevBtn.classList.add("disabled")
                            : this.selectedIndex === this.navItems.length - 1 &&
                              this.nextBtn.classList.add("disabled");
                },
            },
            {
                key: "validateForm",
                value: function () {
                    if (this.validate) {
                        var t =
                            this.tabPans[this.selectedIndex].querySelector(
                                "form"
                            );
                        if (t)
                            return (
                                t.classList.add("was-validated"),
                                t.checkValidity()
                            );
                    }
                    return !0;
                },
            },
        ]),
        s
    );
})();
