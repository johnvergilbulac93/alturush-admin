(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_foods_pages_report_SourceMostOrder_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/report/SourceMostOrder.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/report/SourceMostOrder.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************************************/
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

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "SourceMostOrder",
  data: function data() {
    return {
      filter: {
        dateFrom: "",
        dateTo: ""
      }
    };
  },
  computed: _objectSpread({}, (0,vuex__WEBPACK_IMPORTED_MODULE_0__.mapState)(["SourceMostOrder"])),
  methods: _objectSpread(_objectSpread({}, (0,vuex__WEBPACK_IMPORTED_MODULE_0__.mapActions)(["getSourceMostOrder"])), {}, {
    fetch: function fetch() {
      if (this.filter.dateFrom <= this.filter.dateTo) {
        var filter = {
          dateFrom: this.filter.dateFrom,
          dateTo: this.filter.dateTo
        };
        this.getSourceMostOrder({
          filter: filter
        });
      } else {
        swal.fire("Invalid Date!", "Please check.", "error");
      }
    },
    compute_total_num: function compute_total_num() {
      var count = 0;
      this.SourceMostOrder.forEach(function (d) {
        count += d.count;
      });
      return count;
    },
    exportToExcel: function exportToExcel(type, fn, dl) {
      var xlsName = "SOURCE-MOST-ORDER" + this.filter.dateFrom + "to" + this.filter.dateTo + ".";
      var elt = document.getElementById("exportable_table");
      var wb = XLSX.utils.table_to_book(elt, {
        sheet: "SOURCE MOST ORDER"
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
  },
  beforeMount: function beforeMount() {
    this.filter.dateFrom = moment(this.$root.serverDateTime).format("YYYY-MM-DD");
    this.filter.dateTo = moment(this.$root.serverDateTime).format("YYYY-MM-DD");
  }
});

/***/ }),

/***/ "./resources/js/components/foods/pages/report/SourceMostOrder.vue":
/*!************************************************************************!*\
  !*** ./resources/js/components/foods/pages/report/SourceMostOrder.vue ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _SourceMostOrder_vue_vue_type_template_id_1a0eade5___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SourceMostOrder.vue?vue&type=template&id=1a0eade5& */ "./resources/js/components/foods/pages/report/SourceMostOrder.vue?vue&type=template&id=1a0eade5&");
/* harmony import */ var _SourceMostOrder_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SourceMostOrder.vue?vue&type=script&lang=js& */ "./resources/js/components/foods/pages/report/SourceMostOrder.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _SourceMostOrder_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _SourceMostOrder_vue_vue_type_template_id_1a0eade5___WEBPACK_IMPORTED_MODULE_0__.render,
  _SourceMostOrder_vue_vue_type_template_id_1a0eade5___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/foods/pages/report/SourceMostOrder.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/foods/pages/report/SourceMostOrder.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************!*\
  !*** ./resources/js/components/foods/pages/report/SourceMostOrder.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SourceMostOrder_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SourceMostOrder.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/report/SourceMostOrder.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SourceMostOrder_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/foods/pages/report/SourceMostOrder.vue?vue&type=template&id=1a0eade5&":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/components/foods/pages/report/SourceMostOrder.vue?vue&type=template&id=1a0eade5& ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SourceMostOrder_vue_vue_type_template_id_1a0eade5___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SourceMostOrder_vue_vue_type_template_id_1a0eade5___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SourceMostOrder_vue_vue_type_template_id_1a0eade5___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./SourceMostOrder.vue?vue&type=template&id=1a0eade5& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/report/SourceMostOrder.vue?vue&type=template&id=1a0eade5&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/report/SourceMostOrder.vue?vue&type=template&id=1a0eade5&":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/foods/pages/report/SourceMostOrder.vue?vue&type=template&id=1a0eade5& ***!
  \**********************************************************************************************************************************************************************************************************************************************/
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
      _c("div", { staticClass: "flex justify-end items-center" }, [
        _c("div", { staticClass: "items-center flex gap-5" }, [
          _c("div", { staticClass: "w-64" }, [
            _c("label", { staticClass: "text-xs text-gray-500" }, [
              _vm._v("Filter by Date From:")
            ]),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.filter.dateFrom,
                  expression: "filter.dateFrom"
                }
              ],
              staticClass: "form",
              attrs: { type: "date" },
              domProps: { value: _vm.filter.dateFrom },
              on: {
                change: function($event) {
                  return _vm.fetch()
                },
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.$set(_vm.filter, "dateFrom", $event.target.value)
                }
              }
            })
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "w-64" }, [
            _c("label", { staticClass: "text-xs text-gray-500" }, [
              _vm._v("Filter by Date To:")
            ]),
            _vm._v(" "),
            _c("input", {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.filter.dateTo,
                  expression: "filter.dateTo"
                }
              ],
              staticClass: "form",
              attrs: { type: "date" },
              domProps: { value: _vm.filter.dateTo },
              on: {
                change: function($event) {
                  return _vm.fetch()
                },
                input: function($event) {
                  if ($event.target.composing) {
                    return
                  }
                  _vm.$set(_vm.filter, "dateTo", $event.target.value)
                }
              }
            })
          ])
        ])
      ]),
      _vm._v(" "),
      _c("hr", { staticClass: "mt-4" }),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "flex justify-end items-center mb-4 mt-2 gap-2" },
        [
          _c(
            "button",
            {
              staticClass:
                "px-2 py-1 bg-blue-500 focus:outline-none text-white hover:bg-blue-600 disabled:opacity-50",
              class: !_vm.SourceMostOrder.length ? "cursor-not-allowed" : "",
              attrs: { disabled: !_vm.SourceMostOrder.length },
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
              class: !_vm.SourceMostOrder.length ? "cursor-not-allowed" : "",
              attrs: { disabled: !_vm.SourceMostOrder.length },
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
            _vm._v("\n                LIST OF SOURCE MOST ORDER\n            ")
          ]),
          _vm._v(" "),
          _c("p", { staticClass: "font-semibold text-gray-700" }, [
            _vm._v("SUMMARY REPORT")
          ]),
          _vm._v(" "),
          _c("p", { staticClass: "text-xs" }, [
            _vm._v(
              "\n                AS OF:   " +
                _vm._s(_vm._f("formatDateNoTime")(_vm.filter.dateFrom)) +
                " To\n                " +
                _vm._s(_vm._f("formatDateNoTime")(_vm.filter.dateTo)) +
                ".\n            "
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "w-1/2 mt-2" }, [
            _c(
              "table",
              {
                staticClass: "min-w-full divide-y divide-gray-300",
                attrs: { id: "exportable_table" }
              },
              [
                _vm._m(1),
                _vm._v(" "),
                _c(
                  "tbody",
                  { staticClass: "tbody" },
                  [
                    !_vm.SourceMostOrder.length
                      ? _c("tr", [
                          _c(
                            "td",
                            {
                              staticClass: "td text-center",
                              attrs: { colspan: "2" }
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
                    _vm._l(_vm.SourceMostOrder, function(data, i) {
                      return _c("tr", { key: i }, [
                        _c("td", { staticClass: "td text-center" }, [
                          _vm._v(
                            "\n                                " +
                              _vm._s(data.source) +
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
                ),
                _vm._v(" "),
                _vm.SourceMostOrder.length
                  ? _c(
                      "tfoot",
                      { staticClass: "border bg-gray-100  tracking-normal" },
                      [
                        _c("tr", { staticClass: "border font-semibold" }, [
                          _c("td", { staticClass: "border p-2 text-center" }, [
                            _vm._v(
                              "\n                                TOTAL\n                            "
                            )
                          ]),
                          _vm._v(" "),
                          _c("td", { staticClass: "border p-2 text-center" }, [
                            _vm._v(
                              "\n                                " +
                                _vm._s(_vm.compute_total_num()) +
                                "\n                            "
                            )
                          ])
                        ])
                      ]
                    )
                  : _vm._e()
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
        [_vm._v("Source Most Order")]
      )
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", { staticClass: "border bg-gray-100  tracking-normal" }, [
      _c("tr", { staticClass: "border" }, [
        _c("th", { staticClass: "border p-2 text-center" }, [_vm._v("Source")]),
        _vm._v(" "),
        _c("th", { staticClass: "border p-2 text-center" }, [
          _vm._v(
            "\n                               Total Order(s)\n                            "
          )
        ])
      ])
    ])
  }
]
render._withStripped = true



/***/ })

}]);