import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

import state            from "./state";
import * as getters     from "./getters";
import * as mutations   from "./mutations";
import * as actions     from "./actions";

import User             from "./modules/User";
import Usertype         from "./modules/Usertype";
import B_unit           from "./modules/Bunit";
import B_Group          from "./modules/BGroup";
import B_Time           from "./modules/Btime";
import B_Rule           from "./modules/BRule";
import PGroup           from "./modules/PriceGroup";
import GCat             from "./modules/GCategories";
import Discount         from "./modules/Discount";
import GlobalDisc       from "./modules/GlobalDisc";
import PMethod          from "./modules/PaymentMethod";
import Charges          from "./modules/Delivery-Charges";
import Tenant           from "./modules/Tenant";
import Province         from "./modules/Provinces";
import Town             from "./modules/Town";
import Brgy             from "./modules/Barangay";
import Product          from "./modules/Product";
import Report           from "./modules/Reports";
import MinOrder         from "./modules/MinOrder";



export default new Vuex.Store({
    state,
    getters,
    mutations,
    actions,

    modules: {
        User,
        Usertype,
        B_unit,
        B_Group,
        B_Time,
        B_Rule,
        PGroup,
        GCat,
        Discount,
        GlobalDisc,
        PMethod,
        Charges,
        Tenant,
        Province,
        Town,
        Brgy,
        Product,
        Report,
        MinOrder
    }
});
