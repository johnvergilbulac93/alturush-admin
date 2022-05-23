(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_foods_pages_Masterfile_GlobalCategory_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/Masterfile/GlobalCategory.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/Masterfile/GlobalCategory.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "GlobalCategory",
  data: function data() {
    var sortOrders = {};
    var columns = [{
      width: "15%",
      label: "Image",
      name: "image",
      "class": "text-left"
    }, {
      width: "15%",
      label: "Category",
      name: "cat",
      "class": "text-left"
    }, {
      width: "15%",
      label: "Delivery",
      name: "delivery",
      "class": "text-center"
    }, {
      width: "15%",
      label: "Pick-up",
      name: "pick_up",
      "class": "text-center"
    }, {
      width: "15%",
      label: "Status",
      name: "status",
      "class": "text-center"
    }, {
      width: "15%",
      label: "Action",
      name: "action",
      "class": "text-center"
    }];
    columns.forEach(function (column) {
      sortOrders[column.name] = -1;
    });
    return {
      columns: columns,
      sortKey: "id",
      sortOrders: sortOrders,
      tableData: {
        length: 10,
        search: "",
        column: 1,
        dir: "desc"
      },
      currentPage: 1,
      category: "",
      id: "",
      editMode: false,
      preview: null,
      preview2: null,
      image: null
    };
  },
  computed: _objectSpread({}, (0,vuex__WEBPACK_IMPORTED_MODULE_0__.mapState)(["perPage", "pagination", "isModal", "GlobalCategory2", "isModal2", "errors"])),
  methods: _objectSpread(_objectSpread({}, (0,vuex__WEBPACK_IMPORTED_MODULE_0__.mapActions)(["showGlobalCategory", "setGlobalCategoryDeliveryStatus", "setGlobalCategoryPickUpStatus", "setGlobalCategoryStatus", "modal", "modal2", "updateGlobalCategory", "createGlobalCategory", "updateImageGlobalCategory"])), {}, {
    handleFileChange: function handleFileChange(event) {
      var _this = this;

      var input = event.target;
      this.preview2 = null;

      if (input.files) {
        var reader = new FileReader();

        reader.onload = function (e) {
          _this.preview = e.target.result;
        };

        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
    update: function update() {
      this.updateGlobalCategory({
        id: this.id,
        category: this.category
      });
    },
    reset: function reset() {
      this.image = null, this.preview = null;
      this.id = "";
      this.preview2 = null;
      document.querySelector("body").style.overflow = "visible";
    },
    create: function create() {
      var formData = new FormData();
      formData.append("image", this.image);
      formData.append("category", this.category);
      this.createGlobalCategory({
        formData: formData
      });
      this.reset();
    },
    editImage: function editImage(data) {
      this.id = data.id;
      this.preview2 = data.cat_picture;
      this.modal2({
        flag: true
      });
    },
    updateImage: function updateImage() {
      var formData = new FormData();
      formData.append("image", this.image);
      formData.append("id", this.id);
      this.updateImageGlobalCategory({
        formData: formData
      });
    },
    editModal: function editModal(data) {
      document.querySelector("body").style.overflow = "hidden";
      this.editMode = true;
      this.id = data.id;
      this.category = data.category;
      this.modal({
        flag: true
      });
    },
    addModal: function addModal() {
      document.querySelector("body").style.overflow = "hidden";
      this.editMode = false;
      this.id = "";
      this.category = "";
      this.modal({
        flag: true
      });
    },
    closeModal: function closeModal() {
      this.reset();
      this.modal({
        flag: false
      });
    },
    closeModal2: function closeModal2() {
      this.reset();
      this.modal2({
        flag: false
      });
    },
    setStatus: function setStatus(data) {
      var _this2 = this;

      swal.fire({
        title: "Confirmation",
        text: "Do you want to change the status?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, change it!"
      }).then(function (result) {
        if (result.isConfirmed) {
          _this2.setGlobalCategoryStatus({
            status: data.status,
            id: data.id
          });
        }
      });
    },
    pickupStatus: function pickupStatus(data) {
      var _this3 = this;

      swal.fire({
        title: "Confirmation",
        text: "Do you want to change the status?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, change it!"
      }).then(function (result) {
        if (result.isConfirmed) {
          _this3.setGlobalCategoryPickUpStatus({
            status: data.pick_up,
            id: data.id
          });
        }
      });
    },
    deliveryStatus: function deliveryStatus(data) {
      var _this4 = this;

      swal.fire({
        title: "Confirmation",
        text: "Do you want to change the status?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, change it!"
      }).then(function (result) {
        if (result.isConfirmed) {
          _this4.setGlobalCategoryDeliveryStatus({
            status: data.delivery,
            id: data.id
          });
        }
      });
    },
    fetch: function fetch() {
      var filterData = {
        length: this.tableData.length,
        search: this.tableData.search,
        dir: this.tableData.dir
      };
      this.showGlobalCategory({
        filterData: filterData,
        currentPage: this.currentPage
      });
    },
    clear: function clear() {
      this.tableData.search = "", this.fetch();
    },
    previousPage: function previousPage() {
      this.currentPage--;
      this.fetch();
    },
    nextPage: function nextPage() {
      this.currentPage++;
      this.fetch();
    },
    sortBy: function sortBy(key) {
      this.sortKey = key;
      this.sortOrders[key] = this.sortOrders[key] * -1;
      this.tableData.column = this.getIndex(this.columns, "name", key);
      this.tableData.dir = this.sortOrders[key] === 1 ? "asc" : "desc";
      this.fetch();
    },
    getIndex: function getIndex(array, key, value) {
      return array.findIndex(function (i) {
        return i[key] == value;
      });
    }
  }),
  mounted: function mounted() {
    var _this5 = this;

    Fire.$on("reload_gcategory", function () {
      _this5.fetch();
    });
    this.fetch();
  }
});

/***/ }),

/***/ "./resources/js/components/foods/pages/Masterfile/GlobalCategory.vue":
/*!***************************************************************************!*\
  !*** ./resources/js/components/foods/pages/Masterfile/GlobalCategory.vue ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _GlobalCategory_vue_vue_type_template_id_64336a92___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./GlobalCategory.vue?vue&type=template&id=64336a92& */ "./resources/js/components/foods/pages/Masterfile/GlobalCategory.vue?vue&type=template&id=64336a92&");
/* harmony import */ var _GlobalCategory_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./GlobalCategory.vue?vue&type=script&lang=js& */ "./resources/js/components/foods/pages/Masterfile/GlobalCategory.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _GlobalCategory_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _GlobalCategory_vue_vue_type_template_id_64336a92___WEBPACK_IMPORTED_MODULE_0__.render,
  _GlobalCategory_vue_vue_type_template_id_64336a92___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/foods/pages/Masterfile/GlobalCategory.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/foods/pages/Masterfile/GlobalCategory.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/foods/pages/Masterfile/GlobalCategory.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_GlobalCategory_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./GlobalCategory.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/Masterfile/GlobalCategory.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_GlobalCategory_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/foods/pages/Masterfile/GlobalCategory.vue?vue&type=template&id=64336a92&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/foods/pages/Masterfile/GlobalCategory.vue?vue&type=template&id=64336a92& ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_GlobalCategory_vue_vue_type_template_id_64336a92___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_GlobalCategory_vue_vue_type_template_id_64336a92___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_GlobalCategory_vue_vue_type_template_id_64336a92___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./GlobalCategory.vue?vue&type=template&id=64336a92& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/Masterfile/GlobalCategory.vue?vue&type=template&id=64336a92&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/Masterfile/GlobalCategory.vue?vue&type=template&id=64336a92&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/Masterfile/GlobalCategory.vue?vue&type=template&id=64336a92& ***!
  \*************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "border" }, [
    _c("div", { staticClass: "text-gray-800 overflow-x-auto" }, [
      _c(
        "div",
        {
          staticClass: "mb-2 bg-gray-100 p-2 flex justify-between items-center"
        },
        [
          _c(
            "label",
            { staticClass: "text-lg font-semibold", attrs: { for: "" } },
            [_vm._v("Global Category List")]
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "flex gap-1  btn-add ",
              attrs: {
                "data-toggle": "tooltip",
                "data-placement": "bottom",
                title: "Add Global Category"
              },
              on: { click: _vm.addModal }
            },
            [
              _c(
                "svg",
                {
                  staticClass: "h-5 w-5",
                  attrs: {
                    xmlns: "http://www.w3.org/2000/svg",
                    viewBox: "0 0 20 20",
                    fill: "currentColor"
                  }
                },
                [
                  _c("path", {
                    attrs: {
                      "fill-rule": "evenodd",
                      d:
                        "M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z",
                      "clip-rule": "evenodd"
                    }
                  })
                ]
              ),
              _vm._v(" "),
              _c("span", [_vm._v("Global Category")])
            ]
          )
        ]
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "p-2" },
        [
          _c("div", { staticClass: "flex justify-between items-center" }, [
            _c("div", { staticClass: "w-1/3 flex items-center gap-0.5 " }, [
              _c("div", { staticClass: "relative w-full flex " }, [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.tableData.search,
                      expression: "tableData.search"
                    }
                  ],
                  staticClass: "relative form-search",
                  attrs: { type: "text", placeholder: "Search...." },
                  domProps: { value: _vm.tableData.search },
                  on: {
                    keyup: function($event) {
                      if (
                        !$event.type.indexOf("key") &&
                        _vm._k($event.keyCode, "enter", 13, $event.key, "Enter")
                      ) {
                        return null
                      }
                      return _vm.fetch($event)
                    },
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(_vm.tableData, "search", $event.target.value)
                    }
                  }
                }),
                _vm._v(" "),
                _vm.tableData.search.length
                  ? _c(
                      "button",
                      {
                        staticClass:
                          "absolute right-0 z-10   pr-2 w-8 h-full leading-snug bg-transparent rounded  flex items-center justify-center focus:outline-none ",
                        on: { click: _vm.clear }
                      },
                      [
                        _c(
                          "svg",
                          {
                            staticClass: "h-5 w-5  hover:text-red-500",
                            attrs: {
                              xmlns: "http://www.w3.org/2000/svg",
                              fill: "none",
                              viewBox: "0 0 24 24",
                              stroke: "currentColor"
                            }
                          },
                          [
                            _c("path", {
                              attrs: {
                                "stroke-linecap": "round",
                                "stroke-linejoin": "round",
                                "stroke-width": "2",
                                d: "M6 18L18 6M6 6l12 12"
                              }
                            })
                          ]
                        )
                      ]
                    )
                  : _vm._e()
              ]),
              _vm._v(" "),
              _c(
                "button",
                { staticClass: "button-search", on: { click: _vm.fetch } },
                [
                  _c(
                    "svg",
                    {
                      staticClass: "h-5 w-5 ",
                      attrs: {
                        xmlns: "http://www.w3.org/2000/svg",
                        fill: "none",
                        viewBox: "0 0 24 24",
                        stroke: "currentColor"
                      }
                    },
                    [
                      _c("path", {
                        attrs: {
                          "stroke-linecap": "round",
                          "stroke-linejoin": "round",
                          "stroke-width": "2",
                          d: "M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                        }
                      })
                    ]
                  )
                ]
              )
            ]),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "justify-end items-center sm:hidden lg:flex gap-1 "
              },
              [
                _c("span", { staticClass: "sm:hidden xl:block" }, [
                  _vm._v("Show")
                ]),
                _vm._v(" "),
                _c(
                  "select",
                  {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.tableData.length,
                        expression: "tableData.length"
                      }
                    ],
                    staticClass: "form-sort",
                    on: {
                      change: [
                        function($event) {
                          var $$selectedVal = Array.prototype.filter
                            .call($event.target.options, function(o) {
                              return o.selected
                            })
                            .map(function(o) {
                              var val = "_value" in o ? o._value : o.value
                              return val
                            })
                          _vm.$set(
                            _vm.tableData,
                            "length",
                            $event.target.multiple
                              ? $$selectedVal
                              : $$selectedVal[0]
                          )
                        },
                        _vm.fetch
                      ]
                    }
                  },
                  _vm._l(_vm.perPage, function(records, index) {
                    return _c(
                      "option",
                      { key: index, domProps: { value: records } },
                      [
                        _vm._v(
                          "\n                            " +
                            _vm._s(records) +
                            "\n                        "
                        )
                      ]
                    )
                  }),
                  0
                ),
                _vm._v(" "),
                _c("span", { staticClass: "sm:hidden xl:block" }, [
                  _vm._v("Entries")
                ])
              ]
            )
          ]),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "mt-2" },
            [
              _c(
                "Datatable",
                {
                  attrs: {
                    columns: _vm.columns,
                    sortKey: _vm.sortKey,
                    sortOrders: _vm.sortOrders
                  },
                  on: { sort: _vm.sortBy }
                },
                [
                  _c(
                    "tbody",
                    { staticClass: "tbody" },
                    [
                      !_vm.GlobalCategory2.length
                        ? _c("tr", { staticClass: "tr" }, [
                            _c(
                              "td",
                              {
                                staticClass: " td text-center",
                                attrs: { colspan: "6" }
                              },
                              [
                                _vm._v(
                                  "\n                                NO DATA AVAILABLE\n                            "
                                )
                              ]
                            )
                          ])
                        : _vm._e(),
                      _vm._v(" "),
                      _vm._l(_vm.GlobalCategory2, function(data, i) {
                        return _c("tr", { key: i }, [
                          _c("td", { staticClass: "td" }, [
                            _c(
                              "div",
                              { staticClass: "flex items-center gap-2" },
                              [
                                data.cat_picture
                                  ? _c("img", {
                                      staticClass: " w-10 rounded-full",
                                      attrs: {
                                        src: data.cat_picture,
                                        alt: "image"
                                      }
                                    })
                                  : _c("img", {
                                      staticClass: " w-10 rounded-full",
                                      attrs: {
                                        src: _vm.$root.path + "noimage.png",
                                        alt: "image"
                                      }
                                    }),
                                _vm._v(
                                  "\n                                    |\n                                    "
                                ),
                                _c(
                                  "a",
                                  {
                                    on: {
                                      click: function($event) {
                                        return _vm.editImage(data)
                                      }
                                    }
                                  },
                                  [_vm._v("Edit")]
                                )
                              ]
                            )
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "td" }, [
                            _vm._v(_vm._s(data.category))
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "td text-center" }, [
                            _c(
                              "button",
                              {
                                staticClass:
                                  "px-2 py-1 text-white rounded-full font-semibold ",
                                class:
                                  data.delivery == 1
                                    ? "bg-sky-400 hover:bg-sky-500"
                                    : "bg-red-500 hover:bg-red-600",
                                on: {
                                  click: function($event) {
                                    return _vm.deliveryStatus(data)
                                  }
                                }
                              },
                              [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(
                                      data.delivery == 1
                                        ? "Activate"
                                        : "Inactivate"
                                    ) +
                                    "\n                                "
                                )
                              ]
                            )
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "td text-center" }, [
                            _c(
                              "button",
                              {
                                staticClass:
                                  "px-2 py-1 text-white rounded-full font-semibold ",
                                class:
                                  data.pick_up == 1
                                    ? "bg-sky-400 hover:bg-sky-500"
                                    : "bg-red-500 hover:bg-red-600",
                                on: {
                                  click: function($event) {
                                    return _vm.pickupStatus(data)
                                  }
                                }
                              },
                              [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(
                                      data.pick_up == 1
                                        ? "Activate"
                                        : "Inactivate"
                                    ) +
                                    "\n                                "
                                )
                              ]
                            )
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "td text-center" }, [
                            _c(
                              "button",
                              {
                                staticClass:
                                  "px-2 py-1 text-white rounded-full font-semibold ",
                                class:
                                  data.status == 1
                                    ? "bg-sky-400 hover:bg-sky-500"
                                    : "bg-red-500 hover:bg-red-600",
                                on: {
                                  click: function($event) {
                                    return _vm.setStatus(data)
                                  }
                                }
                              },
                              [
                                _vm._v(
                                  "\n                                    " +
                                    _vm._s(
                                      data.status == 1 ? "Active" : "Inactive"
                                    ) +
                                    "\n                                "
                                )
                              ]
                            )
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "td text-center" }, [
                            _c(
                              "button",
                              {
                                staticClass:
                                  "focus:outline-none bg-cyan-500 hover:bg-cyan-600 text-white rounded ",
                                attrs: {
                                  "data-toggle": "tooltip",
                                  "data-placement": "bottom",
                                  title: "Edit"
                                },
                                on: {
                                  click: function($event) {
                                    return _vm.editModal(data)
                                  }
                                }
                              },
                              [
                                _c(
                                  "svg",
                                  {
                                    staticClass: "h-5 w-5",
                                    attrs: {
                                      xmlns: "http://www.w3.org/2000/svg",
                                      fill: "none",
                                      viewBox: "0 0 24 24",
                                      stroke: "currentColor"
                                    }
                                  },
                                  [
                                    _c("path", {
                                      attrs: {
                                        "stroke-linecap": "round",
                                        "stroke-linejoin": "round",
                                        "stroke-width": "2",
                                        d:
                                          "M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                      }
                                    })
                                  ]
                                )
                              ]
                            )
                          ])
                        ])
                      })
                    ],
                    2
                  )
                ]
              ),
              _vm._v(" "),
              _c("Pagination", {
                attrs: { pagination: _vm.pagination },
                on: {
                  prev: function($event) {
                    return _vm.previousPage(_vm.pagination.prevPageUrl)
                  },
                  next: function($event) {
                    return _vm.nextPage(_vm.pagination.nextPageUrl)
                  }
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "transition",
            {
              attrs: {
                "enter-active-class": " ease-in-out transition duration-500",
                "enter-class": "transform -translate-y-11 opacity-0 ",
                "enter-to-class": "opacity-100",
                "leave-active-class": "ease-in-out transition duration-500",
                "leave-class": " opacity-100",
                "leave-to-class": "transform -translate-y-11 opacity-0"
              }
            },
            [
              _vm.isModal
                ? _c(
                    "div",
                    {
                      staticClass:
                        " fixed top-0 left-0 z-50 p-2 flex justify-center items-center w-full h-screen backdrop-blur-sm bg-white/30"
                    },
                    [
                      _c(
                        "form",
                        {
                          staticClass:
                            "sm:w-full lg:w-1/2 bg-white border rounded shadow-2xl shadow-black/20 ",
                          on: {
                            submit: function($event) {
                              $event.preventDefault()
                              _vm.editMode ? _vm.update() : _vm.create()
                            }
                          }
                        },
                        [
                          _c(
                            "div",
                            {
                              staticClass:
                                "p-2 flex justify-between items-center lg:text-lg sm:text-sm "
                            },
                            [
                              !_vm.editMode
                                ? _c(
                                    "label",
                                    { staticClass: "font-semibold " },
                                    [_vm._v("Add Global Category")]
                                  )
                                : _c(
                                    "label",
                                    { staticClass: "font-semibold " },
                                    [_vm._v("Update Global Category")]
                                  ),
                              _vm._v(" "),
                              _c(
                                "a",
                                {
                                  staticClass: "transition duration-500",
                                  on: { click: _vm.closeModal }
                                },
                                [
                                  _c(
                                    "svg",
                                    {
                                      staticClass:
                                        "lg:h-6 lg:w-6 sm:h-5 sm:w-5 text-gray-700 hover:text-red-500",
                                      attrs: {
                                        xmlns: "http://www.w3.org/2000/svg",
                                        fill: "none",
                                        viewBox: "0 0 24 24",
                                        stroke: "currentColor"
                                      }
                                    },
                                    [
                                      _c("path", {
                                        attrs: {
                                          "stroke-linecap": "round",
                                          "stroke-linejoin": "round",
                                          "stroke-width": "2",
                                          d: "M6 18L18 6M6 6l12 12"
                                        }
                                      })
                                    ]
                                  )
                                ]
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c("hr"),
                          _vm._v(" "),
                          _c(
                            "div",
                            {
                              staticClass:
                                "p-5 flex flex-col justify-center items-center space-y-2"
                            },
                            [
                              _c(
                                "div",
                                { staticClass: "flex flex-col w-1/2" },
                                [
                                  _c(
                                    "label",
                                    {
                                      staticClass: "font-semibold",
                                      attrs: { for: "" }
                                    },
                                    [_vm._v("Category")]
                                  ),
                                  _vm._v(" "),
                                  _c("input", {
                                    directives: [
                                      {
                                        name: "model",
                                        rawName: "v-model",
                                        value: _vm.category,
                                        expression: "category"
                                      }
                                    ],
                                    staticClass: "form",
                                    attrs: { type: "text" },
                                    domProps: { value: _vm.category },
                                    on: {
                                      input: function($event) {
                                        if ($event.target.composing) {
                                          return
                                        }
                                        _vm.category = $event.target.value
                                      }
                                    }
                                  }),
                                  _vm._v(" "),
                                  _c(
                                    "transition",
                                    {
                                      attrs: {
                                        "enter-active-class":
                                          "ease-in duration-300",
                                        "enter-class": "opacity-0 ",
                                        "enter-to-class": "opacity-100",
                                        "leave-active-class":
                                          "ease-out duration-500",
                                        "leave-class": "opacity-100",
                                        "leave-to-class": "opacity-0"
                                      }
                                    },
                                    [
                                      _vm.errors.category
                                        ? _c("Error", {
                                            attrs: {
                                              message: _vm.errors.category[0]
                                            }
                                          })
                                        : _vm._e()
                                    ],
                                    1
                                  )
                                ],
                                1
                              ),
                              _vm._v(" "),
                              !_vm.editMode
                                ? _c(
                                    "div",
                                    { staticClass: "flex flex-col w-1/2" },
                                    [
                                      _c(
                                        "label",
                                        {
                                          staticClass: "font-semibold",
                                          attrs: { for: "" }
                                        },
                                        [_vm._v("Image")]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "div",
                                        {
                                          staticClass:
                                            "flex items-center space-x-6 mt-2 "
                                        },
                                        [
                                          _c(
                                            "div",
                                            { staticClass: "shrink-0" },
                                            [
                                              _vm.preview
                                                ? _c("img", {
                                                    staticClass:
                                                      "h-16 w-16 object-cover rounded-full",
                                                    attrs: {
                                                      src: _vm.preview,
                                                      alt:
                                                        "Current profile photo"
                                                    }
                                                  })
                                                : _c("img", {
                                                    staticClass:
                                                      "h-16 w-16 object-cover rounded-full",
                                                    attrs: {
                                                      src:
                                                        _vm.$root.path +
                                                        "noimage.png",
                                                      alt:
                                                        "Current profile photo"
                                                    }
                                                  })
                                            ]
                                          ),
                                          _vm._v(" "),
                                          _c(
                                            "label",
                                            {
                                              staticClass:
                                                "block cursor-pointer"
                                            },
                                            [
                                              _c(
                                                "span",
                                                { staticClass: "sr-only" },
                                                [_vm._v("Choose profile photo")]
                                              ),
                                              _vm._v(" "),
                                              _c("input", {
                                                ref: "category_image",
                                                staticClass:
                                                  "block w-full text-sm text-gray-500\n                                                   file:mr-4 file:py-2 file:px-2\n                                                   file:rounded-full file:border-0\n                                                   file:text-sm file:font-semibold\n                                                   file:bg-orange-50 file:text-orange-600\n                                                   hover:file:bg-orange-100\n                                                   ",
                                                attrs: { type: "file" },
                                                on: {
                                                  change: _vm.handleFileChange
                                                }
                                              })
                                            ]
                                          )
                                        ]
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "transition",
                                        {
                                          attrs: {
                                            "enter-active-class":
                                              "ease-in duration-300",
                                            "enter-class": "opacity-0 ",
                                            "enter-to-class": "opacity-100",
                                            "leave-active-class":
                                              "ease-out duration-500",
                                            "leave-class": "opacity-100",
                                            "leave-to-class": "opacity-0"
                                          }
                                        },
                                        [
                                          _vm.errors.image
                                            ? _c("Error", {
                                                attrs: {
                                                  message: _vm.errors.image[0]
                                                }
                                              })
                                            : _vm._e()
                                        ],
                                        1
                                      )
                                    ],
                                    1
                                  )
                                : _vm._e()
                            ]
                          ),
                          _vm._v(" "),
                          _c("hr"),
                          _vm._v(" "),
                          _c(
                            "div",
                            {
                              staticClass:
                                "flex justify-end items-center gap-2 p-2"
                            },
                            [
                              _c("input", {
                                staticClass: "btn-submit cursor-pointer",
                                attrs: { type: "submit", value: "Submit" }
                              }),
                              _vm._v(" "),
                              _c("input", {
                                staticClass: "btn-cancel cursor-pointer",
                                attrs: { type: "button", value: "Cancel" },
                                on: { click: _vm.closeModal }
                              })
                            ]
                          )
                        ]
                      )
                    ]
                  )
                : _vm._e()
            ]
          ),
          _vm._v(" "),
          _c(
            "transition",
            {
              attrs: {
                "enter-active-class": " ease-in-out transition duration-500",
                "enter-class": "transform -translate-y-11 opacity-0 ",
                "enter-to-class": "opacity-100",
                "leave-active-class": "ease-in-out transition duration-500",
                "leave-class": " opacity-100",
                "leave-to-class": "transform -translate-y-11 opacity-0"
              }
            },
            [
              _vm.isModal2
                ? _c(
                    "div",
                    {
                      staticClass:
                        " fixed top-0 left-0 z-50 p-2 flex justify-center items-center w-full min-h-screen"
                    },
                    [
                      _c(
                        "form",
                        {
                          staticClass:
                            "sm:w-full lg:w-1/2 bg-white border rounded shadow-2xl shadow-black/20 ",
                          on: {
                            submit: function($event) {
                              $event.preventDefault()
                              return _vm.updateImage($event)
                            }
                          }
                        },
                        [
                          _c(
                            "div",
                            {
                              staticClass:
                                "p-2 flex justify-between items-center lg:text-lg sm:text-sm "
                            },
                            [
                              _c("label", { staticClass: "font-semibold " }, [
                                _vm._v("Update Global Category")
                              ]),
                              _vm._v(" "),
                              _c(
                                "a",
                                {
                                  staticClass: "transition duration-500",
                                  on: { click: _vm.closeModal2 }
                                },
                                [
                                  _c(
                                    "svg",
                                    {
                                      staticClass:
                                        "lg:h-6 lg:w-6 sm:h-5 sm:w-5 text-gray-700 hover:text-red-500",
                                      attrs: {
                                        xmlns: "http://www.w3.org/2000/svg",
                                        fill: "none",
                                        viewBox: "0 0 24 24",
                                        stroke: "currentColor"
                                      }
                                    },
                                    [
                                      _c("path", {
                                        attrs: {
                                          "stroke-linecap": "round",
                                          "stroke-linejoin": "round",
                                          "stroke-width": "2",
                                          d: "M6 18L18 6M6 6l12 12"
                                        }
                                      })
                                    ]
                                  )
                                ]
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c("hr"),
                          _vm._v(" "),
                          _c(
                            "div",
                            {
                              staticClass:
                                "p-5 flex flex-col justify-center items-center space-y-2"
                            },
                            [
                              _c(
                                "div",
                                { staticClass: "flex flex-col w-1/2" },
                                [
                                  _c(
                                    "label",
                                    {
                                      staticClass: "font-semibold",
                                      attrs: { for: "" }
                                    },
                                    [_vm._v("Image")]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    {
                                      staticClass:
                                        "flex items-center space-x-6 mt-2 "
                                    },
                                    [
                                      _c("div", { staticClass: "shrink-0" }, [
                                        _vm.preview
                                          ? _c("img", {
                                              staticClass:
                                                "h-16 w-16 object-cover rounded-full",
                                              attrs: {
                                                src: _vm.preview,
                                                alt: "Current profile photo"
                                              }
                                            })
                                          : _vm._e(),
                                        _vm._v(" "),
                                        _vm.preview2
                                          ? _c("img", {
                                              staticClass:
                                                "h-16 w-16 object-cover rounded-full",
                                              attrs: {
                                                src: _vm.preview2,
                                                alt: "Current profile photo"
                                              }
                                            })
                                          : _vm._e()
                                      ]),
                                      _vm._v(" "),
                                      _c(
                                        "label",
                                        { staticClass: "block cursor-pointer" },
                                        [
                                          _c(
                                            "span",
                                            { staticClass: "sr-only" },
                                            [_vm._v("Choose profile photo")]
                                          ),
                                          _vm._v(" "),
                                          _c("input", {
                                            ref: "category_image",
                                            staticClass:
                                              "block w-full text-sm text-gray-500\n                                                   file:mr-4 file:py-2 file:px-2\n                                                   file:rounded-full file:border-0\n                                                   file:text-sm file:font-semibold\n                                                   file:bg-orange-50 file:text-orange-600\n                                                   hover:file:bg-orange-100\n                                                   ",
                                            attrs: { type: "file" },
                                            on: { change: _vm.handleFileChange }
                                          })
                                        ]
                                      )
                                    ]
                                  )
                                ]
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c("hr"),
                          _vm._v(" "),
                          _c(
                            "div",
                            {
                              staticClass:
                                "flex justify-end items-center gap-2 p-2"
                            },
                            [
                              _c("input", {
                                staticClass:
                                  "btn-submit cursor-pointer disabled:opacity-50",
                                attrs: {
                                  type: "submit",
                                  disabled: !_vm.preview,
                                  value: "Submit"
                                }
                              }),
                              _vm._v(" "),
                              _c("input", {
                                staticClass: "btn-cancel cursor-pointer",
                                attrs: { type: "button", value: "Cancel" },
                                on: { click: _vm.closeModal2 }
                              })
                            ]
                          )
                        ]
                      )
                    ]
                  )
                : _vm._e()
            ]
          )
        ],
        1
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);