export const PAGINATION = (state, pagination) => {
    state.pagination = {
        lastPage: pagination.last_page,
        currentPage: pagination.current_page,
        total: pagination.total,
        lastPageUrl: pagination.last_page_url,
        nextPageUrl: pagination.next_page_url,
        prevPageUrl: pagination.prev_page_url,
        from: pagination.from,
        to: pagination.to
    };
};
export const PAGINATION2 = (state, pagination) => {
    state.pagination2 = {
        lastPage: pagination.last_page,
        currentPage: pagination.current_page,
        total: pagination.total,
        lastPageUrl: pagination.last_page_url,
        nextPageUrl: pagination.next_page_url,
        prevPageUrl: pagination.prev_page_url,
        from: pagination.from,
        to: pagination.to
    };
};
export const SET_ERRORS = (state, payload) => {
    state.errors = payload;
};
export const CLEAR_ERRORS = state => {
    state.errors = {};
};
export const SET_ITEM_CATEGORY = (state, payload) => {
    state.ItemCategory = payload;
};
export const SET_PRICE_CHANGED_INFO = (state, payload) => {
    state.PriceChangeInfo = payload;
};
export const SET_ITEM_NOT_AVAILABLE = (state, payload) => {
    state.ItemsNotAvailable = payload;
};
export const SET_PRICE_COUNT_CHANGED = (state, payload) => {
    state.priceCount = payload;
};
export const SET_STORES = (state, payload) => {
    state.Stores = payload;
};
export const SET_GLOBAL_CATEGORY = (state, payload) => {
    state.GlobalCategory = payload;
};
export const SET_BU_GROUP = (state, payload) => {
    state.BuGroup = payload;
};
export const SET_GLOBAL_CATEGORY2 = (state, payload) => {
    state.GlobalCategory2 = payload;
};
export const SET_PROVINCE = (state, payload) => {
    state.Provinces = payload;
};
export const SET_BARANGAY = (state, payload) => {
    state.Barangays = payload;
};
export const SET_BARANGAY2 = (state, payload) => {
    state.Barangays2 = payload;
};
export const SET_TOWN = (state, payload) => {
    state.Towns = payload;
};
export const SET_TOWN2 = (state, payload) => {
    state.Towns2 = payload;
};
export const SET_TRANSPORTATION = (state, payload) => {
    state.Transportations = payload;
};

export const SET_DEPARTMENTS = (state, payload) => {
    state.Departments = payload;
};
export const FILTERED_BRGY = (state, payload) => {
    state.filterBarangays = state.Barangays.filter(brgy => {
        return brgy.town_id === payload.town_id;
    });
};
export const FILTERED_TOWN = (state, payload) => {
    state.filterTowns = state.Towns.filter(town => {
        return town.prov_id === payload.prov_id;
    });
};

export const SET_EMPLOYEE = (state, payload) => {
    state.Employees = payload;
};
export const CLEAR_EMPLOYEE = state => {
    state.Employees = [];
};
export const SET_ITEM = (state, payload) => {
    state.Items = payload;
};
export const TOTAL_NOT_AVAILABLE = (state, payload) => {
    state.TotalItemNotAvailable = payload;
};
export const SET_PRICE_GROUP = (state, payload) => {
    state.PriceGroup = payload;
};
export const SET_STORE_PRICE_GROUP = (state, payload) => {
    state.StorePriceGroup = payload;
};

export const SET_ORDER_DATA_REPORT = (state, payload) => {
    state.OrderDataReport = payload;
};
export const SET_MOST_CANCELLED_ITEMS = (state, payload) => {
    state.MostCancelledItems = payload;
};
export const SET_HOURLY_CALL_MONITORING = (state, payload) => {
    state.HourlyCallMonitoring = payload;
};
export const SET_COMMISSION = (state, payload) => {
    state.Commission = payload;
};
export const SET_SELECTED_TENANT = (state, payload) => {
    state.SelectedTenant = payload;
};
export const SET_USERTYPE_TENANT = (state, payload) => {
    state.TenantUsertype = payload;
};
export const SET_FOOD_USERTYPE = (state, payload) => {
    state.FoodUsertype = payload;
};
export const SET_USERROLE = (state, payload) => {
    state.Roles = payload;
};
export const SET_DISCOUNT = (state, payload) => {
    state.Disc = payload;
};
export const SET_RANGE_LEVEL = (state, payload) => {
    state.RangeLevel = payload;
};
export const USERTYPE = (state, payload) => {
    state.UserTypes = payload;
};
