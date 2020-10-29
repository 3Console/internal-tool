<template>
<div>
    <audio loop id="mario" ref="mario" src='/sound/mario-theme.mp3'></audio>
    <audio ref="over" src="/sound/mario-over.wav"></audio>
    <audio ref="win" src="/sound/mario-win.wav"></audio>

    <div v-show="currentScreen == 'start'" :class="{'start-screen': true}">
        <div class="shutdown" title="Trở về danh sách trò chơi" @click="backToList()">
            <img src="/images/mario-shutdown.png" alt="">
        </div>
        <h1 class="banner">Nhấn <b style="font-family: Mario;">Start</b>để bắt đầu!</h1>
        <div class="start-button" @click="start()">
            <img src="/images/mario-start.png" alt="">
        </div>
    </div>
    <div v-show="currentScreen == 'game' " :class="{mario: true, 'full-screen': fullScreen}">
        <audio id="coin" ref="coin" src='/sound/coin.mp3'></audio>
        <audio id="fail" ref="fail" src='/sound/fail.mp3'></audio>
        <audio id="die" ref="die" src='/sound/die.wav'></audio>
        <audio id="correct" ref="correct" src='/sound/mario-correct.wav'></audio>

        <div class="score">
            <div>
                <img class="mario-icon" src="/images/super-mario.png" alt="">
                <a-icon class="heart-icon" v-for="i in lifeScore" :key="i" type="heart" theme="filled" two-tone-color="#e60965" />
                <a-icon class="heart-disabled-icon" v-for="i in (5-lifeScore)" :key="i" type="heart" theme="twoTone" two-tone-color="#40012c" />
            </div>
            <div>
                <div class="shutdown" title="Trở về danh sách trò chơi" @click="backToList()">
                    <img src="/images/mario-shutdown.png" alt="">
                </div>
                <img v-if="fullScreen" @click="changeScreenMode()" class="min-icon" src="/images/min-icon.png" width="30px" height="30px" alt="">
                <img v-else @click="changeScreenMode()" class="max-icon" src="/images/max-icon.png" width="30px" height="30px" alt="">
            </div>

        </div>
        <div class="guess">
            <ul class="word">

                <li v-for="(character, index) in characters" :key="character" :class="{letter: true, 'true-letter': isCompletedWord, 'wrong-letter': isVisibleWrong, 'question-bg': !character.isVisible, 'block-bg': character.isVisible, 'jump': character.jump}" :data-pos="index" v-if="character.content != ' '">

                    <span style="left: -10px;position: relative; z-index: 0;"> {{ character.isVisible ? character.content : '&nbsp;' }}</span>
                    <img v-show="character.jump" class="mario-jump" src="/images/mario-jump.png" alt="">
                </li>
                <li v-else class="space-letter">

                </li>
            </ul>
        </div>
        <div class="guessForm">
            <div class="wrong">
                <ul class="wrongLetters">
                    <li v-for="(character, index) in shufferCharacters" :class="{shake: character.shake}" v-if="character.isVisible && character.content != ' '" @click="onSelectCharacter(character, index)" :key="character">
                        {{character.content}}
                    </li>
                </ul>
            </div>
        </div>
        <h4 class="hint">
            {{currentWord.meaning}}
            <br>
            <div v-if="currentWord.hint">
                <b>Gợi ý:</b> &nbsp;{{currentWord.hint}}
            </div>
        </h4>
        <!-- <div class="luigi-model">
            <img src="https://media1.giphy.com/media/iIGA9qQ8CaJLLmi0Bh/source.gif" alt="">
        </div> -->
        <div class="mario-model">
            <img src="/images/mario.gif" alt="">
        </div>
    </div>
    <div v-show="currentScreen == 'result-over'" :class="{'result-screen': true}">
        <div class="shutdown" title="Trở về danh sách trò chơi" @click="backToList()">
            <img src="/images/mario-shutdown.png" alt="">
        </div>
        <h1 class="banner" style="font-family: Mario">GAME <br> OVER</h1>
        <div class="replay" @click="replay()">
            <img src="/images/replay.png" alt="">
        </div>
    </div>
    <div v-show="currentScreen == 'result-win'" :class="{'result-screen': true}">
        <div class="shutdown" title="Trở về danh sách trò chơi" @click="backToList()">
            <img src="/images/mario-shutdown.png" alt="">
        </div>
        <h1 class="banner" style="font-family: Mario">YOU <br> WIN</h1>
        <div class="replay" @click="replay()">
            <img src="/images/replay.png" alt="">
        </div>
    </div>
</div>
</template>

<script>
import rf from '../../../requests/RequestFactory';
export default {
    props: {
        ids: Array
    },
    data() {
        return {
            words: [],
            currentScreen: 'start',
            currentWord: {},
            currentCorrectCharacterIndex: 0,
            currentWordIndex: 0,
            inputCharacter: '',
            characters: [],
            shufferCharacters: [],
            isWinner: false,
            isLoser: false,
            isCompletedWord: false,
            isVisibleWrong: false,
            isIncreased: false,
            lifeScore: 5,
            fullScreen: false
        }
    },
    watch: {
        inputCharacter: {
            handler() {
                this.inputCharacter = this.inputCharacter.toUpperCase();
            }
        },
        characters: {
            immediate: true,
            deep: true,
            handler(newValue, oldValue) {
                if (this.characters && this.characters.length) {
                    let isRemainingChar = !!this.characters.find((character) => {
                        return character.isVisible == false && character.content != ' ';
                    });
                    if (!isRemainingChar) {

                        this.currentWordIndex = this.currentWordIndex + 1;
                        //Win the game
                        if (!this.words[this.currentWordIndex]) {
                            this.currentScreen = 'result-win';
                            this.stopSound('mario');
                            this.playSound('win');
                            this.winGame();
                            return;
                        }
                        //Move to new word
                        this.decreasePriority([this.currentWord.id]);
                        this.isIncreased = true;
                        this.playSound('correct');
                        this.isCompletedWord = true;
                        setTimeout(() => {
                            this.currentWord = this.words[this.currentWordIndex];
                            this.isCompletedWord = false;
                        }, 2000);
                    }
                }
            }
        },
        currentWord: {
            handler() {
                this.setCharacters(this.currentWord.word);
            }
        },
        lifeScore: {
            handler() {
                if (this.lifeScore == 0) {
                    this.loseGame();
                }
            }
        }
    },
    methods: {
        playSound(ref) {
            this.$refs[ref].pause();
            this.$refs[ref].src = this.$refs[ref].src;
            this.$refs[ref].play();
        },
        stopSound(ref) {
            this.$refs[ref].pause();
            this.$refs[ref].src = this.$refs[ref].src;
        },
        increasePriority(wordIds) {
            // let wordIds = this.words.map(word => word.id);
            rf.getRequest('WordRequest').increasePriority(wordIds).then((res) => {
                console.log(res);
            })
        },
        decreasePriority(wordIds) {
            // let wordIds = this.words.map(word => word.id);
            rf.getRequest('WordRequest').decreasePriority(wordIds).then((res) => {
                console.log('Descreased');
            })
        },
        onSelectCharacter(character, index) {
            if (character.content == this.characters[this.currentCorrectCharacterIndex].content) {
                this.characters[this.currentCorrectCharacterIndex].jump = true;
                let wordIndex = Number.parseInt(this.currentCorrectCharacterIndex);
                setTimeout(() => {
                    this.characters[wordIndex].isVisible = true;
                    this.characters[wordIndex].jump = false;
                }, 500);

                this.shufferCharacters[index].isVisible = false;
                this.currentCorrectCharacterIndex++;
                this.playSound('coin');

                // this.shufferCharacters.splice(index, 1);
            } else if (this.characters[this.currentCorrectCharacterIndex].content == ' ') {
                if (character.content == this.characters[this.currentCorrectCharacterIndex + 1].content) {
                    this.characters[this.currentCorrectCharacterIndex].jump = true;

                    let wordIndex = Number.parseInt(this.currentCorrectCharacterIndex + 1);
                    setTimeout(() => {
                        this.characters[wordIndex].isVisible = true;
                        this.characters[wordIndex].jump = false;
                    }, 500);

                    this.shufferCharacters[index].isVisible = false;
                    this.currentCorrectCharacterIndex = this.currentCorrectCharacterIndex + 2;
                    this.playSound('coin');
                }
            } else {
                this.playSound('fail');
                this.shufferCharacters[index].shake = true;
                if (this.isIncreased == false) {
                    this.increasePriority([this.currentWord.id]);
                    this.isIncreased = true;
                }
                setTimeout(() => {
                    this.shufferCharacters[index].shake = false;
                }, 100)
                this.lifeScore--;

            }
        },
        setCharacters(word) {
            this.currentCorrectCharacterIndex = 0;
            this.characters = word.split('').map(word => {
                return {
                    content: word.toLowerCase(),
                    isVisible: false,
                    jump: false
                }
            });
            this.shufferCharacters = word.split('').map(word => {
                return {
                    content: word.toLowerCase(),
                    isVisible: true,
                    shake: false
                }
            }).sort(function () {
                return .5 - Math.random();
            });
        },
        changeScreenMode() {
            this.fullScreen = !this.fullScreen;
        },
        winGame() {
            this.isWinner = true;
        },
        loseGame() {
            this.playSound('die');
            this.isLoser = true;
            this.stopSound('mario');
            this.playSound('over');
            this.currentScreen = 'result-over';
        },
        resetWord() {
            this.lifeScore = 5;
            this.isVisibleWrong = false;
            this.currentCorrectCharacterIndex = 0;
        },
        showAllCharacter() {
            this.characters = this.characters.map(character => {
                character.isVisibleWrong = true;
                return character;
            });
        },
        start() {
            this.currentScreen = 'game';
            this.playSound('mario');
        },
        playAgain() {
            this.isLoser = false;
            this.isWinner = false;
            this.lifeScore = 5;
        },
        getWords(ids) {
            rf.getRequest('GameRequest').getGame2Resource(ids).then((res) => {
                this.words = res;
                this.currentWord = this.words[this.currentCorrectCharacterIndex];
                this.characters = this.setCharacters(this.currentWord.word);
            })
        },
        replay() {
            rf.getRequest('GameRequest').getGame2Resource(this.$props.ids).then((res) => {
                this.currentScreen = 'start';
                this.words = res;
                this.lifeScore = 5;
                this.currentCorrectCharacterIndex = 0;
                this.currentWordIndex = 0;
                this.currentWord = this.words[this.currentCorrectCharacterIndex];
                this.characters = this.setCharacters(this.currentWord.word);
            })
        },
        backToList() {
            this.stopSound('mario');
            this.$emit('backToList');
            this.replay();
        }
    },
    mounted() {
        this.currentScreen = 'start',
        this.getWords(this.$props.ids);
    }
}
</script>

<style lang="scss" scoped>
$blue: #53BDFF;
$green: #2EB933;
$drk-blue: darken($blue, 10%);

a {
    color: $blue;
    text-decoration: none;
    font-size: 14px;
    font-family: 'Pacifico', cursive;

    &:hover {
        color: lighten($blue, 10%);
    }
}

@keyframes pulse {
    from {
        transform: scale(0.9);
    }

    to {
        transform: scale(1.1);
    }
}

.shutdown {
    width: 60px;
    height: 60px;
    float: right;
    cursor: pointer;
}

.start-screen {
    margin: 0 auto;
    text-align: center;
    padding: 10px;
    background-color: aliceblue;
    background-image: url(/images/mario-background.jpg);
    height: 700px;
    background-size: contain;

    .banner {
        font-family: 'Pacifico', cursive;
        font-size: 70px;
        margin-top: 150px;
    }

    img {
        margin-top: 20px;
    }

    .start-button {
        animation: pulse 1.5s infinite;
    }

}

.result-screen {
    margin: 0 auto;
    text-align: center;
    padding: 10px;
    background-color: aliceblue;
    background-image: url(/images/mario-background.jpg);
    height: 700px;
    background-size: cover;

    .banner {
        font-family: 'Pacifico', cursive;
        font-size: 70px;
        margin-top: 150px;
    }

    img {
        margin-top: 20px;
    }

    .start-button {
        animation: pulse 1.5s infinite;
    }
}

.mario {
    margin: 0 auto;
    text-align: center;
    padding: 10px;
    background-color: aliceblue;
    background-image: url(/images/mario-background.jpg);
    height: 700px;
    background-size: cover;

    .score {
        float: left;
        width: 100%;
        top: 20;
        margin-left: 20px;
        margin-top: 17px;
    }

    .hint {
        width: 450px;
        margin: 0px auto;
        background-image: url(/images/hint-bg.png);
        height: 150px;
        background-size: cover;
        padding: 20px;
        color: white;
        font-size: 28px;
        box-shadow: 6px 5px 5px rgba(0, 0, 0, 0.5);
        border-radius: 2%;
        font-family: 'Pacifico', cursive;

    }

    .mario-icon {
        width: 41px;
        margin-bottom: 12px;
        float: left;
    }

    .mario-jump {
        position: relative;
        width: 50px;
        height: 67px;
        top: 89px;
        left: -46px;
        z-index: 10;
    }

    .mario-model {
        position: relative;
        width: 122px;
        bottom: 80px;
        float: left;
    }

    .luigi-model {
        position: relative;
        width: 254px;
        bottom: 90px;
        float: right;
    }

    .heart-icon {
        font-size: 25px;
        color: #e60965;
        float: left;
    }

    .heart-disabled-icon {
        font-size: 25px;
        color: #856974;
        float: left;
    }

    .max-icon {
        // margin-right: 22px;
        float: right;
        cursor: pointer;
    }

    .min-icon {
        // margin-right: 22px;
        float: right;
        cursor: pointer;
    }

    .shutdown {
        margin-right: 20px;
        width: 46px;
        margin-top: -2px;
        cursor: pointer;
    }
}

.replay {
    width: 300px;
    margin: 0px auto;
    cursor: pointer;
    animation: pulse 1.5s infinite;

}

.full-screen {
    position: absolute;
    top: 0px;
    bottom: -200px;
    right: 0px;
    left: 0px;
    height: 920px;

    .mario-model {
        position: relative;
        width: 141px;
        bottom: -20px;
        float: right;
    }
}

h1 {
    font-size: 50px;
    margin-bottom: 20px;
    color: $blue;
    font-weight: 300;
}

p {
    margin-bottom: 20px;
    color: gray;
    line-height: 1.3;

}

@keyframes shake {
    0% {
        transform: translate(0px, 0);
    }

    20% {
        transform: translate(3px, 0);
    }

    40% {
        transform: translate(6px, 0);
    }

    50% {
        transform: translate(0px, 0);
    }

    60% {
        transform: translate(-3px, 0);
    }

    80% {
        transform: translate(-6px, 0);
    }

    100% {
        transform: translate(0px, 0);
    }
}

.shake {
    transform-origin: 50% 50%;
    animation: shake .5s linear alternate !important;
}

@keyframes jump {
    0% {
        transform: translate3d(0, 0, 0) scale3d(1, 1, 1);
    }

    10% {
        transform: translate3d(0, -10%, 0) scale3d(1, 1, 1);
    }

    20% {
        transform: translate3d(0, -20%, 0) scale3d(1, 1, 1);
    }

    30% {
        transform: translate3d(0, -30%, 0) scale3d(1, 1, 1);
    }

    40% {
        transform: translate3d(0, -40%, 0) scale3d(1, 1, 1);
    }

    50% {
        transform: translate3d(0, -50%, 0) scale3d(1, 1, 1);
    }

    60% {
        transform: translate3d(0, -40%, 0) scale3d(1, 1, 1);
    }

    70% {
        transform: translate3d(0, -30%, 0) scale3d(1, 1, 1);
    }

    80% {
        transform: translate3d(0, -20%, 0) scale3d(1, 1, 1);
    }

    90% {
        transform: translate3d(0, -10%, 0) scale3d(1, 1, 1);
    }

    100% {
        transform: translate3d(0, -0%, 0) scale3d(1, 1, 1);
    }
}

.jump {
    transform-origin: 50% 50%;
    animation: jump .5s linear alternate;
}

@keyframes letteranim {
    50% {
        transform: translateY(-5px) scale(1.05);
    }
}

.letter {
    display: inline-block;
    box-shadow: 6px 5px 5px rgba(0, 0, 0, 0.5);
    margin: 0 10px;
    font-size: 50px;
    padding: 10px;
    transition: .5s;
    width: 60px;
    background-size: cover;
    font-family: "Mario", Helvetica, Arial;
    text-align: center;
    padding-left: 20px;
}

.question-bg {
    background-image: url(/images/mario-block.gif);
}

.block-bg {
    background-image: url(/images/mario-block-right.png);
}

.true-letter {
    transition: 0.7s ease-in-out;
    color: #46a727;
    border-bottom: 5px solid #17dc69db;
}

.space-letter {
    display: inline-block;
    // color: transparent;
    margin: 0 10px;
    font-size: 50px;
    padding: 10px;
    transition: .5s;
}

.word {
    display: block;
    white-space: nowrap;
    padding-left: 0px;

    li {
        text-transform: uppercase;
    }

}

.correct {
    color: $blue;
    text-shadow: 1px 2px 0 $drk-blue;
    animation: letteranim .3s ease;
}

.guess {
    margin-top: 100px;
}

.guessForm {
    margin: 20px auto 0;
    margin-top: 100px;

    .guessButton {
        font-family: 'Signika Negative', sans-serif;

    }

    input[type="text"] {
        outline: none;
        padding: 10px;
        font-size: 30px;
        margin-bottom: 20px;
        margin-right: 5px;
        border: 1px solid #aaa;
        color: gray;
        width: 170px;
        font-family: 'Signika Negative', sans-serif;
    }

    .guessButton {
        border: none;
        font-size: 30px;
        padding: 10px 20px;
        cursor: pointer;
        background: $blue;
        color: white;
        transition: .3s;
        margin: 10px 0;
        text-shadow: 1px 2px 0 $drk-blue;

        &:hover {
            background: $drk-blue;
        }
    }
}

.wrongLetters {
    font-size: 20px;
    font-family: "Mario", Helvetica, Arial;
    height: 110px;

    p {
        margin-bottom: 10px;
    }

    li {
        cursor: pointer;
        display: inline-block;
        font-size: 40px;
        background: lighten(red, 15%);
        text-shadow: 1px 2px 0 red;
        padding: 10px;
        color: white;
        margin-right: 10px;
        animation: letteranim .3s ease;
        box-shadow: 6px 5px 5px rgba(0, 0, 0, 0.5);
    }
}

.message {
    padding: 20px;
    position: absolute;
    top: 110px;
    right: 0;
    bottom: 0;
    width: 86%;
    /*   height: 100%; */
    background: darken($drk-blue, 10%);
    z-index: 12402402;

    h1 {
        display: none;
        color: white;
        text-shadow: 1px 2px 0 #ccc;
    }

    .highlight {
        color: yellow;
        text-transform: capitalize;
    }

    .text {
        color: white;
        font-size: 30px;
        display: none;

        p {
            color: white;
        }

        .highlight {
            font-size: 40px;
        }
    }

    .muted {
        margin: 20px auto;
        color: lighten($blue, 10%);
    }
}

.button {
    display: none;
    margin: 10px 0;
    border: none;
    font-size: 30px;
    padding: 10px 20px;
    cursor: pointer;
    background: lighten($green, 5%);
    color: white;
    transition: .3s;
    text-shadow: 1px 2px 0 $green;

    &:hover {
        background: lighten($green, 20%);

    }
}
</style>
