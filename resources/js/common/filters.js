import Vue from 'vue';
import moment from 'moment';

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

Vue.filter('dateFormat', function (date) {
    return moment(date, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD');
});

Vue.filter('fromNow', function (date) {
    return moment(date, 'YYYY-MM-DD HH:mm:ss').fromNow();
});
