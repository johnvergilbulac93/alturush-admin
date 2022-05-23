(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_foods_pages_report_MostCancelledItems_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/report/MostCancelledItems.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/report/MostCancelledItems.vue?vue&type=script&lang=js& ***!
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "MostCancelledItems",
  data: function data() {
    return {
      dateNow: ""
    };
  },
  computed: _objectSpread({}, (0,vuex__WEBPACK_IMPORTED_MODULE_0__.mapState)(["MostCancelledItems"])),
  methods: _objectSpread(_objectSpread({}, (0,vuex__WEBPACK_IMPORTED_MODULE_0__.mapActions)(["getMostCancelledItem"])), {}, {
    fetch: function fetch() {
      this.getMostCancelledItem();
    },
    exportToExcel: function exportToExcel(type, fn, dl) {
      var xlsName = "MOST-CANCELLED-ITEM" + this.dateNow + ".";
      var elt = document.getElementById("exportable_table");
      var wb = XLSX.utils.table_to_book(elt, {
        sheet: "MOST CANCELLED ITEM"
      });
      return dl ? XLSX.write(wb, {
        bookType: type,
        bookSST: true,
        type: "base64"
      }) : XLSX.writeFile(wb, fn || xlsName + (type || "xlsx"));
    },
    print: function print() {
      window.print();
    }
  }),
  mounted: function mounted() {
    this.fetch();
    this.dateNow = moment(this.$root.serverDateTime).format("LL");
  }
});

/***/ }),

/***/ "./resources/js/components/foods/pages/report/MostCancelledItems.vue":
/*!***************************************************************************!*\
  !*** ./resources/js/components/foods/pages/report/MostCancelledItems.vue ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _MostCancelledItems_vue_vue_type_template_id_6745402d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MostCancelledItems.vue?vue&type=template&id=6745402d& */ "./resources/js/components/foods/pages/report/MostCancelledItems.vue?vue&type=template&id=6745402d&");
/* harmony import */ var _MostCancelledItems_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MostCancelledItems.vue?vue&type=script&lang=js& */ "./resources/js/components/foods/pages/report/MostCancelledItems.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _MostCancelledItems_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _MostCancelledItems_vue_vue_type_template_id_6745402d___WEBPACK_IMPORTED_MODULE_0__.render,
  _MostCancelledItems_vue_vue_type_template_id_6745402d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/foods/pages/report/MostCancelledItems.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/foods/pages/report/MostCancelledItems.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/components/foods/pages/report/MostCancelledItems.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MostCancelledItems_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MostCancelledItems.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/report/MostCancelledItems.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MostCancelledItems_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/foods/pages/report/MostCancelledItems.vue?vue&type=template&id=6745402d&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/foods/pages/report/MostCancelledItems.vue?vue&type=template&id=6745402d& ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MostCancelledItems_vue_vue_type_template_id_6745402d___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MostCancelledItems_vue_vue_type_template_id_6745402d___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_MostCancelledItems_vue_vue_type_template_id_6745402d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MostCancelledItems.vue?vue&type=template&id=6745402d& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/report/MostCancelledItems.vue?vue&type=template&id=6745402d&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/report/MostCancelledItems.vue?vue&type=template&id=6745402d&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/report/MostCancelledItems.vue?vue&type=template&id=6745402d& ***!
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
  return _c("div", { staticClass: "border text-gray-800 overflow-x-auto" }, [
    _vm._m(0),
    _vm._v(" "),
    _c("div", { staticClass: "p-2" }, [
      _c(
        "div",
        { staticClass: "flex justify-end items-center mb-4 mt-2 gap-2" },
        [
          _c(
            "button",
            {
              staticClass:
                "px-2 py-1 bg-blue-500 focus:outline-none text-white hover:bg-blue-600 disabled:opacity-50",
              on: {
                click: function($event) {
                  return _vm.print()
                }
              }
            },
            [
              _c("i", { staticClass: "fas fa-print" }),
              _vm._v("\n                Print\n            ")
            ]
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass:
                "px-2 py-1 bg-green-500 focus:outline-none text-white hover:bg-green-600 disabled:opacity-50",
              on: {
                click: function($event) {
                  return _vm.exportToExcel("xlsx")
                }
              }
            },
            [
              _c("i", { staticClass: "far fa-file-excel" }),
              _vm._v("\n                Export Excel\n            ")
            ]
          )
        ]
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "flex flex-col items-center",
          attrs: { id: "section-to-print2" }
        },
        [
          _c("h2", { staticClass: "font-semibold text-lg " }, [
            _vm._v(
              "\n                LIST OF MOST CANCELLED ITEMS\n            "
            )
          ]),
          _vm._v(" "),
          _vm._m(1),
          _vm._v(" "),
          _c("p", { staticClass: "text-xs" }, [
            _vm._v("AS OF:   " + _vm._s(_vm.dateNow))
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "w-3/4 mt-2" }, [
            _c(
              "table",
              {
                staticClass: "min-w-full divide-y divide-gray-300",
                attrs: { id: "exportable_table" }
              },
              [
                _vm._m(2),
                _vm._v(" "),
                _c(
                  "tbody",
                  { staticClass: "tbody" },
                  [
                    !_vm.MostCancelledItems.length
                      ? _c("tr", [
                          _c(
                            "td",
                            {
                              staticClass: "border p-2 text-center",
                              attrs: { colspan: "4" }
                            },
                            [
                              _vm._v(
                                "\n                                NO RESULT FOUND\n                            "
                              )
                            ]
                          )
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _vm._l(_vm.MostCancelledItems, function(data, i) {
                      return _c("tr", { key: i }, [
                        _c("td", { staticClass: "td text-center" }, [
                          _vm._v(_vm._s(i + 1))
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "td text-left" }, [
                          _vm._v(
                            "\n                                " +
                              _vm._s(data.category_name) +
                              "\n                            "
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "td text-left" }, [
                          _vm._v(
                            "\n                                " +
                              _vm._s(data.product_name) +
                              "\n                            "
                          )
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "td text-center" }, [
                          _vm._v(_vm._s(data.count))
                        ])
                      ])
                    })
                  ],
                  2
                )
              ]
            )
          ])
        ]
      )
    ])
  ])
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
        [_vm._v("Most Cancelled Items")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("p", { staticClass: "font-semibold text-gray-700" }, [
      _c("span", [_vm._v("SUMMARY REPORT")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "border bg-gray-100  tracking-normal" }, [
      _c("tr", { staticClass: "border" }, [
        _c("th", { staticClass: "border p-2 text-center" }, [_vm._v("#")]),
        _vm._v(" "),
        _c("th", { staticClass: "border p-2 text-left" }, [_vm._v("Category")]),
        _vm._v(" "),
        _c("th", { staticClass: "border p-2 text-left" }, [
          _vm._v(
            "\n                                Description\n                            "
          )
        ]),
        _vm._v(" "),
        _c("th", { staticClass: "border p-2 text-right" }, [
          _vm._v(
            "\n                                Total Cancelled Item(s)\n                            "
          )
        ])
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);