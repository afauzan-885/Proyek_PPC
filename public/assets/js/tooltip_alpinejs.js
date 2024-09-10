(() => {
    var V = "top",
        _ = "bottom",
        k = "right",
        W = "left",
        Ve = "auto",
        ye = [V, _, k, W],
        ce = "start",
        lt = "end",
        Zt = "clippingParents",
        ct = "viewport",
        Ie = "popper",
        er = "reference",
        Tt = ye.reduce(function (t, e) {
            return t.concat([e + "-" + ce, e + "-" + lt]);
        }, []),
        dt = [].concat(ye, [Ve]).reduce(function (t, e) {
            return t.concat([e, e + "-" + ce, e + "-" + lt]);
        }, []),
        tn = "beforeRead",
        rn = "read",
        nn = "afterRead",
        on = "beforeMain",
        an = "main",
        sn = "afterMain",
        fn = "beforeWrite",
        pn = "write",
        un = "afterWrite",
        ze = [tn, rn, nn, on, an, sn, fn, pn, un];
    function F(t) {
        return t ? (t.nodeName || "").toLowerCase() : null;
    }
    function B(t) {
        if (t == null) return window;
        if (t.toString() !== "[object Window]") {
            var e = t.ownerDocument;
            return (e && e.defaultView) || window;
        }
        return t;
    }
    function de(t) {
        var e = B(t).Element;
        return t instanceof e || t instanceof Element;
    }
    function H(t) {
        var e = B(t).HTMLElement;
        return t instanceof e || t instanceof HTMLElement;
    }
    function mt(t) {
        if (typeof ShadowRoot == "undefined") return !1;
        var e = B(t).ShadowRoot;
        return t instanceof e || t instanceof ShadowRoot;
    }
    function ln(t) {
        var e = t.state;
        Object.keys(e.elements).forEach(function (r) {
            var n = e.styles[r] || {},
                i = e.attributes[r] || {},
                a = e.elements[r];
            !H(a) ||
                !F(a) ||
                (Object.assign(a.style, n),
                Object.keys(i).forEach(function (f) {
                    var p = i[f];
                    p === !1
                        ? a.removeAttribute(f)
                        : a.setAttribute(f, p === !0 ? "" : p);
                }));
        });
    }
    function cn(t) {
        var e = t.state,
            r = {
                popper: {
                    position: e.options.strategy,
                    left: "0",
                    top: "0",
                    margin: "0",
                },
                arrow: { position: "absolute" },
                reference: {},
            };
        return (
            Object.assign(e.elements.popper.style, r.popper),
            (e.styles = r),
            e.elements.arrow && Object.assign(e.elements.arrow.style, r.arrow),
            function () {
                Object.keys(e.elements).forEach(function (n) {
                    var i = e.elements[n],
                        a = e.attributes[n] || {},
                        f = Object.keys(
                            e.styles.hasOwnProperty(n) ? e.styles[n] : r[n]
                        ),
                        p = f.reduce(function (l, c) {
                            return (l[c] = ""), l;
                        }, {});
                    !H(i) ||
                        !F(i) ||
                        (Object.assign(i.style, p),
                        Object.keys(a).forEach(function (l) {
                            i.removeAttribute(l);
                        }));
                });
            }
        );
    }
    var vt = {
        name: "applyStyles",
        enabled: !0,
        phase: "write",
        fn: ln,
        effect: cn,
        requires: ["computeStyles"],
    };
    function I(t) {
        return t.split("-")[0];
    }
    function Q(t) {
        var e = t.getBoundingClientRect();
        return {
            width: e.width,
            height: e.height,
            top: e.top,
            right: e.right,
            bottom: e.bottom,
            left: e.left,
            x: e.left,
            y: e.top,
        };
    }
    function Pe(t) {
        var e = Q(t),
            r = t.offsetWidth,
            n = t.offsetHeight;
        return (
            Math.abs(e.width - r) <= 1 && (r = e.width),
            Math.abs(e.height - n) <= 1 && (n = e.height),
            { x: t.offsetLeft, y: t.offsetTop, width: r, height: n }
        );
    }
    function Ge(t, e) {
        var r = e.getRootNode && e.getRootNode();
        if (t.contains(e)) return !0;
        if (r && mt(r)) {
            var n = e;
            do {
                if (n && t.isSameNode(n)) return !0;
                n = n.parentNode || n.host;
            } while (n);
        }
        return !1;
    }
    function $(t) {
        return B(t).getComputedStyle(t);
    }
    function Ct(t) {
        return ["table", "td", "th"].indexOf(F(t)) >= 0;
    }
    function U(t) {
        return ((de(t) ? t.ownerDocument : t.document) || window.document)
            .documentElement;
    }
    function me(t) {
        return F(t) === "html"
            ? t
            : t.assignedSlot || t.parentNode || (mt(t) ? t.host : null) || U(t);
    }
    function tr(t) {
        return !H(t) || $(t).position === "fixed" ? null : t.offsetParent;
    }
    function dn(t) {
        var e = navigator.userAgent.toLowerCase().indexOf("firefox") !== -1,
            r = navigator.userAgent.indexOf("Trident") !== -1;
        if (r && H(t)) {
            var n = $(t);
            if (n.position === "fixed") return null;
        }
        for (var i = me(t); H(i) && ["html", "body"].indexOf(F(i)) < 0; ) {
            var a = $(i);
            if (
                a.transform !== "none" ||
                a.perspective !== "none" ||
                a.contain === "paint" ||
                ["transform", "perspective"].indexOf(a.willChange) !== -1 ||
                (e && a.willChange === "filter") ||
                (e && a.filter && a.filter !== "none")
            )
                return i;
            i = i.parentNode;
        }
        return null;
    }
    function re(t) {
        for (
            var e = B(t), r = tr(t);
            r && Ct(r) && $(r).position === "static";

        )
            r = tr(r);
        return r &&
            (F(r) === "html" || (F(r) === "body" && $(r).position === "static"))
            ? e
            : r || dn(t) || e;
    }
    function Te(t) {
        return ["top", "bottom"].indexOf(t) >= 0 ? "x" : "y";
    }
    var Z = Math.max,
        be = Math.min,
        Ke = Math.round;
    function Ce(t, e, r) {
        return Z(t, be(e, r));
    }
    function Je() {
        return { top: 0, right: 0, bottom: 0, left: 0 };
    }
    function Qe(t) {
        return Object.assign({}, Je(), t);
    }
    function Ze(t, e) {
        return e.reduce(function (r, n) {
            return (r[n] = t), r;
        }, {});
    }
    var mn = function (e, r) {
        return (
            (e =
                typeof e == "function"
                    ? e(Object.assign({}, r.rects, { placement: r.placement }))
                    : e),
            Qe(typeof e != "number" ? e : Ze(e, ye))
        );
    };
    function vn(t) {
        var e,
            r = t.state,
            n = t.name,
            i = t.options,
            a = r.elements.arrow,
            f = r.modifiersData.popperOffsets,
            p = I(r.placement),
            l = Te(p),
            c = [W, k].indexOf(p) >= 0,
            u = c ? "height" : "width";
        if (!(!a || !f)) {
            var y = mn(i.padding, r),
                j = Pe(a),
                b = l === "y" ? V : W,
                g = l === "y" ? _ : k,
                h =
                    r.rects.reference[u] +
                    r.rects.reference[l] -
                    f[l] -
                    r.rects.popper[u],
                w = f[l] - r.rects.reference[l],
                O = re(a),
                x = O
                    ? l === "y"
                        ? O.clientHeight || 0
                        : O.clientWidth || 0
                    : 0,
                N = h / 2 - w / 2,
                o = y[b],
                T = x - j[u] - y[g],
                d = x / 2 - j[u] / 2 + N,
                D = Ce(o, d, T),
                E = l;
            r.modifiersData[n] =
                ((e = {}), (e[E] = D), (e.centerOffset = D - d), e);
        }
    }
    function gn(t) {
        var e = t.state,
            r = t.options,
            n = r.element,
            i = n === void 0 ? "[data-popper-arrow]" : n;
        if (
            i != null &&
            !(
                typeof i == "string" &&
                ((i = e.elements.popper.querySelector(i)), !i)
            )
        ) {
            if (
                (H(i) ||
                    console.error(
                        [
                            'Popper: "arrow" element must be an HTMLElement (not an SVGElement).',
                            "To use an SVG arrow, wrap it in an HTMLElement that will be used as",
                            "the arrow.",
                        ].join(" ")
                    ),
                !Ge(e.elements.popper, i))
            ) {
                console.error(
                    [
                        'Popper: "arrow" modifier\'s `element` must be a child of the popper',
                        "element.",
                    ].join(" ")
                );
                return;
            }
            e.elements.arrow = i;
        }
    }
    var rr = {
        name: "arrow",
        enabled: !0,
        phase: "main",
        fn: vn,
        effect: gn,
        requires: ["popperOffsets"],
        requiresIfExists: ["preventOverflow"],
    };
    var hn = { top: "auto", right: "auto", bottom: "auto", left: "auto" };
    function yn(t) {
        var e = t.x,
            r = t.y,
            n = window,
            i = n.devicePixelRatio || 1;
        return { x: Ke(Ke(e * i) / i) || 0, y: Ke(Ke(r * i) / i) || 0 };
    }
    function nr(t) {
        var e,
            r = t.popper,
            n = t.popperRect,
            i = t.placement,
            a = t.offsets,
            f = t.position,
            p = t.gpuAcceleration,
            l = t.adaptive,
            c = t.roundOffsets,
            u = c === !0 ? yn(a) : typeof c == "function" ? c(a) : a,
            y = u.x,
            j = y === void 0 ? 0 : y,
            b = u.y,
            g = b === void 0 ? 0 : b,
            h = a.hasOwnProperty("x"),
            w = a.hasOwnProperty("y"),
            O = W,
            x = V,
            N = window;
        if (l) {
            var o = re(r),
                T = "clientHeight",
                d = "clientWidth";
            o === B(r) &&
                ((o = U(r)),
                $(o).position !== "static" &&
                    ((T = "scrollHeight"), (d = "scrollWidth"))),
                (o = o),
                i === V && ((x = _), (g -= o[T] - n.height), (g *= p ? 1 : -1)),
                i === W && ((O = k), (j -= o[d] - n.width), (j *= p ? 1 : -1));
        }
        var D = Object.assign({ position: f }, l && hn);
        if (p) {
            var E;
            return Object.assign(
                {},
                D,
                ((E = {}),
                (E[x] = w ? "0" : ""),
                (E[O] = h ? "0" : ""),
                (E.transform =
                    (N.devicePixelRatio || 1) < 2
                        ? "translate(" + j + "px, " + g + "px)"
                        : "translate3d(" + j + "px, " + g + "px, 0)"),
                E)
            );
        }
        return Object.assign(
            {},
            D,
            ((e = {}),
            (e[x] = w ? g + "px" : ""),
            (e[O] = h ? j + "px" : ""),
            (e.transform = ""),
            e)
        );
    }
    function bn(t) {
        var e = t.state,
            r = t.options,
            n = r.gpuAcceleration,
            i = n === void 0 ? !0 : n,
            a = r.adaptive,
            f = a === void 0 ? !0 : a,
            p = r.roundOffsets,
            l = p === void 0 ? !0 : p,
            c = $(e.elements.popper).transitionProperty || "";
        f &&
            ["transform", "top", "right", "bottom", "left"].some(function (y) {
                return c.indexOf(y) >= 0;
            }) &&
            console.warn(
                [
                    "Popper: Detected CSS transitions on at least one of the following",
                    'CSS properties: "transform", "top", "right", "bottom", "left".',
                    `

`,
                    'Disable the "computeStyles" modifier\'s `adaptive` option to allow',
                    "for smooth transitions, or remove these properties from the CSS",
                    "transition declaration on the popper element if only transitioning",
                    "opacity or background-color for example.",
                    `

`,
                    "We recommend using the popper element as a wrapper around an inner",
                    "element that can have any CSS property transitioned for animations.",
                ].join(" ")
            );
        var u = {
            placement: I(e.placement),
            popper: e.elements.popper,
            popperRect: e.rects.popper,
            gpuAcceleration: i,
        };
        e.modifiersData.popperOffsets != null &&
            (e.styles.popper = Object.assign(
                {},
                e.styles.popper,
                nr(
                    Object.assign({}, u, {
                        offsets: e.modifiersData.popperOffsets,
                        position: e.options.strategy,
                        adaptive: f,
                        roundOffsets: l,
                    })
                )
            )),
            e.modifiersData.arrow != null &&
                (e.styles.arrow = Object.assign(
                    {},
                    e.styles.arrow,
                    nr(
                        Object.assign({}, u, {
                            offsets: e.modifiersData.arrow,
                            position: "absolute",
                            adaptive: !1,
                            roundOffsets: l,
                        })
                    )
                )),
            (e.attributes.popper = Object.assign({}, e.attributes.popper, {
                "data-popper-placement": e.placement,
            }));
    }
    var or = {
        name: "computeStyles",
        enabled: !0,
        phase: "beforeWrite",
        fn: bn,
        data: {},
    };
    var gt = { passive: !0 };
    function wn(t) {
        var e = t.state,
            r = t.instance,
            n = t.options,
            i = n.scroll,
            a = i === void 0 ? !0 : i,
            f = n.resize,
            p = f === void 0 ? !0 : f,
            l = B(e.elements.popper),
            c = [].concat(e.scrollParents.reference, e.scrollParents.popper);
        return (
            a &&
                c.forEach(function (u) {
                    u.addEventListener("scroll", r.update, gt);
                }),
            p && l.addEventListener("resize", r.update, gt),
            function () {
                a &&
                    c.forEach(function (u) {
                        u.removeEventListener("scroll", r.update, gt);
                    }),
                    p && l.removeEventListener("resize", r.update, gt);
            }
        );
    }
    var ir = {
        name: "eventListeners",
        enabled: !0,
        phase: "write",
        fn: function () {},
        effect: wn,
        data: {},
    };
    var On = { left: "right", right: "left", bottom: "top", top: "bottom" };
    function ke(t) {
        return t.replace(/left|right|bottom|top/g, function (e) {
            return On[e];
        });
    }
    var xn = { start: "end", end: "start" };
    function ht(t) {
        return t.replace(/start|end/g, function (e) {
            return xn[e];
        });
    }
    function Se(t) {
        var e = B(t),
            r = e.pageXOffset,
            n = e.pageYOffset;
        return { scrollLeft: r, scrollTop: n };
    }
    function De(t) {
        return Q(U(t)).left + Se(t).scrollLeft;
    }
    function St(t) {
        var e = B(t),
            r = U(t),
            n = e.visualViewport,
            i = r.clientWidth,
            a = r.clientHeight,
            f = 0,
            p = 0;
        return (
            n &&
                ((i = n.width),
                (a = n.height),
                /^((?!chrome|android).)*safari/i.test(navigator.userAgent) ||
                    ((f = n.offsetLeft), (p = n.offsetTop))),
            { width: i, height: a, x: f + De(t), y: p }
        );
    }
    function Dt(t) {
        var e,
            r = U(t),
            n = Se(t),
            i = (e = t.ownerDocument) == null ? void 0 : e.body,
            a = Z(
                r.scrollWidth,
                r.clientWidth,
                i ? i.scrollWidth : 0,
                i ? i.clientWidth : 0
            ),
            f = Z(
                r.scrollHeight,
                r.clientHeight,
                i ? i.scrollHeight : 0,
                i ? i.clientHeight : 0
            ),
            p = -n.scrollLeft + De(t),
            l = -n.scrollTop;
        return (
            $(i || r).direction === "rtl" &&
                (p += Z(r.clientWidth, i ? i.clientWidth : 0) - a),
            { width: a, height: f, x: p, y: l }
        );
    }
    function Ae(t) {
        var e = $(t),
            r = e.overflow,
            n = e.overflowX,
            i = e.overflowY;
        return /auto|scroll|overlay|hidden/.test(r + i + n);
    }
    function yt(t) {
        return ["html", "body", "#document"].indexOf(F(t)) >= 0
            ? t.ownerDocument.body
            : H(t) && Ae(t)
            ? t
            : yt(me(t));
    }
    function we(t, e) {
        var r;
        e === void 0 && (e = []);
        var n = yt(t),
            i = n === ((r = t.ownerDocument) == null ? void 0 : r.body),
            a = B(n),
            f = i ? [a].concat(a.visualViewport || [], Ae(n) ? n : []) : n,
            p = e.concat(f);
        return i ? p : p.concat(we(me(f)));
    }
    function We(t) {
        return Object.assign({}, t, {
            left: t.x,
            top: t.y,
            right: t.x + t.width,
            bottom: t.y + t.height,
        });
    }
    function En(t) {
        var e = Q(t);
        return (
            (e.top = e.top + t.clientTop),
            (e.left = e.left + t.clientLeft),
            (e.bottom = e.top + t.clientHeight),
            (e.right = e.left + t.clientWidth),
            (e.width = t.clientWidth),
            (e.height = t.clientHeight),
            (e.x = e.left),
            (e.y = e.top),
            e
        );
    }
    function ar(t, e) {
        return e === ct ? We(St(t)) : H(e) ? En(e) : We(Dt(U(t)));
    }
    function jn(t) {
        var e = we(me(t)),
            r = ["absolute", "fixed"].indexOf($(t).position) >= 0,
            n = r && H(t) ? re(t) : t;
        return de(n)
            ? e.filter(function (i) {
                  return de(i) && Ge(i, n) && F(i) !== "body";
              })
            : [];
    }
    function At(t, e, r) {
        var n = e === "clippingParents" ? jn(t) : [].concat(e),
            i = [].concat(n, [r]),
            a = i[0],
            f = i.reduce(function (p, l) {
                var c = ar(t, l);
                return (
                    (p.top = Z(c.top, p.top)),
                    (p.right = be(c.right, p.right)),
                    (p.bottom = be(c.bottom, p.bottom)),
                    (p.left = Z(c.left, p.left)),
                    p
                );
            }, ar(t, a));
        return (
            (f.width = f.right - f.left),
            (f.height = f.bottom - f.top),
            (f.x = f.left),
            (f.y = f.top),
            f
        );
    }
    function ae(t) {
        return t.split("-")[1];
    }
    function et(t) {
        var e = t.reference,
            r = t.element,
            n = t.placement,
            i = n ? I(n) : null,
            a = n ? ae(n) : null,
            f = e.x + e.width / 2 - r.width / 2,
            p = e.y + e.height / 2 - r.height / 2,
            l;
        switch (i) {
            case V:
                l = { x: f, y: e.y - r.height };
                break;
            case _:
                l = { x: f, y: e.y + e.height };
                break;
            case k:
                l = { x: e.x + e.width, y: p };
                break;
            case W:
                l = { x: e.x - r.width, y: p };
                break;
            default:
                l = { x: e.x, y: e.y };
        }
        var c = i ? Te(i) : null;
        if (c != null) {
            var u = c === "y" ? "height" : "width";
            switch (a) {
                case ce:
                    l[c] = l[c] - (e[u] / 2 - r[u] / 2);
                    break;
                case lt:
                    l[c] = l[c] + (e[u] / 2 - r[u] / 2);
                    break;
                default:
            }
        }
        return l;
    }
    function ne(t, e) {
        e === void 0 && (e = {});
        var r = e,
            n = r.placement,
            i = n === void 0 ? t.placement : n,
            a = r.boundary,
            f = a === void 0 ? Zt : a,
            p = r.rootBoundary,
            l = p === void 0 ? ct : p,
            c = r.elementContext,
            u = c === void 0 ? Ie : c,
            y = r.altBoundary,
            j = y === void 0 ? !1 : y,
            b = r.padding,
            g = b === void 0 ? 0 : b,
            h = Qe(typeof g != "number" ? g : Ze(g, ye)),
            w = u === Ie ? er : Ie,
            O = t.elements.reference,
            x = t.rects.popper,
            N = t.elements[j ? w : u],
            o = At(de(N) ? N : N.contextElement || U(t.elements.popper), f, l),
            T = Q(O),
            d = et({
                reference: T,
                element: x,
                strategy: "absolute",
                placement: i,
            }),
            D = We(Object.assign({}, x, d)),
            E = u === Ie ? D : T,
            M = {
                top: o.top - E.top + h.top,
                bottom: E.bottom - o.bottom + h.bottom,
                left: o.left - E.left + h.left,
                right: E.right - o.right + h.right,
            },
            S = t.modifiersData.offset;
        if (u === Ie && S) {
            var R = S[i];
            Object.keys(M).forEach(function (L) {
                var A = [k, _].indexOf(L) >= 0 ? 1 : -1,
                    q = [V, _].indexOf(L) >= 0 ? "y" : "x";
                M[L] += R[q] * A;
            });
        }
        return M;
    }
    function Nt(t, e) {
        e === void 0 && (e = {});
        var r = e,
            n = r.placement,
            i = r.boundary,
            a = r.rootBoundary,
            f = r.padding,
            p = r.flipVariations,
            l = r.allowedAutoPlacements,
            c = l === void 0 ? dt : l,
            u = ae(n),
            y = u
                ? p
                    ? Tt
                    : Tt.filter(function (g) {
                          return ae(g) === u;
                      })
                : ye,
            j = y.filter(function (g) {
                return c.indexOf(g) >= 0;
            });
        j.length === 0 &&
            ((j = y),
            console.error(
                [
                    "Popper: The `allowedAutoPlacements` option did not allow any",
                    "placements. Ensure the `placement` option matches the variation",
                    "of the allowed placements.",
                    'For example, "auto" cannot be used to allow "bottom-start".',
                    'Use "auto-start" instead.',
                ].join(" ")
            ));
        var b = j.reduce(function (g, h) {
            return (
                (g[h] = ne(t, {
                    placement: h,
                    boundary: i,
                    rootBoundary: a,
                    padding: f,
                })[I(h)]),
                g
            );
        }, {});
        return Object.keys(b).sort(function (g, h) {
            return b[g] - b[h];
        });
    }
    function Pn(t) {
        if (I(t) === Ve) return [];
        var e = ke(t);
        return [ht(t), e, ht(e)];
    }
    function Tn(t) {
        var e = t.state,
            r = t.options,
            n = t.name;
        if (!e.modifiersData[n]._skip) {
            for (
                var i = r.mainAxis,
                    a = i === void 0 ? !0 : i,
                    f = r.altAxis,
                    p = f === void 0 ? !0 : f,
                    l = r.fallbackPlacements,
                    c = r.padding,
                    u = r.boundary,
                    y = r.rootBoundary,
                    j = r.altBoundary,
                    b = r.flipVariations,
                    g = b === void 0 ? !0 : b,
                    h = r.allowedAutoPlacements,
                    w = e.options.placement,
                    O = I(w),
                    x = O === w,
                    N = l || (x || !g ? [ke(w)] : Pn(w)),
                    o = [w].concat(N).reduce(function (ie, z) {
                        return ie.concat(
                            I(z) === Ve
                                ? Nt(e, {
                                      placement: z,
                                      boundary: u,
                                      rootBoundary: y,
                                      padding: c,
                                      flipVariations: g,
                                      allowedAutoPlacements: h,
                                  })
                                : z
                        );
                    }, []),
                    T = e.rects.reference,
                    d = e.rects.popper,
                    D = new Map(),
                    E = !0,
                    M = o[0],
                    S = 0;
                S < o.length;
                S++
            ) {
                var R = o[S],
                    L = I(R),
                    A = ae(R) === ce,
                    q = [V, _].indexOf(L) >= 0,
                    ee = q ? "width" : "height",
                    pe = ne(e, {
                        placement: R,
                        boundary: u,
                        rootBoundary: y,
                        altBoundary: j,
                        padding: c,
                    }),
                    K = q ? (A ? k : W) : A ? _ : V;
                T[ee] > d[ee] && (K = ke(K));
                var X = ke(K),
                    ue = [];
                if (
                    (a && ue.push(pe[L] <= 0),
                    p && ue.push(pe[K] <= 0, pe[X] <= 0),
                    ue.every(function (ie) {
                        return ie;
                    }))
                ) {
                    (M = R), (E = !1);
                    break;
                }
                D.set(R, ue);
            }
            if (E)
                for (
                    var oe = g ? 3 : 1,
                        Oe = function (z) {
                            var ge = o.find(function (_e) {
                                var he = D.get(_e);
                                if (he)
                                    return he.slice(0, z).every(function (Re) {
                                        return Re;
                                    });
                            });
                            if (ge) return (M = ge), "break";
                        },
                        te = oe;
                    te > 0;
                    te--
                ) {
                    var xe = Oe(te);
                    if (xe === "break") break;
                }
            e.placement !== M &&
                ((e.modifiersData[n]._skip = !0),
                (e.placement = M),
                (e.reset = !0));
        }
    }
    var sr = {
        name: "flip",
        enabled: !0,
        phase: "main",
        fn: Tn,
        requiresIfExists: ["offset"],
        data: { _skip: !1 },
    };
    function fr(t, e, r) {
        return (
            r === void 0 && (r = { x: 0, y: 0 }),
            {
                top: t.top - e.height - r.y,
                right: t.right - e.width + r.x,
                bottom: t.bottom - e.height + r.y,
                left: t.left - e.width - r.x,
            }
        );
    }
    function pr(t) {
        return [V, k, _, W].some(function (e) {
            return t[e] >= 0;
        });
    }
    function Cn(t) {
        var e = t.state,
            r = t.name,
            n = e.rects.reference,
            i = e.rects.popper,
            a = e.modifiersData.preventOverflow,
            f = ne(e, { elementContext: "reference" }),
            p = ne(e, { altBoundary: !0 }),
            l = fr(f, n),
            c = fr(p, i, a),
            u = pr(l),
            y = pr(c);
        (e.modifiersData[r] = {
            referenceClippingOffsets: l,
            popperEscapeOffsets: c,
            isReferenceHidden: u,
            hasPopperEscaped: y,
        }),
            (e.attributes.popper = Object.assign({}, e.attributes.popper, {
                "data-popper-reference-hidden": u,
                "data-popper-escaped": y,
            }));
    }
    var ur = {
        name: "hide",
        enabled: !0,
        phase: "main",
        requiresIfExists: ["preventOverflow"],
        fn: Cn,
    };
    function Sn(t, e, r) {
        var n = I(t),
            i = [W, V].indexOf(n) >= 0 ? -1 : 1,
            a =
                typeof r == "function"
                    ? r(Object.assign({}, e, { placement: t }))
                    : r,
            f = a[0],
            p = a[1];
        return (
            (f = f || 0),
            (p = (p || 0) * i),
            [W, k].indexOf(n) >= 0 ? { x: p, y: f } : { x: f, y: p }
        );
    }
    function Dn(t) {
        var e = t.state,
            r = t.options,
            n = t.name,
            i = r.offset,
            a = i === void 0 ? [0, 0] : i,
            f = dt.reduce(function (u, y) {
                return (u[y] = Sn(y, e.rects, a)), u;
            }, {}),
            p = f[e.placement],
            l = p.x,
            c = p.y;
        e.modifiersData.popperOffsets != null &&
            ((e.modifiersData.popperOffsets.x += l),
            (e.modifiersData.popperOffsets.y += c)),
            (e.modifiersData[n] = f);
    }
    var lr = {
        name: "offset",
        enabled: !0,
        phase: "main",
        requires: ["popperOffsets"],
        fn: Dn,
    };
    function An(t) {
        var e = t.state,
            r = t.name;
        e.modifiersData[r] = et({
            reference: e.rects.reference,
            element: e.rects.popper,
            strategy: "absolute",
            placement: e.placement,
        });
    }
    var cr = {
        name: "popperOffsets",
        enabled: !0,
        phase: "read",
        fn: An,
        data: {},
    };
    function Mt(t) {
        return t === "x" ? "y" : "x";
    }
    function Nn(t) {
        var e = t.state,
            r = t.options,
            n = t.name,
            i = r.mainAxis,
            a = i === void 0 ? !0 : i,
            f = r.altAxis,
            p = f === void 0 ? !1 : f,
            l = r.boundary,
            c = r.rootBoundary,
            u = r.altBoundary,
            y = r.padding,
            j = r.tether,
            b = j === void 0 ? !0 : j,
            g = r.tetherOffset,
            h = g === void 0 ? 0 : g,
            w = ne(e, {
                boundary: l,
                rootBoundary: c,
                padding: y,
                altBoundary: u,
            }),
            O = I(e.placement),
            x = ae(e.placement),
            N = !x,
            o = Te(O),
            T = Mt(o),
            d = e.modifiersData.popperOffsets,
            D = e.rects.reference,
            E = e.rects.popper,
            M =
                typeof h == "function"
                    ? h(Object.assign({}, e.rects, { placement: e.placement }))
                    : h,
            S = { x: 0, y: 0 };
        if (!!d) {
            if (a || p) {
                var R = o === "y" ? V : W,
                    L = o === "y" ? _ : k,
                    A = o === "y" ? "height" : "width",
                    q = d[o],
                    ee = d[o] + w[R],
                    pe = d[o] - w[L],
                    K = b ? -E[A] / 2 : 0,
                    X = x === ce ? D[A] : E[A],
                    ue = x === ce ? -E[A] : -D[A],
                    oe = e.elements.arrow,
                    Oe = b && oe ? Pe(oe) : { width: 0, height: 0 },
                    te = e.modifiersData["arrow#persistent"]
                        ? e.modifiersData["arrow#persistent"].padding
                        : Je(),
                    xe = te[R],
                    ie = te[L],
                    z = Ce(0, D[A], Oe[A]),
                    ge = N ? D[A] / 2 - K - z - xe - M : X - z - xe - M,
                    _e = N ? -D[A] / 2 + K + z + ie + M : ue + z + ie + M,
                    he = e.elements.arrow && re(e.elements.arrow),
                    Re = he
                        ? o === "y"
                            ? he.clientTop || 0
                            : he.clientLeft || 0
                        : 0,
                    le = e.modifiersData.offset
                        ? e.modifiersData.offset[e.placement][o]
                        : 0,
                    Fe = d[o] + ge - le - Re,
                    $e = d[o] + _e - le;
                if (a) {
                    var Ue = Ce(b ? be(ee, Fe) : ee, q, b ? Z(pe, $e) : pe);
                    (d[o] = Ue), (S[o] = Ue - q);
                }
                if (p) {
                    var at = o === "x" ? V : W,
                        st = o === "x" ? _ : k,
                        Ee = d[T],
                        qe = Ee + w[at],
                        Xe = Ee - w[st],
                        Ye = Ce(b ? be(qe, Fe) : qe, Ee, b ? Z(Xe, $e) : Xe);
                    (d[T] = Ye), (S[T] = Ye - Ee);
                }
            }
            e.modifiersData[n] = S;
        }
    }
    var dr = {
        name: "preventOverflow",
        enabled: !0,
        phase: "main",
        fn: Nn,
        requiresIfExists: ["offset"],
    };
    function Rt(t) {
        return { scrollLeft: t.scrollLeft, scrollTop: t.scrollTop };
    }
    function Lt(t) {
        return t === B(t) || !H(t) ? Se(t) : Rt(t);
    }
    function Bt(t, e, r) {
        r === void 0 && (r = !1);
        var n = U(e),
            i = Q(t),
            a = H(e),
            f = { scrollLeft: 0, scrollTop: 0 },
            p = { x: 0, y: 0 };
        return (
            (a || (!a && !r)) &&
                ((F(e) !== "body" || Ae(n)) && (f = Lt(e)),
                H(e)
                    ? ((p = Q(e)), (p.x += e.clientLeft), (p.y += e.clientTop))
                    : n && (p.x = De(n))),
            {
                x: i.left + f.scrollLeft - p.x,
                y: i.top + f.scrollTop - p.y,
                width: i.width,
                height: i.height,
            }
        );
    }
    function Mn(t) {
        var e = new Map(),
            r = new Set(),
            n = [];
        t.forEach(function (a) {
            e.set(a.name, a);
        });
        function i(a) {
            r.add(a.name);
            var f = [].concat(a.requires || [], a.requiresIfExists || []);
            f.forEach(function (p) {
                if (!r.has(p)) {
                    var l = e.get(p);
                    l && i(l);
                }
            }),
                n.push(a);
        }
        return (
            t.forEach(function (a) {
                r.has(a.name) || i(a);
            }),
            n
        );
    }
    function Vt(t) {
        var e = Mn(t);
        return ze.reduce(function (r, n) {
            return r.concat(
                e.filter(function (i) {
                    return i.phase === n;
                })
            );
        }, []);
    }
    function It(t) {
        var e;
        return function () {
            return (
                e ||
                    (e = new Promise(function (r) {
                        Promise.resolve().then(function () {
                            (e = void 0), r(t());
                        });
                    })),
                e
            );
        };
    }
    function se(t) {
        for (
            var e = arguments.length, r = new Array(e > 1 ? e - 1 : 0), n = 1;
            n < e;
            n++
        )
            r[n - 1] = arguments[n];
        return [].concat(r).reduce(function (i, a) {
            return i.replace(/%s/, a);
        }, t);
    }
    var Ne =
            'Popper: modifier "%s" provided an invalid %s property, expected %s but got %s',
        Rn =
            'Popper: modifier "%s" requires "%s", but "%s" modifier is not available',
        Ln = [
            "name",
            "enabled",
            "phase",
            "fn",
            "effect",
            "requires",
            "options",
        ];
    function kt(t) {
        t.forEach(function (e) {
            Object.keys(e).forEach(function (r) {
                switch (r) {
                    case "name":
                        typeof e.name != "string" &&
                            console.error(
                                se(
                                    Ne,
                                    String(e.name),
                                    '"name"',
                                    '"string"',
                                    '"' + String(e.name) + '"'
                                )
                            );
                        break;
                    case "enabled":
                        typeof e.enabled != "boolean" &&
                            console.error(
                                se(
                                    Ne,
                                    e.name,
                                    '"enabled"',
                                    '"boolean"',
                                    '"' + String(e.enabled) + '"'
                                )
                            );
                    case "phase":
                        ze.indexOf(e.phase) < 0 &&
                            console.error(
                                se(
                                    Ne,
                                    e.name,
                                    '"phase"',
                                    "either " + ze.join(", "),
                                    '"' + String(e.phase) + '"'
                                )
                            );
                        break;
                    case "fn":
                        typeof e.fn != "function" &&
                            console.error(
                                se(
                                    Ne,
                                    e.name,
                                    '"fn"',
                                    '"function"',
                                    '"' + String(e.fn) + '"'
                                )
                            );
                        break;
                    case "effect":
                        typeof e.effect != "function" &&
                            console.error(
                                se(
                                    Ne,
                                    e.name,
                                    '"effect"',
                                    '"function"',
                                    '"' + String(e.fn) + '"'
                                )
                            );
                        break;
                    case "requires":
                        Array.isArray(e.requires) ||
                            console.error(
                                se(
                                    Ne,
                                    e.name,
                                    '"requires"',
                                    '"array"',
                                    '"' + String(e.requires) + '"'
                                )
                            );
                        break;
                    case "requiresIfExists":
                        Array.isArray(e.requiresIfExists) ||
                            console.error(
                                se(
                                    Ne,
                                    e.name,
                                    '"requiresIfExists"',
                                    '"array"',
                                    '"' + String(e.requiresIfExists) + '"'
                                )
                            );
                        break;
                    case "options":
                    case "data":
                        break;
                    default:
                        console.error(
                            'PopperJS: an invalid property has been provided to the "' +
                                e.name +
                                '" modifier, valid properties are ' +
                                Ln.map(function (n) {
                                    return '"' + n + '"';
                                }).join(", ") +
                                '; but "' +
                                r +
                                '" was provided.'
                        );
                }
                e.requires &&
                    e.requires.forEach(function (n) {
                        t.find(function (i) {
                            return i.name === n;
                        }) == null &&
                            console.error(se(Rn, String(e.name), n, n));
                    });
            });
        });
    }
    function Wt(t, e) {
        var r = new Set();
        return t.filter(function (n) {
            var i = e(n);
            if (!r.has(i)) return r.add(i), !0;
        });
    }
    function Ht(t) {
        var e = t.reduce(function (r, n) {
            var i = r[n.name];
            return (
                (r[n.name] = i
                    ? Object.assign({}, i, n, {
                          options: Object.assign({}, i.options, n.options),
                          data: Object.assign({}, i.data, n.data),
                      })
                    : n),
                r
            );
        }, {});
        return Object.keys(e).map(function (r) {
            return e[r];
        });
    }
    var mr =
            "Popper: Invalid reference or popper argument provided. They must be either a DOM element or virtual element.",
        Bn =
            "Popper: An infinite loop in the modifiers cycle has been detected! The cycle has been interrupted to prevent a browser crash.",
        vr = { placement: "bottom", modifiers: [], strategy: "absolute" };
    function gr() {
        for (var t = arguments.length, e = new Array(t), r = 0; r < t; r++)
            e[r] = arguments[r];
        return !e.some(function (n) {
            return !(n && typeof n.getBoundingClientRect == "function");
        });
    }
    function hr(t) {
        t === void 0 && (t = {});
        var e = t,
            r = e.defaultModifiers,
            n = r === void 0 ? [] : r,
            i = e.defaultOptions,
            a = i === void 0 ? vr : i;
        return function (p, l, c) {
            c === void 0 && (c = a);
            var u = {
                    placement: "bottom",
                    orderedModifiers: [],
                    options: Object.assign({}, vr, a),
                    modifiersData: {},
                    elements: { reference: p, popper: l },
                    attributes: {},
                    styles: {},
                },
                y = [],
                j = !1,
                b = {
                    state: u,
                    setOptions: function (O) {
                        h(),
                            (u.options = Object.assign({}, a, u.options, O)),
                            (u.scrollParents = {
                                reference: de(p)
                                    ? we(p)
                                    : p.contextElement
                                    ? we(p.contextElement)
                                    : [],
                                popper: we(l),
                            });
                        var x = Vt(Ht([].concat(n, u.options.modifiers)));
                        u.orderedModifiers = x.filter(function (S) {
                            return S.enabled;
                        });
                        var N = Wt(
                            [].concat(x, u.options.modifiers),
                            function (S) {
                                var R = S.name;
                                return R;
                            }
                        );
                        if ((kt(N), I(u.options.placement) === Ve)) {
                            var o = u.orderedModifiers.find(function (S) {
                                var R = S.name;
                                return R === "flip";
                            });
                            o ||
                                console.error(
                                    [
                                        'Popper: "auto" placements require the "flip" modifier be',
                                        "present and enabled to work.",
                                    ].join(" ")
                                );
                        }
                        var T = $(l),
                            d = T.marginTop,
                            D = T.marginRight,
                            E = T.marginBottom,
                            M = T.marginLeft;
                        return (
                            [d, D, E, M].some(function (S) {
                                return parseFloat(S);
                            }) &&
                                console.warn(
                                    [
                                        'Popper: CSS "margin" styles cannot be used to apply padding',
                                        "between the popper and its reference element or boundary.",
                                        "To replicate margin, use the `offset` modifier, as well as",
                                        "the `padding` option in the `preventOverflow` and `flip`",
                                        "modifiers.",
                                    ].join(" ")
                                ),
                            g(),
                            b.update()
                        );
                    },
                    forceUpdate: function () {
                        if (!j) {
                            var O = u.elements,
                                x = O.reference,
                                N = O.popper;
                            if (!gr(x, N)) {
                                console.error(mr);
                                return;
                            }
                            (u.rects = {
                                reference: Bt(
                                    x,
                                    re(N),
                                    u.options.strategy === "fixed"
                                ),
                                popper: Pe(N),
                            }),
                                (u.reset = !1),
                                (u.placement = u.options.placement),
                                u.orderedModifiers.forEach(function (R) {
                                    return (u.modifiersData[R.name] =
                                        Object.assign({}, R.data));
                                });
                            for (
                                var o = 0, T = 0;
                                T < u.orderedModifiers.length;
                                T++
                            ) {
                                if (((o += 1), o > 100)) {
                                    console.error(Bn);
                                    break;
                                }
                                if (u.reset === !0) {
                                    (u.reset = !1), (T = -1);
                                    continue;
                                }
                                var d = u.orderedModifiers[T],
                                    D = d.fn,
                                    E = d.options,
                                    M = E === void 0 ? {} : E,
                                    S = d.name;
                                typeof D == "function" &&
                                    (u =
                                        D({
                                            state: u,
                                            options: M,
                                            name: S,
                                            instance: b,
                                        }) || u);
                            }
                        }
                    },
                    update: It(function () {
                        return new Promise(function (w) {
                            b.forceUpdate(), w(u);
                        });
                    }),
                    destroy: function () {
                        h(), (j = !0);
                    },
                };
            if (!gr(p, l)) return console.error(mr), b;
            b.setOptions(c).then(function (w) {
                !j && c.onFirstUpdate && c.onFirstUpdate(w);
            });
            function g() {
                u.orderedModifiers.forEach(function (w) {
                    var O = w.name,
                        x = w.options,
                        N = x === void 0 ? {} : x,
                        o = w.effect;
                    if (typeof o == "function") {
                        var T = o({
                                state: u,
                                name: O,
                                instance: b,
                                options: N,
                            }),
                            d = function () {};
                        y.push(T || d);
                    }
                });
            }
            function h() {
                y.forEach(function (w) {
                    return w();
                }),
                    (y = []);
            }
            return b;
        };
    }
    var Vn = [ir, cr, or, vt, lr, sr, dr, rr, ur],
        yr = hr({ defaultModifiers: Vn });
    var In = "tippy-box",
        br = "tippy-content",
        kn = "tippy-backdrop",
        wr = "tippy-arrow",
        Or = "tippy-svg-arrow",
        Me = { passive: !0, capture: !0 };
    function Wn(t, e) {
        return {}.hasOwnProperty.call(t, e);
    }
    function _t(t, e, r) {
        if (Array.isArray(t)) {
            var n = t[e];
            return n ?? (Array.isArray(r) ? r[e] : r);
        }
        return t;
    }
    function Ft(t, e) {
        var r = {}.toString.call(t);
        return r.indexOf("[object") === 0 && r.indexOf(e + "]") > -1;
    }
    function xr(t, e) {
        return typeof t == "function" ? t.apply(void 0, e) : t;
    }
    function Er(t, e) {
        if (e === 0) return t;
        var r;
        return function (n) {
            clearTimeout(r),
                (r = setTimeout(function () {
                    t(n);
                }, e));
        };
    }
    function Hn(t, e) {
        var r = Object.assign({}, t);
        return (
            e.forEach(function (n) {
                delete r[n];
            }),
            r
        );
    }
    function _n(t) {
        return t.split(/\s+/).filter(Boolean);
    }
    function tt(t) {
        return [].concat(t);
    }
    function jr(t, e) {
        t.indexOf(e) === -1 && t.push(e);
    }
    function Fn(t) {
        return t.filter(function (e, r) {
            return t.indexOf(e) === r;
        });
    }
    function $n(t) {
        return t.split("-")[0];
    }
    function bt(t) {
        return [].slice.call(t);
    }
    function Un(t) {
        return Object.keys(t).reduce(function (e, r) {
            return t[r] !== void 0 && (e[r] = t[r]), e;
        }, {});
    }
    function rt() {
        return document.createElement("div");
    }
    function nt(t) {
        return ["Element", "Fragment"].some(function (e) {
            return Ft(t, e);
        });
    }
    function qn(t) {
        return Ft(t, "NodeList");
    }
    function Pr(t) {
        return Ft(t, "MouseEvent");
    }
    function Xn(t) {
        return !!(t && t._tippy && t._tippy.reference === t);
    }
    function Yn(t) {
        return nt(t)
            ? [t]
            : qn(t)
            ? bt(t)
            : Array.isArray(t)
            ? t
            : bt(document.querySelectorAll(t));
    }
    function $t(t, e) {
        t.forEach(function (r) {
            r && (r.style.transitionDuration = e + "ms");
        });
    }
    function Tr(t, e) {
        t.forEach(function (r) {
            r && r.setAttribute("data-state", e);
        });
    }
    function Cr(t) {
        var e,
            r = tt(t),
            n = r[0];
        return (n == null || (e = n.ownerDocument) == null ? void 0 : e.body)
            ? n.ownerDocument
            : document;
    }
    function zn(t, e) {
        var r = e.clientX,
            n = e.clientY;
        return t.every(function (i) {
            var a = i.popperRect,
                f = i.popperState,
                p = i.props,
                l = p.interactiveBorder,
                c = $n(f.placement),
                u = f.modifiersData.offset;
            if (!u) return !0;
            var y = c === "bottom" ? u.top.y : 0,
                j = c === "top" ? u.bottom.y : 0,
                b = c === "right" ? u.left.x : 0,
                g = c === "left" ? u.right.x : 0,
                h = a.top - n + y > l,
                w = n - a.bottom - j > l,
                O = a.left - r + b > l,
                x = r - a.right - g > l;
            return h || w || O || x;
        });
    }
    function Ut(t, e, r) {
        var n = e + "EventListener";
        ["transitionend", "webkitTransitionEnd"].forEach(function (i) {
            t[n](i, r);
        });
    }
    var fe = { isTouch: !1 },
        Sr = 0;
    function Gn() {
        fe.isTouch ||
            ((fe.isTouch = !0),
            window.performance && document.addEventListener("mousemove", Dr));
    }
    function Dr() {
        var t = performance.now();
        t - Sr < 20 &&
            ((fe.isTouch = !1), document.removeEventListener("mousemove", Dr)),
            (Sr = t);
    }
    function Kn() {
        var t = document.activeElement;
        if (Xn(t)) {
            var e = t._tippy;
            t.blur && !e.state.isVisible && t.blur();
        }
    }
    function Jn() {
        document.addEventListener("touchstart", Gn, Me),
            window.addEventListener("blur", Kn);
    }
    var Qn = typeof window != "undefined" && typeof document != "undefined",
        Zn = Qn ? navigator.userAgent : "",
        eo = /MSIE |Trident\//.test(Zn);
    function He(t) {
        var e = t === "destroy" ? "n already-" : " ";
        return [
            t +
                "() was called on a" +
                e +
                "destroyed instance. This is a no-op but",
            "indicates a potential memory leak.",
        ].join(" ");
    }
    function Ar(t) {
        var e = /[ \t]{2,}/g,
            r = /^[ \t]*/gm;
        return t.replace(e, " ").replace(r, "").trim();
    }
    function to(t) {
        return Ar(
            `
  %ctippy.js

  %c` +
                Ar(t) +
                `

  %c\u{1F477}\u200D This is a development-only message. It will be removed in production.
  `
        );
    }
    function Nr(t) {
        return [
            to(t),
            "color: #00C584; font-size: 1.3em; font-weight: bold;",
            "line-height: 1.5",
            "color: #a6a095;",
        ];
    }
    var ot;
    ro();
    function ro() {
        ot = new Set();
    }
    function ve(t, e) {
        if (t && !ot.has(e)) {
            var r;
            ot.add(e), (r = console).warn.apply(r, Nr(e));
        }
    }
    function qt(t, e) {
        if (t && !ot.has(e)) {
            var r;
            ot.add(e), (r = console).error.apply(r, Nr(e));
        }
    }
    function no(t) {
        var e = !t,
            r =
                Object.prototype.toString.call(t) === "[object Object]" &&
                !t.addEventListener;
        qt(
            e,
            [
                "tippy() was passed",
                "`" + String(t) + "`",
                "as its targets (first) argument. Valid types are: String, Element,",
                "Element[], or NodeList.",
            ].join(" ")
        ),
            qt(
                r,
                [
                    "tippy() was passed a plain object which is not supported as an argument",
                    "for virtual positioning. Use props.getReferenceClientRect instead.",
                ].join(" ")
            );
    }
    var Mr = {
            animateFill: !1,
            followCursor: !1,
            inlinePositioning: !1,
            sticky: !1,
        },
        oo = {
            allowHTML: !1,
            animation: "fade",
            arrow: !0,
            content: "",
            inertia: !1,
            maxWidth: 350,
            role: "tooltip",
            theme: "",
            zIndex: 9999,
        },
        G = Object.assign(
            {
                appendTo: function () {
                    return document.body;
                },
                aria: { content: "auto", expanded: "auto" },
                delay: 0,
                duration: [300, 250],
                getReferenceClientRect: null,
                hideOnClick: !0,
                ignoreAttributes: !1,
                interactive: !1,
                interactiveBorder: 2,
                interactiveDebounce: 0,
                moveTransition: "",
                offset: [0, 10],
                onAfterUpdate: function () {},
                onBeforeUpdate: function () {},
                onCreate: function () {},
                onDestroy: function () {},
                onHidden: function () {},
                onHide: function () {},
                onMount: function () {},
                onShow: function () {},
                onShown: function () {},
                onTrigger: function () {},
                onUntrigger: function () {},
                onClickOutside: function () {},
                placement: "top",
                plugins: [],
                popperOptions: {},
                render: null,
                showOnCreate: !1,
                touch: !0,
                trigger: "mouseenter focus",
                triggerTarget: null,
            },
            Mr,
            {},
            oo
        ),
        io = Object.keys(G),
        ao = function (e) {
            Rr(e, []);
            var r = Object.keys(e);
            r.forEach(function (n) {
                G[n] = e[n];
            });
        };
    function Lr(t) {
        var e = t.plugins || [],
            r = e.reduce(function (n, i) {
                var a = i.name,
                    f = i.defaultValue;
                return a && (n[a] = t[a] !== void 0 ? t[a] : f), n;
            }, {});
        return Object.assign({}, t, {}, r);
    }
    function so(t, e) {
        var r = e ? Object.keys(Lr(Object.assign({}, G, { plugins: e }))) : io,
            n = r.reduce(function (i, a) {
                var f = (t.getAttribute("data-tippy-" + a) || "").trim();
                if (!f) return i;
                if (a === "content") i[a] = f;
                else
                    try {
                        i[a] = JSON.parse(f);
                    } catch (p) {
                        i[a] = f;
                    }
                return i;
            }, {});
        return n;
    }
    function Br(t, e) {
        var r = Object.assign(
            {},
            e,
            { content: xr(e.content, [t]) },
            e.ignoreAttributes ? {} : so(t, e.plugins)
        );
        return (
            (r.aria = Object.assign({}, G.aria, {}, r.aria)),
            (r.aria = {
                expanded:
                    r.aria.expanded === "auto"
                        ? e.interactive
                        : r.aria.expanded,
                content:
                    r.aria.content === "auto"
                        ? e.interactive
                            ? null
                            : "describedby"
                        : r.aria.content,
            }),
            r
        );
    }
    function Rr(t, e) {
        t === void 0 && (t = {}), e === void 0 && (e = []);
        var r = Object.keys(t);
        r.forEach(function (n) {
            var i = Hn(G, Object.keys(Mr)),
                a = !Wn(i, n);
            a &&
                (a =
                    e.filter(function (f) {
                        return f.name === n;
                    }).length === 0),
                ve(
                    a,
                    [
                        "`" + n + "`",
                        "is not a valid prop. You may have spelled it incorrectly, or if it's",
                        "a plugin, forgot to pass it in an array as props.plugins.",
                        `

`,
                        `All props: https://atomiks.github.io/tippyjs/v6/all-props/
`,
                        "Plugins: https://atomiks.github.io/tippyjs/v6/plugins/",
                    ].join(" ")
                );
        });
    }
    var fo = function () {
        return "innerHTML";
    };
    function Xt(t, e) {
        t[fo()] = e;
    }
    function Vr(t) {
        var e = rt();
        return (
            t === !0
                ? (e.className = wr)
                : ((e.className = Or), nt(t) ? e.appendChild(t) : Xt(e, t)),
            e
        );
    }
    function Ir(t, e) {
        nt(e.content)
            ? (Xt(t, ""), t.appendChild(e.content))
            : typeof e.content != "function" &&
              (e.allowHTML ? Xt(t, e.content) : (t.textContent = e.content));
    }
    function Yt(t) {
        var e = t.firstElementChild,
            r = bt(e.children);
        return {
            box: e,
            content: r.find(function (n) {
                return n.classList.contains(br);
            }),
            arrow: r.find(function (n) {
                return n.classList.contains(wr) || n.classList.contains(Or);
            }),
            backdrop: r.find(function (n) {
                return n.classList.contains(kn);
            }),
        };
    }
    function kr(t) {
        var e = rt(),
            r = rt();
        (r.className = In),
            r.setAttribute("data-state", "hidden"),
            r.setAttribute("tabindex", "-1");
        var n = rt();
        (n.className = br),
            n.setAttribute("data-state", "hidden"),
            Ir(n, t.props),
            e.appendChild(r),
            r.appendChild(n),
            i(t.props, t.props);
        function i(a, f) {
            var p = Yt(e),
                l = p.box,
                c = p.content,
                u = p.arrow;
            f.theme
                ? l.setAttribute("data-theme", f.theme)
                : l.removeAttribute("data-theme"),
                typeof f.animation == "string"
                    ? l.setAttribute("data-animation", f.animation)
                    : l.removeAttribute("data-animation"),
                f.inertia
                    ? l.setAttribute("data-inertia", "")
                    : l.removeAttribute("data-inertia"),
                (l.style.maxWidth =
                    typeof f.maxWidth == "number"
                        ? f.maxWidth + "px"
                        : f.maxWidth),
                f.role
                    ? l.setAttribute("role", f.role)
                    : l.removeAttribute("role"),
                (a.content !== f.content || a.allowHTML !== f.allowHTML) &&
                    Ir(c, t.props),
                f.arrow
                    ? u
                        ? a.arrow !== f.arrow &&
                          (l.removeChild(u), l.appendChild(Vr(f.arrow)))
                        : l.appendChild(Vr(f.arrow))
                    : u && l.removeChild(u);
        }
        return { popper: e, onUpdate: i };
    }
    kr.$$tippy = !0;
    var po = 1,
        wt = [],
        zt = [];
    function uo(t, e) {
        var r = Br(t, Object.assign({}, G, {}, Lr(Un(e)))),
            n,
            i,
            a,
            f = !1,
            p = !1,
            l = !1,
            c = !1,
            u,
            y,
            j,
            b = [],
            g = Er(at, r.interactiveDebounce),
            h,
            w = po++,
            O = null,
            x = Fn(r.plugins),
            N = {
                isEnabled: !0,
                isVisible: !1,
                isDestroyed: !1,
                isMounted: !1,
                isShown: !1,
            },
            o = {
                id: w,
                reference: t,
                popper: rt(),
                popperInstance: O,
                props: r,
                state: N,
                plugins: x,
                clearDelayTimeouts: Xr,
                setProps: Yr,
                setContent: zr,
                show: Gr,
                hide: Kr,
                hideWithInteractivity: Jr,
                enable: Ur,
                disable: qr,
                unmount: Qr,
                destroy: Zr,
            };
        if (!r.render)
            return qt(!0, "render() function has not been supplied."), o;
        var T = r.render(o),
            d = T.popper,
            D = T.onUpdate;
        d.setAttribute("data-tippy-root", ""),
            (d.id = "tippy-" + o.id),
            (o.popper = d),
            (t._tippy = o),
            (d._tippy = o);
        var E = x.map(function (s) {
                return s.fn(o);
            }),
            M = t.hasAttribute("aria-expanded");
        return (
            Fe(),
            oe(),
            K(),
            X("onCreate", [o]),
            r.showOnCreate && Jt(),
            d.addEventListener("mouseenter", function () {
                o.props.interactive &&
                    o.state.isVisible &&
                    o.clearDelayTimeouts();
            }),
            d.addEventListener("mouseleave", function (s) {
                o.props.interactive &&
                    o.props.trigger.indexOf("mouseenter") >= 0 &&
                    (q().addEventListener("mousemove", g), g(s));
            }),
            o
        );
        function S() {
            var s = o.props.touch;
            return Array.isArray(s) ? s : [s, 0];
        }
        function R() {
            return S()[0] === "hold";
        }
        function L() {
            var s;
            return !!((s = o.props.render) == null ? void 0 : s.$$tippy);
        }
        function A() {
            return h || t;
        }
        function q() {
            var s = A().parentNode;
            return s ? Cr(s) : document;
        }
        function ee() {
            return Yt(d);
        }
        function pe(s) {
            return (o.state.isMounted && !o.state.isVisible) ||
                fe.isTouch ||
                (u && u.type === "focus")
                ? 0
                : _t(o.props.delay, s ? 0 : 1, G.delay);
        }
        function K() {
            (d.style.pointerEvents =
                o.props.interactive && o.state.isVisible ? "" : "none"),
                (d.style.zIndex = "" + o.props.zIndex);
        }
        function X(s, m, v) {
            if (
                (v === void 0 && (v = !0),
                E.forEach(function (P) {
                    P[s] && P[s].apply(void 0, m);
                }),
                v)
            ) {
                var C;
                (C = o.props)[s].apply(C, m);
            }
        }
        function ue() {
            var s = o.props.aria;
            if (!!s.content) {
                var m = "aria-" + s.content,
                    v = d.id,
                    C = tt(o.props.triggerTarget || t);
                C.forEach(function (P) {
                    var Y = P.getAttribute(m);
                    if (o.state.isVisible)
                        P.setAttribute(m, Y ? Y + " " + v : v);
                    else {
                        var J = Y && Y.replace(v, "").trim();
                        J ? P.setAttribute(m, J) : P.removeAttribute(m);
                    }
                });
            }
        }
        function oe() {
            if (!(M || !o.props.aria.expanded)) {
                var s = tt(o.props.triggerTarget || t);
                s.forEach(function (m) {
                    o.props.interactive
                        ? m.setAttribute(
                              "aria-expanded",
                              o.state.isVisible && m === A() ? "true" : "false"
                          )
                        : m.removeAttribute("aria-expanded");
                });
            }
        }
        function Oe() {
            q().removeEventListener("mousemove", g),
                (wt = wt.filter(function (s) {
                    return s !== g;
                }));
        }
        function te(s) {
            if (
                !(fe.isTouch && (l || s.type === "mousedown")) &&
                !(o.props.interactive && d.contains(s.target))
            ) {
                if (A().contains(s.target)) {
                    if (
                        fe.isTouch ||
                        (o.state.isVisible &&
                            o.props.trigger.indexOf("click") >= 0)
                    )
                        return;
                } else X("onClickOutside", [o, s]);
                o.props.hideOnClick === !0 &&
                    (o.clearDelayTimeouts(),
                    o.hide(),
                    (p = !0),
                    setTimeout(function () {
                        p = !1;
                    }),
                    o.state.isMounted || ge());
            }
        }
        function xe() {
            l = !0;
        }
        function ie() {
            l = !1;
        }
        function z() {
            var s = q();
            s.addEventListener("mousedown", te, !0),
                s.addEventListener("touchend", te, Me),
                s.addEventListener("touchstart", ie, Me),
                s.addEventListener("touchmove", xe, Me);
        }
        function ge() {
            var s = q();
            s.removeEventListener("mousedown", te, !0),
                s.removeEventListener("touchend", te, Me),
                s.removeEventListener("touchstart", ie, Me),
                s.removeEventListener("touchmove", xe, Me);
        }
        function _e(s, m) {
            Re(s, function () {
                !o.state.isVisible &&
                    d.parentNode &&
                    d.parentNode.contains(d) &&
                    m();
            });
        }
        function he(s, m) {
            Re(s, m);
        }
        function Re(s, m) {
            var v = ee().box;
            function C(P) {
                P.target === v && (Ut(v, "remove", C), m());
            }
            if (s === 0) return m();
            Ut(v, "remove", y), Ut(v, "add", C), (y = C);
        }
        function le(s, m, v) {
            v === void 0 && (v = !1);
            var C = tt(o.props.triggerTarget || t);
            C.forEach(function (P) {
                P.addEventListener(s, m, v),
                    b.push({ node: P, eventType: s, handler: m, options: v });
            });
        }
        function Fe() {
            R() &&
                (le("touchstart", Ue, { passive: !0 }),
                le("touchend", st, { passive: !0 })),
                _n(o.props.trigger).forEach(function (s) {
                    if (s !== "manual")
                        switch ((le(s, Ue), s)) {
                            case "mouseenter":
                                le("mouseleave", st);
                                break;
                            case "focus":
                                le(eo ? "focusout" : "blur", Ee);
                                break;
                            case "focusin":
                                le("focusout", Ee);
                                break;
                        }
                });
        }
        function $e() {
            b.forEach(function (s) {
                var m = s.node,
                    v = s.eventType,
                    C = s.handler,
                    P = s.options;
                m.removeEventListener(v, C, P);
            }),
                (b = []);
        }
        function Ue(s) {
            var m,
                v = !1;
            if (!(!o.state.isEnabled || qe(s) || p)) {
                var C = ((m = u) == null ? void 0 : m.type) === "focus";
                (u = s),
                    (h = s.currentTarget),
                    oe(),
                    !o.state.isVisible &&
                        Pr(s) &&
                        wt.forEach(function (P) {
                            return P(s);
                        }),
                    s.type === "click" &&
                    (o.props.trigger.indexOf("mouseenter") < 0 || f) &&
                    o.props.hideOnClick !== !1 &&
                    o.state.isVisible
                        ? (v = !0)
                        : Jt(s),
                    s.type === "click" && (f = !v),
                    v && !C && ft(s);
            }
        }
        function at(s) {
            var m = s.target,
                v = A().contains(m) || d.contains(m);
            if (!(s.type === "mousemove" && v)) {
                var C = Et()
                    .concat(d)
                    .map(function (P) {
                        var Y,
                            J = P._tippy,
                            Le =
                                (Y = J.popperInstance) == null
                                    ? void 0
                                    : Y.state;
                        return Le
                            ? {
                                  popperRect: P.getBoundingClientRect(),
                                  popperState: Le,
                                  props: r,
                              }
                            : null;
                    })
                    .filter(Boolean);
                zn(C, s) && (Oe(), ft(s));
            }
        }
        function st(s) {
            var m = qe(s) || (o.props.trigger.indexOf("click") >= 0 && f);
            if (!m) {
                if (o.props.interactive) {
                    o.hideWithInteractivity(s);
                    return;
                }
                ft(s);
            }
        }
        function Ee(s) {
            (o.props.trigger.indexOf("focusin") < 0 && s.target !== A()) ||
                (o.props.interactive &&
                    s.relatedTarget &&
                    d.contains(s.relatedTarget)) ||
                ft(s);
        }
        function qe(s) {
            return fe.isTouch ? R() !== s.type.indexOf("touch") >= 0 : !1;
        }
        function Xe() {
            Ye();
            var s = o.props,
                m = s.popperOptions,
                v = s.placement,
                C = s.offset,
                P = s.getReferenceClientRect,
                Y = s.moveTransition,
                J = L() ? Yt(d).arrow : null,
                Le = P
                    ? {
                          getBoundingClientRect: P,
                          contextElement: P.contextElement || A(),
                      }
                    : t,
                Qt = {
                    name: "$$tippy",
                    enabled: !0,
                    phase: "beforeWrite",
                    requires: ["computeStyles"],
                    fn: function (pt) {
                        var Be = pt.state;
                        if (L()) {
                            var en = ee(),
                                Pt = en.box;
                            [
                                "placement",
                                "reference-hidden",
                                "escaped",
                            ].forEach(function (ut) {
                                ut === "placement"
                                    ? Pt.setAttribute(
                                          "data-placement",
                                          Be.placement
                                      )
                                    : Be.attributes.popper["data-popper-" + ut]
                                    ? Pt.setAttribute("data-" + ut, "")
                                    : Pt.removeAttribute("data-" + ut);
                            }),
                                (Be.attributes.popper = {});
                        }
                    },
                },
                je = [
                    { name: "offset", options: { offset: C } },
                    {
                        name: "preventOverflow",
                        options: {
                            padding: { top: 2, bottom: 2, left: 5, right: 5 },
                        },
                    },
                    { name: "flip", options: { padding: 5 } },
                    { name: "computeStyles", options: { adaptive: !Y } },
                    Qt,
                ];
            L() &&
                J &&
                je.push({ name: "arrow", options: { element: J, padding: 3 } }),
                je.push.apply(je, (m == null ? void 0 : m.modifiers) || []),
                (o.popperInstance = yr(
                    Le,
                    d,
                    Object.assign({}, m, {
                        placement: v,
                        onFirstUpdate: j,
                        modifiers: je,
                    })
                ));
        }
        function Ye() {
            o.popperInstance &&
                (o.popperInstance.destroy(), (o.popperInstance = null));
        }
        function $r() {
            var s = o.props.appendTo,
                m,
                v = A();
            (o.props.interactive && s === G.appendTo) || s === "parent"
                ? (m = v.parentNode)
                : (m = xr(s, [v])),
                m.contains(d) || m.appendChild(d),
                Xe(),
                ve(
                    o.props.interactive &&
                        s === G.appendTo &&
                        v.nextElementSibling !== d,
                    [
                        "Interactive tippy element may not be accessible via keyboard",
                        "navigation because it is not directly after the reference element",
                        "in the DOM source order.",
                        `

`,
                        "Using a wrapper <div> or <span> tag around the reference element",
                        "solves this by creating a new parentNode context.",
                        `

`,
                        "Specifying `appendTo: document.body` silences this warning, but it",
                        "assumes you are using a focus management solution to handle",
                        "keyboard navigation.",
                        `

`,
                        "See: https://atomiks.github.io/tippyjs/v6/accessibility/#interactivity",
                    ].join(" ")
                );
        }
        function Et() {
            return bt(d.querySelectorAll("[data-tippy-root]"));
        }
        function Jt(s) {
            o.clearDelayTimeouts(), s && X("onTrigger", [o, s]), z();
            var m = pe(!0),
                v = S(),
                C = v[0],
                P = v[1];
            fe.isTouch && C === "hold" && P && (m = P),
                m
                    ? (n = setTimeout(function () {
                          o.show();
                      }, m))
                    : o.show();
        }
        function ft(s) {
            if (
                (o.clearDelayTimeouts(),
                X("onUntrigger", [o, s]),
                !o.state.isVisible)
            ) {
                ge();
                return;
            }
            if (
                !(
                    o.props.trigger.indexOf("mouseenter") >= 0 &&
                    o.props.trigger.indexOf("click") >= 0 &&
                    ["mouseleave", "mousemove"].indexOf(s.type) >= 0 &&
                    f
                )
            ) {
                var m = pe(!1);
                m
                    ? (i = setTimeout(function () {
                          o.state.isVisible && o.hide();
                      }, m))
                    : (a = requestAnimationFrame(function () {
                          o.hide();
                      }));
            }
        }
        function Ur() {
            o.state.isEnabled = !0;
        }
        function qr() {
            o.hide(), (o.state.isEnabled = !1);
        }
        function Xr() {
            clearTimeout(n), clearTimeout(i), cancelAnimationFrame(a);
        }
        function Yr(s) {
            if (
                (ve(o.state.isDestroyed, He("setProps")), !o.state.isDestroyed)
            ) {
                X("onBeforeUpdate", [o, s]), $e();
                var m = o.props,
                    v = Br(
                        t,
                        Object.assign({}, o.props, {}, s, {
                            ignoreAttributes: !0,
                        })
                    );
                (o.props = v),
                    Fe(),
                    m.interactiveDebounce !== v.interactiveDebounce &&
                        (Oe(), (g = Er(at, v.interactiveDebounce))),
                    m.triggerTarget && !v.triggerTarget
                        ? tt(m.triggerTarget).forEach(function (C) {
                              C.removeAttribute("aria-expanded");
                          })
                        : v.triggerTarget && t.removeAttribute("aria-expanded"),
                    oe(),
                    K(),
                    D && D(m, v),
                    o.popperInstance &&
                        (Xe(),
                        Et().forEach(function (C) {
                            requestAnimationFrame(
                                C._tippy.popperInstance.forceUpdate
                            );
                        })),
                    X("onAfterUpdate", [o, s]);
            }
        }
        function zr(s) {
            o.setProps({ content: s });
        }
        function Gr() {
            ve(o.state.isDestroyed, He("show"));
            var s = o.state.isVisible,
                m = o.state.isDestroyed,
                v = !o.state.isEnabled,
                C = fe.isTouch && !o.props.touch,
                P = _t(o.props.duration, 0, G.duration);
            if (
                !(s || m || v || C) &&
                !A().hasAttribute("disabled") &&
                (X("onShow", [o], !1), o.props.onShow(o) !== !1)
            ) {
                if (
                    ((o.state.isVisible = !0),
                    L() && (d.style.visibility = "visible"),
                    K(),
                    z(),
                    o.state.isMounted || (d.style.transition = "none"),
                    L())
                ) {
                    var Y = ee(),
                        J = Y.box,
                        Le = Y.content;
                    $t([J, Le], 0);
                }
                (j = function () {
                    var je;
                    if (!(!o.state.isVisible || c)) {
                        if (
                            ((c = !0),
                            d.offsetHeight,
                            (d.style.transition = o.props.moveTransition),
                            L() && o.props.animation)
                        ) {
                            var jt = ee(),
                                pt = jt.box,
                                Be = jt.content;
                            $t([pt, Be], P), Tr([pt, Be], "visible");
                        }
                        ue(),
                            oe(),
                            jr(zt, o),
                            (je = o.popperInstance) == null || je.forceUpdate(),
                            (o.state.isMounted = !0),
                            X("onMount", [o]),
                            o.props.animation &&
                                L() &&
                                he(P, function () {
                                    (o.state.isShown = !0), X("onShown", [o]);
                                });
                    }
                }),
                    $r();
            }
        }
        function Kr() {
            ve(o.state.isDestroyed, He("hide"));
            var s = !o.state.isVisible,
                m = o.state.isDestroyed,
                v = !o.state.isEnabled,
                C = _t(o.props.duration, 1, G.duration);
            if (
                !(s || m || v) &&
                (X("onHide", [o], !1), o.props.onHide(o) !== !1)
            ) {
                if (
                    ((o.state.isVisible = !1),
                    (o.state.isShown = !1),
                    (c = !1),
                    (f = !1),
                    L() && (d.style.visibility = "hidden"),
                    Oe(),
                    ge(),
                    K(),
                    L())
                ) {
                    var P = ee(),
                        Y = P.box,
                        J = P.content;
                    o.props.animation && ($t([Y, J], C), Tr([Y, J], "hidden"));
                }
                ue(),
                    oe(),
                    o.props.animation ? L() && _e(C, o.unmount) : o.unmount();
            }
        }
        function Jr(s) {
            ve(o.state.isDestroyed, He("hideWithInteractivity")),
                q().addEventListener("mousemove", g),
                jr(wt, g),
                g(s);
        }
        function Qr() {
            ve(o.state.isDestroyed, He("unmount")),
                o.state.isVisible && o.hide(),
                !!o.state.isMounted &&
                    (Ye(),
                    Et().forEach(function (s) {
                        s._tippy.unmount();
                    }),
                    d.parentNode && d.parentNode.removeChild(d),
                    (zt = zt.filter(function (s) {
                        return s !== o;
                    })),
                    (o.state.isMounted = !1),
                    X("onHidden", [o]));
        }
        function Zr() {
            ve(o.state.isDestroyed, He("destroy")),
                !o.state.isDestroyed &&
                    (o.clearDelayTimeouts(),
                    o.unmount(),
                    $e(),
                    delete t._tippy,
                    (o.state.isDestroyed = !0),
                    X("onDestroy", [o]));
        }
    }
    function it(t, e) {
        e === void 0 && (e = {});
        var r = G.plugins.concat(e.plugins || []);
        no(t), Rr(e, r), Jn();
        var n = Object.assign({}, e, { plugins: r }),
            i = Yn(t),
            a = nt(n.content),
            f = i.length > 1;
        ve(
            a && f,
            [
                "tippy() was passed an Element as the `content` prop, but more than",
                "one tippy instance was created by this invocation. This means the",
                "content element will only be appended to the last tippy instance.",
                `

`,
                "Instead, pass the .innerHTML of the element, or use a function that",
                "returns a cloned version of the element instead.",
                `

`,
                `1) content: element.innerHTML
`,
                "2) content: () => element.cloneNode(true)",
            ].join(" ")
        );
        var p = i.reduce(function (l, c) {
            var u = c && uo(c, n);
            return u && l.push(u), l;
        }, []);
        return nt(t) ? p[0] : p;
    }
    it.defaultProps = G;
    it.setDefaultProps = ao;
    it.currentInput = fe;
    var af = Object.assign({}, vt, {
        effect: function (e) {
            var r = e.state,
                n = {
                    popper: {
                        position: r.options.strategy,
                        left: "0",
                        top: "0",
                        margin: "0",
                    },
                    arrow: { position: "absolute" },
                    reference: {},
                };
            Object.assign(r.elements.popper.style, n.popper),
                (r.styles = n),
                r.elements.arrow &&
                    Object.assign(r.elements.arrow.style, n.arrow);
        },
    });
    var Gt = { clientX: 0, clientY: 0 },
        Ot = [];
    function Wr(t) {
        var e = t.clientX,
            r = t.clientY;
        Gt = { clientX: e, clientY: r };
    }
    function lo(t) {
        t.addEventListener("mousemove", Wr);
    }
    function co(t) {
        t.removeEventListener("mousemove", Wr);
    }
    var Hr = {
        name: "followCursor",
        defaultValue: !1,
        fn: function (e) {
            var r = e.reference,
                n = Cr(e.props.triggerTarget || r),
                i = !1,
                a = !1,
                f = !0,
                p = e.props;
            function l() {
                return e.props.followCursor === "initial" && e.state.isVisible;
            }
            function c() {
                n.addEventListener("mousemove", j);
            }
            function u() {
                n.removeEventListener("mousemove", j);
            }
            function y() {
                (i = !0),
                    e.setProps({ getReferenceClientRect: null }),
                    (i = !1);
            }
            function j(h) {
                var w = h.target ? r.contains(h.target) : !0,
                    O = e.props.followCursor,
                    x = h.clientX,
                    N = h.clientY,
                    o = r.getBoundingClientRect(),
                    T = x - o.left,
                    d = N - o.top;
                (w || !e.props.interactive) &&
                    e.setProps({
                        getReferenceClientRect: function () {
                            var E = r.getBoundingClientRect(),
                                M = x,
                                S = N;
                            O === "initial" &&
                                ((M = E.left + T), (S = E.top + d));
                            var R = O === "horizontal" ? E.top : S,
                                L = O === "vertical" ? E.right : M,
                                A = O === "horizontal" ? E.bottom : S,
                                q = O === "vertical" ? E.left : M;
                            return {
                                width: L - q,
                                height: A - R,
                                top: R,
                                right: L,
                                bottom: A,
                                left: q,
                            };
                        },
                    });
            }
            function b() {
                e.props.followCursor &&
                    (Ot.push({ instance: e, doc: n }), lo(n));
            }
            function g() {
                (Ot = Ot.filter(function (h) {
                    return h.instance !== e;
                })),
                    Ot.filter(function (h) {
                        return h.doc === n;
                    }).length === 0 && co(n);
            }
            return {
                onCreate: b,
                onDestroy: g,
                onBeforeUpdate: function () {
                    p = e.props;
                },
                onAfterUpdate: function (w, O) {
                    var x = O.followCursor;
                    i ||
                        (x !== void 0 &&
                            p.followCursor !== x &&
                            (g(),
                            x
                                ? (b(), e.state.isMounted && !a && !l() && c())
                                : (u(), y())));
                },
                onMount: function () {
                    e.props.followCursor &&
                        !a &&
                        (f && (j(Gt), (f = !1)), l() || c());
                },
                onTrigger: function (w, O) {
                    Pr(O) && (Gt = { clientX: O.clientX, clientY: O.clientY }),
                        (a = O.type === "focus");
                },
                onHidden: function () {
                    e.props.followCursor && (y(), u(), (f = !0));
                },
            };
        },
    };
    it.setDefaultProps({ render: kr });
    var xt = it;
    var _r = (t) => {
        let e = { plugins: [] },
            r = (n) => t[t.indexOf(n) + 1];
        if (
            (t.includes("animation") && (e.animation = r("animation")),
            t.includes("duration") && (e.duration = parseInt(r("duration"))),
            t.includes("delay"))
        ) {
            let n = r("delay");
            e.delay = n.includes("-")
                ? n.split("-").map((i) => parseInt(i))
                : parseInt(n);
        }
        if (t.includes("cursor")) {
            e.plugins.push(Hr);
            let n = r("cursor");
            ["x", "initial"].includes(n)
                ? (e.followCursor = n === "x" ? "horizontal" : "initial")
                : (e.followCursor = !0);
        }
        return (
            t.includes("on") && (e.trigger = r("on")),
            t.includes("arrowless") && (e.arrow = !1),
            t.includes("html") && (e.allowHTML = !0),
            t.includes("interactive") && (e.interactive = !0),
            t.includes("border") &&
                e.interactive &&
                (e.interactiveBorder = parseInt(r("border"))),
            t.includes("debounce") &&
                e.interactive &&
                (e.interactiveDebounce = parseInt(r("debounce"))),
            t.includes("max-width") && (e.maxWidth = parseInt(r("max-width"))),
            t.includes("theme") && (e.theme = r("theme")),
            t.includes("placement") && (e.placement = r("placement")),
            e
        );
    };
    function Kt(t) {
        t.magic("tooltip", (e) => (r, n = {}) => {
            let i = n.timeout;
            delete n.timeout;
            let a = xt(e, { content: r, trigger: "manual", ...n });
            a.show(),
                setTimeout(() => {
                    a.hide(), setTimeout(() => a.destroy(), n.duration || 300);
                }, i || 2e3);
        }),
            t.directive(
                "tooltip",
                (
                    e,
                    { modifiers: r, expression: n },
                    { evaluateLater: i, effect: a }
                ) => {
                    let f = r.length > 0 ? _r(r) : {};
                    e.__x_tippy || (e.__x_tippy = xt(e, f));
                    let p = () => e.__x_tippy.enable(),
                        l = () => e.__x_tippy.disable(),
                        c = (u) => {
                            u ? (p(), e.__x_tippy.setContent(u)) : l();
                        };
                    if (r.includes("raw")) c(n);
                    else {
                        let u = i(n);
                        a(() => {
                            u((y) => {
                                typeof y == "object"
                                    ? (e.__x_tippy.setProps(y), p())
                                    : c(y);
                            });
                        });
                    }
                }
            );
    }
    Kt.defaultProps = (t) => (xt.setDefaultProps(t), Kt);
    var Fr = Kt;
    document.addEventListener("alpine:initializing", () => {
        Fr(window.Alpine);
    });
})();