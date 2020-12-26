/** @license
	Animator.js 1.1.9

	This library is released under the BSD license:

	Copyright (c) 2006, Bernard Sumption. All rights reserved.

	Redistribution and use in source and binary forms, with or without
	modification, are permitted provided that the following conditions are met:

	Redistributions of source code must retain the above copyright notice, this
	list of conditions and the following disclaimer. Redistributions in binary
	form must reproduce the above copyright notice, this list of conditions and
	the following disclaimer in the documentation and/or other materials
	provided with the distribution. Neither the name BernieCode nor
	the names of its contributors may be used to endorse or promote products
	derived from this software without specific prior written permission. 

	THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
	AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
	IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
	ARE DISCLAIMED. IN NO EVENT SHALL THE REGENTS OR CONTRIBUTORS BE LIABLE FOR
	ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
	DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
	SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
	CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
	LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
	OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH
	DAMAGE.

*/
function Animator(t) {
    this.setOptions(t);
    var e = this;
    this.timerDelegate = function() {
        e.onTimerEvent()
    }, this.subjects = [], this.subjectScopes = [], this.target = 0, this.state = 0, this.lastTime = null
}

function NumericalStyleSubject(t, e, i, n, a) {
    this.els = Animator.makeArray(t), "opacity" == e && window.ActiveXObject ? this.property = "filter" : this.property = Animator.camelize(e), this.from = parseFloat(i), this.to = parseFloat(n), this.units = null != a ? a : "px"
}

function ColorStyleSubject(t, e, i, n) {
    this.els = Animator.makeArray(t), this.property = Animator.camelize(e), this.to = this.expandColor(n), this.from = this.expandColor(i), this.origFrom = i, this.origTo = n
}

function DiscreteStyleSubject(t, e, i, n, a) {
    this.els = Animator.makeArray(t), this.property = Animator.camelize(e), this.from = i, this.to = n, this.threshold = a || .5
}

function CSSStyleSubject(t, e, i) {
    if (t = Animator.makeArray(t), this.subjects = [], 0 != t.length) {
        var n, a, o;
        if (i) o = this.parseStyle(e, t[0]), a = this.parseStyle(i, t[0]);
        else {
            a = this.parseStyle(e, t[0]), o = {};
            for (n in a) o[n] = CSSStyleSubject.getStyle(t[0], n)
        }
        var n;
        for (n in o) o[n] == a[n] && (delete o[n], delete a[n]);
        var n, s, r, l, u, c;
        for (n in o) {
            var d = String(o[n]),
                h = String(a[n]);
            if (null != a[n]) {
                if (u = ColorStyleSubject.parseColor(d)) c = ColorStyleSubject.parseColor(h), l = ColorStyleSubject;
                else if (d.match(CSSStyleSubject.numericalRe) && h.match(CSSStyleSubject.numericalRe)) {
                    u = parseFloat(d), c = parseFloat(h), l = NumericalStyleSubject, r = CSSStyleSubject.numericalRe.exec(d);
                    var f = CSSStyleSubject.numericalRe.exec(h);
                    s = null != r[1] ? r[1] : null != f[1] ? f[1] : f
                } else {
                    if (!d.match(CSSStyleSubject.discreteRe) || !h.match(CSSStyleSubject.discreteRe)) {
                        window.DEBUG && alert("Unrecognised format for value of " + n + ": '" + o[n] + "'");
                        continue
                    }
                    u = d, c = h, l = DiscreteStyleSubject, s = 0
                }
                this.subjects[this.subjects.length] = new l(t, n, u, c, s)
            } else window.DEBUG && alert("No to style provided for '" + n + '"')
        }
    }
}

function AnimatorChain(t, e) {
    this.animators = t, this.setOptions(e);
    for (var i = 0; i < this.animators.length; i++) this.listenTo(this.animators[i]);
    this.forwards = !1, this.current = 0
}

function Accordion(t) {
    this.setOptions(t);
    var e = this.options.initialSection,
        i;
    this.options.rememberance && (i = document.location.hash.substring(1)), this.rememberanceTexts = [], this.ans = [];
    for (var n = this, a = 0; a < this.options.sections.length; a++) {
        var o = this.options.sections[a],
            s = new Animator(this.options.animatorOptions),
            r = this.options.from + this.options.shift * a,
            l = this.options.to + this.options.shift * a;
        s.addSubject(new NumericalStyleSubject(o, this.options.property, r, l, this.options.units)), s.jumpTo(0);
        var u = this.options.getActivator(o);
        u.index = a, u.onclick = function() {
            n.show(this.index)
        }, this.ans[this.ans.length] = s, this.rememberanceTexts[a] = u.innerHTML.replace(/\s/g, ""), this.rememberanceTexts[a] === i && (e = a)
    }
    this.show(e)
}

function embedMixcloudPlayer(t) {
    var e = encodeURIComponent(t);
    e = e.replace("https", "http");
    var i = '<iframe data-state="0" class="mixcloudplayer" width="100%" height="80" src="//www.mixcloud.com/widget/iframe/?feed=' + e + '&embed_uuid=addfd1ba-1531-4f6e-9977-6ca2bd308dcc&stylecolor=&embed_type=widget_standard" frameborder="0"></iframe><div class="canc"></div>';
    return i
}

function embedVideo(t, e, i) {
    i = e / 16 * 9;
    var n = t,
        a = n.match(/=[\w-]{11}/),
        o = a[0].replace(/=/, ""),
        s = '<iframe width="' + e + '" height="' + i + '" src="' + window.location.protocol + "//www.youtube.com/embed/" + o + '?html5=1" frameborder="0" class="youtube-player" allowfullscreen></iframe>';
    return s
}

function embedYahooVideo(t) {
    var e = t,
        i = e.match(/\d{8}/),
        n = e.match(/\d{7}/),
        a = '<div class="embedded_video">\n';
    return a += '<object width="100%">\n', a += '<param name="movie" value="http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.46" />\n', a += '<param name="allowFullScreen" value="true" />\n', a += '<param name="AllowScriptAccess" VALUE="always" />\n', a += '<param name="bgcolor" value="#000000" />\n', a += '<param name="flashVars" value="id=' + i + "&vid=" + n + '&lang=en-us&intl=us&embed=1&ap=9460582" />\n', a += '<embed src="http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.46" type="application/x-shockwave-flash"  allowFullScreen="true" AllowScriptAccess="always" bgcolor="#000000" flashVars="id=' + i + "&vid=" + n + '&lang=en-us&intl=us&embed=1&ap=9460582" >\n', a += "</embed>\n", a += "</object>\n", a += "</div>\n"
}
Animator.prototype = {
        setOptions: function(t) {
            this.options = Animator.applyDefaults({
                interval: 20,
                duration: 400,
                onComplete: function() {},
                onStep: function() {},
                transition: Animator.tx.easeInOut
            }, t)
        },
        seekTo: function(t) {
            this.seekFromTo(this.state, t)
        },
        seekFromTo: function(t, e) {
            this.target = Math.max(0, Math.min(1, e)), this.state = Math.max(0, Math.min(1, t)), this.lastTime = (new Date).getTime(), this.intervalId || (this.intervalId = window.setInterval(this.timerDelegate, this.options.interval))
        },
        jumpTo: function(t) {
            this.target = this.state = Math.max(0, Math.min(1, t)), this.propagate()
        },
        toggle: function() {
            this.seekTo(1 - this.target)
        },
        addSubject: function(t, e) {
            return this.subjects[this.subjects.length] = t, this.subjectScopes[this.subjectScopes.length] = e, this
        },
        clearSubjects: function() {
            this.subjects = [], this.subjectScopes = []
        },
        propagate: function() {
            for (var t = this.options.transition(this.state), e = 0; e < this.subjects.length; e++) this.subjects[e].setState ? this.subjects[e].setState(t) : this.subjects[e].apply(this.subjectScopes[e], [t])
        },
        onTimerEvent: function() {
            var t = (new Date).getTime(),
                e = t - this.lastTime;
            this.lastTime = t;
            var i = e / this.options.duration * (this.state < this.target ? 1 : -1);
            Math.abs(i) >= Math.abs(this.state - this.target) ? this.state = this.target : this.state += i;
            try {
                this.propagate()
            } finally {
                this.options.onStep.call(this), this.target == this.state && (window.clearInterval(this.intervalId), this.intervalId = null, this.options.onComplete.call(this))
            }
        },
        play: function() {
            this.seekFromTo(0, 1)
        },
        reverse: function() {
            this.seekFromTo(1, 0)
        },
        inspect: function() {
            for (var t = "#<Animator:\n", e = 0; e < this.subjects.length; e++) t += this.subjects[e].inspect();
            return t += ">"
        }
    }, Animator.applyDefaults = function(t, e) {
        e = e || {};
        var i, n = {};
        for (i in t) n[i] = void 0 !== e[i] ? e[i] : t[i];
        return n
    }, Animator.makeArray = function(t) {
        if (null == t) return [];
        if (!t.length) return [t];
        for (var e = [], i = 0; i < t.length; i++) e[i] = t[i];
        return e
    }, Animator.camelize = function(t) {
        var e = t.split("-");
        if (1 == e.length) return e[0];
        for (var i = 0 == t.indexOf("-") ? e[0].charAt(0).toUpperCase() + e[0].substring(1) : e[0], n = 1, a = e.length; a > n; n++) {
            var o = e[n];
            i += o.charAt(0).toUpperCase() + o.substring(1)
        }
        return i
    }, Animator.apply = function(t, e, i) {
        return e instanceof Array ? new Animator(i).addSubject(new CSSStyleSubject(t, e[0], e[1])) : new Animator(i).addSubject(new CSSStyleSubject(t, e))
    }, Animator.makeEaseIn = function(t) {
        return function(e) {
            return Math.pow(e, 2 * t)
        }
    }, Animator.makeEaseOut = function(t) {
        return function(e) {
            return 1 - Math.pow(1 - e, 2 * t)
        }
    }, Animator.makeElastic = function(t) {
        return function(e) {
            return e = Animator.tx.easeInOut(e), (1 - Math.cos(e * Math.PI * t)) * (1 - e) + e
        }
    }, Animator.makeADSR = function(t, e, i, n) {
        return null == n && (n = .5),
            function(a) {
                return t > a ? a / t : e > a ? 1 - (a - t) / (e - t) * (1 - n) : i > a ? n : n * (1 - (a - i) / (1 - i))
            }
    }, Animator.makeBounce = function(t) {
        var e = Animator.makeElastic(t);
        return function(t) {
            return t = e(t), 1 >= t ? t : 2 - t
        }
    }, Animator.tx = {
        easeInOut: function(t) {
            return -Math.cos(t * Math.PI) / 2 + .5
        },
        linear: function(t) {
            return t
        },
        easeIn: Animator.makeEaseIn(1.5),
        easeOut: Animator.makeEaseOut(1.5),
        strongEaseIn: Animator.makeEaseIn(2.5),
        strongEaseOut: Animator.makeEaseOut(2.5),
        elastic: Animator.makeElastic(1),
        veryElastic: Animator.makeElastic(3),
        bouncy: Animator.makeBounce(1),
        veryBouncy: Animator.makeBounce(3)
    }, NumericalStyleSubject.prototype = {
        setState: function(t) {
            for (var e = this.getStyle(t), i = "opacity" == this.property && 0 == t ? "hidden" : "", n = 0, a = 0; a < this.els.length; a++) {
                try {
                    this.els[a].style[this.property] = e
                } catch (o) {
                    if ("fontWeight" != this.property) throw o
                }
                if (n++ > 20) return
            }
        },
        getStyle: function(t) {
            return t = this.from + (this.to - this.from) * t, "filter" == this.property ? "alpha(opacity=" + Math.round(100 * t) + ")" : "opacity" == this.property ? t : Math.round(t) + this.units
        },
        inspect: function() {
            return "	" + this.property + "(" + this.from + this.units + " to " + this.to + this.units + ")\n"
        }
    }, ColorStyleSubject.prototype = {
        expandColor: function(t) {
            var e, i, n, a;
            return (e = ColorStyleSubject.parseColor(t)) ? (i = parseInt(e.slice(1, 3), 16), n = parseInt(e.slice(3, 5), 16), a = parseInt(e.slice(5, 7), 16), [i, n, a]) : void(window.DEBUG && alert("Invalid colour: '" + t + "'"))
        },
        getValueForState: function(t, e) {
            return Math.round(this.from[t] + (this.to[t] - this.from[t]) * e)
        },
        setState: function(t) {
            for (var e = "#" + ColorStyleSubject.toColorPart(this.getValueForState(0, t)) + ColorStyleSubject.toColorPart(this.getValueForState(1, t)) + ColorStyleSubject.toColorPart(this.getValueForState(2, t)), i = 0; i < this.els.length; i++) this.els[i].style[this.property] = e
        },
        inspect: function() {
            return "	" + this.property + "(" + this.origFrom + " to " + this.origTo + ")\n"
        }
    }, ColorStyleSubject.parseColor = function(t) {
        var e = "#",
            i;
        if (i = ColorStyleSubject.parseColor.rgbRe.exec(t)) {
            for (var n, a = 1; 3 >= a; a++) n = Math.max(0, Math.min(255, parseInt(i[a]))), e += ColorStyleSubject.toColorPart(n);
            return e
        }
        if (i = ColorStyleSubject.parseColor.hexRe.exec(t)) {
            if (3 == i[1].length) {
                for (var a = 0; 3 > a; a++) e += i[1].charAt(a) + i[1].charAt(a);
                return e
            }
            return "#" + i[1]
        }
        return !1
    }, ColorStyleSubject.toColorPart = function(t) {
        t > 255 && (t = 255);
        var e = t.toString(16);
        return 16 > t ? "0" + e : e
    }, ColorStyleSubject.parseColor.rgbRe = /^rgb\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\)$/i, ColorStyleSubject.parseColor.hexRe = /^\#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/, DiscreteStyleSubject.prototype = {
        setState: function(t) {
            for (var e = 0, i = 0; i < this.els.length; i++) this.els[i].style[this.property] = t <= this.threshold ? this.from : this.to
        },
        inspect: function() {
            return "	" + this.property + "(" + this.from + " to " + this.to + " @ " + this.threshold + ")\n"
        }
    }, CSSStyleSubject.prototype = {
        parseStyle: function(t, e) {
            var i = {};
            if (-1 != t.indexOf(":"))
                for (var n = t.split(";"), a = 0; a < n.length; a++) {
                    var o = CSSStyleSubject.ruleRe.exec(n[a]);
                    o && (i[o[1]] = o[2])
                } else {
                    var s, r, l;
                    l = e.className, e.className = t;
                    for (var a = 0; a < CSSStyleSubject.cssProperties.length; a++) s = CSSStyleSubject.cssProperties[a], r = CSSStyleSubject.getStyle(e, s), null != r && (i[s] = r);
                    e.className = l
                }
            return i
        },
        setState: function(t) {
            for (var e = 0; e < this.subjects.length; e++) this.subjects[e].setState(t)
        },
        inspect: function() {
            for (var t = "", e = 0; e < this.subjects.length; e++) t += this.subjects[e].inspect();
            return t
        }
    }, CSSStyleSubject.getStyle = function(t, e) {
        var i;
        return document.defaultView && document.defaultView.getComputedStyle && (i = document.defaultView.getComputedStyle(t, "").getPropertyValue(e)) ? i : (e = Animator.camelize(e), t.currentStyle && (i = t.currentStyle[e]), i || t.style[e])
    }, CSSStyleSubject.ruleRe = /^\s*([a-zA-Z\-]+)\s*:\s*(\S(.+\S)?)\s*$/, CSSStyleSubject.numericalRe = /^-?\d+(?:\.\d+)?(%|[a-zA-Z]{2})?$/, CSSStyleSubject.discreteRe = /^\w+$/, CSSStyleSubject.cssProperties = ["azimuth", "background", "background-attachment", "background-color", "background-image", "background-position", "background-repeat", "border-collapse", "border-color", "border-spacing", "border-style", "border-top", "border-top-color", "border-right-color", "border-bottom-color", "border-left-color", "border-top-style", "border-right-style", "border-bottom-style", "border-left-style", "border-top-width", "border-right-width", "border-bottom-width", "border-left-width", "border-width", "bottom", "clear", "clip", "color", "content", "cursor", "direction", "display", "elevation", "empty-cells", "css-float", "font", "font-family", "font-size", "font-size-adjust", "font-stretch", "font-style", "font-variant", "font-weight", "height", "left", "letter-spacing", "line-height", "list-style", "list-style-image", "list-style-position", "list-style-type", "margin", "margin-top", "margin-right", "margin-bottom", "margin-left", "max-height", "max-width", "min-height", "min-width", "orphans", "outline", "outline-color", "outline-style", "outline-width", "overflow", "padding", "padding-top", "padding-right", "padding-bottom", "padding-left", "pause", "position", "right", "size", "table-layout", "text-align", "text-decoration", "text-indent", "text-shadow", "text-transform", "top", "vertical-align", "visibility", "white-space", "width", "word-spacing", "z-index", "opacity", "outline-offset", "overflow-x", "overflow-y"], AnimatorChain.prototype = {
        setOptions: function(t) {
            this.options = Animator.applyDefaults({
                resetOnPlay: !0
            }, t)
        },
        play: function() {
            if (this.forwards = !0, this.current = -1, this.options.resetOnPlay)
                for (var t = 0; t < this.animators.length; t++) this.animators[t].jumpTo(0);
            this.advance()
        },
        reverse: function() {
            if (this.forwards = !1, this.current = this.animators.length, this.options.resetOnPlay)
                for (var t = 0; t < this.animators.length; t++) this.animators[t].jumpTo(1);
            this.advance()
        },
        toggle: function() {
            this.forwards ? this.seekTo(0) : this.seekTo(1)
        },
        listenTo: function(t) {
            var e = t.options.onComplete,
                i = this;
            t.options.onComplete = function() {
                e && e.call(t), i.advance()
            }
        },
        advance: function() {
            if (this.forwards) {
                if (null == this.animators[this.current + 1]) return;
                this.current++, this.animators[this.current].play()
            } else {
                if (null == this.animators[this.current - 1]) return;
                this.current--, this.animators[this.current].reverse()
            }
        },
        seekTo: function(t) {
            0 >= t ? (this.forwards = !1, this.animators[this.current].seekTo(0)) : (this.forwards = !0, this.animators[this.current].seekTo(1))
        }
    }, Accordion.prototype = {
        setOptions: function(t) {
            this.options = Object.extend({
                sections: null,
                getActivator: function(t) {
                    return document.getElementById(t.getAttribute("activator"))
                },
                shift: 0,
                initialSection: 0,
                rememberance: !0,
                animatorOptions: {}
            }, t || {})
        },
        show: function(t) {
            for (var e = 0; e < this.ans.length; e++) this.ans[e].seekTo(e > t ? 1 : 0);
            this.options.rememberance && (document.location.hash = this.rememberanceTexts[t])
        }
    },
    /** @license
     *
     * SoundManager 2: JavaScript Sound for the Web
     * ----------------------------------------------
     * http://schillmania.com/projects/soundmanager2/
     *
     * Copyright (c) 2007, Scott Schiller. All rights reserved.
     * Code provided under the BSD License:
     * http://schillmania.com/projects/soundmanager2/license.txt
     *
     * V2.97a.20150601
     */
    function(t, e) {
        "use strict";

        function i(i, n) {
            function a(t) {
                return r.preferFlash && Nt && !r.ignoreFlash && r.flash[t] !== e && r.flash[t]
            }

            function o(t) {
                return function(e) {
                    var i = this._s,
                        n;
                    return n = i && i._a ? t.call(this, e) : null
                }
            }
            this.setupOptions = {
                url: i || null,
                flashVersion: 8,
                debugMode: !0,
                debugFlash: !1,
                useConsole: !0,
                consoleOnly: !0,
                waitForWindowLoad: !1,
                bgColor: "#ffffff",
                useHighPerformance: !1,
                flashPollingInterval: null,
                html5PollingInterval: null,
                flashLoadTimeout: 1e3,
                wmode: null,
                allowScriptAccess: "always",
                useFlashBlock: !1,
                useHTML5Audio: !0,
                forceUseGlobalHTML5Audio: !1,
                ignoreMobileRestrictions: !1,
                html5Test: /^(probably|maybe)$/i,
                preferFlash: !1,
                noSWFCache: !1,
                idPrefix: "sound"
            }, this.defaultOptions = {
                autoLoad: !1,
                autoPlay: !1,
                from: null,
                loops: 1,
                onid3: null,
                onload: null,
                whileloading: null,
                onplay: null,
                onpause: null,
                onresume: null,
                whileplaying: null,
                onposition: null,
                onstop: null,
                onfailure: null,
                onfinish: null,
                multiShot: !0,
                multiShotEvents: !1,
                position: null,
                pan: 0,
                stream: !0,
                to: null,
                type: null,
                usePolicyFile: !1,
                volume: 100
            }, this.flash9Options = {
                isMovieStar: null,
                usePeakData: !1,
                useWaveformData: !1,
                useEQData: !1,
                onbufferchange: null,
                ondataerror: null
            }, this.movieStarOptions = {
                bufferTime: 3,
                serverURL: null,
                onconnect: null,
                duration: null
            }, this.audioFormats = {
                mp3: {
                    type: ['audio/mpeg; codecs="mp3"', "audio/mpeg", "audio/mp3", "audio/MPA", "audio/mpa-robust"],
                    required: !0
                },
                mp4: {
                    related: ["aac", "m4a", "m4b"],
                    type: ['audio/mp4; codecs="mp4a.40.2"', "audio/aac", "audio/x-m4a", "audio/MP4A-LATM", "audio/mpeg4-generic"],
                    required: !1
                },
                ogg: {
                    type: ["audio/ogg; codecs=vorbis"],
                    required: !1
                },
                opus: {
                    type: ["audio/ogg; codecs=opus", "audio/opus"],
                    required: !1
                },
                wav: {
                    type: ['audio/wav; codecs="1"', "audio/wav", "audio/wave", "audio/x-wav"],
                    required: !1
                }
            }, this.movieID = "sm2-container", this.id = n || "sm2movie", this.debugID = "soundmanager-debug", this.debugURLParam = /([#?&])debug=1/i, this.versionNumber = "V2.97a.20150601", this.version = null, this.movieURL = null, this.altURL = null, this.swfLoaded = !1, this.enabled = !1, this.oMC = null, this.sounds = {}, this.soundIDs = [], this.muted = !1, this.didFlashBlock = !1, this.filePattern = null, this.filePatterns = {
                flash8: /\.mp3(\?.*)?$/i,
                flash9: /\.mp3(\?.*)?$/i
            }, this.features = {
                buffering: !1,
                peakData: !1,
                waveformData: !1,
                eqData: !1,
                movieStar: !1
            }, this.sandbox = {}, this.html5 = {
                usingFlash: null
            }, this.flash = {}, this.html5Only = !1, this.ignoreFlash = !1;
            var s, r = this,
                l = null,
                u = null,
                c = "soundManager",
                d = c + ": ",
                h = "HTML5::",
                f, p = navigator.userAgent,
                m = t.location.href.toString(),
                g = document,
                v, y, w, b, _ = [],
                C = !0,
                x, S = !1,
                k = !1,
                T = !1,
                M = !1,
                P = !1,
                O, D = 0,
                L, E, F, A, I, q, j, N, V, z, H, R, B, Q, W, X, U, Y, G, Z, J, K, tt = ["log", "info", "warn", "error"],
                et = 8,
                it, nt, at, ot = null,
                st = null,
                rt, lt, ut, ct, dt, ht, ft, pt, mt, gt = !1,
                vt = !1,
                yt, wt, bt, _t = 0,
                Ct = null,
                xt, St = [],
                kt, Tt = null,
                Mt, Pt, Ot, Dt, Lt, Et, Ft, At, It = Array.prototype.slice,
                qt = !1,
                jt, Nt, Vt, $t, zt, Ht, Rt, Bt, Qt = 0,
                Wt, Xt = 1e3,
                Ut = p.match(/(ipad|iphone|ipod)/i),
                Yt = p.match(/android/i),
                Gt = p.match(/msie/i),
                Zt = p.match(/webkit/i),
                Jt = p.match(/safari/i) && !p.match(/chrome/i),
                Kt = p.match(/opera/i),
                te = p.match(/(mobile|pre\/|xoom)/i) || Ut || Yt,
                ee = !m.match(/usehtml5audio/i) && !m.match(/sm2\-ignorebadua/i) && Jt && !p.match(/silk/i) && p.match(/OS X 10_6_([3-7])/i),
                ie = t.console !== e && console.log !== e,
                ne = g.hasFocus !== e ? g.hasFocus() : null,
                ae = Jt && (g.hasFocus === e || !g.hasFocus()),
                oe = !ae,
                se = /(mp3|mp4|mpa|m4a|m4b)/i,
                re = "about:blank",
                le = "data:audio/wave;base64,/UklGRiYAAABXQVZFZm10IBAAAAABAAEARKwAAIhYAQACABAAZGF0YQIAAAD//w==",
                ue = g.location ? g.location.protocol.match(/http/i) : null,
                ce = ue ? "" : "http://",
                de = /^\s*audio\/(?:x-)?(?:mpeg4|aac|flv|mov|mp4||m4v|m4a|m4b|mp4v|3gp|3g2)\s*(?:$|;)/i,
                he = ["mpeg4", "aac", "flv", "mov", "mp4", "m4v", "f4v", "m4a", "m4b", "mp4v", "3gp", "3g2"],
                fe = new RegExp("\\.(" + he.join("|") + ")(\\?.*)?$", "i");
            this.mimePattern = /^\s*audio\/(?:x-)?(?:mp(?:eg|3))\s*(?:$|;)/i, this.useAltURL = !ue, ct = {
                swfBox: "sm2-object-box",
                swfDefault: "movieContainer",
                swfError: "swf_error",
                swfTimedout: "swf_timedout",
                swfLoaded: "swf_loaded",
                swfUnblocked: "swf_unblocked",
                sm2Debug: "sm2_debug",
                highPerf: "high_performance",
                flashDebug: "flash_debug"
            }, this.hasHTML5 = function() {
                try {
                    return Audio !== e && (Kt && opera !== e && opera.version() < 10 ? new Audio(null) : new Audio).canPlayType !== e
                } catch (t) {
                    return !1
                }
            }(), this.setup = function(t) {
                var i = !r.url;
                return t !== e && T && Tt && r.ok() && (t.flashVersion !== e || t.url !== e || t.html5Test !== e), F(t), qt || (te ? r.setupOptions.ignoreMobileRestrictions && !r.setupOptions.forceUseGlobalHTML5Audio || (St.push(B.globalHTML5), qt = !0) : r.setupOptions.forceUseGlobalHTML5Audio && (St.push(B.globalHTML5), qt = !0)), !Wt && te && (r.setupOptions.ignoreMobileRestrictions ? St.push(B.ignoreMobile) : (r.setupOptions.useHTML5Audio = !0, r.setupOptions.preferFlash = !1, Ut ? r.ignoreFlash = !0 : (Yt && !p.match(/android\s2\.3/i) || !Yt) && (qt = !0))), t && (i && U && t.url !== e && r.beginDelayedInit(), U || t.url === e || "complete" !== g.readyState || setTimeout(W, 1)), Wt = !0, r
            }, this.ok = function() {
                return Tt ? T && !M : r.useHTML5Audio && r.hasHTML5
            }, this.supported = this.ok, this.getMovie = function(e) {
                return f(e) || g[e] || t[e]
            }, this.createSound = function(t, i) {
                function n() {
                    return l = ht(l), r.sounds[l.id] = new s(l), r.soundIDs.push(l.id), r.sounds[l.id]
                }
                var a, o, l, c = null;
                if (!T || !r.ok()) return !1;
                if (i !== e && (t = {
                        id: t,
                        url: i
                    }), l = E(t), l.url = xt(l.url), l.id === e && (l.id = r.setupOptions.idPrefix + Qt++), mt(l.id, !0)) return r.sounds[l.id];
                if (Pt(l)) c = n(), c._setup_html5(l);
                else {
                    if (r.html5Only) return n();
                    if (r.html5.usingFlash && l.url && l.url.match(/data\:/i)) return n();
                    b > 8 && null === l.isMovieStar && (l.isMovieStar = !!(l.serverURL || (l.type ? l.type.match(de) : !1) || l.url && l.url.match(fe))), l = ft(l, a), c = n(), 8 === b ? u._createSound(l.id, l.loops || 1, l.usePolicyFile) : (u._createSound(l.id, l.url, l.usePeakData, l.useWaveformData, l.useEQData, l.isMovieStar, l.isMovieStar ? l.bufferTime : !1, l.loops || 1, l.serverURL, l.duration || null, l.autoPlay, !0, l.autoLoad, l.usePolicyFile), l.serverURL || (c.connected = !0, l.onconnect && l.onconnect.apply(c))), l.serverURL || !l.autoLoad && !l.autoPlay || c.load(l)
                }
                return !l.serverURL && l.autoPlay && c.play(), c
            }, this.destroySound = function(t, e) {
                if (!mt(t)) return !1;
                var i = r.sounds[t],
                    n;
                for (i.stop(), i._iO = {}, i.unload(), n = 0; n < r.soundIDs.length; n++)
                    if (r.soundIDs[n] === t) {
                        r.soundIDs.splice(n, 1);
                        break
                    }
                return e || i.destruct(!0), i = null, delete r.sounds[t], !0
            }, this.load = function(t, e) {
                return mt(t) ? r.sounds[t].load(e) : !1
            }, this.unload = function(t) {
                return mt(t) ? r.sounds[t].unload() : !1
            }, this.onPosition = function(t, e, i, n) {
                return mt(t) ? r.sounds[t].onposition(e, i, n) : !1
            }, this.onposition = this.onPosition, this.clearOnPosition = function(t, e, i) {
                return mt(t) ? r.sounds[t].clearOnPosition(e, i) : !1
            }, this.play = function(t, e) {
                var i = null,
                    n = e && !(e instanceof Object);
                if (!T || !r.ok()) return !1;
                if (mt(t, n)) n && (e = {
                    url: e
                });
                else {
                    if (!n) return !1;
                    n && (e = {
                        url: e
                    }), e && e.url && (e.id = t, i = r.createSound(e).play())
                }
                return null === i && (i = r.sounds[t].play(e)), i
            }, this.start = this.play, this.setPosition = function(t, e) {
                return mt(t) ? r.sounds[t].setPosition(e) : !1
            }, this.stop = function(t) {
                return mt(t) ? r.sounds[t].stop() : !1
            }, this.stopAll = function() {
                var t;
                for (t in r.sounds) r.sounds.hasOwnProperty(t) && r.sounds[t].stop()
            }, this.pause = function(t) {
                return mt(t) ? r.sounds[t].pause() : !1
            }, this.pauseAll = function() {
                var t;
                for (t = r.soundIDs.length - 1; t >= 0; t--) r.sounds[r.soundIDs[t]].pause()
            }, this.resume = function(t) {
                return mt(t) ? r.sounds[t].resume() : !1
            }, this.resumeAll = function() {
                var t;
                for (t = r.soundIDs.length - 1; t >= 0; t--) r.sounds[r.soundIDs[t]].resume()
            }, this.togglePause = function(t) {
                return mt(t) ? r.sounds[t].togglePause() : !1
            }, this.setPan = function(t, e) {
                return mt(t) ? r.sounds[t].setPan(e) : !1
            }, this.setVolume = function(t, i) {
                var n, a; {
                    if (t === e || isNaN(t) || i !== e) return mt(t) ? r.sounds[t].setVolume(i) : !1;
                    for (n = 0, a = r.soundIDs.length; a > n; n++) r.sounds[r.soundIDs[n]].setVolume(t)
                }
            }, this.mute = function(t) {
                var e = 0;
                if (t instanceof String && (t = null), t) return mt(t) ? r.sounds[t].mute() : !1;
                for (e = r.soundIDs.length - 1; e >= 0; e--) r.sounds[r.soundIDs[e]].mute();
                return r.muted = !0, !0
            }, this.muteAll = function() {
                r.mute()
            }, this.unmute = function(t) {
                var e;
                if (t instanceof String && (t = null), t) return mt(t) ? r.sounds[t].unmute() : !1;
                for (e = r.soundIDs.length - 1; e >= 0; e--) r.sounds[r.soundIDs[e]].unmute();
                return r.muted = !1, !0
            }, this.unmuteAll = function() {
                r.unmute()
            }, this.toggleMute = function(t) {
                return mt(t) ? r.sounds[t].toggleMute() : !1
            }, this.getMemoryUse = function() {
                var t = 0;
                return u && 8 !== b && (t = parseInt(u._getMemoryUse(), 10)), t
            }, this.disable = function(i) {
                var n;
                if (i === e && (i = !1), M) return !1;
                for (M = !0, n = r.soundIDs.length - 1; n >= 0; n--) it(r.sounds[r.soundIDs[n]]);
                return L(i), At.remove(t, "load", j), !0
            }, this.canPlayMIME = function(t) {
                var e;
                return r.hasHTML5 && (e = Ot({
                    type: t
                })), !e && Tt && (e = t && r.ok() ? !!((b > 8 ? t.match(de) : null) || t.match(r.mimePattern)) : null), e
            }, this.canPlayURL = function(t) {
                var e;
                return r.hasHTML5 && (e = Ot({
                    url: t
                })), !e && Tt && (e = t && r.ok() ? !!t.match(r.filePattern) : null), e
            }, this.canPlayLink = function(t) {
                return t.type !== e && t.type && r.canPlayMIME(t.type) ? !0 : r.canPlayURL(t.href)
            }, this.getSoundById = function(t, e) {
                if (!t) return null;
                var i = r.sounds[t];
                return i
            }, this.onready = function(e, i) {
                var n = "onready",
                    a = !1;
                if ("function" != typeof e) throw rt("needFunction", n);
                return i || (i = t), I(n, e, i), q(), a = !0, a
            }, this.ontimeout = function(e, i) {
                var n = "ontimeout",
                    a = !1;
                if ("function" != typeof e) throw rt("needFunction", n);
                return i || (i = t), I(n, e, i), q({
                    type: n
                }), a = !0, a
            }, this._writeDebug = function(t, e) {
                return !0
            }, this._wD = this._writeDebug, this._debug = function() {}, this.reboot = function(e, i) {
                var n, a, o;
                for (n = r.soundIDs.length - 1; n >= 0; n--) r.sounds[r.soundIDs[n]].destruct();
                if (u) try {
                    Gt && (st = u.innerHTML), ot = u.parentNode.removeChild(u)
                } catch (s) {}
                if (st = ot = Tt = u = null, r.enabled = U = T = gt = vt = S = k = M = qt = r.swfLoaded = !1, r.soundIDs = [], r.sounds = {}, Qt = 0, Wt = !1, e) _ = [];
                else
                    for (n in _)
                        if (_.hasOwnProperty(n))
                            for (a = 0, o = _[n].length; o > a; a++) _[n][a].fired = !1; return r.html5 = {
                    usingFlash: null
                }, r.flash = {}, r.html5Only = !1, r.ignoreFlash = !1, t.setTimeout(function() {
                    i || r.beginDelayedInit()
                }, 20), r
            }, this.reset = function() {
                return r.reboot(!0, !0)
            }, this.getMoviePercent = function() {
                return u && "PercentLoaded" in u ? u.PercentLoaded() : null
            }, this.beginDelayedInit = function() {
                P = !0, W(), setTimeout(function() {
                    return vt ? !1 : (G(), Q(), vt = !0, !0)
                }, 20), N()
            }, this.destruct = function() {
                r.disable(!0)
            }, s = function(t) {
                var i = this,
                    n, a, o, s, c, d, h = !1,
                    f = [],
                    p = 0,
                    m, g, v = null,
                    y, w;
                y = {
                    duration: null,
                    time: null
                }, this.id = t.id, this.sID = this.id, this.url = t.url, this.options = E(t), this.instanceOptions = this.options, this._iO = this.instanceOptions, this.pan = this.options.pan, this.volume = this.options.volume, this.isHTML5 = !1, this._a = null, w = !this.url, this.id3 = {}, this._debug = function() {}, this.load = function(t) {
                    var n = null,
                        a;
                    if (t !== e ? i._iO = E(t, i.options) : (t = i.options, i._iO = t, v && v !== i.url && (i._iO.url = i.url, i.url = null)), i._iO.url || (i._iO.url = i.url), i._iO.url = xt(i._iO.url), i.instanceOptions = i._iO, a = i._iO, !a.url && !i.url) return i;
                    if (a.url === i.url && 0 !== i.readyState && 2 !== i.readyState) return 3 === i.readyState && a.onload && Bt(i, function() {
                        a.onload.apply(i, [!!i.duration])
                    }), i;
                    if (i.loaded = !1, i.readyState = 1, i.playState = 0, i.id3 = {}, Pt(a)) n = i._setup_html5(a), n._called_load || (i._html5_canplay = !1, i.url !== a.url && (i._a.src = a.url, i.setPosition(0)), i._a.autobuffer = "auto", i._a.preload = "auto", i._a._called_load = !0);
                    else {
                        if (r.html5Only) return i;
                        if (i._iO.url && i._iO.url.match(/data\:/i)) return i;
                        try {
                            i.isHTML5 = !1, i._iO = ft(ht(a)), i._iO.autoPlay && (i._iO.position || i._iO.from) && (i._iO.autoPlay = !1), a = i._iO, 8 === b ? u._load(i.id, a.url, a.stream, a.autoPlay, a.usePolicyFile) : u._load(i.id, a.url, !!a.stream, !!a.autoPlay, a.loops || 1, !!a.autoLoad, a.usePolicyFile)
                        } catch (o) {
                            Z({
                                type: "SMSOUND_LOAD_JS_EXCEPTION",
                                fatal: !0
                            })
                        }
                    }
                    return i.url = a.url, i
                }, this.unload = function() {
                    return 0 !== i.readyState && (i.isHTML5 ? (s(), i._a && (i._a.pause(), v = Lt(i._a))) : 8 === b ? u._unload(i.id, re) : u._unload(i.id), n()), i
                }, this.destruct = function(t) {
                    i.isHTML5 ? (s(), i._a && (i._a.pause(), Lt(i._a), qt || o(), i._a._s = null, i._a = null)) : (i._iO.onfailure = null, u._destroySound(i.id)), t || r.destroySound(i.id, !0)
                }, this.play = function(t, n) {
                    var a, o, s, l, f, p, m, v = !0,
                        y = null;
                    if (n = n === e ? !0 : n, t || (t = {}), i.url && (i._iO.url = i.url), i._iO = E(i._iO, i.options), i._iO = E(t, i._iO), i._iO.url = xt(i._iO.url), i.instanceOptions = i._iO, !i.isHTML5 && i._iO.serverURL && !i.connected) return i.getAutoPlay() || i.setAutoPlay(!0), i;
                    if (Pt(i._iO) && (i._setup_html5(i._iO), c()), 1 !== i.playState || i.paused || (o = i._iO.multiShot, o || (i.isHTML5 && i.setPosition(i._iO.position), y = i)), null !== y) return y;
                    if (t.url && t.url !== i.url && (i.readyState || i.isHTML5 || 8 !== b || !w ? i.load(i._iO) : w = !1), i.loaded || (0 === i.readyState ? (i.isHTML5 || r.html5Only ? i.isHTML5 ? i.load(i._iO) : y = i : (i._iO.autoPlay = !0, i.load(i._iO)), i.instanceOptions = i._iO) : 2 === i.readyState && (y = i)), null !== y) return y;
                    if (!i.isHTML5 && 9 === b && i.position > 0 && i.position === i.duration && (t.position = 0), i.paused && i.position >= 0 && (!i._iO.serverURL || i.position > 0)) i.resume();
                    else {
                        if (i._iO = E(t, i._iO), (!i.isHTML5 && null !== i._iO.position && i._iO.position > 0 || null !== i._iO.from && i._iO.from > 0 || null !== i._iO.to) && 0 === i.instanceCount && 0 === i.playState && !i._iO.serverURL) {
                            if (l = function() {
                                    i._iO = E(t, i._iO), i.play(i._iO)
                                }, i.isHTML5 && !i._html5_canplay ? (i.load({
                                    _oncanplay: l
                                }), y = !1) : i.isHTML5 || i.loaded || i.readyState && 2 === i.readyState || (i.load({
                                    onload: l
                                }), y = !1), null !== y) return y;
                            i._iO = g()
                        }(!i.instanceCount || i._iO.multiShotEvents || i.isHTML5 && i._iO.multiShot && !qt || !i.isHTML5 && b > 8 && !i.getAutoPlay()) && i.instanceCount++, i._iO.onposition && 0 === i.playState && d(i), i.playState = 1, i.paused = !1, i.position = i._iO.position === e || isNaN(i._iO.position) ? 0 : i._iO.position, i.isHTML5 || (i._iO = ft(ht(i._iO))), i._iO.onplay && n && (i._iO.onplay.apply(i), h = !0), i.setVolume(i._iO.volume, !0), i.setPan(i._iO.pan, !0), i.isHTML5 ? i.instanceCount < 2 ? (c(), s = i._setup_html5(), i.setPosition(i._iO.position), s.play()) : (f = new Audio(i._iO.url), p = function() {
                            At.remove(f, "ended", p), i._onfinish(i), Lt(f), f = null
                        }, m = function() {
                            At.remove(f, "canplay", m);
                            try {
                                f.currentTime = i._iO.position / Xt
                            } catch (t) {}
                            f.play()
                        }, At.add(f, "ended", p), i._iO.volume !== e && (f.volume = Math.max(0, Math.min(1, i._iO.volume / 100))), i.muted && (f.muted = !0), i._iO.position ? At.add(f, "canplay", m) : f.play()) : (v = u._start(i.id, i._iO.loops || 1, 9 === b ? i.position : i.position / Xt, i._iO.multiShot || !1), 9 !== b || v || i._iO.onplayerror && i._iO.onplayerror.apply(i))
                    }
                    return i
                }, this.start = this.play, this.stop = function(t) {
                    var e = i._iO,
                        n;
                    return 1 === i.playState && (i._onbufferchange(0), i._resetOnPosition(0), i.paused = !1, i.isHTML5 || (i.playState = 0), m(), e.to && i.clearOnPosition(e.to), i.isHTML5 ? i._a && (n = i.position, i.setPosition(0), i.position = n, i._a.pause(), i.playState = 0, i._onTimer(), s()) : (u._stop(i.id, t), e.serverURL && i.unload()), i.instanceCount = 0, i._iO = {}, e.onstop && e.onstop.apply(i)), i
                }, this.setAutoPlay = function(t) {
                    i._iO.autoPlay = t, i.isHTML5 || (u._setAutoPlay(i.id, t), t && (i.instanceCount || 1 !== i.readyState || i.instanceCount++))
                }, this.getAutoPlay = function() {
                    return i._iO.autoPlay
                }, this.setPosition = function(t) {
                    t === e && (t = 0);
                    var n, a, o = i.isHTML5 ? Math.max(t, 0) : Math.min(i.duration || i._iO.duration, Math.max(t, 0));
                    if (i.position = o, a = i.position / Xt, i._resetOnPosition(i.position), i._iO.position = o, i.isHTML5) {
                        if (i._a) {
                            if (i._html5_canplay) {
                                if (i._a.currentTime !== a) try {
                                    i._a.currentTime = a, (0 === i.playState || i.paused) && i._a.pause()
                                } catch (s) {}
                            } else if (a) return i;
                            i.paused && i._onTimer(!0)
                        }
                    } else n = 9 === b ? i.position : a, i.readyState && 2 !== i.readyState && u._setPosition(i.id, n, i.paused || !i.playState, i._iO.multiShot);
                    return i
                }, this.pause = function(t) {
                    return i.paused || 0 === i.playState && 1 !== i.readyState ? i : (i.paused = !0, i.isHTML5 ? (i._setup_html5().pause(), s()) : (t || t === e) && u._pause(i.id, i._iO.multiShot), i._iO.onpause && i._iO.onpause.apply(i), i)
                }, this.resume = function() {
                    var t = i._iO;
                    return i.paused ? (i.paused = !1, i.playState = 1, i.isHTML5 ? (i._setup_html5().play(), c()) : (t.isMovieStar && !t.serverURL && i.setPosition(i.position), u._pause(i.id, t.multiShot)), !h && t.onplay ? (t.onplay.apply(i), h = !0) : t.onresume && t.onresume.apply(i), i) : i
                }, this.togglePause = function() {
                    return 0 === i.playState ? (i.play({
                        position: 9 !== b || i.isHTML5 ? i.position / Xt : i.position
                    }), i) : (i.paused ? i.resume() : i.pause(), i)
                }, this.setPan = function(t, n) {
                    return t === e && (t = 0), n === e && (n = !1), i.isHTML5 || u._setPan(i.id, t), i._iO.pan = t, n || (i.pan = t, i.options.pan = t), i
                }, this.setVolume = function(t, n) {
                    return t === e && (t = 100), n === e && (n = !1), i.isHTML5 ? i._a && (r.muted && !i.muted && (i.muted = !0, i._a.muted = !0), i._a.volume = Math.max(0, Math.min(1, t / 100))) : u._setVolume(i.id, r.muted && !i.muted || i.muted ? 0 : t), i._iO.volume = t, n || (i.volume = t, i.options.volume = t), i
                }, this.mute = function() {
                    return i.muted = !0, i.isHTML5 ? i._a && (i._a.muted = !0) : u._setVolume(i.id, 0), i
                }, this.unmute = function() {
                    i.muted = !1;
                    var t = i._iO.volume !== e;
                    return i.isHTML5 ? i._a && (i._a.muted = !1) : u._setVolume(i.id, t ? i._iO.volume : i.options.volume), i
                }, this.toggleMute = function() {
                    return i.muted ? i.unmute() : i.mute()
                }, this.onPosition = function(t, n, a) {
                    return f.push({
                        position: parseInt(t, 10),
                        method: n,
                        scope: a !== e ? a : i,
                        fired: !1
                    }), i
                }, this.onposition = this.onPosition, this.clearOnPosition = function(t, e) {
                    var i;
                    if (t = parseInt(t, 10), isNaN(t)) return !1;
                    for (i = 0; i < f.length; i++) t === f[i].position && (e && e !== f[i].method || (f[i].fired && p--, f.splice(i, 1)))
                }, this._processOnPosition = function() {
                    var t, e, n = f.length;
                    if (!n || !i.playState || p >= n) return !1;
                    for (t = n - 1; t >= 0; t--) e = f[t], !e.fired && i.position >= e.position && (e.fired = !0, p++, e.method.apply(e.scope, [e.position]), n = f.length);
                    return !0
                }, this._resetOnPosition = function(t) {
                    var e, i, n = f.length;
                    if (!n) return !1;
                    for (e = n - 1; e >= 0; e--) i = f[e], i.fired && t <= i.position && (i.fired = !1, p--);
                    return !0
                }, g = function() {
                    var t = i._iO,
                        e = t.from,
                        n = t.to,
                        a, o;
                    return o = function() {
                        i.clearOnPosition(n, o), i.stop()
                    }, a = function() {
                        null === n || isNaN(n) || i.onPosition(n, o)
                    }, null === e || isNaN(e) || (t.position = e, t.multiShot = !1, a()), t
                }, d = function() {
                    var t, e = i._iO.onposition;
                    if (e)
                        for (t in e) e.hasOwnProperty(t) && i.onPosition(parseInt(t, 10), e[t])
                }, m = function() {
                    var t, e = i._iO.onposition;
                    if (e)
                        for (t in e) e.hasOwnProperty(t) && i.clearOnPosition(parseInt(t, 10))
                }, c = function() {
                    i.isHTML5 && yt(i)
                }, s = function() {
                    i.isHTML5 && wt(i)
                }, n = function(t) {
                    t || (f = [], p = 0), h = !1, i._hasTimer = null, i._a = null, i._html5_canplay = !1, i.bytesLoaded = null, i.bytesTotal = null, i.duration = i._iO && i._iO.duration ? i._iO.duration : null, i.durationEstimate = null, i.buffered = [], i.eqData = [], i.eqData.left = [], i.eqData.right = [], i.failures = 0, i.isBuffering = !1, i.instanceOptions = {}, i.instanceCount = 0, i.loaded = !1, i.metadata = {}, i.readyState = 0, i.muted = !1, i.paused = !1, i.peakData = {
                        left: 0,
                        right: 0
                    }, i.waveformData = {
                        left: [],
                        right: []
                    }, i.playState = 0, i.position = null, i.id3 = {}
                }, n(), this._onTimer = function(t) {
                    var e, n = !1,
                        a, o = {};
                    return i._hasTimer || t ? (i._a && (t || (i.playState > 0 || 1 === i.readyState) && !i.paused) && (e = i._get_html5_duration(), e !== y.duration && (y.duration = e, i.duration = e, n = !0), i.durationEstimate = i.duration, a = i._a.currentTime * Xt || 0, a !== y.time && (y.time = a, n = !0), (n || t) && i._whileplaying(a, o, o, o, o)), n) : void 0
                }, this._get_html5_duration = function() {
                    var t = i._iO,
                        e = i._a && i._a.duration ? i._a.duration * Xt : t && t.duration ? t.duration : null,
                        n = e && !isNaN(e) && e !== 1 / 0 ? e : null;
                    return n
                }, this._apply_loop = function(t, e) {
                    t.loop = e > 1 ? "loop" : ""
                }, this._setup_html5 = function(t) {
                    var e = E(i._iO, t),
                        o = qt ? l : i._a,
                        s = decodeURI(e.url),
                        r;
                    if (qt ? s === decodeURI(jt) && (r = !0) : s === decodeURI(v) && (r = !0), o) {
                        if (o._s)
                            if (qt) o._s && o._s.playState && !r && o._s.stop();
                            else if (!qt && s === decodeURI(v)) return i._apply_loop(o, e.loops), o;
                        r || (v && n(!1), o.src = e.url, i.url = e.url, v = e.url, jt = e.url, o._called_load = !1)
                    } else e.autoLoad || e.autoPlay ? (i._a = new Audio(e.url), i._a.load()) : i._a = Kt && opera.version() < 10 ? new Audio(null) : new Audio, o = i._a, o._called_load = !1, qt && (l = o);
                    return i.isHTML5 = !0, i._a = o, o._s = i, a(), i._apply_loop(o, e.loops), e.autoLoad || e.autoPlay ? i.load() : (o.autobuffer = !1, o.preload = "auto"), o
                }, a = function() {
                    function t(t, e, n) {
                        return i._a ? i._a.addEventListener(t, e, n || !1) : null
                    }
                    if (i._a._added_events) return !1;
                    var e;
                    i._a._added_events = !0;
                    for (e in zt) zt.hasOwnProperty(e) && t(e, zt[e]);
                    return !0
                }, o = function() {
                    function t(t, e, n) {
                        return i._a ? i._a.removeEventListener(t, e, n || !1) : null
                    }
                    var e;
                    i._a._added_events = !1;
                    for (e in zt) zt.hasOwnProperty(e) && t(e, zt[e])
                }, this._onload = function(t) {
                    var e, n = !!t || !i.isHTML5 && 8 === b && i.duration;
                    return i.loaded = n, i.readyState = n ? 3 : 2, i._onbufferchange(0), i._iO.onload && Bt(i, function() {
                        i._iO.onload.apply(i, [n])
                    }), !0
                }, this._onbufferchange = function(t) {
                    return 0 === i.playState ? !1 : t && i.isBuffering || !t && !i.isBuffering ? !1 : (i.isBuffering = 1 === t, i._iO.onbufferchange && i._iO.onbufferchange.apply(i, [t]), !0)
                }, this._onsuspend = function() {
                    return i._iO.onsuspend && i._iO.onsuspend.apply(i), !0
                }, this._onfailure = function(t, e, n) {
                    i.failures++, i._iO.onfailure && 1 === i.failures && i._iO.onfailure(t, e, n)
                }, this._onwarning = function(t, e, n) {
                    i._iO.onwarning && i._iO.onwarning(t, e, n)
                }, this._onfinish = function() {
                    var t = i._iO.onfinish;
                    i._onbufferchange(0), i._resetOnPosition(0), i.instanceCount && (i.instanceCount--, i.instanceCount || (m(), i.playState = 0, i.paused = !1, i.instanceCount = 0, i.instanceOptions = {}, i._iO = {}, s(), i.isHTML5 && (i.position = 0)), i.instanceCount && !i._iO.multiShotEvents || t && Bt(i, function() {
                        t.apply(i)
                    }))
                }, this._whileloading = function(t, e, n, a) {
                    var o = i._iO;
                    i.bytesLoaded = t, i.bytesTotal = e, i.duration = Math.floor(n), i.bufferLength = a, i.isHTML5 || o.isMovieStar ? i.durationEstimate = i.duration : o.duration ? i.durationEstimate = i.duration > o.duration ? i.duration : o.duration : i.durationEstimate = parseInt(i.bytesTotal / i.bytesLoaded * i.duration, 10), i.isHTML5 || (i.buffered = [{
                        start: 0,
                        end: i.duration
                    }]), (3 !== i.readyState || i.isHTML5) && o.whileloading && o.whileloading.apply(i)
                }, this._whileplaying = function(t, n, a, o, s) {
                    var r = i._iO,
                        l;
                    return isNaN(t) || null === t ? !1 : (i.position = Math.max(0, t), i._processOnPosition(), !i.isHTML5 && b > 8 && (r.usePeakData && n !== e && n && (i.peakData = {
                        left: n.leftPeak,
                        right: n.rightPeak
                    }), r.useWaveformData && a !== e && a && (i.waveformData = {
                        left: a.split(","),
                        right: o.split(",")
                    }), r.useEQData && s !== e && s && s.leftEQ && (l = s.leftEQ.split(","), i.eqData = l, i.eqData.left = l, s.rightEQ !== e && s.rightEQ && (i.eqData.right = s.rightEQ.split(",")))), 1 === i.playState && (i.isHTML5 || 8 !== b || i.position || !i.isBuffering || i._onbufferchange(0), r.whileplaying && r.whileplaying.apply(i)), !0)
                }, this._oncaptiondata = function(t) {
                    i.captiondata = t, i._iO.oncaptiondata && i._iO.oncaptiondata.apply(i, [t])
                }, this._onmetadata = function(t, e) {
                    var n = {},
                        a, o;
                    for (a = 0, o = t.length; o > a; a++) n[t[a]] = e[a];
                    i.metadata = n, i._iO.onmetadata && i._iO.onmetadata.call(i, i.metadata)
                }, this._onid3 = function(t, e) {
                    var n = [],
                        a, o;
                    for (a = 0, o = t.length; o > a; a++) n[t[a]] = e[a];
                    i.id3 = E(i.id3, n), i._iO.onid3 && i._iO.onid3.apply(i)
                }, this._onconnect = function(t) {
                    t = 1 === t, i.connected = t, t && (i.failures = 0, mt(i.id) && (i.getAutoPlay() ? i.play(e, i.getAutoPlay()) : i._iO.autoLoad && i.load()), i._iO.onconnect && i._iO.onconnect.apply(i, [t]))
                }, this._ondataerror = function(t) {
                    i.playState > 0 && i._iO.ondataerror && i._iO.ondataerror.apply(i)
                }
            }, Y = function() {
                return g.body || g.getElementsByTagName("div")[0]
            }, f = function(t) {
                return g.getElementById(t)
            }, E = function(t, i) {
                var n = t || {},
                    a, o;
                a = i === e ? r.defaultOptions : i;
                for (o in a) a.hasOwnProperty(o) && n[o] === e && ("object" != typeof a[o] || null === a[o] ? n[o] = a[o] : n[o] = E(n[o], a[o]));
                return n
            }, Bt = function(e, i) {
                e.isHTML5 || 8 !== b ? i() : t.setTimeout(i, 0)
            }, A = {
                onready: 1,
                ontimeout: 1,
                defaultOptions: 1,
                flash9Options: 1,
                movieStarOptions: 1
            }, F = function(t, i) {
                var n, a = !0,
                    o = i !== e,
                    s = r.setupOptions,
                    l = A;
                for (n in t)
                    if (t.hasOwnProperty(n))
                        if ("object" != typeof t[n] || null === t[n] || t[n] instanceof Array || t[n] instanceof RegExp) o && l[i] !== e ? r[i][n] = t[n] : s[n] !== e ? (r.setupOptions[n] = t[n], r[n] = t[n]) : l[n] === e ? a = !1 : r[n] instanceof Function ? r[n].apply(r, t[n] instanceof Array ? t[n] : [t[n]]) : r[n] = t[n];
                        else {
                            if (l[n] !== e) return F(t[n], n);
                            a = !1
                        }
                return a
            }, At = function() {
                function e(t) {
                    var e = It.call(t),
                        i = e.length;
                    return o ? (e[1] = "on" + e[1], i > 3 && e.pop()) : 3 === i && e.push(!1), e
                }

                function i(t, e) {
                    var i = t.shift(),
                        n = [s[e]];
                    o ? i[n](t[0], t[1]) : i[n].apply(i, t)
                }

                function n() {
                    i(e(arguments), "add")
                }

                function a() {
                    i(e(arguments), "remove")
                }
                var o = t.attachEvent,
                    s = {
                        add: o ? "attachEvent" : "addEventListener",
                        remove: o ? "detachEvent" : "removeEventListener"
                    };
                return {
                    add: n,
                    remove: a
                }
            }(), zt = {
                abort: o(function() {}),
                canplay: o(function() {
                    var t = this._s,
                        i;
                    if (t._html5_canplay) return !0;
                    if (t._html5_canplay = !0, t._onbufferchange(0), i = t._iO.position === e || isNaN(t._iO.position) ? null : t._iO.position / Xt, this.currentTime !== i) try {
                        this.currentTime = i
                    } catch (n) {}
                    t._iO._oncanplay && t._iO._oncanplay()
                }),
                canplaythrough: o(function() {
                    var t = this._s;
                    t.loaded || (t._onbufferchange(0), t._whileloading(t.bytesLoaded, t.bytesTotal, t._get_html5_duration()), t._onload(!0))
                }),
                durationchange: o(function() {
                    var t = this._s,
                        e;
                    e = t._get_html5_duration(), isNaN(e) || e === t.duration || (t.durationEstimate = t.duration = e)
                }),
                ended: o(function() {
                    var t = this._s;
                    t._onfinish()
                }),
                error: o(function() {
                    this._s._onload(!1)
                }),
                loadeddata: o(function() {
                    var t = this._s;
                    t._loaded || Jt || (t.duration = t._get_html5_duration())
                }),
                loadedmetadata: o(function() {}),
                loadstart: o(function() {
                    this._s._onbufferchange(1)
                }),
                play: o(function() {
                    this._s._onbufferchange(0)
                }),
                playing: o(function() {
                    this._s._onbufferchange(0)
                }),
                progress: o(function(t) {
                    var e = this._s,
                        i, n, a, o = 0,
                        s = "progress" === t.type,
                        r = t.target.buffered,
                        l = t.loaded || 0,
                        u = t.total || 1;
                    if (e.buffered = [], r && r.length) {
                        for (i = 0, n = r.length; n > i; i++) e.buffered.push({
                            start: r.start(i) * Xt,
                            end: r.end(i) * Xt
                        });
                        o = (r.end(0) - r.start(0)) * Xt, l = Math.min(1, o / (t.target.duration * Xt))
                    }
                    isNaN(l) || (e._whileloading(l, u, e._get_html5_duration()), l && u && l === u && zt.canplaythrough.call(this, t))
                }),
                ratechange: o(function() {}),
                suspend: o(function(t) {
                    var e = this._s;
                    zt.progress.call(this, t), e._onsuspend()
                }),
                stalled: o(function() {}),
                timeupdate: o(function() {
                    this._s._onTimer()
                }),
                waiting: o(function() {
                    var t = this._s;
                    t._onbufferchange(1)
                })
            }, Pt = function(t) {
                var e;
                return e = t && (t.type || t.url || t.serverURL) ? t.serverURL || t.type && a(t.type) ? !1 : t.type ? Ot({
                    type: t.type
                }) : Ot({
                    url: t.url
                }) || r.html5Only || t.url.match(/data\:/i) : !1
            }, Lt = function(t) {
                var i;
                return t && (i = Jt ? re : r.html5.canPlayType("audio/wav") ? le : re, t.src = i, t._called_unload !== e && (t._called_load = !1)), qt && (jt = null), i
            }, Ot = function(t) {
                if (!r.useHTML5Audio || !r.hasHTML5) return !1;
                var i = t.url || null,
                    n = t.type || null,
                    o = r.audioFormats,
                    s, l, u, c;
                if (n && r.html5[n] !== e) return r.html5[n] && !a(n);
                if (!Dt) {
                    Dt = [];
                    for (c in o) o.hasOwnProperty(c) && (Dt.push(c), o[c].related && (Dt = Dt.concat(o[c].related)));
                    Dt = new RegExp("\\.(" + Dt.join("|") + ")(\\?.*)?$", "i")
                }
                return u = i ? i.toLowerCase().match(Dt) : null, u && u.length ? u = u[1] : n ? (l = n.indexOf(";"), u = (-1 !== l ? n.substr(0, l) : n).substr(6)) : s = !1, u && r.html5[u] !== e ? s = r.html5[u] && !a(u) : (n = "audio/" + u, s = "probably"), s
            }, Ft = function() {
                function t(t) {
                    var e, n, a = !1,
                        o = !1;
                    if (!i || "function" != typeof i.canPlayType) return a;
                    if (t instanceof Array) {
                        for (l = 0, n = t.length; n > l; l++)(r.html5[t[l]] || i.canPlayType(t[l]).match(r.html5Test)) && (o = !0, r.html5[t[l]] = !0, r.flash[t[l]] = !!t[l].match(se));
                        a = o
                    } else e = i && "function" == typeof i.canPlayType ? i.canPlayType(t) : !1, a = !(!e || !e.match(r.html5Test));
                    return a
                }
                if (!r.useHTML5Audio || !r.hasHTML5) return r.html5.usingFlash = !0, Tt = !0, !1;
                var i = Audio !== e ? Kt && opera.version() < 10 ? new Audio(null) : new Audio : null,
                    n, a, o = {},
                    s, l;
                s = r.audioFormats;
                for (n in s)
                    if (s.hasOwnProperty(n) && (a = "audio/" + n, o[n] = t(s[n].type), o[a] = o[n], n.match(se) ? (r.flash[n] = !0, r.flash[a] = !0) : (r.flash[n] = !1, r.flash[a] = !1), s[n] && s[n].related))
                        for (l = s[n].related.length - 1; l >= 0; l--) o["audio/" + s[n].related[l]] = o[n], r.html5[s[n].related[l]] = o[n], r.flash[s[n].related[l]] = o[n];
                return o.canPlayType = i ? t : null, r.html5 = E(r.html5, o), r.html5.usingFlash = Mt(), Tt = r.html5.usingFlash, !0
            }, B = {}, rt = function() {}, ht = function(t) {
                return 8 === b && t.loops > 1 && t.stream && (t.stream = !1), t
            }, ft = function(t, e) {
                return t && !t.usePolicyFile && (t.onid3 || t.usePeakData || t.useWaveformData || t.useEQData) && (t.usePolicyFile = !0), t
            }, pt = function(t) {}, v = function() {
                return !1
            }, it = function(t) {
                var e;
                for (e in t) t.hasOwnProperty(e) && "function" == typeof t[e] && (t[e] = v);
                e = null
            }, nt = function(t) {
                t === e && (t = !1), (M || t) && r.disable(t)
            }, at = function(t) {
                var e = null,
                    i;
                if (t)
                    if (t.match(/\.swf(\?.*)?$/i)) {
                        if (e = t.substr(t.toLowerCase().lastIndexOf(".swf?") + 4)) return t
                    } else t.lastIndexOf("/") !== t.length - 1 && (t += "/");
                return i = (t && -1 !== t.lastIndexOf("/") ? t.substr(0, t.lastIndexOf("/") + 1) : "./") + r.movieURL, r.noSWFCache && (i += "?ts=" + (new Date).getTime()), i
            }, H = function() {
                b = parseInt(r.flashVersion, 10), 8 !== b && 9 !== b && (r.flashVersion = b = et);
                var t = r.debugMode || r.debugFlash ? "_debug.swf" : ".swf";
                r.useHTML5Audio && !r.html5Only && r.audioFormats.mp4.required && 9 > b && (r.flashVersion = b = 9), r.version = r.versionNumber + (r.html5Only ? " (HTML5-only mode)" : 9 === b ? " (AS3/Flash 9)" : " (AS2/Flash 8)"), b > 8 ? (r.defaultOptions = E(r.defaultOptions, r.flash9Options), r.features.buffering = !0, r.defaultOptions = E(r.defaultOptions, r.movieStarOptions), r.filePatterns.flash9 = new RegExp("\\.(mp3|" + he.join("|") + ")(\\?.*)?$", "i"), r.features.movieStar = !0) : r.features.movieStar = !1, r.filePattern = r.filePatterns[8 !== b ? "flash9" : "flash8"], r.movieURL = (8 === b ? "soundmanager2.swf" : "soundmanager2_flash9.swf").replace(".swf", t), r.features.peakData = r.features.waveformData = r.features.eqData = b > 8
            }, J = function(t, e) {
                return u ? void u._setPolling(t, e) : !1
            }, K = function() {}, mt = this.getSoundById, ut = function() {
                var t = [];
                return r.debugMode && t.push(ct.sm2Debug), r.debugFlash && t.push(ct.flashDebug), r.useHighPerformance && t.push(ct.highPerf), t.join(" ")
            }, lt = function() {
                var t = rt("fbHandler"),
                    e = r.getMoviePercent(),
                    i = ct,
                    n = {
                        type: "FLASHBLOCK"
                    };
                return r.html5Only ? !1 : void(r.ok() ? r.oMC && (r.oMC.className = [ut(), i.swfDefault, i.swfLoaded + (r.didFlashBlock ? " " + i.swfUnblocked : "")].join(" ")) : (Tt && (r.oMC.className = ut() + " " + i.swfDefault + " " + (null === e ? i.swfTimedout : i.swfError)), r.didFlashBlock = !0, q({
                    type: "ontimeout",
                    ignoreInit: !0,
                    error: n
                }), Z(n)))
            }, I = function(t, i, n) {
                _[t] === e && (_[t] = []), _[t].push({
                    method: i,
                    scope: n || null,
                    fired: !1
                })
            }, q = function(t) {
                if (t || (t = {
                        type: r.ok() ? "onready" : "ontimeout"
                    }), !T && t && !t.ignoreInit) return !1;
                if ("ontimeout" === t.type && (r.ok() || M && !t.ignoreInit)) return !1;
                var e = {
                        success: t && t.ignoreInit ? r.ok() : !M
                    },
                    i = t && t.type ? _[t.type] || [] : [],
                    n = [],
                    a, o, s = [e],
                    l = Tt && !r.ok();
                for (t.error && (s[0].error = t.error), a = 0, o = i.length; o > a; a++) i[a].fired !== !0 && n.push(i[a]);
                if (n.length)
                    for (a = 0, o = n.length; o > a; a++) n[a].scope ? n[a].method.apply(n[a].scope, s) : n[a].method.apply(this, s), l || (n[a].fired = !0);
                return !0
            }, j = function() {
                t.setTimeout(function() {
                    r.useFlashBlock && lt(), q(), "function" == typeof r.onload && r.onload.apply(t), r.waitForWindowLoad && At.add(t, "load", j)
                }, 1)
            }, Vt = function() {
                if (Nt !== e) return Nt;
                var i = !1,
                    n = navigator,
                    a = n.plugins,
                    o, s, r, l = t.ActiveXObject;
                if (a && a.length) s = "application/x-shockwave-flash", r = n.mimeTypes, r && r[s] && r[s].enabledPlugin && r[s].enabledPlugin.description && (i = !0);
                else if (l !== e && !p.match(/MSAppHost/i)) {
                    try {
                        o = new l("ShockwaveFlash.ShockwaveFlash")
                    } catch (u) {
                        o = null
                    }
                    i = !!o, o = null
                }
                return Nt = i, i
            }, Mt = function() {
                var t, e, i = r.audioFormats,
                    n = Ut && !!p.match(/os (1|2|3_0|3_1)\s/i);
                if (n ? (r.hasHTML5 = !1, r.html5Only = !0, r.oMC && (r.oMC.style.display = "none")) : r.useHTML5Audio && (r.html5 && r.html5.canPlayType || (r.hasHTML5 = !1)), r.useHTML5Audio && r.hasHTML5) {
                    kt = !0;
                    for (e in i) i.hasOwnProperty(e) && i[e].required && (r.html5.canPlayType(i[e].type) ? r.preferFlash && (r.flash[e] || r.flash[i[e].type]) && (t = !0) : (kt = !1, t = !0))
                }
                return r.ignoreFlash && (t = !1, kt = !0), r.html5Only = r.hasHTML5 && r.useHTML5Audio && !t, !r.html5Only
            }, xt = function(t) {
                var e, i, n = 0,
                    a;
                if (t instanceof Array) {
                    for (e = 0, i = t.length; i > e; e++)
                        if (t[e] instanceof Object) {
                            if (r.canPlayMIME(t[e].type)) {
                                n = e;
                                break
                            }
                        } else if (r.canPlayURL(t[e])) {
                        n = e;
                        break
                    }
                    t[n].url && (t[n] = t[n].url), a = t[n]
                } else a = t;
                return a
            }, yt = function(t) {
                t._hasTimer || (t._hasTimer = !0, !te && r.html5PollingInterval && (null === Ct && 0 === _t && (Ct = setInterval(bt, r.html5PollingInterval)), _t++))
            }, wt = function(t) {
                t._hasTimer && (t._hasTimer = !1, !te && r.html5PollingInterval && _t--)
            }, bt = function() {
                var t;
                if (null !== Ct && !_t) return clearInterval(Ct), Ct = null, !1;
                for (t = r.soundIDs.length - 1; t >= 0; t--) r.sounds[r.soundIDs[t]].isHTML5 && r.sounds[r.soundIDs[t]]._hasTimer && r.sounds[r.soundIDs[t]]._onTimer()
            }, Z = function(i) {
                i = i !== e ? i : {}, "function" == typeof r.onerror && r.onerror.apply(t, [{
                    type: i.type !== e ? i.type : null
                }]), i.fatal !== e && i.fatal && r.disable()
            }, $t = function() {
                if (!ee || !Vt()) return !1;
                var t = r.audioFormats,
                    e, i;
                for (i in t)
                    if (t.hasOwnProperty(i) && ("mp3" === i || "mp4" === i) && (r.html5[i] = !1, t[i] && t[i].related))
                        for (e = t[i].related.length - 1; e >= 0; e--) r.html5[t[i].related[e]] = !1
            }, this._setSandboxType = function(t) {}, this._externalInterfaceOK = function(t) {
                if (r.swfLoaded) return !1;
                var e;
                r.swfLoaded = !0, ae = !1, ee && $t(), setTimeout(w, Gt ? 100 : 1)
            }, G = function(t, i) {
                function n() {}

                function a(t, e) {
                    return '<param name="' + t + '" value="' + e + '" />'
                }
                if (S && k) return !1;
                if (r.html5Only) return H(), n(), r.oMC = f(r.movieID), w(), S = !0, k = !0, !1;
                var o = i || r.url,
                    s = r.altURL || o,
                    l = "JS/Flash audio component (SoundManager 2)",
                    u = Y(),
                    c = ut(),
                    d = null,
                    h = g.getElementsByTagName("html")[0],
                    m, v, y, b, _, C, x, T;
                if (d = h && h.dir && h.dir.match(/rtl/i), t = t === e ? r.id : t, H(), r.url = at(ue ? o : s), i = r.url, r.wmode = !r.wmode && r.useHighPerformance ? "transparent" : r.wmode, null !== r.wmode && (p.match(/msie 8/i) || !Gt && !r.useHighPerformance) && navigator.platform.match(/win32|win64/i) && (St.push(B.spcWmode),
                        r.wmode = null), m = {
                        name: t,
                        id: t,
                        src: i,
                        quality: "high",
                        allowScriptAccess: r.allowScriptAccess,
                        bgcolor: r.bgColor,
                        pluginspage: ce + "www.macromedia.com/go/getflashplayer",
                        title: l,
                        type: "application/x-shockwave-flash",
                        wmode: r.wmode,
                        hasPriority: "true"
                    }, r.debugFlash && (m.FlashVars = "debug=1"), r.wmode || delete m.wmode, Gt) v = g.createElement("div"), b = ['<object id="' + t + '" data="' + i + '" type="' + m.type + '" title="' + m.title + '" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0">', a("movie", i), a("AllowScriptAccess", r.allowScriptAccess), a("quality", m.quality), r.wmode ? a("wmode", r.wmode) : "", a("bgcolor", r.bgColor), a("hasPriority", "true"), r.debugFlash ? a("FlashVars", m.FlashVars) : "", "</object>"].join("");
                else {
                    v = g.createElement("embed");
                    for (y in m) m.hasOwnProperty(y) && v.setAttribute(y, m[y])
                }
                if (K(), c = ut(), u = Y())
                    if (r.oMC = f(r.movieID) || g.createElement("div"), r.oMC.id) T = r.oMC.className, r.oMC.className = (T ? T + " " : ct.swfDefault) + (c ? " " + c : ""), r.oMC.appendChild(v), Gt && (_ = r.oMC.appendChild(g.createElement("div")), _.className = ct.swfBox, _.innerHTML = b), k = !0;
                    else {
                        if (r.oMC.id = r.movieID, r.oMC.className = ct.swfDefault + " " + c, C = null, _ = null, r.useFlashBlock || (r.useHighPerformance ? C = {
                                position: "fixed",
                                width: "8px",
                                height: "8px",
                                bottom: "0px",
                                left: "0px",
                                overflow: "hidden"
                            } : (C = {
                                position: "absolute",
                                width: "6px",
                                height: "6px",
                                top: "-9999px",
                                left: "-9999px"
                            }, d && (C.left = Math.abs(parseInt(C.left, 10)) + "px"))), Zt && (r.oMC.style.zIndex = 1e4), !r.debugFlash)
                            for (x in C) C.hasOwnProperty(x) && (r.oMC.style[x] = C[x]);
                        try {
                            Gt || r.oMC.appendChild(v), u.appendChild(r.oMC), Gt && (_ = r.oMC.appendChild(g.createElement("div")), _.className = ct.swfBox, _.innerHTML = b), k = !0
                        } catch (M) {
                            throw new Error(rt("domError") + " \n" + M.toString())
                        }
                    }
                return S = !0, n(), !0
            }, Q = function() {
                return r.html5Only ? (G(), !1) : u ? !1 : r.url ? (u = r.getMovie(r.id), u || (ot ? (Gt ? r.oMC.innerHTML = st : r.oMC.appendChild(ot), ot = null, S = !0) : G(r.id, r.url), u = r.getMovie(r.id)), "function" == typeof r.oninitmovie && setTimeout(r.oninitmovie, 1), !0) : !1
            }, N = function() {
                setTimeout(V, 1e3)
            }, z = function() {
                t.setTimeout(function() {
                    r.setup({
                        preferFlash: !1
                    }).reboot(), r.didFlashBlock = !0, r.beginDelayedInit()
                }, 1)
            }, V = function() {
                var e, i = !1;
                return r.url ? gt ? !1 : (gt = !0, At.remove(t, "load", N), Nt && ae && !ne ? !1 : (T || (e = r.getMoviePercent(), e > 0 && 100 > e && (i = !0)), void setTimeout(function() {
                    return e = r.getMoviePercent(), i ? (gt = !1, t.setTimeout(N, 1), !1) : void(!T && oe && (null === e ? r.useFlashBlock || 0 === r.flashLoadTimeout ? r.useFlashBlock && lt() : !r.useFlashBlock && kt ? z() : q({
                        type: "ontimeout",
                        ignoreInit: !0,
                        error: {
                            type: "INIT_FLASHBLOCK"
                        }
                    }) : 0 === r.flashLoadTimeout || (!r.useFlashBlock && kt ? z() : nt(!0))))
                }, r.flashLoadTimeout))) : !1
            }, R = function() {
                function e() {
                    At.remove(t, "focus", R)
                }
                return ne || !ae ? (e(), !0) : (oe = !0, ne = !0, gt = !1, N(), e(), !0)
            }, Rt = function() {}, Ht = function() {}, L = function(e) {
                if (T) return !1;
                if (r.html5Only) return T = !0, j(), !0;
                var i = r.useFlashBlock && r.flashLoadTimeout && !r.getMoviePercent(),
                    n = !0,
                    a;
                return i || (T = !0), a = {
                    type: !Nt && Tt ? "NO_FLASH" : "INIT_TIMEOUT"
                }, (M || e) && (r.useFlashBlock && r.oMC && (r.oMC.className = ut() + " " + (null === r.getMoviePercent() ? ct.swfTimedout : ct.swfError)), q({
                    type: "ontimeout",
                    error: a,
                    ignoreInit: !0
                }), Z(a), n = !1), M || (r.waitForWindowLoad && !P ? At.add(t, "load", j) : j()), n
            }, y = function() {
                var t, i = r.setupOptions;
                for (t in i) i.hasOwnProperty(t) && (r[t] === e ? r[t] = i[t] : r[t] !== i[t] && (r.setupOptions[t] = r[t]))
            }, w = function() {
                function e() {
                    At.remove(t, "load", r.beginDelayedInit)
                }
                if (T) return !1;
                if (r.html5Only) return T || (e(), r.enabled = !0, L()), !0;
                Q();
                try {
                    u._externalInterfaceTest(!1), J(!0, r.flashPollingInterval || (r.useHighPerformance ? 10 : 50)), r.debugMode || u._disableDebug(), r.enabled = !0, r.html5Only || At.add(t, "unload", v)
                } catch (i) {
                    return Z({
                        type: "JS_TO_FLASH_EXCEPTION",
                        fatal: !0
                    }), nt(!0), L(), !1
                }
                return L(), e(), !0
            }, W = function() {
                return U ? !1 : (U = !0, y(), K(), !Nt && r.hasHTML5 && r.setup({
                    useHTML5Audio: !0,
                    preferFlash: !1
                }), Ft(), !Nt && Tt && (St.push(B.needFlash), r.setup({
                    flashLoadTimeout: 1
                })), g.removeEventListener && g.removeEventListener("DOMContentLoaded", W, !1), Q(), !0)
            }, Et = function() {
                return "complete" === g.readyState && (W(), g.detachEvent("onreadystatechange", Et)), !0
            }, X = function() {
                P = !0, W(), At.remove(t, "load", X)
            }, Vt(), At.add(t, "focus", R), At.add(t, "load", N), At.add(t, "load", X), g.addEventListener ? g.addEventListener("DOMContentLoaded", W, !1) : g.attachEvent ? g.attachEvent("onreadystatechange", Et) : Z({
                type: "NO_DOM2_EVENTS",
                fatal: !0
            })
        }
        if (!t || !t.document) throw new Error("SoundManager requires a browser with window and document objects.");
        var n = null;
        t.SM2_DEFER !== e && SM2_DEFER || (n = new i), "object" == typeof module && module && "object" == typeof module.exports ? (module.exports.SoundManager = i, module.exports.soundManager = n) : "function" == typeof define && define.amd && define(function() {
            function e(e) {
                if (!t.soundManager && e instanceof Function) {
                    var n = e(i);
                    n instanceof i && (t.soundManager = n)
                }
                return t.soundManager
            }
            return {
                constructor: i,
                getInstance: e
            }
        }), t.SoundManager = i, t.soundManager = n
    }(window);
var threeSixtyPlayer, ThreeSixtyPlayer;
if (function(t) {
        function e() {
            var e = this,
                i = this,
                n = soundManager,
                a = navigator.userAgent,
                o = a.match(/msie/i),
                s = a.match(/opera/i),
                r = a.match(/safari/i),
                l = a.match(/chrome/i),
                u = a.match(/firefox/i),
                c = a.match(/ipad|iphone/i),
                d = "undefined" == typeof t.G_vmlCanvasManager && "undefined" != typeof document.createElement("canvas").getContext("2d"),
                h = s || l ? 359.9 : 360,
                f = navigator.userAgent.match(/msie [678]/i) ? 1 : 2;
            this.excludeClass = "threesixty-exclude", this.links = [], this.sounds = [], this.soundsByURL = [], this.indexByURL = [], this.lastSound = null, this.lastTouchedSound = null, this.soundCount = 0, this.oUITemplate = null, this.oUIImageMap = null, this.vuMeter = null, this.callbackCount = 0, this.peakDataHistory = [], this.config = {
                playNext: !1,
                autoPlay: !1,
                allowMultiple: !1,
                loadRingColor: "#ccc",
                playRingColor: "#000",
                backgroundRingColor: "#eee",
                segmentRingColor: "rgba(255,255,255,0.33)",
                segmentRingColorAlt: "rgba(0,0,0,0.1)",
                loadRingColorMetadata: "#ddd",
                playRingColorMetadata: "rgba(128,192,256,0.9)",
                circleDiameter: null,
                circleRadius: null,
                animDuration: 500,
                animTransition: t.Animator.tx.bouncy,
                showHMSTime: !1,
                scaleFont: !0,
                useWaveformData: !1,
                waveformDataColor: "#0099ff",
                waveformDataDownsample: 3,
                waveformDataOutside: !1,
                waveformDataConstrain: !1,
                waveformDataLineRatio: .64,
                useEQData: !1,
                eqDataColor: "#339933",
                eqDataDownsample: 4,
                eqDataOutside: !0,
                eqDataLineRatio: .54,
                usePeakData: !0,
                peakDataColor: "#ff33ff",
                peakDataOutside: !0,
                peakDataLineRatio: .5,
                useAmplifier: !0,
                fontSizeMax: null,
                scaleArcWidth: 1,
                useFavIcon: !1
            }, this.css = {
                sDefault: "sm2_link",
                sBuffering: "sm2_buffering",
                sPlaying: "sm2_playing",
                sPaused: "sm2_paused"
            }, this.addEventHandler = "undefined" != typeof t.addEventListener ? function(t, e, i) {
                return t.addEventListener(e, i, !1)
            } : function(t, e, i) {
                t.attachEvent("on" + e, i)
            }, this.removeEventHandler = "undefined" != typeof t.removeEventListener ? function(t, e, i) {
                return t.removeEventListener(e, i, !1)
            } : function(t, e, i) {
                return t.detachEvent("on" + e, i)
            }, this.hasClass = function(t, e) {
                return "undefined" != typeof t.className ? t.className.match(new RegExp("(\\s|^)" + e + "(\\s|$)")) : !1
            }, this.addClass = function(t, i) {
                return t && i && !e.hasClass(t, i) ? void(t.className = (t.className ? t.className + " " : "") + i) : !1
            }, this.removeClass = function(t, i) {
                return t && i && e.hasClass(t, i) ? void(t.className = t.className.replace(new RegExp("( " + i + ")|(" + i + ")", "g"), "")) : !1
            }, this.getElementsByClassName = function(t, i, n) {
                var a = n || document,
                    o = [],
                    s, r, l = [];
                if ("undefined" != typeof i && "string" != typeof i)
                    for (s = i.length; s--;) l && l[i[s]] || (l[i[s]] = a.getElementsByTagName(i[s]));
                else l = i ? a.getElementsByTagName(i) : a.all || a.getElementsByTagName("*");
                if ("string" != typeof i)
                    for (s = i.length; s--;)
                        for (r = l[i[s]].length; r--;) e.hasClass(l[i[s]][r], t) && o.push(l[i[s]][r]);
                else
                    for (s = 0; s < l.length; s++) e.hasClass(l[s], t) && o.push(l[s]);
                return o
            }, this.getParentByNodeName = function(t, e) {
                if (!t || !e) return !1;
                for (e = e.toLowerCase(); t.parentNode && e !== t.parentNode.nodeName.toLowerCase();) t = t.parentNode;
                return t.parentNode && e === t.parentNode.nodeName.toLowerCase() ? t.parentNode : null
            }, this.getParentByClassName = function(t, i) {
                if (!t || !i) return !1;
                for (; t.parentNode && !e.hasClass(t.parentNode, i);) t = t.parentNode;
                return t.parentNode && e.hasClass(t.parentNode, i) ? t.parentNode : null
            }, this.getSoundByURL = function(t) {
                return "undefined" != typeof e.soundsByURL[t] ? e.soundsByURL[t] : null
            }, this.isChildOfNode = function(t, e) {
                if (!t || !t.parentNode) return !1;
                e = e.toLowerCase();
                do t = t.parentNode; while (t && t.parentNode && t.nodeName.toLowerCase() !== e);
                return t && t.nodeName.toLowerCase() === e ? t : null
            }, this.isChildOfClass = function(t, i) {
                if (!t || !i) return !1;
                for (; t.parentNode && !e.hasClass(t, i);) t = e.findParent(t);
                return e.hasClass(t, i)
            }, this.findParent = function(t) {
                if (!t || !t.parentNode) return !1;
                if (t = t.parentNode, 2 === t.nodeType)
                    for (; t && t.parentNode && 2 === t.parentNode.nodeType;) t = t.parentNode;
                return t
            }, this.getStyle = function(e, i) {
                try {
                    if (e.currentStyle) return e.currentStyle[i];
                    if (t.getComputedStyle) return document.defaultView.getComputedStyle(e, null).getPropertyValue(i)
                } catch (n) {}
                return null
            }, this.findXY = function(t) {
                var e = 0,
                    i = 0;
                do e += t.offsetLeft, i += t.offsetTop; while (t = t.offsetParent);
                return [e, i]
            }, this.getMouseXY = function(i) {
                return i = i ? i : t.event, c && i.touches && (i = i.touches[0]), i.pageX || i.pageY ? [i.pageX, i.pageY] : i.clientX || i.clientY ? [i.clientX + e.getScrollLeft(), i.clientY + e.getScrollTop()] : void 0
            }, this.getScrollLeft = function() {
                return document.body.scrollLeft + document.documentElement.scrollLeft
            }, this.getScrollTop = function() {
                return document.body.scrollTop + document.documentElement.scrollTop
            }, this.events = {
                play: function() {
                    i.removeClass(this._360data.oUIBox, this._360data.className), this._360data.className = i.css.sPlaying, i.addClass(this._360data.oUIBox, this._360data.className), e.fanOut(this)
                },
                stop: function() {
                    i.removeClass(this._360data.oUIBox, this._360data.className), this._360data.className = "", e.fanIn(this)
                },
                pause: function() {
                    i.removeClass(this._360data.oUIBox, this._360data.className), this._360data.className = i.css.sPaused, i.addClass(this._360data.oUIBox, this._360data.className)
                },
                resume: function() {
                    i.removeClass(this._360data.oUIBox, this._360data.className), this._360data.className = i.css.sPlaying, i.addClass(this._360data.oUIBox, this._360data.className)
                },
                finish: function() {
                    var t;
                    i.removeClass(this._360data.oUIBox, this._360data.className), this._360data.className = "", this._360data.didFinish = !0, e.fanIn(this), i.config.playNext && (t = i.indexByURL[this._360data.oLink.href] + 1, t < i.links.length && i.handleClick({
                        target: i.links[t]
                    }))
                },
                whileloading: function() {
                    this.paused && e.updatePlaying.apply(this)
                },
                whileplaying: function() {
                    e.updatePlaying.apply(this), this._360data.fps++
                },
                bufferchange: function() {
                    this.isBuffering ? i.addClass(this._360data.oUIBox, i.css.sBuffering) : i.removeClass(this._360data.oUIBox, i.css.sBuffering)
                }
            }, this.stopEvent = function(e) {
                return "undefined" != typeof e && "undefined" != typeof e.preventDefault ? e.preventDefault() : "undefined" != typeof t.event && "undefined" != typeof t.event.returnValue && (t.event.returnValue = !1), !1
            }, this.getTheDamnLink = o ? function(e) {
                return e && e.target ? e.target : t.event.srcElement
            } : function(t) {
                return t.target
            }, this.handleClick = function(i) {
                if (i.button > 1) return !0;
                var a = e.getTheDamnLink(i),
                    o, s, r, l, u, c, d;
                return ("a" === a.nodeName.toLowerCase() || (a = e.isChildOfNode(a, "a"))) && e.isChildOfClass(a, "ui360") ? (s = a.getAttribute("href"), a.href && n.canPlayLink(a) && !e.hasClass(a, e.excludeClass) ? (n._writeDebug("handleClick()"), r = a.href, l = e.getSoundByURL(r), l ? l === e.lastSound ? l.togglePause() : (l.togglePause(), n._writeDebug("sound different than last sound: " + e.lastSound.id), !e.config.allowMultiple && e.lastSound && e.stopSound(e.lastSound)) : (u = a.parentNode, c = e.getElementsByClassName("ui360-vis", "div", u.parentNode).length, l = n.createSound({
                    id: "ui360Sound" + e.soundCount++,
                    url: r,
                    onplay: e.events.play,
                    onstop: e.events.stop,
                    onpause: e.events.pause,
                    onresume: e.events.resume,
                    onfinish: e.events.finish,
                    onbufferchange: e.events.bufferchange,
                    type: a.type || null,
                    whileloading: e.events.whileloading,
                    whileplaying: e.events.whileplaying,
                    useWaveformData: c && e.config.useWaveformData,
                    useEQData: c && e.config.useEQData,
                    usePeakData: c && e.config.usePeakData
                }), d = parseInt(e.getElementsByClassName("sm2-360ui", "div", u)[0].offsetWidth * f, 10), o = e.getElementsByClassName("sm2-canvas", "canvas", u), l._360data = {
                    oUI360: e.getParentByClassName(a, "ui360"),
                    oLink: a,
                    className: e.css.sPlaying,
                    oUIBox: e.getElementsByClassName("sm2-360ui", "div", u)[0],
                    oCanvas: o[o.length - 1],
                    oButton: e.getElementsByClassName("sm2-360btn", "span", u)[0],
                    oTiming: e.getElementsByClassName("sm2-timing", "div", u)[0],
                    oCover: e.getElementsByClassName("sm2-cover", "div", u)[0],
                    circleDiameter: d,
                    circleRadius: d / 2,
                    lastTime: null,
                    didFinish: null,
                    pauseCount: 0,
                    radius: 0,
                    fontSize: 1,
                    fontSizeMax: e.config.fontSizeMax,
                    scaleFont: c && e.config.scaleFont,
                    showHMSTime: c,
                    amplifier: c && e.config.usePeakData ? .9 : 1,
                    radiusMax: .175 * d,
                    width: 0,
                    widthMax: .4 * d,
                    lastValues: {
                        bytesLoaded: 0,
                        bytesTotal: 0,
                        position: 0,
                        durationEstimate: 0
                    },
                    animating: !1,
                    oAnim: new t.Animator({
                        duration: e.config.animDuration,
                        transition: e.config.animTransition,
                        onComplete: function() {}
                    }),
                    oAnimProgress: function(t) {
                        var i = this;
                        i._360data.radius = parseInt(i._360data.radiusMax * i._360data.amplifier * t, 10), i._360data.width = parseInt(i._360data.widthMax * i._360data.amplifier * t, 10), i._360data.scaleFont && null !== i._360data.fontSizeMax && (i._360data.oTiming.style.fontSize = parseInt(Math.max(1, i._360data.fontSizeMax * t), 10) + "px", i._360data.oTiming.style.opacity = t), (i.paused || 0 === i.playState || 0 === i._360data.lastValues.bytesLoaded || 0 === i._360data.lastValues.position) && e.updatePlaying.apply(i)
                    },
                    fps: 0
                }, "undefined" != typeof e.Metadata && e.getElementsByClassName("metadata", "div", l._360data.oUI360).length && (l._360data.metadata = new e.Metadata(l, e)), l._360data.scaleFont && null !== l._360data.fontSizeMax && (l._360data.oTiming.style.fontSize = "1px"), l._360data.oAnim.addSubject(l._360data.oAnimProgress, l), e.refreshCoords(l), e.updatePlaying.apply(l), e.soundsByURL[r] = l, e.sounds.push(l), !e.config.allowMultiple && e.lastSound && e.stopSound(e.lastSound), l.play()), e.lastSound = l, "undefined" != typeof i && "undefined" != typeof i.preventDefault ? i.preventDefault() : "undefined" != typeof t.event && (t.event.returnValue = !1), !1) : !0) : !0
            }, this.fanOut = function(i) {
                var n = i;
                return 1 === n._360data.animating ? !1 : (n._360data.animating = 0, soundManager._writeDebug("fanOut: " + n.id + ": " + n._360data.oLink.href), n._360data.oAnim.seekTo(1), void t.setTimeout(function() {
                    n._360data.animating = 0
                }, e.config.animDuration + 20))
            }, this.fanIn = function(i) {
                var n = i;
                return -1 === n._360data.animating ? !1 : (n._360data.animating = -1, soundManager._writeDebug("fanIn: " + n.id + ": " + n._360data.oLink.href), n._360data.oAnim.seekTo(0), void t.setTimeout(function() {
                    n._360data.didFinish = !1, n._360data.animating = 0, e.resetLastValues(n)
                }, e.config.animDuration + 20))
            }, this.resetLastValues = function(t) {
                t._360data.lastValues.position = 0
            }, this.refreshCoords = function(t) {
                t._360data.canvasXY = e.findXY(t._360data.oCanvas), t._360data.canvasMid = [t._360data.circleRadius, t._360data.circleRadius], t._360data.canvasMidXY = [t._360data.canvasXY[0] + t._360data.canvasMid[0], t._360data.canvasXY[1] + t._360data.canvasMid[1]]
            }, this.stopSound = function(t) {
                soundManager._writeDebug("stopSound: " + t.id), soundManager.stop(t.id), c || soundManager.unload(t.id)
            }, this.buttonClick = function(i) {
                var n = i ? i.target ? i.target : i.srcElement : t.event.srcElement;
                return e.handleClick({
                    target: e.getParentByClassName(n, "sm2-360ui").nextSibling
                }), !1
            }, this.buttonMouseDown = function(t) {
                return c ? e.addEventHandler(document, "touchmove", e.mouseDown) : document.onmousemove = function(t) {
                    e.mouseDown(t)
                }, e.stopEvent(t), !1
            }, this.mouseDown = function(i) {
                if (!c && i.button > 1) return !0;
                if (!e.lastSound) return e.stopEvent(i), !1;
                var n = i ? i : t.event,
                    a, o, s;
                return c && n.touches && (n = n.touches[0]), a = n.target || n.srcElement, o = e.getSoundByURL(e.getElementsByClassName("sm2_link", "a", e.getParentByClassName(a, "ui360"))[0].href), e.lastTouchedSound = o, e.refreshCoords(o), s = o._360data, e.addClass(s.oUIBox, "sm2_dragging"), s.pauseCount = e.lastTouchedSound.paused ? 1 : 0, e.mmh(i ? i : t.event), c ? (e.removeEventHandler(document, "touchmove", e.mouseDown), e.addEventHandler(document, "touchmove", e.mmh), e.addEventHandler(document, "touchend", e.mouseUp)) : (document.onmousemove = e.mmh, document.onmouseup = e.mouseUp), e.stopEvent(i), !1
            }, this.mouseUp = function(t) {
                var i = e.lastTouchedSound._360data;
                e.removeClass(i.oUIBox, "sm2_dragging"), 0 === i.pauseCount && e.lastTouchedSound.resume(), c ? (e.removeEventHandler(document, "touchmove", e.mmh), e.removeEventHandler(document, "touchend", e.mouseUP)) : (document.onmousemove = null, document.onmouseup = null)
            }, this.mmh = function(i) {
                "undefined" == typeof i && (i = t.event);
                var n = e.lastTouchedSound,
                    a = e.getMouseXY(i),
                    o = a[0],
                    s = a[1],
                    r = o - n._360data.canvasMidXY[0],
                    l = s - n._360data.canvasMidXY[1],
                    u = Math.floor(h - (e.rad2deg(Math.atan2(r, l)) + 180));
                return n.setPosition(n.durationEstimate * (u / h)), e.stopEvent(i), !1
            }, this.drawSolidArc = function(t, i, n, a, o, l, u) {
                var c = n,
                    d = n,
                    h = t,
                    f, p, m, g;
                h.getContext && (f = h.getContext("2d")), t = f, u || e.clearCanvas(h), i && (f.fillStyle = i), t.beginPath(), isNaN(o) && (o = 0), p = n - a, m = s || r, (!m || m && n > 0) && (t.arc(0, 0, n, l, o, !1), g = e.getArcEndpointCoords(p, o), t.lineTo(g.x, g.y), t.arc(0, 0, p, o, l, !0), t.closePath(), t.fill())
            }, this.getArcEndpointCoords = function(t, e) {
                return {
                    x: t * Math.cos(e),
                    y: t * Math.sin(e)
                }
            }, this.deg2rad = function(t) {
                return t * Math.PI / 180
            }, this.rad2deg = function(t) {
                return 180 * t / Math.PI
            }, this.getTime = function(t, e) {
                var i = Math.floor(t / 1e3),
                    n = Math.floor(i / 60),
                    a = i - 60 * n;
                return e ? n + ":" + (10 > a ? "0" + a : a) : {
                    min: n,
                    sec: a
                }
            }, this.clearCanvas = function(t) {
                var e = t,
                    i = null,
                    n, a;
                e.getContext && (i = e.getContext("2d")), i && (n = e.offsetWidth, a = e.offsetHeight, i.clearRect(-(n / 2), -(a / 2), n, a))
            }, this.updatePlaying = function() {
                var t = this._360data.showHMSTime ? e.getTime(this.position, !0) : parseInt(this.position / 1e3, 10),
                    i = e.config.scaleArcWidth;
                this.bytesLoaded && (this._360data.lastValues.bytesLoaded = this.bytesLoaded, this._360data.lastValues.bytesTotal = this.bytesTotal), this.position && (this._360data.lastValues.position = this.position), this.durationEstimate && (this._360data.lastValues.durationEstimate = this.durationEstimate), e.drawSolidArc(this._360data.oCanvas, e.config.backgroundRingColor, this._360data.width, this._360data.radius * i, e.deg2rad(h), !1), e.drawSolidArc(this._360data.oCanvas, this._360data.metadata ? e.config.loadRingColorMetadata : e.config.loadRingColor, this._360data.width, this._360data.radius * i, e.deg2rad(h * (this._360data.lastValues.bytesLoaded / this._360data.lastValues.bytesTotal)), 0, !0), 0 !== this._360data.lastValues.position && e.drawSolidArc(this._360data.oCanvas, this._360data.metadata ? e.config.playRingColorMetadata : e.config.playRingColor, this._360data.width, this._360data.radius * i, e.deg2rad(1 === this._360data.didFinish ? h : h * (this._360data.lastValues.position / this._360data.lastValues.durationEstimate)), 0, !0), this._360data.metadata && this._360data.metadata.events.whileplaying(), t !== this._360data.lastTime && (this._360data.lastTime = t, this._360data.oTiming.innerHTML = t), (this.instanceOptions.useWaveformData || this.instanceOptions.useEQData) && d && e.updateWaveform(this), e.config.useFavIcon && e.vuMeter && e.vuMeter.updateVU(this)
            }, this.updateWaveform = function(t) {
                if (!e.config.useWaveformData && !e.config.useEQData || !n.features.waveformData && !n.features.eqData) return !1;
                if (!t.waveformData.left.length && !t.eqData.length && !t.peakData.left) return !1;
                var i = t._360data.oCanvas.getContext("2d"),
                    a = 0,
                    o = parseInt(t._360data.circleDiameter / 2, 10),
                    s = o / 2,
                    r = 1,
                    l = 1,
                    u = 0,
                    c = o,
                    d, h, f, p, m, g, v, y, w, b, _, C, x, S, k, T;
                if (e.config.useWaveformData)
                    for (p = e.config.waveformDataDownsample, p = Math.max(1, p), m = 256, g = m / p, v = 0, y = 0, w = null, b = e.config.waveformDataOutside ? 1 : e.config.waveformDataConstrain ? .5 : .565, s = e.config.waveformDataOutside ? .7 : .75, _ = e.deg2rad(360 / g * e.config.waveformDataLineRatio), d = 0; m > d; d += p) v = e.deg2rad(360 * (d / g * 1 / p)), y = v + _, w = t.waveformData.left[d], 0 > w && e.config.waveformDataConstrain && (w = Math.abs(w)), e.drawSolidArc(t._360data.oCanvas, e.config.waveformDataColor, t._360data.width * b * (2 - e.config.scaleArcWidth), t._360data.radius * s * 1.25 * w, y, v, !0);
                if (e.config.useEQData)
                    for (p = e.config.eqDataDownsample, C = 0, p = Math.max(1, p), x = 192, g = x / p, b = e.config.eqDataOutside ? 1 : .565, f = e.config.eqDataOutside ? -1 : 1, s = e.config.eqDataOutside ? .5 : .75, v = 0, y = 0, _ = e.deg2rad(360 / g * e.config.eqDataLineRatio), S = e.deg2rad(1 === t._360data.didFinish ? 360 : 360 * (t._360data.lastValues.position / t._360data.lastValues.durationEstimate)), h = 0, k = 0, d = 0; x > d; d += p) v = e.deg2rad(360 * (d / x)), y = v + _, e.drawSolidArc(t._360data.oCanvas, y > S ? e.config.eqDataColor : e.config.playRingColor, t._360data.width * b, t._360data.radius * s * (t.eqData.left[d] * f), y, v, !0);
                if (e.config.usePeakData && !t._360data.animating) {
                    for (T = t.peakData.left || t.peakData.right, x = 3, d = 0; x > d; d++) T = T || t.eqData[d];
                    t._360data.amplifier = e.config.useAmplifier ? .9 + .1 * T : 1, t._360data.radiusMax = .175 * t._360data.circleDiameter * t._360data.amplifier, t._360data.widthMax = .4 * t._360data.circleDiameter * t._360data.amplifier, t._360data.radius = parseInt(t._360data.radiusMax * t._360data.amplifier, 10), t._360data.width = parseInt(t._360data.widthMax * t._360data.amplifier, 10)
                }
            }, this.getUIHTML = function(t) {
                return ['<canvas class="sm2-canvas" width="' + t + '" height="' + t + '"></canvas>', ' <span class="sm2-360btn sm2-360btn-default"></span>', ' <div class="sm2-timing' + (navigator.userAgent.match(/safari/i) ? " alignTweak" : "") + '"></div>', ' <div class="sm2-cover"></div>']
            }, this.uiTest = function(t) {
                var i = document.createElement("div"),
                    n, a, o, s, r, l, u, c, d;
                return i.className = "sm2-360ui", n = document.createElement("div"), n.className = "ui360" + (t ? " " + t : ""), a = n.appendChild(i.cloneNode(!0)), n.style.position = "absolute", n.style.left = "-9999px", o = document.body.appendChild(n), s = a.offsetWidth * f, r = e.getUIHTML(s), a.innerHTML = r[1] + r[2] + r[3], l = parseInt(s, 10), u = parseInt(l / 2, 10), d = e.getElementsByClassName("sm2-timing", "div", o)[0], c = parseInt(e.getStyle(d, "font-size"), 10), isNaN(c) && (c = null), n.parentNode.removeChild(n), r = n = a = o = null, {
                    circleDiameter: l,
                    circleRadius: u,
                    fontSizeMax: c
                }
            }, this.init = function() {
                n._writeDebug("threeSixtyPlayer.init()");
                var i = e.getElementsByClassName("ui360", "div"),
                    a, s, r = [],
                    l = !1,
                    u = 0,
                    d, h, p, m, g, v, y, w, b, _, C, x, S;
                for (a = 0, s = i.length; s > a; a++) r.push(i[a].getElementsByTagName("a")[0]), i[a].style.backgroundImage = "none";
                for (e.oUITemplate = document.createElement("div"), e.oUITemplate.className = "sm2-360ui", e.oUITemplateVis = document.createElement("div"), e.oUITemplateVis.className = "sm2-360ui", y = e.uiTest(), e.config.circleDiameter = y.circleDiameter, e.config.circleRadius = y.circleRadius, w = e.uiTest("ui360-vis"), e.config.fontSizeMax = w.fontSizeMax, e.oUITemplate.innerHTML = e.getUIHTML(e.config.circleDiameter).join(""), e.oUITemplateVis.innerHTML = e.getUIHTML(w.circleDiameter).join(""), a = 0, s = r.length; s > a; a++) !n.canPlayLink(r[a]) || e.hasClass(r[a], e.excludeClass) || e.hasClass(r[a], e.css.sDefault) || (e.addClass(r[a], e.css.sDefault), e.links[u] = r[a], e.indexByURL[r[a].href] = u, u++, l = e.hasClass(r[a].parentNode, "ui360-vis"), g = (l ? w : y).circleDiameter, v = (l ? w : y).circleRadius, b = r[a].parentNode.insertBefore((l ? e.oUITemplateVis : e.oUITemplate).cloneNode(!0), r[a]), o && "undefined" != typeof t.G_vmlCanvasManager ? (C = r[a].parentNode, x = document.createElement("canvas"), x.className = "sm2-canvas", S = "sm2_canvas_" + a + (new Date).getTime(), x.id = S, x.width = g, x.height = g, b.appendChild(x), t.G_vmlCanvasManager.initElement(x), h = document.getElementById(S), d = h.parentNode.getElementsByTagName("canvas"), d.length > 1 && (h = d[d.length - 1])) : h = r[a].parentNode.getElementsByTagName("canvas")[0], f > 1 && e.addClass(h, "hi-dpi"), m = e.getElementsByClassName("sm2-cover", "div", r[a].parentNode)[0], _ = r[a].parentNode.getElementsByTagName("span")[0], e.addEventHandler(_, "click", e.buttonClick), c ? e.addEventHandler(m, "touchstart", e.mouseDown) : e.addEventHandler(m, "mousedown", e.mouseDown), p = h.getContext("2d"), p.translate(v, v), p.rotate(e.deg2rad(-90)));
                u > 0 && (e.addEventHandler(document, "click", e.handleClick), e.config.autoPlay && e.handleClick({
                    target: e.links[0],
                    preventDefault: function() {}
                })), n._writeDebug("threeSixtyPlayer.init(): Found " + u + " relevant items."), e.config.useFavIcon && "undefined" != typeof this.VUMeter && (this.vuMeter = new this.VUMeter(this))
            }
        }
        e.prototype.VUMeter = function(t) {
            var e = t,
                i = this,
                n = document.getElementsByTagName("head")[0],
                a = navigator.userAgent.match(/opera/i),
                o = navigator.userAgent.match(/firefox/i);
            this.vuMeterData = [], this.vuDataCanvas = null, this.setPageIcon = function(t) {
                if (!e.config.useFavIcon || !e.config.usePeakData || !t) return !1;
                var i = document.getElementById("sm2-favicon");
                i && (n.removeChild(i), i = null), i || (i = document.createElement("link"), i.id = "sm2-favicon", i.rel = "shortcut icon", i.type = "image/png", i.href = t, document.getElementsByTagName("head")[0].appendChild(i))
            }, this.resetPageIcon = function() {
                if (!e.config.useFavIcon) return !1;
                var t = document.getElementById("favicon");
                t && (t.href = "/favicon.ico")
            }, this.updateVU = function(t) {
                soundManager.flashVersion >= 9 && e.config.useFavIcon && e.config.usePeakData && i.setPageIcon(i.vuMeterData[parseInt(16 * t.peakData.left, 10)][parseInt(16 * t.peakData.right, 10)])
            }, this.createVUData = function() {
                var t = 0,
                    e = 0,
                    n = i.vuDataCanvas.getContext("2d"),
                    a = n.createLinearGradient(0, 16, 0, 0),
                    o = n.createLinearGradient(0, 16, 0, 0),
                    s = "rgba(0,0,0,0.2)";
                for (a.addColorStop(0, "rgb(0,192,0)"), a.addColorStop(.3, "rgb(0,255,0)"), a.addColorStop(.625, "rgb(255,255,0)"), a.addColorStop(.85, "rgb(255,0,0)"), o.addColorStop(0, s), o.addColorStop(1, "rgba(0,0,0,0.5)"), t = 0; 16 > t; t++) i.vuMeterData[t] = [];
                for (t = 0; 16 > t; t++)
                    for (e = 0; 16 > e; e++) i.vuDataCanvas.setAttribute("width", 16), i.vuDataCanvas.setAttribute("height", 16), n.fillStyle = o, n.fillRect(0, 0, 7, 15), n.fillRect(8, 0, 7, 15), n.fillStyle = a, n.fillRect(0, 15 - t, 7, 16 - (16 - t)), n.fillRect(8, 15 - e, 7, 16 - (16 - e)), n.clearRect(0, 3, 16, 1), n.clearRect(0, 7, 16, 1), n.clearRect(0, 11, 16, 1), i.vuMeterData[t][e] = i.vuDataCanvas.toDataURL("image/png")
            }, this.testCanvas = function() {
                var t = document.createElement("canvas"),
                    e = null,
                    i;
                if (!t || "undefined" == typeof t.getContext) return null;
                if (e = t.getContext("2d"), !e || "function" != typeof t.toDataURL) return null;
                try {
                    i = t.toDataURL("image/png")
                } catch (n) {
                    return null
                }
                return t
            }, this.init = function() {
                e.config.useFavIcon && (i.vuDataCanvas = i.testCanvas(), i.vuDataCanvas && (o || a) ? i.createVUData() : e.config.useFavIcon = !1)
            }, this.init()
        }, e.prototype.Metadata = function(t, e) {
            soundManager._wD("Metadata()");
            var i = this,
                n = t._360data.oUI360,
                a = n.getElementsByTagName("ul")[0],
                o = a.getElementsByTagName("li"),
                s = navigator.userAgent.match(/firefox/i),
                r = !1,
                l, u;
            for (this.lastWPExec = 0, this.refreshInterval = 250, this.totalTime = 0, this.events = {
                    whileplaying: function() {
                        var n = t._360data.width,
                            a = t._360data.radius,
                            o = t.durationEstimate || 1e3 * i.totalTime,
                            s = null,
                            r, l, u;
                        for (r = 0, l = i.data.length; l > r; r++) s = r % 2 === 0, e.drawSolidArc(t._360data.oCanvas, s ? e.config.segmentRingColorAlt : e.config.segmentRingColor, s ? n : n, s ? a / 2 : a / 2, e.deg2rad(360 * (i.data[r].endTimeMS / o)), e.deg2rad(360 * ((i.data[r].startTimeMS || 1) / o)), !0);
                        u = new Date, u - i.lastWPExec > i.refreshInterval && (i.refresh(), i.lastWPExec = u)
                    }
                }, this.refresh = function() {
                    var e, i, n = null,
                        a = t.position,
                        o = t._360data.metadata.data;
                    for (e = 0, i = o.length; i > e; e++)
                        if (a >= o[e].startTimeMS && a <= o[e].endTimeMS) {
                            n = e;
                            break
                        }
                    n !== o.currentItem && n < o.length && (t._360data.oLink.innerHTML = o.mainTitle + ' <span class="metadata"><span class="sm2_divider"> | </span><span class="sm2_metadata">' + o[n].title + "</span></span>", o.currentItem = n)
                }, this.strToTime = function(t) {
                    var e = t.split(":"),
                        i = 0,
                        n;
                    for (n = e.length; n--;) i += parseInt(e[n], 10) * Math.pow(60, e.length - 1 - n);
                    return i
                }, this.data = [], this.data.givenDuration = null, this.data.currentItem = null, this.data.mainTitle = t._360data.oLink.innerHTML, l = 0; l < o.length; l++) this.data[l] = {
                o: null,
                title: o[l].getElementsByTagName("p")[0].innerHTML,
                startTime: o[l].getElementsByTagName("span")[0].innerHTML,
                startSeconds: i.strToTime(o[l].getElementsByTagName("span")[0].innerHTML.replace(/[()]/g, "")),
                duration: 0,
                durationMS: null,
                startTimeMS: null,
                endTimeMS: null,
                oNote: null
            };
            for (u = e.getElementsByClassName("duration", "div", n), this.data.givenDuration = u.length ? 1e3 * i.strToTime(u[0].innerHTML) : 0, l = 0; l < this.data.length; l++) this.data[l].duration = parseInt(this.data[l + 1] ? this.data[l + 1].startSeconds : (i.data.givenDuration ? i.data.givenDuration : t.durationEstimate) / 1e3, 10) - this.data[l].startSeconds, this.data[l].startTimeMS = 1e3 * this.data[l].startSeconds, this.data[l].durationMS = 1e3 * this.data[l].duration, this.data[l].endTimeMS = this.data[l].startTimeMS + this.data[l].durationMS, this.totalTime += this.data[l].duration
        }, navigator.userAgent.match(/webkit/i) && navigator.userAgent.match(/mobile/i) && soundManager.setup({
            useHTML5Audio: !0
        }), soundManager.setup({
            html5PollingInterval: 50,
            debugMode: t.location.href.match(/debug=1/i),
            consoleOnly: !0,
            flashVersion: 9,
            useHighPerformance: !0
        }), soundManager.debugMode && t.setInterval(function() {
            var e = t.threeSixtyPlayer;
            e && e.lastSound && e.lastSound._360data.fps && "undefined" == typeof t.isHome && (soundManager._writeDebug("fps: ~" + e.lastSound._360data.fps), e.lastSound._360data.fps = 0)
        }, 1e3), t.ThreeSixtyPlayer = e
    }(window), threeSixtyPlayer = new ThreeSixtyPlayer, soundManager.onready(threeSixtyPlayer.init), document.createElement("canvas").getContext || ! function() {
        function t() {
            return this.context_ || (this.context_ = new u(this))
        }

        function e(t, e, i) {
            var n = _.call(arguments, 2);
            return function() {
                return t.apply(e, n.concat(_.call(arguments)))
            }
        }

        function i(t) {
            var e = t.srcElement;
            switch (t.propertyName) {
                case "width":
                    e.style.width = e.attributes.width.nodeValue + "px", e.getContext().clearRect();
                    break;
                case "height":
                    e.style.height = e.attributes.height.nodeValue + "px", e.getContext().clearRect()
            }
        }

        function n(t) {
            var e = t.srcElement;
            e.firstChild && (e.firstChild.style.width = e.clientWidth + "px", e.firstChild.style.height = e.clientHeight + "px")
        }

        function a() {
            return [
                [1, 0, 0],
                [0, 1, 0],
                [0, 0, 1]
            ]
        }

        function o(t, e) {
            for (var i = a(), n = 0; 3 > n; n++)
                for (var o = 0; 3 > o; o++) {
                    for (var s = 0, r = 0; 3 > r; r++) s += t[n][r] * e[r][o];
                    i[n][o] = s
                }
            return i
        }

        function s(t, e) {
            e.fillStyle = t.fillStyle, e.lineCap = t.lineCap, e.lineJoin = t.lineJoin, e.lineWidth = t.lineWidth, e.miterLimit = t.miterLimit, e.shadowBlur = t.shadowBlur, e.shadowColor = t.shadowColor, e.shadowOffsetX = t.shadowOffsetX, e.shadowOffsetY = t.shadowOffsetY, e.strokeStyle = t.strokeStyle, e.globalAlpha = t.globalAlpha, e.arcScaleX_ = t.arcScaleX_, e.arcScaleY_ = t.arcScaleY_, e.lineScale_ = t.lineScale_
        }

        function r(t) {
            var e, i = 1;
            if (t = String(t), "rgb" == t.substring(0, 3)) {
                var n = t.indexOf("(", 3),
                    a = t.indexOf(")", n + 1),
                    o = t.substring(n + 1, a).split(",");
                e = "#";
                for (var s = 0; 3 > s; s++) e += x[Number(o[s])];
                4 == o.length && "a" == t.substr(3, 1) && (i = o[3])
            } else e = t;
            return {
                color: e,
                alpha: i
            }
        }

        function l(t) {
            switch (t) {
                case "butt":
                    return "flat";
                case "round":
                    return "round";
                case "square":
                default:
                    return "square"
            }
        }

        function u(t) {
            this.m_ = a(), this.mStack_ = [], this.aStack_ = [], this.currentPath_ = [], this.strokeStyle = "#000", this.fillStyle = "#000", this.lineWidth = 1, this.lineJoin = "miter", this.lineCap = "butt", this.miterLimit = 1 * w, this.globalAlpha = 1, this.canvas = t;
            var e = t.ownerDocument.createElement("div");
            e.style.width = t.clientWidth + "px", e.style.height = t.clientHeight + "px", e.style.overflow = "hidden", e.style.position = "absolute", t.appendChild(e), this.element_ = e, this.arcScaleX_ = 1, this.arcScaleY_ = 1, this.lineScale_ = 1
        }

        function c(t, e, i, n) {
            t.currentPath_.push({
                type: "bezierCurveTo",
                cp1x: e.x,
                cp1y: e.y,
                cp2x: i.x,
                cp2y: i.y,
                x: n.x,
                y: n.y
            }), t.currentX_ = n.x, t.currentY_ = n.y
        }

        function d(t) {
            this.type_ = t, this.x0_ = 0, this.y0_ = 0, this.r0_ = 0, this.x1_ = 0, this.y1_ = 0, this.r1_ = 0, this.colors_ = []
        }

        function h() {}
        var f = Math,
            p = f.round,
            m = f.sin,
            g = f.cos,
            v = f.abs,
            y = f.sqrt,
            w = 10,
            b = w / 2,
            _ = Array.prototype.slice,
            C = {
                init: function(t) {
                    if (/MSIE/.test(navigator.userAgent) && !window.opera) {
                        var i = t || document;
                        i.createElement("canvas"), i.attachEvent("onreadystatechange", e(this.init_, this, i))
                    }
                },
                init_: function(t) {
                    if (t.namespaces.g_vml_ || t.namespaces.add("g_vml_", "urn:schemas-microsoft-com:vml", "#default#VML"), t.namespaces.g_o_ || t.namespaces.add("g_o_", "urn:schemas-microsoft-com:office:office", "#default#VML"), !t.styleSheets.ex_canvas_) {
                        var e = t.createStyleSheet();
                        e.owningElement.id = "ex_canvas_", e.cssText = "canvas{display:inline-block;overflow:hidden;text-align:left;width:300px;height:150px}g_vml_\\:*{behavior:url(#default#VML)}g_o_\\:*{behavior:url(#default#VML)}"
                    }
                    for (var i = t.getElementsByTagName("canvas"), n = 0; n < i.length; n++) this.initElement(i[n])
                },
                initElement: function(e) {
                    if (!e.getContext) {
                        e.getContext = t, e.innerHTML = "", e.attachEvent("onpropertychange", i), e.attachEvent("onresize", n);
                        var a = e.attributes;
                        a.width && a.width.specified ? e.style.width = a.width.nodeValue + "px" : e.width = e.clientWidth, a.height && a.height.specified ? e.style.height = a.height.nodeValue + "px" : e.height = e.clientHeight
                    }
                    return e
                }
            };
        C.init();
        for (var x = [], S = 0; 16 > S; S++)
            for (var k = 0; 16 > k; k++) x[16 * S + k] = S.toString(16) + k.toString(16);
        var T = u.prototype;
        T.clearRect = function() {
            this.element_.innerHTML = ""
        }, T.beginPath = function() {
            this.currentPath_ = []
        }, T.moveTo = function(t, e) {
            var i = this.getCoords_(t, e);
            this.currentPath_.push({
                type: "moveTo",
                x: i.x,
                y: i.y
            }), this.currentX_ = i.x, this.currentY_ = i.y
        }, T.lineTo = function(t, e) {
            var i = this.getCoords_(t, e);
            this.currentPath_.push({
                type: "lineTo",
                x: i.x,
                y: i.y
            }), this.currentX_ = i.x, this.currentY_ = i.y
        }, T.bezierCurveTo = function(t, e, i, n, a, o) {
            var s = this.getCoords_(a, o),
                r = this.getCoords_(t, e),
                l = this.getCoords_(i, n);
            c(this, r, l, s)
        }, T.quadraticCurveTo = function(t, e, i, n) {
            var a = this.getCoords_(t, e),
                o = this.getCoords_(i, n),
                s = {
                    x: this.currentX_ + 2 / 3 * (a.x - this.currentX_),
                    y: this.currentY_ + 2 / 3 * (a.y - this.currentY_)
                },
                r = {
                    x: s.x + (o.x - this.currentX_) / 3,
                    y: s.y + (o.y - this.currentY_) / 3
                };
            c(this, s, r, o)
        }, T.arc = function(t, e, i, n, a, o) {
            i *= w;
            var s = o ? "at" : "wa",
                r = t + g(n) * i - b,
                l = e + m(n) * i - b,
                u = t + g(a) * i - b,
                c = e + m(a) * i - b;
            r != u || o || (r += .125);
            var d = this.getCoords_(t, e),
                h = this.getCoords_(r, l),
                f = this.getCoords_(u, c);
            this.currentPath_.push({
                type: s,
                x: d.x,
                y: d.y,
                radius: i,
                xStart: h.x,
                yStart: h.y,
                xEnd: f.x,
                yEnd: f.y
            })
        }, T.rect = function(t, e, i, n) {
            this.moveTo(t, e), this.lineTo(t + i, e), this.lineTo(t + i, e + n), this.lineTo(t, e + n), this.closePath()
        }, T.strokeRect = function(t, e, i, n) {
            var a = this.currentPath_;
            this.beginPath(), this.moveTo(t, e), this.lineTo(t + i, e), this.lineTo(t + i, e + n), this.lineTo(t, e + n), this.closePath(), this.stroke(), this.currentPath_ = a
        }, T.fillRect = function(t, e, i, n) {
            var a = this.currentPath_;
            this.beginPath(), this.moveTo(t, e), this.lineTo(t + i, e), this.lineTo(t + i, e + n), this.lineTo(t, e + n), this.closePath(), this.fill(), this.currentPath_ = a
        }, T.createLinearGradient = function(t, e, i, n) {
            var a = new d("gradient");
            return a.x0_ = t, a.y0_ = e, a.x1_ = i, a.y1_ = n, a
        }, T.createRadialGradient = function(t, e, i, n, a, o) {
            var s = new d("gradientradial");
            return s.x0_ = t, s.y0_ = e, s.r0_ = i, s.x1_ = n, s.y1_ = a, s.r1_ = o, s
        }, T.drawImage = function(t, e) {
            var i, n, a, o, s, r, l, u, c = t.runtimeStyle.width,
                d = t.runtimeStyle.height;
            t.runtimeStyle.width = "auto", t.runtimeStyle.height = "auto";
            var h = t.width,
                m = t.height;
            if (t.runtimeStyle.width = c, t.runtimeStyle.height = d, 3 == arguments.length) i = arguments[1], n = arguments[2], s = r = 0, l = a = h, u = o = m;
            else if (5 == arguments.length) i = arguments[1], n = arguments[2], a = arguments[3], o = arguments[4], s = r = 0, l = h, u = m;
            else {
                if (9 != arguments.length) throw Error("Invalid number of arguments");
                s = arguments[1], r = arguments[2], l = arguments[3], u = arguments[4], i = arguments[5], n = arguments[6], a = arguments[7], o = arguments[8]
            }
            var g = this.getCoords_(i, n),
                v = l / 2,
                y = u / 2,
                b = [],
                _ = 10,
                C = 10;
            if (b.push(" <g_vml_:group", ' coordsize="', w * _, ",", w * C, '"', ' coordorigin="0,0"', ' style="width:', _, "px;height:", C, "px;position:absolute;"), 1 != this.m_[0][0] || this.m_[0][1]) {
                var x = [];
                x.push("M11=", this.m_[0][0], ",", "M12=", this.m_[1][0], ",", "M21=", this.m_[0][1], ",", "M22=", this.m_[1][1], ",", "Dx=", p(g.x / w), ",", "Dy=", p(g.y / w), "");
                var S = g,
                    k = this.getCoords_(i + a, n),
                    T = this.getCoords_(i, n + o),
                    M = this.getCoords_(i + a, n + o);
                S.x = f.max(S.x, k.x, T.x, M.x), S.y = f.max(S.y, k.y, T.y, M.y), b.push("padding:0 ", p(S.x / w), "px ", p(S.y / w), "px 0;filter:progid:DXImageTransform.Microsoft.Matrix(", x.join(""), ", sizingmethod='clip');")
            } else b.push("top:", p(g.y / w), "px;left:", p(g.x / w), "px;");
            b.push(' ">', '<g_vml_:image src="', t.src, '"', ' style="width:', w * a, "px;", " height:", w * o, 'px;"', ' cropleft="', s / h, '"', ' croptop="', r / m, '"', ' cropright="', (h - s - l) / h, '"', ' cropbottom="', (m - r - u) / m, '"', " />", "</g_vml_:group>"), this.element_.insertAdjacentHTML("BeforeEnd", b.join(""))
        }, T.stroke = function(t) {
            var e = [],
                i = !1,
                n = r(t ? this.fillStyle : this.strokeStyle),
                a = n.color,
                o = n.alpha * this.globalAlpha,
                s = 10,
                u = 10;
            e.push("<g_vml_:shape", ' filled="', !!t, '"', ' style="position:absolute;width:', s, "px;height:", u, 'px;"', ' coordorigin="0 0" coordsize="', w * s, " ", w * u, '"', ' stroked="', !t, '"', ' path="');
            for (var c = !1, d = {
                    x: null,
                    y: null
                }, h = {
                    x: null,
                    y: null
                }, m = 0; m < this.currentPath_.length; m++) {
                var g = this.currentPath_[m],
                    v;
                switch (g.type) {
                    case "moveTo":
                        v = g, e.push(" m ", p(g.x), ",", p(g.y));
                        break;
                    case "lineTo":
                        e.push(" l ", p(g.x), ",", p(g.y));
                        break;
                    case "close":
                        e.push(" x "), g = null;
                        break;
                    case "bezierCurveTo":
                        e.push(" c ", p(g.cp1x), ",", p(g.cp1y), ",", p(g.cp2x), ",", p(g.cp2y), ",", p(g.x), ",", p(g.y));
                        break;
                    case "at":
                    case "wa":
                        e.push(" ", g.type, " ", p(g.x - this.arcScaleX_ * g.radius), ",", p(g.y - this.arcScaleY_ * g.radius), " ", p(g.x + this.arcScaleX_ * g.radius), ",", p(g.y + this.arcScaleY_ * g.radius), " ", p(g.xStart), ",", p(g.yStart), " ", p(g.xEnd), ",", p(g.yEnd))
                }
                g && ((null == d.x || g.x < d.x) && (d.x = g.x), (null == h.x || g.x > h.x) && (h.x = g.x), (null == d.y || g.y < d.y) && (d.y = g.y), (null == h.y || g.y > h.y) && (h.y = g.y))
            }
            if (e.push(' ">'), t)
                if ("object" == typeof this.fillStyle) {
                    var y = this.fillStyle,
                        b = 0,
                        _ = {
                            x: 0,
                            y: 0
                        },
                        C = 0,
                        x = 1;
                    if ("gradient" == y.type_) {
                        var S = y.x0_ / this.arcScaleX_,
                            k = y.y0_ / this.arcScaleY_,
                            T = y.x1_ / this.arcScaleX_,
                            M = y.y1_ / this.arcScaleY_,
                            P = this.getCoords_(S, k),
                            O = this.getCoords_(T, M),
                            D = O.x - P.x,
                            L = O.y - P.y;
                        b = 180 * Math.atan2(D, L) / Math.PI, 0 > b && (b += 360), 1e-6 > b && (b = 0)
                    } else {
                        var P = this.getCoords_(y.x0_, y.y0_),
                            E = h.x - d.x,
                            F = h.y - d.y;
                        _ = {
                            x: (P.x - d.x) / E,
                            y: (P.y - d.y) / F
                        }, E /= this.arcScaleX_ * w, F /= this.arcScaleY_ * w;
                        var A = f.max(E, F);
                        C = 2 * y.r0_ / A, x = 2 * y.r1_ / A - C
                    }
                    var I = y.colors_;
                    I.sort(function(t, e) {
                        return t.offset - e.offset
                    });
                    for (var q = I.length, j = I[0].color, N = I[q - 1].color, V = I[0].alpha * this.globalAlpha, z = I[q - 1].alpha * this.globalAlpha, H = [], m = 0; q > m; m++) {
                        var R = I[m];
                        H.push(R.offset * x + C + " " + R.color)
                    }
                    e.push('<g_vml_:fill type="', y.type_, '"', ' method="none" focus="100%"', ' color="', j, '"', ' color2="', N, '"', ' colors="', H.join(","), '"', ' opacity="', z, '"', ' g_o_:opacity2="', V, '"', ' angle="', b, '"', ' focusposition="', _.x, ",", _.y, '" />')
                } else e.push('<g_vml_:fill color="', a, '" opacity="', o, '" />');
            else {
                var B = this.lineScale_ * this.lineWidth;
                1 > B && (o *= B), e.push("<g_vml_:stroke", ' opacity="', o, '"', ' joinstyle="', this.lineJoin, '"', ' miterlimit="', this.miterLimit, '"', ' endcap="', l(this.lineCap), '"', ' weight="', B, 'px"', ' color="', a, '" />')
            }
            e.push("</g_vml_:shape>"), this.element_.insertAdjacentHTML("beforeEnd", e.join(""))
        }, T.fill = function() {
            this.stroke(!0)
        }, T.closePath = function() {
            this.currentPath_.push({
                type: "close"
            })
        }, T.getCoords_ = function(t, e) {
            var i = this.m_;
            return {
                x: w * (t * i[0][0] + e * i[1][0] + i[2][0]) - b,
                y: w * (t * i[0][1] + e * i[1][1] + i[2][1]) - b
            }
        }, T.save = function() {
            var t = {};
            s(this, t), this.aStack_.push(t), this.mStack_.push(this.m_), this.m_ = o(a(), this.m_)
        }, T.restore = function() {
            s(this.aStack_.pop(), this), this.m_ = this.mStack_.pop()
        }, T.translate = function(t, e) {
            var i = [
                [1, 0, 0],
                [0, 1, 0],
                [t, e, 1]
            ];
            this.m_ = o(i, this.m_)
        }, T.rotate = function(t) {
            var e = g(t),
                i = m(t),
                n = [
                    [e, i, 0],
                    [-i, e, 0],
                    [0, 0, 1]
                ];
            this.m_ = o(n, this.m_)
        }, T.scale = function(t, e) {
            this.arcScaleX_ *= t, this.arcScaleY_ *= e;
            var i = [
                    [t, 0, 0],
                    [0, e, 0],
                    [0, 0, 1]
                ],
                n = this.m_ = o(i, this.m_),
                a = n[0][0] * n[1][1] - n[0][1] * n[1][0];
            this.lineScale_ = y(v(a))
        }, T.clip = function() {}, T.arcTo = function() {}, T.createPattern = function() {
            return new h
        }, d.prototype.addColorStop = function(t, e) {
            e = r(e), this.colors_.push({
                offset: t,
                color: e.color,
                alpha: e.alpha
            })
        }, G_vmlCanvasManager = C, CanvasRenderingContext2D = u, CanvasGradient = d, CanvasPattern = h
    }(), function($, t, e) {
        function i(t) {
            return t
        }

        function n(t) {
            return decodeURIComponent(t.replace(a, " "))
        }
        var a = /\+/g,
            o = $.cookie = function(a, s, r) {
                if (s !== e) {
                    if (r = $.extend({}, o.defaults, r), null === s && (r.expires = -1), "number" == typeof r.expires) {
                        var l = r.expires,
                            u = r.expires = new Date;
                        u.setDate(u.getDate() + l)
                    }
                    return s = o.json ? JSON.stringify(s) : String(s), t.cookie = [encodeURIComponent(a), "=", o.raw ? s : encodeURIComponent(s), r.expires ? "; expires=" + r.expires.toUTCString() : "", r.path ? "; path=" + r.path : "", r.domain ? "; domain=" + r.domain : "", r.secure ? "; secure" : ""].join("")
                }
                for (var c = o.raw ? i : n, d = t.cookie.split("; "), h = 0, f = d.length; f > h; h++) {
                    var p = d[h].split("=");
                    if (c(p.shift()) === a) {
                        var m = c(p.join("="));
                        return o.json ? JSON.parse(m) : m
                    }
                }
                return null
            };
        o.defaults = {}, $.removeCookie = function(t, e) {
            return null !== $.cookie(t) ? ($.cookie(t, null, e), !0) : !1
        }
    }(jQuery, document), "undefined" == typeof jQuery) {
    var jQuery;
    jQuery = "function" == typeof require ? $ = require("jQuery") : $
}
jQuery.easing.jswing = jQuery.easing.swing, jQuery.extend(jQuery.easing, {
        def: "easeOutQuad",
        swing: function(t, e, i, n, a) {
            return jQuery.easing[jQuery.easing.def](t, e, i, n, a)
        },
        easeInQuad: function(t, e, i, n, a) {
            return n * (e /= a) * e + i
        },
        easeOutQuad: function(t, e, i, n, a) {
            return -n * (e /= a) * (e - 2) + i
        },
        easeInOutQuad: function(t, e, i, n, a) {
            return (e /= a / 2) < 1 ? n / 2 * e * e + i : -n / 2 * (--e * (e - 2) - 1) + i
        },
        easeInCubic: function(t, e, i, n, a) {
            return n * (e /= a) * e * e + i
        },
        easeOutCubic: function(t, e, i, n, a) {
            return n * ((e = e / a - 1) * e * e + 1) + i
        },
        easeInOutCubic: function(t, e, i, n, a) {
            return (e /= a / 2) < 1 ? n / 2 * e * e * e + i : n / 2 * ((e -= 2) * e * e + 2) + i
        },
        easeInQuart: function(t, e, i, n, a) {
            return n * (e /= a) * e * e * e + i
        },
        easeOutQuart: function(t, e, i, n, a) {
            return -n * ((e = e / a - 1) * e * e * e - 1) + i
        },
        easeInOutQuart: function(t, e, i, n, a) {
            return (e /= a / 2) < 1 ? n / 2 * e * e * e * e + i : -n / 2 * ((e -= 2) * e * e * e - 2) + i
        },
        easeInQuint: function(t, e, i, n, a) {
            return n * (e /= a) * e * e * e * e + i
        },
        easeOutQuint: function(t, e, i, n, a) {
            return n * ((e = e / a - 1) * e * e * e * e + 1) + i
        },
        easeInOutQuint: function(t, e, i, n, a) {
            return (e /= a / 2) < 1 ? n / 2 * e * e * e * e * e + i : n / 2 * ((e -= 2) * e * e * e * e + 2) + i
        },
        easeInSine: function(t, e, i, n, a) {
            return -n * Math.cos(e / a * (Math.PI / 2)) + n + i
        },
        easeOutSine: function(t, e, i, n, a) {
            return n * Math.sin(e / a * (Math.PI / 2)) + i
        },
        easeInOutSine: function(t, e, i, n, a) {
            return -n / 2 * (Math.cos(Math.PI * e / a) - 1) + i
        },
        easeInExpo: function(t, e, i, n, a) {
            return 0 == e ? i : n * Math.pow(2, 10 * (e / a - 1)) + i
        },
        easeOutExpo: function(t, e, i, n, a) {
            return e == a ? i + n : n * (-Math.pow(2, -10 * e / a) + 1) + i
        },
        easeInOutExpo: function(t, e, i, n, a) {
            return 0 == e ? i : e == a ? i + n : (e /= a / 2) < 1 ? n / 2 * Math.pow(2, 10 * (e - 1)) + i : n / 2 * (-Math.pow(2, -10 * --e) + 2) + i
        },
        easeInCirc: function(t, e, i, n, a) {
            return -n * (Math.sqrt(1 - (e /= a) * e) - 1) + i
        },
        easeOutCirc: function(t, e, i, n, a) {
            return n * Math.sqrt(1 - (e = e / a - 1) * e) + i
        },
        easeInOutCirc: function(t, e, i, n, a) {
            return (e /= a / 2) < 1 ? -n / 2 * (Math.sqrt(1 - e * e) - 1) + i : n / 2 * (Math.sqrt(1 - (e -= 2) * e) + 1) + i
        },
        easeInElastic: function(t, e, i, n, a) {
            var o = 1.70158,
                s = 0,
                r = n;
            if (0 == e) return i;
            if (1 == (e /= a)) return i + n;
            if (s || (s = .3 * a), r < Math.abs(n)) {
                r = n;
                var o = s / 4
            } else var o = s / (2 * Math.PI) * Math.asin(n / r);
            return -(r * Math.pow(2, 10 * (e -= 1)) * Math.sin((e * a - o) * (2 * Math.PI) / s)) + i
        },
        easeOutElastic: function(t, e, i, n, a) {
            var o = 1.70158,
                s = 0,
                r = n;
            if (0 == e) return i;
            if (1 == (e /= a)) return i + n;
            if (s || (s = .3 * a), r < Math.abs(n)) {
                r = n;
                var o = s / 4
            } else var o = s / (2 * Math.PI) * Math.asin(n / r);
            return r * Math.pow(2, -10 * e) * Math.sin((e * a - o) * (2 * Math.PI) / s) + n + i
        },
        easeInOutElastic: function(t, e, i, n, a) {
            var o = 1.70158,
                s = 0,
                r = n;
            if (0 == e) return i;
            if (2 == (e /= a / 2)) return i + n;
            if (s || (s = a * (.3 * 1.5)), r < Math.abs(n)) {
                r = n;
                var o = s / 4
            } else var o = s / (2 * Math.PI) * Math.asin(n / r);
            return 1 > e ? -.5 * (r * Math.pow(2, 10 * (e -= 1)) * Math.sin((e * a - o) * (2 * Math.PI) / s)) + i : r * Math.pow(2, -10 * (e -= 1)) * Math.sin((e * a - o) * (2 * Math.PI) / s) * .5 + n + i
        },
        easeInBack: function(t, e, i, n, a, o) {
            return void 0 == o && (o = 1.70158), n * (e /= a) * e * ((o + 1) * e - o) + i
        },
        easeOutBack: function(t, e, i, n, a, o) {
            return void 0 == o && (o = 1.70158), n * ((e = e / a - 1) * e * ((o + 1) * e + o) + 1) + i
        },
        easeInOutBack: function(t, e, i, n, a, o) {
            return void 0 == o && (o = 1.70158), (e /= a / 2) < 1 ? n / 2 * (e * e * (((o *= 1.525) + 1) * e - o)) + i : n / 2 * ((e -= 2) * e * (((o *= 1.525) + 1) * e + o) + 2) + i
        },
        easeInBounce: function(t, e, i, n, a) {
            return n - jQuery.easing.easeOutBounce(t, a - e, 0, n, a) + i
        },
        easeOutBounce: function(t, e, i, n, a) {
            return (e /= a) < 1 / 2.75 ? n * (7.5625 * e * e) + i : 2 / 2.75 > e ? n * (7.5625 * (e -= 1.5 / 2.75) * e + .75) + i : 2.5 / 2.75 > e ? n * (7.5625 * (e -= 2.25 / 2.75) * e + .9375) + i : n * (7.5625 * (e -= 2.625 / 2.75) * e + .984375) + i
        },
        easeInOutBounce: function(t, e, i, n, a) {
            return a / 2 > e ? .5 * jQuery.easing.easeInBounce(t, 2 * e, 0, n, a) + i : .5 * jQuery.easing.easeOutBounce(t, 2 * e - a, 0, n, a) + .5 * n + i
        }
    }), jQuery.extend(jQuery.easing, {
        easeInOutMaterial: function(t, e, i, n, a) {
            return (e /= a / 2) < 1 ? n / 2 * e * e + i : n / 4 * ((e -= 2) * e * e + 2) + i
        }
    }), jQuery.Velocity ? console.log("Velocity is already loaded. You may be needlessly importing Velocity again; note that Materialize includes Velocity.") : (! function(t) {
        function e(t) {
            var e = t.length,
                n = i.type(t);
            return "function" === n || i.isWindow(t) ? !1 : 1 === t.nodeType && e ? !0 : "array" === n || 0 === e || "number" == typeof e && e > 0 && e - 1 in t
        }
        if (!t.jQuery) {
            var i = function(t, e) {
                return new i.fn.init(t, e)
            };
            i.isWindow = function(t) {
                return null != t && t == t.window
            }, i.type = function(t) {
                return null == t ? t + "" : "object" == typeof t || "function" == typeof t ? a[s.call(t)] || "object" : typeof t
            }, i.isArray = Array.isArray || function(t) {
                return "array" === i.type(t)
            }, i.isPlainObject = function(t) {
                var e;
                if (!t || "object" !== i.type(t) || t.nodeType || i.isWindow(t)) return !1;
                try {
                    if (t.constructor && !o.call(t, "constructor") && !o.call(t.constructor.prototype, "isPrototypeOf")) return !1
                } catch (n) {
                    return !1
                }
                for (e in t);
                return void 0 === e || o.call(t, e)
            }, i.each = function(t, i, n) {
                var a, o = 0,
                    s = t.length,
                    r = e(t);
                if (n) {
                    if (r)
                        for (; s > o && (a = i.apply(t[o], n), a !== !1); o++);
                    else
                        for (o in t)
                            if (a = i.apply(t[o], n), a === !1) break
                } else if (r)
                    for (; s > o && (a = i.call(t[o], o, t[o]), a !== !1); o++);
                else
                    for (o in t)
                        if (a = i.call(t[o], o, t[o]), a === !1) break; return t
            }, i.data = function(t, e, a) {
                if (void 0 === a) {
                    var o = t[i.expando],
                        s = o && n[o];
                    if (void 0 === e) return s;
                    if (s && e in s) return s[e]
                } else if (void 0 !== e) {
                    var o = t[i.expando] || (t[i.expando] = ++i.uuid);
                    return n[o] = n[o] || {}, n[o][e] = a, a
                }
            }, i.removeData = function(t, e) {
                var a = t[i.expando],
                    o = a && n[a];
                o && i.each(e, function(t, e) {
                    delete o[e]
                })
            }, i.extend = function() {
                var t, e, n, a, o, s, r = arguments[0] || {},
                    l = 1,
                    u = arguments.length,
                    c = !1;
                for ("boolean" == typeof r && (c = r, r = arguments[l] || {}, l++), "object" != typeof r && "function" !== i.type(r) && (r = {}), l === u && (r = this, l--); u > l; l++)
                    if (null != (o = arguments[l]))
                        for (a in o) t = r[a], n = o[a], r !== n && (c && n && (i.isPlainObject(n) || (e = i.isArray(n))) ? (e ? (e = !1, s = t && i.isArray(t) ? t : []) : s = t && i.isPlainObject(t) ? t : {}, r[a] = i.extend(c, s, n)) : void 0 !== n && (r[a] = n));
                return r
            }, i.queue = function(t, n, a) {
                function o(t, i) {
                    var n = i || [];
                    return null != t && (e(Object(t)) ? ! function(t, e) {
                        for (var i = +e.length, n = 0, a = t.length; i > n;) t[a++] = e[n++];
                        if (i !== i)
                            for (; void 0 !== e[n];) t[a++] = e[n++];
                        return t.length = a, t
                    }(n, "string" == typeof t ? [t] : t) : [].push.call(n, t)), n
                }
                if (t) {
                    n = (n || "fx") + "queue";
                    var s = i.data(t, n);
                    return a ? (!s || i.isArray(a) ? s = i.data(t, n, o(a)) : s.push(a), s) : s || []
                }
            }, i.dequeue = function(t, e) {
                i.each(t.nodeType ? [t] : t, function(t, n) {
                    e = e || "fx";
                    var a = i.queue(n, e),
                        o = a.shift();
                    "inprogress" === o && (o = a.shift()), o && ("fx" === e && a.unshift("inprogress"), o.call(n, function() {
                        i.dequeue(n, e)
                    }))
                })
            }, i.fn = i.prototype = {
                init: function(t) {
                    if (t.nodeType) return this[0] = t, this;
                    throw new Error("Not a DOM node.")
                },
                offset: function() {
                    var e = this[0].getBoundingClientRect ? this[0].getBoundingClientRect() : {
                        top: 0,
                        left: 0
                    };
                    return {
                        top: e.top + (t.pageYOffset || document.scrollTop || 0) - (document.clientTop || 0),
                        left: e.left + (t.pageXOffset || document.scrollLeft || 0) - (document.clientLeft || 0)
                    }
                },
                position: function() {
                    function t() {
                        for (var t = this.offsetParent || document; t && "html" === !t.nodeType.toLowerCase && "static" === t.style.position;) t = t.offsetParent;
                        return t || document
                    }
                    var e = this[0],
                        t = t.apply(e),
                        n = this.offset(),
                        a = /^(?:body|html)$/i.test(t.nodeName) ? {
                            top: 0,
                            left: 0
                        } : i(t).offset();
                    return n.top -= parseFloat(e.style.marginTop) || 0, n.left -= parseFloat(e.style.marginLeft) || 0, t.style && (a.top += parseFloat(t.style.borderTopWidth) || 0, a.left += parseFloat(t.style.borderLeftWidth) || 0), {
                        top: n.top - a.top,
                        left: n.left - a.left
                    }
                }
            };
            var n = {};
            i.expando = "velocity" + (new Date).getTime(), i.uuid = 0;
            for (var a = {}, o = a.hasOwnProperty, s = a.toString, r = "Boolean Number String Function Array Date RegExp Object Error".split(" "), l = 0; l < r.length; l++) a["[object " + r[l] + "]"] = r[l].toLowerCase();
            i.fn.init.prototype = i.fn, t.Velocity = {
                Utilities: i
            }
        }
    }(window), function(t) {
        "object" == typeof module && "object" == typeof module.exports ? module.exports = t() : "function" == typeof define && define.amd ? define(t) : t()
    }(function() {
        return function(t, e, i, n) {
            function a(t) {
                for (var e = -1, i = t ? t.length : 0, n = []; ++e < i;) {
                    var a = t[e];
                    a && n.push(a)
                }
                return n
            }

            function o(t) {
                return m.isWrapped(t) ? t = [].slice.call(t) : m.isNode(t) && (t = [t]), t
            }

            function s(t) {
                var e = h.data(t, "velocity");
                return null === e ? n : e
            }

            function r(t) {
                return function(e) {
                    return Math.round(e * t) * (1 / t)
                }
            }

            function l(t, i, n, a) {
                function o(t, e) {
                    return 1 - 3 * e + 3 * t
                }

                function s(t, e) {
                    return 3 * e - 6 * t
                }

                function r(t) {
                    return 3 * t
                }

                function l(t, e, i) {
                    return ((o(e, i) * t + s(e, i)) * t + r(e)) * t
                }

                function u(t, e, i) {
                    return 3 * o(e, i) * t * t + 2 * s(e, i) * t + r(e)
                }

                function c(e, i) {
                    for (var a = 0; m > a; ++a) {
                        var o = u(i, t, n);
                        if (0 === o) return i;
                        var s = l(i, t, n) - e;
                        i -= s / o
                    }
                    return i
                }

                function d() {
                    for (var e = 0; w > e; ++e) x[e] = l(e * b, t, n)
                }

                function h(e, i, a) {
                    var o, s, r = 0;
                    do s = i + (a - i) / 2, o = l(s, t, n) - e, o > 0 ? a = s : i = s; while (Math.abs(o) > v && ++r < y);
                    return s
                }

                function f(e) {
                    for (var i = 0, a = 1, o = w - 1; a != o && x[a] <= e; ++a) i += b;
                    --a;
                    var s = (e - x[a]) / (x[a + 1] - x[a]),
                        r = i + s * b,
                        l = u(r, t, n);
                    return l >= g ? c(e, r) : 0 == l ? r : h(e, i, i + b)
                }

                function p() {
                    S = !0, (t != i || n != a) && d()
                }
                var m = 4,
                    g = .001,
                    v = 1e-7,
                    y = 10,
                    w = 11,
                    b = 1 / (w - 1),
                    _ = "Float32Array" in e;
                if (4 !== arguments.length) return !1;
                for (var C = 0; 4 > C; ++C)
                    if ("number" != typeof arguments[C] || isNaN(arguments[C]) || !isFinite(arguments[C])) return !1;
                t = Math.min(t, 1), n = Math.min(n, 1), t = Math.max(t, 0), n = Math.max(n, 0);
                var x = _ ? new Float32Array(w) : new Array(w),
                    S = !1,
                    k = function(e) {
                        return S || p(), t === i && n === a ? e : 0 === e ? 0 : 1 === e ? 1 : l(f(e), i, a)
                    };
                k.getControlPoints = function() {
                    return [{
                        x: t,
                        y: i
                    }, {
                        x: n,
                        y: a
                    }]
                };
                var T = "generateBezier(" + [t, i, n, a] + ")";
                return k.toString = function() {
                    return T
                }, k
            }

            function u(t, e) {
                var i = t;
                return m.isString(t) ? w.Easings[t] || (i = !1) : i = m.isArray(t) && 1 === t.length ? r.apply(null, t) : m.isArray(t) && 2 === t.length ? b.apply(null, t.concat([e])) : m.isArray(t) && 4 === t.length ? l.apply(null, t) : !1, i === !1 && (i = w.Easings[w.defaults.easing] ? w.defaults.easing : y), i
            }

            function c(t) {
                if (t) {
                    var e = (new Date).getTime(),
                        i = w.State.calls.length;
                    i > 1e4 && (w.State.calls = a(w.State.calls));
                    for (var o = 0; i > o; o++)
                        if (w.State.calls[o]) {
                            var r = w.State.calls[o],
                                l = r[0],
                                u = r[2],
                                f = r[3],
                                p = !!f,
                                g = null;
                            f || (f = w.State.calls[o][3] = e - 16);
                            for (var v = Math.min((e - f) / u.duration, 1), y = 0, b = l.length; b > y; y++) {
                                var C = l[y],
                                    S = C.element;
                                if (s(S)) {
                                    var k = !1;
                                    if (u.display !== n && null !== u.display && "none" !== u.display) {
                                        if ("flex" === u.display) {
                                            var T = ["-webkit-box", "-moz-box", "-ms-flexbox", "-webkit-flex"];
                                            h.each(T, function(t, e) {
                                                _.setPropertyValue(S, "display", e)
                                            })
                                        }
                                        _.setPropertyValue(S, "display", u.display)
                                    }
                                    u.visibility !== n && "hidden" !== u.visibility && _.setPropertyValue(S, "visibility", u.visibility);
                                    for (var M in C)
                                        if ("element" !== M) {
                                            var P, O = C[M],
                                                D = m.isString(O.easing) ? w.Easings[O.easing] : O.easing;
                                            if (1 === v) P = O.endValue;
                                            else {
                                                var L = O.endValue - O.startValue;
                                                if (P = O.startValue + L * D(v, u, L), !p && P === O.currentValue) continue
                                            }
                                            if (O.currentValue = P, "tween" === M) g = P;
                                            else {
                                                if (_.Hooks.registered[M]) {
                                                    var E = _.Hooks.getRoot(M),
                                                        F = s(S).rootPropertyValueCache[E];
                                                    F && (O.rootPropertyValue = F)
                                                }
                                                var A = _.setPropertyValue(S, M, O.currentValue + (0 === parseFloat(P) ? "" : O.unitType), O.rootPropertyValue, O.scrollData);
                                                _.Hooks.registered[M] && (s(S).rootPropertyValueCache[E] = _.Normalizations.registered[E] ? _.Normalizations.registered[E]("extract", null, A[1]) : A[1]), "transform" === A[0] && (k = !0)
                                            }
                                        }
                                    u.mobileHA && s(S).transformCache.translate3d === n && (s(S).transformCache.translate3d = "(0px, 0px, 0px)", k = !0), k && _.flushTransformCache(S)
                                }
                            }
                            u.display !== n && "none" !== u.display && (w.State.calls[o][2].display = !1), u.visibility !== n && "hidden" !== u.visibility && (w.State.calls[o][2].visibility = !1), u.progress && u.progress.call(r[1], r[1], v, Math.max(0, f + u.duration - e), f, g), 1 === v && d(o)
                        }
                }
                w.State.isTicking && x(c)
            }

            function d(t, e) {
                if (!w.State.calls[t]) return !1;
                for (var i = w.State.calls[t][0], a = w.State.calls[t][1], o = w.State.calls[t][2], r = w.State.calls[t][4], l = !1, u = 0, c = i.length; c > u; u++) {
                    var d = i[u].element;
                    if (e || o.loop || ("none" === o.display && _.setPropertyValue(d, "display", o.display), "hidden" === o.visibility && _.setPropertyValue(d, "visibility", o.visibility)), o.loop !== !0 && (h.queue(d)[1] === n || !/\.velocityQueueEntryFlag/i.test(h.queue(d)[1])) && s(d)) {
                        s(d).isAnimating = !1, s(d).rootPropertyValueCache = {};
                        var f = !1;
                        h.each(_.Lists.transforms3D, function(t, e) {
                            var i = /^scale/.test(e) ? 1 : 0,
                                a = s(d).transformCache[e];
                            s(d).transformCache[e] !== n && new RegExp("^\\(" + i + "[^.]").test(a) && (f = !0, delete s(d).transformCache[e])
                        }), o.mobileHA && (f = !0, delete s(d).transformCache.translate3d), f && _.flushTransformCache(d), _.Values.removeClass(d, "velocity-animating")
                    }
                    if (!e && o.complete && !o.loop && u === c - 1) try {
                        o.complete.call(a, a)
                    } catch (p) {
                        setTimeout(function() {
                            throw p
                        }, 1)
                    }
                    r && o.loop !== !0 && r(a), s(d) && o.loop === !0 && !e && (h.each(s(d).tweensContainer, function(t, e) {
                        /^rotate/.test(t) && 360 === parseFloat(e.endValue) && (e.endValue = 0, e.startValue = 360), /^backgroundPosition/.test(t) && 100 === parseFloat(e.endValue) && "%" === e.unitType && (e.endValue = 0, e.startValue = 100)
                    }), w(d, "reverse", {
                        loop: !0,
                        delay: o.delay
                    })), o.queue !== !1 && h.dequeue(d, o.queue)
                }
                w.State.calls[t] = !1;
                for (var m = 0, g = w.State.calls.length; g > m; m++)
                    if (w.State.calls[m] !== !1) {
                        l = !0;
                        break
                    }
                l === !1 && (w.State.isTicking = !1, delete w.State.calls, w.State.calls = [])
            }
            var h, f = function() {
                    if (i.documentMode) return i.documentMode;
                    for (var t = 7; t > 4; t--) {
                        var e = i.createElement("div");
                        if (e.innerHTML = "<!--[if IE " + t + "]><span></span><![endif]-->", e.getElementsByTagName("span").length) return e = null, t
                    }
                    return n
                }(),
                p = function() {
                    var t = 0;
                    return e.webkitRequestAnimationFrame || e.mozRequestAnimationFrame || function(e) {
                        var i, n = (new Date).getTime();
                        return i = Math.max(0, 16 - (n - t)), t = n + i, setTimeout(function() {
                            e(n + i)
                        }, i)
                    }
                }(),
                m = {
                    isString: function(t) {
                        return "string" == typeof t
                    },
                    isArray: Array.isArray || function(t) {
                        return "[object Array]" === Object.prototype.toString.call(t)
                    },
                    isFunction: function(t) {
                        return "[object Function]" === Object.prototype.toString.call(t)
                    },
                    isNode: function(t) {
                        return t && t.nodeType
                    },
                    isNodeList: function(t) {
                        return "object" == typeof t && /^\[object (HTMLCollection|NodeList|Object)\]$/.test(Object.prototype.toString.call(t)) && t.length !== n && (0 === t.length || "object" == typeof t[0] && t[0].nodeType > 0)
                    },
                    isWrapped: function(t) {
                        return t && (t.jquery || e.Zepto && e.Zepto.zepto.isZ(t))
                    },
                    isSVG: function(t) {
                        return e.SVGElement && t instanceof e.SVGElement
                    },
                    isEmptyObject: function(t) {
                        for (var e in t) return !1;
                        return !0
                    }
                },
                g = !1;
            if (t.fn && t.fn.jquery ? (h = t, g = !0) : h = e.Velocity.Utilities, 8 >= f && !g) throw new Error("Velocity: IE8 and below require jQuery to be loaded before Velocity.");
            if (7 >= f) return void(jQuery.fn.velocity = jQuery.fn.animate);
            var v = 400,
                y = "swing",
                w = {
                    State: {
                        isMobile: /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),
                        isAndroid: /Android/i.test(navigator.userAgent),
                        isGingerbread: /Android 2\.3\.[3-7]/i.test(navigator.userAgent),
                        isChrome: e.chrome,
                        isFirefox: /Firefox/i.test(navigator.userAgent),
                        prefixElement: i.createElement("div"),
                        prefixMatches: {},
                        scrollAnchor: null,
                        scrollPropertyLeft: null,
                        scrollPropertyTop: null,
                        isTicking: !1,
                        calls: []
                    },
                    CSS: {},
                    Utilities: h,
                    Redirects: {},
                    Easings: {},
                    Promise: e.Promise,
                    defaults: {
                        queue: "",
                        duration: v,
                        easing: y,
                        begin: n,
                        complete: n,
                        progress: n,
                        display: n,
                        visibility: n,
                        loop: !1,
                        delay: !1,
                        mobileHA: !0,
                        _cacheValues: !0
                    },
                    init: function(t) {
                        h.data(t, "velocity", {
                            isSVG: m.isSVG(t),
                            isAnimating: !1,
                            computedStyle: null,
                            tweensContainer: null,
                            rootPropertyValueCache: {},
                            transformCache: {}
                        })
                    },
                    hook: null,
                    mock: !1,
                    version: {
                        major: 1,
                        minor: 2,
                        patch: 2
                    },
                    debug: !1
                };
            e.pageYOffset !== n ? (w.State.scrollAnchor = e, w.State.scrollPropertyLeft = "pageXOffset", w.State.scrollPropertyTop = "pageYOffset") : (w.State.scrollAnchor = i.documentElement || i.body.parentNode || i.body, w.State.scrollPropertyLeft = "scrollLeft", w.State.scrollPropertyTop = "scrollTop");
            var b = function() {
                function t(t) {
                    return -t.tension * t.x - t.friction * t.v
                }

                function e(e, i, n) {
                    var a = {
                        x: e.x + n.dx * i,
                        v: e.v + n.dv * i,
                        tension: e.tension,
                        friction: e.friction
                    };
                    return {
                        dx: a.v,
                        dv: t(a)
                    }
                }

                function i(i, n) {
                    var a = {
                            dx: i.v,
                            dv: t(i)
                        },
                        o = e(i, .5 * n, a),
                        s = e(i, .5 * n, o),
                        r = e(i, n, s),
                        l = 1 / 6 * (a.dx + 2 * (o.dx + s.dx) + r.dx),
                        u = 1 / 6 * (a.dv + 2 * (o.dv + s.dv) + r.dv);
                    return i.x = i.x + l * n, i.v = i.v + u * n, i
                }
                return function n(t, e, a) {
                    var o, s, r, l = {
                            x: -1,
                            v: 0,
                            tension: null,
                            friction: null
                        },
                        u = [0],
                        c = 0,
                        d = 1e-4,
                        h = .016;
                    for (t = parseFloat(t) || 500, e = parseFloat(e) || 20, a = a || null, l.tension = t, l.friction = e, o = null !== a, o ? (c = n(t, e), s = c / a * h) : s = h; r = i(r || l, s), u.push(1 + r.x), c += 16, Math.abs(r.x) > d && Math.abs(r.v) > d;);
                    return o ? function(t) {
                        return u[t * (u.length - 1) | 0]
                    } : c
                }
            }();
            w.Easings = {
                linear: function(t) {
                    return t
                },
                swing: function(t) {
                    return .5 - Math.cos(t * Math.PI) / 2
                },
                spring: function(t) {
                    return 1 - Math.cos(4.5 * t * Math.PI) * Math.exp(6 * -t)
                }
            }, h.each([
                ["ease", [.25, .1, .25, 1]],
                ["ease-in", [.42, 0, 1, 1]],
                ["ease-out", [0, 0, .58, 1]],
                ["ease-in-out", [.42, 0, .58, 1]],
                ["easeInSine", [.47, 0, .745, .715]],
                ["easeOutSine", [.39, .575, .565, 1]],
                ["easeInOutSine", [.445, .05, .55, .95]],
                ["easeInQuad", [.55, .085, .68, .53]],
                ["easeOutQuad", [.25, .46, .45, .94]],
                ["easeInOutQuad", [.455, .03, .515, .955]],
                ["easeInCubic", [.55, .055, .675, .19]],
                ["easeOutCubic", [.215, .61, .355, 1]],
                ["easeInOutCubic", [.645, .045, .355, 1]],
                ["easeInQuart", [.895, .03, .685, .22]],
                ["easeOutQuart", [.165, .84, .44, 1]],
                ["easeInOutQuart", [.77, 0, .175, 1]],
                ["easeInQuint", [.755, .05, .855, .06]],
                ["easeOutQuint", [.23, 1, .32, 1]],
                ["easeInOutQuint", [.86, 0, .07, 1]],
                ["easeInExpo", [.95, .05, .795, .035]],
                ["easeOutExpo", [.19, 1, .22, 1]],
                ["easeInOutExpo", [1, 0, 0, 1]],
                ["easeInCirc", [.6, .04, .98, .335]],
                ["easeOutCirc", [.075, .82, .165, 1]],
                ["easeInOutCirc", [.785, .135, .15, .86]]
            ], function(t, e) {
                w.Easings[e[0]] = l.apply(null, e[1])
            });
            var _ = w.CSS = {
                RegEx: {
                    isHex: /^#([A-f\d]{3}){1,2}$/i,
                    valueUnwrap: /^[A-z]+\((.*)\)$/i,
                    wrappedValueAlreadyExtracted: /[0-9.]+ [0-9.]+ [0-9.]+( [0-9.]+)?/,
                    valueSplit: /([A-z]+\(.+\))|(([A-z0-9#-.]+?)(?=\s|$))/gi
                },
                Lists: {
                    colors: ["fill", "stroke", "stopColor", "color", "backgroundColor", "borderColor", "borderTopColor", "borderRightColor", "borderBottomColor", "borderLeftColor", "outlineColor"],
                    transformsBase: ["translateX", "translateY", "scale", "scaleX", "scaleY", "skewX", "skewY", "rotateZ"],
                    transforms3D: ["transformPerspective", "translateZ", "scaleZ", "rotateX", "rotateY"]
                },
                Hooks: {
                    templates: {
                        textShadow: ["Color X Y Blur", "black 0px 0px 0px"],
                        boxShadow: ["Color X Y Blur Spread", "black 0px 0px 0px 0px"],
                        clip: ["Top Right Bottom Left", "0px 0px 0px 0px"],
                        backgroundPosition: ["X Y", "0% 0%"],
                        transformOrigin: ["X Y Z", "50% 50% 0px"],
                        perspectiveOrigin: ["X Y", "50% 50%"]
                    },
                    registered: {},
                    register: function() {
                        for (var t = 0; t < _.Lists.colors.length; t++) {
                            var e = "color" === _.Lists.colors[t] ? "0 0 0 1" : "255 255 255 1";
                            _.Hooks.templates[_.Lists.colors[t]] = ["Red Green Blue Alpha", e]
                        }
                        var i, n, a;
                        if (f)
                            for (i in _.Hooks.templates) {
                                n = _.Hooks.templates[i], a = n[0].split(" ");
                                var o = n[1].match(_.RegEx.valueSplit);
                                "Color" === a[0] && (a.push(a.shift()), o.push(o.shift()), _.Hooks.templates[i] = [a.join(" "), o.join(" ")])
                            }
                        for (i in _.Hooks.templates) {
                            n = _.Hooks.templates[i], a = n[0].split(" ");
                            for (var t in a) {
                                var s = i + a[t],
                                    r = t;
                                _.Hooks.registered[s] = [i, r]
                            }
                        }
                    },
                    getRoot: function(t) {
                        var e = _.Hooks.registered[t];
                        return e ? e[0] : t
                    },
                    cleanRootPropertyValue: function(t, e) {
                        return _.RegEx.valueUnwrap.test(e) && (e = e.match(_.RegEx.valueUnwrap)[1]), _.Values.isCSSNullValue(e) && (e = _.Hooks.templates[t][1]), e
                    },
                    extractValue: function(t, e) {
                        var i = _.Hooks.registered[t];
                        if (i) {
                            var n = i[0],
                                a = i[1];
                            return e = _.Hooks.cleanRootPropertyValue(n, e), e.toString().match(_.RegEx.valueSplit)[a]
                        }
                        return e
                    },
                    injectValue: function(t, e, i) {
                        var n = _.Hooks.registered[t];
                        if (n) {
                            var a, o, s = n[0],
                                r = n[1];
                            return i = _.Hooks.cleanRootPropertyValue(s, i), a = i.toString().match(_.RegEx.valueSplit), a[r] = e, o = a.join(" ")
                        }
                        return i
                    }
                },
                Normalizations: {
                    registered: {
                        clip: function(t, e, i) {
                            switch (t) {
                                case "name":
                                    return "clip";
                                case "extract":
                                    var n;
                                    return _.RegEx.wrappedValueAlreadyExtracted.test(i) ? n = i : (n = i.toString().match(_.RegEx.valueUnwrap), n = n ? n[1].replace(/,(\s+)?/g, " ") : i), n;
                                case "inject":
                                    return "rect(" + i + ")"
                            }
                        },
                        blur: function(t, e, i) {
                            switch (t) {
                                case "name":
                                    return w.State.isFirefox ? "filter" : "-webkit-filter";
                                case "extract":
                                    var n = parseFloat(i);
                                    if (!n && 0 !== n) {
                                        var a = i.toString().match(/blur\(([0-9]+[A-z]+)\)/i);
                                        n = a ? a[1] : 0
                                    }
                                    return n;
                                case "inject":
                                    return parseFloat(i) ? "blur(" + i + ")" : "none"
                            }
                        },
                        opacity: function(t, e, i) {
                            if (8 >= f) switch (t) {
                                case "name":
                                    return "filter";
                                case "extract":
                                    var n = i.toString().match(/alpha\(opacity=(.*)\)/i);
                                    return i = n ? n[1] / 100 : 1;
                                case "inject":
                                    return e.style.zoom = 1, parseFloat(i) >= 1 ? "" : "alpha(opacity=" + parseInt(100 * parseFloat(i), 10) + ")"
                            } else switch (t) {
                                case "name":
                                    return "opacity";
                                case "extract":
                                    return i;
                                case "inject":
                                    return i
                            }
                        }
                    },
                    register: function() {
                        9 >= f || w.State.isGingerbread || (_.Lists.transformsBase = _.Lists.transformsBase.concat(_.Lists.transforms3D));
                        for (var t = 0; t < _.Lists.transformsBase.length; t++) ! function() {
                            var e = _.Lists.transformsBase[t];
                            _.Normalizations.registered[e] = function(t, i, a) {
                                switch (t) {
                                    case "name":
                                        return "transform";
                                    case "extract":
                                        return s(i) === n || s(i).transformCache[e] === n ? /^scale/i.test(e) ? 1 : 0 : s(i).transformCache[e].replace(/[()]/g, "");
                                    case "inject":
                                        var o = !1;
                                        switch (e.substr(0, e.length - 1)) {
                                            case "translate":
                                                o = !/(%|px|em|rem|vw|vh|\d)$/i.test(a);
                                                break;
                                            case "scal":
                                            case "scale":
                                                w.State.isAndroid && s(i).transformCache[e] === n && 1 > a && (a = 1), o = !/(\d)$/i.test(a);
                                                break;
                                            case "skew":
                                                o = !/(deg|\d)$/i.test(a);
                                                break;
                                            case "rotate":
                                                o = !/(deg|\d)$/i.test(a)
                                        }
                                        return o || (s(i).transformCache[e] = "(" + a + ")"), s(i).transformCache[e]
                                }
                            }
                        }();
                        for (var t = 0; t < _.Lists.colors.length; t++) ! function() {
                            var e = _.Lists.colors[t];
                            _.Normalizations.registered[e] = function(t, i, a) {
                                switch (t) {
                                    case "name":
                                        return e;
                                    case "extract":
                                        var o;
                                        if (_.RegEx.wrappedValueAlreadyExtracted.test(a)) o = a;
                                        else {
                                            var s, r = {
                                                black: "rgb(0, 0, 0)",
                                                blue: "rgb(0, 0, 255)",
                                                gray: "rgb(128, 128, 128)",
                                                green: "rgb(0, 128, 0)",
                                                red: "rgb(255, 0, 0)",
                                                white: "rgb(255, 255, 255)"
                                            };
                                            /^[A-z]+$/i.test(a) ? s = r[a] !== n ? r[a] : r.black : _.RegEx.isHex.test(a) ? s = "rgb(" + _.Values.hexToRgb(a).join(" ") + ")" : /^rgba?\(/i.test(a) || (s = r.black), o = (s || a).toString().match(_.RegEx.valueUnwrap)[1].replace(/,(\s+)?/g, " ")
                                        }
                                        return 8 >= f || 3 !== o.split(" ").length || (o += " 1"), o;
                                    case "inject":
                                        return 8 >= f ? 4 === a.split(" ").length && (a = a.split(/\s+/).slice(0, 3).join(" ")) : 3 === a.split(" ").length && (a += " 1"), (8 >= f ? "rgb" : "rgba") + "(" + a.replace(/\s+/g, ",").replace(/\.(\d)+(?=,)/g, "") + ")"
                                }
                            }
                        }()
                    }
                },
                Names: {
                    camelCase: function(t) {
                        return t.replace(/-(\w)/g, function(t, e) {
                            return e.toUpperCase()
                        })
                    },
                    SVGAttribute: function(t) {
                        var e = "width|height|x|y|cx|cy|r|rx|ry|x1|x2|y1|y2";
                        return (f || w.State.isAndroid && !w.State.isChrome) && (e += "|transform"), new RegExp("^(" + e + ")$", "i").test(t)
                    },
                    prefixCheck: function(t) {
                        if (w.State.prefixMatches[t]) return [w.State.prefixMatches[t], !0];
                        for (var e = ["", "Webkit", "Moz", "ms", "O"], i = 0, n = e.length; n > i; i++) {
                            var a;
                            if (a = 0 === i ? t : e[i] + t.replace(/^\w/, function(t) {
                                    return t.toUpperCase()
                                }), m.isString(w.State.prefixElement.style[a])) return w.State.prefixMatches[t] = a, [a, !0]
                        }
                        return [t, !1]
                    }
                },
                Values: {
                    hexToRgb: function(t) {
                        var e, i = /^#?([a-f\d])([a-f\d])([a-f\d])$/i,
                            n = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i;
                        return t = t.replace(i, function(t, e, i, n) {
                            return e + e + i + i + n + n
                        }), e = n.exec(t), e ? [parseInt(e[1], 16), parseInt(e[2], 16), parseInt(e[3], 16)] : [0, 0, 0]
                    },
                    isCSSNullValue: function(t) {
                        return 0 == t || /^(none|auto|transparent|(rgba\(0, ?0, ?0, ?0\)))$/i.test(t)
                    },
                    getUnitType: function(t) {
                        return /^(rotate|skew)/i.test(t) ? "deg" : /(^(scale|scaleX|scaleY|scaleZ|alpha|flexGrow|flexHeight|zIndex|fontWeight)$)|((opacity|red|green|blue|alpha)$)/i.test(t) ? "" : "px"
                    },
                    getDisplayType: function(t) {
                        var e = t && t.tagName.toString().toLowerCase();
                        return /^(b|big|i|small|tt|abbr|acronym|cite|code|dfn|em|kbd|strong|samp|var|a|bdo|br|img|map|object|q|script|span|sub|sup|button|input|label|select|textarea)$/i.test(e) ? "inline" : /^(li)$/i.test(e) ? "list-item" : /^(tr)$/i.test(e) ? "table-row" : /^(table)$/i.test(e) ? "table" : /^(tbody)$/i.test(e) ? "table-row-group" : "block"
                    },
                    addClass: function(t, e) {
                        t.classList ? t.classList.add(e) : t.className += (t.className.length ? " " : "") + e
                    },
                    removeClass: function(t, e) {
                        t.classList ? t.classList.remove(e) : t.className = t.className.toString().replace(new RegExp("(^|\\s)" + e.split(" ").join("|") + "(\\s|$)", "gi"), " ")
                    }
                },
                getPropertyValue: function(t, i, a, o) {
                    function r(t, i) {
                        function a() {
                            u && _.setPropertyValue(t, "display", "none")
                        }
                        var l = 0;
                        if (8 >= f) l = h.css(t, i);
                        else {
                            var u = !1;
                            if (/^(width|height)$/.test(i) && 0 === _.getPropertyValue(t, "display") && (u = !0, _.setPropertyValue(t, "display", _.Values.getDisplayType(t))), !o) {
                                if ("height" === i && "border-box" !== _.getPropertyValue(t, "boxSizing").toString().toLowerCase()) {
                                    var c = t.offsetHeight - (parseFloat(_.getPropertyValue(t, "borderTopWidth")) || 0) - (parseFloat(_.getPropertyValue(t, "borderBottomWidth")) || 0) - (parseFloat(_.getPropertyValue(t, "paddingTop")) || 0) - (parseFloat(_.getPropertyValue(t, "paddingBottom")) || 0);
                                    return a(), c
                                }
                                if ("width" === i && "border-box" !== _.getPropertyValue(t, "boxSizing").toString().toLowerCase()) {
                                    var d = t.offsetWidth - (parseFloat(_.getPropertyValue(t, "borderLeftWidth")) || 0) - (parseFloat(_.getPropertyValue(t, "borderRightWidth")) || 0) - (parseFloat(_.getPropertyValue(t, "paddingLeft")) || 0) - (parseFloat(_.getPropertyValue(t, "paddingRight")) || 0);
                                    return a(), d
                                }
                            }
                            var p;
                            p = s(t) === n ? e.getComputedStyle(t, null) : s(t).computedStyle ? s(t).computedStyle : s(t).computedStyle = e.getComputedStyle(t, null), "borderColor" === i && (i = "borderTopColor"), l = 9 === f && "filter" === i ? p.getPropertyValue(i) : p[i], ("" === l || null === l) && (l = t.style[i]), a()
                        }
                        if ("auto" === l && /^(top|right|bottom|left)$/i.test(i)) {
                            var m = r(t, "position");
                            ("fixed" === m || "absolute" === m && /top|left/i.test(i)) && (l = h(t).position()[i] + "px")
                        }
                        return l
                    }
                    var l;
                    if (_.Hooks.registered[i]) {
                        var u = i,
                            c = _.Hooks.getRoot(u);
                        a === n && (a = _.getPropertyValue(t, _.Names.prefixCheck(c)[0])), _.Normalizations.registered[c] && (a = _.Normalizations.registered[c]("extract", t, a)), l = _.Hooks.extractValue(u, a)
                    } else if (_.Normalizations.registered[i]) {
                        var d, p;
                        d = _.Normalizations.registered[i]("name", t), "transform" !== d && (p = r(t, _.Names.prefixCheck(d)[0]), _.Values.isCSSNullValue(p) && _.Hooks.templates[i] && (p = _.Hooks.templates[i][1])), l = _.Normalizations.registered[i]("extract", t, p)
                    }
                    if (!/^[\d-]/.test(l))
                        if (s(t) && s(t).isSVG && _.Names.SVGAttribute(i))
                            if (/^(height|width)$/i.test(i)) try {
                                l = t.getBBox()[i]
                            } catch (m) {
                                l = 0
                            } else l = t.getAttribute(i);
                            else l = r(t, _.Names.prefixCheck(i)[0]);
                    return _.Values.isCSSNullValue(l) && (l = 0), w.debug >= 2 && console.log("Get " + i + ": " + l), l
                },
                setPropertyValue: function(t, i, n, a, o) {
                    var r = i;
                    if ("scroll" === i) o.container ? o.container["scroll" + o.direction] = n : "Left" === o.direction ? e.scrollTo(n, o.alternateValue) : e.scrollTo(o.alternateValue, n);
                    else if (_.Normalizations.registered[i] && "transform" === _.Normalizations.registered[i]("name", t)) _.Normalizations.registered[i]("inject", t, n), r = "transform", n = s(t).transformCache[i];
                    else {
                        if (_.Hooks.registered[i]) {
                            var l = i,
                                u = _.Hooks.getRoot(i);
                            a = a || _.getPropertyValue(t, u), n = _.Hooks.injectValue(l, n, a), i = u
                        }
                        if (_.Normalizations.registered[i] && (n = _.Normalizations.registered[i]("inject", t, n), i = _.Normalizations.registered[i]("name", t)), r = _.Names.prefixCheck(i)[0], 8 >= f) try {
                            t.style[r] = n
                        } catch (c) {
                            w.debug && console.log("Browser does not support [" + n + "] for [" + r + "]")
                        } else s(t) && s(t).isSVG && _.Names.SVGAttribute(i) ? t.setAttribute(i, n) : t.style[r] = n;
                        w.debug >= 2 && console.log("Set " + i + " (" + r + "): " + n)
                    }
                    return [r, n]
                },
                flushTransformCache: function(t) {
                    function e(e) {
                        return parseFloat(_.getPropertyValue(t, e))
                    }
                    var i = "";
                    if ((f || w.State.isAndroid && !w.State.isChrome) && s(t).isSVG) {
                        var n = {
                            translate: [e("translateX"), e("translateY")],
                            skewX: [e("skewX")],
                            skewY: [e("skewY")],
                            scale: 1 !== e("scale") ? [e("scale"), e("scale")] : [e("scaleX"), e("scaleY")],
                            rotate: [e("rotateZ"), 0, 0]
                        };
                        h.each(s(t).transformCache, function(t) {
                            /^translate/i.test(t) ? t = "translate" : /^scale/i.test(t) ? t = "scale" : /^rotate/i.test(t) && (t = "rotate"), n[t] && (i += t + "(" + n[t].join(" ") + ") ", delete n[t])
                        })
                    } else {
                        var a, o;
                        h.each(s(t).transformCache, function(e) {
                            return a = s(t).transformCache[e], "transformPerspective" === e ? (o = a, !0) : (9 === f && "rotateZ" === e && (e = "rotate"), void(i += e + a + " "))
                        }), o && (i = "perspective" + o + " " + i)
                    }
                    _.setPropertyValue(t, "transform", i)
                }
            };
            _.Hooks.register(), _.Normalizations.register(), w.hook = function(t, e, i) {
                var a = n;
                return t = o(t), h.each(t, function(t, o) {
                    if (s(o) === n && w.init(o), i === n) a === n && (a = w.CSS.getPropertyValue(o, e));
                    else {
                        var r = w.CSS.setPropertyValue(o, e, i);
                        "transform" === r[0] && w.CSS.flushTransformCache(o), a = r
                    }
                }), a
            };
            var C = function() {
                function t() {
                    return r ? M.promise || null : l
                }

                function a() {
                    function t(t) {
                        function d(t, e) {
                            var i = n,
                                a = n,
                                s = n;
                            return m.isArray(t) ? (i = t[0], !m.isArray(t[1]) && /^[\d-]/.test(t[1]) || m.isFunction(t[1]) || _.RegEx.isHex.test(t[1]) ? s = t[1] : (m.isString(t[1]) && !_.RegEx.isHex.test(t[1]) || m.isArray(t[1])) && (a = e ? t[1] : u(t[1], r.duration), t[2] !== n && (s = t[2]))) : i = t, e || (a = a || r.easing), m.isFunction(i) && (i = i.call(o, S, x)), m.isFunction(s) && (s = s.call(o, S, x)), [i || 0, a, s]
                        }

                        function f(t, e) {
                            var i, n;
                            return n = (e || "0").toString().toLowerCase().replace(/[%A-z]+$/, function(t) {
                                return i = t, ""
                            }), i || (i = _.Values.getUnitType(t)), [n, i]
                        }

                        function v() {
                            var t = {
                                    myParent: o.parentNode || i.body,
                                    position: _.getPropertyValue(o, "position"),
                                    fontSize: _.getPropertyValue(o, "fontSize")
                                },
                                n = t.position === A.lastPosition && t.myParent === A.lastParent,
                                a = t.fontSize === A.lastFontSize;
                            A.lastParent = t.myParent, A.lastPosition = t.position, A.lastFontSize = t.fontSize;
                            var r = 100,
                                l = {};
                            if (a && n) l.emToPx = A.lastEmToPx, l.percentToPxWidth = A.lastPercentToPxWidth, l.percentToPxHeight = A.lastPercentToPxHeight;
                            else {
                                var u = s(o).isSVG ? i.createElementNS("http://www.w3.org/2000/svg", "rect") : i.createElement("div");
                                w.init(u), t.myParent.appendChild(u), h.each(["overflow", "overflowX", "overflowY"], function(t, e) {
                                    w.CSS.setPropertyValue(u, e, "hidden")
                                }), w.CSS.setPropertyValue(u, "position", t.position), w.CSS.setPropertyValue(u, "fontSize", t.fontSize), w.CSS.setPropertyValue(u, "boxSizing", "content-box"), h.each(["minWidth", "maxWidth", "width", "minHeight", "maxHeight", "height"], function(t, e) {
                                    w.CSS.setPropertyValue(u, e, r + "%")
                                }), w.CSS.setPropertyValue(u, "paddingLeft", r + "em"), l.percentToPxWidth = A.lastPercentToPxWidth = (parseFloat(_.getPropertyValue(u, "width", null, !0)) || 1) / r, l.percentToPxHeight = A.lastPercentToPxHeight = (parseFloat(_.getPropertyValue(u, "height", null, !0)) || 1) / r, l.emToPx = A.lastEmToPx = (parseFloat(_.getPropertyValue(u, "paddingLeft")) || 1) / r, t.myParent.removeChild(u)
                            }
                            return null === A.remToPx && (A.remToPx = parseFloat(_.getPropertyValue(i.body, "fontSize")) || 16), null === A.vwToPx && (A.vwToPx = parseFloat(e.innerWidth) / 100, A.vhToPx = parseFloat(e.innerHeight) / 100), l.remToPx = A.remToPx, l.vwToPx = A.vwToPx, l.vhToPx = A.vhToPx, w.debug >= 1 && console.log("Unit ratios: " + JSON.stringify(l), o), l
                        }
                        if (r.begin && 0 === S) try {
                            r.begin.call(p, p)
                        } catch (b) {
                            setTimeout(function() {
                                throw b
                            }, 1)
                        }
                        if ("scroll" === P) {
                            var C, k, T, O = /^x$/i.test(r.axis) ? "Left" : "Top",
                                D = parseFloat(r.offset) || 0;
                            r.container ? m.isWrapped(r.container) || m.isNode(r.container) ? (r.container = r.container[0] || r.container, C = r.container["scroll" + O], T = C + h(o).position()[O.toLowerCase()] + D) : r.container = null : (C = w.State.scrollAnchor[w.State["scrollProperty" + O]], k = w.State.scrollAnchor[w.State["scrollProperty" + ("Left" === O ? "Top" : "Left")]], T = h(o).offset()[O.toLowerCase()] + D), l = {
                                scroll: {
                                    rootPropertyValue: !1,
                                    startValue: C,
                                    currentValue: C,
                                    endValue: T,
                                    unitType: "",
                                    easing: r.easing,
                                    scrollData: {
                                        container: r.container,
                                        direction: O,
                                        alternateValue: k
                                    }
                                },
                                element: o
                            }, w.debug && console.log("tweensContainer (scroll): ", l.scroll, o)
                        } else if ("reverse" === P) {
                            if (!s(o).tweensContainer) return void h.dequeue(o, r.queue);
                            "none" === s(o).opts.display && (s(o).opts.display = "auto"), "hidden" === s(o).opts.visibility && (s(o).opts.visibility = "visible"), s(o).opts.loop = !1, s(o).opts.begin = null, s(o).opts.complete = null, y.easing || delete r.easing, y.duration || delete r.duration, r = h.extend({}, s(o).opts, r);
                            var L = h.extend(!0, {}, s(o).tweensContainer);
                            for (var E in L)
                                if ("element" !== E) {
                                    var F = L[E].startValue;
                                    L[E].startValue = L[E].currentValue = L[E].endValue, L[E].endValue = F, m.isEmptyObject(y) || (L[E].easing = r.easing), w.debug && console.log("reverse tweensContainer (" + E + "): " + JSON.stringify(L[E]), o)
                                }
                            l = L
                        } else if ("start" === P) {
                            var L;
                            s(o).tweensContainer && s(o).isAnimating === !0 && (L = s(o).tweensContainer), h.each(g, function(t, e) {
                                if (RegExp("^" + _.Lists.colors.join("$|^") + "$").test(t)) {
                                    var i = d(e, !0),
                                        a = i[0],
                                        o = i[1],
                                        s = i[2];
                                    if (_.RegEx.isHex.test(a)) {
                                        for (var r = ["Red", "Green", "Blue"], l = _.Values.hexToRgb(a), u = s ? _.Values.hexToRgb(s) : n, c = 0; c < r.length; c++) {
                                            var h = [l[c]];
                                            o && h.push(o), u !== n && h.push(u[c]), g[t + r[c]] = h
                                        }
                                        delete g[t]
                                    }
                                }
                            });
                            for (var q in g) {
                                var j = d(g[q]),
                                    N = j[0],
                                    V = j[1],
                                    z = j[2];
                                q = _.Names.camelCase(q);
                                var H = _.Hooks.getRoot(q),
                                    R = !1;
                                if (s(o).isSVG || "tween" === H || _.Names.prefixCheck(H)[1] !== !1 || _.Normalizations.registered[H] !== n) {
                                    (r.display !== n && null !== r.display && "none" !== r.display || r.visibility !== n && "hidden" !== r.visibility) && /opacity|filter/.test(q) && !z && 0 !== N && (z = 0), r._cacheValues && L && L[q] ? (z === n && (z = L[q].endValue + L[q].unitType), R = s(o).rootPropertyValueCache[H]) : _.Hooks.registered[q] ? z === n ? (R = _.getPropertyValue(o, H), z = _.getPropertyValue(o, q, R)) : R = _.Hooks.templates[H][1] : z === n && (z = _.getPropertyValue(o, q));
                                    var B, Q, W, X = !1;
                                    if (B = f(q, z), z = B[0], W = B[1], B = f(q, N), N = B[0].replace(/^([+-\/*])=/, function(t, e) {
                                            return X = e, ""
                                        }), Q = B[1], z = parseFloat(z) || 0, N = parseFloat(N) || 0, "%" === Q && (/^(fontSize|lineHeight)$/.test(q) ? (N /= 100, Q = "em") : /^scale/.test(q) ? (N /= 100, Q = "") : /(Red|Green|Blue)$/i.test(q) && (N = N / 100 * 255, Q = "")), /[\/*]/.test(X)) Q = W;
                                    else if (W !== Q && 0 !== z)
                                        if (0 === N) Q = W;
                                        else {
                                            a = a || v();
                                            var U = /margin|padding|left|right|width|text|word|letter/i.test(q) || /X$/.test(q) || "x" === q ? "x" : "y";
                                            switch (W) {
                                                case "%":
                                                    z *= "x" === U ? a.percentToPxWidth : a.percentToPxHeight;
                                                    break;
                                                case "px":
                                                    break;
                                                default:
                                                    z *= a[W + "ToPx"]
                                            }
                                            switch (Q) {
                                                case "%":
                                                    z *= 1 / ("x" === U ? a.percentToPxWidth : a.percentToPxHeight);
                                                    break;
                                                case "px":
                                                    break;
                                                default:
                                                    z *= 1 / a[Q + "ToPx"]
                                            }
                                        }
                                    switch (X) {
                                        case "+":
                                            N = z + N;
                                            break;
                                        case "-":
                                            N = z - N;
                                            break;
                                        case "*":
                                            N = z * N;
                                            break;
                                        case "/":
                                            N = z / N
                                    }
                                    l[q] = {
                                        rootPropertyValue: R,
                                        startValue: z,
                                        currentValue: z,
                                        endValue: N,
                                        unitType: Q,
                                        easing: V
                                    }, w.debug && console.log("tweensContainer (" + q + "): " + JSON.stringify(l[q]), o)
                                } else w.debug && console.log("Skipping [" + H + "] due to a lack of browser support.")
                            }
                            l.element = o
                        }
                        l.element && (_.Values.addClass(o, "velocity-animating"), I.push(l), "" === r.queue && (s(o).tweensContainer = l, s(o).opts = r), s(o).isAnimating = !0, S === x - 1 ? (w.State.calls.push([I, p, r, null, M.resolver]), w.State.isTicking === !1 && (w.State.isTicking = !0, c())) : S++)
                    }
                    var a, o = this,
                        r = h.extend({}, w.defaults, y),
                        l = {};
                    switch (s(o) === n && w.init(o), parseFloat(r.delay) && r.queue !== !1 && h.queue(o, r.queue, function(t) {
                        w.velocityQueueEntryFlag = !0, s(o).delayTimer = {
                            setTimeout: setTimeout(t, parseFloat(r.delay)),
                            next: t
                        }
                    }), r.duration.toString().toLowerCase()) {
                        case "fast":
                            r.duration = 200;
                            break;
                        case "normal":
                            r.duration = v;
                            break;
                        case "slow":
                            r.duration = 600;
                            break;
                        default:
                            r.duration = parseFloat(r.duration) || 1
                    }
                    w.mock !== !1 && (w.mock === !0 ? r.duration = r.delay = 1 : (r.duration *= parseFloat(w.mock) || 1, r.delay *= parseFloat(w.mock) || 1)), r.easing = u(r.easing, r.duration), r.begin && !m.isFunction(r.begin) && (r.begin = null), r.progress && !m.isFunction(r.progress) && (r.progress = null), r.complete && !m.isFunction(r.complete) && (r.complete = null), r.display !== n && null !== r.display && (r.display = r.display.toString().toLowerCase(), "auto" === r.display && (r.display = w.CSS.Values.getDisplayType(o))), r.visibility !== n && null !== r.visibility && (r.visibility = r.visibility.toString().toLowerCase()), r.mobileHA = r.mobileHA && w.State.isMobile && !w.State.isGingerbread, r.queue === !1 ? r.delay ? setTimeout(t, r.delay) : t() : h.queue(o, r.queue, function(e, i) {
                        return i === !0 ? (M.promise && M.resolver(p), !0) : (w.velocityQueueEntryFlag = !0, void t(e))
                    }), "" !== r.queue && "fx" !== r.queue || "inprogress" === h.queue(o)[0] || h.dequeue(o)
                }
                var r, l, f, p, g, y, b = arguments[0] && (arguments[0].p || h.isPlainObject(arguments[0].properties) && !arguments[0].properties.names || m.isString(arguments[0].properties));
                if (m.isWrapped(this) ? (r = !1, f = 0, p = this, l = this) : (r = !0, f = 1, p = b ? arguments[0].elements || arguments[0].e : arguments[0]), p = o(p)) {
                    b ? (g = arguments[0].properties || arguments[0].p, y = arguments[0].options || arguments[0].o) : (g = arguments[f], y = arguments[f + 1]);
                    var x = p.length,
                        S = 0;
                    if (!/^(stop|finish)$/i.test(g) && !h.isPlainObject(y)) {
                        var k = f + 1;
                        y = {};
                        for (var T = k; T < arguments.length; T++) m.isArray(arguments[T]) || !/^(fast|normal|slow)$/i.test(arguments[T]) && !/^\d/.test(arguments[T]) ? m.isString(arguments[T]) || m.isArray(arguments[T]) ? y.easing = arguments[T] : m.isFunction(arguments[T]) && (y.complete = arguments[T]) : y.duration = arguments[T]
                    }
                    var M = {
                        promise: null,
                        resolver: null,
                        rejecter: null
                    };
                    r && w.Promise && (M.promise = new w.Promise(function(t, e) {
                        M.resolver = t, M.rejecter = e
                    }));
                    var P;
                    switch (g) {
                        case "scroll":
                            P = "scroll";
                            break;
                        case "reverse":
                            P = "reverse";
                            break;
                        case "finish":
                        case "stop":
                            h.each(p, function(t, e) {
                                s(e) && s(e).delayTimer && (clearTimeout(s(e).delayTimer.setTimeout), s(e).delayTimer.next && s(e).delayTimer.next(), delete s(e).delayTimer)
                            });
                            var O = [];
                            return h.each(w.State.calls, function(t, e) {
                                e && h.each(e[1], function(i, a) {
                                    var o = y === n ? "" : y;
                                    return o === !0 || e[2].queue === o || y === n && e[2].queue === !1 ? void h.each(p, function(i, n) {
                                        n === a && ((y === !0 || m.isString(y)) && (h.each(h.queue(n, m.isString(y) ? y : ""), function(t, e) {
                                            m.isFunction(e) && e(null, !0)
                                        }), h.queue(n, m.isString(y) ? y : "", [])), "stop" === g ? (s(n) && s(n).tweensContainer && o !== !1 && h.each(s(n).tweensContainer, function(t, e) {
                                            e.endValue = e.currentValue
                                        }), O.push(t)) : "finish" === g && (e[2].duration = 1))
                                    }) : !0
                                })
                            }), "stop" === g && (h.each(O, function(t, e) {
                                d(e, !0)
                            }), M.promise && M.resolver(p)), t();
                        default:
                            if (!h.isPlainObject(g) || m.isEmptyObject(g)) {
                                if (m.isString(g) && w.Redirects[g]) {
                                    var D = h.extend({}, y),
                                        L = D.duration,
                                        E = D.delay || 0;
                                    return D.backwards === !0 && (p = h.extend(!0, [], p).reverse()), h.each(p, function(t, e) {
                                        parseFloat(D.stagger) ? D.delay = E + parseFloat(D.stagger) * t : m.isFunction(D.stagger) && (D.delay = E + D.stagger.call(e, t, x)), D.drag && (D.duration = parseFloat(L) || (/^(callout|transition)/.test(g) ? 1e3 : v), D.duration = Math.max(D.duration * (D.backwards ? 1 - t / x : (t + 1) / x), .75 * D.duration, 200)), w.Redirects[g].call(e, e, D || {}, t, x, p, M.promise ? M : n)
                                    }), t()
                                }
                                var F = "Velocity: First argument (" + g + ") was not a property map, a known action, or a registered redirect. Aborting.";
                                return M.promise ? M.rejecter(new Error(F)) : console.log(F), t()
                            }
                            P = "start"
                    }
                    var A = {
                            lastParent: null,
                            lastPosition: null,
                            lastFontSize: null,
                            lastPercentToPxWidth: null,
                            lastPercentToPxHeight: null,
                            lastEmToPx: null,
                            remToPx: null,
                            vwToPx: null,
                            vhToPx: null
                        },
                        I = [];
                    h.each(p, function(t, e) {
                        m.isNode(e) && a.call(e)
                    });
                    var q, D = h.extend({}, w.defaults, y);
                    if (D.loop = parseInt(D.loop), q = 2 * D.loop - 1, D.loop)
                        for (var j = 0; q > j; j++) {
                            var N = {
                                delay: D.delay,
                                progress: D.progress
                            };
                            j === q - 1 && (N.display = D.display, N.visibility = D.visibility, N.complete = D.complete), C(p, "reverse", N)
                        }
                    return t()
                }
            };
            w = h.extend(C, w), w.animate = C;
            var x = e.requestAnimationFrame || p;
            return w.State.isMobile || i.hidden === n || i.addEventListener("visibilitychange", function() {
                i.hidden ? (x = function(t) {
                    return setTimeout(function() {
                        t(!0)
                    }, 16)
                }, c()) : x = e.requestAnimationFrame || p
            }), t.Velocity = w, t !== e && (t.fn.velocity = C, t.fn.velocity.defaults = w.defaults), h.each(["Down", "Up"], function(t, e) {
                w.Redirects["slide" + e] = function(t, i, a, o, s, r) {
                    var l = h.extend({}, i),
                        u = l.begin,
                        c = l.complete,
                        d = {
                            height: "",
                            marginTop: "",
                            marginBottom: "",
                            paddingTop: "",
                            paddingBottom: ""
                        },
                        f = {};
                    l.display === n && (l.display = "Down" === e ? "inline" === w.CSS.Values.getDisplayType(t) ? "inline-block" : "block" : "none"), l.begin = function() {
                        u && u.call(s, s);
                        for (var i in d) {
                            f[i] = t.style[i];
                            var n = w.CSS.getPropertyValue(t, i);
                            d[i] = "Down" === e ? [n, 0] : [0, n]
                        }
                        f.overflow = t.style.overflow, t.style.overflow = "hidden"
                    }, l.complete = function() {
                        for (var e in f) t.style[e] = f[e];
                        c && c.call(s, s), r && r.resolver(s)
                    }, w(t, d, l)
                }
            }), h.each(["In", "Out"], function(t, e) {
                w.Redirects["fade" + e] = function(t, i, a, o, s, r) {
                    var l = h.extend({}, i),
                        u = {
                            opacity: "In" === e ? 1 : 0
                        },
                        c = l.complete;
                    l.complete = a !== o - 1 ? l.begin = null : function() {
                        c && c.call(s, s), r && r.resolver(s)
                    }, l.display === n && (l.display = "In" === e ? "auto" : "none"), w(this, u, l)
                }
            }), w
        }(window.jQuery || window.Zepto || window, window, document)
    })), ! function(t, e, i, n) {
        "use strict";

        function a(t, e, i) {
            return setTimeout(c(t, i), e)
        }

        function o(t, e, i) {
            return Array.isArray(t) ? (s(t, i[e], i), !0) : !1
        }

        function s(t, e, i) {
            var a;
            if (t)
                if (t.forEach) t.forEach(e, i);
                else if (t.length !== n)
                for (a = 0; a < t.length;) e.call(i, t[a], a, t), a++;
            else
                for (a in t) t.hasOwnProperty(a) && e.call(i, t[a], a, t)
        }

        function r(t, e, i) {
            for (var a = Object.keys(e), o = 0; o < a.length;)(!i || i && t[a[o]] === n) && (t[a[o]] = e[a[o]]), o++;
            return t
        }

        function l(t, e) {
            return r(t, e, !0)
        }

        function u(t, e, i) {
            var n, a = e.prototype;
            n = t.prototype = Object.create(a), n.constructor = t, n._super = a, i && r(n, i)
        }

        function c(t, e) {
            return function() {
                return t.apply(e, arguments)
            }
        }

        function d(t, e) {
            return typeof t == ct ? t.apply(e ? e[0] || n : n, e) : t
        }

        function h(t, e) {
            return t === n ? e : t
        }

        function f(t, e, i) {
            s(v(e), function(e) {
                t.addEventListener(e, i, !1)
            })
        }

        function p(t, e, i) {
            s(v(e), function(e) {
                t.removeEventListener(e, i, !1)
            })
        }

        function m(t, e) {
            for (; t;) {
                if (t == e) return !0;
                t = t.parentNode
            }
            return !1
        }

        function g(t, e) {
            return t.indexOf(e) > -1
        }

        function v(t) {
            return t.trim().split(/\s+/g)
        }

        function y(t, e, i) {
            if (t.indexOf && !i) return t.indexOf(e);
            for (var n = 0; n < t.length;) {
                if (i && t[n][i] == e || !i && t[n] === e) return n;
                n++
            }
            return -1
        }

        function w(t) {
            return Array.prototype.slice.call(t, 0)
        }

        function b(t, e, i) {
            for (var n = [], a = [], o = 0; o < t.length;) {
                var s = e ? t[o][e] : t[o];
                y(a, s) < 0 && n.push(t[o]), a[o] = s, o++
            }
            return i && (n = e ? n.sort(function(t, i) {
                return t[e] > i[e]
            }) : n.sort()), n
        }

        function _(t, e) {
            for (var i, a, o = e[0].toUpperCase() + e.slice(1), s = 0; s < lt.length;) {
                if (i = lt[s], a = i ? i + o : e, a in t) return a;
                s++
            }
            return n
        }

        function C() {
            return pt++
        }

        function x(t) {
            var e = t.ownerDocument;
            return e.defaultView || e.parentWindow
        }

        function S(t, e) {
            var i = this;
            this.manager = t, this.callback = e, this.element = t.element, this.target = t.options.inputTarget, this.domHandler = function(e) {
                d(t.options.enable, [t]) && i.handler(e)
            }, this.init()
        }

        function k(t) {
            var e, i = t.options.inputClass;
            return new(e = i ? i : vt ? V : yt ? R : gt ? Q : N)(t, T)
        }

        function T(t, e, i) {
            var n = i.pointers.length,
                a = i.changedPointers.length,
                o = e & St && 0 === n - a,
                s = e & (Tt | Mt) && 0 === n - a;
            i.isFirst = !!o, i.isFinal = !!s, o && (t.session = {}), i.eventType = e, M(t, i), t.emit("hammer.input", i), t.recognize(i), t.session.prevInput = i
        }

        function M(t, e) {
            var i = t.session,
                n = e.pointers,
                a = n.length;
            i.firstInput || (i.firstInput = D(e)), a > 1 && !i.firstMultiple ? i.firstMultiple = D(e) : 1 === a && (i.firstMultiple = !1);
            var o = i.firstInput,
                s = i.firstMultiple,
                r = s ? s.center : o.center,
                l = e.center = L(n);
            e.timeStamp = ft(), e.deltaTime = e.timeStamp - o.timeStamp, e.angle = I(r, l), e.distance = A(r, l), P(i, e), e.offsetDirection = F(e.deltaX, e.deltaY), e.scale = s ? j(s.pointers, n) : 1, e.rotation = s ? q(s.pointers, n) : 0, O(i, e);
            var u = t.element;
            m(e.srcEvent.target, u) && (u = e.srcEvent.target), e.target = u
        }

        function P(t, e) {
            var i = e.center,
                n = t.offsetDelta || {},
                a = t.prevDelta || {},
                o = t.prevInput || {};
            (e.eventType === St || o.eventType === Tt) && (a = t.prevDelta = {
                x: o.deltaX || 0,
                y: o.deltaY || 0
            }, n = t.offsetDelta = {
                x: i.x,
                y: i.y
            }), e.deltaX = a.x + (i.x - n.x), e.deltaY = a.y + (i.y - n.y)
        }

        function O(t, e) {
            var i, a, o, s, r = t.lastInterval || e,
                l = e.timeStamp - r.timeStamp;
            if (e.eventType != Mt && (l > xt || r.velocity === n)) {
                var u = r.deltaX - e.deltaX,
                    c = r.deltaY - e.deltaY,
                    d = E(l, u, c);
                a = d.x, o = d.y, i = ht(d.x) > ht(d.y) ? d.x : d.y, s = F(u, c), t.lastInterval = e
            } else i = r.velocity, a = r.velocityX, o = r.velocityY, s = r.direction;
            e.velocity = i, e.velocityX = a, e.velocityY = o, e.direction = s
        }

        function D(t) {
            for (var e = [], i = 0; i < t.pointers.length;) e[i] = {
                clientX: dt(t.pointers[i].clientX),
                clientY: dt(t.pointers[i].clientY)
            }, i++;
            return {
                timeStamp: ft(),
                pointers: e,
                center: L(e),
                deltaX: t.deltaX,
                deltaY: t.deltaY
            }
        }

        function L(t) {
            var e = t.length;
            if (1 === e) return {
                x: dt(t[0].clientX),
                y: dt(t[0].clientY)
            };
            for (var i = 0, n = 0, a = 0; e > a;) i += t[a].clientX, n += t[a].clientY, a++;
            return {
                x: dt(i / e),
                y: dt(n / e)
            }
        }

        function E(t, e, i) {
            return {
                x: e / t || 0,
                y: i / t || 0
            }
        }

        function F(t, e) {
            return t === e ? Pt : ht(t) >= ht(e) ? t > 0 ? Ot : Dt : e > 0 ? Lt : Et
        }

        function A(t, e, i) {
            i || (i = qt);
            var n = e[i[0]] - t[i[0]],
                a = e[i[1]] - t[i[1]];
            return Math.sqrt(n * n + a * a)
        }

        function I(t, e, i) {
            i || (i = qt);
            var n = e[i[0]] - t[i[0]],
                a = e[i[1]] - t[i[1]];
            return 180 * Math.atan2(a, n) / Math.PI
        }

        function q(t, e) {
            return I(e[1], e[0], jt) - I(t[1], t[0], jt)
        }

        function j(t, e) {
            return A(e[0], e[1], jt) / A(t[0], t[1], jt)
        }

        function N() {
            this.evEl = Vt, this.evWin = $t, this.allow = !0, this.pressed = !1, S.apply(this, arguments)
        }

        function V() {
            this.evEl = Rt, this.evWin = Bt, S.apply(this, arguments), this.store = this.manager.session.pointerEvents = []
        }

        function z() {
            this.evTarget = Wt, this.evWin = Xt, this.started = !1, S.apply(this, arguments)
        }

        function H(t, e) {
            var i = w(t.touches),
                n = w(t.changedTouches);
            return e & (Tt | Mt) && (i = b(i.concat(n), "identifier", !0)), [i, n]
        }

        function R() {
            this.evTarget = Yt, this.targetIds = {}, S.apply(this, arguments)
        }

        function B(t, e) {
            var i = w(t.touches),
                n = this.targetIds;
            if (e & (St | kt) && 1 === i.length) return n[i[0].identifier] = !0, [i, i];
            var a, o, s = w(t.changedTouches),
                r = [],
                l = this.target;
            if (o = i.filter(function(t) {
                    return m(t.target, l)
                }), e === St)
                for (a = 0; a < o.length;) n[o[a].identifier] = !0, a++;
            for (a = 0; a < s.length;) n[s[a].identifier] && r.push(s[a]), e & (Tt | Mt) && delete n[s[a].identifier], a++;
            return r.length ? [b(o.concat(r), "identifier", !0), r] : void 0
        }

        function Q() {
            S.apply(this, arguments);
            var t = c(this.handler, this);
            this.touch = new R(this.manager, t), this.mouse = new N(this.manager, t)
        }

        function W(t, e) {
            this.manager = t, this.set(e)
        }

        function X(t) {
            if (g(t, ee)) return ee;
            var e = g(t, ie),
                i = g(t, ne);
            return e && i ? ie + " " + ne : e || i ? e ? ie : ne : g(t, te) ? te : Kt
        }

        function U(t) {
            this.id = C(), this.manager = null, this.options = l(t || {}, this.defaults), this.options.enable = h(this.options.enable, !0), this.state = ae, this.simultaneous = {}, this.requireFail = []
        }

        function Y(t) {
            return t & ue ? "cancel" : t & re ? "end" : t & se ? "move" : t & oe ? "start" : ""
        }

        function G(t) {
            return t == Et ? "down" : t == Lt ? "up" : t == Ot ? "left" : t == Dt ? "right" : ""
        }

        function Z(t, e) {
            var i = e.manager;
            return i ? i.get(t) : t
        }

        function J() {
            U.apply(this, arguments)
        }

        function $() {
            J.apply(this, arguments), this.pX = null, this.pY = null
        }

        function K() {
            J.apply(this, arguments)
        }

        function tt() {
            U.apply(this, arguments), this._timer = null, this._input = null
        }

        function et() {
            J.apply(this, arguments)
        }

        function it() {
            J.apply(this, arguments)
        }

        function nt() {
            U.apply(this, arguments), this.pTime = !1, this.pCenter = !1, this._timer = null, this._input = null, this.count = 0
        }

        function at(t, e) {
            return e = e || {}, e.recognizers = h(e.recognizers, at.defaults.preset), new ot(t, e)
        }

        function ot(t, e) {
            e = e || {}, this.options = l(e, at.defaults), this.options.inputTarget = this.options.inputTarget || t, this.handlers = {}, this.session = {}, this.recognizers = [], this.element = t, this.input = k(this), this.touchAction = new W(this, this.options.touchAction), st(this, !0), s(e.recognizers, function(t) {
                var e = this.add(new t[0](t[1]));
                t[2] && e.recognizeWith(t[2]), t[3] && e.requireFailure(t[3])
            }, this)
        }

        function st(t, e) {
            var i = t.element;
            s(t.options.cssProps, function(t, n) {
                i.style[_(i.style, n)] = e ? t : ""
            })
        }

        function rt(t, i) {
            var n = e.createEvent("Event");
            n.initEvent(t, !0, !0), n.gesture = i, i.target.dispatchEvent(n)
        }
        var lt = ["", "webkit", "moz", "MS", "ms", "o"],
            ut = e.createElement("div"),
            ct = "function",
            dt = Math.round,
            ht = Math.abs,
            ft = Date.now,
            pt = 1,
            mt = /mobile|tablet|ip(ad|hone|od)|android/i,
            gt = "ontouchstart" in t,
            vt = _(t, "PointerEvent") !== n,
            yt = gt && mt.test(navigator.userAgent),
            wt = "touch",
            bt = "pen",
            _t = "mouse",
            Ct = "kinect",
            xt = 25,
            St = 1,
            kt = 2,
            Tt = 4,
            Mt = 8,
            Pt = 1,
            Ot = 2,
            Dt = 4,
            Lt = 8,
            Et = 16,
            Ft = Ot | Dt,
            At = Lt | Et,
            It = Ft | At,
            qt = ["x", "y"],
            jt = ["clientX", "clientY"];
        S.prototype = {
            handler: function() {},
            init: function() {
                this.evEl && f(this.element, this.evEl, this.domHandler), this.evTarget && f(this.target, this.evTarget, this.domHandler), this.evWin && f(x(this.element), this.evWin, this.domHandler)
            },
            destroy: function() {
                this.evEl && p(this.element, this.evEl, this.domHandler), this.evTarget && p(this.target, this.evTarget, this.domHandler), this.evWin && p(x(this.element), this.evWin, this.domHandler)
            }
        };
        var Nt = {
                mousedown: St,
                mousemove: kt,
                mouseup: Tt
            },
            Vt = "mousedown",
            $t = "mousemove mouseup";
        u(N, S, {
            handler: function(t) {
                var e = Nt[t.type];
                e & St && 0 === t.button && (this.pressed = !0), e & kt && 1 !== t.which && (e = Tt), this.pressed && this.allow && (e & Tt && (this.pressed = !1), this.callback(this.manager, e, {
                    pointers: [t],
                    changedPointers: [t],
                    pointerType: _t,
                    srcEvent: t
                }))
            }
        });
        var zt = {
                pointerdown: St,
                pointermove: kt,
                pointerup: Tt,
                pointercancel: Mt,
                pointerout: Mt
            },
            Ht = {
                2: wt,
                3: bt,
                4: _t,
                5: Ct
            },
            Rt = "pointerdown",
            Bt = "pointermove pointerup pointercancel";
        t.MSPointerEvent && (Rt = "MSPointerDown", Bt = "MSPointerMove MSPointerUp MSPointerCancel"), u(V, S, {
            handler: function(t) {
                var e = this.store,
                    i = !1,
                    n = t.type.toLowerCase().replace("ms", ""),
                    a = zt[n],
                    o = Ht[t.pointerType] || t.pointerType,
                    s = o == wt,
                    r = y(e, t.pointerId, "pointerId");
                a & St && (0 === t.button || s) ? 0 > r && (e.push(t), r = e.length - 1) : a & (Tt | Mt) && (i = !0), 0 > r || (e[r] = t, this.callback(this.manager, a, {
                    pointers: e,
                    changedPointers: [t],
                    pointerType: o,
                    srcEvent: t
                }), i && e.splice(r, 1))
            }
        });
        var Qt = {
                touchstart: St,
                touchmove: kt,
                touchend: Tt,
                touchcancel: Mt
            },
            Wt = "touchstart",
            Xt = "touchstart touchmove touchend touchcancel";
        u(z, S, {
            handler: function(t) {
                var e = Qt[t.type];
                if (e === St && (this.started = !0), this.started) {
                    var i = H.call(this, t, e);
                    e & (Tt | Mt) && 0 === i[0].length - i[1].length && (this.started = !1), this.callback(this.manager, e, {
                        pointers: i[0],
                        changedPointers: i[1],
                        pointerType: wt,
                        srcEvent: t
                    })
                }
            }
        });
        var Ut = {
                touchstart: St,
                touchmove: kt,
                touchend: Tt,
                touchcancel: Mt
            },
            Yt = "touchstart touchmove touchend touchcancel";
        u(R, S, {
            handler: function(t) {
                var e = Ut[t.type],
                    i = B.call(this, t, e);
                i && this.callback(this.manager, e, {
                    pointers: i[0],
                    changedPointers: i[1],
                    pointerType: wt,
                    srcEvent: t
                })
            }
        }), u(Q, S, {
            handler: function(t, e, i) {
                var n = i.pointerType == wt,
                    a = i.pointerType == _t;
                if (n) this.mouse.allow = !1;
                else if (a && !this.mouse.allow) return;
                e & (Tt | Mt) && (this.mouse.allow = !0), this.callback(t, e, i)
            },
            destroy: function() {
                this.touch.destroy(), this.mouse.destroy()
            }
        });
        var Gt = _(ut.style, "touchAction"),
            Zt = Gt !== n,
            Jt = "compute",
            Kt = "auto",
            te = "manipulation",
            ee = "none",
            ie = "pan-x",
            ne = "pan-y";
        W.prototype = {
            set: function(t) {
                t == Jt && (t = this.compute()), Zt && (this.manager.element.style[Gt] = t), this.actions = t.toLowerCase().trim()
            },
            update: function() {
                this.set(this.manager.options.touchAction)
            },
            compute: function() {
                var t = [];
                return s(this.manager.recognizers, function(e) {
                    d(e.options.enable, [e]) && (t = t.concat(e.getTouchAction()))
                }), X(t.join(" "))
            },
            preventDefaults: function(t) {
                if (!Zt) {
                    var e = t.srcEvent,
                        i = t.offsetDirection;
                    if (this.manager.session.prevented) return void e.preventDefault();
                    var n = this.actions,
                        a = g(n, ee),
                        o = g(n, ne),
                        s = g(n, ie);
                    return a || o && i & Ft || s && i & At ? this.preventSrc(e) : void 0
                }
            },
            preventSrc: function(t) {
                this.manager.session.prevented = !0, t.preventDefault()
            }
        };
        var ae = 1,
            oe = 2,
            se = 4,
            re = 8,
            le = re,
            ue = 16,
            ce = 32;
        U.prototype = {
            defaults: {},
            set: function(t) {
                return r(this.options, t), this.manager && this.manager.touchAction.update(), this
            },
            recognizeWith: function(t) {
                if (o(t, "recognizeWith", this)) return this;
                var e = this.simultaneous;
                return t = Z(t, this), e[t.id] || (e[t.id] = t, t.recognizeWith(this)), this
            },
            dropRecognizeWith: function(t) {
                return o(t, "dropRecognizeWith", this) ? this : (t = Z(t, this), delete this.simultaneous[t.id], this)
            },
            requireFailure: function(t) {
                if (o(t, "requireFailure", this)) return this;
                var e = this.requireFail;
                return t = Z(t, this), -1 === y(e, t) && (e.push(t), t.requireFailure(this)), this
            },
            dropRequireFailure: function(t) {
                if (o(t, "dropRequireFailure", this)) return this;
                t = Z(t, this);
                var e = y(this.requireFail, t);
                return e > -1 && this.requireFail.splice(e, 1), this
            },
            hasRequireFailures: function() {
                return this.requireFail.length > 0
            },
            canRecognizeWith: function(t) {
                return !!this.simultaneous[t.id]
            },
            emit: function(t) {
                function e(e) {
                    i.manager.emit(i.options.event + (e ? Y(n) : ""), t)
                }
                var i = this,
                    n = this.state;
                re > n && e(!0), e(), n >= re && e(!0)
            },
            tryEmit: function(t) {
                return this.canEmit() ? this.emit(t) : void(this.state = ce)
            },
            canEmit: function() {
                for (var t = 0; t < this.requireFail.length;) {
                    if (!(this.requireFail[t].state & (ce | ae))) return !1;
                    t++
                }
                return !0
            },
            recognize: function(t) {
                var e = r({}, t);
                return d(this.options.enable, [this, e]) ? (this.state & (le | ue | ce) && (this.state = ae), this.state = this.process(e), void(this.state & (oe | se | re | ue) && this.tryEmit(e))) : (this.reset(), void(this.state = ce))
            },
            process: function() {},
            getTouchAction: function() {},
            reset: function() {}
        }, u(J, U, {
            defaults: {
                pointers: 1
            },
            attrTest: function(t) {
                var e = this.options.pointers;
                return 0 === e || t.pointers.length === e
            },
            process: function(t) {
                var e = this.state,
                    i = t.eventType,
                    n = e & (oe | se),
                    a = this.attrTest(t);
                return n && (i & Mt || !a) ? e | ue : n || a ? i & Tt ? e | re : e & oe ? e | se : oe : ce
            }
        }), u($, J, {
            defaults: {
                event: "pan",
                threshold: 10,
                pointers: 1,
                direction: It
            },
            getTouchAction: function() {
                var t = this.options.direction,
                    e = [];
                return t & Ft && e.push(ne), t & At && e.push(ie), e
            },
            directionTest: function(t) {
                var e = this.options,
                    i = !0,
                    n = t.distance,
                    a = t.direction,
                    o = t.deltaX,
                    s = t.deltaY;
                return a & e.direction || (e.direction & Ft ? (a = 0 === o ? Pt : 0 > o ? Ot : Dt, i = o != this.pX, n = Math.abs(t.deltaX)) : (a = 0 === s ? Pt : 0 > s ? Lt : Et, i = s != this.pY, n = Math.abs(t.deltaY))), t.direction = a, i && n > e.threshold && a & e.direction
            },
            attrTest: function(t) {
                return J.prototype.attrTest.call(this, t) && (this.state & oe || !(this.state & oe) && this.directionTest(t))
            },
            emit: function(t) {
                this.pX = t.deltaX, this.pY = t.deltaY;
                var e = G(t.direction);
                e && this.manager.emit(this.options.event + e, t), this._super.emit.call(this, t)
            }
        }), u(K, J, {
            defaults: {
                event: "pinch",
                threshold: 0,
                pointers: 2
            },
            getTouchAction: function() {
                return [ee]
            },
            attrTest: function(t) {
                return this._super.attrTest.call(this, t) && (Math.abs(t.scale - 1) > this.options.threshold || this.state & oe)
            },
            emit: function(t) {
                if (this._super.emit.call(this, t), 1 !== t.scale) {
                    var e = t.scale < 1 ? "in" : "out";
                    this.manager.emit(this.options.event + e, t)
                }
            }
        }), u(tt, U, {
            defaults: {
                event: "press",
                pointers: 1,
                time: 500,
                threshold: 5
            },
            getTouchAction: function() {
                return [Kt]
            },
            process: function(t) {
                var e = this.options,
                    i = t.pointers.length === e.pointers,
                    n = t.distance < e.threshold,
                    o = t.deltaTime > e.time;
                if (this._input = t, !n || !i || t.eventType & (Tt | Mt) && !o) this.reset();
                else if (t.eventType & St) this.reset(), this._timer = a(function() {
                    this.state = le, this.tryEmit()
                }, e.time, this);
                else if (t.eventType & Tt) return le;
                return ce
            },
            reset: function() {
                clearTimeout(this._timer)
            },
            emit: function(t) {
                this.state === le && (t && t.eventType & Tt ? this.manager.emit(this.options.event + "up", t) : (this._input.timeStamp = ft(), this.manager.emit(this.options.event, this._input)))
            }
        }), u(et, J, {
            defaults: {
                event: "rotate",
                threshold: 0,
                pointers: 2
            },
            getTouchAction: function() {
                return [ee]
            },
            attrTest: function(t) {
                return this._super.attrTest.call(this, t) && (Math.abs(t.rotation) > this.options.threshold || this.state & oe)
            }
        }), u(it, J, {
            defaults: {
                event: "swipe",
                threshold: 10,
                velocity: .65,
                direction: Ft | At,
                pointers: 1
            },
            getTouchAction: function() {
                return $.prototype.getTouchAction.call(this)
            },
            attrTest: function(t) {
                var e, i = this.options.direction;
                return i & (Ft | At) ? e = t.velocity : i & Ft ? e = t.velocityX : i & At && (e = t.velocityY), this._super.attrTest.call(this, t) && i & t.direction && t.distance > this.options.threshold && ht(e) > this.options.velocity && t.eventType & Tt
            },
            emit: function(t) {
                var e = G(t.direction);
                e && this.manager.emit(this.options.event + e, t), this.manager.emit(this.options.event, t)
            }
        }), u(nt, U, {
            defaults: {
                event: "tap",
                pointers: 1,
                taps: 1,
                interval: 300,
                time: 250,
                threshold: 2,
                posThreshold: 10
            },
            getTouchAction: function() {
                return [te]
            },
            process: function(t) {
                var e = this.options,
                    i = t.pointers.length === e.pointers,
                    n = t.distance < e.threshold,
                    o = t.deltaTime < e.time;
                if (this.reset(), t.eventType & St && 0 === this.count) return this.failTimeout();
                if (n && o && i) {
                    if (t.eventType != Tt) return this.failTimeout();
                    var s = this.pTime ? t.timeStamp - this.pTime < e.interval : !0,
                        r = !this.pCenter || A(this.pCenter, t.center) < e.posThreshold;
                    this.pTime = t.timeStamp, this.pCenter = t.center, r && s ? this.count += 1 : this.count = 1, this._input = t;
                    var l = this.count % e.taps;
                    if (0 === l) return this.hasRequireFailures() ? (this._timer = a(function() {
                        this.state = le, this.tryEmit()
                    }, e.interval, this), oe) : le
                }
                return ce
            },
            failTimeout: function() {
                return this._timer = a(function() {
                    this.state = ce
                }, this.options.interval, this), ce
            },
            reset: function() {
                clearTimeout(this._timer)
            },
            emit: function() {
                this.state == le && (this._input.tapCount = this.count, this.manager.emit(this.options.event, this._input))
            }
        }), at.VERSION = "2.0.4", at.defaults = {
            domEvents: !1,
            touchAction: Jt,
            enable: !0,
            inputTarget: null,
            inputClass: null,
            preset: [
                [et, {
                    enable: !1
                }],
                [K, {
                        enable: !1
                    },
                    ["rotate"]
                ],
                [it, {
                    direction: Ft
                }],
                [$, {
                        direction: Ft
                    },
                    ["swipe"]
                ],
                [nt],
                [nt, {
                        event: "doubletap",
                        taps: 2
                    },
                    ["tap"]
                ],
                [tt]
            ],
            cssProps: {
                userSelect: "default",
                touchSelect: "none",
                touchCallout: "none",
                contentZooming: "none",
                userDrag: "none",
                tapHighlightColor: "rgba(0,0,0,0)"
            }
        };
        var de = 1,
            he = 2;
        ot.prototype = {
            set: function(t) {
                return r(this.options, t), t.touchAction && this.touchAction.update(), t.inputTarget && (this.input.destroy(), this.input.target = t.inputTarget, this.input.init()), this
            },
            stop: function(t) {
                this.session.stopped = t ? he : de
            },
            recognize: function(t) {
                var e = this.session;
                if (!e.stopped) {
                    this.touchAction.preventDefaults(t);
                    var i, n = this.recognizers,
                        a = e.curRecognizer;
                    (!a || a && a.state & le) && (a = e.curRecognizer = null);
                    for (var o = 0; o < n.length;) i = n[o], e.stopped === he || a && i != a && !i.canRecognizeWith(a) ? i.reset() : i.recognize(t), !a && i.state & (oe | se | re) && (a = e.curRecognizer = i), o++
                }
            },
            get: function(t) {
                if (t instanceof U) return t;
                for (var e = this.recognizers, i = 0; i < e.length; i++)
                    if (e[i].options.event == t) return e[i];
                return null
            },
            add: function(t) {
                if (o(t, "add", this)) return this;
                var e = this.get(t.options.event);
                return e && this.remove(e), this.recognizers.push(t), t.manager = this, this.touchAction.update(), t
            },
            remove: function(t) {
                if (o(t, "remove", this)) return this;
                var e = this.recognizers;
                return t = this.get(t), e.splice(y(e, t), 1), this.touchAction.update(), this
            },
            on: function(t, e) {
                var i = this.handlers;
                return s(v(t), function(t) {
                    i[t] = i[t] || [], i[t].push(e)
                }), this
            },
            off: function(t, e) {
                var i = this.handlers;
                return s(v(t), function(t) {
                    e ? i[t].splice(y(i[t], e), 1) : delete i[t]
                }), this
            },
            emit: function(t, e) {
                this.options.domEvents && rt(t, e);
                var i = this.handlers[t] && this.handlers[t].slice();
                if (i && i.length) {
                    e.type = t, e.preventDefault = function() {
                        e.srcEvent.preventDefault()
                    };
                    for (var n = 0; n < i.length;) i[n](e), n++
                }
            },
            destroy: function() {
                this.element && st(this, !1), this.handlers = {}, this.session = {}, this.input.destroy(), this.element = null
            }
        }, r(at, {
            INPUT_START: St,
            INPUT_MOVE: kt,
            INPUT_END: Tt,
            INPUT_CANCEL: Mt,
            STATE_POSSIBLE: ae,
            STATE_BEGAN: oe,
            STATE_CHANGED: se,
            STATE_ENDED: re,
            STATE_RECOGNIZED: le,
            STATE_CANCELLED: ue,
            STATE_FAILED: ce,
            DIRECTION_NONE: Pt,
            DIRECTION_LEFT: Ot,
            DIRECTION_RIGHT: Dt,
            DIRECTION_UP: Lt,
            DIRECTION_DOWN: Et,
            DIRECTION_HORIZONTAL: Ft,
            DIRECTION_VERTICAL: At,
            DIRECTION_ALL: It,
            Manager: ot,
            Input: S,
            TouchAction: W,
            TouchInput: R,
            MouseInput: N,
            PointerEventInput: V,
            TouchMouseInput: Q,
            SingleTouchInput: z,
            Recognizer: U,
            AttrRecognizer: J,
            Tap: nt,
            Pan: $,
            Swipe: it,
            Pinch: K,
            Rotate: et,
            Press: tt,
            on: f,
            off: p,
            each: s,
            merge: l,
            extend: r,
            inherit: u,
            bindFn: c,
            prefixed: _
        }), typeof define == ct && define.amd ? define(function() {
            return at
        }) : "undefined" != typeof module && module.exports ? module.exports = at : t[i] = at
    }(window, document, "Hammer"),
    function(t) {
        "function" == typeof define && define.amd ? define(["jquery", "hammerjs"], t) : "object" == typeof exports ? t(require("jquery"), require("hammerjs")) : t(jQuery, Hammer)
    }(function(t, e) {
        function i(i, n) {
            var a = t(i);
            a.data("hammer") || a.data("hammer", new e(a[0], n))
        }
        t.fn.hammer = function(t) {
            return this.each(function() {
                i(this, t)
            })
        }, e.Manager.prototype.emit = function(e) {
            return function(i, n) {
                e.call(this, i, n), t(this.element).trigger({
                    type: i,
                    gesture: n
                })
            }
        }(e.Manager.prototype.emit)
    }),
    function(t) {
        t.Package ? Materialize = {} : t.Materialize = {}
    }(window), Materialize.guid = function() {
        function t() {
            return Math.floor(65536 * (1 + Math.random())).toString(16).substring(1)
        }
        return function() {
            return t() + t() + "-" + t() + "-" + t() + "-" + t() + "-" + t() + t() + t()
        }
    }(), Materialize.elementOrParentIsFixed = function(t) {
        var e = $(t),
            i = e.add(e.parents()),
            n = !1;
        return i.each(function() {
            return "fixed" === $(this).css("position") ? (n = !0, !1) : void 0
        }), n
    };
var Vel;
Vel = $ ? $.Velocity : jQuery ? jQuery.Velocity : Velocity,
    function(t) {
        t.fn.collapsible = function(e) {
            var i = {
                accordion: void 0
            };
            return e = t.extend(i, e), this.each(function() {
                function i(e) {
                    r = s.find("> li > .collapsible-header"), e.hasClass("active") ? e.parent().addClass("active") : e.parent().removeClass("active"), e.parent().hasClass("active") ? e.siblings(".collapsible-body").stop(!0, !1).slideDown({
                        duration: 350,
                        easing: "easeOutQuart",
                        queue: !1,
                        complete: function() {
                            t(this).css("height", "")
                        }
                    }) : e.siblings(".collapsible-body").stop(!0, !1).slideUp({
                        duration: 350,
                        easing: "easeOutQuart",
                        queue: !1,
                        complete: function() {
                            t(this).css("height", "")
                        }
                    }), r.not(e).removeClass("active").parent().removeClass("active"), r.not(e).parent().children(".collapsible-body").stop(!0, !1).slideUp({
                        duration: 350,
                        easing: "easeOutQuart",
                        queue: !1,
                        complete: function() {
                            t(this).css("height", "")
                        }
                    })
                }

                function n(e) {
                    e.hasClass("active") ? e.parent().addClass("active") : e.parent().removeClass("active"), e.parent().hasClass("active") ? e.siblings(".collapsible-body").stop(!0, !1).slideDown({
                        duration: 350,
                        easing: "easeOutQuart",
                        queue: !1,
                        complete: function() {
                            t(this).css("height", "")
                        }
                    }) : e.siblings(".collapsible-body").stop(!0, !1).slideUp({
                        duration: 350,
                        easing: "easeOutQuart",
                        queue: !1,
                        complete: function() {
                            t(this).css("height", "")
                        }
                    })
                }

                function a(t) {
                    var e = o(t);
                    return e.length > 0
                }

                function o(t) {
                    return t.closest("li > .collapsible-header")
                }
                var s = t(this),
                    r = t(this).find("> li > .collapsible-header"),
                    l = s.data("collapsible");
                s.off("click.collapse", "> li > .collapsible-header"), r.off("click.collapse"), s.on("click.collapse", "> li > .collapsible-header", function(s) {
                    var r = t(this),
                        u = t(s.target);
                    a(u) && (u = o(u)), u.toggleClass("active"), e.accordion || "accordion" === l || void 0 === l ? i(u) : (n(u), r.hasClass("active") && n(r))
                });
                var r = s.find("> li > .collapsible-header");
                e.accordion || "accordion" === l || void 0 === l ? i(r.filter(".active").first()) : r.filter(".active").each(function() {
                    n(t(this))
                })
            })
        }, t(document).ready(function() {
            t(".collapsible").collapsible()
        })
    }(jQuery),
    function(t) {
        t.fn.scrollTo = function(e) {
            return t(this).scrollTop(t(this).scrollTop() - t(this).offset().top + t(e).offset().top), this
        }, t.fn.dropdown = function(e) {
            var i = {
                inDuration: 300,
                outDuration: 225,
                constrain_width: !0,
                hover: !1,
                gutter: 0,
                belowOrigin: !1,
                alignment: "left"
            };
            this.each(function() {
                function n() {
                    void 0 !== s.data("induration") && (r.inDuration = s.data("inDuration")), void 0 !== s.data("outduration") && (r.outDuration = s.data("outDuration")), void 0 !== s.data("constrainwidth") && (r.constrain_width = s.data("constrainwidth")), void 0 !== s.data("hover") && (r.hover = s.data("hover")), void 0 !== s.data("gutter") && (r.gutter = s.data("gutter")), void 0 !== s.data("beloworigin") && (r.belowOrigin = s.data("beloworigin")), void 0 !== s.data("alignment") && (r.alignment = s.data("alignment"))
                }

                function a(e) {
                    "focus" === e && (l = !0), n(), u.addClass("active"), s.addClass("active"), r.constrain_width === !0 ? u.css("width", s.outerWidth()) : u.css("white-space", "nowrap");
                    var i, a = window.innerHeight,
                        o = s.innerHeight(),
                        c = s.offset().left,
                        d = s.offset().top - t(window).scrollTop(),
                        h = r.alignment,
                        f = 0;
                    if (r.belowOrigin === !0 && (f = o), c + u.innerWidth() > t(window).width() ? h = "right" : c - u.innerWidth() + s.innerWidth() < 0 && (h = "left"), d + u.innerHeight() > a)
                        if (d + o - u.innerHeight() < 0) {
                            var p = a - d - f;
                            u.css("max-height", p)
                        } else f || (f += o), f -= u.innerHeight();
                    if ("left" === h) i = r.gutter, leftPosition = s.position().left + i;
                    else if ("right" === h) {
                        var m = s.position().left + s.outerWidth() - u.outerWidth();
                        i = -r.gutter, leftPosition = m + i
                    }
                    u.css({
                        position: "absolute",
                        top: s.position().top + f,
                        left: leftPosition
                    }), u.stop(!0, !0).css("opacity", 0).slideDown({
                        queue: !1,
                        duration: r.inDuration,
                        easing: "easeOutCubic",
                        complete: function() {
                            t(this).css("height", "")
                        }
                    }).animate({
                        opacity: 1
                    }, {
                        queue: !1,
                        duration: r.inDuration,
                        easing: "easeOutSine"
                    })
                }

                function o() {
                    l = !1, u.fadeOut(r.outDuration), u.removeClass("active"), s.removeClass("active"), setTimeout(function() {
                        u.css("max-height", "")
                    }, r.outDuration)
                }
                var s = t(this),
                    r = t.extend({}, i, e),
                    l = !1,
                    u = t("#" + s.attr("data-activates"));
                if (n(), s.after(u), r.hover) {
                    var c = !1;
                    s.unbind("click." + s.attr("id")), s.on("mouseenter", function(t) {
                        c === !1 && (a(), c = !0)
                    }), s.on("mouseleave", function(e) {
                        var i = e.toElement || e.relatedTarget;
                        t(i).closest(".dropdown-content").is(u) || (u.stop(!0, !0), o(), c = !1)
                    }), u.on("mouseleave", function(e) {
                        var i = e.toElement || e.relatedTarget;
                        t(i).closest(".dropdown-button").is(s) || (u.stop(!0, !0), o(), c = !1)
                    })
                } else s.unbind("click." + s.attr("id")), s.bind("click." + s.attr("id"), function(e) {
                    l || (s[0] != e.currentTarget || s.hasClass("active") || 0 !== t(e.target).closest(".dropdown-content").length ? s.hasClass("active") && (o(), t(document).unbind("click." + u.attr("id") + " touchstart." + u.attr("id"))) : (e.preventDefault(), a("click")), u.hasClass("active") && t(document).bind("click." + u.attr("id") + " touchstart." + u.attr("id"), function(e) {
                        u.is(e.target) || s.is(e.target) || s.find(e.target).length || (o(), t(document).unbind("click." + u.attr("id") + " touchstart." + u.attr("id")))
                    }))
                });
                s.on("open", function(t, e) {
                    a(e)
                }), s.on("close", o)
            })
        }, t(document).ready(function() {
            t(".dropdown-button").dropdown()
        })
    }(jQuery),
    function(t) {
        var e = 0,
            i = 0,
            n = function() {
                return i++, "materialize-lean-overlay-" + i
            };
        t.fn.extend({
            openModal: function(i) {
                t("body").css("overflow", "hidden");
                var a = {
                        opacity: .5,
                        in_duration: 350,
                        out_duration: 250,
                        ready: void 0,
                        complete: void 0,
                        dismissible: !0,
                        starting_top: "4%"
                    },
                    o = n(),
                    s = t(this),
                    r = t('<div class="lean-overlay"></div>'),
                    l = ++e;
                r.attr("id", o).css("z-index", 1e3 + 2 * l), s.data("overlay-id", o).css("z-index", 1e3 + 2 * l + 1), t("body").append(r), i = t.extend(a, i), i.dismissible && (r.click(function() {
                    s.closeModal(i)
                }), t(document).on("keyup.leanModal" + o, function(t) {
                    27 === t.keyCode && s.closeModal(i)
                })), s.find(".modal-close").on("click.close", function(t) {
                    s.closeModal(i)
                }), r.css({
                    display: "block",
                    opacity: 0
                }), s.css({
                    display: "block",
                    opacity: 0
                }), r.velocity({
                    opacity: i.opacity
                }, {
                    duration: i.in_duration,
                    queue: !1,
                    ease: "easeOutCubic"
                }), s.data("associated-overlay", r[0]), s.hasClass("bottom-sheet") ? s.velocity({
                    bottom: "0",
                    opacity: 1
                }, {
                    duration: i.in_duration,
                    queue: !1,
                    ease: "easeOutCubic",
                    complete: function() {
                        "function" == typeof i.ready && i.ready()
                    }
                }) : (t.Velocity.hook(s, "scaleX", .7), s.css({
                    top: i.starting_top
                }), s.velocity({
                    top: "10%",
                    opacity: 1,
                    scaleX: "1"
                }, {
                    duration: i.in_duration,
                    queue: !1,
                    ease: "easeOutCubic",
                    complete: function() {
                        "function" == typeof i.ready && i.ready()
                    }
                }))
            }
        }), t.fn.extend({
            closeModal: function(i) {
                var n = {
                        out_duration: 250,
                        complete: void 0
                    },
                    a = t(this),
                    o = a.data("overlay-id"),
                    s = t("#" + o);
                i = t.extend(n, i), t("body").css("overflow", ""), a.find(".modal-close").off("click.close"), t(document).off("keyup.leanModal" + o), s.velocity({
                    opacity: 0
                }, {
                    duration: i.out_duration,
                    queue: !1,
                    ease: "easeOutQuart"
                }), a.hasClass("bottom-sheet") ? a.velocity({
                    bottom: "-100%",
                    opacity: 0
                }, {
                    duration: i.out_duration,
                    queue: !1,
                    ease: "easeOutCubic",
                    complete: function() {
                        s.css({
                            display: "none"
                        }), "function" == typeof i.complete && i.complete(), s.remove(), e--
                    }
                }) : a.velocity({
                    top: i.starting_top,
                    opacity: 0,
                    scaleX: .7
                }, {
                    duration: i.out_duration,
                    complete: function() {
                        t(this).css("display", "none"), "function" == typeof i.complete && i.complete(), s.remove(), e--
                    }
                })
            }
        }), t.fn.extend({
            leanModal: function(e) {
                return this.each(function() {
                    var i = {
                            starting_top: "4%"
                        },
                        n = t.extend(i, e);
                    t(this).click(function(e) {
                        n.starting_top = (t(this).offset().top - t(window).scrollTop()) / 1.15;
                        var i = t(this).attr("href") || "#" + t(this).data("target");
                        t(i).openModal(n), e.preventDefault()
                    })
                })
            }
        })
    }(jQuery),
    function(t) {
        t.fn.materialbox = function() {
            return this.each(function() {
                function e() {
                    o = !1;
                    var e = l.parent(".material-placeholder"),
                        n = (window.innerWidth, window.innerHeight, l.data("width")),
                        s = l.data("height");
                    l.velocity("stop", !0), t("#materialbox-overlay").velocity("stop", !0), t(".materialbox-caption").velocity("stop", !0), t("#materialbox-overlay").velocity({
                        opacity: 0
                    }, {
                        duration: r,
                        queue: !1,
                        easing: "easeOutQuad",
                        complete: function() {
                            a = !1, t(this).remove()
                        }
                    }), l.velocity({
                        width: n,
                        height: s,
                        left: 0,
                        top: 0
                    }, {
                        duration: r,
                        queue: !1,
                        easing: "easeOutQuad"
                    }), t(".materialbox-caption").velocity({
                        opacity: 0
                    }, {
                        duration: r,
                        queue: !1,
                        easing: "easeOutQuad",
                        complete: function() {
                            e.css({
                                height: "",
                                width: "",
                                position: "",
                                top: "",
                                left: ""
                            }), l.css({
                                height: "",
                                top: "",
                                left: "",
                                width: "",
                                "max-width": "",
                                position: "",
                                "z-index": ""
                            }), l.removeClass("active"), o = !0, t(this).remove(), i.css("overflow", "")
                        }
                    })
                }
                if (!t(this).hasClass("initialized")) {
                    t(this).addClass("initialized");
                    var i, n, a = !1,
                        o = !0,
                        s = 275,
                        r = 200,
                        l = t(this),
                        u = t("<div></div>").addClass("material-placeholder");
                    l.wrap(u), l.on("click", function() {
                        var r = l.parent(".material-placeholder"),
                            u = window.innerWidth,
                            c = window.innerHeight,
                            d = l.width(),
                            h = l.height();
                        if (o === !1) return e(), !1;
                        if (a && o === !0) return e(), !1;
                        for (o = !1, l.addClass("active"), a = !0, r.css({
                                width: r[0].getBoundingClientRect().width,
                                height: r[0].getBoundingClientRect().height,
                                position: "relative",
                                top: 0,
                                left: 0
                            }), i = void 0, n = r[0].parentNode; null !== n && !t(n).is(document);) {
                            var f = t(n);
                            "hidden" === f.css("overflow") && (f.css("overflow", "visible"), i = void 0 === i ? f : i.add(f)), n = n.parentNode
                        }
                        l.css({
                            position: "absolute",
                            "z-index": 1e3
                        }).data("width", d).data("height", h);
                        var p = t('<div id="materialbox-overlay"></div>').css({
                            opacity: 0
                        }).click(function() {
                            o === !0 && e()
                        });
                        if (t("body").append(p), p.velocity({
                                opacity: 1
                            }, {
                                duration: s,
                                queue: !1,
                                easing: "easeOutQuad"
                            }), "" !== l.data("caption")) {
                            var m = t('<div class="materialbox-caption"></div>');
                            m.text(l.data("caption")), t("body").append(m), m.css({
                                display: "inline"
                            }), m.velocity({
                                opacity: 1
                            }, {
                                duration: s,
                                queue: !1,
                                easing: "easeOutQuad"
                            })
                        }
                        var g = 0,
                            v = d / u,
                            y = h / c,
                            w = 0,
                            b = 0;
                        v > y ? (g = h / d, w = .9 * u, b = .9 * u * g) : (g = d / h, w = .9 * c * g, b = .9 * c), l.hasClass("responsive-img") ? l.velocity({
                            "max-width": w,
                            width: d
                        }, {
                            duration: 0,
                            queue: !1,
                            complete: function() {
                                l.css({
                                    left: 0,
                                    top: 0
                                }).velocity({
                                    height: b,
                                    width: w,
                                    left: t(document).scrollLeft() + u / 2 - l.parent(".material-placeholder").offset().left - w / 2,
                                    top: t(document).scrollTop() + c / 2 - l.parent(".material-placeholder").offset().top - b / 2
                                }, {
                                    duration: s,
                                    queue: !1,
                                    easing: "easeOutQuad",
                                    complete: function() {
                                        o = !0
                                    }
                                })
                            }
                        }) : l.css("left", 0).css("top", 0).velocity({
                            height: b,
                            width: w,
                            left: t(document).scrollLeft() + u / 2 - l.parent(".material-placeholder").offset().left - w / 2,
                            top: t(document).scrollTop() + c / 2 - l.parent(".material-placeholder").offset().top - b / 2
                        }, {
                            duration: s,
                            queue: !1,
                            easing: "easeOutQuad",
                            complete: function() {
                                o = !0
                            }
                        })
                    }), t(window).scroll(function() {
                        a && e()
                    }), t(document).keyup(function(t) {
                        27 === t.keyCode && o === !0 && a && e()
                    })
                }
            })
        }, t(document).ready(function() {
            t(".materialboxed").materialbox()
        })
    }(jQuery),
    function(t) {
        t.fn.parallax = function() {
            var e = t(window).width();
            return this.each(function(i) {
                function n(i) {
                    var n;
                    n = 601 > e ? a.height() > 0 ? a.height() : a.children("img").height() : a.height() > 0 ? a.height() : 500;
                    var o = a.children("img").first(),
                        s = o.height(),
                        r = s - n,
                        l = a.offset().top + n,
                        u = a.offset().top,
                        c = t(window).scrollTop(),
                        d = window.innerHeight,
                        h = c + d,
                        f = (h - u) / (n + d),
                        p = Math.round(r * f);
                    i && o.css("display", "block"), l > c && c + d > u && o.css("transform", "translate3D(-50%," + p + "px, 0)")
                }
                var a = t(this);
                a.addClass("parallax"), a.children("img").one("load", function() {
                    n(!0)
                }).each(function() {
                    this.complete && t(this).load()
                }), t(window).scroll(function() {
                    e = t(window).width(), n(!1)
                }), t(window).resize(function() {
                    e = t(window).width(), n(!1)
                })
            })
        }
    }(jQuery),
    function(t) {
        var e = {
            init: function() {
                return this.each(function() {
                    var e = t(this);
                    t(window).width(), e.width("100%");
                    var i, n, a = e.find("li.tab a"),
                        o = e.width(),
                        s = e.find("li").first().outerWidth(),
                        r = 0;
                    i = t(a.filter('[href="' + location.hash + '"]')), 0 === i.length && (i = t(this).find("li.tab a.active").first()), 0 === i.length && (i = t(this).find("li.tab a").first()), i.addClass("active"), r = a.index(i), 0 > r && (r = 0), n = t(i[0].hash), e.append('<div class="indicator"></div>');
                    var l = e.find(".indicator");
                    e.is(":visible") && (l.css({
                        right: o - (r + 1) * s
                    }), l.css({
                        left: r * s
                    })), t(window).resize(function() {
                        o = e.width(), s = e.find("li").first().outerWidth(), 0 > r && (r = 0), 0 !== s && 0 !== o && (l.css({
                            right: o - (r + 1) * s
                        }), l.css({
                            left: r * s
                        }))
                    }), a.not(i).each(function() {
                        t(this.hash).hide()
                    }), e.on("click", "a", function(u) {
                        if (t(this).parent().hasClass("disabled")) return void u.preventDefault();
                        o = e.width(), s = e.find("li").first().outerWidth(), i.removeClass("active"), n.hide(), i = t(this), n = t(this.hash), a = e.find("li.tab a"), i.addClass("active");
                        var c = r;
                        r = a.index(t(this)), 0 > r && (r = 0), n.show(), r - c >= 0 ? (l.velocity({
                            right: o - (r + 1) * s
                        }, {
                            duration: 300,
                            queue: !1,
                            easing: "easeOutQuad"
                        }), l.velocity({
                            left: r * s
                        }, {
                            duration: 300,
                            queue: !1,
                            easing: "easeOutQuad",
                            delay: 90
                        })) : (l.velocity({
                            left: r * s
                        }, {
                            duration: 300,
                            queue: !1,
                            easing: "easeOutQuad"
                        }), l.velocity({
                            right: o - (r + 1) * s
                        }, {
                            duration: 300,
                            queue: !1,
                            easing: "easeOutQuad",
                            delay: 90
                        })), u.preventDefault()
                    })
                })
            },
            select_tab: function(t) {
                this.find('a[href="#' + t + '"]').trigger("click")
            }
        };
        t.fn.tabs = function(i) {
            return e[i] ? e[i].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof i && i ? void t.error("Method " + i + " does not exist on jQuery.tooltip") : e.init.apply(this, arguments)
        }, t(document).ready(function() {
            t("ul.tabs").tabs()
        })
    }(jQuery),
    function(t) {
        t.fn.tooltip = function(i) {
            var n = 5,
                a = {
                    delay: 350
                };
            return "remove" === i ? (this.each(function() {
                t("#" + t(this).attr("data-tooltip-id")).remove(), t(this).off("mouseenter.tooltip mouseleave.tooltip")
            }), !1) : (i = t.extend(a, i), this.each(function() {
                var a = Materialize.guid(),
                    o = t(this);
                o.attr("data-tooltip-id", a);
                var s = t("<span></span>").text(o.attr("data-tooltip")),
                    r = t("<div></div>");
                r.addClass("material-tooltip").append(s).appendTo(t("body")).attr("id", a);
                var l = t("<div></div>").addClass("backdrop");
                l.appendTo(r), l.css({
                    top: 0,
                    left: 0
                }), o.off("mouseenter.tooltip mouseleave.tooltip");
                var u, c = !1;
                o.on({
                    "mouseenter.tooltip": function(t) {
                        var a = o.attr("data-delay");
                        a = void 0 === a || "" === a ? i.delay : a, u = setTimeout(function() {
                            c = !0, r.velocity("stop"), l.velocity("stop"), r.css({
                                display: "block",
                                left: "0px",
                                top: "0px"
                            }), r.children("span").text(o.attr("data-tooltip"));
                            var t, i, a, s = o.outerWidth(),
                                u = o.outerHeight(),
                                d = o.attr("data-position"),
                                h = r.outerHeight(),
                                f = r.outerWidth(),
                                p = "0px",
                                m = "0px",
                                g = 8;
                            "top" === d ? (t = o.offset().top - h - n, i = o.offset().left + s / 2 - f / 2, a = e(i, t, f, h), p = "-10px", l.css({
                                borderRadius: "14px 14px 0 0",
                                transformOrigin: "50% 90%",
                                marginTop: h,
                                marginLeft: f / 2 - l.width() / 2
                            })) : "left" === d ? (t = o.offset().top + u / 2 - h / 2, i = o.offset().left - f - n, a = e(i, t, f, h), m = "-10px", l.css({
                                width: "14px",
                                height: "14px",
                                borderRadius: "14px 0 0 14px",
                                transformOrigin: "95% 50%",
                                marginTop: h / 2,
                                marginLeft: f
                            })) : "right" === d ? (t = o.offset().top + u / 2 - h / 2, i = o.offset().left + s + n, a = e(i, t, f, h), m = "+10px", l.css({
                                width: "14px",
                                height: "14px",
                                borderRadius: "0 14px 14px 0",
                                transformOrigin: "5% 50%",
                                marginTop: h / 2,
                                marginLeft: "0px"
                            })) : (t = o.offset().top + o.outerHeight() + n, i = o.offset().left + s / 2 - f / 2, a = e(i, t, f, h), p = "+10px", l.css({
                                marginLeft: f / 2 - l.width() / 2
                            })), r.css({
                                top: a.y,
                                left: a.x
                            }), g = f / 8, 8 > g && (g = 8), ("right" === d || "left" === d) && (g = f / 10, 6 > g && (g = 6)), r.velocity({
                                marginTop: p,
                                marginLeft: m
                            }, {
                                duration: 350,
                                queue: !1
                            }).velocity({
                                opacity: 1
                            }, {
                                duration: 300,
                                delay: 50,
                                queue: !1
                            }), l.css({
                                display: "block"
                            }).velocity({
                                opacity: 1
                            }, {
                                duration: 55,
                                delay: 0,
                                queue: !1
                            }).velocity({
                                scale: g
                            }, {
                                duration: 300,
                                delay: 0,
                                queue: !1,
                                easing: "easeInOutQuad"
                            })
                        }, a)
                    },
                    "mouseleave.tooltip": function() {
                        c = !1, clearTimeout(u), setTimeout(function() {
                            1 != c && (r.velocity({
                                opacity: 0,
                                marginTop: 0,
                                marginLeft: 0
                            }, {
                                duration: 225,
                                queue: !1
                            }), l.velocity({
                                opacity: 0,
                                scale: 1
                            }, {
                                duration: 225,
                                queue: !1,
                                complete: function() {
                                    l.css("display", "none"), r.css("display", "none"), c = !1
                                }
                            }))
                        }, 225)
                    }
                })
            }))
        };
        var e = function(e, i, n, a) {
            var o = e,
                s = i;
            return 0 > o ? o = 4 : o + n > window.innerWidth && (o -= o + n - window.innerWidth), 0 > s ? s = 4 : s + a > window.innerHeight + t(window).scrollTop && (s -= s + a - window.innerHeight), {
                x: o,
                y: s
            }
        };
        t(document).ready(function() {
            t(".tooltipped").tooltip()
        })
    }(jQuery),
    function(t) {
        "use strict";

        function e(t) {
            return null !== t && t === t.window
        }

        function i(t) {
            return e(t) ? t : 9 === t.nodeType && t.defaultView
        }

        function n(t) {
            var e, n, a = {
                    top: 0,
                    left: 0
                },
                o = t && t.ownerDocument;
            return e = o.documentElement, "undefined" != typeof t.getBoundingClientRect && (a = t.getBoundingClientRect()), n = i(o), {
                top: a.top + n.pageYOffset - e.clientTop,
                left: a.left + n.pageXOffset - e.clientLeft
            }
        }

        function a(t) {
            var e = "";
            for (var i in t) t.hasOwnProperty(i) && (e += i + ":" + t[i] + ";");
            return e
        }

        function o(t) {
            if (c.allowEvent(t) === !1) return null;
            for (var e = null, i = t.target || t.srcElement; null !== i.parentElement;) {
                if (!(i instanceof SVGElement || -1 === i.className.indexOf("waves-effect"))) {
                    e = i;
                    break
                }
                if (i.classList.contains("waves-effect")) {
                    e = i;
                    break
                }
                i = i.parentElement
            }
            return e
        }

        function s(e) {
            var i = o(e);
            null !== i && (u.show(e, i), "ontouchstart" in t && (i.addEventListener("touchend", u.hide, !1), i.addEventListener("touchcancel", u.hide, !1)), i.addEventListener("mouseup", u.hide, !1), i.addEventListener("mouseleave", u.hide, !1))
        }
        var r = r || {},
            l = document.querySelectorAll.bind(document),
            u = {
                duration: 750,
                show: function(t, e) {
                    if (2 === t.button) return !1;
                    var i = e || this,
                        o = document.createElement("div");
                    o.className = "waves-ripple", i.appendChild(o);
                    var s = n(i),
                        r = t.pageY - s.top,
                        l = t.pageX - s.left,
                        c = "scale(" + i.clientWidth / 100 * 10 + ")";
                    "touches" in t && (r = t.touches[0].pageY - s.top, l = t.touches[0].pageX - s.left), o.setAttribute("data-hold", Date.now()), o.setAttribute("data-scale", c), o.setAttribute("data-x", l), o.setAttribute("data-y", r);
                    var d = {
                        top: r + "px",
                        left: l + "px"
                    };
                    o.className = o.className + " waves-notransition", o.setAttribute("style", a(d)), o.className = o.className.replace("waves-notransition", ""), d["-webkit-transform"] = c, d["-moz-transform"] = c, d["-ms-transform"] = c, d["-o-transform"] = c, d.transform = c, d.opacity = "1", d["-webkit-transition-duration"] = u.duration + "ms", d["-moz-transition-duration"] = u.duration + "ms", d["-o-transition-duration"] = u.duration + "ms", d["transition-duration"] = u.duration + "ms", d["-webkit-transition-timing-function"] = "cubic-bezier(0.250, 0.460, 0.450, 0.940)", d["-moz-transition-timing-function"] = "cubic-bezier(0.250, 0.460, 0.450, 0.940)", d["-o-transition-timing-function"] = "cubic-bezier(0.250, 0.460, 0.450, 0.940)", d["transition-timing-function"] = "cubic-bezier(0.250, 0.460, 0.450, 0.940)", o.setAttribute("style", a(d))
                },
                hide: function(t) {
                    c.touchup(t);
                    var e = this,
                        i = (1.4 * e.clientWidth, null),
                        n = e.getElementsByClassName("waves-ripple");
                    if (!(n.length > 0)) return !1;
                    i = n[n.length - 1];
                    var o = i.getAttribute("data-x"),
                        s = i.getAttribute("data-y"),
                        r = i.getAttribute("data-scale"),
                        l = Date.now() - Number(i.getAttribute("data-hold")),
                        d = 350 - l;
                    0 > d && (d = 0), setTimeout(function() {
                        var t = {
                            top: s + "px",
                            left: o + "px",
                            opacity: "0",
                            "-webkit-transition-duration": u.duration + "ms",
                            "-moz-transition-duration": u.duration + "ms",
                            "-o-transition-duration": u.duration + "ms",
                            "transition-duration": u.duration + "ms",
                            "-webkit-transform": r,
                            "-moz-transform": r,
                            "-ms-transform": r,
                            "-o-transform": r,
                            transform: r
                        };
                        i.setAttribute("style", a(t)), setTimeout(function() {
                            try {
                                e.removeChild(i)
                            } catch (t) {
                                return !1
                            }
                        }, u.duration)
                    }, d)
                },
                wrapInput: function(t) {
                    for (var e = 0; e < t.length; e++) {
                        var i = t[e];
                        if ("input" === i.tagName.toLowerCase()) {
                            var n = i.parentNode;
                            if ("i" === n.tagName.toLowerCase() && -1 !== n.className.indexOf("waves-effect")) continue;
                            var a = document.createElement("i");
                            a.className = i.className + " waves-input-wrapper";
                            var o = i.getAttribute("style");
                            o || (o = ""), a.setAttribute("style", o), i.className = "waves-button-input", i.removeAttribute("style"), n.replaceChild(a, i), a.appendChild(i)
                        }
                    }
                }
            },
            c = {
                touches: 0,
                allowEvent: function(t) {
                    var e = !0;
                    return "touchstart" === t.type ? c.touches += 1 : "touchend" === t.type || "touchcancel" === t.type ? setTimeout(function() {
                        c.touches > 0 && (c.touches -= 1)
                    }, 500) : "mousedown" === t.type && c.touches > 0 && (e = !1), e
                },
                touchup: function(t) {
                    c.allowEvent(t)
                }
            };
        r.displayEffect = function(e) {
            e = e || {}, "duration" in e && (u.duration = e.duration), u.wrapInput(l(".waves-effect")), "ontouchstart" in t && document.body.addEventListener("touchstart", s, !1), document.body.addEventListener("mousedown", s, !1)
        }, r.attach = function(e) {
            "input" === e.tagName.toLowerCase() && (u.wrapInput([e]), e = e.parentElement), "ontouchstart" in t && e.addEventListener("touchstart", s, !1), e.addEventListener("mousedown", s, !1)
        }, t.Waves = r, document.addEventListener("DOMContentLoaded", function() {
            r.displayEffect()
        }, !1)
    }(window), Materialize.toast = function(t, e, i, n) {
        function a(t) {
            var e = document.createElement("div");
            if (e.classList.add("toast"), i)
                for (var a = i.split(" "), o = 0, s = a.length; s > o; o++) e.classList.add(a[o]);
            ("object" == typeof HTMLElement ? t instanceof HTMLElement : t && "object" == typeof t && null !== t && 1 === t.nodeType && "string" == typeof t.nodeName) ? e.appendChild(t): t instanceof jQuery ? e.appendChild(t[0]) : e.innerHTML = t;
            var r = new Hammer(e, {
                prevent_default: !1
            });
            return r.on("pan", function(t) {
                var i = t.deltaX,
                    n = 80;
                e.classList.contains("panning") || e.classList.add("panning");
                var a = 1 - Math.abs(i / n);
                0 > a && (a = 0), Vel(e, {
                    left: i,
                    opacity: a
                }, {
                    duration: 50,
                    queue: !1,
                    easing: "easeOutQuad"
                })
            }), r.on("panend", function(t) {
                var i = t.deltaX,
                    a = 80;
                Math.abs(i) > a ? Vel(e, {
                    marginTop: "-40px"
                }, {
                    duration: 375,
                    easing: "easeOutExpo",
                    queue: !1,
                    complete: function() {
                        "function" == typeof n && n(), e.parentNode.removeChild(e)
                    }
                }) : (e.classList.remove("panning"), Vel(e, {
                    left: 0,
                    opacity: 1
                }, {
                    duration: 300,
                    easing: "easeOutExpo",
                    queue: !1
                }))
            }), e
        }
        i = i || "";
        var o = document.getElementById("toast-container");
        null === o && (o = document.createElement("div"), o.id = "toast-container", document.body.appendChild(o));
        var s = a(t);
        t && o.appendChild(s), s.style.top = "35px", s.style.opacity = 0, Vel(s, {
            top: "0px",
            opacity: 1
        }, {
            duration: 300,
            easing: "easeOutCubic",
            queue: !1
        });
        var r = e,
            l = setInterval(function() {
                null === s.parentNode && window.clearInterval(l), s.classList.contains("panning") || (r -= 20), 0 >= r && (Vel(s, {
                    opacity: 0,
                    marginTop: "-40px"
                }, {
                    duration: 375,
                    easing: "easeOutExpo",
                    queue: !1,
                    complete: function() {
                        "function" == typeof n && n(), this[0].parentNode.removeChild(this[0])
                    }
                }), window.clearInterval(l))
            }, 20)
    },
    function(t) {
        var e = {
            init: function(e) {
                var i = {
                    menuWidth: 240,
                    edge: "left",
                    closeOnClick: !1
                };
                e = t.extend(i, e), t(this).each(function() {
                    function i(i) {
                        s = !1, r = !1, t("body").css("overflow", ""), t("#sidenav-overlay").velocity({
                            opacity: 0
                        }, {
                            duration: 200,
                            queue: !1,
                            easing: "easeOutQuad",
                            complete: function() {
                                t(this).remove()
                            }
                        }), "left" === e.edge ? (o.css({
                            width: "",
                            right: "",
                            left: "0"
                        }), a.velocity({
                            left: -1 * (e.menuWidth + 10)
                        }, {
                            duration: 200,
                            queue: !1,
                            easing: "easeOutCubic",
                            complete: function() {
                                i === !0 && (a.removeAttr("style"), a.css("width", e.menuWidth))
                            }
                        })) : (o.css({
                            width: "",
                            right: "0",
                            left: ""
                        }), a.velocity({
                            right: -1 * (e.menuWidth + 10)
                        }, {
                            duration: 200,
                            queue: !1,
                            easing: "easeOutCubic",
                            complete: function() {
                                i === !0 && (a.removeAttr("style"), a.css("width", e.menuWidth))
                            }
                        }))
                    }
                    var n = t(this),
                        a = t("#" + n.attr("data-activates"));
                    240 != e.menuWidth && a.css("width", e.menuWidth);
                    var o = t('<div class="drag-target"></div>');
                    t("body").append(o), "left" == e.edge ? (a.css("left", -1 * (e.menuWidth + 10)), o.css({
                        left: 0
                    })) : (a.addClass("right-aligned").css("right", -1 * (e.menuWidth + 10)).css("left", ""), o.css({
                        right: 0
                    })), a.hasClass("fixed") && window.innerWidth > 992 && a.css("left", 0), a.hasClass("fixed") && t(window).resize(function() {
                        window.innerWidth > 992 ? 0 !== t("#sidenav-overlay").css("opacity") && r ? i(!0) : (a.removeAttr("style"), a.css("width", e.menuWidth)) : r === !1 && ("left" === e.edge ? a.css("left", -1 * (e.menuWidth + 10)) : a.css("right", -1 * (e.menuWidth + 10)))
                    }), e.closeOnClick === !0 && a.on("click.itemclick", "a:not(.collapsible-header)", function() {
                        i()
                    });
                    var s = !1,
                        r = !1;
                    o.on("click", function() {
                        i()
                    }), o.hammer({
                        prevent_default: !1
                    }).bind("pan", function(n) {
                        if ("touch" == n.gesture.pointerType) {
                            var o = (n.gesture.direction, n.gesture.center.x);
                            if (n.gesture.center.y, n.gesture.velocityX, t("body").css("overflow", "hidden"), 0 === t("#sidenav-overlay").length) {
                                var s = t('<div id="sidenav-overlay"></div>');
                                s.css("opacity", 0).click(function() {
                                    i()
                                }), t("body").append(s)
                            }
                            if ("left" === e.edge && (o > e.menuWidth ? o = e.menuWidth : 0 > o && (o = 0)), "left" === e.edge) o < e.menuWidth / 2 ? r = !1 : o >= e.menuWidth / 2 && (r = !0), a.css("left", o - e.menuWidth);
                            else {
                                o < window.innerWidth - e.menuWidth / 2 ? r = !0 : o >= window.innerWidth - e.menuWidth / 2 && (r = !1);
                                var l = -1 * (o - e.menuWidth / 2);
                                l > 0 && (l = 0), a.css("right", l)
                            }
                            var u;
                            "left" === e.edge ? (u = o / e.menuWidth, t("#sidenav-overlay").velocity({
                                opacity: u
                            }, {
                                duration: 50,
                                queue: !1,
                                easing: "easeOutQuad"
                            })) : (u = Math.abs((o - window.innerWidth) / e.menuWidth), t("#sidenav-overlay").velocity({
                                opacity: u
                            }, {
                                duration: 50,
                                queue: !1,
                                easing: "easeOutQuad"
                            }))
                        }
                    }).bind("panend", function(i) {
                        if ("touch" == i.gesture.pointerType) {
                            var n = i.gesture.velocityX;
                            s = !1, "left" === e.edge ? r && .3 >= n || -.5 > n ? (a.velocity({
                                left: 0
                            }, {
                                duration: 300,
                                queue: !1,
                                easing: "easeOutQuad"
                            }), t("#sidenav-overlay").velocity({
                                opacity: 1
                            }, {
                                duration: 50,
                                queue: !1,
                                easing: "easeOutQuad"
                            }), o.css({
                                width: "50%",
                                right: 0,
                                left: ""
                            })) : (!r || n > .3) && (t("body").css("overflow", ""), a.velocity({
                                left: -1 * (e.menuWidth + 10)
                            }, {
                                duration: 200,
                                queue: !1,
                                easing: "easeOutQuad"
                            }), t("#sidenav-overlay").velocity({
                                opacity: 0
                            }, {
                                duration: 200,
                                queue: !1,
                                easing: "easeOutQuad",
                                complete: function() {
                                    t(this).remove()
                                }
                            }), o.css({
                                width: "10px",
                                right: "",
                                left: 0
                            })) : r && n >= -.3 || n > .5 ? (a.velocity({
                                right: 0
                            }, {
                                duration: 300,
                                queue: !1,
                                easing: "easeOutQuad"
                            }), t("#sidenav-overlay").velocity({
                                opacity: 1
                            }, {
                                duration: 50,
                                queue: !1,
                                easing: "easeOutQuad"
                            }), o.css({
                                width: "50%",
                                right: "",
                                left: 0
                            })) : (!r || -.3 > n) && (t("body").css("overflow", ""), a.velocity({
                                right: -1 * (e.menuWidth + 10)
                            }, {
                                duration: 200,
                                queue: !1,
                                easing: "easeOutQuad"
                            }), t("#sidenav-overlay").velocity({
                                opacity: 0
                            }, {
                                duration: 200,
                                queue: !1,
                                easing: "easeOutQuad",
                                complete: function() {
                                    t(this).remove()
                                }
                            }), o.css({
                                width: "10px",
                                right: 0,
                                left: ""
                            }))
                        }
                    }), n.click(function() {
                        if (r === !0) r = !1, s = !1, i();
                        else {
                            t("body").css("overflow", "hidden"), t("body").append(o), "left" === e.edge ? (o.css({
                                width: "50%",
                                right: 0,
                                left: ""
                            }), a.velocity({
                                left: 0
                            }, {
                                duration: 300,
                                queue: !1,
                                easing: "easeOutQuad"
                            })) : (o.css({
                                width: "50%",
                                right: "",
                                left: 0
                            }), a.velocity({
                                right: 0
                            }, {
                                duration: 300,
                                queue: !1,
                                easing: "easeOutQuad"
                            }), a.css("left", ""));
                            var n = t('<div id="sidenav-overlay"></div>');
                            n.css("opacity", 0).click(function() {
                                r = !1, s = !1, i(), n.velocity({
                                    opacity: 0
                                }, {
                                    duration: 300,
                                    queue: !1,
                                    easing: "easeOutQuad",
                                    complete: function() {
                                        t(this).remove()
                                    }
                                })
                            }), t("body").append(n), n.velocity({
                                opacity: 1
                            }, {
                                duration: 300,
                                queue: !1,
                                easing: "easeOutQuad",
                                complete: function() {
                                    r = !0, s = !1
                                }
                            })
                        }
                        return !1
                    })
                })
            },
            show: function() {
                this.trigger("click")
            },
            hide: function() {
                t("#sidenav-overlay").trigger("click")
            }
        };
        t.fn.sideNav = function(i) {
            return e[i] ? e[i].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof i && i ? void t.error("Method " + i + " does not exist on jQuery.sideNav") : e.init.apply(this, arguments)
        }
    }(jQuery),
    function(t) {
        function e(e, i, n, a) {
            var o = t();
            return t.each(s, function(t, s) {
                if (s.height() > 0) {
                    var r = s.offset().top,
                        l = s.offset().left,
                        u = l + s.width(),
                        c = r + s.height(),
                        d = !(l > i || a > u || r > n || e > c);
                    d && o.push(s)
                }
            }), o
        }

        function i() {
            ++u;
            var i = o.scrollTop(),
                n = o.scrollLeft(),
                a = n + o.width(),
                s = i + o.height(),
                l = e(i + c.top + 200, a + c.right, s + c.bottom, n + c.left);
            t.each(l, function(t, e) {
                var i = e.data("scrollSpy:ticks");
                "number" != typeof i && e.triggerHandler("scrollSpy:enter"), e.data("scrollSpy:ticks", u)
            }), t.each(r, function(t, e) {
                var i = e.data("scrollSpy:ticks");
                "number" == typeof i && i !== u && (e.triggerHandler("scrollSpy:exit"), e.data("scrollSpy:ticks", null))
            }), r = l
        }

        function n() {
            o.trigger("scrollSpy:winSize")
        }

        function a(t, e, i) {
            var n, a, o, s = null,
                r = 0;
            i || (i = {});
            var l = function() {
                r = i.leading === !1 ? 0 : d(), s = null, o = t.apply(n, a), n = a = null
            };
            return function() {
                var u = d();
                r || i.leading !== !1 || (r = u);
                var c = e - (u - r);
                return n = this, a = arguments, 0 >= c ? (clearTimeout(s), s = null, r = u, o = t.apply(n, a), n = a = null) : s || i.trailing === !1 || (s = setTimeout(l, c)), o
            }
        }
        var o = t(window),
            s = [],
            r = [],
            l = !1,
            u = 0,
            c = {
                top: 0,
                right: 0,
                bottom: 0,
                left: 0
            },
            d = Date.now || function() {
                return (new Date).getTime()
            };
        t.scrollSpy = function(e, n) {
            var r = [];
            e = t(e), e.each(function(e, i) {
                s.push(t(i)), t(i).data("scrollSpy:id", e), t("a[href=#" + t(i).attr("id") + "]").click(function(e) {
                    e.preventDefault();
                    var i = t(this.hash).offset().top + 1;
                    t("html, body").animate({
                        scrollTop: i - 200
                    }, {
                        duration: 400,
                        queue: !1,
                        easing: "easeOutCubic"
                    })
                })
            }), n = n || {
                throttle: 100
            }, c.top = n.offsetTop || 0, c.right = n.offsetRight || 0, c.bottom = n.offsetBottom || 0, c.left = n.offsetLeft || 0;
            var u = a(i, n.throttle || 100),
                d = function() {
                    t(document).ready(u)
                };
            return l || (o.on("scroll", d), o.on("resize", d), l = !0), setTimeout(d, 0), e.on("scrollSpy:enter", function() {
                r = t.grep(r, function(t) {
                    return 0 != t.height()
                });
                var e = t(this);
                r[0] ? (t("a[href=#" + r[0].attr("id") + "]").removeClass("active"), e.data("scrollSpy:id") < r[0].data("scrollSpy:id") ? r.unshift(t(this)) : r.push(t(this))) : r.push(t(this)), t("a[href=#" + r[0].attr("id") + "]").addClass("active")
            }), e.on("scrollSpy:exit", function() {
                if (r = t.grep(r, function(t) {
                        return 0 != t.height()
                    }), r[0]) {
                    t("a[href=#" + r[0].attr("id") + "]").removeClass("active");
                    var e = t(this);
                    r = t.grep(r, function(t) {
                        return t.attr("id") != e.attr("id")
                    }), r[0] && t("a[href=#" + r[0].attr("id") + "]").addClass("active")
                }
            }), e
        }, t.winSizeSpy = function(e) {
            return t.winSizeSpy = function() {
                return o
            }, e = e || {
                throttle: 100
            }, o.on("resize", a(n, e.throttle || 100))
        }, t.fn.scrollSpy = function(e) {
            return t.scrollSpy(t(this), e)
        }
    }(jQuery),
    function(t) {
        t(document).ready(function() {
            function e(e) {
                var i = e.css("font-family"),
                    a = e.css("font-size");
                a && n.css("font-size", a), i && n.css("font-family", i), "off" === e.attr("wrap") && n.css("overflow-wrap", "normal").css("white-space", "pre"), n.text(e.val() + "\n");
                var o = n.html().replace(/\n/g, "<br>");
                n.html(o), e.is(":visible") ? n.css("width", e.width()) : n.css("width", t(window).width() / 2), e.css("height", n.height())
            }
            Materialize.updateTextFields = function() {
                var e = "input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=number], input[type=search], textarea";
                t(e).each(function(e, i) {
                    t(i).val().length > 0 || i.autofocus || void 0 !== t(this).attr("placeholder") || t(i)[0].validity.badInput === !0 ? t(this).siblings("label, i").addClass("active") : t(this).siblings("label, i").removeClass("active")
                })
            };
            var i = "input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=number], input[type=search], textarea";
            t(document).on("change", i, function() {
                (0 !== t(this).val().length || void 0 !== t(this).attr("placeholder")) && t(this).siblings("label").addClass("active"), validate_field(t(this))
            }), t(document).ready(function() {
                Materialize.updateTextFields()
            }), t(document).on("reset", function(e) {
                var n = t(e.target);
                n.is("form") && (n.find(i).removeClass("valid").removeClass("invalid"), n.find(i).each(function() {
                    "" === t(this).attr("value") && t(this).siblings("label, i").removeClass("active")
                }), n.find("select.initialized").each(function() {
                    var t = n.find("option[selected]").text();
                    n.siblings("input.select-dropdown").val(t)
                }))
            }), t(document).on("focus", i, function() {
                t(this).siblings("label, i").addClass("active")
            }), t(document).on("blur", i, function() {
                var e = t(this);
                0 === e.val().length && e[0].validity.badInput !== !0 && void 0 === e.attr("placeholder") && e.siblings("label, i").removeClass("active"), 0 === e.val().length && e[0].validity.badInput !== !0 && void 0 !== e.attr("placeholder") && e.siblings("i").removeClass("active"), validate_field(e)
            }), window.validate_field = function(t) {
                var e = void 0 !== t.attr("length"),
                    i = parseInt(t.attr("length")),
                    n = t.val().length;
                0 === t.val().length && t[0].validity.badInput === !1 ? t.hasClass("validate") && (t.removeClass("valid"), t.removeClass("invalid")) : t.hasClass("validate") && (t.is(":valid") && e && i >= n || t.is(":valid") && !e ? (t.removeClass("invalid"), t.addClass("valid")) : (t.removeClass("valid"), t.addClass("invalid")))
            };
            var n = t(".hiddendiv").first();
            n.length || (n = t('<div class="hiddendiv common"></div>'), t("body").append(n));
            var a = ".materialize-textarea";
            t(a).each(function() {
                var i = t(this);
                i.val().length && e(i)
            }), t("body").on("keyup keydown autoresize", a, function() {
                e(t(this))
            }), t(document).on("change", '.file-field input[type="file"]', function() {
                for (var e = t(this).closest(".file-field"), i = e.find("input.file-path"), n = t(this)[0].files, a = [], o = 0; o < n.length; o++) a.push(n[o].name);
                i.val(a.join(", ")), i.trigger("change")
            });
            var o, s = "input[type=range]",
                r = !1;
            t(s).each(function() {
                var e = t('<span class="thumb"><span class="value"></span></span>');
                t(this).after(e)
            });
            var l = ".range-field";
            t(document).on("change", s, function(e) {
                var i = t(this).siblings(".thumb");
                i.find(".value").html(t(this).val())
            }), t(document).on("input mousedown touchstart", s, function(e) {
                var i = t(this).siblings(".thumb"),
                    n = t(this).outerWidth();
                i.length <= 0 && (i = t('<span class="thumb"><span class="value"></span></span>'), t(this).after(i)), i.find(".value").html(t(this).val()), r = !0, t(this).addClass("active"), i.hasClass("active") || i.velocity({
                    height: "30px",
                    width: "30px",
                    top: "-20px",
                    marginLeft: "-15px"
                }, {
                    duration: 300,
                    easing: "easeOutExpo"
                }), "input" !== e.type && (o = void 0 === e.pageX || null === e.pageX ? e.originalEvent.touches[0].pageX - t(this).offset().left : e.pageX - t(this).offset().left, 0 > o ? o = 0 : o > n && (o = n), i.addClass("active").css("left", o)), i.find(".value").html(t(this).val())
            }), t(document).on("mouseup touchend", l, function() {
                r = !1, t(this).removeClass("active")
            }), t(document).on("mousemove touchmove", l, function(e) {
                var i, n = t(this).children(".thumb");
                if (r) {
                    n.hasClass("active") || n.velocity({
                        height: "30px",
                        width: "30px",
                        top: "-20px",
                        marginLeft: "-15px"
                    }, {
                        duration: 300,
                        easing: "easeOutExpo"
                    }), i = void 0 === e.pageX || null === e.pageX ? e.originalEvent.touches[0].pageX - t(this).offset().left : e.pageX - t(this).offset().left;
                    var a = t(this).outerWidth();
                    0 > i ? i = 0 : i > a && (i = a), n.addClass("active").css("left", i), n.find(".value").html(n.siblings(s).val())
                }
            }), t(document).on("mouseout touchleave", l, function() {
                if (!r) {
                    var e = t(this).children(".thumb");
                    e.hasClass("active") && e.velocity({
                        height: "0",
                        width: "0",
                        top: "10px",
                        marginLeft: "-6px"
                    }, {
                        duration: 100
                    }), e.removeClass("active")
                }
            })
        }), t.fn.material_select = function(e) {
            function i(t, e, i) {
                var a = t.indexOf(e),
                    o = -1 === a;
                return o ? t.push(e) : t.splice(a, 1), i.siblings("ul.dropdown-content").find("li").eq(e).toggleClass("active"), i.find("option").eq(e).prop("selected", o), n(t, i), o
            }

            function n(t, e) {
                for (var i = "", n = 0, a = t.length; a > n; n++) {
                    var o = e.find("option").eq(t[n]).text();
                    i += 0 === n ? o : ", " + o
                }
                "" === i && (i = e.find("option:disabled").eq(0).text()), e.siblings("input.select-dropdown").val(i)
            }
            t(this).each(function() {
                var n = t(this);
                if (!n.hasClass("browser-default")) {
                    var a = !!n.attr("multiple"),
                        o = n.data("select-id");
                    if (o && (n.parent().find("span.caret").remove(), n.parent().find("input").remove(), n.unwrap(), t("ul#select-options-" + o).remove()), "destroy" === e) return void n.data("select-id", null).removeClass("initialized");
                    var s = Materialize.guid();
                    n.data("select-id", s);
                    var r = t('<div class="select-wrapper"></div>');
                    r.addClass(n.attr("class"));
                    var l = t('<ul id="select-options-' + s + '" class="dropdown-content select-dropdown ' + (a ? "multiple-select-dropdown" : "") + '"></ul>'),
                        u = n.children("option, optgroup"),
                        c = [],
                        d = !1,
                        h = n.find("option:selected").html() || n.find("option:first").html() || "",
                        f = function(e, i, n) {
                            var a = i.is(":disabled") ? "disabled " : "",
                                o = i.data("icon"),
                                s = i.attr("class");
                            if (o) {
                                var r = "";
                                return s && (r = ' class="' + s + '"'), "multiple" === n ? l.append(t('<li class="' + a + '"><img src="' + o + '"' + r + '><span><input type="checkbox"' + a + "/><label></label>" + i.html() + "</span></li>")) : l.append(t('<li class="' + a + '"><img src="' + o + '"' + r + "><span>" + i.html() + "</span></li>")), !0
                            }
                            "multiple" === n ? l.append(t('<li class="' + a + '"><span><input type="checkbox"' + a + "/><label></label>" + i.html() + "</span></li>")) : l.append(t('<li class="' + a + '"><span>' + i.html() + "</span></li>"))
                        };
                    u.length && u.each(function() {
                        if (t(this).is("option")) a ? f(n, t(this), "multiple") : f(n, t(this));
                        else if (t(this).is("optgroup")) {
                            var e = t(this).children("option");
                            l.append(t('<li class="optgroup"><span>' + t(this).attr("label") + "</span></li>")), e.each(function() {
                                f(n, t(this))
                            })
                        }
                    }), l.find("li:not(.optgroup)").each(function(o) {
                        t(this).click(function(s) {
                            if (!t(this).hasClass("disabled") && !t(this).hasClass("optgroup")) {
                                var r = !0;
                                a ? (t('input[type="checkbox"]', this).prop("checked", function(t, e) {
                                    return !e
                                }), r = i(c, t(this).index(), n), g.trigger("focus")) : (l.find("li").removeClass("active"), t(this).toggleClass("active"), g.val(t(this).text())), activateOption(l, t(this)), n.find("option").eq(o).prop("selected", r), n.trigger("change"), "undefined" != typeof e && e()
                            }
                            s.stopPropagation()
                        })
                    }), n.wrap(r);
                    var p = t('<span class="caret">&#9660;</span>');
                    n.is(":disabled") && p.addClass("disabled");
                    var m = h.replace(/"/g, "&quot;"),
                        g = t('<input type="text" class="select-dropdown" readonly="true" ' + (n.is(":disabled") ? "disabled" : "") + ' data-activates="select-options-' + s + '" value="' + m + '"/>');
                    n.before(g), g.before(p), g.after(l), n.is(":disabled") || g.dropdown({
                        hover: !1,
                        closeOnClick: !1
                    }), n.attr("tabindex") && t(g[0]).attr("tabindex", n.attr("tabindex")), n.addClass("initialized"), g.on({
                        focus: function() {
                            if (t("ul.select-dropdown").not(l[0]).is(":visible") && t("input.select-dropdown").trigger("close"), !l.is(":visible")) {
                                t(this).trigger("open", ["focus"]);
                                var e = t(this).val(),
                                    i = l.find("li").filter(function() {
                                        return t(this).text().toLowerCase() === e.toLowerCase()
                                    })[0];
                                activateOption(l, i)
                            }
                        },
                        click: function(t) {
                            t.stopPropagation()
                        }
                    }), g.on("blur", function() {
                        a || t(this).trigger("close"), l.find("li.selected").removeClass("selected")
                    }), l.hover(function() {
                        d = !0
                    }, function() {
                        d = !1
                    }), t(window).on({
                        click: function() {
                            a && (d || g.trigger("close"))
                        }
                    }), a && n.find("option:selected:not(:disabled)").each(function() {
                        var e = t(this).index();
                        i(c, e, n), l.find("li").eq(e).find(":checkbox").prop("checked", !0)
                    }), activateOption = function(e, i) {
                        if (i) {
                            e.find("li.selected").removeClass("selected");
                            var n = t(i);
                            n.addClass("selected"), l.scrollTo(n)
                        }
                    };
                    var v = [],
                        y = function(e) {
                            if (9 == e.which) return void g.trigger("close");
                            if (40 == e.which && !l.is(":visible")) return void g.trigger("open");
                            if (13 != e.which || l.is(":visible")) {
                                e.preventDefault();
                                var i = String.fromCharCode(e.which).toLowerCase(),
                                    n = [9, 13, 27, 38, 40];
                                if (i && -1 === n.indexOf(e.which)) {
                                    v.push(i);
                                    var o = v.join(""),
                                        s = l.find("li").filter(function() {
                                            return 0 === t(this).text().toLowerCase().indexOf(o)
                                        })[0];
                                    s && activateOption(l, s)
                                }
                                if (13 == e.which) {
                                    var r = l.find("li.selected:not(.disabled)")[0];
                                    r && (t(r).trigger("click"), a || g.trigger("close"))
                                }
                                40 == e.which && (s = l.find("li.selected").length ? l.find("li.selected").next("li:not(.disabled)")[0] : l.find("li:not(.disabled)")[0], activateOption(l, s)), 27 == e.which && g.trigger("close"), 38 == e.which && (s = l.find("li.selected").prev("li:not(.disabled)")[0], s && activateOption(l, s)), setTimeout(function() {
                                    v = []
                                }, 1e3)
                            }
                        };
                    g.on("keydown", y)
                }
            })
        }
    }(jQuery),
    function(t) {
        var e = {
            init: function(e) {
                var i = {
                    indicators: !0,
                    height: 400,
                    transition: 500,
                    interval: 6e3
                };
                return e = t.extend(i, e), this.each(function() {
                    function i(t, e) {
                        t.hasClass("center-align") ? t.velocity({
                            opacity: 0,
                            translateY: -100
                        }, {
                            duration: e,
                            queue: !1
                        }) : t.hasClass("right-align") ? t.velocity({
                            opacity: 0,
                            translateX: 100
                        }, {
                            duration: e,
                            queue: !1
                        }) : t.hasClass("left-align") && t.velocity({
                            opacity: 0,
                            translateX: -100
                        }, {
                            duration: e,
                            queue: !1
                        })
                    }

                    function n(t) {
                        t >= u.length ? t = 0 : 0 > t && (t = u.length - 1), c = l.find(".active").index(), c != t && (a = u.eq(c), $caption = a.find(".caption"), a.removeClass("active"), a.velocity({
                            opacity: 0
                        }, {
                            duration: e.transition,
                            queue: !1,
                            easing: "easeOutQuad",
                            complete: function() {
                                u.not(".active").velocity({
                                    opacity: 0,
                                    translateX: 0,
                                    translateY: 0
                                }, {
                                    duration: 0,
                                    queue: !1
                                })
                            }
                        }), i($caption, e.transition), e.indicators && o.eq(c).removeClass("active"), u.eq(t).velocity({
                            opacity: 1
                        }, {
                            duration: e.transition,
                            queue: !1,
                            easing: "easeOutQuad"
                        }), u.eq(t).find(".caption").velocity({
                            opacity: 1,
                            translateX: 0,
                            translateY: 0
                        }, {
                            duration: e.transition,
                            delay: e.transition,
                            queue: !1,
                            easing: "easeOutQuad"
                        }), u.eq(t).addClass("active"), e.indicators && o.eq(t).addClass("active"))
                    }
                    var a, o, s, r = t(this),
                        l = r.find("ul.slides").first(),
                        u = l.find("li"),
                        c = l.find(".active").index(); - 1 != c && (a = u.eq(c)), r.hasClass("fullscreen") || (e.indicators ? r.height(e.height + 40) : r.height(e.height), l.height(e.height)), u.find(".caption").each(function() {
                        i(t(this), 0)
                    }), u.find("img").each(function() {
                        var e = "data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==";
                        t(this).attr("src") !== e && (t(this).css("background-image", "url(" + t(this).attr("src") + ")"), t(this).attr("src", e))
                    }), e.indicators && (o = t('<ul class="indicators"></ul>'), u.each(function(i) {
                        var a = t('<li class="indicator-item"></li>');
                        a.click(function() {
                            var i = l.parent(),
                                a = i.find(t(this)).index();
                            n(a), clearInterval(s), s = setInterval(function() {
                                c = l.find(".active").index(), u.length == c + 1 ? c = 0 : c += 1, n(c)
                            }, e.transition + e.interval)
                        }), o.append(a)
                    }), r.append(o), o = r.find("ul.indicators").find("li.indicator-item")), a ? a.show() : (u.first().addClass("active").velocity({
                        opacity: 1
                    }, {
                        duration: e.transition,
                        queue: !1,
                        easing: "easeOutQuad"
                    }), c = 0, a = u.eq(c), e.indicators && o.eq(c).addClass("active")), a.find("img").each(function() {
                        a.find(".caption").velocity({
                            opacity: 1,
                            translateX: 0,
                            translateY: 0
                        }, {
                            duration: e.transition,
                            queue: !1,
                            easing: "easeOutQuad"
                        })
                    }), s = setInterval(function() {
                        c = l.find(".active").index(), n(c + 1)
                    }, e.transition + e.interval);
                    var d = !1,
                        h = !1,
                        f = !1;
                    r.hammer({
                        prevent_default: !1
                    }).bind("pan", function(t) {
                        if ("touch" === t.gesture.pointerType) {
                            clearInterval(s);
                            var e = t.gesture.direction,
                                i = t.gesture.deltaX,
                                n = t.gesture.velocityX;
                            $curr_slide = l.find(".active"), $curr_slide.velocity({
                                translateX: i
                            }, {
                                duration: 50,
                                queue: !1,
                                easing: "easeOutQuad"
                            }), 4 === e && (i > r.innerWidth() / 2 || -.65 > n) ? f = !0 : 2 === e && (i < -1 * r.innerWidth() / 2 || n > .65) && (h = !0);
                            var a;
                            h && (a = $curr_slide.next(), 0 === a.length && (a = u.first()), a.velocity({
                                opacity: 1
                            }, {
                                duration: 300,
                                queue: !1,
                                easing: "easeOutQuad"
                            })), f && (a = $curr_slide.prev(), 0 === a.length && (a = u.last()), a.velocity({
                                opacity: 1
                            }, {
                                duration: 300,
                                queue: !1,
                                easing: "easeOutQuad"
                            }))
                        }
                    }).bind("panend", function(t) {
                        "touch" === t.gesture.pointerType && ($curr_slide = l.find(".active"), d = !1, curr_index = l.find(".active").index(), f || h ? h ? (n(curr_index + 1), $curr_slide.velocity({
                            translateX: -1 * r.innerWidth()
                        }, {
                            duration: 300,
                            queue: !1,
                            easing: "easeOutQuad",
                            complete: function() {
                                $curr_slide.velocity({
                                    opacity: 0,
                                    translateX: 0
                                }, {
                                    duration: 0,
                                    queue: !1
                                })
                            }
                        })) : f && (n(curr_index - 1), $curr_slide.velocity({
                            translateX: r.innerWidth()
                        }, {
                            duration: 300,
                            queue: !1,
                            easing: "easeOutQuad",
                            complete: function() {
                                $curr_slide.velocity({
                                    opacity: 0,
                                    translateX: 0
                                }, {
                                    duration: 0,
                                    queue: !1
                                })
                            }
                        })) : $curr_slide.velocity({
                            translateX: 0
                        }, {
                            duration: 300,
                            queue: !1,
                            easing: "easeOutQuad"
                        }), h = !1, f = !1, clearInterval(s), s = setInterval(function() {
                            c = l.find(".active").index(), u.length == c + 1 ? c = 0 : c += 1, n(c)
                        }, e.transition + e.interval))
                    }), r.on("sliderPause", function() {
                        clearInterval(s)
                    }), r.on("sliderStart", function() {
                        clearInterval(s), s = setInterval(function() {
                            c = l.find(".active").index(), u.length == c + 1 ? c = 0 : c += 1, n(c)
                        }, e.transition + e.interval)
                    }), r.on("sliderNext", function() {
                        c = l.find(".active").index(), n(c + 1)
                    }), r.on("sliderPrev", function() {
                        c = l.find(".active").index(), n(c - 1)
                    })
                })
            },
            pause: function() {
                t(this).trigger("sliderPause")
            },
            start: function() {
                t(this).trigger("sliderStart")
            },
            next: function() {
                t(this).trigger("sliderNext")
            },
            prev: function() {
                t(this).trigger("sliderPrev")
            }
        };
        t.fn.slider = function(i) {
            return e[i] ? e[i].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof i && i ? void t.error("Method " + i + " does not exist on jQuery.tooltip") : e.init.apply(this, arguments)
        }
    }(jQuery),
    function(t) {
        t(document).ready(function() {
            t(document).on("click.card", ".card", function(e) {
                t(this).find("> .card-reveal").length && (t(e.target).is(t(".card-reveal .card-title")) || t(e.target).is(t(".card-reveal .card-title i")) ? t(this).find(".card-reveal").velocity({
                    translateY: 0
                }, {
                    duration: 225,
                    queue: !1,
                    easing: "easeInOutQuad",
                    complete: function() {
                        t(this).css({
                            display: "none"
                        })
                    }
                }) : (t(e.target).is(t(".card .activator")) || t(e.target).is(t(".card .activator i"))) && (t(e.target).closest(".card").css("overflow", "hidden"), t(this).find(".card-reveal").css({
                    display: "block"
                }).velocity("stop", !1).velocity({
                    translateY: "-100%"
                }, {
                    duration: 300,
                    queue: !1,
                    easing: "easeInOutQuad"
                }))), t(".card-reveal").closest(".card").css("overflow", "hidden")
            })
        })
    }(jQuery),
    function(t) {
        t(document).ready(function() {
            t(document).on("click.chip", ".chip .material-icons", function(e) {
                t(this).parent().remove()
            })
        })
    }(jQuery),
    function(t) {
        t(document).ready(function() {
            t.fn.pushpin = function(e) {
                var i = {
                    top: 0,
                    bottom: 1 / 0,
                    offset: 0
                };
                return e = t.extend(i, e), $index = 0, this.each(function() {
                    function i(t) {
                        t.removeClass("pin-top"), t.removeClass("pinned"), t.removeClass("pin-bottom")
                    }

                    function n(n, a) {
                        n.each(function() {
                            e.top <= a && e.bottom >= a && !t(this).hasClass("pinned") && (i(t(this)), t(this).css("top", e.offset), t(this).addClass("pinned")), a < e.top && !t(this).hasClass("pin-top") && (i(t(this)), t(this).css("top", 0), t(this).addClass("pin-top")), a > e.bottom && !t(this).hasClass("pin-bottom") && (i(t(this)), t(this).addClass("pin-bottom"), t(this).css("top", e.bottom - s))
                        })
                    }
                    var a = Materialize.guid(),
                        o = t(this),
                        s = t(this).offset().top;
                    n(o, t(window).scrollTop()), t(window).on("scroll." + a, function() {
                        var i = t(window).scrollTop() + e.offset;
                        n(o, i)
                    })
                })
            }
        })
    }(jQuery),
    function(t) {
        t(document).ready(function() {
            t.fn.reverse = [].reverse, t(document).on("mouseenter.fixedActionBtn", ".fixed-action-btn:not(.click-to-toggle)", function(i) {
                var n = t(this);
                e(n)
            }), t(document).on("mouseleave.fixedActionBtn", ".fixed-action-btn:not(.click-to-toggle)", function(e) {
                var n = t(this);
                i(n)
            }), t(document).on("click.fixedActionBtn", ".fixed-action-btn.click-to-toggle > a", function(n) {
                var a = t(this),
                    o = a.parent();
                o.hasClass("active") ? i(o) : e(o)
            })
        }), t.fn.extend({
            openFAB: function() {
                e(t(this))
            },
            closeFAB: function() {
                i(t(this))
            }
        });
        var e = function(e) {
                if ($this = e, $this.hasClass("active") === !1) {
                    var i, n, a = $this.hasClass("horizontal");
                    a === !0 ? n = 40 : i = 40, $this.addClass("active"), $this.find("ul .btn-floating").velocity({
                        scaleY: ".4",
                        scaleX: ".4",
                        translateY: i + "px",
                        translateX: n + "px"
                    }, {
                        duration: 0
                    });
                    var o = 0;
                    $this.find("ul .btn-floating").reverse().each(function() {
                        t(this).velocity({
                            opacity: "1",
                            scaleX: "1",
                            scaleY: "1",
                            translateY: "0",
                            translateX: "0"
                        }, {
                            duration: 80,
                            delay: o
                        }), o += 40
                    })
                }
            },
            i = function(t) {
                $this = t;
                var e, i, n = $this.hasClass("horizontal");
                n === !0 ? i = 40 : e = 40, $this.removeClass("active"), $this.find("ul .btn-floating").velocity("stop", !0), $this.find("ul .btn-floating").velocity({
                    opacity: "0",
                    scaleX: ".4",
                    scaleY: ".4",
                    translateY: e + "px",
                    translateX: i + "px"
                }, {
                    duration: 80
                })
            }
    }(jQuery),
    function(t) {
        Materialize.fadeInImage = function(e) {
            var i = t(e);
            i.css({
                opacity: 0
            }), t(i).velocity({
                opacity: 1
            }, {
                duration: 650,
                queue: !1,
                easing: "easeOutSine"
            }), t(i).velocity({
                opacity: 1
            }, {
                duration: 1300,
                queue: !1,
                easing: "swing",
                step: function(e, i) {
                    i.start = 100;
                    var n = e / 100,
                        a = 150 - (100 - e) / 1.75;
                    100 > a && (a = 100), e >= 0 && t(this).css({
                        "-webkit-filter": "grayscale(" + n + ")brightness(" + a + "%)",
                        filter: "grayscale(" + n + ")brightness(" + a + "%)"
                    })
                }
            })
        }, Materialize.showStaggeredList = function(e) {
            var i = 0;
            t(e).find("li").velocity({
                translateX: "-100px"
            }, {
                duration: 0
            }), t(e).find("li").each(function() {
                t(this).velocity({
                    opacity: "1",
                    translateX: "0"
                }, {
                    duration: 800,
                    delay: i,
                    easing: [60, 10]
                }), i += 120
            })
        }, t(document).ready(function() {
            var e = !1,
                i = !1;
            t(".dismissable").each(function() {
                t(this).hammer({
                    prevent_default: !1
                }).bind("pan", function(n) {
                    if ("touch" === n.gesture.pointerType) {
                        var a = t(this),
                            o = n.gesture.direction,
                            s = n.gesture.deltaX,
                            r = n.gesture.velocityX;
                        a.velocity({
                            translateX: s
                        }, {
                            duration: 50,
                            queue: !1,
                            easing: "easeOutQuad"
                        }), 4 === o && (s > a.innerWidth() / 2 || -.75 > r) && (e = !0), 2 === o && (s < -1 * a.innerWidth() / 2 || r > .75) && (i = !0)
                    }
                }).bind("panend", function(n) {
                    if (Math.abs(n.gesture.deltaX) < t(this).innerWidth() / 2 && (i = !1, e = !1), "touch" === n.gesture.pointerType) {
                        var a = t(this);
                        if (e || i) {
                            var o;
                            o = e ? a.innerWidth() : -1 * a.innerWidth(), a.velocity({
                                translateX: o
                            }, {
                                duration: 100,
                                queue: !1,
                                easing: "easeOutQuad",
                                complete: function() {
                                    a.css("border", "none"), a.velocity({
                                        height: 0,
                                        padding: 0
                                    }, {
                                        duration: 200,
                                        queue: !1,
                                        easing: "easeOutQuad",
                                        complete: function() {
                                            a.remove()
                                        }
                                    })
                                }
                            })
                        } else a.velocity({
                            translateX: 0
                        }, {
                            duration: 100,
                            queue: !1,
                            easing: "easeOutQuad"
                        });
                        e = !1, i = !1
                    }
                })
            })
        })
    }(jQuery),
    function(t) {
        Materialize.scrollFire = function(t) {
            var e = !1;
            window.addEventListener("scroll", function() {
                e = !0
            }), setInterval(function() {
                if (e) {
                    e = !1;
                    for (var i = window.pageYOffset + window.innerHeight, n = 0; n < t.length; n++) {
                        var a = t[n],
                            o = a.selector,
                            s = a.offset,
                            r = a.callback,
                            l = document.querySelector(o);
                        if (null !== l) {
                            var u = l.getBoundingClientRect().top + window.pageYOffset;
                            if (i > u + s && a.done !== !0) {
                                var c = new Function(r);
                                c(), a.done = !0
                            }
                        }
                    }
                }
            }, 100)
        }
    }(jQuery),
    function(t) {
        "function" == typeof define && define.amd ? define("picker", ["jquery"], t) : "object" == typeof exports ? module.exports = t(require("jquery")) : this.Picker = t(jQuery)
    }(function(t) {
        function e(o, s, l, d) {
            function h() {
                return e._.node("div", e._.node("div", e._.node("div", e._.node("div", S.component.nodes(w.open), _.box), _.wrap), _.frame), _.holder)
            }

            function f() {
                C.data(s, S).addClass(_.input).attr("tabindex", -1).val(C.data("value") ? S.get("select", b.format) : o.value), b.editable || C.on("focus." + w.id + " click." + w.id, function(t) {
                    t.preventDefault(), S.$root[0].focus()
                }).on("keydown." + w.id, g), a(o, {
                    haspopup: !0,
                    expanded: !1,
                    readonly: !1,
                    owns: o.id + "_root"
                })
            }

            function p() {
                S.$root.on({
                    keydown: g,
                    focusin: function(t) {
                        S.$root.removeClass(_.focused), t.stopPropagation()
                    },
                    "mousedown click": function(e) {
                        var i = e.target;
                        i != S.$root.children()[0] && (e.stopPropagation(), "mousedown" != e.type || t(i).is("input, select, textarea, button, option") || (e.preventDefault(), S.$root[0].focus()))
                    }
                }).on({
                    focus: function() {
                        C.addClass(_.target)
                    },
                    blur: function() {
                        C.removeClass(_.target)
                    }
                }).on("focus.toOpen", v).on("click", "[data-pick], [data-nav], [data-clear], [data-close]", function() {
                    var e = t(this),
                        i = e.data(),
                        n = e.hasClass(_.navDisabled) || e.hasClass(_.disabled),
                        a = r();
                    a = a && (a.type || a.href), (n || a && !t.contains(S.$root[0], a)) && S.$root[0].focus(), !n && i.nav ? S.set("highlight", S.component.item.highlight, {
                        nav: i.nav
                    }) : !n && "pick" in i ? S.set("select", i.pick) : i.clear ? S.clear().close(!0) : i.close && S.close(!0)
                }), a(S.$root[0], "hidden", !0)
            }

            function m() {
                var e;
                b.hiddenName === !0 ? (e = o.name, o.name = "") : (e = ["string" == typeof b.hiddenPrefix ? b.hiddenPrefix : "", "string" == typeof b.hiddenSuffix ? b.hiddenSuffix : "_submit"], e = e[0] + o.name + e[1]), S._hidden = t('<input type=hidden name="' + e + '"' + (C.data("value") || o.value ? ' value="' + S.get("select", b.formatSubmit) + '"' : "") + ">")[0], C.on("change." + w.id, function() {
                    S._hidden.value = o.value ? S.get("select", b.formatSubmit) : ""
                }), b.container ? t(b.container).append(S._hidden) : C.after(S._hidden)
            }

            function g(t) {
                var e = t.keyCode,
                    i = /^(8|46)$/.test(e);
                return 27 == e ? (S.close(), !1) : void((32 == e || i || !w.open && S.component.key[e]) && (t.preventDefault(), t.stopPropagation(), i ? S.clear().close() : S.open()))
            }

            function v(t) {
                t.stopPropagation(), "focus" == t.type && S.$root.addClass(_.focused), S.open()
            }
            if (!o) return e;
            var y = !1,
                w = {
                    id: o.id || "P" + Math.abs(~~(Math.random() * new Date))
                },
                b = l ? t.extend(!0, {}, l.defaults, d) : d || {},
                _ = t.extend({}, e.klasses(), b.klass),
                C = t(o),
                x = function() {
                    return this.start()
                },
                S = x.prototype = {
                    constructor: x,
                    $node: C,
                    start: function() {
                        return w && w.start ? S : (w.methods = {}, w.start = !0, w.open = !1, w.type = o.type, o.autofocus = o == r(), o.readOnly = !b.editable, o.id = o.id || w.id, "text" != o.type && (o.type = "text"), S.component = new l(S, b), S.$root = t(e._.node("div", h(), _.picker, 'id="' + o.id + '_root" tabindex="0"')), p(), b.formatSubmit && m(), f(), b.container ? t(b.container).append(S.$root) : C.after(S.$root), S.on({
                            start: S.component.onStart,
                            render: S.component.onRender,
                            stop: S.component.onStop,
                            open: S.component.onOpen,
                            close: S.component.onClose,
                            set: S.component.onSet
                        }).on({
                            start: b.onStart,
                            render: b.onRender,
                            stop: b.onStop,
                            open: b.onOpen,
                            close: b.onClose,
                            set: b.onSet
                        }), y = i(S.$root.children()[0]), o.autofocus && S.open(), S.trigger("start").trigger("render"))
                    },
                    render: function(t) {
                        return t ? S.$root.html(h()) : S.$root.find("." + _.box).html(S.component.nodes(w.open)), S.trigger("render")
                    },
                    stop: function() {
                        return w.start ? (S.close(), S._hidden && S._hidden.parentNode.removeChild(S._hidden), S.$root.remove(), C.removeClass(_.input).removeData(s), setTimeout(function() {
                            C.off("." + w.id)
                        }, 0), o.type = w.type, o.readOnly = !1, S.trigger("stop"), w.methods = {}, w.start = !1, S) : S
                    },
                    open: function(i) {
                        return w.open ? S : (C.addClass(_.active), a(o, "expanded", !0), setTimeout(function() {
                            S.$root.addClass(_.opened), a(S.$root[0], "hidden", !1)
                        }, 0), i !== !1 && (w.open = !0, y && c.css("overflow", "hidden").css("padding-right", "+=" + n()), S.$root[0].focus(), u.on("click." + w.id + " focusin." + w.id, function(t) {
                            var e = t.target;
                            e != o && e != document && 3 != t.which && S.close(e === S.$root.children()[0])
                        }).on("keydown." + w.id, function(i) {
                            var n = i.keyCode,
                                a = S.component.key[n],
                                o = i.target;
                            27 == n ? S.close(!0) : o != S.$root[0] || !a && 13 != n ? t.contains(S.$root[0], o) && 13 == n && (i.preventDefault(), o.click()) : (i.preventDefault(), a ? e._.trigger(S.component.key.go, S, [e._.trigger(a)]) : S.$root.find("." + _.highlighted).hasClass(_.disabled) || S.set("select", S.component.item.highlight).close())
                        })), S.trigger("open"))
                    },
                    close: function(t) {
                        return t && (S.$root.off("focus.toOpen")[0].focus(), setTimeout(function() {
                            S.$root.on("focus.toOpen", v)
                        }, 0)), C.removeClass(_.active), a(o, "expanded", !1), setTimeout(function() {
                            S.$root.removeClass(_.opened + " " + _.focused), a(S.$root[0], "hidden", !0)
                        }, 0), w.open ? (w.open = !1, y && c.css("overflow", "").css("padding-right", "-=" + n()), u.off("." + w.id), S.trigger("close")) : S
                    },
                    clear: function(t) {
                        return S.set("clear", null, t)
                    },
                    set: function(e, i, n) {
                        var a, o, s = t.isPlainObject(e),
                            r = s ? e : {};
                        if (n = s && t.isPlainObject(i) ? i : n || {}, e) {
                            s || (r[e] = i);
                            for (a in r) o = r[a], a in S.component.item && (void 0 === o && (o = null), S.component.set(a, o, n)), ("select" == a || "clear" == a) && C.val("clear" == a ? "" : S.get(a, b.format)).trigger("change");
                            S.render()
                        }
                        return n.muted ? S : S.trigger("set", r)
                    },
                    get: function(t, i) {
                        if (t = t || "value", null != w[t]) return w[t];
                        if ("valueSubmit" == t) {
                            if (S._hidden) return S._hidden.value;
                            t = "value"
                        }
                        if ("value" == t) return o.value;
                        if (t in S.component.item) {
                            if ("string" == typeof i) {
                                var n = S.component.get(t);
                                return n ? e._.trigger(S.component.formats.toString, S.component, [i, n]) : ""
                            }
                            return S.component.get(t)
                        }
                    },
                    on: function(e, i, n) {
                        var a, o, s = t.isPlainObject(e),
                            r = s ? e : {};
                        if (e) {
                            s || (r[e] = i);
                            for (a in r) o = r[a], n && (a = "_" + a), w.methods[a] = w.methods[a] || [], w.methods[a].push(o)
                        }
                        return S
                    },
                    off: function() {
                        var t, e, i = arguments;
                        for (t = 0, namesCount = i.length; t < namesCount; t += 1) e = i[t], e in w.methods && delete w.methods[e];
                        return S
                    },
                    trigger: function(t, i) {
                        var n = function(t) {
                            var n = w.methods[t];
                            n && n.map(function(t) {
                                e._.trigger(t, S, [i])
                            })
                        };
                        return n("_" + t), n(t), S
                    }
                };
            return new x
        }

        function i(t) {
            var e, i = "position";
            return t.currentStyle ? e = t.currentStyle[i] : window.getComputedStyle && (e = getComputedStyle(t)[i]), "fixed" == e
        }

        function n() {
            if (c.height() <= l.height()) return 0;
            var e = t('<div style="visibility:hidden;width:100px" />').appendTo("body"),
                i = e[0].offsetWidth;
            e.css("overflow", "scroll");
            var n = t('<div style="width:100%" />').appendTo(e),
                a = n[0].offsetWidth;
            return e.remove(), i - a
        }

        function a(e, i, n) {
            if (t.isPlainObject(i))
                for (var a in i) o(e, a, i[a]);
            else o(e, i, n)
        }

        function o(t, e, i) {
            t.setAttribute(("role" == e ? "" : "aria-") + e, i)
        }

        function s(e, i) {
            t.isPlainObject(e) || (e = {
                attribute: i
            }), i = "";
            for (var n in e) {
                var a = ("role" == n ? "" : "aria-") + n,
                    o = e[n];
                i += null == o ? "" : a + '="' + e[n] + '"'
            }
            return i
        }

        function r() {
            try {
                return document.activeElement
            } catch (t) {}
        }
        var l = t(window),
            u = t(document),
            c = t(document.documentElement);
        return e.klasses = function(t) {
            return t = t || "picker", {
                picker: t,
                opened: t + "--opened",
                focused: t + "--focused",
                input: t + "__input",
                active: t + "__input--active",
                target: t + "__input--target",
                holder: t + "__holder",
                frame: t + "__frame",
                wrap: t + "__wrap",
                box: t + "__box"
            }
        }, e._ = {
            group: function(t) {
                for (var i, n = "", a = e._.trigger(t.min, t); a <= e._.trigger(t.max, t, [a]); a += t.i) i = e._.trigger(t.item, t, [a]), n += e._.node(t.node, i[0], i[1], i[2]);
                return n
            },
            node: function(e, i, n, a) {
                return i ? (i = t.isArray(i) ? i.join("") : i, n = n ? ' class="' + n + '"' : "", a = a ? " " + a : "", "<" + e + n + a + ">" + i + "</" + e + ">") : ""
            },
            lead: function(t) {
                return (10 > t ? "0" : "") + t
            },
            trigger: function(t, e, i) {
                return "function" == typeof t ? t.apply(e, i || []) : t
            },
            digits: function(t) {
                return /\d/.test(t[1]) ? 2 : 1
            },
            isDate: function(t) {
                return {}.toString.call(t).indexOf("Date") > -1 && this.isInteger(t.getDate())
            },
            isInteger: function(t) {
                return {}.toString.call(t).indexOf("Number") > -1 && t % 1 === 0
            },
            ariaAttr: s
        }, e.extend = function(i, n) {
            t.fn[i] = function(a, o) {
                var s = this.data(i);
                return "picker" == a ? s : s && "string" == typeof a ? e._.trigger(s[a], s, [o]) : this.each(function() {
                    var o = t(this);
                    o.data(i) || new e(this, i, n, a)
                })
            }, t.fn[i].defaults = n.defaults
        }, e
    }),
    function(t) {
        "function" == typeof define && define.amd ? define(["picker", "jquery"], t) : "object" == typeof exports ? module.exports = t(require("./picker.js"), require("jquery")) : t(Picker, jQuery)
    }(function(t, e) {
        function i(t, e) {
            var i = this,
                n = t.$node[0],
                a = n.value,
                o = t.$node.data("value"),
                s = o || a,
                r = o ? e.formatSubmit : e.format,
                l = function() {
                    return n.currentStyle ? "rtl" == n.currentStyle.direction : "rtl" == getComputedStyle(t.$root[0]).direction
                };
            i.settings = e, i.$node = t.$node, i.queue = {
                min: "measure create",
                max: "measure create",
                now: "now create",
                select: "parse create validate",
                highlight: "parse navigate create validate",
                view: "parse create validate viewset",
                disable: "deactivate",
                enable: "activate"
            }, i.item = {}, i.item.clear = null, i.item.disable = (e.disable || []).slice(0), i.item.enable = - function(t) {
                return t[0] === !0 ? t.shift() : -1
            }(i.item.disable), i.set("min", e.min).set("max", e.max).set("now"), s ? i.set("select", s, {
                format: r
            }) : i.set("select", null).set("highlight", i.item.now), i.key = {
                40: 7,
                38: -7,
                39: function() {
                    return l() ? -1 : 1
                },
                37: function() {
                    return l() ? 1 : -1
                },
                go: function(t) {
                    var e = i.item.highlight,
                        n = new Date(e.year, e.month, e.date + t);
                    i.set("highlight", n, {
                        interval: t
                    }), this.render()
                }
            }, t.on("render", function() {
                t.$root.find("." + e.klass.selectMonth).on("change", function() {
                    var i = this.value;
                    i && (t.set("highlight", [t.get("view").year, i, t.get("highlight").date]), t.$root.find("." + e.klass.selectMonth).trigger("focus"))
                }), t.$root.find("." + e.klass.selectYear).on("change", function() {
                    var i = this.value;
                    i && (t.set("highlight", [i, t.get("view").month, t.get("highlight").date]), t.$root.find("." + e.klass.selectYear).trigger("focus"))
                })
            }, 1).on("open", function() {
                var n = "";
                i.disabled(i.get("now")) && (n = ":not(." + e.klass.buttonToday + ")"), t.$root.find("button" + n + ", select").attr("disabled", !1)
            }, 1).on("close", function() {
                t.$root.find("button, select").attr("disabled", !0)
            }, 1)
        }
        var n = 7,
            a = 6,
            o = t._;
        i.prototype.set = function(t, e, i) {
            var n = this,
                a = n.item;
            return null === e ? ("clear" == t && (t = "select"), a[t] = e, n) : (a["enable" == t ? "disable" : "flip" == t ? "enable" : t] = n.queue[t].split(" ").map(function(a) {
                return e = n[a](t, e, i)
            }).pop(), "select" == t ? n.set("highlight", a.select, i) : "highlight" == t ? n.set("view", a.highlight, i) : t.match(/^(flip|min|max|disable|enable)$/) && (a.select && n.disabled(a.select) && n.set("select", a.select, i), a.highlight && n.disabled(a.highlight) && n.set("highlight", a.highlight, i)), n)
        }, i.prototype.get = function(t) {
            return this.item[t]
        }, i.prototype.create = function(t, i, n) {
            var a, s = this;
            return i = void 0 === i ? t : i, i == -(1 / 0) || i == 1 / 0 ? a = i : e.isPlainObject(i) && o.isInteger(i.pick) ? i = i.obj : e.isArray(i) ? (i = new Date(i[0], i[1], i[2]), i = o.isDate(i) ? i : s.create().obj) : i = o.isInteger(i) || o.isDate(i) ? s.normalize(new Date(i), n) : s.now(t, i, n), {
                year: a || i.getFullYear(),
                month: a || i.getMonth(),
                date: a || i.getDate(),
                day: a || i.getDay(),
                obj: a || i,
                pick: a || i.getTime()
            }
        }, i.prototype.createRange = function(t, i) {
            var n = this,
                a = function(t) {
                    return t === !0 || e.isArray(t) || o.isDate(t) ? n.create(t) : t
                };
            return o.isInteger(t) || (t = a(t)), o.isInteger(i) || (i = a(i)), o.isInteger(t) && e.isPlainObject(i) ? t = [i.year, i.month, i.date + t] : o.isInteger(i) && e.isPlainObject(t) && (i = [t.year, t.month, t.date + i]), {
                from: a(t),
                to: a(i)
            }
        }, i.prototype.withinRange = function(t, e) {
            return t = this.createRange(t.from, t.to), e.pick >= t.from.pick && e.pick <= t.to.pick
        }, i.prototype.overlapRanges = function(t, e) {
            var i = this;
            return t = i.createRange(t.from, t.to), e = i.createRange(e.from, e.to), i.withinRange(t, e.from) || i.withinRange(t, e.to) || i.withinRange(e, t.from) || i.withinRange(e, t.to)
        }, i.prototype.now = function(t, e, i) {
            return e = new Date, i && i.rel && e.setDate(e.getDate() + i.rel), this.normalize(e, i)
        }, i.prototype.navigate = function(t, i, n) {
            var a, o, s, r, l = e.isArray(i),
                u = e.isPlainObject(i),
                c = this.item.view;
            if (l || u) {
                for (u ? (o = i.year, s = i.month, r = i.date) : (o = +i[0], s = +i[1], r = +i[2]), n && n.nav && c && c.month !== s && (o = c.year, s = c.month), a = new Date(o, s + (n && n.nav ? n.nav : 0), 1), o = a.getFullYear(), s = a.getMonth(); new Date(o, s, r).getMonth() !== s;) r -= 1;
                i = [o, s, r]
            }
            return i
        }, i.prototype.normalize = function(t) {
            return t.setHours(0, 0, 0, 0), t
        }, i.prototype.measure = function(t, e) {
            var i = this;
            return e ? "string" == typeof e ? e = i.parse(t, e) : o.isInteger(e) && (e = i.now(t, e, {
                rel: e
            })) : e = "min" == t ? -(1 / 0) : 1 / 0, e
        }, i.prototype.viewset = function(t, e) {
            return this.create([e.year, e.month, 1])
        }, i.prototype.validate = function(t, i, n) {
            var a, s, r, l, u = this,
                c = i,
                d = n && n.interval ? n.interval : 1,
                h = -1 === u.item.enable,
                f = u.item.min,
                p = u.item.max,
                m = h && u.item.disable.filter(function(t) {
                    if (e.isArray(t)) {
                        var n = u.create(t).pick;
                        n < i.pick ? a = !0 : n > i.pick && (s = !0)
                    }
                    return o.isInteger(t)
                }).length;
            if ((!n || !n.nav) && (!h && u.disabled(i) || h && u.disabled(i) && (m || a || s) || !h && (i.pick <= f.pick || i.pick >= p.pick)))
                for (h && !m && (!s && d > 0 || !a && 0 > d) && (d *= -1); u.disabled(i) && (Math.abs(d) > 1 && (i.month < c.month || i.month > c.month) && (i = c, d = d > 0 ? 1 : -1), i.pick <= f.pick ? (r = !0, d = 1, i = u.create([f.year, f.month, f.date + (i.pick === f.pick ? 0 : -1)])) : i.pick >= p.pick && (l = !0, d = -1, i = u.create([p.year, p.month, p.date + (i.pick === p.pick ? 0 : 1)])), !r || !l);) i = u.create([i.year, i.month, i.date + d]);
            return i
        }, i.prototype.disabled = function(t) {
            var i = this,
                n = i.item.disable.filter(function(n) {
                    return o.isInteger(n) ? t.day === (i.settings.firstDay ? n : n - 1) % 7 : e.isArray(n) || o.isDate(n) ? t.pick === i.create(n).pick : e.isPlainObject(n) ? i.withinRange(n, t) : void 0
                });
            return n = n.length && !n.filter(function(t) {
                return e.isArray(t) && "inverted" == t[3] || e.isPlainObject(t) && t.inverted
            }).length, -1 === i.item.enable ? !n : n || t.pick < i.item.min.pick || t.pick > i.item.max.pick
        }, i.prototype.parse = function(t, e, i) {
            var n = this,
                a = {};
            return e && "string" == typeof e ? (i && i.format || (i = i || {}, i.format = n.settings.format), n.formats.toArray(i.format).map(function(t) {
                var i = n.formats[t],
                    s = i ? o.trigger(i, n, [e, a]) : t.replace(/^!/, "").length;
                i && (a[t] = e.substr(0, s)), e = e.substr(s)
            }), [a.yyyy || a.yy, +(a.mm || a.m) - 1, a.dd || a.d]) : e
        }, i.prototype.formats = function() {
            function t(t, e, i) {
                var n = t.match(/\w+/)[0];
                return i.mm || i.m || (i.m = e.indexOf(n) + 1), n.length
            }

            function e(t) {
                return t.match(/\w+/)[0].length
            }
            return {
                d: function(t, e) {
                    return t ? o.digits(t) : e.date
                },
                dd: function(t, e) {
                    return t ? 2 : o.lead(e.date)
                },
                ddd: function(t, i) {
                    return t ? e(t) : this.settings.weekdaysShort[i.day]
                },
                dddd: function(t, i) {
                    return t ? e(t) : this.settings.weekdaysFull[i.day]
                },
                m: function(t, e) {
                    return t ? o.digits(t) : e.month + 1
                },
                mm: function(t, e) {
                    return t ? 2 : o.lead(e.month + 1)
                },
                mmm: function(e, i) {
                    var n = this.settings.monthsShort;
                    return e ? t(e, n, i) : n[i.month]
                },
                mmmm: function(e, i) {
                    var n = this.settings.monthsFull;
                    return e ? t(e, n, i) : n[i.month]
                },
                yy: function(t, e) {
                    return t ? 2 : ("" + e.year).slice(2)
                },
                yyyy: function(t, e) {
                    return t ? 4 : e.year
                },
                toArray: function(t) {
                    return t.split(/(d{1,4}|m{1,4}|y{4}|yy|!.)/g)
                },
                toString: function(t, e) {
                    var i = this;
                    return i.formats.toArray(t).map(function(t) {
                        return o.trigger(i.formats[t], i, [0, e]) || t.replace(/^!/, "")
                    }).join("")
                }
            }
        }(), i.prototype.isDateExact = function(t, i) {
            var n = this;
            return o.isInteger(t) && o.isInteger(i) || "boolean" == typeof t && "boolean" == typeof i ? t === i : (o.isDate(t) || e.isArray(t)) && (o.isDate(i) || e.isArray(i)) ? n.create(t).pick === n.create(i).pick : e.isPlainObject(t) && e.isPlainObject(i) ? n.isDateExact(t.from, i.from) && n.isDateExact(t.to, i.to) : !1
        }, i.prototype.isDateOverlap = function(t, i) {
            var n = this,
                a = n.settings.firstDay ? 1 : 0;
            return o.isInteger(t) && (o.isDate(i) || e.isArray(i)) ? (t = t % 7 + a, t === n.create(i).day + 1) : o.isInteger(i) && (o.isDate(t) || e.isArray(t)) ? (i = i % 7 + a, i === n.create(t).day + 1) : e.isPlainObject(t) && e.isPlainObject(i) ? n.overlapRanges(t, i) : !1
        }, i.prototype.flipEnable = function(t) {
            var e = this.item;
            e.enable = t || (-1 == e.enable ? 1 : -1)
        }, i.prototype.deactivate = function(t, i) {
            var n = this,
                a = n.item.disable.slice(0);
            return "flip" == i ? n.flipEnable() : i === !1 ? (n.flipEnable(1), a = []) : i === !0 ? (n.flipEnable(-1), a = []) : i.map(function(t) {
                for (var i, s = 0; s < a.length; s += 1)
                    if (n.isDateExact(t, a[s])) {
                        i = !0;
                        break
                    }
                i || (o.isInteger(t) || o.isDate(t) || e.isArray(t) || e.isPlainObject(t) && t.from && t.to) && a.push(t)
            }), a
        }, i.prototype.activate = function(t, i) {
            var n = this,
                a = n.item.disable,
                s = a.length;
            return "flip" == i ? n.flipEnable() : i === !0 ? (n.flipEnable(1), a = []) : i === !1 ? (n.flipEnable(-1), a = []) : i.map(function(t) {
                var i, r, l, u;
                for (l = 0; s > l; l += 1) {
                    if (r = a[l], n.isDateExact(r, t)) {
                        i = a[l] = null, u = !0;
                        break
                    }
                    if (n.isDateOverlap(r, t)) {
                        e.isPlainObject(t) ? (t.inverted = !0, i = t) : e.isArray(t) ? (i = t, i[3] || i.push("inverted")) : o.isDate(t) && (i = [t.getFullYear(), t.getMonth(), t.getDate(), "inverted"]);
                        break
                    }
                }
                if (i)
                    for (l = 0; s > l; l += 1)
                        if (n.isDateExact(a[l], t)) {
                            a[l] = null;
                            break
                        }
                if (u)
                    for (l = 0; s > l; l += 1)
                        if (n.isDateOverlap(a[l], t)) {
                            a[l] = null;
                            break
                        }
                i && a.push(i)
            }), a.filter(function(t) {
                return null != t
            })
        }, i.prototype.nodes = function(t) {
            var e = this,
                i = e.settings,
                s = e.item,
                r = s.now,
                l = s.select,
                u = s.highlight,
                c = s.view,
                d = s.disable,
                h = s.min,
                f = s.max,
                p = function(t, e) {
                    return i.firstDay && (t.push(t.shift()), e.push(e.shift())), o.node("thead", o.node("tr", o.group({
                        min: 0,
                        max: n - 1,
                        i: 1,
                        node: "th",
                        item: function(n) {
                            return [t[n], i.klass.weekdays, 'scope=col title="' + e[n] + '"']
                        }
                    })))
                }((i.showWeekdaysFull ? i.weekdaysFull : i.weekdaysLetter).slice(0), i.weekdaysFull.slice(0)),
                m = function(t) {
                    return o.node("div", " ", i.klass["nav" + (t ? "Next" : "Prev")] + (t && c.year >= f.year && c.month >= f.month || !t && c.year <= h.year && c.month <= h.month ? " " + i.klass.navDisabled : ""), "data-nav=" + (t || -1) + " " + o.ariaAttr({
                        role: "button",
                        controls: e.$node[0].id + "_table"
                    }) + ' title="' + (t ? i.labelMonthNext : i.labelMonthPrev) + '"')
                },
                g = function(n) {
                    var a = i.showMonthsShort ? i.monthsShort : i.monthsFull;
                    return "short_months" == n && (a = i.monthsShort), i.selectMonths && void 0 == n ? o.node("select", o.group({
                        min: 0,
                        max: 11,
                        i: 1,
                        node: "option",
                        item: function(t) {
                            return [a[t], 0, "value=" + t + (c.month == t ? " selected" : "") + (c.year == h.year && t < h.month || c.year == f.year && t > f.month ? " disabled" : "")]
                        }
                    }), i.klass.selectMonth + " browser-default", (t ? "" : "disabled") + " " + o.ariaAttr({
                        controls: e.$node[0].id + "_table"
                    }) + ' title="' + i.labelMonthSelect + '"') : "short_months" == n ? null != l ? o.node("div", a[l.month]) : o.node("div", a[c.month]) : o.node("div", a[c.month], i.klass.month)
                },
                v = function(n) {
                    var a = c.year,
                        s = i.selectYears === !0 ? 5 : ~~(i.selectYears / 2);
                    if (s) {
                        var r = h.year,
                            l = f.year,
                            u = a - s,
                            d = a + s;
                        if (r > u && (d += r - u, u = r), d > l) {
                            var p = u - r,
                                m = d - l;
                            u -= p > m ? m : p, d = l
                        }
                        if (i.selectYears && void 0 == n) return o.node("select", o.group({
                            min: u,
                            max: d,
                            i: 1,
                            node: "option",
                            item: function(t) {
                                return [t, 0, "value=" + t + (a == t ? " selected" : "")]
                            }
                        }), i.klass.selectYear + " browser-default", (t ? "" : "disabled") + " " + o.ariaAttr({
                            controls: e.$node[0].id + "_table"
                        }) + ' title="' + i.labelYearSelect + '"')
                    }
                    return "raw" == n ? o.node("div", a) : o.node("div", a, i.klass.year)
                };
            return createDayLabel = function() {
                return null != l ? o.node("div", l.date) : o.node("div", r.date)
            }, createWeekdayLabel = function() {
                var t;
                t = null != l ? l.day : r.day;
                var e = i.weekdaysFull[t];
                return e
            }, o.node("div", o.node("div", createWeekdayLabel(), "picker__weekday-display") + o.node("div", g("short_months"), i.klass.month_display) + o.node("div", createDayLabel(), i.klass.day_display) + o.node("div", v("raw"), i.klass.year_display), i.klass.date_display) + o.node("div", o.node("div", (i.selectYears ? g() + v() : g() + v()) + m() + m(1), i.klass.header) + o.node("table", p + o.node("tbody", o.group({
                min: 0,
                max: a - 1,
                i: 1,
                node: "tr",
                item: function(t) {
                    var a = i.firstDay && 0 === e.create([c.year, c.month, 1]).day ? -7 : 0;
                    return [o.group({
                        min: n * t - c.day + a + 1,
                        max: function() {
                            return this.min + n - 1
                        },
                        i: 1,
                        node: "td",
                        item: function(t) {
                            t = e.create([c.year, c.month, t + (i.firstDay ? 1 : 0)]);
                            var n = l && l.pick == t.pick,
                                a = u && u.pick == t.pick,
                                s = d && e.disabled(t) || t.pick < h.pick || t.pick > f.pick,
                                p = o.trigger(e.formats.toString, e, [i.format, t]);
                            return [o.node("div", t.date, function(e) {
                                return e.push(c.month == t.month ? i.klass.infocus : i.klass.outfocus), r.pick == t.pick && e.push(i.klass.now), n && e.push(i.klass.selected), a && e.push(i.klass.highlighted), s && e.push(i.klass.disabled), e.join(" ")
                            }([i.klass.day]), "data-pick=" + t.pick + " " + o.ariaAttr({
                                role: "gridcell",
                                label: p,
                                selected: n && e.$node.val() === p ? !0 : null,
                                activedescendant: a ? !0 : null,
                                disabled: s ? !0 : null
                            })), "", o.ariaAttr({
                                role: "presentation"
                            })]
                        }
                    })]
                }
            })), i.klass.table, 'id="' + e.$node[0].id + '_table" ' + o.ariaAttr({
                role: "grid",
                controls: e.$node[0].id,
                readonly: !0
            })), i.klass.calendar_container) + o.node("div", o.node("button", i.today, "btn-flat picker__today", "type=button data-pick=" + r.pick + (t && !e.disabled(r) ? "" : " disabled") + " " + o.ariaAttr({
                controls: e.$node[0].id
            })) + o.node("button", i.clear, "btn-flat picker__clear", "type=button data-clear=1" + (t ? "" : " disabled") + " " + o.ariaAttr({
                controls: e.$node[0].id
            })) + o.node("button", i.close, "btn-flat picker__close", "type=button data-close=true " + (t ? "" : " disabled") + " " + o.ariaAttr({
                controls: e.$node[0].id
            })), i.klass.footer)
        }, i.defaults = function(t) {
            return {
                labelMonthNext: "Next month",
                labelMonthPrev: "Previous month",
                labelMonthSelect: "Select a month",
                labelYearSelect: "Select a year",
                monthsFull: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                weekdaysFull: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                weekdaysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
                weekdaysLetter: ["S", "M", "T", "W", "T", "F", "S"],
                today: "Today",
                clear: "Clear",
                close: "Close",
                format: "d mmmm, yyyy",
                klass: {
                    table: t + "table",
                    header: t + "header",
                    date_display: t + "date-display",
                    day_display: t + "day-display",
                    month_display: t + "month-display",
                    year_display: t + "year-display",
                    calendar_container: t + "calendar-container",
                    navPrev: t + "nav--prev",
                    navNext: t + "nav--next",
                    navDisabled: t + "nav--disabled",
                    month: t + "month",
                    year: t + "year",
                    selectMonth: t + "select--month",
                    selectYear: t + "select--year",
                    weekdays: t + "weekday",
                    day: t + "day",
                    disabled: t + "day--disabled",
                    selected: t + "day--selected",
                    highlighted: t + "day--highlighted",
                    now: t + "day--today",
                    infocus: t + "day--infocus",
                    outfocus: t + "day--outfocus",
                    footer: t + "footer",
                    buttonClear: t + "button--clear",
                    buttonToday: t + "button--today",
                    buttonClose: t + "button--close"
                }
            }
        }(t.klasses().picker + "__"), t.extend("pickadate", i)
    }),
    function(t) {
        function e() {
            var e = +t(this).attr("length"),
                i = +t(this).val().length,
                n = e >= i;
            t(this).parent().find('span[class="character-counter"]').html(i + "/" + e), a(n, t(this))
        }

        function i(e) {
            var i = t("<span/>").addClass("character-counter").css("float", "right").css("font-size", "12px").css("height", 1);
            e.parent().append(i)
        }

        function n() {
            t(this).parent().find('span[class="character-counter"]').html("")
        }

        function a(t, e) {
            var i = e.hasClass("invalid");
            t && i ? e.removeClass("invalid") : t || i || (e.removeClass("valid"), e.addClass("invalid"))
        }
        t.fn.characterCounter = function() {
            return this.each(function() {
                var a = void 0 !== t(this).attr("length");
                a && (t(this).on("input", e), t(this).on("focus", e), t(this).on("blur", n), i(t(this)))
            })
        }, t(document).ready(function() {
            t("input, textarea").characterCounter()
        })
    }(jQuery),
    function(t) {
        var e = {
            init: function(e) {
                var i = {
                    time_constant: 200,
                    dist: -100,
                    shift: 0,
                    padding: 0,
                    full_width: !1
                };
                return e = t.extend(i, e), this.each(function() {
                    function i() {
                        "undefined" != typeof window.ontouchstart && (L[0].addEventListener("touchstart", c), L[0].addEventListener("touchmove", d), L[0].addEventListener("touchend", h)), L[0].addEventListener("mousedown", c), L[0].addEventListener("mousemove", d), L[0].addEventListener("mouseup", h), L[0].addEventListener("click", u)
                    }

                    function n(t) {
                        return t.targetTouches && t.targetTouches.length >= 1 ? t.targetTouches[0].clientX : t.clientX
                    }

                    function a(t) {
                        return t.targetTouches && t.targetTouches.length >= 1 ? t.targetTouches[0].clientY : t.clientY
                    }

                    function o(t) {
                        return t >= w ? t % w : 0 > t ? o(w + t % w) : t
                    }

                    function s(t) {
                        var i, n, a, s, r, l, u;
                        for (p = "number" == typeof t ? t : p, m = Math.floor((p + v / 2) / v), a = p - m * v, s = 0 > a ? 1 : -1, r = -s * a * 2 / v, e.full_width ? u = "translateX(0)" : (u = "translateX(" + (L[0].clientWidth - item_width) / 2 + "px) ", u += "translateY(" + (L[0].clientHeight - item_width) / 2 + "px)"), l = f[o(m)], l.style[k] = u + " translateX(" + -a / 2 + "px) translateX(" + s * e.shift * r * i + "px) translateZ(" + e.dist * r + "px)", l.style.zIndex = 0, e.full_width ? tweenedOpacity = 1 : tweenedOpacity = 1 - .2 * r, l.style.opacity = tweenedOpacity, n = w >> 1, i = 1; n >= i; ++i) e.full_width ? (zTranslation = e.dist, tweenedOpacity = i === n && 0 > a ? 1 - r : 1) : (zTranslation = e.dist * (2 * i + r * s), tweenedOpacity = 1 - .2 * (2 * i + r * s)), l = f[o(m + i)], l.style[k] = u + " translateX(" + (e.shift + (v * i - a) / 2) + "px) translateZ(" + zTranslation + "px)", l.style.zIndex = -i, l.style.opacity = tweenedOpacity, e.full_width ? (zTranslation = e.dist, tweenedOpacity = i === n && a > 0 ? 1 - r : 1) : (zTranslation = e.dist * (2 * i - r * s), tweenedOpacity = 1 - .2 * (2 * i - r * s)), l = f[o(m - i)], l.style[k] = u + " translateX(" + (-e.shift + (-v * i - a) / 2) + "px) translateZ(" + zTranslation + "px)", l.style.zIndex = -i, l.style.opacity = tweenedOpacity;
                        l = f[o(m)], l.style[k] = u + " translateX(" + -a / 2 + "px) translateX(" + s * e.shift * r + "px) translateZ(" + e.dist * r + "px)", l.style.zIndex = 0, e.full_width ? tweenedOpacity = 1 : tweenedOpacity = 1 - .2 * r, l.style.opacity = tweenedOpacity
                    }

                    function r() {
                        var t, e, i, n;
                        t = Date.now(), e = t - M, M = t, i = p - T, T = p, n = 1e3 * i / (1 + e), S = .8 * n + .2 * S
                    }

                    function l() {
                        var t, i;
                        C && (t = Date.now() - M, i = C * Math.exp(-t / e.time_constant), i > 2 || -2 > i ? (s(x - i), requestAnimationFrame(l)) : s(x))
                    }

                    function u(i) {
                        if (O) return i.preventDefault(), i.stopPropagation(), !1;
                        if (!e.full_width) {
                            var n = t(i.target).closest(".carousel-item").index(),
                                a = m % w - n;
                            0 > a ? Math.abs(a + w) < Math.abs(a) && (a += w) : a > 0 && Math.abs(a - w) < a && (a -= w), 0 > a ? t(this).trigger("carouselNext", [Math.abs(a)]) : a > 0 && t(this).trigger("carouselPrev", [a])
                        }
                    }

                    function c(t) {
                        g = !0, O = !1, D = !1, b = n(t), _ = a(t), S = C = 0, T = p, M = Date.now(), clearInterval(P), P = setInterval(r, 100)
                    }

                    function d(t) {
                        var e, i, o;
                        if (g)
                            if (e = n(t), y = a(t), i = b - e, o = Math.abs(_ - y), 30 > o && !D)(i > 2 || -2 > i) && (O = !0, b = e, s(p + i));
                            else {
                                if (O) return t.preventDefault(), t.stopPropagation(), !1;
                                D = !0
                            }
                        return O ? (t.preventDefault(), t.stopPropagation(), !1) : void 0
                    }

                    function h(t) {
                        return g = !1, clearInterval(P), x = p, (S > 10 || -10 > S) && (C = .9 * S, x = p + C), x = Math.round(x / v) * v, C = x - p, M = Date.now(), requestAnimationFrame(l), t.preventDefault(), t.stopPropagation(), !1
                    }
                    var f, p, m, g, v, w, b, _, C, x, S, k, T, M, P, O, D, L = t(this);
                    return L.hasClass("initialized") ? !0 : (e.full_width && (e.dist = 0, imageHeight = L.find(".carousel-item img").first().load(function() {
                        L.css("height", t(this).height())
                    })), L.addClass("initialized"), g = !1, p = x = 0, f = [], item_width = L.find(".carousel-item").first().innerWidth(), v = 2 * item_width + e.padding, L.find(".carousel-item").each(function() {
                        f.push(t(this)[0])
                    }), w = f.length, k = "transform", ["webkit", "Moz", "O", "ms"].every(function(t) {
                        var e = t + "Transform";
                        return "undefined" != typeof document.body.style[e] ? (k = e, !1) : !0
                    }), window.onresize = s, i(), s(p), t(this).on("carouselNext", function(t, e) {
                        void 0 === e && (e = 1), x = p + v * e, p !== x && (C = x - p, M = Date.now(), requestAnimationFrame(l))
                    }), void t(this).on("carouselPrev", function(t, e) {
                        void 0 === e && (e = 1), x = p - v * e, p !== x && (C = x - p, M = Date.now(), requestAnimationFrame(l))
                    }))
                })
            },
            next: function(e) {
                t(this).trigger("carouselNext", [e])
            },
            prev: function(e) {
                t(this).trigger("carouselPrev", [e])
            }
        };
        t.fn.carousel = function(i) {
            return e[i] ? e[i].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof i && i ? void t.error("Method " + i + " does not exist on jQuery.carousel") : e.init.apply(this, arguments)
        }
    }(jQuery),
    function($) {
        $.fn.qt360player = function(t, e) {
            function i(e, i) {
                if (console.log("\n ======== loadInPlayer init =========="), $.fn.destroyAll360Sounds(), l = e.attr("data-playtrack"), void 0 !== l) {
                    mp3url = e.attr("data-playtrack").split("geo-sample").join("sample"), p = mp3url.split(".").pop(), console.log("Track Extension: " + p), console.log("Loading mp3 file: " + mp3url), s = e.attr("data-target"), n = $("#" + s), soundManager.stopAll();
                    var n = $(".ui360");
                    n.empty();
                    var o = Math.floor(1e6 * Math.random());
                    n.append('<a id="playerlink" href="' + mp3url + "?ver=" + o + '"></a>'), i && (console.log("Autoplay executing"), threeSixtyPlayer.config.autoPlay = !0, $(t).find("a.beingplayed").removeClass("beingplayed").find("i").removeClass(h).addClass(d), a = mp3url, e.addClass("beingplayed").find("i").removeClass(d).addClass(h)), c.html('<i class="fa fa-music"></i> ' + e.attr("data-title")), threeSixtyPlayer.init()
                }
            }
            $("body").hasClass("mobile"), void 0 === t && (t = "body");
            var n, a, o, s, r = !1,
                l, u = !1,
                c = $(t).find("#qtTracktitle"),
                d = "mdi-av-play-arrow",
                h = "mdi-av-pause",
                f = "mdi-device-access-time",
                p = "";
            "destroy" === e && $.fn.destroyAll360Sounds(), soundManager.setup({
                url: $("body").attr("data-soundmanagerurl"),
                allowScriptAccess: "always",
                useHighPerformance: !0,
                consoleOnly: !0,
                debugMode: !1,
                debugFlash: !1
            }), soundManager.flash9Options.useWaveformData = !0, soundManager.flash9Options.useEQData = !0, soundManager.flash9Options.usePeakData = !0, soundManager.preferFlash = !0, soundManager.flashVersion = 9, threeSixtyPlayer.config = {
                playNext: !1,
                autoPlay: !1,
                allowMultiple: !1,
                loadRingColor: $("#qtBody").attr("data-accentcolordark"),
                playRingColor: $("#qtBody").attr("data-textcolor"),
                backgroundRingColor: $("#qtBody").attr("data-accentcolor"),
                circleDiameter: 360,
                circleRadius: 180,
                animDuration: 500,
                animTransition: Animator.tx.bouncy,
                showHMSTime: !0,
                useWaveformData: !1,
                waveformDataColor: "#fff",
                waveformDataDownsample: 3,
                waveformDataOutside: !1,
                waveformDataConstrain: !1,
                waveformDataLineRatio: .8,
                useEQData: !0,
                eqDataColor: "#FFF",
                eqDataDownsample: 2,
                eqDataOutside: !0,
                eqDataLineRatio: .73,
                usePeakData: !0,
                peakDataColor: "#FFF",
                peakDataOutside: !0,
                peakDataLineRatio: 1.8,
                scaleArcWidth: .8,
                useAmplifier: !0,
                useFavIcon: !0
            }, "number" == typeof $.mainVolumeLevel && (console.log("Setting volume to " + $.mainVolumeLevel), soundManager.setVolume($.mainVolumeLevel));
            var m = threeSixtyPlayer.events.play,
                g = threeSixtyPlayer.events.resume,
                v = threeSixtyPlayer.events.finish,
                y = threeSixtyPlayer.events.pause,
                w = threeSixtyPlayer.events.stop,
                b = function() {
                    console.log("state: " + r), r = "play", soundManager.stop("currentSound"), soundManager.destroySound("currentSound"), $(t).find(".sm2-360ui").addClass("sm2_playing"), $(t).find("a.beingplayed i").removeClass(d).addClass(h), m.apply(this), console.log("Volume state form Cookie: " + $.mainVolumeLevel), soundManager.setVolume($.mainVolumeLevel), "number" == typeof $.mainVolumeLevel && (console.log("Setting volume to " + $.mainVolumeLevel), soundManager.setVolume($.mainVolumeLevel)), $.fn.qtPlayerStateChange(1)
                };
            threeSixtyPlayer.events.play = b;
            var _ = function() {
                console.log("state: " + r), m.apply(this), $.fn.qtPlayerStateChange(1)
            };
            threeSixtyPlayer.events.resume = _;
            var C = function() {
                console.log("state: " + r);
                var e = $("a.beingplayed").closest("li").next();
                e.length > 0 ? e.find("a[data-playtrack]").click() : ($(t).find("a.beingplayed").removeClass("beingplayed").find("i").removeClass(h).addClass(d), r = "finish"), v.apply(this), $.fn.qtPlayerStateChange(0)
            };
            threeSixtyPlayer.events.finish = C;
            var x = function() {
                console.log("state: " + r), r = "pause", $(t).find("a.beingplayed i").removeClass(h).addClass(d), y.apply(this), $.fn.qtPlayerStateChange(0)
            };
            threeSixtyPlayer.events.pause = x;
            var S = function() {
                console.log("state: " + r), r = "stop", $(t).find("a.beingplayed").removeClass("beingplayed").find("i").removeClass(h).addClass(d), w.apply(this), $.fn.qtPlayerStateChange(0)
            };
            if (threeSixtyPlayer.events.stop = S, String.prototype.stripSlashes = function() {
                    return this.replace(/\\(.)/gm, "$1")
                }, !1 === u) {
                var k = $(t).find("a[data-playtrack]").first();
                console.log("First track: " + k), k.length > 0 && (console.log("First track loaded"), i(k, !1), k.addClass("beingplayed")), u = !0
            }
            $(t).off("click", "a[data-playtrack]"), $(t).on("click", "a[data-playtrack]", function(e) {
                e.preventDefault();
                var n = $(this);
                return n.hasClass("beingplayed") ? $(t).find(".sm2-360btn").click() : i($(this), !0), !1
            });
            var T, M;
            $(t).off("click", "a.playnext"), $(t).on("click", "a.playnext", function(e) {
                return console.log("playnext"), e.preventDefault(), $(t).find("a.beingplayed").closest("li").next().find("a[data-playtrack]").click(), !1
            }), $(t).off("click", "a.playprev"), $(t).on("click", "a.playprev", function(e) {
                return console.log("playprev"), e.preventDefault(), $(t).find("a.beingplayed").closest("li").prev().find("a[data-playtrack]").click(), !1
            })
        }
    }(jQuery), window.Modernizr = function(t, e, i) {
        function n(t) {
            g.cssText = t
        }

        function a(t, e) {
            return n(w.join(t + ";") + (e || ""))
        }

        function o(t, e) {
            return typeof t === e
        }

        function s(t, e) {
            return !!~("" + t).indexOf(e)
        }

        function r(t, e) {
            for (var n in t) {
                var a = t[n];
                if (!s(a, "-") && g[a] !== i) return "pfx" == e ? a : !0
            }
            return !1
        }

        function l(t, e, n) {
            for (var a in t) {
                var s = e[t[a]];
                if (s !== i) return n === !1 ? t[a] : o(s, "function") ? s.bind(n || e) : s
            }
            return !1
        }

        function u(t, e, i) {
            var n = t.charAt(0).toUpperCase() + t.slice(1),
                a = (t + " " + _.join(n + " ") + n).split(" ");
            return o(e, "string") || o(e, "undefined") ? r(a, e) : (a = (t + " " + C.join(n + " ") + n).split(" "), l(a, e, i))
        }
        var c = "2.6.2",
            d = {},
            h = !0,
            f = e.documentElement,
            p = "modernizr",
            m = e.createElement(p),
            g = m.style,
            v, y = {}.toString,
            w = " -webkit- -moz- -o- -ms- ".split(" "),
            b = "Webkit Moz O ms",
            _ = b.split(" "),
            C = b.toLowerCase().split(" "),
            x = {},
            S = {},
            k = {},
            T = [],
            M = T.slice,
            P, O = function(t, i, n, a) {
                var o, s, r, l, u = e.createElement("div"),
                    c = e.body,
                    d = c || e.createElement("body");
                if (parseInt(n, 10))
                    for (; n--;) r = e.createElement("div"), r.id = a ? a[n] : p + (n + 1), u.appendChild(r);
                return o = ["&#173;", '<style id="s', p, '">', t, "</style>"].join(""), u.id = p, (c ? u : d).innerHTML += o, d.appendChild(u), c || (d.style.background = "", d.style.overflow = "hidden", l = f.style.overflow, f.style.overflow = "hidden", f.appendChild(d)), s = i(u, t), c ? u.parentNode.removeChild(u) : (d.parentNode.removeChild(d), f.style.overflow = l), !!s
            },
            D = {}.hasOwnProperty,
            L;
        L = o(D, "undefined") || o(D.call, "undefined") ? function(t, e) {
            return e in t && o(t.constructor.prototype[e], "undefined")
        } : function(t, e) {
            return D.call(t, e)
        }, Function.prototype.bind || (Function.prototype.bind = function(t) {
            var e = this;
            if ("function" != typeof e) throw new TypeError;
            var i = M.call(arguments, 1),
                n = function() {
                    if (this instanceof n) {
                        var a = function() {};
                        a.prototype = e.prototype;
                        var o = new a,
                            s = e.apply(o, i.concat(M.call(arguments)));
                        return Object(s) === s ? s : o
                    }
                    return e.apply(t, i.concat(M.call(arguments)))
                };
            return n
        }), x.touch = function() {
            var i;
            return "ontouchstart" in t || t.DocumentTouch && e instanceof DocumentTouch ? i = !0 : O(["@media (", w.join("touch-enabled),("), p, ")", "{#modernizr{top:9px;position:absolute}}"].join(""), function(t) {
                i = 9 === t.offsetTop
            }), i
        }, x.csstransforms3d = function() {
            var t = !!u("perspective");
            return t && "webkitPerspective" in f.style && O("@media (transform-3d),(-webkit-transform-3d){#modernizr{left:9px;position:absolute;height:3px;}}", function(e, i) {
                t = 9 === e.offsetLeft && 3 === e.offsetHeight
            }), t
        };
        for (var E in x) L(x, E) && (P = E.toLowerCase(), d[P] = x[E](), T.push((d[P] ? "" : "no-") + P));
        return d.addTest = function(t, e) {
                if ("object" == typeof t)
                    for (var n in t) L(t, n) && d.addTest(n, t[n]);
                else {
                    if (t = t.toLowerCase(), d[t] !== i) return d;
                    e = "function" == typeof e ? e() : e, "undefined" != typeof h && h && (f.className += " " + (e ? "" : "no-") + t), d[t] = e
                }
                return d
            }, n(""), m = v = null,
            function(t, e) {
                function i(t, e) {
                    var i = t.createElement("p"),
                        n = t.getElementsByTagName("head")[0] || t.documentElement;
                    return i.innerHTML = "x<style>" + e + "</style>", n.insertBefore(i.lastChild, n.firstChild)
                }

                function n() {
                    var t = v.elements;
                    return "string" == typeof t ? t.split(" ") : t
                }

                function a(t) {
                    var e = m[t[f]];
                    return e || (e = {}, p++, t[f] = p, m[p] = e), e
                }

                function o(t, i, n) {
                    if (i || (i = e), g) return i.createElement(t);
                    n || (n = a(i));
                    var o;
                    return o = n.cache[t] ? n.cache[t].cloneNode() : d.test(t) ? (n.cache[t] = n.createElem(t)).cloneNode() : n.createElem(t), o.canHaveChildren && !c.test(t) ? n.frag.appendChild(o) : o
                }

                function s(t, i) {
                    if (t || (t = e), g) return t.createDocumentFragment();
                    i = i || a(t);
                    for (var o = i.frag.cloneNode(), s = 0, r = n(), l = r.length; l > s; s++) o.createElement(r[s]);
                    return o
                }

                function r(t, e) {
                    e.cache || (e.cache = {}, e.createElem = t.createElement, e.createFrag = t.createDocumentFragment, e.frag = e.createFrag()), t.createElement = function(i) {
                        return v.shivMethods ? o(i, t, e) : e.createElem(i)
                    }, t.createDocumentFragment = Function("h,f", "return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&(" + n().join().replace(/\w+/g, function(t) {
                        return e.createElem(t), e.frag.createElement(t), 'c("' + t + '")'
                    }) + ");return n}")(v, e.frag)
                }

                function l(t) {
                    t || (t = e);
                    var n = a(t);
                    return v.shivCSS && !h && !n.hasCSS && (n.hasCSS = !!i(t, "article,aside,figcaption,figure,footer,header,hgroup,nav,section{display:block}mark{background:#FF0;color:#000}")), g || r(t, n), t
                }
                var u = t.html5 || {},
                    c = /^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,
                    d = /^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,
                    h, f = "_html5shiv",
                    p = 0,
                    m = {},
                    g;
                ! function() {
                    try {
                        var t = e.createElement("a");
                        t.innerHTML = "<xyz></xyz>", h = "hidden" in t, g = 1 == t.childNodes.length || function() {
                            e.createElement("a");
                            var t = e.createDocumentFragment();
                            return "undefined" == typeof t.cloneNode || "undefined" == typeof t.createDocumentFragment || "undefined" == typeof t.createElement
                        }()
                    } catch (i) {
                        h = !0, g = !0
                    }
                }();
                var v = {
                    elements: u.elements || "abbr article aside audio bdi canvas data datalist details figcaption figure footer header hgroup mark meter nav output progress section summary time video",
                    shivCSS: u.shivCSS !== !1,
                    supportsUnknownElements: g,
                    shivMethods: u.shivMethods !== !1,
                    type: "default",
                    shivDocument: l,
                    createElement: o,
                    createDocumentFragment: s
                };
                t.html5 = v, l(e)
            }(this, e), d._version = c, d._prefixes = w, d._domPrefixes = C, d._cssomPrefixes = _, d.testProp = function(t) {
                return r([t])
            }, d.testAllProps = u, d.testStyles = O, d.prefixed = function(t, e, i) {
                return e ? u(t, e, i) : u(t, "pfx")
            }, f.className = f.className.replace(/(^|\s)no-js(\s|$)/, "$1$2") + (h ? " js " + T.join(" ") : ""), d
    }(this, this.document),
    function(t, e, i) {
        function n(t) {
            return "[object Function]" == p.call(t)
        }

        function a(t) {
            return "string" == typeof t
        }

        function o() {}

        function s(t) {
            return !t || "loaded" == t || "complete" == t || "uninitialized" == t
        }

        function r() {
            var t = m.shift();
            g = 1, t ? t.t ? h(function() {
                ("c" == t.t ? M.injectCss : M.injectJs)(t.s, 0, t.a, t.x, t.e, 1)
            }, 0) : (t(), r()) : g = 0
        }

        function l(t, i, n, a, o, l, u) {
            function c(e) {
                if (!p && s(d.readyState) && (b.r = p = 1, !g && r(), d.onload = d.onreadystatechange = null, e)) {
                    "img" != t && h(function() {
                        w.removeChild(d)
                    }, 50);
                    for (var n in S[i]) S[i].hasOwnProperty(n) && S[i][n].onload()
                }
            }
            var u = u || M.errorTimeout,
                d = e.createElement(t),
                p = 0,
                v = 0,
                b = {
                    t: n,
                    s: i,
                    e: o,
                    a: l,
                    x: u
                };
            1 === S[i] && (v = 1, S[i] = []), "object" == t ? d.data = i : (d.src = i, d.type = t), d.width = d.height = "0", d.onerror = d.onload = d.onreadystatechange = function() {
                c.call(this, v)
            }, m.splice(a, 0, b), "img" != t && (v || 2 === S[i] ? (w.insertBefore(d, y ? null : f), h(c, u)) : S[i].push(d))
        }

        function u(t, e, i, n, o) {
            return g = 0, e = e || "j", a(t) ? l("c" == e ? _ : b, t, e, this.i++, i, n, o) : (m.splice(this.i++, 0, t), 1 == m.length && r()), this
        }

        function c() {
            var t = M;
            return t.loader = {
                load: u,
                i: 0
            }, t
        }
        var d = e.documentElement,
            h = t.setTimeout,
            f = e.getElementsByTagName("script")[0],
            p = {}.toString,
            m = [],
            g = 0,
            v = "MozAppearance" in d.style,
            y = v && !!e.createRange().compareNode,
            w = y ? d : f.parentNode,
            d = t.opera && "[object Opera]" == p.call(t.opera),
            d = !!e.attachEvent && !d,
            b = v ? "object" : d ? "script" : "img",
            _ = d ? "script" : b,
            C = Array.isArray || function(t) {
                return "[object Array]" == p.call(t)
            },
            x = [],
            S = {},
            k = {
                timeout: function(t, e) {
                    return e.length && (t.timeout = e[0]), t
                }
            },
            T, M;
        M = function(t) {
            function e(t) {
                var t = t.split("!"),
                    e = x.length,
                    i = t.pop(),
                    n = t.length,
                    i = {
                        url: i,
                        origUrl: i,
                        prefixes: t
                    },
                    a, o, s;
                for (o = 0; n > o; o++) s = t[o].split("="), (a = k[s.shift()]) && (i = a(i, s));
                for (o = 0; e > o; o++) i = x[o](i);
                return i
            }

            function s(t, a, o, s, r) {
                var l = e(t),
                    u = l.autoCallback;
                l.url.split(".").pop().split("?").shift(), l.bypass || (a && (a = n(a) ? a : a[t] || a[s] || a[t.split("/").pop().split("?")[0]]), l.instead ? l.instead(t, a, o, s, r) : (S[l.url] ? l.noexec = !0 : S[l.url] = 1, o.load(l.url, l.forceCSS || !l.forceJS && "css" == l.url.split(".").pop().split("?").shift() ? "c" : i, l.noexec, l.attrs, l.timeout), (n(a) || n(u)) && o.load(function() {
                    c(), a && a(l.origUrl, r, s), u && u(l.origUrl, r, s), S[l.url] = 2
                })))
            }

            function r(t, e) {
                function i(t, i) {
                    if (t) {
                        if (a(t)) i || (u = function() {
                            var t = [].slice.call(arguments);
                            c.apply(this, t), d()
                        }), s(t, u, e, 0, r);
                        else if (Object(t) === t)
                            for (f in h = function() {
                                    var e = 0,
                                        i;
                                    for (i in t) t.hasOwnProperty(i) && e++;
                                    return e
                                }(), t) t.hasOwnProperty(f) && (!i && !--h && (n(u) ? u = function() {
                                var t = [].slice.call(arguments);
                                c.apply(this, t), d()
                            } : u[f] = function(t) {
                                return function() {
                                    var e = [].slice.call(arguments);
                                    t && t.apply(this, e), d()
                                }
                            }(c[f])), s(t[f], u, e, f, r))
                    } else !i && d()
                }
                var r = !!t.test,
                    l = t.load || t.both,
                    u = t.callback || o,
                    c = u,
                    d = t.complete || o,
                    h, f;
                i(r ? t.yep : t.nope, !!l), l && i(l)
            }
            var l, u, d = this.yepnope.loader;
            if (a(t)) s(t, 0, d, 0);
            else if (C(t))
                for (l = 0; l < t.length; l++) u = t[l], a(u) ? s(u, 0, d, 0) : C(u) ? M(u) : Object(u) === u && r(u, d);
            else Object(t) === t && r(t, d)
        }, M.addPrefix = function(t, e) {
            k[t] = e
        }, M.addFilter = function(t) {
            x.push(t)
        }, M.errorTimeout = 1e4, null == e.readyState && e.addEventListener && (e.readyState = "loading", e.addEventListener("DOMContentLoaded", T = function() {
            e.removeEventListener("DOMContentLoaded", T, 0), e.readyState = "complete"
        }, 0)), t.yepnope = c(), t.yepnope.executeStack = r, t.yepnope.injectJs = function(t, i, n, a, l, u) {
            var c = e.createElement("script"),
                d, p, a = a || M.errorTimeout;
            c.src = t;
            for (p in n) c.setAttribute(p, n[p]);
            i = u ? r : i || o, c.onreadystatechange = c.onload = function() {
                !d && s(c.readyState) && (d = 1, i(), c.onload = c.onreadystatechange = null)
            }, h(function() {
                d || (d = 1, i(1))
            }, a), l ? c.onload() : f.parentNode.insertBefore(c, f)
        }, t.yepnope.injectCss = function(t, i, n, a, s, l) {
            var a = e.createElement("link"),
                u, i = l ? r : i || o;
            a.href = t, a.rel = "stylesheet", a.type = "text/css";
            for (u in n) a.setAttribute(u, n[u]);
            s || (f.parentNode.insertBefore(a, f), h(i, 0))
        }
    }(this, document), Modernizr.load = function() {
        yepnope.apply(window, [].slice.call(arguments, 0))
    },
    function(t) {
        "use strict";

        function e(t) {
            return new RegExp("(^|\\s+)" + t + "(\\s+|$)")
        }

        function i(t, e) {
            var i = n(t, e) ? o : a;
            i(t, e)
        }
        var n, a, o;
        "classList" in document.documentElement ? (n = function(t, e) {
            return t.classList.contains(e)
        }, a = function(t, e) {
            t.classList.add(e)
        }, o = function(t, e) {
            t.classList.remove(e)
        }) : (n = function(t, i) {
            return e(i).test(t.className)
        }, a = function(t, e) {
            n(t, e) || (t.className = t.className + " " + e)
        }, o = function(t, i) {
            t.className = t.className.replace(e(i), " ")
        });
        var s = {
            hasClass: n,
            addClass: a,
            removeClass: o,
            toggleClass: i,
            has: n,
            add: a,
            remove: o,
            toggle: i
        };
        "function" == typeof define && define.amd ? define(s) : t.classie = s
    }(window);
var Base = function() {};
Base.extend = function(t, e) {
    "use strict";
    var i = Base.prototype.extend;
    Base._prototyping = !0;
    var n = new this;
    i.call(n, t), n.base = function() {}, delete Base._prototyping;
    var a = n.constructor,
        o = n.constructor = function() {
            if (!Base._prototyping)
                if (this._constructing || this.constructor == o) this._constructing = !0, a.apply(this, arguments), delete this._constructing;
                else if (null !== arguments[0]) return (arguments[0].extend || i).call(arguments[0], n)
        };
    return o.ancestor = this, o.extend = this.extend, o.forEach = this.forEach, o.implement = this.implement, o.prototype = n, o.toString = this.toString, o.valueOf = function(t) {
        return "object" == t ? o : a.valueOf()
    }, i.call(o, e), "function" == typeof o.init && o.init(), o
}, Base.prototype = {
    extend: function(t, e) {
        if (arguments.length > 1) {
            var i = this[t];
            if (i && "function" == typeof e && (!i.valueOf || i.valueOf() != e.valueOf()) && /\bbase\b/.test(e)) {
                var n = e.valueOf();
                e = function() {
                    var t = this.base || Base.prototype.base;
                    this.base = i;
                    var e = n.apply(this, arguments);
                    return this.base = t, e
                }, e.valueOf = function(t) {
                    return "object" == t ? e : n
                }, e.toString = Base.toString
            }
            this[t] = e
        } else if (t) {
            var a = Base.prototype.extend;
            Base._prototyping || "function" == typeof this || (a = this.extend || a);
            for (var o = {
                    toSource: null
                }, s = ["constructor", "toString", "valueOf"], r = Base._prototyping ? 0 : 1; l = s[r++];) t[l] != o[l] && a.call(this, l, t[l]);
            for (var l in t) o[l] || a.call(this, l, t[l])
        }
        return this
    }
}, Base = Base.extend({
    constructor: function() {
        this.extend(arguments[0])
    }
}, {
    ancestor: Object,
    version: "1.1",
    forEach: function(t, e, i) {
        for (var n in t) void 0 === this.prototype[n] && e.call(i, t[n], n, t)
    },
    implement: function() {
        for (var t = 0; t < arguments.length; t++) "function" == typeof arguments[t] ? arguments[t](this.prototype) : this.prototype.extend(arguments[t]);
        return this
    },
    toString: function() {
        return String(this.valueOf())
    }
});
var FlipClock;
! function(t) {
    "use strict";
    FlipClock = function(t, e, i) {
        return e instanceof Object && e instanceof Date == 0 && (i = e, e = 0), new FlipClock.Factory(t, e, i)
    }, FlipClock.Lang = {}, FlipClock.Base = Base.extend({
        buildDate: "2014-12-12",
        version: "0.7.7",
        constructor: function(e, i) {
            "object" != typeof e && (e = {}), "object" != typeof i && (i = {}), this.setOptions(t.extend(!0, {}, e, i))
        },
        callback: function(t) {
            if ("function" == typeof t) {
                for (var e = [], i = 1; i <= arguments.length; i++) arguments[i] && e.push(arguments[i]);
                t.apply(this, e)
            }
        },
        log: function(t) {
            window.console && console.log && console.log(t)
        },
        getOption: function(t) {
            return this[t] ? this[t] : !1
        },
        getOptions: function() {
            return this
        },
        setOption: function(t, e) {
            this[t] = e
        },
        setOptions: function(t) {
            for (var e in t) "undefined" != typeof t[e] && this.setOption(e, t[e])
        }
    })
}(jQuery),
function(t) {
    "use strict";
    FlipClock.Face = FlipClock.Base.extend({
        autoStart: !0,
        dividers: [],
        factory: !1,
        lists: [],
        constructor: function(t, e) {
            this.dividers = [], this.lists = [], this.base(e), this.factory = t
        },
        build: function() {
            this.autoStart && this.start()
        },
        createDivider: function(e, i, n) {
            "boolean" != typeof i && i || (n = i, i = e);
            var a = ['<span class="' + this.factory.classes.dot + ' top"></span>', '<span class="' + this.factory.classes.dot + ' bottom"></span>'].join("");
            n && (a = ""), e = this.factory.localize(e);
            var o = ['<span class="' + this.factory.classes.divider + " " + (i ? i : "").toLowerCase() + '">', '<span class="' + this.factory.classes.label + '">' + (e ? e : "") + "</span>", a, "</span>"],
                s = t(o.join(""));
            return this.dividers.push(s), s
        },
        createList: function(t, e) {
            "object" == typeof t && (e = t, t = 0);
            var i = new FlipClock.List(this.factory, t, e);
            return this.lists.push(i), i
        },
        reset: function() {
            this.factory.time = new FlipClock.Time(this.factory, this.factory.original ? Math.round(this.factory.original) : 0, {
                minimumDigits: this.factory.minimumDigits
            }), this.flip(this.factory.original, !1)
        },
        appendDigitToClock: function(t) {
            t.$el.append(!1)
        },
        addDigit: function(t) {
            var e = this.createList(t, {
                classes: {
                    active: this.factory.classes.active,
                    before: this.factory.classes.before,
                    flip: this.factory.classes.flip
                }
            });
            this.appendDigitToClock(e)
        },
        start: function() {},
        stop: function() {},
        autoIncrement: function() {
            this.factory.countdown ? this.decrement() : this.increment()
        },
        increment: function() {
            this.factory.time.addSecond()
        },
        decrement: function() {
            0 == this.factory.time.getTimeSeconds() ? this.factory.stop() : this.factory.time.subSecond()
        },
        flip: function(e, i) {
            var n = this;
            t.each(e, function(t, e) {
                var a = n.lists[t];
                a ? (i || e == a.digit || a.play(), a.select(e)) : n.addDigit(e)
            })
        }
    })
}(jQuery),
function(t) {
    "use strict";
    FlipClock.Factory = FlipClock.Base.extend({
        animationRate: 1e3,
        autoStart: !0,
        callbacks: {
            destroy: !1,
            create: !1,
            init: !1,
            interval: !1,
            start: !1,
            stop: !1,
            reset: !1
        },
        classes: {
            active: "flip-clock-active",
            before: "flip-clock-before",
            divider: "flip-clock-divider",
            dot: "flip-clock-dot",
            label: "flip-clock-label",
            flip: "flip",
            play: "play",
            wrapper: "flip-clock-wrapper"
        },
        clockFace: "HourlyCounter",
        countdown: !1,
        defaultClockFace: "HourlyCounter",
        defaultLanguage: "english",
        $el: !1,
        face: !0,
        lang: !1,
        language: "english",
        minimumDigits: 0,
        original: !1,
        running: !1,
        time: !1,
        timer: !1,
        $wrapper: !1,
        constructor: function(e, i, n) {
            n || (n = {}), this.lists = [], this.running = !1, this.base(n), this.$el = t(e).addClass(this.classes.wrapper), this.$wrapper = this.$el, this.original = i instanceof Date ? i : i ? Math.round(i) : 0, this.time = new FlipClock.Time(this, this.original, {
                minimumDigits: this.minimumDigits,
                animationRate: this.animationRate
            }), this.timer = new FlipClock.Timer(this, n), this.loadLanguage(this.language), this.loadClockFace(this.clockFace, n), this.autoStart && this.start()
        },
        loadClockFace: function(t, e) {
            var i, n = "Face",
                a = !1;
            return t = t.ucfirst() + n, this.face.stop && (this.stop(), a = !0), this.$el.html(""), this.time.minimumDigits = this.minimumDigits, i = FlipClock[t] ? new FlipClock[t](this, e) : new FlipClock[this.defaultClockFace + n](this, e), i.build(), this.face = i, a && this.start(), this.face
        },
        loadLanguage: function(t) {
            var e;
            return e = FlipClock.Lang[t.ucfirst()] ? FlipClock.Lang[t.ucfirst()] : FlipClock.Lang[t] ? FlipClock.Lang[t] : FlipClock.Lang[this.defaultLanguage], this.lang = e
        },
        localize: function(t, e) {
            var i = this.lang;
            if (!t) return null;
            var n = t.toLowerCase();
            return "object" == typeof e && (i = e), i && i[n] ? i[n] : t
        },
        start: function(t) {
            var e = this;
            e.running || e.countdown && !(e.countdown && e.time.time > 0) ? e.log("Trying to start timer when countdown already at 0") : (e.face.start(e.time), e.timer.start(function() {
                e.flip(), "function" == typeof t && t()
            }))
        },
        stop: function(t) {
            this.face.stop(), this.timer.stop(t);
            for (var e in this.lists) this.lists.hasOwnProperty(e) && this.lists[e].stop()
        },
        reset: function(t) {
            this.timer.reset(t), this.face.reset()
        },
        setTime: function(t) {
            this.time.time = t, this.flip(!0)
        },
        getTime: function() {
            return this.time
        },
        setCountdown: function(t) {
            var e = this.running;
            this.countdown = !!t, e && (this.stop(), this.start())
        },
        flip: function(t) {
            this.face.flip(!1, t)
        }
    })
}(jQuery),
function(t) {
    "use strict";
    FlipClock.List = FlipClock.Base.extend({
        digit: 0,
        classes: {
            active: "flip-clock-active",
            before: "flip-clock-before",
            flip: "flip"
        },
        factory: !1,
        $el: !1,
        $obj: !1,
        items: [],
        lastDigit: 0,
        constructor: function(t, e) {
            this.factory = t, this.digit = e, this.lastDigit = e, this.$el = this.createList(), this.$obj = this.$el, e > 0 && this.select(e), this.factory.$el.append(this.$el)
        },
        select: function(t) {
            if ("undefined" == typeof t ? t = this.digit : this.digit = t, this.digit != this.lastDigit) {
                var e = this.$el.find("." + this.classes.before).removeClass(this.classes.before);
                this.$el.find("." + this.classes.active).removeClass(this.classes.active).addClass(this.classes.before), this.appendListItem(this.classes.active, this.digit), e.remove(), this.lastDigit = this.digit
            }
        },
        play: function() {
            this.$el.addClass(this.factory.classes.play)
        },
        stop: function() {
            var t = this;
            setTimeout(function() {
                t.$el.removeClass(t.factory.classes.play)
            }, this.factory.timer.interval)
        },
        createListItem: function(t, e) {
            return ['<li class="' + (t ? t : "") + '">', '<a href="#">', '<div class="up">', '<div class="shadow"></div>', '<div class="inn">' + (e ? e : "") + "</div>", "</div>", '<div class="down">', '<div class="shadow"></div>', '<div class="inn">' + (e ? e : "") + "</div>", "</div>", "</a>", "</li>"].join("");
        },
        appendListItem: function(t, e) {
            var i = this.createListItem(t, e);
            this.$el.append(i)
        },
        createList: function() {
            var e = this.getPrevDigit() ? this.getPrevDigit() : this.digit,
                i = t(['<ul class="' + this.classes.flip + " " + (this.factory.running ? this.factory.classes.play : "") + '">', this.createListItem(this.classes.before, e), this.createListItem(this.classes.active, this.digit), "</ul>"].join(""));
            return i
        },
        getNextDigit: function() {
            return 9 == this.digit ? 0 : this.digit + 1
        },
        getPrevDigit: function() {
            return 0 == this.digit ? 9 : this.digit - 1
        }
    })
}(jQuery),
function(t) {
    "use strict";
    String.prototype.ucfirst = function() {
        return this.substr(0, 1).toUpperCase() + this.substr(1)
    }, t.fn.FlipClock = function(e, i) {
        return new FlipClock(t(this), e, i)
    }, t.fn.flipClock = function(e, i) {
        return t.fn.FlipClock(e, i)
    }
}(jQuery),
function(t) {
    "use strict";
    FlipClock.Time = FlipClock.Base.extend({
        time: 0,
        factory: !1,
        minimumDigits: 0,
        constructor: function(t, e, i) {
            "object" != typeof i && (i = {}), i.minimumDigits || (i.minimumDigits = t.minimumDigits), this.base(i), this.factory = t, e && (this.time = e)
        },
        convertDigitsToArray: function(t) {
            var e = [];
            t = t.toString();
            for (var i = 0; i < t.length; i++) t[i].match(/^\d*$/g) && e.push(t[i]);
            return e
        },
        digit: function(t) {
            var e = this.toString(),
                i = e.length;
            return e[i - t] ? e[i - t] : !1
        },
        digitize: function(e) {
            var i = [];
            if (t.each(e, function(t, e) {
                    e = e.toString(), 1 == e.length && (e = "0" + e);
                    for (var n = 0; n < e.length; n++) i.push(e.charAt(n))
                }), i.length > this.minimumDigits && (this.minimumDigits = i.length), this.minimumDigits > i.length)
                for (var n = i.length; n < this.minimumDigits; n++) i.unshift("0");
            return i
        },
        getDateObject: function() {
            return this.time instanceof Date ? this.time : new Date((new Date).getTime() + 1e3 * this.getTimeSeconds())
        },
        getDayCounter: function(t) {
            var e = [this.getDays(), this.getHours(!0), this.getMinutes(!0)];
            return t && e.push(this.getSeconds(!0)), this.digitize(e)
        },
        getDays: function(t) {
            var e = this.getTimeSeconds() / 60 / 60 / 24;
            return t && (e %= 7), Math.floor(e)
        },
        getHourCounter: function() {
            var t = this.digitize([this.getHours(), this.getMinutes(!0), this.getSeconds(!0)]);
            return t
        },
        getHourly: function() {
            return this.getHourCounter()
        },
        getHours: function(t) {
            var e = this.getTimeSeconds() / 60 / 60;
            return t && (e %= 24), Math.floor(e)
        },
        getMilitaryTime: function(t, e) {
            "undefined" == typeof e && (e = !0), t || (t = this.getDateObject());
            var i = [t.getHours(), t.getMinutes()];
            return e === !0 && i.push(t.getSeconds()), this.digitize(i)
        },
        getMinutes: function(t) {
            var e = this.getTimeSeconds() / 60;
            return t && (e %= 60), Math.floor(e)
        },
        getMinuteCounter: function() {
            var t = this.digitize([this.getMinutes(), this.getSeconds(!0)]);
            return t
        },
        getTimeSeconds: function(t) {
            return t || (t = new Date), this.time instanceof Date ? this.factory.countdown ? Math.max(this.time.getTime() / 1e3 - t.getTime() / 1e3, 0) : t.getTime() / 1e3 - this.time.getTime() / 1e3 : this.time
        },
        getTime: function(t, e) {
            "undefined" == typeof e && (e = !0), t || (t = this.getDateObject()), console.log(t);
            var i = t.getHours(),
                n = [i > 12 ? i - 12 : 0 === i ? 12 : i, t.getMinutes()];
            return e === !0 && n.push(t.getSeconds()), this.digitize(n)
        },
        getSeconds: function(t) {
            var e = this.getTimeSeconds();
            return t && (60 == e ? e = 0 : e %= 60), Math.ceil(e)
        },
        getWeeks: function(t) {
            var e = this.getTimeSeconds() / 60 / 60 / 24 / 7;
            return t && (e %= 52), Math.floor(e)
        },
        removeLeadingZeros: function(e, i) {
            var n = 0,
                a = [];
            return t.each(i, function(t) {
                e > t ? n += parseInt(i[t], 10) : a.push(i[t])
            }), 0 === n ? a : i
        },
        addSeconds: function(t) {
            this.time instanceof Date ? this.time.setSeconds(this.time.getSeconds() + t) : this.time += t
        },
        addSecond: function() {
            this.addSeconds(1)
        },
        subSeconds: function(t) {
            this.time instanceof Date ? this.time.setSeconds(this.time.getSeconds() - t) : this.time -= t
        },
        subSecond: function() {
            this.subSeconds(1)
        },
        toString: function() {
            return this.getTimeSeconds().toString()
        }
    })
}(jQuery),
function() {
    "use strict";
    FlipClock.Timer = FlipClock.Base.extend({
        callbacks: {
            destroy: !1,
            create: !1,
            init: !1,
            interval: !1,
            start: !1,
            stop: !1,
            reset: !1
        },
        count: 0,
        factory: !1,
        interval: 1e3,
        animationRate: 1e3,
        constructor: function(t, e) {
            this.base(e), this.factory = t, this.callback(this.callbacks.init), this.callback(this.callbacks.create)
        },
        getElapsed: function() {
            return this.count * this.interval
        },
        getElapsedTime: function() {
            return new Date(this.time + this.getElapsed())
        },
        reset: function(t) {
            clearInterval(this.timer), this.count = 0, this._setInterval(t), this.callback(this.callbacks.reset)
        },
        start: function(t) {
            this.factory.running = !0, this._createTimer(t), this.callback(this.callbacks.start)
        },
        stop: function(t) {
            this.factory.running = !1, this._clearInterval(t), this.callback(this.callbacks.stop), this.callback(t)
        },
        _clearInterval: function() {
            clearInterval(this.timer)
        },
        _createTimer: function(t) {
            this._setInterval(t)
        },
        _destroyTimer: function(t) {
            this._clearInterval(), this.timer = !1, this.callback(t), this.callback(this.callbacks.destroy)
        },
        _interval: function(t) {
            this.callback(this.callbacks.interval), this.callback(t), this.count++
        },
        _setInterval: function(t) {
            var e = this;
            e._interval(t), e.timer = setInterval(function() {
                e._interval(t)
            }, this.interval)
        }
    })
}(jQuery),
function(t) {
    FlipClock.TwentyFourHourClockFace = FlipClock.Face.extend({
        constructor: function(t, e) {
            this.base(t, e)
        },
        build: function(e) {
            var i = this,
                n = this.factory.$el.find("ul");
            this.factory.time.time || (this.factory.original = new Date, this.factory.time = new FlipClock.Time(this.factory, this.factory.original));
            var e = e ? e : this.factory.time.getMilitaryTime(!1, this.showSeconds);
            e.length > n.length && t.each(e, function(t, e) {
                i.createList(e)
            }), this.createDivider(), this.createDivider(), t(this.dividers[0]).insertBefore(this.lists[this.lists.length - 2].$el), t(this.dividers[1]).insertBefore(this.lists[this.lists.length - 4].$el), this.base()
        },
        flip: function(t, e) {
            this.autoIncrement(), t = t ? t : this.factory.time.getMilitaryTime(!1, this.showSeconds), this.base(t, e)
        }
    })
}(jQuery),
function(t) {
    FlipClock.CounterFace = FlipClock.Face.extend({
        shouldAutoIncrement: !1,
        constructor: function(t, e) {
            "object" != typeof e && (e = {}), t.autoStart = !!e.autoStart, e.autoStart && (this.shouldAutoIncrement = !0), t.increment = function() {
                t.countdown = !1, t.setTime(t.getTime().getTimeSeconds() + 1)
            }, t.decrement = function() {
                t.countdown = !0;
                var e = t.getTime().getTimeSeconds();
                e > 0 && t.setTime(e - 1)
            }, t.setValue = function(e) {
                t.setTime(e)
            }, t.setCounter = function(e) {
                t.setTime(e)
            }, this.base(t, e)
        },
        build: function() {
            var e = this,
                i = this.factory.$el.find("ul"),
                n = this.factory.getTime().digitize([this.factory.getTime().time]);
            n.length > i.length && t.each(n, function(t, i) {
                var n = e.createList(i);
                n.select(i)
            }), t.each(this.lists, function(t, e) {
                e.play()
            }), this.base()
        },
        flip: function(t, e) {
            this.shouldAutoIncrement && this.autoIncrement(), t || (t = this.factory.getTime().digitize([this.factory.getTime().time])), this.base(t, e)
        },
        reset: function() {
            this.factory.time = new FlipClock.Time(this.factory, this.factory.original ? Math.round(this.factory.original) : 0), this.flip()
        }
    })
}(jQuery),
function(t) {
    FlipClock.DailyCounterFace = FlipClock.Face.extend({
        showSeconds: !0,
        constructor: function(t, e) {
            this.base(t, e)
        },
        build: function(e) {
            var i = this,
                n = this.factory.$el.find("ul"),
                a = 0;
            e = e ? e : this.factory.time.getDayCounter(this.showSeconds), e.length > n.length && t.each(e, function(t, e) {
                i.createList(e)
            }), this.showSeconds ? t(this.createDivider("Seconds")).insertBefore(this.lists[this.lists.length - 2].$el) : a = 2, t(this.createDivider("Minutes")).insertBefore(this.lists[this.lists.length - 4 + a].$el), t(this.createDivider("Hours")).insertBefore(this.lists[this.lists.length - 6 + a].$el), t(this.createDivider("Days", !0)).insertBefore(this.lists[0].$el), this.base()
        },
        flip: function(t, e) {
            t || (t = this.factory.time.getDayCounter(this.showSeconds)), this.autoIncrement(), this.base(t, e)
        }
    })
}(jQuery),
function(t) {
    FlipClock.HourlyCounterFace = FlipClock.Face.extend({
        constructor: function(t, e) {
            this.base(t, e)
        },
        build: function(e, i) {
            var n = this,
                a = this.factory.$el.find("ul");
            i = i ? i : this.factory.time.getHourCounter(), i.length > a.length && t.each(i, function(t, e) {
                n.createList(e)
            }), t(this.createDivider("Seconds")).insertBefore(this.lists[this.lists.length - 2].$el), t(this.createDivider("Minutes")).insertBefore(this.lists[this.lists.length - 4].$el), e || t(this.createDivider("Hours", !0)).insertBefore(this.lists[0].$el), this.base()
        },
        flip: function(t, e) {
            t || (t = this.factory.time.getHourCounter()), this.autoIncrement(), this.base(t, e)
        },
        appendDigitToClock: function(t) {
            this.base(t), this.dividers[0].insertAfter(this.dividers[0].next())
        }
    })
}(jQuery),
function() {
    FlipClock.MinuteCounterFace = FlipClock.HourlyCounterFace.extend({
        clearExcessDigits: !1,
        constructor: function(t, e) {
            this.base(t, e)
        },
        build: function() {
            this.base(!0, this.factory.time.getMinuteCounter())
        },
        flip: function(t, e) {
            t || (t = this.factory.time.getMinuteCounter()), this.base(t, e)
        }
    })
}(jQuery),
function(t) {
    FlipClock.TwelveHourClockFace = FlipClock.TwentyFourHourClockFace.extend({
        meridium: !1,
        meridiumText: "AM",
        build: function() {
            var e = this.factory.time.getTime(!1, this.showSeconds);
            this.base(e), this.meridiumText = this.getMeridium(), this.meridium = t(['<ul class="flip-clock-meridium">', "<li>", '<a href="#">' + this.meridiumText + "</a>", "</li>", "</ul>"].join("")), this.meridium.insertAfter(this.lists[this.lists.length - 1].$el)
        },
        flip: function(t, e) {
            this.meridiumText != this.getMeridium() && (this.meridiumText = this.getMeridium(), this.meridium.find("a").html(this.meridiumText)), this.base(this.factory.time.getTime(!1, this.showSeconds), e)
        },
        getMeridium: function() {
            return (new Date).getHours() >= 12 ? "PM" : "AM"
        },
        isPM: function() {
            return "PM" == this.getMeridium()
        },
        isAM: function() {
            return "AM" == this.getMeridium()
        }
    })
}(jQuery),
function() {
    FlipClock.Lang.Arabic = {
        years: "Ø³Ù†ÙˆØ§Øª",
        months: "Ø´Ù‡ÙˆØ±",
        days: "Ø£ÙŠØ§Ù…",
        hours: "Ø³Ø§Ø¹Ø§Øª",
        minutes: "Ø¯Ù‚Ø§Ø¦Ù‚",
        seconds: "Ø«ÙˆØ§Ù†ÙŠ"
    }, FlipClock.Lang.ar = FlipClock.Lang.Arabic, FlipClock.Lang["ar-ar"] = FlipClock.Lang.Arabic, FlipClock.Lang.arabic = FlipClock.Lang.Arabic
}(jQuery),
function() {
    FlipClock.Lang.Danish = {
        years: "Ã…r",
        months: "MÃ¥neder",
        days: "Dage",
        hours: "Timer",
        minutes: "Minutter",
        seconds: "Sekunder"
    }, FlipClock.Lang.da = FlipClock.Lang.Danish, FlipClock.Lang["da-dk"] = FlipClock.Lang.Danish, FlipClock.Lang.danish = FlipClock.Lang.Danish
}(jQuery),
function() {
    FlipClock.Lang.German = {
        years: "Jahre",
        months: "Monate",
        days: "Tage",
        hours: "Stunden",
        minutes: "Minuten",
        seconds: "Sekunden"
    }, FlipClock.Lang.de = FlipClock.Lang.German, FlipClock.Lang["de-de"] = FlipClock.Lang.German, FlipClock.Lang.german = FlipClock.Lang.German
}(jQuery),
function() {
    FlipClock.Lang.English = {
        years: "Years",
        months: "Months",
        days: "Days",
        hours: "Hours",
        minutes: "Minutes",
        seconds: "Seconds"
    }, FlipClock.Lang.en = FlipClock.Lang.English, FlipClock.Lang["en-us"] = FlipClock.Lang.English, FlipClock.Lang.english = FlipClock.Lang.English
}(jQuery),
function() {
    FlipClock.Lang.Spanish = {
        years: "A&#241;os",
        months: "Meses",
        days: "D&#205;as",
        hours: "Horas",
        minutes: "Minutos",
        seconds: "Segundo"
    }, FlipClock.Lang.es = FlipClock.Lang.Spanish, FlipClock.Lang["es-es"] = FlipClock.Lang.Spanish, FlipClock.Lang.spanish = FlipClock.Lang.Spanish
}(jQuery),
function() {
    FlipClock.Lang.Finnish = {
        years: "Vuotta",
        months: "Kuukautta",
        days: "PÃ¤ivÃ¤Ã¤",
        hours: "Tuntia",
        minutes: "Minuuttia",
        seconds: "Sekuntia"
    }, FlipClock.Lang.fi = FlipClock.Lang.Finnish, FlipClock.Lang["fi-fi"] = FlipClock.Lang.Finnish, FlipClock.Lang.finnish = FlipClock.Lang.Finnish
}(jQuery),
function() {
    FlipClock.Lang.French = {
        years: "Ans",
        months: "Mois",
        days: "Jours",
        hours: "Heures",
        minutes: "Minutes",
        seconds: "Secondes"
    }, FlipClock.Lang.fr = FlipClock.Lang.French, FlipClock.Lang["fr-ca"] = FlipClock.Lang.French, FlipClock.Lang.french = FlipClock.Lang.French
}(jQuery),
function() {
    FlipClock.Lang.Italian = {
        years: "Anni",
        months: "Mesi",
        days: "Giorni",
        hours: "Ore",
        minutes: "Minuti",
        seconds: "Secondi"
    }, FlipClock.Lang.it = FlipClock.Lang.Italian, FlipClock.Lang["it-it"] = FlipClock.Lang.Italian, FlipClock.Lang.italian = FlipClock.Lang.Italian
}(jQuery),
function() {
    FlipClock.Lang.Latvian = {
        years: "Gadi",
        months: "MÄ“neÅ¡i",
        days: "Dienas",
        hours: "Stundas",
        minutes: "MinÅ«tes",
        seconds: "Sekundes"
    }, FlipClock.Lang.lv = FlipClock.Lang.Latvian, FlipClock.Lang["lv-lv"] = FlipClock.Lang.Latvian, FlipClock.Lang.latvian = FlipClock.Lang.Latvian
}(jQuery),
function() {
    FlipClock.Lang.Dutch = {
        years: "Jaren",
        months: "Maanden",
        days: "Dagen",
        hours: "Uren",
        minutes: "Minuten",
        seconds: "Seconden"
    }, FlipClock.Lang.nl = FlipClock.Lang.Dutch, FlipClock.Lang["nl-be"] = FlipClock.Lang.Dutch, FlipClock.Lang.dutch = FlipClock.Lang.Dutch
}(jQuery),
function() {
    FlipClock.Lang.Norwegian = {
        years: "Ã…r",
        months: "MÃ¥neder",
        days: "Dager",
        hours: "Timer",
        minutes: "Minutter",
        seconds: "Sekunder"
    }, FlipClock.Lang.no = FlipClock.Lang.Norwegian, FlipClock.Lang.nb = FlipClock.Lang.Norwegian, FlipClock.Lang["no-nb"] = FlipClock.Lang.Norwegian, FlipClock.Lang.norwegian = FlipClock.Lang.Norwegian
}(jQuery),
function() {
    FlipClock.Lang.Portuguese = {
        years: "Anos",
        months: "Meses",
        days: "Dias",
        hours: "Horas",
        minutes: "Minutos",
        seconds: "Segundos"
    }, FlipClock.Lang.pt = FlipClock.Lang.Portuguese, FlipClock.Lang["pt-br"] = FlipClock.Lang.Portuguese, FlipClock.Lang.portuguese = FlipClock.Lang.Portuguese
}(jQuery),
function() {
    FlipClock.Lang.Russian = {
        years: "Ð»ÐµÑ‚",
        months: "Ð¼ÐµÑÑÑ†ÐµÐ²",
        days: "Ð´Ð½ÐµÐ¹",
        hours: "Ñ‡Ð°ÑÐ¾Ð²",
        minutes: "Ð¼Ð¸Ð½ÑƒÑ‚",
        seconds: "ÑÐµÐºÑƒÐ½Ð´"
    }, FlipClock.Lang.ru = FlipClock.Lang.Russian, FlipClock.Lang["ru-ru"] = FlipClock.Lang.Russian, FlipClock.Lang.russian = FlipClock.Lang.Russian
}(jQuery),
function() {
    FlipClock.Lang.Swedish = {
        years: "Ã…r",
        months: "MÃ¥nader",
        days: "Dagar",
        hours: "Timmar",
        minutes: "Minuter",
        seconds: "Sekunder"
    }, FlipClock.Lang.sv = FlipClock.Lang.Swedish, FlipClock.Lang["sv-se"] = FlipClock.Lang.Swedish, FlipClock.Lang.swedish = FlipClock.Lang.Swedish
}(jQuery),
function() {
    FlipClock.Lang.Chinese = {
        years: "å¹´",
        months: "æœˆ",
        days: "æ—¥",
        hours: "æ—¶",
        minutes: "åˆ†",
        seconds: "ç§’"
    }, FlipClock.Lang.zh = FlipClock.Lang.Chinese, FlipClock.Lang["zh-cn"] = FlipClock.Lang.Chinese, FlipClock.Lang.chinese = FlipClock.Lang.Chinese
}(jQuery),
function($) {
    "use strict";
    jQuery.fn.skywheel = function(t) {
        var e = $.extend({}, $.fn.skywheel.defaults, t),
            i = function() {
                var t = document.createElement("style");
                return document.head.appendChild(t), t.sheet
            }();
        i.insertRule(".jq_skywheel li{height:" + e.height + ";width:" + e.width + ";}", i.cssRules.length), i.insertRule(".jq_skywheel li .inner{height:" + e.height + ";line-height:" + e.height + ";}", i.cssRules.length), this.addClass("jq_skywheel"), this.children().each(function(t, e) {});
        var n = this.children(),
            a = n.length,
            o, s = this,
            r = this.closest(".qt-gridstackSkywheel"),
            l = function c(t) {
                var i = 0,
                    o = 0,
                    s = 1;
                for (i = 0; a > i; i += 1) $(n[i]).removeClass(), $(n[i]).find(".inner").removeClass("qt-border-accent");
                for ($(n[t]).addClass("center").find(".inner").addClass("qt-border-accent"), i = t + 1; 3 + t > i; i += 1) {
                    o = i >= a ? i - a : i;
                    var r = $(n[o]);
                    r.addClass("effect" + e.effect + "_" + s + " mask" + s), s += 1
                }
                for (s = 1, i = t - 1; i > t - 3; i -= 1) {
                    o = 0 > i ? i + a : i;
                    var r = $(n[o]);
                    $(n[o]).addClass("effect" + e.effect + "_n" + s + " mask" + s), s += 1
                }
            },
            u = function d(t) {
                var i = t.keyCode,
                    n = s.chosen,
                    o = 40,
                    r = 38;
                "updown" == e.keyOption ? (o = 40, r = 38) : "leftright" == e.keyOption && (o = 39, r = 37), i === r ? (n = 0 >= n ? a - 1 : n - 1, l(n), s.chosen = n) : i === o && (n = n >= a - 1 ? 0 : n + 1, l(n), s.chosen = n)
            };
        "nokey" != e.keyOption && $(document).keypress(u), this.chosen = a - 1, this.parent().find(".qt-arrowUp").click(function(t) {
            t.preventDefault(), $(this).parent().find(".effect1_n1").click()
        }), this.parent().find(".qt-arrowDown").click(function(t) {
            t.preventDefault(), $(this).parent().find(".effect1_1").click()
        }), n.each(function(t, e) {
            var i = function() {},
                u = function() {},
                c = function() {
                    if (s.chosen = t, $(e).hasClass("center")) {
                        for (o = 0; a > o; o += 1) $(n[o]).removeClass();
                        return $(e).addClass("chosen"), void $(e).closest(".qt-gridstackSkywheel.open").removeClass("open")
                    }
                    r.addClass("open"), l(t)
                };
            $(e).on("click", c), $(e).on("mouseenter", i), $(e).on("mouseleave", u)
        })
    }, jQuery.fn.skywheel.defaults = {
        type: "normal",
        width: "100px",
        height: "40px",
        effect: 1,
        keyOption: "leftright"
    }
}(jQuery),
function(t) {
    t.fn.prettySocial = function() {
        var e = {
                pinterest: {
                    url: "http://pinterest.com/pin/create/button/?url={{url}}&media={{media}}&description={{description}}",
                    popup: {
                        width: 685,
                        height: 500
                    }
                },
                facebook: {
                    url: "https://www.facebook.com/sharer/sharer.php?s=100&p[title]={{title}}&p[summary]={{description}}&p[url]={{url}}&p[images][0]={{media}}",
                    popup: {
                        width: 626,
                        height: 436
                    }
                },
                twitter: {
                    url: "https://twitter.com/share?url={{url}}&via={{via}}&text={{description}}",
                    popup: {
                        width: 685,
                        height: 500
                    }
                },
                googleplus: {
                    url: "https://plus.google.com/share?url={{url}}",
                    popup: {
                        width: 600,
                        height: 600
                    }
                },
                linkedin: {
                    url: "https://www.linkedin.com/shareArticle?mini=true&url={{url}}&title={{title}}&summary={{description}}+&source={{via}}",
                    popup: {
                        width: 600,
                        height: 600
                    }
                }
            },
            i = function(t, e) {
                var i = window.innerWidth / 2 - t.popup.width / 2,
                    n = window.innerHeight / 2 - t.popup.height / 2;
                return window.open(e, "", "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=" + t.popup.width + ", height=" + t.popup.height + ", top=" + n + ", left=" + i)
            },
            n = function(t, e) {
                var i = t.url.replace(/{{url}}/g, encodeURIComponent(e.url)).replace(/{{title}}/g, encodeURIComponent(e.title)).replace(/{{description}}/g, encodeURIComponent(e.description)).replace(/{{media}}/g, encodeURIComponent(e.media)).replace(/{{via}}/g, encodeURIComponent(e.via));
                return i
            };
        return this.each(function() {
            var a = t(this),
                o = a.data("type"),
                s = e[o] || null;
            s || t.error("Social site is not set.");
            var r = {
                    url: a.data("url") || "",
                    title: a.data("title") || "",
                    description: a.data("description") || "",
                    media: a.data("media") || "",
                    via: a.data("via") || ""
                },
                l = n(s, r);
            navigator.userAgent.match(/Android|IEMobile|BlackBerry|iPhone|iPad|iPod|Opera Mini/i) ? a.bind("touchstart", function(t) {
                t.originalEvent.touches.length > 1 || a.data("touchWithoutScroll", !0)
            }).bind("touchmove", function() {
                a.data("touchWithoutScroll", !1)
            }).bind("touchend", function(t) {
                t.preventDefault();
                var e = a.data("touchWithoutScroll");
                t.originalEvent.touches.length > 1 || !e || i(s, l)
            }) : a.bind("click", function(t) {
                t.preventDefault(), i(s, l)
            })
        })
    }
}(jQuery),
function($, t, e, i) {
    function n(t, e) {
        this.settings = null, this.options = $.extend({}, n.Defaults, e), this.$element = $(t), this.drag = $.extend({}, d), this.state = $.extend({}, h), this.e = $.extend({}, f), this._plugins = {}, this._supress = {}, this._current = null, this._speed = null, this._coordinates = [], this._breakpoint = null, this._width = null, this._items = [], this._clones = [], this._mergers = [], this._invalidated = {}, this._pipe = [], $.each(n.Plugins, $.proxy(function(t, e) {
            this._plugins[t[0].toLowerCase() + t.slice(1)] = new e(this)
        }, this)), $.each(n.Pipe, $.proxy(function(t, e) {
            this._pipe.push({
                filter: e.filter,
                run: $.proxy(e.run, this)
            })
        }, this)), this.setup(), this.initialize()
    }

    function a(t) {
        if (t.touches !== i) return {
            x: t.touches[0].pageX,
            y: t.touches[0].pageY
        };
        if (t.touches === i) {
            if (t.pageX !== i) return {
                x: t.pageX,
                y: t.pageY
            };
            if (t.pageX === i) return {
                x: t.clientX,
                y: t.clientY
            }
        }
    }

    function o(t) {
        var i, n, a = e.createElement("div"),
            o = t;
        for (i in o)
            if (n = o[i], "undefined" != typeof a.style[n]) return a = null, [n, i];
        return [!1]
    }

    function s() {
        return o(["transition", "WebkitTransition", "MozTransition", "OTransition"])[1]
    }

    function r() {
        return o(["transform", "WebkitTransform", "MozTransform", "OTransform", "msTransform"])[0]
    }

    function l() {
        return o(["perspective", "webkitPerspective", "MozPerspective", "OPerspective", "MsPerspective"])[0]
    }

    function u() {
        return "ontouchstart" in t || !!navigator.msMaxTouchPoints
    }

    function c() {
        return t.navigator.msPointerEnabled
    }
    var d, h, f;
    d = {
        start: 0,
        startX: 0,
        startY: 0,
        current: 0,
        currentX: 0,
        currentY: 0,
        offsetX: 0,
        offsetY: 0,
        distance: null,
        startTime: 0,
        endTime: 0,
        updatedX: 0,
        targetEl: null
    }, h = {
        isTouch: !1,
        isScrolling: !1,
        isSwiping: !1,
        direction: !1,
        inMotion: !1
    }, f = {
        _onDragStart: null,
        _onDragMove: null,
        _onDragEnd: null,
        _transitionEnd: null,
        _resizer: null,
        _responsiveCall: null,
        _goToLoop: null,
        _checkVisibile: null
    }, n.Defaults = {
        items: 3,
        loop: !1,
        center: !1,
        mouseDrag: !0,
        touchDrag: !0,
        pullDrag: !0,
        freeDrag: !1,
        margin: 0,
        stagePadding: 0,
        merge: !1,
        mergeFit: !0,
        autoWidth: !1,
        startPosition: 0,
        rtl: !1,
        smartSpeed: 250,
        fluidSpeed: !1,
        dragEndSpeed: !1,
        responsive: {},
        responsiveRefreshRate: 200,
        responsiveBaseElement: t,
        responsiveClass: !1,
        fallbackEasing: "swing",
        info: !1,
        nestedItemSelector: !1,
        itemElement: "div",
        stageElement: "div",
        themeClass: "owl-theme",
        baseClass: "owl-carousel",
        itemClass: "owl-item",
        centerClass: "center",
        activeClass: "active"
    }, n.Width = {
        Default: "default",
        Inner: "inner",
        Outer: "outer"
    }, n.Plugins = {}, n.Pipe = [{
        filter: ["width", "items", "settings"],
        run: function(t) {
            t.current = this._items && this._items[this.relative(this._current)]
        }
    }, {
        filter: ["items", "settings"],
        run: function() {
            var t = this._clones,
                e = this.$stage.children(".cloned");
            (e.length !== t.length || !this.settings.loop && t.length > 0) && (this.$stage.children(".cloned").remove(), this._clones = [])
        }
    }, {
        filter: ["items", "settings"],
        run: function() {
            var t, e, i = this._clones,
                n = this._items,
                a = this.settings.loop ? i.length - Math.max(2 * this.settings.items, 4) : 0;
            for (t = 0, e = Math.abs(a / 2); e > t; t++) a > 0 ? (this.$stage.children().eq(n.length + i.length - 1).remove(), i.pop(), this.$stage.children().eq(0).remove(), i.pop()) : (i.push(i.length / 2), this.$stage.append(n[i[i.length - 1]].clone().addClass("cloned")), i.push(n.length - 1 - (i.length - 1) / 2), this.$stage.prepend(n[i[i.length - 1]].clone().addClass("cloned")))
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function() {
            var t = this.settings.rtl ? 1 : -1,
                e = (this.width() / this.settings.items).toFixed(3),
                i = 0,
                n, a, o;
            for (this._coordinates = [], a = 0, o = this._clones.length + this._items.length; o > a; a++) n = this._mergers[this.relative(a)], n = this.settings.mergeFit && Math.min(n, this.settings.items) || n, i += (this.settings.autoWidth ? this._items[this.relative(a)].width() + this.settings.margin : e * n) * t, this._coordinates.push(i)
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function() {
            var t, e, i = (this.width() / this.settings.items).toFixed(3),
                n = {
                    width: Math.abs(this._coordinates[this._coordinates.length - 1]) + 2 * this.settings.stagePadding,
                    "padding-left": this.settings.stagePadding || "",
                    "padding-right": this.settings.stagePadding || ""
                };
            if (this.$stage.css(n), n = {
                    width: this.settings.autoWidth ? "auto" : i - this.settings.margin
                }, n[this.settings.rtl ? "margin-left" : "margin-right"] = this.settings.margin, !this.settings.autoWidth && $.grep(this._mergers, function(t) {
                    return t > 1
                }).length > 0)
                for (t = 0, e = this._coordinates.length; e > t; t++) n.width = Math.abs(this._coordinates[t]) - Math.abs(this._coordinates[t - 1] || 0) - this.settings.margin, this.$stage.children().eq(t).css(n);
            else this.$stage.children().css(n)
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function(t) {
            t.current && this.reset(this.$stage.children().index(t.current))
        }
    }, {
        filter: ["position"],
        run: function() {
            this.animate(this.coordinates(this._current))
        }
    }, {
        filter: ["width", "position", "items", "settings"],
        run: function() {
            var t = this.settings.rtl ? 1 : -1,
                e = 2 * this.settings.stagePadding,
                i = this.coordinates(this.current()) + e,
                n = i + this.width() * t,
                a, o, s = [],
                r, l;
            for (r = 0, l = this._coordinates.length; l > r; r++) a = this._coordinates[r - 1] || 0, o = Math.abs(this._coordinates[r]) + e * t, (this.op(a, "<=", i) && this.op(a, ">", n) || this.op(o, "<", i) && this.op(o, ">", n)) && s.push(r);
            this.$stage.children("." + this.settings.activeClass).removeClass(this.settings.activeClass), this.$stage.children(":eq(" + s.join("), :eq(") + ")").addClass(this.settings.activeClass), this.settings.center && (this.$stage.children("." + this.settings.centerClass).removeClass(this.settings.centerClass), this.$stage.children().eq(this.current()).addClass(this.settings.centerClass))
        }
    }], n.prototype.initialize = function() {
        if (this.trigger("initialize"), this.$element.addClass(this.settings.baseClass).addClass(this.settings.themeClass).toggleClass("owl-rtl", this.settings.rtl), this.browserSupport(), this.settings.autoWidth && this.state.imagesLoaded !== !0) {
            var t, e, n;
            if (t = this.$element.find("img"), e = this.settings.nestedItemSelector ? "." + this.settings.nestedItemSelector : i, n = this.$element.children(e).width(), t.length && 0 >= n) return this.preloadAutoWidthImages(t), !1
        }
        this.$element.addClass("owl-loading"), this.$stage = $("<" + this.settings.stageElement + ' class="owl-stage"/>').wrap('<div class="owl-stage-outer">'), this.$element.append(this.$stage.parent()), this.replace(this.$element.children().not(this.$stage.parent())), this._width = this.$element.width(), this.refresh(), this.$element.removeClass("owl-loading").addClass("owl-loaded"), this.eventsCall(), this.internalEvents(), this.addTriggerableEvents(), this.trigger("initialized")
    }, n.prototype.setup = function() {
        var t = this.viewport(),
            e = this.options.responsive,
            i = -1,
            n = null;
        e ? ($.each(e, function(e) {
            t >= e && e > i && (i = Number(e))
        }), n = $.extend({}, this.options, e[i]), delete n.responsive, n.responsiveClass && this.$element.attr("class", function(t, e) {
            return e.replace(/\b owl-responsive-\S+/g, "")
        }).addClass("owl-responsive-" + i)) : n = $.extend({}, this.options), null !== this.settings && this._breakpoint === i || (this.trigger("change", {
            property: {
                name: "settings",
                value: n
            }
        }), this._breakpoint = i, this.settings = n, this.invalidate("settings"), this.trigger("changed", {
            property: {
                name: "settings",
                value: this.settings
            }
        }))
    }, n.prototype.optionsLogic = function() {
        this.$element.toggleClass("owl-center", this.settings.center), this.settings.loop && this._items.length < this.settings.items && (this.settings.loop = !1), this.settings.autoWidth && (this.settings.stagePadding = !1, this.settings.merge = !1)
    }, n.prototype.prepare = function(t) {
        var e = this.trigger("prepare", {
            content: t
        });
        return e.data || (e.data = $("<" + this.settings.itemElement + "/>").addClass(this.settings.itemClass).append(t)), this.trigger("prepared", {
            content: e.data
        }), e.data
    }, n.prototype.update = function() {
        for (var t = 0, e = this._pipe.length, i = $.proxy(function(t) {
                return this[t]
            }, this._invalidated), n = {}; e > t;)(this._invalidated.all || $.grep(this._pipe[t].filter, i).length > 0) && this._pipe[t].run(n), t++;
        this._invalidated = {}
    }, n.prototype.width = function(t) {
        switch (t = t || n.Width.Default) {
            case n.Width.Inner:
            case n.Width.Outer:
                return this._width;
            default:
                return this._width - 2 * this.settings.stagePadding + this.settings.margin
        }
    }, n.prototype.refresh = function() {
        if (0 === this._items.length) return !1;
        var e = (new Date).getTime();
        this.trigger("refresh"), this.setup(), this.optionsLogic(), this.$stage.addClass("owl-refresh"), this.update(), this.$stage.removeClass("owl-refresh"), this.state.orientation = t.orientation, this.watchVisibility(), this.trigger("refreshed")
    }, n.prototype.eventsCall = function() {
        this.e._onDragStart = $.proxy(function(t) {
            this.onDragStart(t)
        }, this), this.e._onDragMove = $.proxy(function(t) {
            this.onDragMove(t)
        }, this), this.e._onDragEnd = $.proxy(function(t) {
            this.onDragEnd(t)
        }, this), this.e._onResize = $.proxy(function(t) {
            this.onResize(t)
        }, this), this.e._transitionEnd = $.proxy(function(t) {
            this.transitionEnd(t)
        }, this), this.e._preventClick = $.proxy(function(t) {
            this.preventClick(t)
        }, this)
    }, n.prototype.onThrottledResize = function() {
        t.clearTimeout(this.resizeTimer), this.resizeTimer = t.setTimeout(this.e._onResize, this.settings.responsiveRefreshRate)
    }, n.prototype.onResize = function() {
        return this._items.length ? this._width === this.$element.width() ? !1 : this.trigger("resize").isDefaultPrevented() ? !1 : (this._width = this.$element.width(), this.invalidate("width"), this.refresh(), void this.trigger("resized")) : !1
    }, n.prototype.eventsRouter = function(t) {
        var e = t.type;
        "mousedown" === e || "touchstart" === e ? this.onDragStart(t) : "mousemove" === e || "touchmove" === e ? this.onDragMove(t) : "mouseup" === e || "touchend" === e ? this.onDragEnd(t) : "touchcancel" === e && this.onDragEnd(t)
    }, n.prototype.internalEvents = function() {
        var e = u(),
            i = c();
        this.settings.mouseDrag ? (this.$stage.on("mousedown", $.proxy(function(t) {
            this.eventsRouter(t)
        }, this)), this.$stage.on("dragstart", function() {
            return !1
        }), this.$stage.get(0).onselectstart = function() {
            return !1
        }) : this.$element.addClass("owl-text-select-on"), this.settings.touchDrag && !i && this.$stage.on("touchstart touchcancel", $.proxy(function(t) {
            this.eventsRouter(t)
        }, this)), this.transitionEndVendor && this.on(this.$stage.get(0), this.transitionEndVendor, this.e._transitionEnd, !1), this.settings.responsive !== !1 && this.on(t, "resize", $.proxy(this.onThrottledResize, this))
    }, n.prototype.onDragStart = function(i) {
        var n, o, s, r, l;
        if (n = i.originalEvent || i || t.event, 3 === n.which || this.state.isTouch) return !1;
        if ("mousedown" === n.type && this.$stage.addClass("owl-grab"), this.trigger("drag"), this.drag.startTime = (new Date).getTime(), this.speed(0), this.state.isTouch = !0, this.state.isScrolling = !1, this.state.isSwiping = !1, this.drag.distance = 0, s = a(n).x, r = a(n).y, this.drag.offsetX = this.$stage.position().left, this.drag.offsetY = this.$stage.position().top, this.settings.rtl && (this.drag.offsetX = this.$stage.position().left + this.$stage.width() - this.width() + this.settings.margin), this.state.inMotion && this.support3d) l = this.getTransformProperty(), this.drag.offsetX = l, this.animate(l), this.state.inMotion = !0;
        else if (this.state.inMotion && !this.support3d) return this.state.inMotion = !1, !1;
        this.drag.startX = s - this.drag.offsetX, this.drag.startY = r - this.drag.offsetY, this.drag.start = s - this.drag.startX, this.drag.targetEl = n.target || n.srcElement, this.drag.updatedX = this.drag.start, "IMG" !== this.drag.targetEl.tagName && "A" !== this.drag.targetEl.tagName || (this.drag.targetEl.draggable = !1), $(e).on("mousemove.owl.dragEvents mouseup.owl.dragEvents touchmove.owl.dragEvents touchend.owl.dragEvents", $.proxy(function(t) {
            this.eventsRouter(t)
        }, this))
    }, n.prototype.onDragMove = function(e) {
        var n, o, s, r, l, u, c;
        this.state.isTouch && (this.state.isScrolling || (n = e.originalEvent || e || t.event, s = a(n).x, r = a(n).y, this.drag.currentX = s - this.drag.startX, this.drag.currentY = r - this.drag.startY, this.drag.distance = this.drag.currentX - this.drag.offsetX, this.drag.distance < 0 ? this.state.direction = this.settings.rtl ? "right" : "left" : this.drag.distance > 0 && (this.state.direction = this.settings.rtl ? "left" : "right"), this.settings.loop ? this.op(this.drag.currentX, ">", this.coordinates(this.minimum())) && "right" === this.state.direction ? this.drag.currentX -= (this.settings.center && this.coordinates(0)) - this.coordinates(this._items.length) : this.op(this.drag.currentX, "<", this.coordinates(this.maximum())) && "left" === this.state.direction && (this.drag.currentX += (this.settings.center && this.coordinates(0)) - this.coordinates(this._items.length)) : (l = this.settings.rtl ? this.coordinates(this.maximum()) : this.coordinates(this.minimum()), u = this.settings.rtl ? this.coordinates(this.minimum()) : this.coordinates(this.maximum()), c = this.settings.pullDrag ? this.drag.distance / 5 : 0, this.drag.currentX = Math.max(Math.min(this.drag.currentX, l + c), u + c)), (this.drag.distance > 8 || this.drag.distance < -8) && (n.preventDefault !== i ? n.preventDefault() : n.returnValue = !1, this.state.isSwiping = !0), this.drag.updatedX = this.drag.currentX, (this.drag.currentY > 16 || this.drag.currentY < -16) && this.state.isSwiping === !1 && (this.state.isScrolling = !0, this.drag.updatedX = this.drag.start), this.animate(this.drag.updatedX)))
    }, n.prototype.onDragEnd = function(t) {
        var i, n, a;
        if (this.state.isTouch) {
            if ("mouseup" === t.type && this.$stage.removeClass("owl-grab"), this.trigger("dragged"), this.drag.targetEl.removeAttribute("draggable"), this.state.isTouch = !1, this.state.isScrolling = !1, this.state.isSwiping = !1, 0 === this.drag.distance && this.state.inMotion !== !0) return this.state.inMotion = !1, !1;
            this.drag.endTime = (new Date).getTime(), i = this.drag.endTime - this.drag.startTime, n = Math.abs(this.drag.distance), (n > 3 || i > 300) && this.removeClick(this.drag.targetEl), a = this.closest(this.drag.updatedX), this.speed(this.settings.dragEndSpeed || this.settings.smartSpeed), this.current(a), this.invalidate("position"), this.update(), this.settings.pullDrag || this.drag.updatedX !== this.coordinates(a) || this.transitionEnd(), this.drag.distance = 0, $(e).off(".owl.dragEvents")
        }
    }, n.prototype.removeClick = function(e) {
        this.drag.targetEl = e, $(e).on("click.preventClick", this.e._preventClick), t.setTimeout(function() {
            $(e).off("click.preventClick")
        }, 300)
    }, n.prototype.preventClick = function(t) {
        t.preventDefault ? t.preventDefault() : t.returnValue = !1, t.stopPropagation && t.stopPropagation(), $(t.target).off("click.preventClick")
    }, n.prototype.getTransformProperty = function() {
        var e, i;
        return e = t.getComputedStyle(this.$stage.get(0), null).getPropertyValue(this.vendorName + "transform"), e = e.replace(/matrix(3d)?\(|\)/g, "").split(","), i = 16 === e.length, i !== !0 ? e[4] : e[12]
    }, n.prototype.closest = function(t) {
        var e = -1,
            i = 30,
            n = this.width(),
            a = this.coordinates();
        return this.settings.freeDrag || $.each(a, $.proxy(function(o, s) {
            return t > s - i && s + i > t ? e = o : this.op(t, "<", s) && this.op(t, ">", a[o + 1] || s - n) && (e = "left" === this.state.direction ? o + 1 : o), -1 === e
        }, this)), this.settings.loop || (this.op(t, ">", a[this.minimum()]) ? e = t = this.minimum() : this.op(t, "<", a[this.maximum()]) && (e = t = this.maximum())), e
    }, n.prototype.animate = function(t) {
        this.trigger("translate"), this.state.inMotion = this.speed() > 0, this.support3d ? this.$stage.css({
            transform: "translate3d(" + t + "px,0px, 0px)",
            transition: this.speed() / 1e3 + "s"
        }) : this.state.isTouch ? this.$stage.css({
            left: t + "px"
        }) : this.$stage.animate({
            left: t
        }, this.speed() / 1e3, this.settings.fallbackEasing, $.proxy(function() {
            this.state.inMotion && this.transitionEnd()
        }, this))
    }, n.prototype.current = function(t) {
        if (t === i) return this._current;
        if (0 === this._items.length) return i;
        if (t = this.normalize(t), this._current !== t) {
            var e = this.trigger("change", {
                property: {
                    name: "position",
                    value: t
                }
            });
            e.data !== i && (t = this.normalize(e.data)), this._current = t, this.invalidate("position"), this.trigger("changed", {
                property: {
                    name: "position",
                    value: this._current
                }
            })
        }
        return this._current
    }, n.prototype.invalidate = function(t) {
        this._invalidated[t] = !0
    }, n.prototype.reset = function(t) {
        t = this.normalize(t), t !== i && (this._speed = 0, this._current = t, this.suppress(["translate", "translated"]), this.animate(this.coordinates(t)), this.release(["translate", "translated"]))
    }, n.prototype.normalize = function(t, e) {
        var n = e ? this._items.length : this._items.length + this._clones.length;
        return !$.isNumeric(t) || 1 > n ? i : t = this._clones.length ? (t % n + n) % n : Math.max(this.minimum(e), Math.min(this.maximum(e), t))
    }, n.prototype.relative = function(t) {
        return t = this.normalize(t), t -= this._clones.length / 2, this.normalize(t, !0)
    }, n.prototype.maximum = function(t) {
        var e, i, n = 0,
            a, o = this.settings;
        if (t) return this._items.length - 1;
        if (!o.loop && o.center) e = this._items.length - 1;
        else if (o.loop || o.center)
            if (o.loop || o.center) e = this._items.length + o.items;
            else {
                if (!o.autoWidth && !o.merge) throw "Can not detect maximum absolute position.";
                for (revert = o.rtl ? 1 : -1, i = this.$stage.width() - this.$element.width();
                    (a = this.coordinates(n)) && !(a * revert >= i);) e = ++n
            } else e = this._items.length - o.items;
        return e
    }, n.prototype.minimum = function(t) {
        return t ? 0 : this._clones.length / 2
    }, n.prototype.items = function(t) {
        return t === i ? this._items.slice() : (t = this.normalize(t, !0), this._items[t])
    }, n.prototype.mergers = function(t) {
        return t === i ? this._mergers.slice() : (t = this.normalize(t, !0), this._mergers[t])
    }, n.prototype.clones = function(t) {
        var e = this._clones.length / 2,
            n = e + this._items.length,
            a = function(t) {
                return t % 2 === 0 ? n + t / 2 : e - (t + 1) / 2
            };
        return t === i ? $.map(this._clones, function(t, e) {
            return a(e)
        }) : $.map(this._clones, function(e, i) {
            return e === t ? a(i) : null
        })
    }, n.prototype.speed = function(t) {
        return t !== i && (this._speed = t), this._speed
    }, n.prototype.coordinates = function(t) {
        var e = null;
        return t === i ? $.map(this._coordinates, $.proxy(function(t, e) {
            return this.coordinates(e)
        }, this)) : (this.settings.center ? (e = this._coordinates[t], e += (this.width() - e + (this._coordinates[t - 1] || 0)) / 2 * (this.settings.rtl ? -1 : 1)) : e = this._coordinates[t - 1] || 0, e)
    }, n.prototype.duration = function(t, e, i) {
        return Math.min(Math.max(Math.abs(e - t), 1), 6) * Math.abs(i || this.settings.smartSpeed)
    }, n.prototype.to = function(e, i) {
        if (this.settings.loop) {
            var n = e - this.relative(this.current()),
                a = this.current(),
                o = this.current(),
                s = this.current() + n,
                r = 0 > o - s,
                l = this._clones.length + this._items.length;
            s < this.settings.items && r === !1 ? (a = o + this._items.length, this.reset(a)) : s >= l - this.settings.items && r === !0 && (a = o - this._items.length, this.reset(a)), t.clearTimeout(this.e._goToLoop), this.e._goToLoop = t.setTimeout($.proxy(function() {
                this.speed(this.duration(this.current(), a + n, i)), this.current(a + n), this.update()
            }, this), 30)
        } else this.speed(this.duration(this.current(), e, i)), this.current(e), this.update()
    }, n.prototype.next = function(t) {
        t = t || !1, this.to(this.relative(this.current()) + 1, t)
    }, n.prototype.prev = function(t) {
        t = t || !1, this.to(this.relative(this.current()) - 1, t)
    }, n.prototype.transitionEnd = function(t) {
        return t !== i && (t.stopPropagation(), (t.target || t.srcElement || t.originalTarget) !== this.$stage.get(0)) ? !1 : (this.state.inMotion = !1, void this.trigger("translated"))
    }, n.prototype.viewport = function() {
        var i;
        if (this.options.responsiveBaseElement !== t) i = $(this.options.responsiveBaseElement).width();
        else if (t.innerWidth) i = t.innerWidth;
        else {
            if (!e.documentElement || !e.documentElement.clientWidth) throw "Can not detect viewport width.";
            i = e.documentElement.clientWidth
        }
        return i
    }, n.prototype.replace = function(t) {
        this.$stage.empty(), this._items = [], t && (t = t instanceof jQuery ? t : $(t)), this.settings.nestedItemSelector && (t = t.find("." + this.settings.nestedItemSelector)), t.filter(function() {
            return 1 === this.nodeType
        }).each($.proxy(function(t, e) {
            e = this.prepare(e), this.$stage.append(e), this._items.push(e), this._mergers.push(1 * e.find("[data-merge]").andSelf("[data-merge]").attr("data-merge") || 1)
        }, this)), this.reset($.isNumeric(this.settings.startPosition) ? this.settings.startPosition : 0), this.invalidate("items")
    }, n.prototype.add = function(t, e) {
        e = e === i ? this._items.length : this.normalize(e, !0), this.trigger("add", {
            content: t,
            position: e
        }), 0 === this._items.length || e === this._items.length ? (this.$stage.append(t), this._items.push(t), this._mergers.push(1 * t.find("[data-merge]").andSelf("[data-merge]").attr("data-merge") || 1)) : (this._items[e].before(t), this._items.splice(e, 0, t), this._mergers.splice(e, 0, 1 * t.find("[data-merge]").andSelf("[data-merge]").attr("data-merge") || 1)), this.invalidate("items"), this.trigger("added", {
            content: t,
            position: e
        })
    }, n.prototype.remove = function(t) {
        t = this.normalize(t, !0), t !== i && (this.trigger("remove", {
            content: this._items[t],
            position: t
        }), this._items[t].remove(), this._items.splice(t, 1), this._mergers.splice(t, 1), this.invalidate("items"), this.trigger("removed", {
            content: null,
            position: t
        }))
    }, n.prototype.addTriggerableEvents = function() {
        var t = $.proxy(function(t, e) {
            return $.proxy(function(i) {
                i.relatedTarget !== this && (this.suppress([e]), t.apply(this, [].slice.call(arguments, 1)), this.release([e]))
            }, this)
        }, this);
        $.each({
            next: this.next,
            prev: this.prev,
            to: this.to,
            destroy: this.destroy,
            refresh: this.refresh,
            replace: this.replace,
            add: this.add,
            remove: this.remove
        }, $.proxy(function(e, i) {
            this.$element.on(e + ".owl.carousel", t(i, e + ".owl.carousel"))
        }, this))
    }, n.prototype.watchVisibility = function() {
        function e(t) {
            return t.offsetWidth > 0 && t.offsetHeight > 0
        }

        function i() {
            e(this.$element.get(0)) && (this.$element.removeClass("owl-hidden"), this.refresh(), t.clearInterval(this.e._checkVisibile))
        }
        e(this.$element.get(0)) || (this.$element.addClass("owl-hidden"), t.clearInterval(this.e._checkVisibile), this.e._checkVisibile = t.setInterval($.proxy(i, this), 500))
    }, n.prototype.preloadAutoWidthImages = function(t) {
        var e, i, n, a;
        e = 0, i = this, t.each(function(o, s) {
            n = $(s), a = new Image, a.onload = function() {
                e++, n.attr("src", a.src), n.css("opacity", 1), e >= t.length && (i.state.imagesLoaded = !0, i.initialize())
            }, a.src = n.attr("src") || n.attr("data-src") || n.attr("data-src-retina")
        })
    }, n.prototype.destroy = function() {
        this.$element.hasClass(this.settings.themeClass) && this.$element.removeClass(this.settings.themeClass), this.settings.responsive !== !1 && $(t).off("resize.owl.carousel"), this.transitionEndVendor && this.off(this.$stage.get(0), this.transitionEndVendor, this.e._transitionEnd);
        for (var i in this._plugins) this._plugins[i].destroy();
        (this.settings.mouseDrag || this.settings.touchDrag) && (this.$stage.off("mousedown touchstart touchcancel"), $(e).off(".owl.dragEvents"), this.$stage.get(0).onselectstart = function() {}, this.$stage.off("dragstart", function() {
            return !1
        })), this.$element.off(".owl"), this.$stage.children(".cloned").remove(), this.e = null, this.$element.removeData("owlCarousel"), this.$stage.children().contents().unwrap(), this.$stage.children().unwrap(), this.$stage.unwrap()
    }, n.prototype.op = function(t, e, i) {
        var n = this.settings.rtl;
        switch (e) {
            case "<":
                return n ? t > i : i > t;
            case ">":
                return n ? i > t : t > i;
            case ">=":
                return n ? i >= t : t >= i;
            case "<=":
                return n ? t >= i : i >= t
        }
    }, n.prototype.on = function(t, e, i, n) {
        t.addEventListener ? t.addEventListener(e, i, n) : t.attachEvent && t.attachEvent("on" + e, i)
    }, n.prototype.off = function(t, e, i, n) {
        t.removeEventListener ? t.removeEventListener(e, i, n) : t.detachEvent && t.detachEvent("on" + e, i)
    }, n.prototype.trigger = function(t, e, i) {
        var n = {
                item: {
                    count: this._items.length,
                    index: this.current()
                }
            },
            a = $.camelCase($.grep(["on", t, i], function(t) {
                return t
            }).join("-").toLowerCase()),
            o = $.Event([t, "owl", i || "carousel"].join(".").toLowerCase(), $.extend({
                relatedTarget: this
            }, n, e));
        return this._supress[t] || ($.each(this._plugins, function(t, e) {
            e.onTrigger && e.onTrigger(o)
        }), this.$element.trigger(o), this.settings && "function" == typeof this.settings[a] && this.settings[a].apply(this, o)), o
    }, n.prototype.suppress = function(t) {
        $.each(t, $.proxy(function(t, e) {
            this._supress[e] = !0
        }, this))
    }, n.prototype.release = function(t) {
        $.each(t, $.proxy(function(t, e) {
            delete this._supress[e]
        }, this))
    }, n.prototype.browserSupport = function() {
        if (this.support3d = l(), this.support3d) {
            this.transformVendor = r();
            var e = ["transitionend", "webkitTransitionEnd", "transitionend", "oTransitionEnd"];
            this.transitionEndVendor = e[s()], this.vendorName = this.transformVendor.replace(/Transform/i, ""), this.vendorName = "" !== this.vendorName ? "-" + this.vendorName.toLowerCase() + "-" : ""
        }
        this.state.orientation = t.orientation
    }, $.fn.owlCarousel = function(t) {
        return this.each(function() {
            $(this).data("owlCarousel") || $(this).data("owlCarousel", new n(this, t))
        })
    }, $.fn.owlCarousel.Constructor = n
}(window.Zepto || window.jQuery, window, document),
function($, t, e, i) {
    var n = function(t) {
        this._core = t, this._loaded = [], this._handlers = {
            "initialized.owl.carousel change.owl.carousel": $.proxy(function(t) {
                if (t.namespace && this._core.settings && this._core.settings.lazyLoad && (t.property && "position" == t.property.name || "initialized" == t.type))
                    for (var e = this._core.settings, i = e.center && Math.ceil(e.items / 2) || e.items, n = e.center && -1 * i || 0, a = (t.property && t.property.value || this._core.current()) + n, o = this._core.clones().length, s = $.proxy(function(t, e) {
                            this.load(e)
                        }, this); n++ < i;) this.load(o / 2 + this._core.relative(a)), o && $.each(this._core.clones(this._core.relative(a++)), s)
            }, this)
        }, this._core.options = $.extend({}, n.Defaults, this._core.options), this._core.$element.on(this._handlers)
    };
    n.Defaults = {
        lazyLoad: !1
    }, n.prototype.load = function(e) {
        var i = this._core.$stage.children().eq(e),
            n = i && i.find(".owl-lazy");
        !n || $.inArray(i.get(0), this._loaded) > -1 || (n.each($.proxy(function(e, i) {
            var n = $(i),
                a, o = t.devicePixelRatio > 1 && n.attr("data-src-retina") || n.attr("data-src");
            this._core.trigger("load", {
                element: n,
                url: o
            }, "lazy"), n.is("img") ? n.one("load.owl.lazy", $.proxy(function() {
                n.css("opacity", 1), this._core.trigger("loaded", {
                    element: n,
                    url: o
                }, "lazy")
            }, this)).attr("src", o) : (a = new Image, a.onload = $.proxy(function() {
                n.css({
                    "background-image": "url(" + o + ")",
                    opacity: "1"
                }), this._core.trigger("loaded", {
                    element: n,
                    url: o
                }, "lazy")
            }, this), a.src = o)
        }, this)), this._loaded.push(i.get(0)))
    }, n.prototype.destroy = function() {
        var t, e;
        for (t in this.handlers) this._core.$element.off(t, this.handlers[t]);
        for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null)
    }, $.fn.owlCarousel.Constructor.Plugins.Lazy = n
}(window.Zepto || window.jQuery, window, document),
function($, t, e, i) {
    var n = function(t) {
        this._core = t, this._handlers = {
            "initialized.owl.carousel": $.proxy(function() {
                this._core.settings.autoHeight && this.update()
            }, this),
            "changed.owl.carousel": $.proxy(function(t) {
                this._core.settings.autoHeight && "position" == t.property.name && this.update()
            }, this),
            "loaded.owl.lazy": $.proxy(function(t) {
                this._core.settings.autoHeight && t.element.closest("." + this._core.settings.itemClass) === this._core.$stage.children().eq(this._core.current()) && this.update()
            }, this)
        }, this._core.options = $.extend({}, n.Defaults, this._core.options), this._core.$element.on(this._handlers)
    };
    n.Defaults = {
        autoHeight: !1,
        autoHeightClass: "owl-height"
    }, n.prototype.update = function() {
        this._core.$stage.parent().height(this._core.$stage.children().eq(this._core.current()).height()).addClass(this._core.settings.autoHeightClass)
    }, n.prototype.destroy = function() {
        var t, e;
        for (t in this._handlers) this._core.$element.off(t, this._handlers[t]);
        for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null)
    }, $.fn.owlCarousel.Constructor.Plugins.AutoHeight = n
}(window.Zepto || window.jQuery, window, document),
function($, t, e, i) {
    var n = function(t) {
        this._core = t, this._videos = {}, this._playing = null, this._fullscreen = !1, this._handlers = {
            "resize.owl.carousel": $.proxy(function(t) {
                this._core.settings.video && !this.isInFullScreen() && t.preventDefault()
            }, this),
            "refresh.owl.carousel changed.owl.carousel": $.proxy(function(t) {
                this._playing && this.stop()
            }, this),
            "prepared.owl.carousel": $.proxy(function(t) {
                var e = $(t.content).find(".owl-video");
                e.length && (e.css("display", "none"), this.fetch(e, $(t.content)))
            }, this)
        }, this._core.options = $.extend({}, n.Defaults, this._core.options), this._core.$element.on(this._handlers), this._core.$element.on("click.owl.video", ".owl-video-play-icon", $.proxy(function(t) {
            this.play(t)
        }, this))
    };
    n.Defaults = {
        video: !1,
        videoHeight: !1,
        videoWidth: !1
    }, n.prototype.fetch = function(t, e) {
        var i = t.attr("data-vimeo-id") ? "vimeo" : "youtube",
            n = t.attr("data-vimeo-id") || t.attr("data-youtube-id"),
            a = t.attr("data-width") || this._core.settings.videoWidth,
            o = t.attr("data-height") || this._core.settings.videoHeight,
            s = t.attr("href");
        if (!s) throw new Error("Missing video URL.");
        if (n = s.match(/(http:|https:|)\/\/(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/), n[3].indexOf("youtu") > -1) i = "youtube";
        else {
            if (!(n[3].indexOf("vimeo") > -1)) throw new Error("Video URL not supported.");
            i = "vimeo"
        }
        n = n[6], this._videos[s] = {
            type: i,
            id: n,
            width: a,
            height: o
        }, e.attr("data-video", s), this.thumbnail(t, this._videos[s])
    }, n.prototype.thumbnail = function(t, e) {
        var i, n, a, o = e.width && e.height ? 'style="width:' + e.width + "px;height:" + e.height + 'px;"' : "",
            s = t.find("img"),
            r = "src",
            l = "",
            u = this._core.settings,
            c = function(e) {
                n = '<div class="owl-video-play-icon"></div>', i = u.lazyLoad ? '<div class="owl-video-tn ' + l + '" ' + r + '="' + e + '"></div>' : '<div class="owl-video-tn" style="opacity:1;background-image:url(' + e + ')"></div>', t.after(i), t.after(n)
            };
        return t.wrap('<div class="owl-video-wrapper"' + o + "></div>"), this._core.settings.lazyLoad && (r = "data-src", l = "owl-lazy"), s.length ? (c(s.attr(r)), s.remove(), !1) : void("youtube" === e.type ? (a = "http://img.youtube.com/vi/" + e.id + "/hqdefault.jpg", c(a)) : "vimeo" === e.type && $.ajax({
            type: "GET",
            url: "http://vimeo.com/api/v2/video/" + e.id + ".json",
            jsonp: "callback",
            dataType: "jsonp",
            success: function(t) {
                a = t[0].thumbnail_large, c(a)
            }
        }))
    }, n.prototype.stop = function() {
        this._core.trigger("stop", null, "video"), this._playing.find(".owl-video-frame").remove(), this._playing.removeClass("owl-video-playing"), this._playing = null
    }, n.prototype.play = function(t) {
        this._core.trigger("play", null, "video"), this._playing && this.stop();
        var e = $(t.target || t.srcElement),
            i = e.closest("." + this._core.settings.itemClass),
            n = this._videos[i.attr("data-video")],
            a = n.width || "100%",
            o = n.height || this._core.$stage.height(),
            s, r;
        "youtube" === n.type ? s = '<iframe width="' + a + '" height="' + o + '" src="https://www.youtube.com/embed/' + n.id + "?autoplay=1&v=" + n.id + '" frameborder="0" allowfullscreen></iframe>' : "vimeo" === n.type && (s = '<iframe src="https://player.vimeo.com/video/' + n.id + '?autoplay=1" width="' + a + '" height="' + o + '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'), i.addClass("owl-video-playing"), this._playing = i, r = $('<div style="height:' + o + "px; width:" + a + 'px" class="owl-video-frame">' + s + "</div>"), e.after(r)
    }, n.prototype.isInFullScreen = function() {
        var i = e.fullscreenElement || e.mozFullScreenElement || e.webkitFullscreenElement;
        return i && $(i).parent().hasClass("owl-video-frame") && (this._core.speed(0), this._fullscreen = !0), i && this._fullscreen && this._playing ? !1 : this._fullscreen ? (this._fullscreen = !1, !1) : this._playing && this._core.state.orientation !== t.orientation ? (this._core.state.orientation = t.orientation, !1) : !0
    }, n.prototype.destroy = function() {
        var t, e;
        this._core.$element.off("click.owl.video");
        for (t in this._handlers) this._core.$element.off(t, this._handlers[t]);
        for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null)
    }, $.fn.owlCarousel.Constructor.Plugins.Video = n
}(window.Zepto || window.jQuery, window, document),
function($, t, e, i) {
    var n = function(t) {
        this.core = t, this.core.options = $.extend({}, n.Defaults, this.core.options), this.swapping = !0, this.previous = i, this.next = i, this.handlers = {
            "change.owl.carousel": $.proxy(function(t) {
                "position" == t.property.name && (this.previous = this.core.current(), this.next = t.property.value)
            }, this),
            "drag.owl.carousel dragged.owl.carousel translated.owl.carousel": $.proxy(function(t) {
                this.swapping = "translated" == t.type
            }, this),
            "translate.owl.carousel": $.proxy(function(t) {
                this.swapping && (this.core.options.animateOut || this.core.options.animateIn) && this.swap()
            }, this)
        }, this.core.$element.on(this.handlers)
    };
    n.Defaults = {
        animateOut: !1,
        animateIn: !1
    }, n.prototype.swap = function() {
        if (1 === this.core.settings.items && this.core.support3d) {
            this.core.speed(0);
            var t, e = $.proxy(this.clear, this),
                i = this.core.$stage.children().eq(this.previous),
                n = this.core.$stage.children().eq(this.next),
                a = this.core.settings.animateIn,
                o = this.core.settings.animateOut;
            this.core.current() !== this.previous && (o && (t = this.core.coordinates(this.previous) - this.core.coordinates(this.next), i.css({
                left: t + "px"
            }).addClass("animated owl-animated-out").addClass(o).one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", e)), a && n.addClass("animated owl-animated-in").addClass(a).one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", e))
        }
    }, n.prototype.clear = function(t) {
        $(t.target).css({
            left: ""
        }).removeClass("animated owl-animated-out owl-animated-in").removeClass(this.core.settings.animateIn).removeClass(this.core.settings.animateOut), this.core.transitionEnd()
    }, n.prototype.destroy = function() {
        var t, e;
        for (t in this.handlers) this.core.$element.off(t, this.handlers[t]);
        for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null)
    }, $.fn.owlCarousel.Constructor.Plugins.Animate = n
}(window.Zepto || window.jQuery, window, document),
function($, t, e, i) {
    var n = function(t) {
        this.core = t, this.core.options = $.extend({}, n.Defaults, this.core.options), this.handlers = {
            "translated.owl.carousel refreshed.owl.carousel": $.proxy(function() {
                this.autoplay()
            }, this),
            "play.owl.autoplay": $.proxy(function(t, e, i) {
                this.play(e, i)
            }, this),
            "stop.owl.autoplay": $.proxy(function() {
                this.stop()
            }, this),
            "mouseover.owl.autoplay": $.proxy(function() {
                this.core.settings.autoplayHoverPause && this.pause()
            }, this),
            "mouseleave.owl.autoplay": $.proxy(function() {
                this.core.settings.autoplayHoverPause && this.autoplay()
            }, this)
        }, this.core.$element.on(this.handlers)
    };
    n.Defaults = {
        autoplay: !1,
        autoplayTimeout: 5e3,
        autoplayHoverPause: !1,
        autoplaySpeed: !1
    }, n.prototype.autoplay = function() {
        this.core.settings.autoplay && !this.core.state.videoPlay ? (t.clearInterval(this.interval), this.interval = t.setInterval($.proxy(function() {
            this.play()
        }, this), this.core.settings.autoplayTimeout)) : t.clearInterval(this.interval)
    }, n.prototype.play = function(i, n) {
        return e.hidden === !0 || this.core.state.isTouch || this.core.state.isScrolling || this.core.state.isSwiping || this.core.state.inMotion ? void 0 : this.core.settings.autoplay === !1 ? void t.clearInterval(this.interval) : void this.core.next(this.core.settings.autoplaySpeed)
    }, n.prototype.stop = function() {
        t.clearInterval(this.interval)
    }, n.prototype.pause = function() {
        t.clearInterval(this.interval)
    }, n.prototype.destroy = function() {
        var e, i;
        t.clearInterval(this.interval);
        for (e in this.handlers) this.core.$element.off(e, this.handlers[e]);
        for (i in Object.getOwnPropertyNames(this)) "function" != typeof this[i] && (this[i] = null)
    }, $.fn.owlCarousel.Constructor.Plugins.autoplay = n
}(window.Zepto || window.jQuery, window, document),
function($, t, e, i) {
    "use strict";
    var n = function(t) {
        this._core = t, this._initialized = !1, this._pages = [], this._controls = {}, this._templates = [], this.$element = this._core.$element, this._overrides = {
            next: this._core.next,
            prev: this._core.prev,
            to: this._core.to
        }, this._handlers = {
            "prepared.owl.carousel": $.proxy(function(t) {
                this._core.settings.dotsData && this._templates.push($(t.content).find("[data-dot]").andSelf("[data-dot]").attr("data-dot"))
            }, this),
            "add.owl.carousel": $.proxy(function(t) {
                this._core.settings.dotsData && this._templates.splice(t.position, 0, $(t.content).find("[data-dot]").andSelf("[data-dot]").attr("data-dot"))
            }, this),
            "remove.owl.carousel prepared.owl.carousel": $.proxy(function(t) {
                this._core.settings.dotsData && this._templates.splice(t.position, 1)
            }, this),
            "change.owl.carousel": $.proxy(function(t) {
                if ("position" == t.property.name && !this._core.state.revert && !this._core.settings.loop && this._core.settings.navRewind) {
                    var e = this._core.current(),
                        i = this._core.maximum(),
                        n = this._core.minimum();
                    t.data = t.property.value > i ? e >= i ? n : i : t.property.value < n ? i : t.property.value
                }
            }, this),
            "changed.owl.carousel": $.proxy(function(t) {
                "position" == t.property.name && this.draw()
            }, this),
            "refreshed.owl.carousel": $.proxy(function() {
                this._initialized || (this.initialize(), this._initialized = !0), this._core.trigger("refresh", null, "navigation"), this.update(), this.draw(), this._core.trigger("refreshed", null, "navigation")
            }, this)
        }, this._core.options = $.extend({}, n.Defaults, this._core.options), this.$element.on(this._handlers)
    };
    n.Defaults = {
        nav: !1,
        navRewind: !0,
        navText: ["prev", "next"],
        navSpeed: !1,
        navElement: "div",
        navContainer: !1,
        navContainerClass: "owl-nav",
        navClass: ["owl-prev", "owl-next"],
        slideBy: 1,
        dotClass: "owl-dot",
        dotsClass: "owl-dots",
        dots: !0,
        dotsEach: !1,
        dotData: !1,
        dotsSpeed: !1,
        dotsContainer: !1,
        controlsClass: "owl-controls"
    }, n.prototype.initialize = function() {
        var t, e, i = this._core.settings;
        i.dotsData || (this._templates = [$("<div>").addClass(i.dotClass).append($("<span>")).prop("outerHTML")]), i.navContainer && i.dotsContainer || (this._controls.$container = $("<div>").addClass(i.controlsClass).appendTo(this.$element)), this._controls.$indicators = i.dotsContainer ? $(i.dotsContainer) : $("<div>").hide().addClass(i.dotsClass).appendTo(this._controls.$container), this._controls.$indicators.on("click", "div", $.proxy(function(t) {
            var e = $(t.target).parent().is(this._controls.$indicators) ? $(t.target).index() : $(t.target).parent().index();
            t.preventDefault(), this.to(e, i.dotsSpeed)
        }, this)), t = i.navContainer ? $(i.navContainer) : $("<div>").addClass(i.navContainerClass).prependTo(this._controls.$container), this._controls.$next = $("<" + i.navElement + ">"), this._controls.$previous = this._controls.$next.clone(), this._controls.$previous.addClass(i.navClass[0]).html(i.navText[0]).hide().prependTo(t).on("click", $.proxy(function(t) {
            this.prev(i.navSpeed)
        }, this)), this._controls.$next.addClass(i.navClass[1]).html(i.navText[1]).hide().appendTo(t).on("click", $.proxy(function(t) {
            this.next(i.navSpeed)
        }, this));
        for (e in this._overrides) this._core[e] = $.proxy(this[e], this)
    }, n.prototype.destroy = function() {
        var t, e, i, n;
        for (t in this._handlers) this.$element.off(t, this._handlers[t]);
        for (e in this._controls) this._controls[e].remove();
        for (n in this.overides) this._core[n] = this._overrides[n];
        for (i in Object.getOwnPropertyNames(this)) "function" != typeof this[i] && (this[i] = null)
    }, n.prototype.update = function() {
        var t, e, i, n = this._core.settings,
            a = this._core.clones().length / 2,
            o = a + this._core.items().length,
            s = n.center || n.autoWidth || n.dotData ? 1 : n.dotsEach || n.items;
        if ("page" !== n.slideBy && (n.slideBy = Math.min(n.slideBy, n.items)), n.dots || "page" == n.slideBy)
            for (this._pages = [], t = a, e = 0, i = 0; o > t; t++)(e >= s || 0 === e) && (this._pages.push({
                start: t - a,
                end: t - a + s - 1
            }), e = 0, ++i), e += this._core.mergers(this._core.relative(t))
    }, n.prototype.draw = function() {
        var t, e, i = "",
            n = this._core.settings,
            a = this._core.$stage.children(),
            o = this._core.relative(this._core.current());
        if (!n.nav || n.loop || n.navRewind || (this._controls.$previous.toggleClass("disabled", 0 >= o), this._controls.$next.toggleClass("disabled", o >= this._core.maximum())), this._controls.$previous.toggle(n.nav), this._controls.$next.toggle(n.nav), n.dots) {
            if (t = this._pages.length - this._controls.$indicators.children().length, n.dotData && 0 !== t) {
                for (e = 0; e < this._controls.$indicators.children().length; e++) i += this._templates[this._core.relative(e)];
                this._controls.$indicators.html(i)
            } else t > 0 ? (i = new Array(t + 1).join(this._templates[0]), this._controls.$indicators.append(i)) : 0 > t && this._controls.$indicators.children().slice(t).remove();
            this._controls.$indicators.find(".active").removeClass("active"), this._controls.$indicators.children().eq($.inArray(this.current(), this._pages)).addClass("active")
        }
        this._controls.$indicators.toggle(n.dots)
    }, n.prototype.onTrigger = function(t) {
        var e = this._core.settings;
        t.page = {
            index: $.inArray(this.current(), this._pages),
            count: this._pages.length,
            size: e && (e.center || e.autoWidth || e.dotData ? 1 : e.dotsEach || e.items)
        }
    }, n.prototype.current = function() {
        var t = this._core.relative(this._core.current());
        return $.grep(this._pages, function(e) {
            return e.start <= t && e.end >= t
        }).pop()
    }, n.prototype.getPosition = function(t) {
        var e, i, n = this._core.settings;
        return "page" == n.slideBy ? (e = $.inArray(this.current(), this._pages), i = this._pages.length, t ? ++e : --e, e = this._pages[(e % i + i) % i].start) : (e = this._core.relative(this._core.current()), i = this._core.items().length, t ? e += n.slideBy : e -= n.slideBy), e
    }, n.prototype.next = function(t) {
        $.proxy(this._overrides.to, this._core)(this.getPosition(!0), t)
    }, n.prototype.prev = function(t) {
        $.proxy(this._overrides.to, this._core)(this.getPosition(!1), t)
    }, n.prototype.to = function(t, e, i) {
        var n;
        i ? $.proxy(this._overrides.to, this._core)(t, e) : (n = this._pages.length, $.proxy(this._overrides.to, this._core)(this._pages[(t % n + n) % n].start, e))
    }, $.fn.owlCarousel.Constructor.Plugins.Navigation = n
}(window.Zepto || window.jQuery, window, document),
function($, t, e, i) {
    "use strict";
    var n = function(e) {
        this._core = e, this._hashes = {}, this.$element = this._core.$element, this._handlers = {
            "initialized.owl.carousel": $.proxy(function() {
                "URLHash" == this._core.settings.startPosition && $(t).trigger("hashchange.owl.navigation")
            }, this),
            "prepared.owl.carousel": $.proxy(function(t) {
                var e = $(t.content).find("[data-hash]").andSelf("[data-hash]").attr("data-hash");
                this._hashes[e] = t.content
            }, this)
        }, this._core.options = $.extend({}, n.Defaults, this._core.options), this.$element.on(this._handlers), $(t).on("hashchange.owl.navigation", $.proxy(function() {
            var e = t.location.hash.substring(1),
                i = this._core.$stage.children(),
                n = this._hashes[e] && i.index(this._hashes[e]) || 0;
            return e ? void this._core.to(n, !1, !0) : !1
        }, this))
    };
    n.Defaults = {
        URLhashListener: !1
    }, n.prototype.destroy = function() {
        var e, i;
        $(t).off("hashchange.owl.navigation");
        for (e in this._handlers) this._core.$element.off(e, this._handlers[e]);
        for (i in Object.getOwnPropertyNames(this)) "function" != typeof this[i] && (this[i] = null)
    }, $.fn.owlCarousel.Constructor.Plugins.Hash = n
}(window.Zepto || window.jQuery, window, document), ! function(t, e, i) {
    "use strict";

    function n(i) {
        if (a = e.documentElement, o = e.body, W(), rt = this, i = i || {}, ht = i.constants || {}, i.easing)
            for (var n in i.easing) Y[n] = i.easing[n];
        wt = i.edgeStrategy || "set", ct = {
            beforerender: i.beforerender,
            render: i.render,
            keyframe: i.keyframe
        }, dt = i.forceHeight !== !1, dt && (qt = i.scale || 1), ft = i.mobileDeceleration || S, mt = i.smoothScrolling !== !1, gt = i.smoothScrollingDuration || T, vt = {
            targetTop: rt.getScrollTop()
        }, Bt = (i.mobileCheck || function() {
            return /Android|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent || navigator.vendor || t.opera)
        })(), Bt ? (ut = e.getElementById(i.skrollrBody || k), ut && st(), G(), Dt(a, [y, _], [w])) : Dt(a, [y, b], [w]), rt.refresh(), Ct(t, "resize orientationchange", function() {
            var t = a.clientWidth,
                e = a.clientHeight;
            (e !== zt || t !== $t) && (zt = e, $t = t, Ht = !0)
        });
        var s = X();
        return function r() {
            $(), _t = s(r)
        }(), rt
    }
    var a, o, s = {
            get: function() {
                return rt
            },
            init: function(t) {
                return rt || new n(t)
            },
            VERSION: "0.6.30"
        },
        r = Object.prototype.hasOwnProperty,
        l = t.Math,
        u = t.getComputedStyle,
        c = "touchstart",
        d = "touchmove",
        h = "touchcancel",
        f = "touchend",
        p = "skrollable",
        m = p + "-before",
        g = p + "-between",
        v = p + "-after",
        y = "skrollr",
        w = "no-" + y,
        b = y + "-desktop",
        _ = y + "-mobile",
        C = "linear",
        x = 1e3,
        S = .004,
        k = "skrollr-body",
        T = 200,
        M = "start",
        P = "end",
        O = "center",
        D = "bottom",
        L = "___skrollable_id",
        E = /^(?:input|textarea|button|select)$/i,
        F = /^\s+|\s+$/g,
        A = /^data(?:-(_\w+))?(?:-?(-?\d*\.?\d+p?))?(?:-?(start|end|top|center|bottom))?(?:-?(top|center|bottom))?$/,
        I = /\s*(@?[\w\-\[\]]+)\s*:\s*(.+?)\s*(?:;|$)/gi,
        q = /^(@?[a-z\-]+)\[(\w+)\]$/,
        j = /-([a-z0-9_])/g,
        N = function(t, e) {
            return e.toUpperCase()
        },
        V = /[\-+]?[\d]*\.?[\d]+/g,
        z = /\{\?\}/g,
        H = /rgba?\(\s*-?\d+\s*,\s*-?\d+\s*,\s*-?\d+/g,
        R = /[a-z\-]+-gradient/g,
        B = "",
        Q = "",
        W = function() {
            var t = /^(?:O|Moz|webkit|ms)|(?:-(?:o|moz|webkit|ms)-)/;
            if (u) {
                var e = u(o, null);
                for (var i in e)
                    if (B = i.match(t) || +i == i && e[i].match(t)) break;
                if (!B) return void(B = Q = "");
                B = B[0], "-" === B.slice(0, 1) ? (Q = B, B = {
                    "-webkit-": "webkit",
                    "-moz-": "Moz",
                    "-ms-": "ms",
                    "-o-": "O"
                }[B]) : Q = "-" + B.toLowerCase() + "-"
            }
        },
        X = function() {
            var e = t.requestAnimationFrame || t[B.toLowerCase() + "RequestAnimationFrame"],
                i = Ft();
            return (Bt || !e) && (e = function(e) {
                var n = Ft() - i,
                    a = l.max(0, 1e3 / 60 - n);
                return t.setTimeout(function() {
                    i = Ft(), e()
                }, a)
            }), e
        },
        U = function() {
            var e = t.cancelAnimationFrame || t[B.toLowerCase() + "CancelAnimationFrame"];
            return (Bt || !e) && (e = function(e) {
                return t.clearTimeout(e)
            }), e
        },
        Y = {
            begin: function() {
                return 0
            },
            end: function() {
                return 1
            },
            linear: function(t) {
                return t
            },
            quadratic: function(t) {
                return t * t
            },
            cubic: function(t) {
                return t * t * t
            },
            swing: function(t) {
                return -l.cos(t * l.PI) / 2 + .5
            },
            sqrt: function(t) {
                return l.sqrt(t)
            },
            outCubic: function(t) {
                return l.pow(t - 1, 3) + 1
            },
            bounce: function(t) {
                var e;
                if (.5083 >= t) e = 3;
                else if (.8489 >= t) e = 9;
                else if (.96208 >= t) e = 27;
                else {
                    if (!(.99981 >= t)) return 1;
                    e = 91
                }
                return 1 - l.abs(3 * l.cos(t * e * 1.028) / e)
            }
        };
    n.prototype.refresh = function(t) {
        var n, a, o = !1;
        for (t === i ? (o = !0, lt = [], Rt = 0, t = e.getElementsByTagName("*")) : t.length === i && (t = [t]), n = 0, a = t.length; a > n; n++) {
            var s = t[n],
                r = s,
                l = [],
                u = mt,
                c = wt,
                d = !1;
            if (o && L in s && delete s[L], s.attributes) {
                for (var h = 0, f = s.attributes.length; f > h; h++) {
                    var m = s.attributes[h];
                    if ("data-anchor-target" !== m.name)
                        if ("data-smooth-scrolling" !== m.name)
                            if ("data-edge-strategy" !== m.name)
                                if ("data-emit-events" !== m.name) {
                                    var g = m.name.match(A);
                                    if (null !== g) {
                                        var v = {
                                            props: m.value,
                                            element: s,
                                            eventType: m.name.replace(j, N)
                                        };
                                        l.push(v);
                                        var y = g[1];
                                        y && (v.constant = y.substr(1));
                                        var w = g[2];
                                        /p$/.test(w) ? (v.isPercentage = !0, v.offset = (0 | w.slice(0, -1)) / 100) : v.offset = 0 | w;
                                        var b = g[3],
                                            _ = g[4] || b;
                                        b && b !== M && b !== P ? (v.mode = "relative", v.anchors = [b, _]) : (v.mode = "absolute", b === P ? v.isEnd = !0 : v.isPercentage || (v.offset = v.offset * qt))
                                    }
                                } else d = !0;
                    else c = m.value;
                    else u = "off" !== m.value;
                    else if (r = e.querySelector(m.value), null === r) throw 'Unable to find anchor target "' + m.value + '"'
                }
                if (l.length) {
                    var C, x, S;
                    !o && L in s ? (S = s[L], C = lt[S].styleAttr, x = lt[S].classAttr) : (S = s[L] = Rt++, C = s.style.cssText, x = Ot(s)), lt[S] = {
                        element: s,
                        styleAttr: C,
                        classAttr: x,
                        anchorTarget: r,
                        keyFrames: l,
                        smoothScrolling: u,
                        edgeStrategy: c,
                        emitEvents: d,
                        lastFrameIndex: -1
                    }, Dt(s, [p], [])
                }
            }
        }
        for (Tt(), n = 0, a = t.length; a > n; n++) {
            var k = lt[t[n][L]];
            k !== i && (K(k), et(k))
        }
        return rt
    }, n.prototype.relativeToAbsolute = function(t, e, i) {
        var n = a.clientHeight,
            o = t.getBoundingClientRect(),
            s = o.top,
            r = o.bottom - o.top;
        return e === D ? s -= n : e === O && (s -= n / 2), i === D ? s += r : i === O && (s += r / 2), s += rt.getScrollTop(), s + .5 | 0
    }, n.prototype.animateTo = function(t, e) {
        e = e || {};
        var n = Ft(),
            a = rt.getScrollTop(),
            o = e.duration === i ? x : e.duration;
        return pt = {
            startTop: a,
            topDiff: t - a,
            targetTop: t,
            duration: o,
            startTime: n,
            endTime: n + o,
            easing: Y[e.easing || C],
            done: e.done
        }, pt.topDiff || (pt.done && pt.done.call(rt, !1), pt = i), rt
    }, n.prototype.stopAnimateTo = function() {
        pt && pt.done && pt.done.call(rt, !0), pt = i
    }, n.prototype.isAnimatingTo = function() {
        return !!pt
    }, n.prototype.isMobile = function() {
        return Bt
    }, n.prototype.setScrollTop = function(e, i) {
        return yt = i === !0, Bt ? Qt = l.min(l.max(e, 0), It) : t.scrollTo(0, e), rt
    }, n.prototype.getScrollTop = function() {
        return Bt ? Qt : t.pageYOffset || a.scrollTop || o.scrollTop || 0
    }, n.prototype.getMaxScrollTop = function() {
        return It
    }, n.prototype.on = function(t, e) {
        return ct[t] = e, rt
    }, n.prototype.off = function(t) {
        return delete ct[t], rt
    }, n.prototype.destroy = function() {
        var t = U();
        t(_t), St(), Dt(a, [w], [y, b, _]);
        for (var e = 0, n = lt.length; n > e; e++) ot(lt[e].element);
        a.style.overflow = o.style.overflow = "", a.style.height = o.style.height = "", ut && s.setStyle(ut, "transform", "none"), rt = i, ut = i, ct = i, dt = i, It = 0, qt = 1, ht = i, ft = i, jt = "down", Nt = -1, $t = 0, zt = 0, Ht = !1, pt = i, mt = i, gt = i, vt = i, yt = i, Rt = 0, wt = i, Bt = !1, Qt = 0, bt = i
    };
    var G = function() {
            var n, s, r, u, p, m, g, v, y, w, b, _;
            Ct(a, [c, d, h, f].join(" "), function(t) {
                var a = t.changedTouches[0];
                for (u = t.target; 3 === u.nodeType;) u = u.parentNode;
                switch (p = a.clientY, m = a.clientX, w = t.timeStamp, E.test(u.tagName) || t.preventDefault(), t.type) {
                    case c:
                        n && n.blur(), rt.stopAnimateTo(), n = u, s = g = p, r = m, y = w;
                        break;
                    case d:
                        E.test(u.tagName) && e.activeElement !== u && t.preventDefault(), v = p - g, _ = w - b, rt.setScrollTop(Qt - v, !0), g = p, b = w;
                        break;
                    default:
                    case h:
                    case f:
                        var o = s - p,
                            C = r - m,
                            x = C * C + o * o;
                        if (49 > x) {
                            if (!E.test(n.tagName)) {
                                n.focus();
                                var S = e.createEvent("MouseEvents");
                                S.initMouseEvent("click", !0, !0, t.view, 1, a.screenX, a.screenY, a.clientX, a.clientY, t.ctrlKey, t.altKey, t.shiftKey, t.metaKey, 0, null), n.dispatchEvent(S)
                            }
                            return
                        }
                        n = i;
                        var k = v / _;
                        k = l.max(l.min(k, 3), -3);
                        var T = l.abs(k / ft),
                            M = k * T + .5 * ft * T * T,
                            P = rt.getScrollTop() - M,
                            O = 0;
                        P > It ? (O = (It - P) / M, P = It) : 0 > P && (O = -P / M, P = 0), T *= 1 - O, rt.animateTo(P + .5 | 0, {
                            easing: "outCubic",
                            duration: T
                        })
                }
            }), t.scrollTo(0, 0), a.style.overflow = o.style.overflow = "hidden";
        },
        Z = function() {
            var t, e, i, n, o, s, r, u, c, d, h, f = a.clientHeight,
                p = Mt();
            for (u = 0, c = lt.length; c > u; u++)
                for (t = lt[u], e = t.element, i = t.anchorTarget, n = t.keyFrames, o = 0, s = n.length; s > o; o++) r = n[o], d = r.offset, h = p[r.constant] || 0, r.frame = d, r.isPercentage && (d *= f, r.frame = d), "relative" === r.mode && (ot(e), r.frame = rt.relativeToAbsolute(i, r.anchors[0], r.anchors[1]) - d, ot(e, !0)), r.frame += h, dt && !r.isEnd && r.frame > It && (It = r.frame);
            for (It = l.max(It, Pt()), u = 0, c = lt.length; c > u; u++) {
                for (t = lt[u], n = t.keyFrames, o = 0, s = n.length; s > o; o++) r = n[o], h = p[r.constant] || 0, r.isEnd && (r.frame = It - r.offset + h);
                t.keyFrames.sort(At)
            }
        },
        J = function(t, e) {
            for (var i = 0, n = lt.length; n > i; i++) {
                var a, o, l = lt[i],
                    u = l.element,
                    c = l.smoothScrolling ? t : e,
                    d = l.keyFrames,
                    h = d.length,
                    f = d[0],
                    y = d[d.length - 1],
                    w = c < f.frame,
                    b = c > y.frame,
                    _ = w ? f : y,
                    C = l.emitEvents,
                    x = l.lastFrameIndex;
                if (w || b) {
                    if (w && -1 === l.edge || b && 1 === l.edge) continue;
                    switch (w ? (Dt(u, [m], [v, g]), C && x > -1 && (kt(u, f.eventType, jt), l.lastFrameIndex = -1)) : (Dt(u, [v], [m, g]), C && h > x && (kt(u, y.eventType, jt), l.lastFrameIndex = h)), l.edge = w ? -1 : 1, l.edgeStrategy) {
                        case "reset":
                            ot(u);
                            continue;
                        case "ease":
                            c = _.frame;
                            break;
                        default:
                        case "set":
                            var S = _.props;
                            for (a in S) r.call(S, a) && (o = at(S[a].value), 0 === a.indexOf("@") ? u.setAttribute(a.substr(1), o) : s.setStyle(u, a, o));
                            continue
                    }
                } else 0 !== l.edge && (Dt(u, [p, g], [m, v]), l.edge = 0);
                for (var k = 0; h - 1 > k; k++)
                    if (c >= d[k].frame && c <= d[k + 1].frame) {
                        var T = d[k],
                            M = d[k + 1];
                        for (a in T.props)
                            if (r.call(T.props, a)) {
                                var P = (c - T.frame) / (M.frame - T.frame);
                                P = T.props[a].easing(P), o = nt(T.props[a].value, M.props[a].value, P), o = at(o), 0 === a.indexOf("@") ? u.setAttribute(a.substr(1), o) : s.setStyle(u, a, o)
                            }
                        C && x !== k && ("down" === jt ? kt(u, T.eventType, jt) : kt(u, M.eventType, jt), l.lastFrameIndex = k);
                        break
                    }
            }
        },
        $ = function() {
            Ht && (Ht = !1, Tt());
            var t, e, n = rt.getScrollTop(),
                a = Ft();
            if (pt) a >= pt.endTime ? (n = pt.targetTop, t = pt.done, pt = i) : (e = pt.easing((a - pt.startTime) / pt.duration), n = pt.startTop + e * pt.topDiff | 0), rt.setScrollTop(n, !0);
            else if (!yt) {
                var o = vt.targetTop - n;
                o && (vt = {
                    startTop: Nt,
                    topDiff: n - Nt,
                    targetTop: n,
                    startTime: Vt,
                    endTime: Vt + gt
                }), a <= vt.endTime && (e = Y.sqrt((a - vt.startTime) / gt), n = vt.startTop + e * vt.topDiff | 0)
            }
            if (yt || Nt !== n) {
                jt = n > Nt ? "down" : Nt > n ? "up" : jt, yt = !1;
                var r = {
                        curTop: n,
                        lastTop: Nt,
                        maxTop: It,
                        direction: jt
                    },
                    l = ct.beforerender && ct.beforerender.call(rt, r);
                l !== !1 && (J(n, rt.getScrollTop()), Bt && ut && s.setStyle(ut, "transform", "translate(0, " + -Qt + "px) " + bt), Nt = n, ct.render && ct.render.call(rt, r)), t && t.call(rt, !1)
            }
            Vt = a
        },
        K = function(t) {
            for (var e = 0, i = t.keyFrames.length; i > e; e++) {
                for (var n, a, o, s, r = t.keyFrames[e], l = {}; null !== (s = I.exec(r.props));) o = s[1], a = s[2], n = o.match(q), null !== n ? (o = n[1], n = n[2]) : n = C, a = a.indexOf("!") ? tt(a) : [a.slice(1)], l[o] = {
                    value: a,
                    easing: Y[n]
                };
                r.props = l
            }
        },
        tt = function(t) {
            var e = [];
            return H.lastIndex = 0, t = t.replace(H, function(t) {
                return t.replace(V, function(t) {
                    return t / 255 * 100 + "%"
                })
            }), Q && (R.lastIndex = 0, t = t.replace(R, function(t) {
                return Q + t
            })), t = t.replace(V, function(t) {
                return e.push(+t), "{?}"
            }), e.unshift(t), e
        },
        et = function(t) {
            var e, i, n = {};
            for (e = 0, i = t.keyFrames.length; i > e; e++) it(t.keyFrames[e], n);
            for (n = {}, e = t.keyFrames.length - 1; e >= 0; e--) it(t.keyFrames[e], n)
        },
        it = function(t, e) {
            var i;
            for (i in e) r.call(t.props, i) || (t.props[i] = e[i]);
            for (i in t.props) e[i] = t.props[i]
        },
        nt = function(t, e, i) {
            var n, a = t.length;
            if (a !== e.length) throw "Can't interpolate between \"" + t[0] + '" and "' + e[0] + '"';
            var o = [t[0]];
            for (n = 1; a > n; n++) o[n] = t[n] + (e[n] - t[n]) * i;
            return o
        },
        at = function(t) {
            var e = 1;
            return z.lastIndex = 0, t[0].replace(z, function() {
                return t[e++]
            })
        },
        ot = function(t, e) {
            t = [].concat(t);
            for (var i, n, a = 0, o = t.length; o > a; a++) n = t[a], i = lt[n[L]], i && (e ? (n.style.cssText = i.dirtyStyleAttr, Dt(n, i.dirtyClassAttr)) : (i.dirtyStyleAttr = n.style.cssText, i.dirtyClassAttr = Ot(n), n.style.cssText = i.styleAttr, Dt(n, i.classAttr)))
        },
        st = function() {
            bt = "translateZ(0)", s.setStyle(ut, "transform", bt);
            var t = u(ut),
                e = t.getPropertyValue("transform"),
                i = t.getPropertyValue(Q + "transform"),
                n = e && "none" !== e || i && "none" !== i;
            n || (bt = "")
        };
    s.setStyle = function(t, e, i) {
        var n = t.style;
        if (e = e.replace(j, N).replace("-", ""), "zIndex" === e) isNaN(i) ? n[e] = i : n[e] = "" + (0 | i);
        else if ("float" === e) n.styleFloat = n.cssFloat = i;
        else try {
            B && (n[B + e.slice(0, 1).toUpperCase() + e.slice(1)] = i), n[e] = i
        } catch (a) {}
    };
    var rt, lt, ut, ct, dt, ht, ft, pt, mt, gt, vt, yt, wt, bt, _t, Ct = s.addEvent = function(e, i, n) {
            var a = function(e) {
                return e = e || t.event, e.target || (e.target = e.srcElement), e.preventDefault || (e.preventDefault = function() {
                    e.returnValue = !1, e.defaultPrevented = !0
                }), n.call(this, e)
            };
            i = i.split(" ");
            for (var o, s = 0, r = i.length; r > s; s++) o = i[s], e.addEventListener ? e.addEventListener(o, n, !1) : e.attachEvent("on" + o, a), Wt.push({
                element: e,
                name: o,
                listener: n
            })
        },
        xt = s.removeEvent = function(t, e, i) {
            e = e.split(" ");
            for (var n = 0, a = e.length; a > n; n++) t.removeEventListener ? t.removeEventListener(e[n], i, !1) : t.detachEvent("on" + e[n], i)
        },
        St = function() {
            for (var t, e = 0, i = Wt.length; i > e; e++) t = Wt[e], xt(t.element, t.name, t.listener);
            Wt = []
        },
        kt = function(t, e, i) {
            ct.keyframe && ct.keyframe.call(rt, t, e, i)
        },
        Tt = function() {
            var t = rt.getScrollTop();
            It = 0, dt && !Bt && (o.style.height = ""), Z(), dt && !Bt && (o.style.height = It + a.clientHeight + "px"), Bt ? rt.setScrollTop(l.min(rt.getScrollTop(), It)) : rt.setScrollTop(t, !0), yt = !0
        },
        Mt = function() {
            var t, e, i = a.clientHeight,
                n = {};
            for (t in ht) e = ht[t], "function" == typeof e ? e = e.call(rt) : /p$/.test(e) && (e = e.slice(0, -1) / 100 * i), n[t] = e;
            return n
        },
        Pt = function() {
            var t, e = 0;
            return ut && (e = l.max(ut.offsetHeight, ut.scrollHeight)), t = l.max(e, o.scrollHeight, o.offsetHeight, a.scrollHeight, a.offsetHeight, a.clientHeight), t - a.clientHeight
        },
        Ot = function(e) {
            var i = "className";
            return t.SVGElement && e instanceof t.SVGElement && (e = e[i], i = "baseVal"), e[i]
        },
        Dt = function(e, n, a) {
            var o = "className";
            if (t.SVGElement && e instanceof t.SVGElement && (e = e[o], o = "baseVal"), a === i) return void(e[o] = n);
            for (var s = e[o], r = 0, l = a.length; l > r; r++) s = Et(s).replace(Et(a[r]), " ");
            s = Lt(s);
            for (var u = 0, c = n.length; c > u; u++) - 1 === Et(s).indexOf(Et(n[u])) && (s += " " + n[u]);
            e[o] = Lt(s)
        },
        Lt = function(t) {
            return t.replace(F, "")
        },
        Et = function(t) {
            return " " + t + " "
        },
        Ft = Date.now || function() {
            return +new Date
        },
        At = function(t, e) {
            return t.frame - e.frame
        },
        It = 0,
        qt = 1,
        jt = "down",
        Nt = -1,
        Vt = Ft(),
        $t = 0,
        zt = 0,
        Ht = !1,
        Rt = 0,
        Bt = !1,
        Qt = 0,
        Wt = [];
    "function" == typeof define && define.amd ? define([], function() {
        return s
    }) : "undefined" != typeof module && module.exports ? module.exports = s : t.skrollr = s
}(window, document),
function($) {
    "use strict";

    function t() {
        var t = !1;
        return function(e) {
            (/(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(e) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(e.substr(0, 4))) && (t = !0)
        }(navigator.userAgent || navigator.vendor || window.opera), t
    }

    function e(t, e) {
        for (var i = [].slice.call(arguments).splice(2), n = t.split("."), a = n.pop(), o = 0; o < n.length; o++) e = e[n[o]];
        return e[a].apply(this, i)
    }
    $.fn.imagesLoaded = function() {
        var t = this.find('img[src!=""]');
        if (!t.length) return $.Deferred().resolve().promise();
        var e = [];
        return t.each(function() {
            var t = $.Deferred();
            e.push(t);
            var i = new Image;
            i.onload = function() {
                t.resolve()
            }, i.onerror = function() {
                t.resolve()
            }, i.src = this.src
        }), $.when.apply($, e)
    }, $.fn.qtInitTripleView = function() {
        if (0 !== $("#qtvscontainer").length && 0 !== $("#qtvscontainer section").length) {
            var e = document.getElementById("qtvscontainer"),
                i = $("#qtvscontainer"),
                n = e.querySelector("div.qt-vs-wrapper"),
                a = Array.prototype.slice.call(n.querySelectorAll("section")),
                o = Array.prototype.slice.call(e.querySelectorAll("header.qt-vs-header ul.qt-vs-nav > li")),
                s = a.length,
                r = {
                    WebkitTransition: "webkitTransitionEnd",
                    MozTransition: "transitionend",
                    OTransition: "oTransitionEnd",
                    msTransition: "MSTransitionEnd",
                    transition: "transitionend"
                },
                l = r[Modernizr.prefixed("transition")],
                u = t() ? "touchstart" : "click";
            if (s >= 3 && Modernizr.csstransforms3d) {
                var c = 0,
                    d = !1;
                i.addClass("qt-vs-triplelayout");
                var h = function() {
                        i.on("click", "#qtvtL", function() {
                            p("left")
                        }).on("click", "#qtvtR", function() {
                            p("right")
                        })
                    },
                    f = function() {
                        a.forEach(function(t, e) {
                            t.className = ""
                        }), o.forEach(function(t, e) {
                            t.className = ""
                        })
                    },
                    p = function(t) {
                        if (d) return !1;
                        d = !0;
                        var i = "right" === t ? "left" : "right";
                        classie.add(e, "qt-vs-move-" + i);
                        var n = 0 === c ? s - 1 : c - 1,
                            r = s - 1 > c ? c + 1 : 0,
                            u;
                        "right" === t ? u = s - 1 > r ? r + 1 : 0 : "left" === t && (u = n > 0 ? n - 1 : s - 1);
                        var h = a[u],
                            p = o[u];
                        h.className = "", p.className = "", classie.add(h, "qt-vs-" + t + "-outer"), classie.add(p, "qt-vs-nav-" + t + "-outer");
                        var m = function() {
                            h.removeEventListener(l, m), f(), "right" === t ? (classie.add(a[c], "qt-vs-left"), classie.add(a[r], "qt-vs-current"), classie.add(h, "qt-vs-right"), classie.add(o[c], "qt-vs-nav-left"), classie.add(o[r], "qt-vs-nav-current"), classie.add(p, "qt-vs-nav-right"), c = s - 1 > c ? c + 1 : 0) : "left" === t && (classie.add(h, "qt-vs-left"), classie.add(a[n], "qt-vs-current"), classie.add(a[c], "qt-vs-right"), classie.add(p, "qt-vs-nav-left"), classie.add(o[n], "qt-vs-nav-current"), classie.add(o[c], "qt-vs-nav-right"), c = c > 0 ? c - 1 : s - 1), classie.remove(e, "qt-vs-move-" + i), d = !1
                        };
                        h.addEventListener(l, m)
                    };
                classie.add(a[c], "qt-vs-current"), classie.add(a[c + 1], "qt-vs-right"), classie.add(a[s - 1], "qt-vs-left"), classie.add(o[c], "qt-vs-nav-current"), classie.add(o[c + 1], "qt-vs-nav-right"), classie.add(o[s - 1], "qt-vs-nav-left"), h(), o.forEach(function(t, e) {
                    t.addEventListener(u, function(e) {
                        if (e.preventDefault(), classie.has(t, "qt-vs-nav-right")) p("right");
                        else {
                            if (!classie.has(t, "qt-vs-nav-left")) return !1;
                            p("left")
                        }
                    })
                }), document.addEventListener("keydown", function(t) {
                    var e = t.keyCode || t.which,
                        i = {
                            left: 37,
                            right: 39
                        };
                    switch (e) {
                        case i.left:
                            p("left");
                            break;
                        case i.right:
                            p("right")
                    }
                }), t() && (Hammer(e).on("swipeleft", function(t) {
                    p("right")
                }), Hammer(e).on("swiperight", function(t) {
                    p("left")
                })), $(".qt-vs-container").addClass("active")
            }
            console.log("Tripleview init")
        }
    }, $.fn.parallaxV3 = function(t) {
        var e = $(window).height(),
            i = $.extend({
                speed: .15,
                blursize: 0
            }, t);
        return this.each(function() {
            var t = $(this),
                e = $(window).scrollTop(),
                n = t.offset().top,
                a = t.outerHeight(),
                o = Math.round((n - e) * i.speed);
            t.initialBlur = t.attr("data-blurStart"), t.css({
                "background-position": "center " + o + "px",
                "-webkit-filter": "blur(" + t.initialBlur + "px)",
                "-moz-filter": "blur(" + t.initialBlur + "px)",
                "-o-filter": "blur(" + t.initialBlur + "px)",
                "-ms-filter": "blur(" + t.initialBlur + "px)",
                filter: "blur(" + t.initialBlur + "px)"
            }), t.blursize = t.attr("data-blur"), t.scrolling = t.attr("data-scrolling");
            var s;
            $("body").hasClass("mobile") || $(document).scroll(function() {
                e = $(window).scrollTop(), n = t.offset().top, a = t.outerHeight(), s = t.blursize * (e / 150), o = Math.round((n - e) * i.speed), "no" !== t.scrolling && t.css("background-position", "center " + o + "px"), t.blursize > 0 && (s > 6 && (s = 6), t.initialBlur > s && (s = t.initialBlur), t.css({
                    "-webkit-filter": "blur(" + s + "px)",
                    "-moz-filter": "blur(" + s + "px)",
                    "-o-filter": "blur(" + s + "px)",
                    "-ms-filter": "blur(" + s + "px)",
                    filter: "blur(" + s + "px)"
                }))
            })
        })
    }, $.fn.parallaxBackground = function(t) {
        return void 0 === t && (t = "body"), $(t + ' [data-type="background"]').each(function() {
            var t = jQuery(this),
                e = t.attr("data-bgimageurl");
            "" !== e && "undefined" != typeof e && (t.css({
                background: "url(" + e + ")",
                "background-size": "cover",
                "background-position": "center center",
                "background-repeat": "no-repeat",
                "background-attachment": "local",
                "-webkit-transform": "translate3d(0, 0, 0)",
                "-webkit-backface-visibility": "hidden",
                "-webkit-perspective": "1000"
            }), t.parallaxV3({
                speed: -.3
            }))
        }), !0
    }, $.fn.parallaxPolydecor = function() {
        function t(t) {
            n = window.pageYOffset, $(".qt-polydecor, .qt-polydecor-page > .kc_row, .qt-polydecor-page > .vc_row").each(function() {
                var t = $(this),
                    e = t.offset().top,
                    i = Math.round(e - n);
                t.find(".decor1").css({
                    top: .98 * i + "px"
                }), t.find(".decor2").css({
                    top: .6 * i + "px"
                })
            })
        }
        if (!($("body").hasClass("mobile") || $(".qt-polydecor").length < 1 && $(".qt-polydecor-page").length < 1)) {
            var e, i, n;
            return $(".qt-polydecor, .qt-polydecor-page > .kc_row, .qt-polydecor-page > .vc_row").not(".nopoly").each(function() {
                var t = $(this);
                t.wrapInner("<div class='qt-polydecor-content'></div>"), t.append('<div class="decor1"></div><div class="decor2"></div>'), e = t.find(".decor1"), i = t.find(".decor2");
                var n = $(this),
                    a = $(window).scrollTop(),
                    o = n.offset().top,
                    s = n.outerHeight(),
                    r = 100,
                    l = 130,
                    a, o = n.offset().top,
                    s = n.outerHeight()
            }), t(), window.addEventListener("scroll", t, !1), !0
        }
    }, $.fn.bodyScroll = function() {
        function t(t) {
            window.pageYOffset > 0 ? i.addClass("qt-scrolled") : i.removeClass("qt-scrolled")
        }
        var e, i = $("#qtBody");
        window.addEventListener("scroll", t, !1)
    }, $.fn.qtMasonry = function(t) {
        return console.log("Executing: $.fn.qtMasonry"), void 0 === t && (t = "#qtBody", console.log(typeof t)), console.log("targetContainer: " + t), $(t).find(".masonrycontainer").each(function(t, e) {
            var i = $(e).attr("id"),
                n = document.querySelector("#" + i);
            if (n) var a = new Masonry(n, {
                itemSelector: ".ms-item",
                columnWidth: ".ms-item"
            })
        }), !0
    }, $.fn.qtSquaredItems = function() {
        return $(".qtSquaredItem").each(function(t, e) {
            var i = $(e),
                n = Math.round(i.width());
            i.height(n)
        }), !0
    }, $.fn.NewYoutubeResize = function() {
        jQuery("iframe").each(function(t, e) {
            var i = jQuery(this);
            if (i.attr("src")) {
                var n = i.attr("src");
                if (n.match("youtube.com") || n.match("vimeo.com") || n.match("vevo.com")) {
                    var a = i.parent().width(),
                        o = i.height();
                    console.log("resizing video " + n), i.css({
                        width: a
                    }), i.height(a / 16 * 9)
                }
            }
        })
    }, $.fn.qtLoadMore = function() {
        return $("body").on("click", "[data-loadmore]", function(t) {
            t.preventDefault();
            var i = $(this),
                n = i.attr("href"),
                a = i.attr("data-callback"),
                o = i.attr("data-buttonid"),
                s = i.attr("data-container"),
                r = i.find("span"),
                l = i.find("i");
            r.toggleClass("hidden"), l.toggleClass("hidden"), $.ajax({
                url: n,
                dataType: "html",
                type: "GET",
                success: function(t) {
                    var i = $(s, t),
                        n = $("#" + o, t);
                    $("#" + o).remove(), $(s).append(i.html()), $(s).after(n), r.toggleClass("hidden"), l.toggleClass("hidden"), $("#qtBody").imagesLoaded().then(function() {
                        a && e(a, $, arguments), !0 === $.skrollrInstance && $.skrollrInstance.refresh(), $.fn.NewYoutubeResize(), $.fn.gridstackSlideshows(), $.fn.transformlinks(), $.fn.dynamicBackgrounds()
                    })
                },
                error: function() {
                    window.location.replace(n)
                }
            })
        }), !0
    }, $.fn.qtGradientOverlay = function() {
        return $(".qt-gradientOverlay").append('<div class="qt-gradient-overlay qt-fade-to-paper"></div>'), $(".qt-gradient-overlay").height($(this).parent().height()), !0
    }, $.fn.qtMobileNav = function() {
        return $("#nav-mobile").on("click", "li.menu-item-has-children > a", function(t) {
            var e = $(this).parent();
            return t.preventDefault(), e.hasClass("open") ? e.removeClass("open") : e.addClass("open"), !0
        }), !0
    }, $.fn.qtQtSwitch = function() {
        $("body").on("click", "[data-qtswitch]", function(t) {
            var e = $(this);
            t.preventDefault(), $(e.attr("data-target")).toggleClass(e.attr("data-qtswitch"))
        }), $("body").on("click", "[data-expandable]", function(t) {
            t.preventDefault();
            var e = $(this),
                i = $(e.attr("data-expandable"));
            console.log("-> EXPANDING " + i.attr("data-expandable")), i.hasClass("open") ? (i.removeClass("open").height(), i.velocity({
                properties: {
                    height: 0
                },
                options: {
                    duration: 500
                }
            })) : (i.addClass("open").height(), i.velocity({
                properties: {
                    height: i.find(".qt-expandable-inner").height() + "px"
                },
                options: {
                    duration: 500
                }
            }))
        })
    }, $.fn.qtQTabs = function() {
        $("body").off("click", ".qt-tabs-controller a.qt-tabswitch"), $("body").on("click", ".qt-tabs-controller a.qt-tabswitch", function(t) {
            t.preventDefault();
            var e = $(this),
                i = e.attr("href").split("#").join(""),
                n = e.attr("data-target"),
                a = $("#" + i),
                o = $(n + " .qt-tab"),
                s = $("#" + i + " .tabcontent").outerHeight();
            o.each(function(t, e) {
                console.log("-");
                var n = $(e),
                    o = n.attr("id");
                i === o ? n.hasClass("active") ? n.velocity({
                    properties: {
                        height: 0
                    },
                    options: {
                        duration: 500,
                        complete: function() {
                            n.removeClass("active")
                        }
                    }
                }) : (a.velocity({
                    properties: {
                        height: s
                    },
                    options: {
                        duration: 500,
                        complete: function() {
                            a.addClass("active").css({
                                height: "auto"
                            })
                        }
                    }
                }), $("html,body").animate({
                    scrollTop: 0
                }, 800, "easeOutBounce")) : n.hasClass("active") && n.velocity({
                    properties: {
                        height: 0
                    },
                    options: {
                        duration: 500,
                        complete: function() {
                            n.removeClass("active")
                        }
                    }
                })
            })
        })
    }, $.fn.qtSmoothScroll = function() {
        var t = $("body");
        t.off("click", "a.qwsmoothscroll"), t.on("click", "a.qwsmoothscroll", function(t) {
            t.preventDefault(), $("html,body").animate({
                scrollTop: $(this.hash).offset().top
            }, 800)
        })
    }, $.fn.transformlinks = function(t) {
        void 0 === t && (t = "body"), jQuery(t).find("a[href*='youtube.com'],a[href*='youtu.be'],a[href*='mixcloud.com'],a[href*='soundcloud.com'], [data-autoembed]").not(".qw-disableembedding").not(".vc_general").each(function(t) {
            function e(e) {
                t.replaceWith(e)
            }
            var i = jQuery(this),
                n = i.attr("href");
            i.attr("data-autoembed") && (n = i.attr("data-autoembed"));
            var a = i.parent().width();
            0 === a && (a = i.parent().parent().parent().width()), 0 === a && (a = i.parent().parent().parent().width()), 0 === a && (a = i.parent().parent().parent().parent().width());
            var o = i.height(),
                t = i,
                s = /(http|https):\/\/(\w{0,3}\.)?youtube\.\w{2,3}\/watch\?v=[\w-]{11}/gi,
                r = n.match(s);
            if (null !== r)
                for (var l = 0; l < r.length; l++) n = n.replace(r[l], embedVideo(r[l], a, a / 16 * 9)), e(n);
            var s = /(http|https)(\:\/\/soundcloud.com\/+([a-zA-Z0-9\/\-_]*))/g,
                u = n.match(s);
            if (null !== u)
                for (l = 0; l < u.length; l++) {
                    var c = u[l].replace(":", "%3A");
                    c = c.replace("https", "http"), jQuery.getJSON("https://soundcloud.com/oembed?maxheight=140&format=js&url=" + c + "&iframe=true&callback=?", function(t) {
                        e(t.html)
                    })
                }
            var s = /(http|https)\:\/\/www\.mixcloud\.com\/[\w-]{0,150}\/[\w-]{0,150}\/[\w-]{0,1}/gi;
            if (r = n.match(s), null !== r)
                for (console.log("Embed mixcloud now"), l = 0; l < r.length; l++) n = n.replace(r[l], embedMixcloudPlayer(r[l])), e(n)
        }), $.fn.NewYoutubeResize()
    }, $.fn.dynamicBackgrounds = function(t) {
        void 0 === t && (t = "body"), $(t + " [data-bgimage]").each(function(t, e) {
            var i = $(this),
                n = i.attr("data-bgimage"),
                a = i.attr("data-bgattachment");
            void 0 == a && (a = "static"), "" !== n && i.css({
                "background-image": "url(" + n + ")",
                "background-attachment": a,
                "background-size": "cover",
                "background-position": "center center"
            })
        }), $(t + " [data-bgcolor]").each(function(t, e) {
            var i = $(this),
                n = i.attr("data-bgcolor");
            if ("" !== n) {
                if (i.attr("data-bgopacity")) var a = i.attr("data-bgopacity"),
                    n = "rgba(" + hexToRgb2(n) + "," + a / 100 + ")";
                i.find(".fp-tableCell, .qw-fixedcontents-layer2, .qw-gbcolorlayer").css({
                    "background-color": n
                })
            }
        })
    }, $.fn.qwScrollfireElements = function() {
        var t = [{
            selector: ".staggeredlist",
            offset: 200,
            callback: 'Materialize.fadeInImage(".staggeredlist")")'
        }];
        Materialize.scrollFire(t)
    };
    var i = [{
            featureType: "landscape",
            elementType: "labels",
            stylers: [{
                visibility: "off"
            }]
        }, {
            featureType: "transit",
            elementType: "labels",
            stylers: [{
                visibility: "off"
            }]
        }, {
            featureType: "poi",
            elementType: "labels",
            stylers: [{
                visibility: "off"
            }]
        }, {
            featureType: "water",
            elementType: "labels",
            stylers: [{
                visibility: "off"
            }]
        }, {
            featureType: "road",
            elementType: "labels.icon",
            stylers: [{
                visibility: "off"
            }]
        }, {
            stylers: [{
                hue: "#00aaff"
            }, {
                saturation: -100
            }, {
                gamma: 2.15
            }, {
                lightness: 12
            }]
        }, {
            featureType: "road",
            elementType: "labels.text.fill",
            stylers: [{
                visibility: "on"
            }, {
                lightness: 24
            }]
        }, {
            featureType: "road",
            elementType: "geometry",
            stylers: [{
                lightness: 57
            }]
        }],
        n = [{
            featureType: "water",
            elementType: "geometry",
            stylers: [{
                color: "#000000"
            }, {
                lightness: 17
            }]
        }, {
            featureType: "landscape",
            elementType: "geometry",
            stylers: [{
                color: "#000000"
            }, {
                lightness: 20
            }]
        }, {
            featureType: "road.highway",
            elementType: "geometry.fill",
            stylers: [{
                color: "#000000"
            }, {
                lightness: 17
            }]
        }, {
            featureType: "road.highway",
            elementType: "geometry.stroke",
            stylers: [{
                color: "#000000"
            }, {
                lightness: 29
            }, {
                weight: .2
            }]
        }, {
            featureType: "road.arterial",
            elementType: "geometry",
            stylers: [{
                color: "#000000"
            }, {
                lightness: 18
            }]
        }, {
            featureType: "road.local",
            elementType: "geometry",
            stylers: [{
                color: "#000000"
            }, {
                lightness: 16
            }]
        }, {
            featureType: "poi",
            elementType: "geometry",
            stylers: [{
                color: "#000000"
            }, {
                lightness: 21
            }]
        }, {
            elementType: "labels.text.stroke",
            stylers: [{
                visibility: "on"
            }, {
                color: "#000000"
            }, {
                lightness: 16
            }]
        }, {
            elementType: "labels.text.fill",
            stylers: [{
                saturation: 36
            }, {
                color: "#000000"
            }, {
                lightness: 40
            }]
        }, {
            elementType: "labels.icon",
            stylers: [{
                visibility: "off"
            }]
        }, {
            featureType: "transit",
            elementType: "geometry",
            stylers: [{
                color: "#000000"
            }, {
                lightness: 19
            }]
        }, {
            featureType: "administrative",
            elementType: "geometry.fill",
            stylers: [{
                color: "#000000"
            }, {
                lightness: 20
            }]
        }, {
            featureType: "administrative",
            elementType: "geometry.stroke",
            stylers: [{
                color: "#000000"
            }, {
                lightness: 17
            }, {
                weight: 1.2
            }]
        }];
    $.fn.dynamicMapsNew = function(t) {
        void 0 === t && (t = "body");
        var e, i;
        $(t + " .qt_dynamicmaps").each(function(t, e) {
            var i = $(e),
                a = i.attr("data-coord").split(","),
                o = a[0],
                s = a[1],
                r = i.attr("id"),
                l = i.attr("data-colors"),
                u = i.attr("data-locationname"),
                c = new google.maps.Map(document.getElementById(r), {
                    zoom: 16,
                    styles: n,
                    center: new google.maps.LatLng(o, s),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }),
                d = new google.maps.InfoWindow,
                h, t;
            h = new google.maps.Marker({
                position: new google.maps.LatLng(o, s),
                map: c
            }), google.maps.event.addListener(h, "click", function(t, e) {
                return function() {
                    d.setContent(u), d.open(c, t)
                }
            }(h, t))
        })
    }, $.fn.qtGridSwitcher = function() {
        $(".cbp-vm-switcher").on("click", "a.cbp-vm-grid", function(t) {
            t.preventDefault(), $(".cbp-vm-switcher").removeClass("cbp-vm-view-list").addClass("cbp-vm-view-grid"), $("a.cbp-vm-grid").addClass("active"), $("a.cbp-vm-list").removeClass("active"), $(this).addClass("active")
        }), $(".cbp-vm-switcher").on("click", "a.cbp-vm-list", function(t) {
            t.preventDefault(), $(".cbp-vm-switcher").removeClass("cbp-vm-view-grid").addClass("cbp-vm-view-list"), $("a.cbp-vm-list").addClass("active"), $("a.cbp-vm-grid").removeClass("active")
        }), $("#qwShowDropdown").change(function() {
            $("a#" + $(this).attr("value")).click()
        })
    }, $.fn.atTabsAnimator = function() {
        $("body").on("click", ".tabs a", function(t) {
            $(".tabcontent").addClass("inactive"), $($(this).attr("href")).removeClass("inactive")
        })
    }, $.fn.qtCollapsible = function() {
        $(".collapsible").collapsible()
    }, $.fn.gridstackSlideshows = function() {
        $(".slider").each(function(t, e) {
            var i = $(e);
            $(e).imagesLoaded().then(function() {
                var t = i.width(),
                    e = t / 16 * 7,
                    n = "1" === i.attr("data-indicators") || "true" === i.attr("data-indicators"),
                    a = i.attr("data-transition"),
                    o = i.attr("data-interval"),
                    s = "1" === i.attr("data-full_width") || "true" === i.attr("data-full_width"),
                    r = i.attr("data-proportion");
                $(window).width() < 500 && (n = !1), void 0 != o && "" !== o || (o = 3e3), void 0 != a && "" !== a || (a = 500);
                var l = {
                    transition: parseInt(a),
                    interval: parseInt(o),
                    full_width: s,
                    indicators: n
                };
                "fullscreen" === r ? (e = $(window).height(), console.log("Height of the slideshow: " + e), $(window).width() > 760 ? l.height = e - 46 : l.height = e, i.find("slide").height(l.height)) : "widescreen" === r ? ($(window).width() > 760 ? l.height = e - 46 : l.height = e, i.find("slide").height(l.height)) : (l.height = parseInt(i.find("img").attr("height")), console.log(l.height), $(window).width() > 760 && (l.height = l.height - 46), i.height(l.height).find("slide").height(l.height).find("slides").height(l.height)), i.slider(l).promise().done(function() {
                    i.hasClass("qt-gridstackSlideshow") && i.height(l.height).velocity({
                        opacity: 1
                    }, 800)
                }), i.find(".prev").click(function() {
                    i.slider("prev")
                }), i.find(".next").click(function() {
                    i.slider("next")
                }), i.find("a.qt-slideshow-link").mouseenter(function() {
                    i.slider("pause")
                }).mouseleave(function() {
                    i.slider("start")
                })
            })
        })
    }, $.fn.gridstackCarousel = function() {
        $(".qt-gridstackCarousel").each(function(t, e) {
            var i = $(e),
                n = i.width(),
                a = n / 16 * 7,
                o = i.attr("data-time_constant"),
                s = i.attr("data-dist"),
                r = i.attr("data-shift"),
                l = i.attr("data-vpadding"),
                u = "1" === i.attr("data-full_width") || "true" === i.attr("data-full_width"),
                c = i.attr("data-padding");
            void 0 != o && "" !== o || (o = 200), void 0 != s && "" !== s || (s = -30), void 0 != r && "" !== r || (r = 0), void 0 != c && "" !== c || (c = 0), void 0 != l && "" !== l || (l = 0), 0 !== l && i.css({
                "margin-top": l,
                "margin-bottom": l
            });
            var d = {
                time_constant: parseInt(o),
                dist: parseInt(s),
                padding: parseInt(c),
                shift: parseInt(r)
            };
            i.carousel(d), i.parent().find(".prev").click(function() {
                i.carousel("prev")
            }), i.parent().find(".next").click(function() {
                i.carousel("next")
            }), i.find(".carousel-item").on("mouseenter touchstart", function(t) {
                var e = $(this);
                e.addClass("active"), $("body").hasClass("mobile") && (setTimeout(function() {
                    e.removeClass("active")
                }, 3e3), i.find(".carousel-item").on("touchstart", function(t) {
                    window.location.href = $(this).attr("href")
                }))
            }).on("mouseleave", function() {
                $(this).removeClass("active")
            })
        })
    }, $.fn.gridstackOwl = function(t) {
        void 0 === t && (t = "body"), $(t + " .owl-carousel").length <= 0 || $(t + " .owl-carousel").each(function(t, e) {
            var i = $(this),
                n = {
                    items: parseInt(i.attr("data-items")),
                    navigation: "true" === i.attr("data-nav") || "1" === i.attr("data-nav"),
                    nav: "true" === i.attr("data-nav") || "1" === i.attr("data-nav"),
                    margin: parseInt(i.attr("data-margin")),
                    dots: "true" === i.attr("data-dots"),
                    navRewind: "true" === i.attr("data-navRewind"),
                    autoplayHoverPause: !0,
                    animateIn: !0,
                    animateOut: !0,
                    loop: !0,
                    center: "true" === i.attr("data-center") || "1" === i.attr("data-center"),
                    mouseDrag: "true" === i.attr("data-mouseDrag") || "1" === i.attr("data-mouseDrag"),
                    touchDrag: "true" === i.attr("data-touchDrag") || "1" === i.attr("data-touchDrag"),
                    pullDrag: "true" === i.attr("data-pullDrag") || "1" === i.attr("data-pullDrag"),
                    freeDrag: "true" === i.attr("data-freeDrag") || "1" === i.attr("data-freeDrag"),
                    stagePadding: parseInt(i.attr("data-stagePadding")),
                    mergeFit: "true" === i.attr("data-mergeFit") || "1" === i.attr("data-mergeFit"),
                    autoWidth: "true" === i.attr("data-autoWidth") || "1" === i.attr("data-autoWidth"),
                    autoplay: "true" === i.attr("data-autoplay") || "1" === i.attr("data-autoplay"),
                    autoplayTimeout: parseInt(i.attr("data-autoplaytimeout")),
                    URLhashListener: "true" === i.attr("data-URLhashListener") || "1" === i.attr("data-URLhashListener"),
                    video: "true" === i.attr("data-video"),
                    videoHeight: "true" === i.attr("data-videoHeight") || "1" === i.attr("data-videoHeight"),
                    videoWidth: "true" === i.attr("data-videoWidth") || "1" === i.attr("data-videoWidth"),
                    responsive: {
                        0: {
                            items: 1,
                            dots: !1,
                            loop: !1
                        },
                        768: {
                            items: 3
                        },
                        1e3: {
                            items: parseInt(i.attr("data-items"))
                        }
                    }
                };
            switch (i.attr("data-arrowstyle")) {
                case "minimal":
                    n.navText = ['<span><i class="fa fa-chevron-left"></i></span>', '<span><i class="fa fa-chevron-right"></i></span>'];
                    break;
                default:
                    n.navText = ['<span class="qt-btn-rhombus btn"><i class="fa fa-chevron-left"></i></span>', '<span class="qt-btn-rhombus btn"><i class="fa fa-chevron-right"></i></span>']
            }
            i.owlCarousel(n)
        })
    }, $.fn.gridstackSkywheel = function() {
        $(".qt-gridstackSkywheel").each(function(t, e) {
            var i = $(this),
                n = i.find("ul"),
                a = i.attr("data-width"),
                o = i.attr("data-height");
            i.find("ul").css({
                "min-height": o
            }), n.skywheel({
                effect: 1,
                width: a,
                height: o,
                keyOption: "updown"
            })
        })
    }, $.fn.qtparticlesJs = function() {
        $("body").hasClass("mobile") || $(".qt-particles").each(function(t, e) {
            var i = $(this),
                n = i.attr("id");
            particlesJS(n, {
                particles: {
                    number: {
                        value: 12,
                        density: {
                            enable: !0,
                            value_area: 1e3
                        }
                    },
                    color: {
                        value: i.attr("data-color") ? i.attr("data-color") : "#FFFFFF"
                    },
                    shape: {
                        type: "polygon",
                        stroke: {
                            width: 0,
                            color: "#000000"
                        },
                        polygon: {
                            nb_sides: i.attr("data-sides") ? i.attr("data-sides") : "3"
                        }
                    },
                    opacity: {
                        value: i.attr("data-opacity") ? i.attr("data-opacity") : "0.5",
                        random: !0,
                        anim: {
                            enable: !0,
                            speed: .2,
                            opacity_min: 0,
                            sync: !1
                        }
                    },
                    size: {
                        value: 8,
                        random: !0,
                        anim: {
                            enable: !1,
                            speed: 50,
                            size_min: .1,
                            sync: !1
                        }
                    },
                    line_linked: {
                        enable: "1" === i.attr("data-lines"),
                        distance: 150,
                        color: i.attr("data-color") ? i.attr("data-color") : "#FFFFFF",
                        opacity: i.attr("data-opacity") ? i.attr("data-opacity") : "0.5",
                        width: 1
                    },
                    move: {
                        enable: !0,
                        speed: i.attr("data-speed") ? i.attr("data-speed") : 1,
                        direction: "none",
                        random: !0,
                        straight: !1,
                        out_mode: "out",
                        bounce: !1,
                        attract: {
                            enable: !1,
                            rotateX: 600,
                            rotateY: 1200
                        }
                    }
                },
                interactivity: {
                    detect_on: "canvas",
                    events: {
                        onhover: {
                            enable: !1,
                            mode: "grab"
                        },
                        onclick: {
                            enable: !1,
                            mode: "push"
                        },
                        resize: !1
                    }
                },
                retina_detect: !0
            })
        })
    }, $.fn.qtFlipClockJs = function(t) {
        void 0 === t && (t = "body"), $(t + " .qtFlipClock").each(function(t, e) {
            var i = $(e),
                n = i.attr("data-deadline"),
                a = new Date,
                o = new Date(n),
                s = o.getTime() / 1e3 - a.getTime() / 1e3,
                r;
            r = i.FlipClock(s, {
                clockFace: "DailyCounter",
                countdown: !0
            })
        })
    }, $.fn.qtEqTit = function(t) {
        void 0 === t && (t = "body"), $(".qt-titdeco-eq").prepend('<i class="qteq"></i>')
    }, $.fn.qtMusicPlayer = function() {
        console.log("\n player ============================================== \n"), $("body").on("click", "#qtRadioBtn", function(t) {
            t.preventDefault();
            var e = $("#qwMusicPlayerContainer");
            e.toggleClass("open")
        }), $.mainVolumeLevel = 100, void 0 !== $.cookie("mainVolumeLevel") && null !== $.cookie("mainVolumeLevel") && (console.log("\n ================= \n Setting volume from Cookie level \n "), $.mainVolumeLevel = $.cookie("mainVolumeLevel")), console.log("Actual volume level" + $.mainVolumeLevel + " / cookie: " + $.cookie("mainVolumeLevel")), $.fn.initVolume = function() {
            $("#qtVolumeControl").each(function(t, e) {
                function i(t) {
                    h = t.pageX - c, h = Math.min(Math.max(0, h), l), r.css({
                        left: h
                    }), f = Math.round(h / l * 100)
                }

                function n() {
                    s.off("mousemove", i), s.off("mouseup", n), console.log("Volume changed to: " + f), void 0 !== soundManager && (a.html(f), soundManager.setVolume(f), $.cookie("mainVolumeLevel", f, {
                        expires: 1
                    }), $.mainVolumeLevel = f)
                }
                var a = $("#qwVolNum"),
                    o = $(this),
                    s = $(document),
                    r = $("#theVolCursor"),
                    l = $("#qtVolumeControl").width() - r.outerWidth(),
                    u, c, l, d, h, f;
                if (r.on("mousedown", function(t) {
                        t.preventDefault(), c = o.offset().left, u = r.offset().left - c, s.on("mousemove", i), s.on("mouseup", n)
                    }), void 0 !== $.cookie("mainVolumeLevel") && null !== $.cookie("mainVolumeLevel")) {
                    var p = $.cookie("mainVolumeLevel"),
                        m = l / 100 * p;
                    r.offset({
                        top: 0,
                        left: m
                    }), a.html(Math.round(p))
                }
            })
        }, $.fn.initializeAudioStream = function(t, e) {
            if (void 0 !== e) {
                var i = $("#qwMusicPlayerContainer"),
                    n = "a[data-mp3url]";
                $.mySound = soundManager.createSound({
                    id: "currentSound",
                    url: e
                }), console.log("Setting volume to: " + $.mainVolumeLevel), console.log("We have autoplay? " + t), "1" === t && ($("#channelsList a:first-child").click(), soundManager.setVolume($.mainVolumeLevel))
            }
        }, $.fn.qtPlayerStateChange = function(t) {
            1 === t ? $("#qtRadioBtn").addClass("state-play accentcolor") : $("#qtRadioBtn").removeClass("state-play accentcolor")
        };
        var t, e, i = "mdi-av-play-arrow",
            n = "mdi-av-pause",
            a = "mdi-device-access-time";
        if ($("body").on("click", "a[data-mp3url]", function(t) {
                t.preventDefault();
                var o = $(this),
                    s = o.attr("data-mp3url");
                if (void 0 === $.mySound) $("a[data-mp3url]").attr("data-state", "0").find("i").removeClass("mdi-av-pause").addClass("mdi-av-play-arrow"), $.mySound = soundManager.createSound({
                    id: "currentSound",
                    url: s,
                    autoPlay: !0,
                    onplay: function() {
                        $("a[data-mp3url]").attr("data-state", "0").find("i").removeClass(n).addClass(i), o.attr("data-state", "1").find("i").removeClass(i).addClass(n)
                    }
                });
                else if (s !== $.mySound.url) {
                    if (void 0 === s) return void console.log("Track url undefined");
                    if (console.log("Preparing to play: " + s), e = s.split(".").pop(), console.log("Track Extension: " + e), $("a[data-mp3url]").attr("data-state", "0").find("i").removeClass(n).addClass(i), o.find("i").removeClass(i).addClass(a), null !== soundManager && "object" == typeof soundManager) {
                        var r = soundManager.getSoundById("currentSound");
                        void 0 !== r.url && soundManager.destroySound("currentSound")
                    }
                    $.fn.destroyAll360Sounds(), $.mySound = soundManager.createSound({
                        id: "currentSound",
                        url: s,
                        autoPlay: !0,
                        onplay: function() {
                            o.find("i").removeClass(i).removeClass(a).addClass(n), o.attr("data-state", "1"), console.log("play"), $.fn.qtPlayerStateChange(1)
                        },
                        onstop: function() {
                            console.log("onstop"), $.fn.qtPlayerStateChange(0)
                        },
                        onpause: function() {
                            console.log("onpause"), $.fn.qtPlayerStateChange(0)
                        }
                    })
                } else if (1 == o.attr("data-state")) $.mySound.pause("currentSound"),
                    o.attr("data-state", "0"), o.find("i").removeClass(n).addClass(i);
                else {
                    if (o.find("i").removeClass(i).addClass(a), null !== soundManager && "object" == typeof soundManager) {
                        var r = soundManager.getSoundById("currentSound");
                        void 0 !== r && void 0 !== r.url && soundManager.destroySound("currentSound")
                    }
                    $.fn.destroyAll360Sounds(), $.mySound = soundManager.createSound({
                        id: "currentSound",
                        url: s,
                        autoPlay: !0,
                        onplay: function() {
                            o.find("i").removeClass(i).removeClass(a).addClass(n), o.attr("data-state", "1"), console.log("play"), $.fn.qtPlayerStateChange(1)
                        },
                        onstop: function() {
                            console.log("onstop"), $.fn.qtPlayerStateChange(0)
                        },
                        onpause: function() {
                            console.log("onpause"), $.fn.qtPlayerStateChange(0)
                        }
                    })
                }
            }), $.fn.initVolume(), $("#qwMusicPlayerContainer").length > 0) {
            console.log("Initializing radio list");
            var o = $("#qwMusicPlayerContainer"),
                s = o.attr("data-soundmanagerswf"),
                r = o.attr("data-autoplay"),
                l = $("#channelsList a:first-child").attr("data-mp3url");
            console.log("AUTOPLAY: " + r), console.log("mp3Url: " + l), "object" == typeof soundManager && soundManager.setup({
                url: s,
                flashVersion: 9,
                onready: function() {
                    $.fn.initializeAudioStream(r, l)
                }
            })
        }
    }, $.fn.destroyAll360Sounds = function() {
        void 0 !== threeSixtyPlayer && threeSixtyPlayer.sounds.forEach(function(t, e, i) {
            soundManager.stop(t.id), soundManager.destroySound(t.id)
        })
    }, $.fn.preloaderVisibility = function(t) {
        1 === t ? $("#qwPreloaderBox").addClass("active") : $("#qwPreloaderBox").removeClass("active")
    }, $.fn.addGeneralPreloader = function() {
        $("body").append('<div id="qwPreloaderBox" class="qt-preloader"><span><i  class="fas fa-circle-notch fa-spin fa-3x fa-fw margin-bottom"></span></div>')
    }, $("body").on("click", "#qwPreloaderBox", function() {
        $.fn.closeModal()
    }), $.fn.qtResizeTimer = function() {
        var t, e = $(window).width();
        $(window).on("resize", function(i) {
            clearTimeout(t), t = setTimeout(function() {
                $(window).width() != e && (e = $(window).width(), location.reload())
            }, 350)
        })
    }, $.fn.qwLoadedTheme = function() {
        $.fn.qtMasonry(), $.fn.dynamicMapsNew(), $.fn.NewYoutubeResize(), $.fn.qtSquaredItems(), $(".button-collapse").sideNav(), $(".prettySocial").prettySocial(), $("#qtMainContainer").hasClass("qt-preloaderanimation") && $("#qtMainContainer.qt-preloaderanimation ").velocity({
            opacity: 1
        }, {
            complete: function() {
                $.fn.preloaderVisibility(0)
            }
        })
    }, $.fn.qwInitTheme = function() {
        $.fn.qtMobileNav(), $.fn.qtEqTit(), $.fn.qtInitTripleView(), $.fn.qtQTabs(), $.fn.qtLoadMore(), $.fn.parallaxBackground(), $.fn.qtGradientOverlay(), $.fn.qtSmoothScroll(), $.fn.transformlinks("#qtMainContainer"), $.fn.qwScrollfireElements(), $.fn.dynamicBackgrounds(), $.fn.qtGridSwitcher(), $.fn.atTabsAnimator(), $(".tabs").tabs("select_tab", "tab_id"), $.fn.gridstackSlideshows(), $.fn.gridstackCarousel(), $.fn.gridstackOwl(), $.fn.gridstackSkywheel(), $.fn.parallaxPolydecor(), $.fn.qtFlipClockJs(), $.fn.qtMusicPlayer(), $.fn.qt360player(), $.fn.qtQtSwitch(), $("#qtMainContainer").hasClass("qt-preloaderanimation") && ($.fn.addGeneralPreloader(), $.fn.preloaderVisibility(1)), $(window).width() > 1280 && $(".dropDownMenu").css({
            "padding-right": $("#headerbuttons").width() + "px"
        }), jQuery(window).load(function() {
            $.fn.qwLoadedTheme(), $("body").hasClass("mobile") || ($.skrollrInstance = skrollr.init({
                forceHeight: !1
            }))
        })
    }, jQuery(document).ready(function() {
        if (!1 === $("body").hasClass("qt-debug")) {
            var t = {};
            t.log = function() {}, window.console = t
        } else if ("undefined" == typeof t) var t = {
            log: function(t) {}
        };
        $.fn.qwInitTheme()
    }), jQuery(window).load(function() {
        setTimeout(function() {
            jQuery(window).resize()
        }, 2e3)
    })
}(jQuery);
//# sourceMappingURL=./main-min.js.map