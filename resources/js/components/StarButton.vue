<template>
<div class="star-btn" @click="handleImportantChange()" :title="word.is_important ? 'Bỏ đánh dấu quan trọng' : 'Đánh dấu quan trọng'">
    <md-icon :class="{star: word.is_important}">star</md-icon>
</div>
</template>

<script>
import rf from './../requests/RequestFactory'; 

export default {
    props: {
        word: Object
    },
    data() {
        return {}
    },
    methods: {
        handleImportantChange () {
            rf.getRequest('WordRequest').changeImportant(this.$props.word.id).then(res => {
                this.$props.word = res;
                this.$emit('refresh');
            })
        }
    },
}
</script>

<style lang="scss">
.star-btn {
    display: inline;
    cursor: pointer;

}

.star {
    color: #F1E80C !important;
}
</style>
