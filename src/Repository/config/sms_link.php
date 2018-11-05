<?php
/**
 * Project vn-telco-phonenumber.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/4/18
 * Time: 14:32
 */
return array(
    'script' => '<script>
var SMSLink = SMSLink || {};
SMSLink.detector = SMSLink.detector || function() {
    var a, b, c, d = navigator.userAgent;
    return d.match(/iPad/i) || d.match(/iPhone/i) ? (a = "iOS", c = d.indexOf("OS ")) : d.match(/Android/i) ? (a = "Android", c = d.indexOf("Android ")) : a = null, "iOS" === a && c > -1 ? b = d.substr(c + 3, 3).replace("_", ".") : "Android" === a && c > -1 ? a = d.substr(c + 8, 3) : ver = null, {
        version: function() {
            return b
        },
        os: function() {
            return a
        },
        isMobile: function() {
            return null !== a
        }
    }
};
var SMSLink = SMSLink || {};
SMSLink.link = SMSLink.link || function() {
    function a() {
        SMSLink.linkDetector || (SMSLink.linkDetector = new SMSLink.detector)
    }
    return a(), {
        replaceAll: function() {
            this.replaceWithSelector("[href^=\'sms:\']")
        },
        replaceWithSelector: function(a) {
            elements = document.querySelectorAll(a);
            for (i in elements) this.replace(elements[i])
        },
        replace: function(a) {
            if (a.href) {
                switch (replaceBody = !1, SMSLink.linkDetector.os()) {
                    case "iOS":
                        parseFloat(SMSLink.linkDetector.version()) <= 8 ? replaceBody = ";" : replaceBody = "&"
                }
                replaceBody && (a.href = a.href.replace(/\?body=/, replaceBody + "body="))
            }
        }
    }
};
document.addEventListener(\'DOMContentLoaded\', (function() {
    link = new SMSLink.link();
    link.replaceAll();
}), false);</script>'
);
