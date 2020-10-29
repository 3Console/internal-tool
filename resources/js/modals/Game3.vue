<template>
<modal name="game3" height="300px" width="400px" @before-open="beforeOpen" @before-close="beforeClose">
    <div class="main-model">
        <h1 class="title">{{title}}</h1>
        <div class="hs-wrapper gold">
            <a class="hs-button gold">
                <span class="hs-border gold">
                    <span class="hs-text gold" @click="handlePlayAgain()">
                        Chơi lại
                    </span>
                </span>
            </a>
        </div>
    </div>
</modal>
</template>

<script>
import rf from '../requests/RequestFactory';
export default {
    data() {
        return {
            title: ''
        }
    },
    methods: {
        beforeOpen(event) {
            this.title = event.params.title;
        },
        handlePlayAgain() {
            this.$modal.hide('game3');
            this.$emit('playagain');
        },
        beforeClose() {
            this.$emit('playagain');
        },
        afterComplete(file, response) {
            // console.log(response);
        },
    }
}
</script>

<style lang="scss">
.game-zone {

    .v--modal {
        background-color: transparent !important;
    }
}
</style>
<style lang="scss" scoped>
.title {
    font-family: 'Fondamento', cursive;
    width: 300px;
    margin: 0px auto;
    text-align: center;
    font-weight: bold;
    padding-top: 28px;
}

.v--modal {
    background-color: transparent !important;
}

.main-model {
    width: 100%;
    height: 100%;
    background-image: url('https://pngimage.net/wp-content/uploads/2018/06/old-note-paper-png.png');
    background-size: cover;
}

.hs-wrapper {
    cursor: pointer;
    width: 200px;
    padding: 0 2px;
    border-right: none;
    border-left: none;
    box-shadow: 0px 1px 20px 0px rgba(0, 0, 0, 0.35);
    border-radius: 5px;
}

.hs-button {
    display: block;
    text-align: center;
    border-radius: 2px;
    border: solid 3px #795548;
}

.hs-text {
    display: table-cell;
    width: 100%;
    vertical-align: middle;
    padding: 9px 24px;
    padding: 0.6rem 1.5rem;
    text-transform: uppercase;
    font-weight: 700;
    text-shadow: 0 0 4px #000, 0 0 8px #000;
    font-size: 20px;
    font-size: 1.25rem;
    letter-spacing: 2px;
}

.hs-border {
    display: table;
    padding: 3px;
    border-radius: 2px;
    height: 35px;
    min-height: 35px;
    width: 100%;
    /* Font style */
    text-transform: uppercase;
    font-family: 'Fondamento', cursive;
    font-weight: normal;
    color: #fff;
    text-decoration: none;
    text-shadow: 1px 1px #000;
    font-size: 17px;
    line-height: 1;
    letter-spacing: 1px;
    text-align: center;
}

.hs-wrapper.gold {
    background-color: #d8be52;
    background: linear-gradient(to bottom,
            #d8be52,
            #a77d33 9%,
            #5f3f1d 93%,
            #1c140d);
    border-top: 2px solid #d8be52;
    border-bottom: 2px solid #1c140d;
    margin: 0px auto;
}

.hs-button.gold {
    background: linear-gradient(to bottom,
            #6f5742,
            #81615d);
}

.hs-text.gold {
    background: radial-gradient(circle,
            #edca37 25%,
            #a77d33 75%,
            #5f3f1d);
}

.hs-border.gold {
    background-color: #a77d33;
    box-shadow: 0px 2px 6px 0px #362c26;
    background: linear-gradient(to bottom,
            #d8be52,
            #d5b631 5%,
            #5f3f1d 59%,
            #362c26);
}

.hs-border:hover .hs-text.gold {
    background: radial-gradient(circle,
            #fed83b 22%,
            #dba23e 83%,
            #9d6224);
}
</style>
