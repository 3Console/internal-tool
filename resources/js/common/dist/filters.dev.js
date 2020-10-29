"use strict";

var _vue = _interopRequireDefault(require("vue"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

var TextToIPA = require('text-to-ipa');

_vue["default"].filter('capitalize', function (value) {
  if (!value) return '';
  value = value.toString().toLowerCase().trim();
  return value.charAt(0).toUpperCase() + value.slice(1);
});