import axios from "axios";

function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

function setCookie(name, value, options = {}) {

    let expires = options.expires;

    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);

    let updatedCookie = name + "=" + value;

    for (let propName in options) {
        updatedCookie += "; " + propName;
        let propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }

    document.cookie = updatedCookie;
}

function deleteCookie(name) {
    setCookie(name, "", {
        path: '/',
        expires: -1
    })
}

function getGetParam(key) {
    var s = window.location.search;
    s = s.match(new RegExp(key + '=([^&=]+)'));
    return s ? s[1] : false;
}


function getRedirectUrl() {
    return encodeURIComponent(window.location);
}

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

const client = axios.create();

export default function (Vue) {
    Vue.axiosClient = {

        client: client,

        getCookieByName (name) {
            return getCookie(name)
        },

        deleteCookie (name) {
            return deleteCookie(name)
        },
        getRedirectUrl (){
            return 'redirect=' + getRedirectUrl()
        },
        getGetParam (key){
            return getGetParam(key)
        }

    }

    Object.defineProperties(Vue.prototype, {
        $axiosClient: {
            get: () => {
                return Vue.axiosClient
            }
        }
    })
}