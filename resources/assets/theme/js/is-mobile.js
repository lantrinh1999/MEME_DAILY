'use strict'

// module.exports = isMobile
// module.exports.isMobile = isMobile
// module.exports.default = isMobile

var mobileRE = /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series[46]0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i

var tabletRE = /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series[46]0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino|android|ipad|playbook|silk/i

function isMobile(opts) {
    if (!opts) opts = {}
    var ua = opts.ua
    if (!ua && typeof navigator !== 'undefined') ua = navigator.userAgent
    if (ua && ua.headers && typeof ua.headers['user-agent'] === 'string') {
        ua = ua.headers['user-agent']
    }
    if (typeof ua !== 'string') return false

    var result = opts.tablet ? tabletRE.test(ua) : mobileRE.test(ua)

    if (
        !result &&
        opts.tablet &&
        opts.featureDetect &&
        navigator &&
        navigator.maxTouchPoints > 1 &&
        ua.indexOf('Macintosh') !== -1 &&
        ua.indexOf('Safari') !== -1
    ) {
        result = true
    }

    return result
}