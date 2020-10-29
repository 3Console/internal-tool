import Vue from 'vue';

Vue.filter('capitalize', function (value) {
    if (!value) return ''
    value = value.toString().toLowerCase().trim();
    return value.charAt(0).toUpperCase() + value.slice(1)
})

Vue.filter('uppercase', function (value) {
    if (!value) return ''
    return value.toUpperCase();
})

Vue.filter('formatPriorityToPercent', function (value) {
    if(value >= 0) {
        return 0;
    } else if(value >= -5) {
        return (Math.abs(value)/ 5) * 100;
    } else {
        return 100;
    }
});

Vue.filter('toIpa', function(value) {
    // return TextToIPA.lookup(value);
});