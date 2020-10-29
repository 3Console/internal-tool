"use strict";

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _vue = _interopRequireDefault(require("vue"));

require("./common/filters");

var _veeValidate = _interopRequireWildcard(require("vee-validate"));

var _vuedraggable = _interopRequireDefault(require("vuedraggable"));

var _vueRouter = _interopRequireDefault(require("vue-router"));

var _routes = _interopRequireDefault(require("./configs/routes"));

var _vueMaterial = _interopRequireDefault(require("vue-material"));

var _vueJsModal = _interopRequireDefault(require("vue-js-modal"));

var _vueToasted = _interopRequireDefault(require("vue-toasted"));

var _vue2Dropzone = _interopRequireDefault(require("vue2-dropzone"));

require("vue2-dropzone/dist/vue2Dropzone.min.css");

require("vue-material/dist/vue-material.min.css");

var _materialDashboard = _interopRequireDefault(require("./material-dashboard"));

var _chartist = _interopRequireDefault(require("chartist"));

var _DataTable = _interopRequireDefault(require("./components/datatable/DataTable"));

require("ant-design-vue/dist/antd.css");

var _antDesignVue = _interopRequireDefault(require("ant-design-vue"));

var _vueSwal = _interopRequireDefault(require("vue-swal"));

function _getRequireWildcardCache() { if (typeof WeakMap !== "function") return null; var cache = new WeakMap(); _getRequireWildcardCache = function _getRequireWildcardCache() { return cache; }; return cache; }

function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } if (obj === null || _typeof(obj) !== "object" && typeof obj !== "function") { return { "default": obj }; } var cache = _getRequireWildcardCache(); if (cache && cache.has(obj)) { return cache.get(obj); } var newObj = {}; var hasPropertyDescriptor = Object.defineProperty && Object.getOwnPropertyDescriptor; for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) { var desc = hasPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : null; if (desc && (desc.get || desc.set)) { Object.defineProperty(newObj, key, desc); } else { newObj[key] = obj[key]; } } } newObj["default"] = obj; if (cache) { cache.set(obj, newObj); } return newObj; }

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

_vue["default"].config.silent = true;

_vue["default"].use(VueDraggable);

_vue["default"].config.productionTip = true;

_vue["default"].use(_vueSwal["default"]);

_vue["default"].use(_vueMaterial["default"]);

_vue["default"].use(_veeValidate["default"]);

_vue["default"].use(_vueJsModal["default"], {
  dialog: true
});

_vue["default"].use(_vueToasted["default"]);

_vue["default"].use(_vueRouter["default"]);

_vue["default"].use(_antDesignVue["default"]);

_vue["default"].component('data-table', _DataTable["default"]);

_vue["default"].component('vue-dropzone', _vue2Dropzone["default"]);

_vue["default"].component('draggable', _vuedraggable["default"]);

_vue["default"].use(_vueRouter["default"]);

_vue["default"].use(_materialDashboard["default"]); // Vue.use(GlobalComponents)
// Vue.use(GlobalDirectives)
// Vue.use(Notifications)
// global library setup


Object.defineProperty(_vue["default"].prototype, '$Chartist', {
  get: function get() {
    return this.$root.Chartist;
  }
});
var router = new _vueRouter["default"](_routes["default"]);
router.beforeEach(function (to, from, next) {
  document.title = 'Vocabulary Learning';

  if (to.matched.some(function (record) {
    return record.meta.requiresAuth === true;
  }) && !window.isAuthenticated) {
    return router.push({
      name: 'Login'
    });
  }

  if (to.matched.some(function (record) {
    return record.meta.requiresAuth === true;
  }) && window.isAdmin) {
    return router.push({
      path: '/admin'
    });
  }

  if (to.matched.some(function (record) {
    return record.meta.requiresAdmin === true;
  }) && !window.isAdmin) {
    if (window.isAuthenticated) {
      return router.push({
        path: '/'
      });
    } else {
      return router.push({
        name: 'Login'
      });
    }
  }

  return next();
});
router.afterEach(function (to) {
  _vue["default"].nextTick(function () {//document.getElementById('content').scrollTop = 0;
  });
});
_vue["default"].prototype.$isAuthenticated = window.isAuthenticated;
_vue["default"].prototype.$isAdmin = window.isAdmin;
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

var app = new _vue["default"]({
  router: router,
  data: {
    Chartist: _chartist["default"]
  }
}).$mount('#app');
var _default = app;
exports["default"] = _default;