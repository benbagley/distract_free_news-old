(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
  typeof define === 'function' && define.amd ? define(factory) :
  (global.VuePersist = factory());
}(this, (function () { 'use strict';
var index = function (Vue, ref) {
  if ( ref === void 0 ) ref = {};
  var defaultStoreName = ref.name; if ( defaultStoreName === void 0 ) defaultStoreName = 'persist:store';
  var defaultExpiration = ref.expiration;
  var read = ref.read; if ( read === void 0 ) read = function (k) { return localStorage.getItem(k); };
  var write = ref.write; if ( write === void 0 ) write = function (k, v) { return localStorage.setItem(k, v); };
  var clear = ref.clear; if ( clear === void 0 ) clear = function (k) { return localStorage.removeItem(k); };
  var cache = {};
  Vue.mixin({
    beforeCreate: function beforeCreate() {
      var this$1 = this;
      this.$persist = function (names, storeName, storeExpiration) {
        if ( storeName === void 0 ) storeName = defaultStoreName;
        if ( storeExpiration === void 0 ) storeExpiration = defaultExpiration;
        var store = cache[storeName] = JSON.parse(read(storeName) || '{}');
        store.data = store.data || {};
        if (isExpired(store.expiration)) {
          clear(storeName);
          store = {
            data: {},
            expiration: getExpiration(storeExpiration)
          };
        }
        if (!store.expiration) {
          store.expiration = getExpiration(storeExpiration);
        }
        this$1._persistWatchers = this$1._persistWatchers || [];
        var loop = function () {
          var name = list[i];
          if (typeof store.data[name] !== 'undefined') {
            this$1[name] = store.data[name];
          }
          if (this$1._persistWatchers.indexOf(name) === -1) {
            this$1._persistWatchers.push(name);
            this$1.$watch(name, function (val) {
              store.data[name] = val;
              write(storeName, JSON.stringify(store));
            }, { deep: true });
          }
        };
        for (var i = 0, list = names; i < list.length; i += 1) loop();
      };
    },
    created: function created() {
      var ref = this.$options;
      var persist = ref.persist;
      if (persist) {
        this.$persist(persist);
      }
    }
  });
};
function getExpiration(exp) {
  return exp ? Date.now() + exp : 0
}
function isExpired(exp) {
  return exp && (Date.now() > exp)
}
return index;
})));
