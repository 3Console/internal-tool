<template>
<div class="styles__soundIcon___3F62k" @click="speakWord()">
    <div class="styles__sound_icon___2JvL9 styles__sound_icon_auto_width___3KkW9 [object Object]"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <path fill="none" stroke="rgb(122, 199, 12)" d="M4.931 9.714l5.686-3.939v13.442L4.934 15.28H.5V9.714h4.431zm7.103-1.792l.814-.474a7.628 7.628 0 0 1 1.908 5.048 7.628 7.628 0 0 1-1.908 5.048l-.814-.474a6.702 6.702 0 0 0 1.802-4.574c0-1.77-.688-3.375-1.802-4.574zm3.806-2.21l.804-.47a11.99 11.99 0 0 1 2.43 7.254c0 2.728-.909 5.244-2.436 7.26l-.804-.467a11.06 11.06 0 0 0 2.321-6.793c0-2.556-.866-4.91-2.315-6.785zM20.496 3a16.45 16.45 0 0 1 3.004 9.496A16.45 16.45 0 0 1 20.49 22l-.8-.466a15.523 15.523 0 0 0 2.89-9.038 15.52 15.52 0 0 0-2.884-9.03l.8-.466z"></path>
        </svg></div>
</div>
</template>

<script>
export default {
    props: {
        word: String
    },
    methods: {
        speakWord() {
            var msg = new SpeechSynthesisUtterance();
            msg.text = this.$props.word;
            window.speechSynthesis.speak(msg);
        },
    },
}
</script>

<style lang="scss">
.styles__soundIcon___3F62k {
    padding-right: .5rem;
}

.styles__sound_icon___2JvL9 {
    cursor: pointer;
    display: flex;
}
</style>
