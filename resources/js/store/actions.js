import Common from "../services/Common";
import MinOrder from "../services/MinOrder";
import User from "../services/masterfile/User";
import Item from "../services/Item";
import axios from "axios";
import Report from "../services/Report";

export const userType = async ({ commit }) => {
    try {
        const { status, data } = await Common.ViewUserType();
        if (status === 200) {
            commit("USERTYPE", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const brgyFiltered = ({ commit }, payload) => {
    commit("FILTERED_BRGY", payload);
};
export const townFiltered = ({ commit }, payload) => {
    commit("FILTERED_TOWN", payload);
};

export const getPriceChangedInfo = async (
    { commit },
    { currentPage, filterData }
) => {
    try {
        const { status, data } = await Item.Price_changed_info(
            currentPage,
            filterData
        );
        if (status === 200) {
            commit("SET_PRICE_CHANGED_INFO", data.data);
            commit("PAGINATION", data);
        }
    } catch (error) {}
};
export const getItemNotAvailable = async (
    { commit },
    { currentPage, filterData }
) => {
    try {
        const { status, data } = await Item.Item_not_available(
            currentPage,
            filterData
        );
        if (status === 200) {
            commit("SET_ITEM_NOT_AVAILABLE", data.data);
            commit("PAGINATION", data);
            commit("TOTAL_NOT_AVAILABLE", data.total);
        }
    } catch (error) {
        console.log(error);
    }
};
export const getPriceGroup = async ({ commit }) => {
    try {
        const { status, data } = await Common.ViewPriceGroup();
        if (status === 200) {
            commit("SET_PRICE_GROUP", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const getGlobalCategory = async ({ commit }) => {
    try {
        const { status, data } = await Common.viewGlobalCategory();
        if (status === 200) {
            commit("SET_GLOBAL_CATEGORY", data);
        }
    } catch (error) {
        console.error(error);
    }
};
export const getProvince = async ({ commit }) => {
    try {
        const { status, data } = await Common.ViewProvince();
        if (status === 200) {
            commit("SET_PROVINCE", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const getItemCategory = async ({ commit }) => {
    try {
        const { status, data } = await Common.ViewItemCategory();
        if (status === 200) {
            commit("SET_ITEM_CATEGORY", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const getBarangay = async ({ commit }) => {
    try {
        const { status, data } = await Common.ViewBarangay();
        if (status === 200) {
            commit("SET_BARANGAY", data);
        }
    } catch (error) {
        console.log(data);
    }
};
export const getTown = async ({ commit }) => {
    try {
        const { status, data } = await Common.ViewTown();
        if (status === 200) {
            commit("SET_TOWN", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const getTransportation = async ({ commit }) => {
    try {
        const { status, data } = await Common.ViewTransportation();
        if (status === 200) {
            commit("SET_TRANSPORTATION", data);
        }
    } catch (error) {
        console.log(error);
    }
};

export const getPriceChanged = async ({ commit }) => {
    try {
        const { status, data } = await Item.Price_changed_count();
        if (status === 200) {
            commit("SET_PRICE_COUNT_CHANGED", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const getStore = async ({ commit }) => {
    try {
        const { status, data } = await Common.ViewStore();
        if (status === 200) {
            commit("SET_STORES", data);
        }
    } catch (error) {
        console.log(error);
    }
};

export const getDepartment = async ({ commit }) => {
    try {
        const { status, data } = await Common.ViewDepartment();
        if (status === 200) {
            commit("SET_DEPARTMENTS", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const saveMinOrder = async ({ commit }, { minorder }) => {
    try {
        const { status } = await MinOrder.saveInfo(minorder);
        if (status === 200) {
            Fire.$emit("reload_min_order");
            toast.fire({
                icon: "success",
                title: "Success",
                text: "Successfully saved"
            });
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
};
export const getMinOrder = async ({ commit }, { currentPage, filterData }) => {
    try {
        const { status, data } = await MinOrder.show(currentPage, filterData);
        if (status === 200) {
            commit("SET_MINORDER", data.data);
            commit("PAGINATION", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const updateMinOrder = async ({ commit }, { minorder }) => {
    try {
        const { status } = await MinOrder.updateInfo(minorder);
        if (status === 200) {
            Fire.$emit("reload_min_order");
            commit("MODAL_FLAG", false);
            toast.fire({
                icon: "success",
                title: "Success",
                text: "Successfully saved"
            });
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
};
export const deleteMinOrder = ({ commit }, { id }) => {
    swal.fire({
        title: "Confirmation",
        text: "Are you sure you want to delete this data?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then(result => {
        if (result.isConfirmed) {
            commit("REMOVE_MIN_ORDER", id);
            MinOrder.delete(id).then(() => {
                toast.fire({
                    icon: "success",
                    title: "Success",
                    text: "Successfully Deleted"
                });
            });
        }
    });
};
export const getEmployee = async ({ commit }, { employee }) => {
    try {
        const { status, data } = await Common.ViewEmployee(employee);
        if (status === 200) {
            commit("SET_EMPLOYEE", data);
        }
    } catch (error) {
        console.log(error);
    }
};

export const enableItemPerUOM = async ({ commit }, { itemCode }) => {
    try {
        const { status } = await Item.item_enable_per_uom(itemCode);
        if (status === 200) {
            swal.fire(
                "Success!",
                "Selected item/uom successfully enable.",
                "success"
            );
        }
    } catch (error) {
        console.log(error);
    }
};
export const getStoreItem = async ({ commit }, { currentPage, filterData }) => {
    try {
        const { status, data } = await Item.store_item_masterfile(
            currentPage,
            filterData
        );
        if (status === 200) {
            commit("SET_ITEM", data.data);
            commit("PAGINATION", data);
        }
    } catch (error) {
        console.log(error);
    }
};

export const userChangePass = async ({ commit }, { user }) => {
    try {
        const { status } = await User.changePassword(user);
        if (status === 200) {
            Fire.$emit("clear_field");
            toast.fire({
                icon: "success",
                title: "Success",
                text: "Successfully change."
            });
            axios.post("/logout").then(() => {
                location.reload();
            });
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
};
export const userChangeUsername = async ({ commit }, { user }) => {
    try {
        const { status } = await User.changeUsername(user);
        if (status === 200) {
            Fire.$emit("clear_field");
            toast.fire({
                icon: "success",
                title: "Success",
                text: "Successfully change."
            });
            location.reload();
        }
    } catch (error) {
        commit("SET_ERRORS", error.response.data.errors);
        setTimeout(() => {
            commit("CLEAR_ERRORS");
        }, 5000);
    }
};
export const getMostCancelledItem = async ({ commit }) => {
    try {
        const { status, data } = await Report.most_cancelled_item();
        if (status === 200) {
            let sortData = [];

            sortData = data.sort(function(a, b) {
                return parseInt(b.count) - parseInt(a.count);
            });

            commit("SET_MOST_CANCELLED_ITEMS", sortData);
        }
    } catch (error) {
        console.log(error);
    }
};
export const getHourlyCallMonitoring = async ({ commit }, { filter }) => {
    try {
        const { status, data } = await Report.hourly_call_monitoring(filter);
        if (status === 200) {
            commit("SET_HOURLY_CALL_MONITORING", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const getCommission = async ({ commit }, { filter }) => {
    try {
        const { status, data } = await Report.commission(filter);
        if (status === 200) {
            commit("SET_COMMISSION", data);
        }
    } catch (error) {
        console.log(error);
    }
};

export const getSelectedTenant = async ({ commit }, { id }) => {
    try {
        const { status, data } = await Common.ViewSelectedTenant(id);
        if (status == 200) {
            commit("SET_SELECTED_TENANT", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const getUsertypeTenant = async ({ commit }) => {
    try {
        const { status, data } = await User.showUsertypeTenant();
        if (status == 200) {
            commit("SET_USERTYPE_TENANT", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const getFoodUsertype = async ({ commit }, payload) => {
    try {
        const { status, data } = await Common.ViewFoodUsertype(payload);
        if (status == 200) {
            commit("SET_FOOD_USERTYPE", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const getUserRole = async ({ commit }, payload) => {
    try {
        const { status, data } = await Common.ViewUserRole(payload);
        if (status == 200) {
            commit("SET_USERROLE", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const getBuGroup = async ({ commit }, payload) => {
    try {
        const { status, data } = await Common.viewBuGroup(payload);
        if (status == 200) {
            commit("SET_BU_GROUP", data);
        }
    } catch (error) {
        console.log(error);
    }
};
export const getDiscount = async ({ commit }, payload) => {
    try {
        const { status, data } = await Common.viewDiscount(payload);
        if (status == 200) {
            commit("SET_DISCOUNT", data);
        }
    } catch (error) {
        console.error(error);
    }
};
export const getRangeLevel = async ({ commit }) => {
    try {
        const { status, data } = await Common.viewRangeLevel();
        if (status === 200) {
            commit("SET_RANGE_LEVEL", data);
        }
    } catch (error) {
        console.log(error);
    }
};
