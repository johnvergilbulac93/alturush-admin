(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_foods_pages_report_TenantOrderDetails_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/report/TenantOrderDetails.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/report/TenantOrderDetails.vue?vue&type=script&lang=js& ***!
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "TenantOrderDetails",
  data: function data() {
    return {
      filter: {
        store: "all",
        dateNow: ""
      },
      currentPage: 1,
      order_list: null,
      selected_tenant: ""
    };
  },
  computed: _objectSpread({}, (0,vuex__WEBPACK_IMPORTED_MODULE_0__.mapState)(["Stores", "TenantOrderDetails", "isModal"])),
  methods: _objectSpread(_objectSpread({}, (0,vuex__WEBPACK_IMPORTED_MODULE_0__.mapActions)(["getStore", "getTenantOrderDetails", "modal"])), {}, {
    fetch: function fetch() {
      var filter = {
        store: this.filter.store,
        date: this.filter.dateNow
      };
      this.getTenantOrderDetails({
        filter: filter
      });
    },
    viewData: function viewData(detail) {
      this.selected_tenant = "".concat(detail.tenant_data.tenant, " - ").concat(detail.tenant_data.acroname);
      this.order_list = detail.orders;
      this.modal({
        flag: true
      });
    }
  }),
  mounted: function mounted() {
    this.getStore();
    this.fetch();
  },
  beforeMount: function beforeMount() {
    this.filter.dateNow = moment(this.$root.serverDateTime).format("YYYY-MM-DD");
  }
});

/***/ }),

/***/ "./resources/js/components/foods/pages/report/TenantOrderDetails.vue":
/*!***************************************************************************!*\
  !*** ./resources/js/components/foods/pages/report/TenantOrderDetails.vue ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _TenantOrderDetails_vue_vue_type_template_id_4ea4d7b9___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TenantOrderDetails.vue?vue&type=template&id=4ea4d7b9& */ "./resources/js/components/foods/pages/report/TenantOrderDetails.vue?vue&type=template&id=4ea4d7b9&");
/* harmony import */ var _TenantOrderDetails_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TenantOrderDetails.vue?vue&type=script&lang=js& */ "./resources/js/components/foods/pages/report/TenantOrderDetails.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _TenantOrderDetails_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _TenantOrderDetails_vue_vue_type_template_id_4ea4d7b9___WEBPACK_IMPORTED_MODULE_0__.render,
  _TenantOrderDetails_vue_vue_type_template_id_4ea4d7b9___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/foods/pages/report/TenantOrderDetails.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/foods/pages/report/TenantOrderDetails.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/foods/pages/report/TenantOrderDetails.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TenantOrderDetails_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TenantOrderDetails.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/report/TenantOrderDetails.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TenantOrderDetails_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/foods/pages/report/TenantOrderDetails.vue?vue&type=template&id=4ea4d7b9&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/foods/pages/report/TenantOrderDetails.vue?vue&type=template&id=4ea4d7b9& ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TenantOrderDetails_vue_vue_type_template_id_4ea4d7b9___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TenantOrderDetails_vue_vue_type_template_id_4ea4d7b9___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TenantOrderDetails_vue_vue_type_template_id_4ea4d7b9___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./TenantOrderDetails.vue?vue&type=template&id=4ea4d7b9& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/report/TenantOrderDetails.vue?vue&type=template&id=4ea4d7b9&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/report/TenantOrderDetails.vue?vue&type=template&id=4ea4d7b9&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/report/TenantOrderDetails.vue?vue&type=template&id=4ea4d7b9& ***!
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
  return _c(
    "div",
    { staticClass: "border text-gray-800 overflow-x-auto" },
    [
      _vm._m(0),
      _vm._v(" "),
      _c("div", { staticClass: "p-2" }, [
        _c("div", { staticClass: "flex justify-between items-center" }, [
          _c("div", { staticClass: "w-64" }, [
            _c(
              "select",
              {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model",
                    value: _vm.filter.store,
                    expression: "filter.store"
                  }
                ],
                staticClass: "form",
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
                        _vm.filter,
                        "store",
                        $event.target.multiple
                          ? $$selectedVal
                          : $$selectedVal[0]
                      )
                    },
                    _vm.fetch
                  ]
                }
              },
              [
                _c("option", { attrs: { value: "all" } }, [
                  _vm._v("ALL STORE")
                ]),
                _vm._v(" "),
                _vm._l(_vm.Stores, function(store, i) {
                  return _c(
                    "option",
                    { key: i, domProps: { value: store.bunit_code } },
                    [
                      _vm._v(
                        "\n                        " +
                          _vm._s(store.business_unit) +
                          "\n                    "
                      )
                    ]
                  )
                })
              ],
              2
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "w-64" }, [
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.filter.dateNow,
                  expression: "filter.dateNow"
                }
              ],
              staticClass: "form",
              attrs: { type: "date" },
              domProps: { value: _vm.filter.dateNow },
              on: {
                change: _vm.fetch,
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.$set(_vm.filter, "dateNow", $event.target.value)
                }
              }
            })
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "mt-5" }, [
          _c("label", { staticClass: "mb-1", attrs: { for: "" } }, [
            _vm._v("List of Tenant(s)")
          ]),
          _vm._v(" "),
          _c("table", { staticClass: "min-w-full divide-y divide-gray-300" }, [
            _vm._m(1),
            _vm._v(" "),
            _c(
              "tbody",
              { staticClass: "tbody" },
              _vm._l(_vm.TenantOrderDetails, function(detail, i) {
                return _c("tr", { key: i, staticClass: "tr " }, [
                  _c("td", { staticClass: "td text-left" }, [
                    _vm._v(
                      "\n                            " +
                        _vm._s(detail.tenant_data.business_unit) +
                        "\n                        "
                    )
                  ]),
                  _vm._v(" "),
                  _c("td", { staticClass: "td text-left" }, [
                    _vm._v(
                      "\n                            " +
                        _vm._s(detail.tenant_data.tenant) +
                        "\n                        "
                    )
                  ]),
                  _vm._v(" "),
                  _c("td", { staticClass: "td text-right" }, [
                    _vm._v(
                      "\n                            " +
                        _vm._s(detail.total_amt) +
                        "\n                        "
                    )
                  ]),
                  _vm._v(" "),
                  _c("td", { staticClass: "td text-center" }, [
                    _c(
                      "button",
                      {
                        staticClass:
                          "focus:outline-none  disabled:opacity-50  bg-blue-600 px-2 py-1 text-white ",
                        class:
                          detail.orders.length == 0 ? "cursor-not-allowed" : "",
                        attrs: {
                          "data-toggle": "tooltip",
                          "data-placement": "bottom",
                          title: "View",
                          disabled: detail.orders.length
                        },
                        on: {
                          click: function($event) {
                            return _vm.viewData(detail)
                          }
                        }
                      },
                      [_c("i", { staticClass: "fas fa-bars" })]
                    )
                  ])
                ])
              }),
              0
            )
          ])
        ])
      ]),
      _vm._v(" "),
      _vm.isModal
        ? _c("modal-tenant-order", {
            attrs: {
              order_list: _vm.order_list,
              selected_tenant: _vm.selected_tenant
            }
          })
        : _vm._e()
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "mb-2 bg-gray-100 p-2" }, [
      _c(
        "label",
        { staticClass: "text-lg font-semibold", attrs: { for: "" } },
        [_vm._v("Tenant Order Details")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "bg-gray-200 tracking-normal border" }, [
      _c("tr", { staticClass: "border" }, [
        _c("th", { staticClass: "p-2 border text-left" }, [_vm._v("Store")]),
        _vm._v(" "),
        _c("th", { staticClass: "p-2 border text-left" }, [_vm._v("Tenant")]),
        _vm._v(" "),
        _c("th", { staticClass: "p-2 border text-right" }, [
          _vm._v(
            "\n                            Order Total Amt.\n                        "
          )
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "p-2 border text-center" }, [_vm._v("Action")])
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);