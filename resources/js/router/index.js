import Vue from "vue";
import VueRouter from "vue-router";
import store from "./../store";
import routes from "./routes"

Vue.use(VueRouter);

let router = new VueRouter({
    mode: "history",
    routes
});
// router.beforeEach((to, from, next) => {
//     if (!store.state.checkSession) {
//         alert("Session expired. You'll be take to the login page.");
//         location.reload();
//     } else {
//         store.commit("CLEAR_ERRORS");
//         next();
//     }
// });
export default router;
