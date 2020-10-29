"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _LoginPage = _interopRequireDefault(require("@/pages/LoginPage.vue"));

var _DashboardLayout = _interopRequireDefault(require("@/pages/admin/Layout/DashboardLayout.vue"));

var _Dashboard = _interopRequireDefault(require("@/pages/admin/Dashboard.vue"));

var _Student = _interopRequireDefault(require("@/pages/admin/Student.vue"));

var _DashboardLayout2 = _interopRequireDefault(require("@/pages/user/Layout/DashboardLayout.vue"));

var _Dashboard2 = _interopRequireDefault(require("@/pages/user/Dashboard.vue"));

var _UserProfile = _interopRequireDefault(require("@/pages/user/UserProfile.vue"));

var _WordList = _interopRequireDefault(require("@/pages/user/WordList.vue"));

var _Category = _interopRequireDefault(require("@/pages/user/Category.vue"));

var _MemoryGame = _interopRequireDefault(require("@/pages/user/MemoryGame.vue"));

var _MemoryGame2 = _interopRequireDefault(require("@/pages/user/MemoryGame2.vue"));

var _Phrase = _interopRequireDefault(require("@/pages/user/Phrase.vue"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

var _default = {
  mode: 'history',
  routes: [{
    path: '/login',
    name: 'Login',
    component: _LoginPage["default"]
  }, {
    path: '/',
    component: _DashboardLayout2["default"],
    redirect: '/',
    children: [{
      path: '/',
      name: 'Dashboard',
      component: _Dashboard2["default"]
    }, {
      path: 'word-list',
      name: 'WordList',
      component: _WordList["default"]
    }, {
      path: 'user',
      name: 'User Profile',
      component: _UserProfile["default"],
      meta: {
        requiresAuth: false
      }
    }, {
      path: 'category',
      name: 'Category',
      component: _Category["default"]
    }, {
      path: 'category/phrase',
      name: 'Phrase',
      component: _Phrase["default"]
    }, {
      path: 'memory-game',
      name: 'MemoryGame',
      component: _MemoryGame["default"]
    }, {
      path: 'memory-game2',
      name: 'MemoryGame',
      component: _MemoryGame2["default"]
    }]
  }, {
    path: '/admin',
    component: _DashboardLayout["default"],
    redirect: '/admin/dashboard',
    children: [{
      path: 'dashboard',
      name: 'Trang chủ',
      component: _Dashboard["default"],
      meta: {
        requiresAdmin: true
      }
    }, {
      path: 'student',
      name: 'Sinh viên',
      component: _Student["default"],
      meta: {
        requiresAdmin: true
      }
    }]
  }]
};
exports["default"] = _default;