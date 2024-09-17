/*! choices.js v11.0.2 | © 2024 Josh Johnson | https://github.com/jshjohnson/Choices#readme */
!(function (e, t) {
    "object" == typeof exports && "undefined" != typeof module
        ? (module.exports = t())
        : "function" == typeof define && define.amd
        ? define(t)
        : ((e =
              "undefined" != typeof globalThis
                  ? globalThis
                  : e || self).Choices = t());
})(this, function () {
    "use strict";
    var e = function (t, i) {
        return (
            (e =
                Object.setPrototypeOf ||
                ({ __proto__: [] } instanceof Array &&
                    function (e, t) {
                        e.__proto__ = t;
                    }) ||
                function (e, t) {
                    for (var i in t)
                        Object.prototype.hasOwnProperty.call(t, i) &&
                            (e[i] = t[i]);
                }),
            e(t, i)
        );
    };
    function t(t, i) {
        if ("function" != typeof i && null !== i)
            throw new TypeError(
                "Class extends value " +
                    String(i) +
                    " is not a constructor or null"
            );
        function n() {
            this.constructor = t;
        }
        e(t, i),
            (t.prototype =
                null === i
                    ? Object.create(i)
                    : ((n.prototype = i.prototype), new n()));
    }
    var i = function () {
        return (
            (i =
                Object.assign ||
                function (e) {
                    for (var t, i = 1, n = arguments.length; i < n; i++)
                        for (var s in (t = arguments[i]))
                            Object.prototype.hasOwnProperty.call(t, s) &&
                                (e[s] = t[s]);
                    return e;
                }),
            i.apply(this, arguments)
        );
    };
    function n(e, t, i) {
        if (i || 2 === arguments.length)
            for (var n, s = 0, o = t.length; s < o; s++)
                (!n && s in t) ||
                    (n || (n = Array.prototype.slice.call(t, 0, s)),
                    (n[s] = t[s]));
        return e.concat(n || Array.prototype.slice.call(t));
    }
    "function" == typeof SuppressedError && SuppressedError;
    var s,
        o = "ADD_CHOICE",
        r = "REMOVE_CHOICE",
        c = "FILTER_CHOICES",
        a = "ACTIVATE_CHOICES",
        h = "CLEAR_CHOICES",
        l = "ADD_GROUP",
        u = "ADD_ITEM",
        d = "REMOVE_ITEM",
        p = "HIGHLIGHT_ITEM",
        f = "search",
        m = "removeItem",
        g = "highlightItem",
        v = ["fuseOptions", "classNames"],
        _ = "select-one",
        y = "select-multiple",
        b = function (e) {
            return { type: r, choice: e };
        },
        E = function (e) {
            return { type: d, item: e };
        },
        C = function (e, t) {
            return { type: p, item: e, highlighted: t };
        },
        S = function (e) {
            return Array.from({ length: e }, function () {
                return Math.floor(36 * Math.random() + 0).toString(36);
            }).join("");
        },
        w = function (e) {
            if ("string" != typeof e) {
                if (null == e) return "";
                if ("object" == typeof e) {
                    if ("raw" in e) return w(e.raw);
                    if ("trusted" in e) return e.trusted;
                }
                return e;
            }
            return e
                .replace(/&/g, "&amp;")
                .replace(/>/g, "&gt;")
                .replace(/</g, "&lt;")
                .replace(/'/g, "&#039;")
                .replace(/"/g, "&quot;");
        },
        I =
            ((s = document.createElement("div")),
            function (e) {
                s.innerHTML = e.trim();
                for (var t = s.children[0]; s.firstChild; )
                    s.removeChild(s.firstChild);
                return t;
            }),
        x = function (e, t) {
            return "function" == typeof e ? e(w(t), t) : e;
        },
        A = function (e) {
            return "function" == typeof e ? e() : e;
        },
        O = function (e) {
            if ("string" == typeof e) return e;
            if ("object" == typeof e) {
                if ("trusted" in e) return e.trusted;
                if ("raw" in e) return e.raw;
            }
            return "";
        },
        L = function (e, t) {
            return e
                ? (function (e) {
                      if ("string" == typeof e) return e;
                      if ("object" == typeof e) {
                          if ("escaped" in e) return e.escaped;
                          if ("trusted" in e) return e.trusted;
                      }
                      return "";
                  })(t)
                : w(t);
        },
        M = function (e, t, i) {
            e.innerHTML = L(t, i);
        },
        T = function (e, t) {
            return e.rank - t.rank;
        },
        N = function (e) {
            return Array.isArray(e) ? e : [e];
        },
        k = function (e) {
            return e && Array.isArray(e)
                ? e
                      .map(function (e) {
                          return ".".concat(e);
                      })
                      .join("")
                : ".".concat(e);
        },
        F = function (e, t) {
            var i;
            (i = e.classList).add.apply(i, N(t));
        },
        D = function (e, t) {
            var i;
            (i = e.classList).remove.apply(i, N(t));
        },
        P = function (e) {
            if (void 0 !== e)
                try {
                    return JSON.parse(e);
                } catch (t) {
                    return e;
                }
            return {};
        },
        j = (function () {
            function e(e) {
                var t = e.type,
                    i = e.classNames;
                (this.element = e.element),
                    (this.classNames = i),
                    (this.type = t),
                    (this.isActive = !1);
            }
            return (
                (e.prototype.show = function () {
                    return (
                        F(this.element, this.classNames.activeState),
                        this.element.setAttribute("aria-expanded", "true"),
                        (this.isActive = !0),
                        this
                    );
                }),
                (e.prototype.hide = function () {
                    return (
                        D(this.element, this.classNames.activeState),
                        this.element.setAttribute("aria-expanded", "false"),
                        (this.isActive = !1),
                        this
                    );
                }),
                e
            );
        })(),
        R = (function () {
            function e(e) {
                var t = e.type,
                    i = e.classNames,
                    n = e.position;
                (this.element = e.element),
                    (this.classNames = i),
                    (this.type = t),
                    (this.position = n),
                    (this.isOpen = !1),
                    (this.isFlipped = !1),
                    (this.isDisabled = !1),
                    (this.isLoading = !1);
            }
            return (
                (e.prototype.shouldFlip = function (e, t) {
                    var i = !1;
                    return (
                        "auto" === this.position
                            ? (i =
                                  this.element.getBoundingClientRect().top -
                                      t >=
                                      0 &&
                                  !window.matchMedia(
                                      "(min-height: ".concat(e + 1, "px)")
                                  ).matches)
                            : "top" === this.position && (i = !0),
                        i
                    );
                }),
                (e.prototype.setActiveDescendant = function (e) {
                    this.element.setAttribute("aria-activedescendant", e);
                }),
                (e.prototype.removeActiveDescendant = function () {
                    this.element.removeAttribute("aria-activedescendant");
                }),
                (e.prototype.open = function (e, t) {
                    F(this.element, this.classNames.openState),
                        this.element.setAttribute("aria-expanded", "true"),
                        (this.isOpen = !0),
                        this.shouldFlip(e, t) &&
                            (F(this.element, this.classNames.flippedState),
                            (this.isFlipped = !0));
                }),
                (e.prototype.close = function () {
                    D(this.element, this.classNames.openState),
                        this.element.setAttribute("aria-expanded", "false"),
                        this.removeActiveDescendant(),
                        (this.isOpen = !1),
                        this.isFlipped &&
                            (D(this.element, this.classNames.flippedState),
                            (this.isFlipped = !1));
                }),
                (e.prototype.addFocusState = function () {
                    F(this.element, this.classNames.focusState);
                }),
                (e.prototype.removeFocusState = function () {
                    D(this.element, this.classNames.focusState);
                }),
                (e.prototype.enable = function () {
                    D(this.element, this.classNames.disabledState),
                        this.element.removeAttribute("aria-disabled"),
                        this.type === _ &&
                            this.element.setAttribute("tabindex", "0"),
                        (this.isDisabled = !1);
                }),
                (e.prototype.disable = function () {
                    F(this.element, this.classNames.disabledState),
                        this.element.setAttribute("aria-disabled", "true"),
                        this.type === _ &&
                            this.element.setAttribute("tabindex", "-1"),
                        (this.isDisabled = !0);
                }),
                (e.prototype.wrap = function (e) {
                    var t = this.element,
                        i = e.parentNode;
                    i &&
                        (e.nextSibling
                            ? i.insertBefore(t, e.nextSibling)
                            : i.appendChild(t)),
                        t.appendChild(e);
                }),
                (e.prototype.unwrap = function (e) {
                    var t = this.element,
                        i = t.parentNode;
                    i && (i.insertBefore(e, t), i.removeChild(t));
                }),
                (e.prototype.addLoadingState = function () {
                    F(this.element, this.classNames.loadingState),
                        this.element.setAttribute("aria-busy", "true"),
                        (this.isLoading = !0);
                }),
                (e.prototype.removeLoadingState = function () {
                    D(this.element, this.classNames.loadingState),
                        this.element.removeAttribute("aria-busy"),
                        (this.isLoading = !1);
                }),
                e
            );
        })(),
        K = (function () {
            function e(e) {
                var t = e.element,
                    i = e.type,
                    n = e.classNames,
                    s = e.preventPaste;
                (this.element = t),
                    (this.type = i),
                    (this.classNames = n),
                    (this.preventPaste = s),
                    (this.isFocussed = this.element.isEqualNode(
                        document.activeElement
                    )),
                    (this.isDisabled = t.disabled),
                    (this._onPaste = this._onPaste.bind(this)),
                    (this._onInput = this._onInput.bind(this)),
                    (this._onFocus = this._onFocus.bind(this)),
                    (this._onBlur = this._onBlur.bind(this));
            }
            return (
                Object.defineProperty(e.prototype, "placeholder", {
                    set: function (e) {
                        this.element.placeholder = e;
                    },
                    enumerable: !1,
                    configurable: !0,
                }),
                Object.defineProperty(e.prototype, "value", {
                    get: function () {
                        return this.element.value;
                    },
                    set: function (e) {
                        this.element.value = e;
                    },
                    enumerable: !1,
                    configurable: !0,
                }),
                (e.prototype.addEventListeners = function () {
                    var e = this.element;
                    e.addEventListener("paste", this._onPaste),
                        e.addEventListener("input", this._onInput, {
                            passive: !0,
                        }),
                        e.addEventListener("focus", this._onFocus, {
                            passive: !0,
                        }),
                        e.addEventListener("blur", this._onBlur, {
                            passive: !0,
                        });
                }),
                (e.prototype.removeEventListeners = function () {
                    var e = this.element;
                    e.removeEventListener("input", this._onInput),
                        e.removeEventListener("paste", this._onPaste),
                        e.removeEventListener("focus", this._onFocus),
                        e.removeEventListener("blur", this._onBlur);
                }),
                (e.prototype.enable = function () {
                    this.element.removeAttribute("disabled"),
                        (this.isDisabled = !1);
                }),
                (e.prototype.disable = function () {
                    this.element.setAttribute("disabled", ""),
                        (this.isDisabled = !0);
                }),
                (e.prototype.focus = function () {
                    this.isFocussed || this.element.focus();
                }),
                (e.prototype.blur = function () {
                    this.isFocussed && this.element.blur();
                }),
                (e.prototype.clear = function (e) {
                    return (
                        void 0 === e && (e = !0),
                        (this.element.value = ""),
                        e && this.setWidth(),
                        this
                    );
                }),
                (e.prototype.setWidth = function () {
                    var e = this.element;
                    (e.style.minWidth = "".concat(
                        e.placeholder.length + 1,
                        "ch"
                    )),
                        (e.style.width = "".concat(e.value.length + 1, "ch"));
                }),
                (e.prototype.setActiveDescendant = function (e) {
                    this.element.setAttribute("aria-activedescendant", e);
                }),
                (e.prototype.removeActiveDescendant = function () {
                    this.element.removeAttribute("aria-activedescendant");
                }),
                (e.prototype._onInput = function () {
                    this.type !== _ && this.setWidth();
                }),
                (e.prototype._onPaste = function (e) {
                    this.preventPaste && e.preventDefault();
                }),
                (e.prototype._onFocus = function () {
                    this.isFocussed = !0;
                }),
                (e.prototype._onBlur = function () {
                    this.isFocussed = !1;
                }),
                e
            );
        })(),
        B = (function () {
            function e(e) {
                (this.element = e.element),
                    (this.scrollPos = this.element.scrollTop),
                    (this.height = this.element.offsetHeight);
            }
            return (
                (e.prototype.prepend = function (e) {
                    var t = this.element.firstElementChild;
                    t
                        ? this.element.insertBefore(e, t)
                        : this.element.append(e);
                }),
                (e.prototype.scrollToTop = function () {
                    this.element.scrollTop = 0;
                }),
                (e.prototype.scrollToChildElement = function (e, t) {
                    var i = this;
                    if (e) {
                        var n =
                            t > 0
                                ? this.element.scrollTop +
                                  (e.offsetTop + e.offsetHeight) -
                                  (this.element.scrollTop +
                                      this.element.offsetHeight)
                                : e.offsetTop;
                        requestAnimationFrame(function () {
                            i._animateScroll(n, t);
                        });
                    }
                }),
                (e.prototype._scrollDown = function (e, t, i) {
                    var n = (i - e) / t;
                    this.element.scrollTop = e + (n > 1 ? n : 1);
                }),
                (e.prototype._scrollUp = function (e, t, i) {
                    var n = (e - i) / t;
                    this.element.scrollTop = e - (n > 1 ? n : 1);
                }),
                (e.prototype._animateScroll = function (e, t) {
                    var i = this,
                        n = this.element.scrollTop,
                        s = !1;
                    t > 0
                        ? (this._scrollDown(n, 4, e), n < e && (s = !0))
                        : (this._scrollUp(n, 4, e), n > e && (s = !0)),
                        s &&
                            requestAnimationFrame(function () {
                                i._animateScroll(e, t);
                            });
                }),
                e
            );
        })(),
        V = (function () {
            function e(e) {
                var t = e.classNames;
                (this.element = e.element),
                    (this.classNames = t),
                    (this.isDisabled = !1);
            }
            return (
                Object.defineProperty(e.prototype, "isActive", {
                    get: function () {
                        return "active" === this.element.dataset.choice;
                    },
                    enumerable: !1,
                    configurable: !0,
                }),
                Object.defineProperty(e.prototype, "dir", {
                    get: function () {
                        return this.element.dir;
                    },
                    enumerable: !1,
                    configurable: !0,
                }),
                Object.defineProperty(e.prototype, "value", {
                    get: function () {
                        return this.element.value;
                    },
                    set: function (e) {
                        this.element.setAttribute("value", e),
                            (this.element.value = e);
                    },
                    enumerable: !1,
                    configurable: !0,
                }),
                (e.prototype.conceal = function () {
                    var e = this.element;
                    F(e, this.classNames.input),
                        (e.hidden = !0),
                        (e.tabIndex = -1);
                    var t = e.getAttribute("style");
                    t && e.setAttribute("data-choice-orig-style", t),
                        e.setAttribute("data-choice", "active");
                }),
                (e.prototype.reveal = function () {
                    var e = this.element;
                    D(e, this.classNames.input),
                        (e.hidden = !1),
                        e.removeAttribute("tabindex");
                    var t = e.getAttribute("data-choice-orig-style");
                    t
                        ? (e.removeAttribute("data-choice-orig-style"),
                          e.setAttribute("style", t))
                        : e.removeAttribute("style"),
                        e.removeAttribute("data-choice");
                }),
                (e.prototype.enable = function () {
                    this.element.removeAttribute("disabled"),
                        (this.element.disabled = !1),
                        (this.isDisabled = !1);
                }),
                (e.prototype.disable = function () {
                    this.element.setAttribute("disabled", ""),
                        (this.element.disabled = !0),
                        (this.isDisabled = !0);
                }),
                (e.prototype.triggerEvent = function (e, t) {
                    var i;
                    void 0 === (i = t || {}) && (i = null),
                        this.element.dispatchEvent(
                            new CustomEvent(e, {
                                detail: i,
                                bubbles: !0,
                                cancelable: !0,
                            })
                        );
                }),
                e
            );
        })(),
        H = (function (e) {
            function i() {
                return (null !== e && e.apply(this, arguments)) || this;
            }
            return t(i, e), i;
        })(V),
        $ = function (e, t) {
            return void 0 === t && (t = !0), void 0 === e ? t : !!e;
        },
        q = function (e) {
            if (
                ("string" == typeof e &&
                    (e = e.split(" ").filter(function (e) {
                        return e.length;
                    })),
                Array.isArray(e) && e.length)
            )
                return e;
        },
        W = function (e, t) {
            if ("string" == typeof e) return W({ value: e, label: e }, !1);
            var i = e;
            if ("choices" in i) {
                if (!t) throw new TypeError("optGroup is not allowed");
                var n = i,
                    s = n.choices.map(function (e) {
                        return W(e, !1);
                    });
                return {
                    id: 0,
                    label: O(n.label) || n.value,
                    active: !!s.length,
                    disabled: !!n.disabled,
                    choices: s,
                };
            }
            var o = i;
            return {
                id: 0,
                group: null,
                score: 0,
                rank: 0,
                value: o.value,
                label: o.label || o.value,
                active: $(o.active),
                selected: $(o.selected, !1),
                disabled: $(o.disabled, !1),
                placeholder: $(o.placeholder, !1),
                highlighted: !1,
                labelClass: q(o.labelClass),
                labelDescription: o.labelDescription,
                customProperties: o.customProperties,
            };
        },
        U = function (e) {
            return "SELECT" === e.tagName;
        },
        G = (function (e) {
            function i(t) {
                var i = t.template,
                    n = t.extractPlaceholder,
                    s =
                        e.call(this, {
                            element: t.element,
                            classNames: t.classNames,
                        }) || this;
                return (s.template = i), (s.extractPlaceholder = n), s;
            }
            return (
                t(i, e),
                Object.defineProperty(i.prototype, "placeholderOption", {
                    get: function () {
                        return (
                            this.element.querySelector('option[value=""]') ||
                            this.element.querySelector("option[placeholder]")
                        );
                    },
                    enumerable: !1,
                    configurable: !0,
                }),
                (i.prototype.addOptions = function (e) {
                    var t = this,
                        i = document.createDocumentFragment();
                    e.forEach(function (e) {
                        var n = e;
                        if (!n.element) {
                            var s = t.template(n);
                            i.appendChild(s), (n.element = s);
                        }
                    }),
                        this.element.appendChild(i);
                }),
                (i.prototype.optionsAsChoices = function () {
                    var e = this,
                        t = [];
                    return (
                        this.element
                            .querySelectorAll(
                                ":scope > option, :scope > optgroup"
                            )
                            .forEach(function (i) {
                                !(function (e) {
                                    return "OPTION" === e.tagName;
                                })(i)
                                    ? (function (e) {
                                          return "OPTGROUP" === e.tagName;
                                      })(i) && t.push(e._optgroupToChoice(i))
                                    : t.push(e._optionToChoice(i));
                            }),
                        t
                    );
                }),
                (i.prototype._optionToChoice = function (e) {
                    return (
                        !e.hasAttribute("value") &&
                            e.hasAttribute("placeholder") &&
                            (e.setAttribute("value", ""), (e.value = "")),
                        {
                            id: 0,
                            group: null,
                            score: 0,
                            rank: 0,
                            value: e.value,
                            label: e.innerHTML,
                            element: e,
                            active: !0,
                            selected: this.extractPlaceholder
                                ? e.selected
                                : e.hasAttribute("selected"),
                            disabled: e.disabled,
                            highlighted: !1,
                            placeholder:
                                this.extractPlaceholder &&
                                (!e.value || e.hasAttribute("placeholder")),
                            labelClass:
                                void 0 !== e.dataset.labelClass
                                    ? q(e.dataset.labelClass)
                                    : void 0,
                            labelDescription:
                                void 0 !== e.dataset.labelDescription
                                    ? e.dataset.labelDescription
                                    : void 0,
                            customProperties: P(e.dataset.customProperties),
                        }
                    );
                }),
                (i.prototype._optgroupToChoice = function (e) {
                    var t = this,
                        i = e.querySelectorAll("option"),
                        n = Array.from(i).map(function (e) {
                            return t._optionToChoice(e);
                        });
                    return {
                        id: 0,
                        label: e.label || "",
                        element: e,
                        active: !!n.length,
                        disabled: e.disabled,
                        choices: n,
                    };
                }),
                i
            );
        })(V),
        z = {
            items: [],
            choices: [],
            silent: !1,
            renderChoiceLimit: -1,
            maxItemCount: -1,
            closeDropdownOnSelect: "auto",
            singleModeForMultiSelect: !1,
            addChoices: !1,
            addItems: !0,
            addItemFilter: function (e) {
                return !!e && "" !== e;
            },
            removeItems: !0,
            removeItemButton: !1,
            removeItemButtonAlignLeft: !1,
            editItems: !1,
            allowHTML: !1,
            allowHtmlUserInput: !1,
            duplicateItemsAllowed: !0,
            delimiter: ",",
            paste: !0,
            searchEnabled: !0,
            searchChoices: !0,
            searchFloor: 1,
            searchResultLimit: 4,
            searchFields: ["label", "value"],
            position: "auto",
            resetScrollPosition: !0,
            shouldSort: !0,
            shouldSortItems: !1,
            sorter: function (e, t) {
                var i = e.label,
                    n = t.label,
                    s = void 0 === n ? t.value : n;
                return O(void 0 === i ? e.value : i).localeCompare(O(s), [], {
                    sensitivity: "base",
                    ignorePunctuation: !0,
                    numeric: !0,
                });
            },
            shadowRoot: null,
            placeholder: !0,
            placeholderValue: null,
            searchPlaceholderValue: null,
            prependValue: null,
            appendValue: null,
            renderSelectedChoices: "auto",
            loadingText: "Mencari...",
            noResultsText: "Hasil tidak ada",
            noChoicesText: "Tidak ada pilihan yang dipilih",

            uniqueItemText: "Hanya kode unik yang dapat dipilih",
            customAddItemText:
                "Only values matching specific conditions can be added",
            addItemText: function (e) {
                return 'Press Enter to add <b>"'.concat(e, '"</b>');
            },
            removeItemIconText: function () {
                return "Remove item";
            },
            removeItemLabelText: function (e) {
                return "Remove item: ".concat(e);
            },
            maxItemText: function (e) {
                return "Only ".concat(e, " values can be added");
            },
            valueComparer: function (e, t) {
                return e === t;
            },
            fuseOptions: { includeScore: !0 },
            labelId: "",
            callbackOnInit: null,
            callbackOnCreateTemplates: null,
            classNames: {
                containerOuter: ["choices"],
                containerInner: ["choices__inner"],
                input: ["choices__input"],
                inputCloned: ["choices__input--cloned"],
                list: ["choices__list"],
                listItems: ["choices__list--multiple"],
                listSingle: ["choices__list--single"],
                listDropdown: ["choices__list--dropdown"],
                item: ["choices__item"],
                itemSelectable: ["choices__item--selectable"],
                itemDisabled: ["choices__item--disabled"],
                itemChoice: ["choices__item--choice"],
                description: ["choices__description"],
                placeholder: ["choices__placeholder"],
                group: ["choices__group"],
                groupHeading: ["choices__heading"],
                button: ["choices__button"],
                activeState: ["is-active"],
                focusState: ["is-focused"],
                openState: ["is-open"],
                disabledState: ["is-disabled"],
                highlightedState: ["is-highlighted"],
                selectedState: ["is-selected"],
                flippedState: ["is-flipped"],
                loadingState: ["is-loading"],
                notice: ["choices__notice"],
                addChoice: ["choices__item--selectable", "add-choice"],
                noResults: ["has-no-results"],
                noChoices: ["has-no-choices"],
            },
            appendGroupInSearch: !1,
        },
        J = function (e) {
            var t = e.itemEl;
            t && (t.remove(), (e.itemEl = void 0));
        },
        X = {
            groups: function (e, t) {
                var i = e,
                    n = !0;
                switch (t.type) {
                    case l:
                        i.push(t.group);
                        break;
                    case h:
                        i = [];
                        break;
                    default:
                        n = !1;
                }
                return { state: i, update: n };
            },
            items: function (e, t, i) {
                var n = e,
                    s = !0;
                switch (t.type) {
                    case u:
                        (t.item.selected = !0),
                            (o = t.item.element) &&
                                ((o.selected = !0),
                                o.setAttribute("selected", "")),
                            n.push(t.item);
                        break;
                    case d:
                        var o;
                        if (((t.item.selected = !1), (o = t.item.element))) {
                            (o.selected = !1), o.removeAttribute("selected");
                            var c = o.parentElement;
                            c && U(c) && c.type === _ && (c.value = "");
                        }
                        J(t.item),
                            (n = n.filter(function (e) {
                                return e.id !== t.item.id;
                            }));
                        break;
                    case r:
                        J(t.choice),
                            (n = n.filter(function (e) {
                                return e.id !== t.choice.id;
                            }));
                        break;
                    case p:
                        var a = t.highlighted,
                            h = n.find(function (e) {
                                return e.id === t.item.id;
                            });
                        h &&
                            h.highlighted !== a &&
                            ((h.highlighted = a),
                            i &&
                                (function (e, t, i) {
                                    var n = e.itemEl;
                                    n && (D(n, i), F(n, t));
                                })(
                                    h,
                                    a
                                        ? i.classNames.highlightedState
                                        : i.classNames.selectedState,
                                    a
                                        ? i.classNames.selectedState
                                        : i.classNames.highlightedState
                                ));
                        break;
                    default:
                        s = !1;
                }
                return { state: n, update: s };
            },
            choices: function (e, t, i) {
                var n = e,
                    s = !0;
                switch (t.type) {
                    case o:
                        n.push(t.choice);
                        break;
                    case r:
                        (t.choice.choiceEl = void 0),
                            t.choice.group &&
                                (t.choice.group.choices =
                                    t.choice.group.choices.filter(function (e) {
                                        return e.id !== t.choice.id;
                                    })),
                            (n = n.filter(function (e) {
                                return e.id !== t.choice.id;
                            }));
                        break;
                    case u:
                    case d:
                        t.item.choiceEl = void 0;
                        break;
                    case c:
                        var l = [];
                        t.results.forEach(function (e) {
                            l[e.item.id] = e;
                        }),
                            n.forEach(function (e) {
                                var t = l[e.id];
                                void 0 !== t
                                    ? ((e.score = t.score),
                                      (e.rank = t.rank),
                                      (e.active = !0))
                                    : ((e.score = 0),
                                      (e.rank = 0),
                                      (e.active = !1)),
                                    i &&
                                        i.appendGroupInSearch &&
                                        (e.choiceEl = void 0);
                            });
                        break;
                    case a:
                        n.forEach(function (e) {
                            (e.active = t.active),
                                i &&
                                    i.appendGroupInSearch &&
                                    (e.choiceEl = void 0);
                        });
                        break;
                    case h:
                        n = [];
                        break;
                    default:
                        s = !1;
                }
                return { state: n, update: s };
            },
        },
        Q = (function () {
            function e(e) {
                (this._state = this.defaultState),
                    (this._listeners = []),
                    (this._txn = 0),
                    (this._context = e);
            }
            return (
                Object.defineProperty(e.prototype, "defaultState", {
                    get: function () {
                        return { groups: [], items: [], choices: [] };
                    },
                    enumerable: !1,
                    configurable: !0,
                }),
                (e.prototype.changeSet = function (e) {
                    return { groups: e, items: e, choices: e };
                }),
                (e.prototype.reset = function () {
                    this._state = this.defaultState;
                    var e = this.changeSet(!0);
                    this._txn
                        ? (this._changeSet = e)
                        : this._listeners.forEach(function (t) {
                              return t(e);
                          });
                }),
                (e.prototype.subscribe = function (e) {
                    return this._listeners.push(e), this;
                }),
                (e.prototype.dispatch = function (e) {
                    var t = this,
                        i = this._state,
                        n = !1,
                        s = this._changeSet || this.changeSet(!1);
                    Object.keys(X).forEach(function (o) {
                        var r = X[o](i[o], e, t._context);
                        r.update && ((n = !0), (s[o] = !0), (i[o] = r.state));
                    }),
                        n &&
                            (this._txn
                                ? (this._changeSet = s)
                                : this._listeners.forEach(function (e) {
                                      return e(s);
                                  }));
                }),
                (e.prototype.withTxn = function (e) {
                    this._txn++;
                    try {
                        e();
                    } finally {
                        if (
                            ((this._txn = Math.max(0, this._txn - 1)),
                            !this._txn)
                        ) {
                            var t = this._changeSet;
                            t &&
                                ((this._changeSet = void 0),
                                this._listeners.forEach(function (e) {
                                    return e(t);
                                }));
                        }
                    }
                }),
                Object.defineProperty(e.prototype, "state", {
                    get: function () {
                        return this._state;
                    },
                    enumerable: !1,
                    configurable: !0,
                }),
                Object.defineProperty(e.prototype, "items", {
                    get: function () {
                        return this.state.items;
                    },
                    enumerable: !1,
                    configurable: !0,
                }),
                Object.defineProperty(e.prototype, "highlightedActiveItems", {
                    get: function () {
                        return this.items.filter(function (e) {
                            return !e.disabled && e.active && e.highlighted;
                        });
                    },
                    enumerable: !1,
                    configurable: !0,
                }),
                Object.defineProperty(e.prototype, "choices", {
                    get: function () {
                        return this.state.choices;
                    },
                    enumerable: !1,
                    configurable: !0,
                }),
                Object.defineProperty(e.prototype, "activeChoices", {
                    get: function () {
                        return this.choices.filter(function (e) {
                            return e.active;
                        });
                    },
                    enumerable: !1,
                    configurable: !0,
                }),
                Object.defineProperty(e.prototype, "searchableChoices", {
                    get: function () {
                        return this.choices.filter(function (e) {
                            return !e.disabled && !e.placeholder;
                        });
                    },
                    enumerable: !1,
                    configurable: !0,
                }),
                Object.defineProperty(e.prototype, "groups", {
                    get: function () {
                        return this.state.groups;
                    },
                    enumerable: !1,
                    configurable: !0,
                }),
                Object.defineProperty(e.prototype, "activeGroups", {
                    get: function () {
                        var e = this;
                        return this.state.groups.filter(function (t) {
                            var i = t.active && !t.disabled,
                                n = e.state.choices.some(function (e) {
                                    return e.active && !e.disabled;
                                });
                            return i && n;
                        }, []);
                    },
                    enumerable: !1,
                    configurable: !0,
                }),
                (e.prototype.inTxn = function () {
                    return this._txn > 0;
                }),
                (e.prototype.getChoiceById = function (e) {
                    return this.activeChoices.find(function (t) {
                        return t.id === e;
                    });
                }),
                (e.prototype.getGroupById = function (e) {
                    return this.groups.find(function (t) {
                        return t.id === e;
                    });
                }),
                e
            );
        })(),
        Y = "no-choices",
        Z = "no-results",
        ee = "add-choice";
    function te(e, t, i) {
        return (
            (t = (function (e) {
                var t = (function (e) {
                    if ("object" != typeof e || !e) return e;
                    var t = e[Symbol.toPrimitive];
                    if (void 0 !== t) {
                        var i = t.call(e, "string");
                        if ("object" != typeof i) return i;
                        throw new TypeError(
                            "@@toPrimitive must return a primitive value."
                        );
                    }
                    return String(e);
                })(e);
                return "symbol" == typeof t ? t : t + "";
            })(t)) in e
                ? Object.defineProperty(e, t, {
                      value: i,
                      enumerable: !0,
                      configurable: !0,
                      writable: !0,
                  })
                : (e[t] = i),
            e
        );
    }
    function ie(e, t) {
        var i = Object.keys(e);
        if (Object.getOwnPropertySymbols) {
            var n = Object.getOwnPropertySymbols(e);
            t &&
                (n = n.filter(function (t) {
                    return Object.getOwnPropertyDescriptor(e, t).enumerable;
                })),
                i.push.apply(i, n);
        }
        return i;
    }
    function ne(e) {
        for (var t = 1; t < arguments.length; t++) {
            var i = null != arguments[t] ? arguments[t] : {};
            t % 2
                ? ie(Object(i), !0).forEach(function (t) {
                      te(e, t, i[t]);
                  })
                : Object.getOwnPropertyDescriptors
                ? Object.defineProperties(
                      e,
                      Object.getOwnPropertyDescriptors(i)
                  )
                : ie(Object(i)).forEach(function (t) {
                      Object.defineProperty(
                          e,
                          t,
                          Object.getOwnPropertyDescriptor(i, t)
                      );
                  });
        }
        return e;
    }
    function se(e) {
        return Array.isArray ? Array.isArray(e) : "[object Array]" === le(e);
    }
    function oe(e) {
        return "string" == typeof e;
    }
    function re(e) {
        return "number" == typeof e;
    }
    function ce(e) {
        return "object" == typeof e;
    }
    function ae(e) {
        return null != e;
    }
    function he(e) {
        return !e.trim().length;
    }
    function le(e) {
        return null == e
            ? void 0 === e
                ? "[object Undefined]"
                : "[object Null]"
            : Object.prototype.toString.call(e);
    }
    const ue = (e) => `Missing ${e} property in key`,
        de = (e) =>
            `Property 'weight' in key '${e}' must be a positive integer`,
        pe = Object.prototype.hasOwnProperty;
    class fe {
        constructor(e) {
            (this._keys = []), (this._keyMap = {});
            let t = 0;
            e.forEach((e) => {
                let i = me(e);
                this._keys.push(i), (this._keyMap[i.id] = i), (t += i.weight);
            }),
                this._keys.forEach((e) => {
                    e.weight /= t;
                });
        }
        get(e) {
            return this._keyMap[e];
        }
        keys() {
            return this._keys;
        }
        toJSON() {
            return JSON.stringify(this._keys);
        }
    }
    function me(e) {
        let t = null,
            i = null,
            n = null,
            s = 1,
            o = null;
        if (oe(e) || se(e)) (n = e), (t = ge(e)), (i = ve(e));
        else {
            if (!pe.call(e, "name")) throw new Error(ue("name"));
            const r = e.name;
            if (((n = r), pe.call(e, "weight") && ((s = e.weight), s <= 0)))
                throw new Error(de(r));
            (t = ge(r)), (i = ve(r)), (o = e.getFn);
        }
        return { path: t, id: i, weight: s, src: n, getFn: o };
    }
    function ge(e) {
        return se(e) ? e : e.split(".");
    }
    function ve(e) {
        return se(e) ? e.join(".") : e;
    }
    const _e = {
        useExtendedSearch: !1,
        getFn: function (e, t) {
            let i = [],
                n = !1;
            const s = (e, t, o) => {
                if (ae(e))
                    if (t[o]) {
                        const r = e[t[o]];
                        if (!ae(r)) return;
                        if (
                            o === t.length - 1 &&
                            (oe(r) ||
                                re(r) ||
                                (function (e) {
                                    return (
                                        !0 === e ||
                                        !1 === e ||
                                        ((function (e) {
                                            return ce(e) && null !== e;
                                        })(e) &&
                                            "[object Boolean]" == le(e))
                                    );
                                })(r))
                        )
                            i.push(
                                (function (e) {
                                    return null == e
                                        ? ""
                                        : (function (e) {
                                              if ("string" == typeof e)
                                                  return e;
                                              let t = e + "";
                                              return "0" == t && 1 / e == -1 / 0
                                                  ? "-0"
                                                  : t;
                                          })(e);
                                })(r)
                            );
                        else if (se(r)) {
                            n = !0;
                            for (let e = 0, i = r.length; e < i; e += 1)
                                s(r[e], t, o + 1);
                        } else t.length && s(r, t, o + 1);
                    } else i.push(e);
            };
            return s(e, oe(t) ? t.split(".") : t, 0), n ? i : i[0];
        },
        ignoreLocation: !1,
        ignoreFieldNorm: !1,
        fieldNormWeight: 1,
    };
    var ye = ne(
        ne(
            ne(
                ne(
                    {},
                    {
                        isCaseSensitive: !1,
                        includeScore: !1,
                        keys: [],
                        shouldSort: !0,
                        sortFn: (e, t) =>
                            e.score === t.score
                                ? e.idx < t.idx
                                    ? -1
                                    : 1
                                : e.score < t.score
                                ? -1
                                : 1,
                    }
                ),
                {
                    includeMatches: !1,
                    findAllMatches: !1,
                    minMatchCharLength: 1,
                }
            ),
            { location: 0, threshold: 0.6, distance: 100 }
        ),
        _e
    );
    const be = /[^ ]+/g;
    class Ee {
        constructor({
            getFn: e = ye.getFn,
            fieldNormWeight: t = ye.fieldNormWeight,
        } = {}) {
            (this.norm = (function (e = 1, t = 3) {
                const i = new Map(),
                    n = Math.pow(10, t);
                return {
                    get(t) {
                        const s = t.match(be).length;
                        if (i.has(s)) return i.get(s);
                        const o = 1 / Math.pow(s, 0.5 * e),
                            r = parseFloat(Math.round(o * n) / n);
                        return i.set(s, r), r;
                    },
                    clear() {
                        i.clear();
                    },
                };
            })(t, 3)),
                (this.getFn = e),
                (this.isCreated = !1),
                this.setIndexRecords();
        }
        setSources(e = []) {
            this.docs = e;
        }
        setIndexRecords(e = []) {
            this.records = e;
        }
        setKeys(e = []) {
            (this.keys = e),
                (this._keysMap = {}),
                e.forEach((e, t) => {
                    this._keysMap[e.id] = t;
                });
        }
        create() {
            !this.isCreated &&
                this.docs.length &&
                ((this.isCreated = !0),
                oe(this.docs[0])
                    ? this.docs.forEach((e, t) => {
                          this._addString(e, t);
                      })
                    : this.docs.forEach((e, t) => {
                          this._addObject(e, t);
                      }),
                this.norm.clear());
        }
        add(e) {
            const t = this.size();
            oe(e) ? this._addString(e, t) : this._addObject(e, t);
        }
        removeAt(e) {
            this.records.splice(e, 1);
            for (let t = e, i = this.size(); t < i; t += 1)
                this.records[t].i -= 1;
        }
        getValueForItemAtKeyId(e, t) {
            return e[this._keysMap[t]];
        }
        size() {
            return this.records.length;
        }
        _addString(e, t) {
            if (!ae(e) || he(e)) return;
            let i = { v: e, i: t, n: this.norm.get(e) };
            this.records.push(i);
        }
        _addObject(e, t) {
            let i = { i: t, $: {} };
            this.keys.forEach((t, n) => {
                let s = t.getFn ? t.getFn(e) : this.getFn(e, t.path);
                if (ae(s))
                    if (se(s)) {
                        let e = [];
                        const t = [{ nestedArrIndex: -1, value: s }];
                        for (; t.length; ) {
                            const { nestedArrIndex: i, value: n } = t.pop();
                            if (ae(n))
                                if (oe(n) && !he(n)) {
                                    let t = { v: n, i: i, n: this.norm.get(n) };
                                    e.push(t);
                                } else
                                    se(n) &&
                                        n.forEach((e, i) => {
                                            t.push({
                                                nestedArrIndex: i,
                                                value: e,
                                            });
                                        });
                        }
                        i.$[n] = e;
                    } else if (oe(s) && !he(s)) {
                        let e = { v: s, n: this.norm.get(s) };
                        i.$[n] = e;
                    }
            }),
                this.records.push(i);
        }
        toJSON() {
            return { keys: this.keys, records: this.records };
        }
    }
    function Ce(
        e,
        t,
        { getFn: i = ye.getFn, fieldNormWeight: n = ye.fieldNormWeight } = {}
    ) {
        const s = new Ee({ getFn: i, fieldNormWeight: n });
        return s.setKeys(e.map(me)), s.setSources(t), s.create(), s;
    }
    function Se(
        e,
        {
            errors: t = 0,
            currentLocation: i = 0,
            expectedLocation: n = 0,
            distance: s = ye.distance,
            ignoreLocation: o = ye.ignoreLocation,
        } = {}
    ) {
        const r = t / e.length;
        if (o) return r;
        const c = Math.abs(n - i);
        return s ? r + c / s : c ? 1 : r;
    }
    const we = 32;
    function Ie(e) {
        let t = {};
        for (let i = 0, n = e.length; i < n; i += 1) {
            const s = e.charAt(i);
            t[s] = (t[s] || 0) | (1 << (n - i - 1));
        }
        return t;
    }
    class xe {
        constructor(
            e,
            {
                location: t = ye.location,
                threshold: i = ye.threshold,
                distance: n = ye.distance,
                includeMatches: s = ye.includeMatches,
                findAllMatches: o = ye.findAllMatches,
                minMatchCharLength: r = ye.minMatchCharLength,
                isCaseSensitive: c = ye.isCaseSensitive,
                ignoreLocation: a = ye.ignoreLocation,
            } = {}
        ) {
            if (
                ((this.options = {
                    location: t,
                    threshold: i,
                    distance: n,
                    includeMatches: s,
                    findAllMatches: o,
                    minMatchCharLength: r,
                    isCaseSensitive: c,
                    ignoreLocation: a,
                }),
                (this.pattern = c ? e : e.toLowerCase()),
                (this.chunks = []),
                !this.pattern.length)
            )
                return;
            const h = (e, t) => {
                    this.chunks.push({
                        pattern: e,
                        alphabet: Ie(e),
                        startIndex: t,
                    });
                },
                l = this.pattern.length;
            if (l > we) {
                let e = 0;
                const t = l % we,
                    i = l - t;
                for (; e < i; ) h(this.pattern.substr(e, we), e), (e += we);
                if (t) {
                    const e = l - we;
                    h(this.pattern.substr(e), e);
                }
            } else h(this.pattern, 0);
        }
        searchIn(e) {
            const { isCaseSensitive: t, includeMatches: i } = this.options;
            if ((t || (e = e.toLowerCase()), this.pattern === e)) {
                let t = { isMatch: !0, score: 0 };
                return i && (t.indices = [[0, e.length - 1]]), t;
            }
            const {
                location: n,
                distance: s,
                threshold: o,
                findAllMatches: r,
                minMatchCharLength: c,
                ignoreLocation: a,
            } = this.options;
            let h = [],
                l = 0,
                u = !1;
            this.chunks.forEach(
                ({ pattern: t, alphabet: d, startIndex: p }) => {
                    const {
                        isMatch: f,
                        score: m,
                        indices: g,
                    } = (function (
                        e,
                        t,
                        i,
                        {
                            location: n = ye.location,
                            distance: s = ye.distance,
                            threshold: o = ye.threshold,
                            findAllMatches: r = ye.findAllMatches,
                            minMatchCharLength: c = ye.minMatchCharLength,
                            includeMatches: a = ye.includeMatches,
                            ignoreLocation: h = ye.ignoreLocation,
                        } = {}
                    ) {
                        if (t.length > we)
                            throw new Error(
                                "Pattern length exceeds max of 32."
                            );
                        const l = t.length,
                            u = e.length,
                            d = Math.max(0, Math.min(n, u));
                        let p = o,
                            f = d;
                        const m = c > 1 || a,
                            g = m ? Array(u) : [];
                        let v;
                        for (; (v = e.indexOf(t, f)) > -1; ) {
                            let e = Se(t, {
                                currentLocation: v,
                                expectedLocation: d,
                                distance: s,
                                ignoreLocation: h,
                            });
                            if (((p = Math.min(e, p)), (f = v + l), m)) {
                                let e = 0;
                                for (; e < l; ) (g[v + e] = 1), (e += 1);
                            }
                        }
                        f = -1;
                        let _ = [],
                            y = 1,
                            b = l + u;
                        const E = 1 << (l - 1);
                        for (let n = 0; n < l; n += 1) {
                            let o = 0,
                                c = b;
                            for (; o < c; )
                                Se(t, {
                                    errors: n,
                                    currentLocation: d + c,
                                    expectedLocation: d,
                                    distance: s,
                                    ignoreLocation: h,
                                }) <= p
                                    ? (o = c)
                                    : (b = c),
                                    (c = Math.floor((b - o) / 2 + o));
                            b = c;
                            let a = Math.max(1, d - c + 1),
                                v = r ? u : Math.min(d + c, u) + l,
                                C = Array(v + 2);
                            C[v + 1] = (1 << n) - 1;
                            for (let o = v; o >= a; o -= 1) {
                                let r = o - 1,
                                    c = i[e.charAt(r)];
                                if (
                                    (m && (g[r] = +!!c),
                                    (C[o] = ((C[o + 1] << 1) | 1) & c),
                                    n &&
                                        (C[o] |=
                                            ((_[o + 1] | _[o]) << 1) |
                                            1 |
                                            _[o + 1]),
                                    C[o] & E &&
                                        ((y = Se(t, {
                                            errors: n,
                                            currentLocation: r,
                                            expectedLocation: d,
                                            distance: s,
                                            ignoreLocation: h,
                                        })),
                                        y <= p))
                                ) {
                                    if (((p = y), (f = r), f <= d)) break;
                                    a = Math.max(1, 2 * d - f);
                                }
                            }
                            if (
                                Se(t, {
                                    errors: n + 1,
                                    currentLocation: d,
                                    expectedLocation: d,
                                    distance: s,
                                    ignoreLocation: h,
                                }) > p
                            )
                                break;
                            _ = C;
                        }
                        const C = {
                            isMatch: f >= 0,
                            score: Math.max(0.001, y),
                        };
                        if (m) {
                            const e = (function (
                                e = [],
                                t = ye.minMatchCharLength
                            ) {
                                let i = [],
                                    n = -1,
                                    s = -1,
                                    o = 0;
                                for (let r = e.length; o < r; o += 1) {
                                    let r = e[o];
                                    r && -1 === n
                                        ? (n = o)
                                        : r ||
                                          -1 === n ||
                                          ((s = o - 1),
                                          s - n + 1 >= t && i.push([n, s]),
                                          (n = -1));
                                }
                                return (
                                    e[o - 1] &&
                                        o - n >= t &&
                                        i.push([n, o - 1]),
                                    i
                                );
                            })(g, c);
                            e.length ? a && (C.indices = e) : (C.isMatch = !1);
                        }
                        return C;
                    })(e, t, d, {
                        location: n + p,
                        distance: s,
                        threshold: o,
                        findAllMatches: r,
                        minMatchCharLength: c,
                        includeMatches: i,
                        ignoreLocation: a,
                    });
                    f && (u = !0), (l += m), f && g && (h = [...h, ...g]);
                }
            );
            let d = { isMatch: u, score: u ? l / this.chunks.length : 1 };
            return u && i && (d.indices = h), d;
        }
    }
    class Ae {
        constructor(e) {
            this.pattern = e;
        }
        static isMultiMatch(e) {
            return Oe(e, this.multiRegex);
        }
        static isSingleMatch(e) {
            return Oe(e, this.singleRegex);
        }
        search() {}
    }
    function Oe(e, t) {
        const i = e.match(t);
        return i ? i[1] : null;
    }
    class Le extends Ae {
        constructor(
            e,
            {
                location: t = ye.location,
                threshold: i = ye.threshold,
                distance: n = ye.distance,
                includeMatches: s = ye.includeMatches,
                findAllMatches: o = ye.findAllMatches,
                minMatchCharLength: r = ye.minMatchCharLength,
                isCaseSensitive: c = ye.isCaseSensitive,
                ignoreLocation: a = ye.ignoreLocation,
            } = {}
        ) {
            super(e),
                (this._bitapSearch = new xe(e, {
                    location: t,
                    threshold: i,
                    distance: n,
                    includeMatches: s,
                    findAllMatches: o,
                    minMatchCharLength: r,
                    isCaseSensitive: c,
                    ignoreLocation: a,
                }));
        }
        static get type() {
            return "fuzzy";
        }
        static get multiRegex() {
            return /^"(.*)"$/;
        }
        static get singleRegex() {
            return /^(.*)$/;
        }
        search(e) {
            return this._bitapSearch.searchIn(e);
        }
    }
    class Me extends Ae {
        constructor(e) {
            super(e);
        }
        static get type() {
            return "include";
        }
        static get multiRegex() {
            return /^'"(.*)"$/;
        }
        static get singleRegex() {
            return /^'(.*)$/;
        }
        search(e) {
            let t,
                i = 0;
            const n = [],
                s = this.pattern.length;
            for (; (t = e.indexOf(this.pattern, i)) > -1; )
                (i = t + s), n.push([t, i - 1]);
            const o = !!n.length;
            return { isMatch: o, score: o ? 0 : 1, indices: n };
        }
    }
    const Te = [
            class extends Ae {
                constructor(e) {
                    super(e);
                }
                static get type() {
                    return "exact";
                }
                static get multiRegex() {
                    return /^="(.*)"$/;
                }
                static get singleRegex() {
                    return /^=(.*)$/;
                }
                search(e) {
                    const t = e === this.pattern;
                    return {
                        isMatch: t,
                        score: t ? 0 : 1,
                        indices: [0, this.pattern.length - 1],
                    };
                }
            },
            Me,
            class extends Ae {
                constructor(e) {
                    super(e);
                }
                static get type() {
                    return "prefix-exact";
                }
                static get multiRegex() {
                    return /^\^"(.*)"$/;
                }
                static get singleRegex() {
                    return /^\^(.*)$/;
                }
                search(e) {
                    const t = e.startsWith(this.pattern);
                    return {
                        isMatch: t,
                        score: t ? 0 : 1,
                        indices: [0, this.pattern.length - 1],
                    };
                }
            },
            class extends Ae {
                constructor(e) {
                    super(e);
                }
                static get type() {
                    return "inverse-prefix-exact";
                }
                static get multiRegex() {
                    return /^!\^"(.*)"$/;
                }
                static get singleRegex() {
                    return /^!\^(.*)$/;
                }
                search(e) {
                    const t = !e.startsWith(this.pattern);
                    return {
                        isMatch: t,
                        score: t ? 0 : 1,
                        indices: [0, e.length - 1],
                    };
                }
            },
            class extends Ae {
                constructor(e) {
                    super(e);
                }
                static get type() {
                    return "inverse-suffix-exact";
                }
                static get multiRegex() {
                    return /^!"(.*)"\$$/;
                }
                static get singleRegex() {
                    return /^!(.*)\$$/;
                }
                search(e) {
                    const t = !e.endsWith(this.pattern);
                    return {
                        isMatch: t,
                        score: t ? 0 : 1,
                        indices: [0, e.length - 1],
                    };
                }
            },
            class extends Ae {
                constructor(e) {
                    super(e);
                }
                static get type() {
                    return "suffix-exact";
                }
                static get multiRegex() {
                    return /^"(.*)"\$$/;
                }
                static get singleRegex() {
                    return /^(.*)\$$/;
                }
                search(e) {
                    const t = e.endsWith(this.pattern);
                    return {
                        isMatch: t,
                        score: t ? 0 : 1,
                        indices: [e.length - this.pattern.length, e.length - 1],
                    };
                }
            },
            class extends Ae {
                constructor(e) {
                    super(e);
                }
                static get type() {
                    return "inverse-exact";
                }
                static get multiRegex() {
                    return /^!"(.*)"$/;
                }
                static get singleRegex() {
                    return /^!(.*)$/;
                }
                search(e) {
                    const t = -1 === e.indexOf(this.pattern);
                    return {
                        isMatch: t,
                        score: t ? 0 : 1,
                        indices: [0, e.length - 1],
                    };
                }
            },
            Le,
        ],
        Ne = Te.length,
        ke = / +(?=(?:[^\"]*\"[^\"]*\")*[^\"]*$)/,
        Fe = new Set([Le.type, Me.type]);
    const De = [];
    function Pe(e, t) {
        for (let i = 0, n = De.length; i < n; i += 1) {
            let n = De[i];
            if (n.condition(e, t)) return new n(e, t);
        }
        return new xe(e, t);
    }
    const je = "$and",
        Re = "$path",
        Ke = (e) => !(!e[je] && !e.$or),
        Be = (e) => ({ [je]: Object.keys(e).map((t) => ({ [t]: e[t] })) });
    function Ve(e, t, { auto: i = !0 } = {}) {
        const n = (e) => {
            let s = Object.keys(e);
            const o = ((e) => !!e[Re])(e);
            if (!o && s.length > 1 && !Ke(e)) return n(Be(e));
            if (((e) => !se(e) && ce(e) && !Ke(e))(e)) {
                const n = o ? e[Re] : s[0],
                    r = o ? e.$val : e[n];
                if (!oe(r))
                    throw new Error(((e) => `Invalid value for key ${e}`)(n));
                const c = { keyId: ve(n), pattern: r };
                return i && (c.searcher = Pe(r, t)), c;
            }
            let r = { children: [], operator: s[0] };
            return (
                s.forEach((t) => {
                    const i = e[t];
                    se(i) &&
                        i.forEach((e) => {
                            r.children.push(n(e));
                        });
                }),
                r
            );
        };
        return Ke(e) || (e = Be(e)), n(e);
    }
    function He(e, t) {
        const i = e.matches;
        (t.matches = []),
            ae(i) &&
                i.forEach((e) => {
                    if (!ae(e.indices) || !e.indices.length) return;
                    const { indices: i, value: n } = e;
                    let s = { indices: i, value: n };
                    e.key && (s.key = e.key.src),
                        e.idx > -1 && (s.refIndex = e.idx),
                        t.matches.push(s);
                });
    }
    function $e(e, t) {
        t.score = e.score;
    }
    class qe {
        constructor(e, t = {}, i) {
            (this.options = ne(ne({}, ye), t)),
                (this._keyStore = new fe(this.options.keys)),
                this.setCollection(e, i);
        }
        setCollection(e, t) {
            if (((this._docs = e), t && !(t instanceof Ee)))
                throw new Error("Incorrect 'index' type");
            this._myIndex =
                t ||
                Ce(this.options.keys, this._docs, {
                    getFn: this.options.getFn,
                    fieldNormWeight: this.options.fieldNormWeight,
                });
        }
        add(e) {
            ae(e) && (this._docs.push(e), this._myIndex.add(e));
        }
        remove(e = () => !1) {
            const t = [];
            for (let i = 0, n = this._docs.length; i < n; i += 1) {
                const s = this._docs[i];
                e(s, i) && (this.removeAt(i), (i -= 1), (n -= 1), t.push(s));
            }
            return t;
        }
        removeAt(e) {
            this._docs.splice(e, 1), this._myIndex.removeAt(e);
        }
        getIndex() {
            return this._myIndex;
        }
        search(e, { limit: t = -1 } = {}) {
            const {
                includeMatches: i,
                includeScore: n,
                shouldSort: s,
                sortFn: o,
                ignoreFieldNorm: r,
            } = this.options;
            let c = oe(e)
                ? oe(this._docs[0])
                    ? this._searchStringList(e)
                    : this._searchObjectList(e)
                : this._searchLogical(e);
            return (
                (function (e, { ignoreFieldNorm: t = ye.ignoreFieldNorm }) {
                    e.forEach((e) => {
                        let i = 1;
                        e.matches.forEach(({ key: e, norm: n, score: s }) => {
                            const o = e ? e.weight : null;
                            i *= Math.pow(
                                0 === s && o ? Number.EPSILON : s,
                                (o || 1) * (t ? 1 : n)
                            );
                        }),
                            (e.score = i);
                    });
                })(c, { ignoreFieldNorm: r }),
                s && c.sort(o),
                re(t) && t > -1 && (c = c.slice(0, t)),
                (function (
                    e,
                    t,
                    {
                        includeMatches: i = ye.includeMatches,
                        includeScore: n = ye.includeScore,
                    } = {}
                ) {
                    const s = [];
                    return (
                        i && s.push(He),
                        n && s.push($e),
                        e.map((e) => {
                            const { idx: i } = e,
                                n = { item: t[i], refIndex: i };
                            return (
                                s.length &&
                                    s.forEach((t) => {
                                        t(e, n);
                                    }),
                                n
                            );
                        })
                    );
                })(c, this._docs, { includeMatches: i, includeScore: n })
            );
        }
        _searchStringList(e) {
            const t = Pe(e, this.options),
                { records: i } = this._myIndex,
                n = [];
            return (
                i.forEach(({ v: e, i: i, n: s }) => {
                    if (!ae(e)) return;
                    const { isMatch: o, score: r, indices: c } = t.searchIn(e);
                    o &&
                        n.push({
                            item: e,
                            idx: i,
                            matches: [
                                { score: r, value: e, norm: s, indices: c },
                            ],
                        });
                }),
                n
            );
        }
        _searchLogical(e) {
            const t = Ve(e, this.options),
                i = (e, t, n) => {
                    if (!e.children) {
                        const { keyId: i, searcher: s } = e,
                            o = this._findMatches({
                                key: this._keyStore.get(i),
                                value: this._myIndex.getValueForItemAtKeyId(
                                    t,
                                    i
                                ),
                                searcher: s,
                            });
                        return o && o.length
                            ? [{ idx: n, item: t, matches: o }]
                            : [];
                    }
                    const s = [];
                    for (let o = 0, r = e.children.length; o < r; o += 1) {
                        const r = i(e.children[o], t, n);
                        if (r.length) s.push(...r);
                        else if (e.operator === je) return [];
                    }
                    return s;
                },
                n = {},
                s = [];
            return (
                this._myIndex.records.forEach(({ $: e, i: o }) => {
                    if (ae(e)) {
                        let r = i(t, e, o);
                        r.length &&
                            (n[o] ||
                                ((n[o] = { idx: o, item: e, matches: [] }),
                                s.push(n[o])),
                            r.forEach(({ matches: e }) => {
                                n[o].matches.push(...e);
                            }));
                    }
                }),
                s
            );
        }
        _searchObjectList(e) {
            const t = Pe(e, this.options),
                { keys: i, records: n } = this._myIndex,
                s = [];
            return (
                n.forEach(({ $: e, i: n }) => {
                    if (!ae(e)) return;
                    let o = [];
                    i.forEach((i, n) => {
                        o.push(
                            ...this._findMatches({
                                key: i,
                                value: e[n],
                                searcher: t,
                            })
                        );
                    }),
                        o.length && s.push({ idx: n, item: e, matches: o });
                }),
                s
            );
        }
        _findMatches({ key: e, value: t, searcher: i }) {
            if (!ae(t)) return [];
            let n = [];
            if (se(t))
                t.forEach(({ v: t, i: s, n: o }) => {
                    if (!ae(t)) return;
                    const { isMatch: r, score: c, indices: a } = i.searchIn(t);
                    r &&
                        n.push({
                            score: c,
                            key: e,
                            value: t,
                            idx: s,
                            norm: o,
                            indices: a,
                        });
                });
            else {
                const { v: s, n: o } = t,
                    { isMatch: r, score: c, indices: a } = i.searchIn(s);
                r &&
                    n.push({ score: c, key: e, value: s, norm: o, indices: a });
            }
            return n;
        }
    }
    (qe.version = "7.0.0"),
        (qe.createIndex = Ce),
        (qe.parseIndex = function (
            e,
            {
                getFn: t = ye.getFn,
                fieldNormWeight: i = ye.fieldNormWeight,
            } = {}
        ) {
            const { keys: n, records: s } = e,
                o = new Ee({ getFn: t, fieldNormWeight: i });
            return o.setKeys(n), o.setIndexRecords(s), o;
        }),
        (qe.config = ye),
        (qe.parseQuery = Ve),
        (function (...e) {
            De.push(...e);
        })(
            class {
                constructor(
                    e,
                    {
                        isCaseSensitive: t = ye.isCaseSensitive,
                        includeMatches: i = ye.includeMatches,
                        minMatchCharLength: n = ye.minMatchCharLength,
                        ignoreLocation: s = ye.ignoreLocation,
                        findAllMatches: o = ye.findAllMatches,
                        location: r = ye.location,
                        threshold: c = ye.threshold,
                        distance: a = ye.distance,
                    } = {}
                ) {
                    (this.query = null),
                        (this.options = {
                            isCaseSensitive: t,
                            includeMatches: i,
                            minMatchCharLength: n,
                            findAllMatches: o,
                            ignoreLocation: s,
                            location: r,
                            threshold: c,
                            distance: a,
                        }),
                        (this.pattern = t ? e : e.toLowerCase()),
                        (this.query = (function (e, t = {}) {
                            return e.split("|").map((e) => {
                                let i = e
                                        .trim()
                                        .split(ke)
                                        .filter((e) => e && !!e.trim()),
                                    n = [];
                                for (let e = 0, s = i.length; e < s; e += 1) {
                                    const s = i[e];
                                    let o = !1,
                                        r = -1;
                                    for (; !o && ++r < Ne; ) {
                                        const e = Te[r];
                                        let i = e.isMultiMatch(s);
                                        i && (n.push(new e(i, t)), (o = !0));
                                    }
                                    if (!o)
                                        for (r = -1; ++r < Ne; ) {
                                            const e = Te[r];
                                            let i = e.isSingleMatch(s);
                                            if (i) {
                                                n.push(new e(i, t));
                                                break;
                                            }
                                        }
                                }
                                return n;
                            });
                        })(this.pattern, this.options));
                }
                static condition(e, t) {
                    return t.useExtendedSearch;
                }
                searchIn(e) {
                    const t = this.query;
                    if (!t) return { isMatch: !1, score: 1 };
                    const { includeMatches: i, isCaseSensitive: n } =
                        this.options;
                    e = n ? e : e.toLowerCase();
                    let s = 0,
                        o = [],
                        r = 0;
                    for (let n = 0, c = t.length; n < c; n += 1) {
                        const c = t[n];
                        (o.length = 0), (s = 0);
                        for (let t = 0, n = c.length; t < n; t += 1) {
                            const n = c[t],
                                {
                                    isMatch: a,
                                    indices: h,
                                    score: l,
                                } = n.search(e);
                            if (!a) {
                                (r = 0), (s = 0), (o.length = 0);
                                break;
                            }
                            (s += 1),
                                (r += l),
                                i &&
                                    (Fe.has(n.constructor.type)
                                        ? (o = [...o, ...h])
                                        : o.push(h));
                        }
                        if (s) {
                            let e = { isMatch: !0, score: r / s };
                            return i && (e.indices = o), e;
                        }
                    }
                    return { isMatch: !1, score: 1 };
                }
            }
        );
    var We = (function () {
            function e(e) {
                (this._haystack = []),
                    (this._fuseOptions = i(i({}, e.fuseOptions), {
                        keys: n([], e.searchFields, !0),
                        includeMatches: !0,
                    }));
            }
            return (
                (e.prototype.index = function (e) {
                    (this._haystack = e),
                        this._fuse && this._fuse.setCollection(e);
                }),
                (e.prototype.reset = function () {
                    (this._haystack = []), (this._fuse = void 0);
                }),
                (e.prototype.isEmptyIndex = function () {
                    return !this._haystack.length;
                }),
                (e.prototype.search = function (e) {
                    return (
                        this._fuse ||
                            (this._fuse = new qe(
                                this._haystack,
                                this._fuseOptions
                            )),
                        this._fuse.search(e).map(function (e, t) {
                            return {
                                item: e.item,
                                score: e.score || 0,
                                rank: t + 1,
                            };
                        })
                    );
                }),
                e
            );
        })(),
        Ue = function (e, t, i) {
            var n = e.dataset,
                s = t.customProperties,
                o = t.labelClass,
                r = t.labelDescription;
            o && (n.labelClass = N(o).join(" ")),
                r && (n.labelDescription = r),
                i &&
                    s &&
                    ("string" == typeof s
                        ? (n.customProperties = s)
                        : "object" != typeof s ||
                          (function (e) {
                              for (var t in e)
                                  if (
                                      Object.prototype.hasOwnProperty.call(e, t)
                                  )
                                      return !1;
                              return !0;
                          })(s) ||
                          (n.customProperties = JSON.stringify(s)));
        },
        Ge = function (e, t, i) {
            var n = t && e.querySelector("label[for='".concat(t, "']")),
                s = n && n.innerText;
            s && i.setAttribute("aria-label", s);
        },
        ze = {
            containerOuter: function (e, t, i, n, s, o, r) {
                var c = e.classNames.containerOuter,
                    a = document.createElement("div");
                return (
                    F(a, c),
                    (a.dataset.type = o),
                    t && (a.dir = t),
                    n && (a.tabIndex = 0),
                    i &&
                        (a.setAttribute("role", s ? "combobox" : "listbox"),
                        s
                            ? a.setAttribute("aria-autocomplete", "list")
                            : r ||
                              Ge(
                                  this._docRoot,
                                  this.passedElement.element.id,
                                  a
                              ),
                        a.setAttribute("aria-haspopup", "true"),
                        a.setAttribute("aria-expanded", "false")),
                    r && a.setAttribute("aria-labelledby", r),
                    a
                );
            },
            containerInner: function (e) {
                var t = e.classNames.containerInner,
                    i = document.createElement("div");
                return F(i, t), i;
            },
            itemList: function (e, t) {
                var i = e.searchEnabled,
                    n = e.classNames,
                    s = n.list,
                    o = n.listSingle,
                    r = n.listItems,
                    c = document.createElement("div");
                return (
                    F(c, s),
                    F(c, t ? o : r),
                    this._isSelectElement &&
                        i &&
                        c.setAttribute("role", "listbox"),
                    c
                );
            },
            placeholder: function (e, t) {
                var i = e.allowHTML,
                    n = e.classNames.placeholder,
                    s = document.createElement("div");
                return F(s, n), M(s, i, t), s;
            },
            item: function (e, t, i) {
                var n = e.allowHTML,
                    s = e.removeItemButtonAlignLeft,
                    o = e.removeItemIconText,
                    r = e.removeItemLabelText,
                    c = e.classNames,
                    a = c.item,
                    h = c.button,
                    l = c.highlightedState,
                    u = c.itemSelectable,
                    d = c.placeholder,
                    p = O(t.value),
                    f = document.createElement("div");
                if ((F(f, a), t.labelClass)) {
                    var m = document.createElement("span");
                    M(m, n, t.label), F(m, t.labelClass), f.appendChild(m);
                } else M(f, n, t.label);
                if (
                    ((f.dataset.item = ""),
                    (f.dataset.id = t.id),
                    (f.dataset.value = p),
                    Ue(f, t, !0),
                    (t.disabled || this.containerOuter.isDisabled) &&
                        f.setAttribute("aria-disabled", "true"),
                    this._isSelectElement &&
                        (f.setAttribute("aria-selected", "true"),
                        f.setAttribute("role", "option")),
                    t.placeholder && (F(f, d), (f.dataset.placeholder = "")),
                    F(f, t.highlighted ? l : u),
                    i)
                ) {
                    t.disabled && D(f, u), (f.dataset.deletable = "");
                    var g = document.createElement("button");
                    (g.type = "button"), F(g, h), M(g, !0, x(o, t.value));
                    var v = x(r, t.value);
                    v && g.setAttribute("aria-label", v),
                        (g.dataset.button = ""),
                        s
                            ? f.insertAdjacentElement("afterbegin", g)
                            : f.appendChild(g);
                }
                return f;
            },
            choiceList: function (e, t) {
                var i = e.classNames.list,
                    n = document.createElement("div");
                return (
                    F(n, i),
                    t || n.setAttribute("aria-multiselectable", "true"),
                    n.setAttribute("role", "listbox"),
                    n
                );
            },
            choiceGroup: function (e, t) {
                var i = e.allowHTML,
                    n = e.classNames,
                    s = n.group,
                    o = n.groupHeading,
                    r = n.itemDisabled,
                    c = t.id,
                    a = t.label,
                    h = t.disabled,
                    l = O(a),
                    u = document.createElement("div");
                F(u, s),
                    h && F(u, r),
                    u.setAttribute("role", "group"),
                    (u.dataset.group = ""),
                    (u.dataset.id = c),
                    (u.dataset.value = l),
                    h && u.setAttribute("aria-disabled", "true");
                var d = document.createElement("div");
                return F(d, o), M(d, i, a || ""), u.appendChild(d), u;
            },
            choice: function (e, t, i, n) {
                var s = e.allowHTML,
                    o = e.classNames,
                    r = o.item,
                    c = o.itemChoice,
                    a = o.itemSelectable,
                    h = o.selectedState,
                    l = o.itemDisabled,
                    u = o.description,
                    d = o.placeholder,
                    p = t.label,
                    f = O(t.value),
                    m = document.createElement("div");
                (m.id = t.elementId),
                    F(m, r),
                    F(m, c),
                    n &&
                        "string" == typeof p &&
                        ((p = L(s, p)),
                        (p = { trusted: (p += " (".concat(n, ")")) }));
                var g = m;
                if (t.labelClass) {
                    var v = document.createElement("span");
                    M(v, s, p), F(v, t.labelClass), (g = v), m.appendChild(v);
                } else M(m, s, p);
                if (t.labelDescription) {
                    var _ = "".concat(t.elementId, "-description");
                    g.setAttribute("aria-describedby", _);
                    var y = document.createElement("span");
                    M(y, s, t.labelDescription),
                        (y.id = _),
                        F(y, u),
                        m.appendChild(y);
                }
                return (
                    t.selected && F(m, h),
                    t.placeholder && F(m, d),
                    m.setAttribute("role", t.group ? "treeitem" : "option"),
                    (m.dataset.choice = ""),
                    (m.dataset.id = t.id),
                    (m.dataset.value = f),
                    i && (m.dataset.selectText = i),
                    t.group && (m.dataset.groupId = "".concat(t.group.id)),
                    Ue(m, t, !1),
                    t.disabled
                        ? (F(m, l),
                          (m.dataset.choiceDisabled = ""),
                          m.setAttribute("aria-disabled", "true"))
                        : (F(m, a), (m.dataset.choiceSelectable = "")),
                    m
                );
            },
            input: function (e, t) {
                var i = e.classNames,
                    n = i.input,
                    s = i.inputCloned,
                    o = e.labelId,
                    r = document.createElement("input");
                return (
                    (r.type = "search"),
                    F(r, n),
                    F(r, s),
                    (r.autocomplete = "off"),
                    (r.autocapitalize = "off"),
                    (r.spellcheck = !1),
                    r.setAttribute("role", "textbox"),
                    r.setAttribute("aria-autocomplete", "list"),
                    t
                        ? r.setAttribute("aria-label", t)
                        : o ||
                          Ge(this._docRoot, this.passedElement.element.id, r),
                    r
                );
            },
            dropdown: function (e) {
                var t = e.classNames,
                    i = t.list,
                    n = t.listDropdown,
                    s = document.createElement("div");
                return (
                    F(s, i),
                    F(s, n),
                    s.setAttribute("aria-expanded", "false"),
                    s
                );
            },
            notice: function (e, t, i) {
                var n = e.classNames,
                    s = n.item,
                    o = n.itemChoice,
                    r = n.addChoice,
                    c = n.noResults,
                    a = n.noChoices,
                    h = n.notice;
                void 0 === i && (i = "");
                var l = document.createElement("div");
                switch ((M(l, !0, t), F(l, s), F(l, o), F(l, h), i)) {
                    case ee:
                        F(l, r);
                        break;
                    case Z:
                        F(l, c);
                        break;
                    case Y:
                        F(l, a);
                }
                return (
                    i === ee &&
                        ((l.dataset.choiceSelectable = ""),
                        (l.dataset.choice = "")),
                    l
                );
            },
            option: function (e) {
                var t = O(e.label),
                    i = new Option(t, e.value, !1, e.selected);
                return (
                    Ue(i, e, !0),
                    (i.disabled = e.disabled),
                    e.selected && i.setAttribute("selected", ""),
                    i
                );
            },
        },
        Je =
            "-ms-scroll-limit" in document.documentElement.style &&
            "-ms-ime-align" in document.documentElement.style,
        Xe = {},
        Qe = function (e) {
            if (e) return e.dataset.id ? parseInt(e.dataset.id, 10) : void 0;
        },
        Ye = "[data-choice-selectable]";
    return (function () {
        function e(t, n) {
            void 0 === t && (t = "[data-choice]"), void 0 === n && (n = {});
            var s = this;
            (this.initialisedOK = void 0),
                (this._hasNonChoicePlaceholder = !1),
                (this._lastAddedChoiceId = 0),
                (this._lastAddedGroupId = 0);
            var o = e.defaults;
            (this.config = i(i(i({}, o.allOptions), o.options), n)),
                v.forEach(function (e) {
                    s.config[e] = i(
                        i(i({}, o.allOptions[e]), o.options[e]),
                        n[e]
                    );
                });
            var r = this.config;
            r.silent || this._validateConfig();
            var c = r.shadowRoot || document.documentElement;
            this._docRoot = c;
            var a = "string" == typeof t ? c.querySelector(t) : t;
            if (
                !a ||
                "object" != typeof a ||
                ("INPUT" !== a.tagName && !U(a))
            ) {
                if (!a && "string" == typeof t)
                    throw TypeError(
                        "Selector ".concat(t, " failed to find an element")
                    );
                throw TypeError(
                    "Expected one of the following types text|select-one|select-multiple"
                );
            }
            var h = a.type,
                l = "text" === h;
            (l || 1 !== r.maxItemCount) && (r.singleModeForMultiSelect = !1),
                r.singleModeForMultiSelect && (h = y);
            var u = h === _,
                d = h === y,
                p = u || d;
            if (
                ((this._elementType = h),
                (this._isTextElement = l),
                (this._isSelectOneElement = u),
                (this._isSelectMultipleElement = d),
                (this._isSelectElement = u || d),
                (this._canAddUserChoices =
                    (l && r.addItems) || (p && r.addChoices)),
                "boolean" != typeof r.renderSelectedChoices &&
                    (r.renderSelectedChoices =
                        "always" === r.renderSelectedChoices || u),
                (r.closeDropdownOnSelect =
                    "auto" === r.closeDropdownOnSelect
                        ? l || u || r.singleModeForMultiSelect
                        : $(r.closeDropdownOnSelect)),
                r.placeholder &&
                    (r.placeholderValue
                        ? (this._hasNonChoicePlaceholder = !0)
                        : a.dataset.placeholder &&
                          ((this._hasNonChoicePlaceholder = !0),
                          (r.placeholderValue = a.dataset.placeholder))),
                n.addItemFilter && "function" != typeof n.addItemFilter)
            ) {
                var f =
                    n.addItemFilter instanceof RegExp
                        ? n.addItemFilter
                        : new RegExp(n.addItemFilter);
                r.addItemFilter = f.test.bind(f);
            }
            if (
                ((this.passedElement = this._isTextElement
                    ? new H({ element: a, classNames: r.classNames })
                    : new G({
                          element: a,
                          classNames: r.classNames,
                          template: function (e) {
                              return s._templates.option(e);
                          },
                          extractPlaceholder:
                              r.placeholder && !this._hasNonChoicePlaceholder,
                      })),
                (this.initialised = !1),
                (this._store = new Q(r)),
                (this._currentValue = ""),
                (r.searchEnabled = (!l && r.searchEnabled) || d),
                (this._canSearch = r.searchEnabled),
                (this._isScrollingOnIe = !1),
                (this._highlightPosition = 0),
                (this._wasTap = !0),
                (this._placeholderValue = this._generatePlaceholderValue()),
                (this._baseId = (function (e) {
                    var t =
                        e.id ||
                        (e.name && "".concat(e.name, "-").concat(S(2))) ||
                        S(4);
                    return (
                        (t = t.replace(/(:|\.|\[|\]|,)/g, "")),
                        "".concat("choices-", "-").concat(t)
                    );
                })(a)),
                (this._direction = a.dir),
                !this._direction)
            ) {
                var m = window.getComputedStyle(a).direction;
                m !==
                    window.getComputedStyle(document.documentElement)
                        .direction && (this._direction = m);
            }
            if (
                ((this._idNames = { itemChoice: "item-choice" }),
                (this._templates = o.templates),
                (this._render = this._render.bind(this)),
                (this._onFocus = this._onFocus.bind(this)),
                (this._onBlur = this._onBlur.bind(this)),
                (this._onKeyUp = this._onKeyUp.bind(this)),
                (this._onKeyDown = this._onKeyDown.bind(this)),
                (this._onInput = this._onInput.bind(this)),
                (this._onClick = this._onClick.bind(this)),
                (this._onTouchMove = this._onTouchMove.bind(this)),
                (this._onTouchEnd = this._onTouchEnd.bind(this)),
                (this._onMouseDown = this._onMouseDown.bind(this)),
                (this._onMouseOver = this._onMouseOver.bind(this)),
                (this._onFormReset = this._onFormReset.bind(this)),
                (this._onSelectKey = this._onSelectKey.bind(this)),
                (this._onEnterKey = this._onEnterKey.bind(this)),
                (this._onEscapeKey = this._onEscapeKey.bind(this)),
                (this._onDirectionKey = this._onDirectionKey.bind(this)),
                (this._onDeleteKey = this._onDeleteKey.bind(this)),
                this.passedElement.isActive)
            )
                return (
                    r.silent ||
                        console.warn(
                            "Trying to initialise Choices on element already initialised",
                            { element: t }
                        ),
                    (this.initialised = !0),
                    void (this.initialisedOK = !1)
                );
            this.init(),
                (this._initialItems = this._store.items.map(function (e) {
                    return e.value;
                }));
        }
        return (
            Object.defineProperty(e, "defaults", {
                get: function () {
                    return Object.preventExtensions({
                        get options() {
                            return Xe;
                        },
                        get allOptions() {
                            return z;
                        },
                        get templates() {
                            return ze;
                        },
                    });
                },
                enumerable: !1,
                configurable: !0,
            }),
            (e.prototype.init = function () {
                if (!this.initialised && void 0 === this.initialisedOK) {
                    (this._searcher = new We(this.config)),
                        this._loadChoices(),
                        this._createTemplates(),
                        this._createElements(),
                        this._createStructure(),
                        (this._isTextElement && !this.config.addItems) ||
                        this.passedElement.element.hasAttribute("disabled") ||
                        this.passedElement.element.closest("fieldset:disabled")
                            ? this.disable()
                            : (this.enable(), this._addEventListeners()),
                        this._initStore(),
                        (this.initialised = !0),
                        (this.initialisedOK = !0);
                    var e = this.config.callbackOnInit;
                    "function" == typeof e && e.call(this);
                }
            }),
            (e.prototype.destroy = function () {
                this.initialised &&
                    (this._removeEventListeners(),
                    this.passedElement.reveal(),
                    this.containerOuter.unwrap(this.passedElement.element),
                    (this._store._listeners = []),
                    this.clearStore(!1),
                    this._stopSearch(),
                    (this._templates = e.defaults.templates),
                    (this.initialised = !1),
                    (this.initialisedOK = void 0));
            }),
            (e.prototype.enable = function () {
                return (
                    this.passedElement.isDisabled &&
                        this.passedElement.enable(),
                    this.containerOuter.isDisabled &&
                        (this._addEventListeners(),
                        this.input.enable(),
                        this.containerOuter.enable()),
                    this
                );
            }),
            (e.prototype.disable = function () {
                return (
                    this.passedElement.isDisabled ||
                        this.passedElement.disable(),
                    this.containerOuter.isDisabled ||
                        (this._removeEventListeners(),
                        this.input.disable(),
                        this.containerOuter.disable()),
                    this
                );
            }),
            (e.prototype.highlightItem = function (e, t) {
                if ((void 0 === t && (t = !0), !e || !e.id)) return this;
                var i = this._store.items.find(function (t) {
                    return t.id === e.id;
                });
                return (
                    !i ||
                        i.highlighted ||
                        (this._store.dispatch(C(i, !0)),
                        t &&
                            this.passedElement.triggerEvent(
                                g,
                                this._getChoiceForOutput(i)
                            )),
                    this
                );
            }),
            (e.prototype.unhighlightItem = function (e, t) {
                if ((void 0 === t && (t = !0), !e || !e.id)) return this;
                var i = this._store.items.find(function (t) {
                    return t.id === e.id;
                });
                return i && i.highlighted
                    ? (this._store.dispatch(C(i, !1)),
                      t &&
                          this.passedElement.triggerEvent(
                              "unhighlightItem",
                              this._getChoiceForOutput(i)
                          ),
                      this)
                    : this;
            }),
            (e.prototype.highlightAll = function () {
                var e = this;
                return (
                    this._store.withTxn(function () {
                        e._store.items.forEach(function (t) {
                            t.highlighted ||
                                (e._store.dispatch(C(t, !0)),
                                e.passedElement.triggerEvent(
                                    g,
                                    e._getChoiceForOutput(t)
                                ));
                        });
                    }),
                    this
                );
            }),
            (e.prototype.unhighlightAll = function () {
                var e = this;
                return (
                    this._store.withTxn(function () {
                        e._store.items.forEach(function (t) {
                            t.highlighted &&
                                (e._store.dispatch(C(t, !1)),
                                e.passedElement.triggerEvent(
                                    g,
                                    e._getChoiceForOutput(t)
                                ));
                        });
                    }),
                    this
                );
            }),
            (e.prototype.removeActiveItemsByValue = function (e) {
                var t = this;
                return (
                    this._store.withTxn(function () {
                        t._store.items
                            .filter(function (t) {
                                return t.value === e;
                            })
                            .forEach(function (e) {
                                return t._removeItem(e);
                            });
                    }),
                    this
                );
            }),
            (e.prototype.removeActiveItems = function (e) {
                var t = this;
                return (
                    this._store.withTxn(function () {
                        t._store.items
                            .filter(function (t) {
                                return t.id !== e;
                            })
                            .forEach(function (e) {
                                return t._removeItem(e);
                            });
                    }),
                    this
                );
            }),
            (e.prototype.removeHighlightedItems = function (e) {
                var t = this;
                return (
                    void 0 === e && (e = !1),
                    this._store.withTxn(function () {
                        t._store.highlightedActiveItems.forEach(function (i) {
                            t._removeItem(i), e && t._triggerChange(i.value);
                        });
                    }),
                    this
                );
            }),
            (e.prototype.showDropdown = function (e) {
                var t = this;
                return (
                    this.dropdown.isActive ||
                        requestAnimationFrame(function () {
                            t.dropdown.show();
                            var i = t.dropdown.element.getBoundingClientRect();
                            t.containerOuter.open(i.bottom, i.height),
                                !e && t._canSearch && t.input.focus(),
                                t.passedElement.triggerEvent("showDropdown");
                        }),
                    this
                );
            }),
            (e.prototype.hideDropdown = function (e) {
                var t = this;
                return this.dropdown.isActive
                    ? (requestAnimationFrame(function () {
                          t.dropdown.hide(),
                              t.containerOuter.close(),
                              !e &&
                                  t._canSearch &&
                                  (t.input.removeActiveDescendant(),
                                  t.input.blur()),
                              t.passedElement.triggerEvent("hideDropdown");
                      }),
                      this)
                    : this;
            }),
            (e.prototype.getValue = function (e) {
                var t = this,
                    i = this._store.items.map(function (i) {
                        return e ? i.value : t._getChoiceForOutput(i);
                    });
                return this._isSelectOneElement ||
                    this.config.singleModeForMultiSelect
                    ? i[0]
                    : i;
            }),
            (e.prototype.setValue = function (e) {
                var t = this;
                return this.initialisedOK
                    ? (this._store.withTxn(function () {
                          e.forEach(function (e) {
                              e && t._addChoice(W(e, !1));
                          });
                      }),
                      this._searcher.reset(),
                      this)
                    : (this._warnChoicesInitFailed("setValue"), this);
            }),
            (e.prototype.setChoiceByValue = function (e) {
                var t = this;
                return this.initialisedOK
                    ? (this._isTextElement ||
                          (this._store.withTxn(function () {
                              (Array.isArray(e) ? e : [e]).forEach(function (
                                  e
                              ) {
                                  return t._findAndSelectChoiceByValue(e);
                              }),
                                  t.unhighlightAll();
                          }),
                          this._searcher.reset()),
                      this)
                    : (this._warnChoicesInitFailed("setChoiceByValue"), this);
            }),
            (e.prototype.setChoices = function (e, t, n, s, o) {
                var r = this;
                if (
                    (void 0 === e && (e = []),
                    void 0 === t && (t = "value"),
                    void 0 === n && (n = "label"),
                    void 0 === s && (s = !1),
                    void 0 === o && (o = !0),
                    !this.initialisedOK)
                )
                    return this._warnChoicesInitFailed("setChoices"), this;
                if (!this._isSelectElement)
                    throw new TypeError(
                        "setChoices can't be used with INPUT based Choices"
                    );
                if ("string" != typeof t || !t)
                    throw new TypeError(
                        "value parameter must be a name of 'value' field in passed objects"
                    );
                if ((s && this.clearChoices(), "function" == typeof e)) {
                    var c = e(this);
                    if ("function" == typeof Promise && c instanceof Promise)
                        return new Promise(function (e) {
                            return requestAnimationFrame(e);
                        })
                            .then(function () {
                                return r._handleLoadingState(!0);
                            })
                            .then(function () {
                                return c;
                            })
                            .then(function (e) {
                                return r.setChoices(e, t, n, s);
                            })
                            .catch(function (e) {
                                r.config.silent || console.error(e);
                            })
                            .then(function () {
                                return r._handleLoadingState(!1);
                            })
                            .then(function () {
                                return r;
                            });
                    if (!Array.isArray(c))
                        throw new TypeError(
                            ".setChoices first argument function must return either array of choices or Promise, got: ".concat(
                                typeof c
                            )
                        );
                    return this.setChoices(c, t, n, !1);
                }
                if (!Array.isArray(e))
                    throw new TypeError(
                        ".setChoices must be called either with array of choices with a function resulting into Promise of array of choices"
                    );
                return (
                    this.containerOuter.removeLoadingState(),
                    this._store.withTxn(function () {
                        o && (r._isSearching = !1);
                        var s = "value" === t,
                            c = "label" === n;
                        e.forEach(function (e) {
                            if ("choices" in e) {
                                var o = e;
                                c || (o = i(i({}, o), { label: o[n] })),
                                    r._addGroup(W(o, !0));
                            } else {
                                var a = e;
                                (c && s) ||
                                    (a = i(i({}, a), {
                                        value: a[t],
                                        label: a[n],
                                    })),
                                    r._addChoice(W(a, !1));
                            }
                        }),
                            r.unhighlightAll();
                    }),
                    this._searcher.reset(),
                    this
                );
            }),
            (e.prototype.refresh = function (e, t, i) {
                var n = this;
                return (
                    void 0 === e && (e = !1),
                    void 0 === t && (t = !1),
                    void 0 === i && (i = !1),
                    this._isSelectElement
                        ? (this._store.withTxn(function () {
                              var s = n.passedElement.optionsAsChoices(),
                                  o = {};
                              i ||
                                  n._store.items.forEach(function (e) {
                                      e.id &&
                                          e.active &&
                                          e.selected &&
                                          !e.disabled &&
                                          (o[e.value] = !0);
                                  }),
                                  n.clearStore(!1);
                              var r = function (e) {
                                  i
                                      ? n._store.dispatch(E(e))
                                      : o[e.value] && (e.selected = !0);
                              };
                              s.forEach(function (e) {
                                  "choices" in e ? e.choices.forEach(r) : r(e);
                              }),
                                  n._addPredefinedChoices(s, t, e),
                                  n._isSearching &&
                                      n._searchChoices(n.input.value);
                          }),
                          this)
                        : (this.config.silent ||
                              console.warn(
                                  "refresh method can only be used on choices backed by a <select> element"
                              ),
                          this)
                );
            }),
            (e.prototype.removeChoice = function (e) {
                var t = this._store.choices.find(function (t) {
                    return t.value === e;
                });
                return t
                    ? (this._clearNotice(),
                      this._store.dispatch(b(t)),
                      this._searcher.reset(),
                      t.selected &&
                          this.passedElement.triggerEvent(
                              m,
                              this._getChoiceForOutput(t)
                          ),
                      this)
                    : this;
            }),
            (e.prototype.clearChoices = function () {
                var e = this;
                return (
                    this._store.withTxn(function () {
                        e._store.choices.forEach(function (t) {
                            t.selected || e._store.dispatch(b(t));
                        });
                    }),
                    this._searcher.reset(),
                    this
                );
            }),
            (e.prototype.clearStore = function (e) {
                return (
                    void 0 === e && (e = !0),
                    this._stopSearch(),
                    e && this.passedElement.element.replaceChildren(""),
                    this.itemList.element.replaceChildren(""),
                    this.choiceList.element.replaceChildren(""),
                    this._store.reset(),
                    (this._lastAddedChoiceId = 0),
                    (this._lastAddedGroupId = 0),
                    this._searcher.reset(),
                    this
                );
            }),
            (e.prototype.clearInput = function () {
                return (
                    this.input.clear(!this._isSelectOneElement),
                    this._stopSearch(),
                    this
                );
            }),
            (e.prototype._validateConfig = function () {
                var e,
                    t,
                    i,
                    n = this.config,
                    s =
                        ((e = z),
                        (t = Object.keys(n).sort()),
                        (i = Object.keys(e).sort()),
                        t.filter(function (e) {
                            return i.indexOf(e) < 0;
                        }));
                s.length &&
                    console.warn(
                        "Unknown config option(s) passed",
                        s.join(", ")
                    ),
                    n.allowHTML &&
                        n.allowHtmlUserInput &&
                        (n.addItems &&
                            console.warn(
                                "Warning: allowHTML/allowHtmlUserInput/addItems all being true is strongly not recommended and may lead to XSS attacks"
                            ),
                        n.addChoices &&
                            console.warn(
                                "Warning: allowHTML/allowHtmlUserInput/addChoices all being true is strongly not recommended and may lead to XSS attacks"
                            ));
            }),
            (e.prototype._render = function (e) {
                void 0 === e && (e = { choices: !0, groups: !0, items: !0 }),
                    this._store.inTxn() ||
                        (this._isSelectElement &&
                            (e.choices || e.groups) &&
                            this._renderChoices(),
                        e.items && this._renderItems());
            }),
            (e.prototype._renderChoices = function () {
                var e = this;
                if (this._canAddItems()) {
                    var t = this.config,
                        i = this._isSearching,
                        n = this._store,
                        s = n.activeGroups,
                        o = n.activeChoices,
                        r = 0;
                    if (
                        (i && t.searchResultLimit > 0
                            ? (r = t.searchResultLimit)
                            : t.renderChoiceLimit > 0 &&
                              (r = t.renderChoiceLimit),
                        this._isSelectElement)
                    ) {
                        var c = o.filter(function (e) {
                            return !e.element;
                        });
                        c.length && this.passedElement.addOptions(c);
                    }
                    var a = document.createDocumentFragment(),
                        h = function (e) {
                            return e.filter(function (e) {
                                return (
                                    !e.placeholder &&
                                    (i
                                        ? !!e.rank
                                        : t.renderSelectedChoices ||
                                          !e.selected)
                                );
                            });
                        },
                        l = !1,
                        u = function (n, s, o) {
                            i ? n.sort(T) : t.shouldSort && n.sort(t.sorter);
                            var c = n.length;
                            (c = !s && r && c > r ? r : c),
                                c--,
                                n.every(function (n, s) {
                                    var r =
                                        n.choiceEl ||
                                        e._templates.choice(
                                            t,
                                            n,
                                            t.itemSelectText,
                                            o
                                        );
                                    return (
                                        (n.choiceEl = r),
                                        a.appendChild(r),
                                        n.disabled ||
                                            (!i && n.selected) ||
                                            (l = !0),
                                        s < c
                                    );
                                });
                        };
                    o.length &&
                        (t.resetScrollPosition &&
                            requestAnimationFrame(function () {
                                return e.choiceList.scrollToTop();
                            }),
                        this._hasNonChoicePlaceholder ||
                            i ||
                            !this._isSelectOneElement ||
                            u(
                                o.filter(function (e) {
                                    return e.placeholder && !e.group;
                                }),
                                !1,
                                void 0
                            ),
                        s.length && !i
                            ? (t.shouldSort && s.sort(t.sorter),
                              u(
                                  o.filter(function (e) {
                                      return !e.placeholder && !e.group;
                                  }),
                                  !1,
                                  void 0
                              ),
                              s.forEach(function (n) {
                                  var s = h(n.choices);
                                  if (s.length) {
                                      if (n.label) {
                                          var o =
                                              n.groupEl ||
                                              e._templates.choiceGroup(
                                                  e.config,
                                                  n
                                              );
                                          (n.groupEl = o),
                                              o.remove(),
                                              a.appendChild(o);
                                      }
                                      u(
                                          s,
                                          !0,
                                          t.appendGroupInSearch && i
                                              ? n.label
                                              : void 0
                                      );
                                  }
                              }))
                            : u(h(o), !1, void 0)),
                        l ||
                            (this._notice ||
                                (this._notice = {
                                    text: A(
                                        i ? t.noResultsText : t.noChoicesText
                                    ),
                                    type: i ? Z : Y,
                                }),
                            a.replaceChildren("")),
                        this._renderNotice(a),
                        this.choiceList.element.replaceChildren(a),
                        l && this._highlightChoice();
                }
            }),
            (e.prototype._renderItems = function () {
                var e = this,
                    t = this._store.items || [],
                    i = this.itemList.element,
                    n = this.config,
                    s = document.createDocumentFragment(),
                    o = function (e) {
                        return i.querySelector(
                            '[data-item][data-id="'.concat(e.id, '"]')
                        );
                    },
                    r = function (t) {
                        var i = t.itemEl;
                        (i && i.parentElement) ||
                            ((i =
                                o(t) ||
                                e._templates.item(n, t, n.removeItemButton)),
                            (t.itemEl = i),
                            s.appendChild(i));
                    };
                t.forEach(r);
                var c = !!s.childNodes.length;
                if (this._isSelectOneElement && this._hasNonChoicePlaceholder) {
                    var a = i.children.length;
                    if (c || a > 1) {
                        var h = i.querySelector(k(n.classNames.placeholder));
                        h && h.remove();
                    } else
                        a ||
                            ((c = !0),
                            r(
                                W(
                                    {
                                        selected: !0,
                                        value: "",
                                        label: n.placeholderValue || "",
                                        placeholder: !0,
                                    },
                                    !1
                                )
                            ));
                }
                c &&
                    (i.append(s),
                    n.shouldSortItems &&
                        !this._isSelectOneElement &&
                        (t.sort(n.sorter),
                        t.forEach(function (e) {
                            var t = o(e);
                            t && (t.remove(), s.append(t));
                        }),
                        i.append(s))),
                    this._isTextElement &&
                        (this.passedElement.value = t
                            .map(function (e) {
                                return e.value;
                            })
                            .join(n.delimiter));
            }),
            (e.prototype._displayNotice = function (e, t, i) {
                void 0 === i && (i = !0);
                var n = this._notice;
                n &&
                ((n.type === t && n.text === e) ||
                    (n.type === ee && (t === Z || t === Y)))
                    ? i && this.showDropdown(!0)
                    : (this._clearNotice(),
                      (this._notice = e ? { text: e, type: t } : void 0),
                      this._renderNotice(),
                      i && e && this.showDropdown(!0));
            }),
            (e.prototype._clearNotice = function () {
                if (this._notice) {
                    var e = this.choiceList.element.querySelector(
                        k(this.config.classNames.notice)
                    );
                    e && e.remove(), (this._notice = void 0);
                }
            }),
            (e.prototype._renderNotice = function (e) {
                var t = this._notice;
                if (t) {
                    var i = this._templates.notice(this.config, t.text, t.type);
                    e ? e.append(i) : this.choiceList.prepend(i);
                }
            }),
            (e.prototype._getChoiceForOutput = function (e, t) {
                return {
                    id: e.id,
                    highlighted: e.highlighted,
                    labelClass: e.labelClass,
                    labelDescription: e.labelDescription,
                    customProperties: e.customProperties,
                    disabled: e.disabled,
                    active: e.active,
                    label: e.label,
                    placeholder: e.placeholder,
                    value: e.value,
                    groupValue: e.group ? e.group.label : void 0,
                    element: e.element,
                    keyCode: t,
                };
            }),
            (e.prototype._triggerChange = function (e) {
                null != e &&
                    this.passedElement.triggerEvent("change", { value: e });
            }),
            (e.prototype._handleButtonAction = function (e) {
                var t = this,
                    i = this._store.items;
                if (
                    i.length &&
                    this.config.removeItems &&
                    this.config.removeItemButton
                ) {
                    var n = e && Qe(e.parentElement),
                        s =
                            n &&
                            i.find(function (e) {
                                return e.id === n;
                            });
                    s &&
                        this._store.withTxn(function () {
                            if (
                                (t._removeItem(s),
                                t._triggerChange(s.value),
                                t._isSelectOneElement &&
                                    !t._hasNonChoicePlaceholder)
                            ) {
                                var e = t._store.choices
                                    .reverse()
                                    .find(function (e) {
                                        return !e.disabled && e.placeholder;
                                    });
                                e &&
                                    (t._addItem(e),
                                    t.unhighlightAll(),
                                    e.value && t._triggerChange(e.value));
                            }
                        });
                }
            }),
            (e.prototype._handleItemAction = function (e, t) {
                var i = this;
                void 0 === t && (t = !1);
                var n = this._store.items;
                if (
                    n.length &&
                    this.config.removeItems &&
                    !this._isSelectOneElement
                ) {
                    var s = Qe(e);
                    s &&
                        (n.forEach(function (e) {
                            e.id !== s || e.highlighted
                                ? !t && e.highlighted && i.unhighlightItem(e)
                                : i.highlightItem(e);
                        }),
                        this.input.focus());
                }
            }),
            (e.prototype._handleChoiceAction = function (e) {
                var t = this,
                    i = Qe(e),
                    n = i && this._store.getChoiceById(i);
                if (!n || n.disabled) return !1;
                var s = this.dropdown.isActive;
                if (!n.selected) {
                    if (!this._canAddItems()) return !0;
                    this._store.withTxn(function () {
                        t._addItem(n, !0, !0),
                            t.clearInput(),
                            t.unhighlightAll();
                    }),
                        this._triggerChange(n.value);
                }
                return (
                    s &&
                        this.config.closeDropdownOnSelect &&
                        (this.hideDropdown(!0),
                        this.containerOuter.element.focus()),
                    !0
                );
            }),
            (e.prototype._handleBackspace = function (e) {
                var t = this.config;
                if (t.removeItems && e.length) {
                    var i = e[e.length - 1],
                        n = e.some(function (e) {
                            return e.highlighted;
                        });
                    t.editItems && !n && i
                        ? ((this.input.value = i.value),
                          this.input.setWidth(),
                          this._removeItem(i),
                          this._triggerChange(i.value))
                        : (n || this.highlightItem(i, !1),
                          this.removeHighlightedItems(!0));
                }
            }),
            (e.prototype._loadChoices = function () {
                var e,
                    t = this.config;
                if (this._isTextElement) {
                    if (
                        ((this._presetChoices = t.items.map(function (e) {
                            return W(e, !1);
                        })),
                        this.passedElement.value)
                    ) {
                        var i = this.passedElement.value
                            .split(t.delimiter)
                            .map(function (e) {
                                return W(e, !1);
                            });
                        this._presetChoices = this._presetChoices.concat(i);
                    }
                    this._presetChoices.forEach(function (e) {
                        e.selected = !0;
                    });
                } else if (this._isSelectElement) {
                    this._presetChoices = t.choices.map(function (e) {
                        return W(e, !0);
                    });
                    var n = this.passedElement.optionsAsChoices();
                    n && (e = this._presetChoices).push.apply(e, n);
                }
            }),
            (e.prototype._handleLoadingState = function (e) {
                void 0 === e && (e = !0);
                var t = this.itemList.element;
                e
                    ? (this.disable(),
                      this.containerOuter.addLoadingState(),
                      this._isSelectOneElement
                          ? t.replaceChildren(
                                this._templates.placeholder(
                                    this.config,
                                    this.config.loadingText
                                )
                            )
                          : (this.input.placeholder = this.config.loadingText))
                    : (this.enable(),
                      this.containerOuter.removeLoadingState(),
                      this._isSelectOneElement
                          ? (t.replaceChildren(""), this._render())
                          : (this.input.placeholder =
                                this._placeholderValue || ""));
            }),
            (e.prototype._handleSearch = function (e) {
                if (this.input.isFocussed)
                    if (null != e && e.length >= this.config.searchFloor) {
                        var t = this.config.searchChoices
                            ? this._searchChoices(e)
                            : 0;
                        null !== t &&
                            this.passedElement.triggerEvent(f, {
                                value: e,
                                resultCount: t,
                            });
                    } else
                        this._store.choices.some(function (e) {
                            return !e.active;
                        }) && this._stopSearch();
            }),
            (e.prototype._canAddItems = function () {
                var e = this.config,
                    t = e.maxItemCount,
                    i = e.maxItemText;
                return !(
                    !e.singleModeForMultiSelect &&
                    t > 0 &&
                    t <= this._store.items.length &&
                    (this.choiceList.element.replaceChildren(""),
                    this._displayNotice("function" == typeof i ? i(t) : i, ee),
                    1)
                );
            }),
            (e.prototype._canCreateItem = function (e) {
                var t = this.config,
                    i = !0,
                    n = "";
                if (
                    (i &&
                        "function" == typeof t.addItemFilter &&
                        !t.addItemFilter(e) &&
                        ((i = !1), (n = x(t.customAddItemText, e))),
                    i)
                ) {
                    var s = this._store.choices.find(function (i) {
                        return t.valueComparer(i.value, e);
                    });
                    if (this._isSelectElement) {
                        if (s) return this._displayNotice("", ee), !1;
                    } else
                        this._isTextElement &&
                            !t.duplicateItemsAllowed &&
                            s &&
                            ((i = !1), (n = x(t.uniqueItemText, e)));
                }
                return (
                    i && (n = x(t.addItemText, e)),
                    n && this._displayNotice(n, ee),
                    i
                );
            }),
            (e.prototype._searchChoices = function (e) {
                var t = e.trim().replace(/\s{2,}/, " ");
                if (!t.length || t === this._currentValue) return null;
                var i = this._searcher;
                i.isEmptyIndex() && i.index(this._store.searchableChoices);
                var n = i.search(t);
                (this._currentValue = t),
                    (this._highlightPosition = 0),
                    (this._isSearching = !0);
                var s = this._notice;
                return (
                    (s && s.type) !== ee &&
                        (n.length
                            ? this._clearNotice()
                            : this._displayNotice(
                                  A(this.config.noResultsText),
                                  Z
                              )),
                    this._store.dispatch(
                        (function (e) {
                            return { type: c, results: e };
                        })(n)
                    ),
                    n.length
                );
            }),
            (e.prototype._stopSearch = function () {
                this._isSearching &&
                    ((this._currentValue = ""),
                    (this._isSearching = !1),
                    this._clearNotice(),
                    this._store.dispatch({ type: a, active: !0 }),
                    this.passedElement.triggerEvent(f, {
                        value: "",
                        resultCount: 0,
                    }));
            }),
            (e.prototype._addEventListeners = function () {
                var e = this._docRoot,
                    t = this.containerOuter.element,
                    i = this.input.element;
                e.addEventListener("touchend", this._onTouchEnd, !0),
                    t.addEventListener("keydown", this._onKeyDown, !0),
                    t.addEventListener("mousedown", this._onMouseDown, !0),
                    e.addEventListener("click", this._onClick, { passive: !0 }),
                    e.addEventListener("touchmove", this._onTouchMove, {
                        passive: !0,
                    }),
                    this.dropdown.element.addEventListener(
                        "mouseover",
                        this._onMouseOver,
                        { passive: !0 }
                    ),
                    this._isSelectOneElement &&
                        (t.addEventListener("focus", this._onFocus, {
                            passive: !0,
                        }),
                        t.addEventListener("blur", this._onBlur, {
                            passive: !0,
                        })),
                    i.addEventListener("keyup", this._onKeyUp, { passive: !0 }),
                    i.addEventListener("input", this._onInput, { passive: !0 }),
                    i.addEventListener("focus", this._onFocus, { passive: !0 }),
                    i.addEventListener("blur", this._onBlur, { passive: !0 }),
                    i.form &&
                        i.form.addEventListener("reset", this._onFormReset, {
                            passive: !0,
                        }),
                    this.input.addEventListeners();
            }),
            (e.prototype._removeEventListeners = function () {
                var e = this._docRoot,
                    t = this.containerOuter.element,
                    i = this.input.element;
                e.removeEventListener("touchend", this._onTouchEnd, !0),
                    t.removeEventListener("keydown", this._onKeyDown, !0),
                    t.removeEventListener("mousedown", this._onMouseDown, !0),
                    e.removeEventListener("click", this._onClick),
                    e.removeEventListener("touchmove", this._onTouchMove),
                    this.dropdown.element.removeEventListener(
                        "mouseover",
                        this._onMouseOver
                    ),
                    this._isSelectOneElement &&
                        (t.removeEventListener("focus", this._onFocus),
                        t.removeEventListener("blur", this._onBlur)),
                    i.removeEventListener("keyup", this._onKeyUp),
                    i.removeEventListener("input", this._onInput),
                    i.removeEventListener("focus", this._onFocus),
                    i.removeEventListener("blur", this._onBlur),
                    i.form &&
                        i.form.removeEventListener("reset", this._onFormReset),
                    this.input.removeEventListeners();
            }),
            (e.prototype._onKeyDown = function (e) {
                var t = e.keyCode,
                    i = this.dropdown.isActive,
                    n =
                        1 === e.key.length ||
                        (2 === e.key.length && e.key.charCodeAt(0) >= 55296) ||
                        "Unidentified" === e.key;
                switch (
                    (this._isTextElement ||
                        i ||
                        (this.showDropdown(),
                        !this.input.isFocussed &&
                            n &&
                            ((this.input.value += e.key),
                            " " === e.key && e.preventDefault())),
                    t)
                ) {
                    case 65:
                        return this._onSelectKey(
                            e,
                            this.itemList.element.hasChildNodes()
                        );
                    case 13:
                        return this._onEnterKey(e, i);
                    case 27:
                        return this._onEscapeKey(e, i);
                    case 38:
                    case 33:
                    case 40:
                    case 34:
                        return this._onDirectionKey(e, i);
                    case 8:
                    case 46:
                        return this._onDeleteKey(
                            e,
                            this._store.items,
                            this.input.isFocussed
                        );
                }
            }),
            (e.prototype._onKeyUp = function () {
                this._canSearch = this.config.searchEnabled;
            }),
            (e.prototype._onInput = function () {
                var e = this.input.value;
                e
                    ? this._canAddItems() &&
                      (this._canSearch && this._handleSearch(e),
                      this._canAddUserChoices &&
                          (this._canCreateItem(e),
                          this._isSelectElement &&
                              ((this._highlightPosition = 0),
                              this._highlightChoice())))
                    : this._isTextElement
                    ? this.hideDropdown(!0)
                    : this._stopSearch();
            }),
            (e.prototype._onSelectKey = function (e, t) {
                (e.ctrlKey || e.metaKey) &&
                    t &&
                    ((this._canSearch = !1),
                    this.config.removeItems &&
                        !this.input.value &&
                        this.input.element === document.activeElement &&
                        this.highlightAll());
            }),
            (e.prototype._onEnterKey = function (e, t) {
                var i = this,
                    n = this.input.value,
                    s = e.target;
                if ((e.preventDefault(), s && s.hasAttribute("data-button")))
                    this._handleButtonAction(s);
                else if (t) {
                    var o = this.dropdown.element.querySelector(
                        k(this.config.classNames.highlightedState)
                    );
                    if (!o || !this._handleChoiceAction(o))
                        if (s && n) {
                            if (this._canAddItems()) {
                                var r = !1;
                                this._store.withTxn(function () {
                                    if (
                                        !(r = i._findAndSelectChoiceByValue(
                                            n,
                                            !0
                                        ))
                                    ) {
                                        if (!i._canAddUserChoices) return;
                                        if (!i._canCreateItem(n)) return;
                                        var e = w(n),
                                            t =
                                                i.config.allowHtmlUserInput ||
                                                e === n
                                                    ? n
                                                    : { escaped: e, raw: n };
                                        i._addChoice(
                                            W(
                                                {
                                                    value: t,
                                                    label: t,
                                                    selected: !0,
                                                },
                                                !1
                                            ),
                                            !0,
                                            !0
                                        ),
                                            (r = !0);
                                    }
                                    i.clearInput(), i.unhighlightAll();
                                }),
                                    r &&
                                        (this._triggerChange(n),
                                        this.config.closeDropdownOnSelect &&
                                            this.hideDropdown(!0));
                            }
                        } else this.hideDropdown(!0);
                } else
                    (this._isSelectElement || this._notice) &&
                        this.showDropdown();
            }),
            (e.prototype._onEscapeKey = function (e, t) {
                t &&
                    (e.stopPropagation(),
                    this.hideDropdown(!0),
                    this.containerOuter.element.focus());
            }),
            (e.prototype._onDirectionKey = function (e, t) {
                var i,
                    n,
                    s,
                    o = e.keyCode;
                if (t || this._isSelectOneElement) {
                    this.showDropdown(), (this._canSearch = !1);
                    var r = 40 === o || 34 === o ? 1 : -1,
                        c = void 0;
                    if (e.metaKey || 34 === o || 33 === o)
                        c = this.dropdown.element.querySelector(
                            r > 0 ? "".concat(Ye, ":last-of-type") : Ye
                        );
                    else {
                        var a = this.dropdown.element.querySelector(
                            k(this.config.classNames.highlightedState)
                        );
                        c = a
                            ? (function (e, t, i) {
                                  void 0 === i && (i = 1);
                                  for (
                                      var n = "".concat(
                                              i > 0 ? "next" : "previous",
                                              "ElementSibling"
                                          ),
                                          s = e[n];
                                      s;

                                  ) {
                                      if (s.matches(t)) return s;
                                      s = s[n];
                                  }
                                  return null;
                              })(a, Ye, r)
                            : this.dropdown.element.querySelector(Ye);
                    }
                    c &&
                        ((i = c),
                        (n = this.choiceList.element),
                        void 0 === (s = r) && (s = 1),
                        (s > 0
                            ? n.scrollTop + n.offsetHeight >=
                              i.offsetTop + i.offsetHeight
                            : i.offsetTop >= n.scrollTop) ||
                            this.choiceList.scrollToChildElement(c, r),
                        this._highlightChoice(c)),
                        e.preventDefault();
                }
            }),
            (e.prototype._onDeleteKey = function (e, t, i) {
                this._isSelectOneElement ||
                    e.target.value ||
                    !i ||
                    (this._handleBackspace(t), e.preventDefault());
            }),
            (e.prototype._onTouchMove = function () {
                this._wasTap && (this._wasTap = !1);
            }),
            (e.prototype._onTouchEnd = function (e) {
                var t = (e || e.touches[0]).target;
                this._wasTap &&
                    this.containerOuter.element.contains(t) &&
                    ((t === this.containerOuter.element ||
                        t === this.containerInner.element) &&
                        (this._isTextElement
                            ? this.input.focus()
                            : this._isSelectMultipleElement &&
                              this.showDropdown()),
                    e.stopPropagation()),
                    (this._wasTap = !0);
            }),
            (e.prototype._onMouseDown = function (e) {
                var t = e.target;
                if (t instanceof HTMLElement) {
                    if (Je && this.choiceList.element.contains(t)) {
                        var i = this.choiceList.element.firstElementChild;
                        this._isScrollingOnIe =
                            "ltr" === this._direction
                                ? e.offsetX >= i.offsetWidth
                                : e.offsetX < i.offsetLeft;
                    }
                    if (t !== this.input.element) {
                        var n = t.closest(
                            "[data-button],[data-item],[data-choice]"
                        );
                        n instanceof HTMLElement &&
                            ("button" in n.dataset
                                ? this._handleButtonAction(n)
                                : "item" in n.dataset
                                ? this._handleItemAction(n, e.shiftKey)
                                : "choice" in n.dataset &&
                                  this._handleChoiceAction(n)),
                            e.preventDefault();
                    }
                }
            }),
            (e.prototype._onMouseOver = function (e) {
                var t = e.target;
                t instanceof HTMLElement &&
                    "choice" in t.dataset &&
                    this._highlightChoice(t);
            }),
            (e.prototype._onClick = function (e) {
                var t = e.target,
                    i = this.containerOuter;
                i.element.contains(t)
                    ? this.dropdown.isActive || i.isDisabled
                        ? this._isSelectOneElement &&
                          t !== this.input.element &&
                          !this.dropdown.element.contains(t) &&
                          this.hideDropdown()
                        : this._isTextElement
                        ? document.activeElement !== this.input.element &&
                          this.input.focus()
                        : (this.showDropdown(), i.element.focus())
                    : (i.removeFocusState(),
                      this.hideDropdown(!0),
                      this.unhighlightAll());
            }),
            (e.prototype._onFocus = function (e) {
                var t = e.target,
                    i = this.containerOuter;
                if (t && i.element.contains(t)) {
                    var n = t === this.input.element;
                    this._isTextElement
                        ? n && i.addFocusState()
                        : this._isSelectMultipleElement
                        ? n && (this.showDropdown(!0), i.addFocusState())
                        : (i.addFocusState(), n && this.showDropdown(!0));
                }
            }),
            (e.prototype._onBlur = function (e) {
                var t = e.target,
                    i = this.containerOuter;
                if (t && i.element.contains(t) && !this._isScrollingOnIe) {
                    var n = t === this.input.element;
                    this._isTextElement || this._isSelectMultipleElement
                        ? n &&
                          (i.removeFocusState(),
                          this.hideDropdown(!0),
                          this.unhighlightAll())
                        : (i.removeFocusState(),
                          (n || (t === i.element && !this._canSearch)) &&
                              this.hideDropdown(!0));
                } else (this._isScrollingOnIe = !1), this.input.element.focus();
            }),
            (e.prototype._onFormReset = function () {
                var e = this;
                this._store.withTxn(function () {
                    e.clearInput(),
                        e.hideDropdown(),
                        e.refresh(!1, !1, !0),
                        e._initialItems.length &&
                            e.setChoiceByValue(e._initialItems);
                });
            }),
            (e.prototype._highlightChoice = function (e) {
                void 0 === e && (e = null);
                var t = Array.from(this.dropdown.element.querySelectorAll(Ye));
                if (t.length) {
                    var i = e,
                        n = this.config.classNames.highlightedState;
                    Array.from(
                        this.dropdown.element.querySelectorAll(k(n))
                    ).forEach(function (e) {
                        D(e, n), e.setAttribute("aria-selected", "false");
                    }),
                        i
                            ? (this._highlightPosition = t.indexOf(i))
                            : (i =
                                  t.length > this._highlightPosition
                                      ? t[this._highlightPosition]
                                      : t[t.length - 1]) || (i = t[0]),
                        F(i, n),
                        i.setAttribute("aria-selected", "true"),
                        this.passedElement.triggerEvent("highlightChoice", {
                            el: i,
                        }),
                        this.dropdown.isActive &&
                            (this.input.setActiveDescendant(i.id),
                            this.containerOuter.setActiveDescendant(i.id));
                }
            }),
            (e.prototype._addItem = function (e, t, i) {
                if ((void 0 === t && (t = !0), void 0 === i && (i = !1), !e.id))
                    throw new TypeError(
                        "item.id must be set before _addItem is called for a choice/item"
                    );
                (this.config.singleModeForMultiSelect ||
                    this._isSelectOneElement) &&
                    this.removeActiveItems(e.id),
                    this._store.dispatch(
                        (function (e) {
                            return { type: u, item: e };
                        })(e)
                    ),
                    t &&
                        (this.passedElement.triggerEvent(
                            "addItem",
                            this._getChoiceForOutput(e)
                        ),
                        i &&
                            this.passedElement.triggerEvent(
                                "choice",
                                this._getChoiceForOutput(e)
                            ));
            }),
            (e.prototype._removeItem = function (e) {
                e.id &&
                    (this._store.dispatch(E(e)),
                    this.passedElement.triggerEvent(
                        m,
                        this._getChoiceForOutput(e)
                    ));
            }),
            (e.prototype._addChoice = function (e, t, i) {
                if ((void 0 === t && (t = !0), void 0 === i && (i = !1), e.id))
                    throw new TypeError(
                        "Can not re-add a choice which has already been added"
                    );
                var n = this.config;
                if (
                    (!this._isSelectElement && n.duplicateItemsAllowed) ||
                    !this._store.choices.find(function (t) {
                        return n.valueComparer(t.value, e.value);
                    })
                ) {
                    this._lastAddedChoiceId++,
                        (e.id = this._lastAddedChoiceId),
                        (e.elementId = ""
                            .concat(this._baseId, "-")
                            .concat(this._idNames.itemChoice, "-")
                            .concat(e.id));
                    var s = n.prependValue,
                        r = n.appendValue;
                    s && (e.value = s + e.value),
                        r && (e.value += r.toString()),
                        (s || r) && e.element && (e.element.value = e.value),
                        this._clearNotice(),
                        this._store.dispatch(
                            (function (e) {
                                return { type: o, choice: e };
                            })(e)
                        ),
                        e.selected && this._addItem(e, t, i);
                }
            }),
            (e.prototype._addGroup = function (e, t) {
                var i = this;
                if ((void 0 === t && (t = !0), e.id))
                    throw new TypeError(
                        "Can not re-add a group which has already been added"
                    );
                this._store.dispatch(
                    (function (e) {
                        return { type: l, group: e };
                    })(e)
                ),
                    e.choices &&
                        (this._lastAddedGroupId++,
                        (e.id = this._lastAddedGroupId),
                        e.choices.forEach(function (n) {
                            (n.group = e),
                                e.disabled && (n.disabled = !0),
                                i._addChoice(n, t);
                        }));
            }),
            (e.prototype._createTemplates = function () {
                var e = this,
                    t = this.config.callbackOnCreateTemplates,
                    i = {};
                "function" == typeof t && (i = t.call(this, I, L, N));
                var n = {};
                Object.keys(this._templates).forEach(function (t) {
                    n[t] = t in i ? i[t].bind(e) : e._templates[t].bind(e);
                }),
                    (this._templates = n);
            }),
            (e.prototype._createElements = function () {
                var e = this._templates,
                    t = this.config,
                    i = this._isSelectOneElement,
                    n = t.position,
                    s = t.classNames,
                    o = this._elementType;
                (this.containerOuter = new R({
                    element: e.containerOuter(
                        t,
                        this._direction,
                        this._isSelectElement,
                        i,
                        t.searchEnabled,
                        o,
                        t.labelId
                    ),
                    classNames: s,
                    type: o,
                    position: n,
                })),
                    (this.containerInner = new R({
                        element: e.containerInner(t),
                        classNames: s,
                        type: o,
                        position: n,
                    })),
                    (this.input = new K({
                        element: e.input(t, this._placeholderValue),
                        classNames: s,
                        type: o,
                        preventPaste: !t.paste,
                    })),
                    (this.choiceList = new B({ element: e.choiceList(t, i) })),
                    (this.itemList = new B({ element: e.itemList(t, i) })),
                    (this.dropdown = new j({
                        element: e.dropdown(t),
                        classNames: s,
                        type: o,
                    }));
            }),
            (e.prototype._createStructure = function () {
                var e = this,
                    t = e.containerInner,
                    i = e.containerOuter,
                    n = e.passedElement,
                    s = this.dropdown.element;
                n.conceal(),
                    t.wrap(n.element),
                    i.wrap(t.element),
                    this._isSelectOneElement
                        ? (this.input.placeholder =
                              this.config.searchPlaceholderValue || "")
                        : (this._placeholderValue &&
                              (this.input.placeholder = this._placeholderValue),
                          this.input.setWidth()),
                    i.element.appendChild(t.element),
                    i.element.appendChild(s),
                    t.element.appendChild(this.itemList.element),
                    s.appendChild(this.choiceList.element),
                    this._isSelectOneElement
                        ? this.config.searchEnabled &&
                          s.insertBefore(this.input.element, s.firstChild)
                        : t.element.appendChild(this.input.element),
                    (this._highlightPosition = 0),
                    (this._isSearching = !1);
            }),
            (e.prototype._initStore = function () {
                var e = this;
                this._store.subscribe(this._render).withTxn(function () {
                    e._addPredefinedChoices(
                        e._presetChoices,
                        e._isSelectOneElement && !e._hasNonChoicePlaceholder,
                        !1
                    );
                }),
                    (!this._store.choices.length ||
                        (this._isSelectOneElement &&
                            this._hasNonChoicePlaceholder)) &&
                        this._render();
            }),
            (e.prototype._addPredefinedChoices = function (e, t, i) {
                var n = this;
                void 0 === t && (t = !1),
                    void 0 === i && (i = !0),
                    t &&
                        -1 ===
                            e.findIndex(function (e) {
                                return e.selected;
                            }) &&
                        e.some(function (e) {
                            return (
                                !e.disabled &&
                                !("choices" in e) &&
                                ((e.selected = !0), !0)
                            );
                        }),
                    e.forEach(function (e) {
                        "choices" in e
                            ? n._isSelectElement && n._addGroup(e, i)
                            : n._addChoice(e, i);
                    });
            }),
            (e.prototype._findAndSelectChoiceByValue = function (e, t) {
                var i = this;
                void 0 === t && (t = !1);
                var n = this._store.choices.find(function (t) {
                    return i.config.valueComparer(t.value, e);
                });
                return !(
                    !n ||
                    n.disabled ||
                    n.selected ||
                    (this._addItem(n, !0, t), 0)
                );
            }),
            (e.prototype._generatePlaceholderValue = function () {
                var e = this.config;
                if (!e.placeholder) return null;
                if (this._hasNonChoicePlaceholder) return e.placeholderValue;
                if (this._isSelectElement) {
                    var t = this.passedElement.placeholderOption;
                    return t ? t.text : null;
                }
                return null;
            }),
            (e.prototype._warnChoicesInitFailed = function (e) {
                if (!this.config.silent) {
                    if (!this.initialised)
                        throw new TypeError(
                            "".concat(
                                e,
                                " called on a non-initialised instance of Choices"
                            )
                        );
                    if (!this.initialisedOK)
                        throw new TypeError(
                            "".concat(
                                e,
                                " called for an element which has multiple instances of Choices initialised on it"
                            )
                        );
                }
            }),
            (e.version = "11.0.2"),
            e
        );
    })();
});
