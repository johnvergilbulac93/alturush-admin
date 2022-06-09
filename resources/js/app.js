/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue").default;

import router from "./router";
import store from "./store/index";

import swal from "sweetalert2";
import moment from "moment";

import ViewUI from "view-design";
import locale from "view-design/dist/locale/en-US";
import "view-design/dist/styles/iview.css";
Vue.use(ViewUI, { locale: locale });

import "nprogress/nprogress.css";

import VueToast from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import excel from "vue-excel-export";

Vue.use(excel);

Vue.use(VueToast, {
    duration: 3000,
    position: "bottom-right"
});

window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: "top",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
});

const toast2 = swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
});

window.toast = toast;
window.toast2 = toast2;

window.Fire = new Vue();

window.moment = require("moment");
window.numeral = require("numeral");

//Filters section
Vue.filter("textformat", function(data) {
    return data.charAt(0).toUpperCase() + data.slice(1);
});

Vue.filter("dateformat", function(created) {
    return moment(created)
        .startOf()
        .fromNow();
});

Vue.filter("formatDate", date =>
    moment(date).format("MMMM Do YYYY, h:mm:ss a")
);
Vue.filter("formatDate2", date => moment(date).format("l"));
Vue.filter("formatDateNoTime", date => moment(date).format("MMM DD, YYYY"));
Vue.filter("formatDateMonthOnly", date => moment(date).format("MMMM"));
Vue.filter("formatTime", date => moment(date).format("h:mm A"));
Vue.filter("formatTime2", time => moment(time, ["HH.mm"]).format("hh:mm a"));

Vue.filter("toCurrency", function(value) {
    if (typeof value !== "number") {
        return value;
    }
    var formatter = new Intl.NumberFormat();
    return formatter.format(value);
});

Vue.filter("toCurrency2", function(value) {
    var formatter = new Intl.NumberFormat("en-PH", {
        style: "currency",
        currency: "PHP"
    });
    return formatter.format(value);
});

let serverDateTime = document.head.querySelector('meta[name="server-datetime"]')
    .content;
let userType = document.head.querySelector('meta[name="user-type"]').content;
let id = document.head.querySelector('meta[name="id"]').content;

window.serverDateTime = serverDateTime;
window.userType = userType;
window.id = id;

Vue.component(
    "Profile",
    require("./components/goods/pages/Profile-Upload.vue").default
);
Vue.component("Pagination", require("./Usable/Pagination.vue").default);
Vue.component("Datatable", require("./Usable/Datatable.vue").default);
Vue.component("Error", require("./Usable/Error.vue").default);
Vue.component("module-clock", require("./Usable/Clock.vue").default);

Vue.component("back-to-top", require("./Usable/BacktoTop.vue").default);

Vue.component("menu-main", require("./components/menu/Main-Menu.vue").default);
Vue.component(
    "menu-admin",
    require("./components/menu/Admin-Menu.vue").default
);
Vue.component(
    "menu-audit",
    require("./components/menu/Audit-Menu.vue").default
);
Vue.component(
    "menu-purch",
    require("./components/menu/Purchasing-Menu.vue").default
);
Vue.component("menu-header", require("./Usable/TheMenuHeader.vue").default);

Vue.component("module-header", require("./Usable/Header.vue").default);
Vue.component("module-dropdown", require("./Usable/Dropdown.vue").default);


setTimeout(() => {
    const box = document.getElementById("idErrorMsg");
    if (box) {
        box.style.display = "none";
    }
}, 5000);

const app = new Vue({
    el: "#app",
    router,
    store,
    data() {
        return {
            url: process.env.MIX_URL_LOCAL,
            path: process.env.MIX_URL_PATH,
            web_url: process.env.MIX_WEB_URL,

            // url: process.env.MIX_URL_ITEM_IMAGES,
            // path: process.env.MIX_URL_RESOURCES,
            serverDateTime,
            userType,
            id,
            logo_path: "https://apanel.alturush.com/",
            open: false,
            openMenu: false,
            upload_profile: false,
            showPassword: false,
            password: "",
            messageIdle: "",
            visible: false
        };
    },

    methods: {
        openSetting() {
            this.open = !this.open;
        },
        handleBlur() {
            setTimeout(() => {
                this.open = false;
            }, 100);
        },
        toggleMenu() {
            setTimeout(() => {
                this.openMenu = false;
            }, 100);
        },
        showUpload() {
            this.upload_profile = true;
        },
        toggleShow() {
            this.showPassword = !this.showPassword;
        },
        handleOpen() {
            this.visible = true;
        },
        handleClose() {
            this.visible = false;
        }
    }
});
