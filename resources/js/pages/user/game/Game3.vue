<template>
<div :class="{game3: true, 'full-screen': fullScreen}">
    <audio id="success" ref="success" src='/sound/success.mp3'></audio>
    <audio id="error" ref="error" src='/sound/error.mp3'></audio>
    <audio loop id="harry" ref="harry" src='/sound/harryporter.mp3'></audio>
    <a-row>
        <a-col span="19" style="margin-bottom: 20px;">
            <div class="hs-wrapper silver" @click="backToGameList()">
                <a class="hs-button silver">
                    <span class="hs-border silver">
                        <span class="hs-text silver">
                            <a-icon type="left" />
                            Quay về
                        </span>
                    </span>
                </a>
            </div>
            <div style="width: 27px" class="hs-button-screen" @click="changeFullScreenMode()">
                <a-icon type="fullscreen" v-if="!fullScreen" />
                <a-icon v-else type="fullscreen-exit" />
            </div>
            <div class="container">
                <div class="timer" style="margin-bottom: 20px;">
                    <span>{{timer}}</span>
                    <a-statistic-countdown v-if="isPlaying" format="mm:ss" title="Thời gian:" :value.sync="deadline" style="margin-right: 50px; color: white !important; font-weight: bold;" @finish="onFinish" />
                    <!-- <a-button type="dashed" v-show="!isPlaying" size="large" @click="startTimer(180)">Bắt đầu</a-button> -->
                </div>
                <div class="trans-mask" @click="handleClickMask()" v-if="!isPlaying"></div>
                <ul class="deck" id="deck">
                    <li :class="{card: true, flip: wordList[0].flip || wordList[0].isDisable}" :data-card="wordList[0].word" @click="flipCard(0)">
                        <h3 v-if="wordList[0].type == 'word'" class="front-face" :style="{'font-size': getFontSize(wordList[0].word) + 'px'}">{{wordList[0].word | uppercase}}</h3>
                        <img v-else class="front-face" :src="wordList[0].image">
                        <img class="back-face" src="/images/card-back2.gif" alt="Memory Card">
                    </li>
                    <li :class="{card: true, flip: wordList[1].flip || wordList[1].isDisable}" :data-card="wordList[1].word" @click="flipCard(1)">
                        <h3 v-if="wordList[1].type == 'word'" class="front-face" :style="{'font-size': getFontSize(wordList[1].word) + 'px'}">{{wordList[1].word | uppercase}}</h3>
                        <img v-else class="front-face" :src="wordList[1].image">
                        <img class="back-face" src="/images/card-back2.gif" alt="Memory Card">
                    </li>
                    <li :class="{card: true, flip: wordList[2].flip || wordList[2].isDisable}" :data-card="wordList[2].word" @click="flipCard(2)">
                        <h3 v-if="wordList[2].type == 'word'" class="front-face" :style="{'font-size': getFontSize(wordList[2].word) + 'px'}">{{wordList[2].word | uppercase}}</h3>
                        <img v-else class="front-face" :src="wordList[2].image">
                        <img class="back-face" src="/images/card-back2.gif" alt="Memory Card">
                    </li>
                    <li :class="{card: true, flip: wordList[3].flip || wordList[3].isDisable}" :data-card="wordList[3].word" @click="flipCard(3)">
                        <h3 v-if="wordList[3].type == 'word'" class="front-face" :style="{'font-size': getFontSize(wordList[3].word) + 'px'}">{{wordList[3].word | uppercase}}</h3>
                        <img v-else class="front-face" :src="wordList[3].image">
                        <img class="back-face" src="/images/card-back2.gif" alt="Memory Card">
                    </li>
                    <li :class="{card: true, flip: wordList[4].flip || wordList[4].isDisable}" :data-card="wordList[4].word" @click="flipCard(4)">
                        <h3 v-if="wordList[4].type == 'word'" class="front-face" :style="{'font-size': getFontSize(wordList[4].word) + 'px'}">{{wordList[4].word | uppercase}}</h3>
                        <img v-else class="front-face" :src="wordList[4].image">
                        <img class="back-face" src="/images/card-back2.gif" alt="Memory Card">
                    </li>
                    <li :class="{card: true, flip: wordList[5].flip || wordList[5].isDisable}" :data-card="wordList[5].word" @click="flipCard(5)">
                        <h3 v-if="wordList[5].type == 'word'" class="front-face" :style="{'font-size': getFontSize(wordList[5].word) + 'px'}">{{wordList[5].word | uppercase}}</h3>
                        <img v-else class="front-face" :src="wordList[5].image">
                        <img class="back-face" src="/images/card-back2.gif" alt="Memory Card">
                    </li>
                    <li :class="{card: true, flip: wordList[6].flip || wordList[6].isDisable}" :data-card="wordList[6].word" @click="flipCard(6)">
                        <h3 v-if="wordList[6].type == 'word'" class="front-face" :style="{'font-size': getFontSize(wordList[6].word) + 'px'}">{{wordList[6].word | uppercase}}</h3>
                        <img v-else class="front-face" :src="wordList[6].image">
                        <img class="back-face" src="/images/card-back2.gif" alt="Memory Card">
                    </li>
                    <li :class="{card: true, flip: wordList[7].flip || wordList[7].isDisable}" :data-card="wordList[7].word" @click="flipCard(7)">
                        <h3 v-if="wordList[7].type == 'word'" class="front-face" :style="{'font-size': getFontSize(wordList[7].word) + 'px'}">{{wordList[7].word | uppercase}}</h3>
                        <img v-else class="front-face" :src="wordList[7].image">
                        <img class="back-face" src="/images/card-back2.gif" alt="Memory Card">
                    </li>
                    <li :class="{card: true, flip: wordList[8].flip || wordList[8].isDisable}" :data-card="wordList[8].word" @click="flipCard(8)">
                        <h3 v-if="wordList[8].type == 'word'" class="front-face" :style="{'font-size': getFontSize(wordList[8].word) + 'px'}">{{wordList[8].word | uppercase}}</h3>
                        <img v-else class="front-face" :src="wordList[8].image">
                        <img class="back-face" src="/images/card-back2.gif" alt="Memory Card">
                    </li>
                    <li :class="{card: true, flip: wordList[9].flip || wordList[9].isDisable}" :data-card="wordList[9].word" @click="flipCard(9)">
                        <h3 v-if="wordList[9].type == 'word'" class="front-face" :style="{'font-size': getFontSize(wordList[9].word) + 'px'}">{{wordList[9].word | uppercase}}</h3>
                        <img v-else class="front-face" :src="wordList[9].image">
                        <img class="back-face" src="/images/card-back2.gif" alt="Memory Card">
                    </li>
                    <li :class="{card: true, flip: wordList[10].flip || wordList[10].isDisable}" :data-card="wordList[10].word" @click="flipCard(10)">
                        <h3 v-if="wordList[10].type == 'word'" class="front-face" :style="{'font-size': getFontSize(wordList[10].word) + 'px'}">{{wordList[10].word | uppercase}}</h3>
                        <img v-else class="front-face" :src="wordList[10].image">
                        <img class="back-face" src="/images/card-back2.gif" alt="Memory Card">
                    </li>
                    <li :class="{card: true, flip: wordList[11].flip || wordList[11].isDisable}" :data-card="wordList[11].word" @click="flipCard(11)">
                        <h3 v-if="wordList[11].type == 'word'" class="front-face" :style="{'font-size': getFontSize(wordList[11].word) + 'px'}">{{wordList[11].word | uppercase}}</h3>
                        <img v-else class="front-face" :src="wordList[11].image">
                        <img class="back-face" src="/images/card-back2.gif" alt="Memory Card">
                    </li>
                    <li :class="{card: true, flip: wordList[12].flip || wordList[12].isDisable}" :data-card="wordList[12].word" @click="flipCard(12)">
                        <h3 v-if="wordList[12].type == 'word'" class="front-face" :style="{'font-size': getFontSize(wordList[12].word) + 'px'}">{{wordList[12].word | uppercase}}</h3>
                        <img v-else class="front-face" :src="wordList[12].image">
                        <img class="back-face" src="/images/card-back2.gif" alt="Memory Card">
                    </li>
                    <li :class="{card: true, flip: wordList[13].flip || wordList[13].isDisable}" :data-card="wordList[13].word" @click="flipCard(13)">
                        <h3 v-if="wordList[13].type == 'word'" class="front-face" :style="{'font-size': getFontSize(wordList[13].word) + 'px'}">{{wordList[13].word | uppercase}}</h3>
                        <img v-else class="front-face" :src="wordList[13].image">
                        <img class="back-face" src="/images/card-back2.gif" alt="Memory Card">
                    </li>
                    <li :class="{card: true, flip: wordList[14].flip || wordList[14].isDisable}" :data-card="wordList[14].word" @click="flipCard(14)">
                        <h3 v-if="wordList[14].type == 'word'" class="front-face" :style="{'font-size': getFontSize(wordList[14].word) + 'px'}">{{wordList[14].word | uppercase}}</h3>
                        <img v-else class="front-face" :src="wordList[14].image">
                        <img class="back-face" src="/images/card-back2.gif" alt="Memory Card">
                    </li>
                    <li :class="{card: true, flip: wordList[15].flip|| wordList[15].isDisable }" :data-card="wordList[15].word" @click="flipCard(15)">
                        <h3 v-if="wordList[15].type == 'word'" class="front-face" :style="{'font-size': getFontSize(wordList[15].word) + 'px'}">{{wordList[15].word | uppercase}}</h3>
                        <img v-else class="front-face" :src="wordList[15].image">
                        <img class="back-face" src="/images/card-back2.gif" alt="Memory Card">
                    </li>
                </ul>
                <div class="treasure">
                    <img width="200px" height="200px" src="/images/treasure.gif" alt="">
                </div>
                <div class="start-btn">
                    <div v-show="!isPlaying" @click="startTimer(120)" class="hs-wrapper classic">
                        <a class="hs-button classic">
                            <span class="hs-border classic">
                                <span class="hs-text classic">
                                    Bắt đầu
                                </span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </a-col>
        <a-col span="5">
            <md-list class="md-triple-line">
                <template v-for="word in matchedWords">
                    <md-list-item class="md-list-item-content">
                        <md-avatar>
                            <img :src="word.image" :alt="word.word">
                        </md-avatar>

                        <div class="md-list-item-text">
                            <span :title="word.word | capitalize">{{word.word | capitalize}}</span>
                            <!-- <span>Nghĩa:</span> -->
                            <p>{{word.meaning}}</p>
                        </div>

                    </md-list-item>
                </template>
            </md-list>

        </a-col>
    </a-row>
    <Game3Model @playagain="playAgain()" />
</div>
</template>

<script>
import rf from '../../../requests/RequestFactory';
import SpeakButton from '../../../components/SpeakButton';
import Game3Model from '../../../modals/Game3';

export default {
    props: {
        ids: Array
    },
    components: {
        SpeakButton,
        Game3Model
    },
    data() {
        return {
            timer: '',
            wordList: [],
            words: [],
            firstCardIndex: 0,
            secondCardIndex: 0,
            isFlipped: false,
            score: 0,
            matchedWords: [],
            isPlaying: false,
            deadline: Date.now(),
            categoryIds: [],
            fullScreen: false
        }
    },
    watch: {
        watch: {
            myProp: {
                // the callback will be called immediately after the start of the observation
                immediate: true,
                handler(val, oldVal) {
                    // do your stuff
                }
            }
        },
        matchedWords() {

            if (this.matchedWords.length == 8) {
                this.loseGame();
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
        getFontSize(word) {
            return 20 + (word.length - 11) * (0.12);
        },
        handleClickMask() {
            this.$message.error('Bạn cần nhấn nút "Bắt đầu" để bắt đầu trò chơi!');
        },
        startTimer(duration) {
            this.playSound('harry');
            this.deadline = Date.now() + duration * 1000;
            this.isPlaying = true;
        },
        onFinish() {
            this.isPlaying = false;
            this.stopSound('harry');
            this.increasePriority([...this.words.map(word => word.id)]);
            this.$modal.show('game3', { title: 'Bạn đã thua cuộc' });
        },
        loseGame() {
            this.isPlaying = false;
            this.decreasePriority([...this.words.map(word => word.id)]);
            this.$modal.show('game3', { title: 'Bạn đã chiến thắng' })
        },
        changeFullScreenMode() {
            this.fullScreen = !this.fullScreen;
        },
        flipCard(wordIndex) {
            // console.log(this.wordList);
            this.wordList[wordIndex].flip = true;
            if (!this.isFlipped) {
                this.firstCardIndex = wordIndex;
                this.isFlipped = true;
                return;
            }
            this.secondCardIndex = wordIndex;
            setTimeout(() => {
                if (this.isMatch()) {
                    // this.playSound('success');
                    console.log("matched");
                    this.speakWord(this.wordList[this.firstCardIndex].word);
                    this.score++;
                    this.$swal({
                        icon: "success",
                        button: false,
                        position: 'top',
                        timer: 500,
                        className: "game-noti"
                    });
                    this.matchedWords.push(this.wordList[this.firstCardIndex]);
                    this.wordList[this.firstCardIndex].isDisable = true;
                    this.wordList[this.secondCardIndex].isDisable = true;
                    this.isFlipped = false;
                } else {
                    // this.playSound('error');
                    this.$swal({
                        position: 'top',
                        icon: "error",
                        button: false,
                        timer: 500,
                        className: "game-noti"
                    });

                    this.wordList[this.firstCardIndex].flip = false;
                    this.wordList[this.secondCardIndex].flip = false;
                    this.isFlipped = false;
                }
            }, 700);
        },

        isMatch() {
            if (this.wordList[this.firstCardIndex].type != this.wordList[this.secondCardIndex].type) {
                return this.wordList[this.firstCardIndex].word == this.wordList[this.secondCardIndex].word;
            }
            return false;
        },
        playAgain() {
            this.getWords();
            this.firstCardIndex = 0;
            this.secondCardIndex = 0;
            this.isFlipped = 0;
            this.score = 0;
            this.matchedWords = [];

        },
        getWords(categoryIds) {
            rf.getRequest('GameRequest').getGame3Resource(this.$props.ids).then(res => {
                this.words = res;
                let image = JSON.parse(JSON.stringify(res)).map(word => {
                    word.type = 'image';
                    word.flip = false;
                    word.isDisable = false;
                    return word;
                });
                let word = JSON.parse(JSON.stringify(res)).map(word => {
                    word.type = 'word';
                    word.flip = false;
                    word.isDisable = false;
                    return word;
                })

                // this.matchedWords = word;

                this.wordList = _.shuffle(word.concat(image));
            })
        },
        speakWord(word) {
            var msg = new SpeechSynthesisUtterance();
            msg.text = word;
            window.speechSynthesis.speak(msg);
        },
        backToGameList() {
            this.stopSound('harry');
            this.isPlaying = false;
            this.$emit('backToList');
        }
    },
    created() {
        this.getWords();
    },
    mounted() {
        // console.log(this.$props.ids);
        this.getWords(this.$props.ids);
    },
}
</script>

<style>
.game-noti {
    width: 148px;
    height: 149px;
    border-radius: 30%;
}

.full-screen {
    position: absolute;
    top: 0px;
    right: 0px;
    left: 0px;
    bottom: -100px;
}

.trans-mask {
    width: 650px;
    height: 580px;
    position: absolute;
    z-index: 10;
    cursor: not-allowed;
}

.swal-overlay {
    background-color: transparent;
}

.ant-statistic-content-value {
    color: white !important;
}

.ant-statistic-title {
    color: white !important;
}
</style>
<style lang="scss" scoped>
.game3 {
    background-image: url('/images/game3-bg.jpg');
    background-size: cover;
    padding: 20px;

    .start-btn {
        margin-top: 20px;
    }

    .treasure {
        position: absolute;
        left: 0px;
        bottom: -50px;
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

    .hs-button-screen {
        text-align: center;
        border-radius: 2px;
        width: 74px;
        right: -230px;
        position: absolute;
        top: 0px;
        color: white;
        font-size: 20px;
        cursor: pointer;
        z-index: 100;
        background: linear-gradient(to bottom,
                #fe8b56,
                #af3019 5%,
                #ae4305 59%,
                #91361f);
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

    /* HearthStone Classic Violet Button
–––––––––––––––––––––––––––––––––––––––––––––––––––– */
    .hs-wrapper.classic {
        background-color: #c1b3b0;
        background: linear-gradient(to bottom,
                #c1b3b0,
                #c1b3b0 9%,
                #4a3424 93%,
                #1c140d);
        border-top: 2px solid #AD9A90;
        border-bottom: 2px solid #1c140d;
    }

    .hs-button.classic {
        background: linear-gradient(to bottom,
                #6f5742,
                #81615d);
    }

    .hs-text.classic {
        background: radial-gradient(circle,
                #bc22c7 25%,
                #7c1693 75%,
                #5c1096);
    }

    .hs-border.classic {
        background-color: #BC22C7;
        box-shadow: 0px 2px 6px 0px #331e0b;
        background: linear-gradient(to bottom,
                #f756fe,
                #c84bd6 5%,
                #7305ae 59%,
                #661f91);
    }

    .hs-border:hover .hs-text.classic {
        background: radial-gradient(circle,
                #e235ee 22%,
                #981cb4);
    }

    .hs-wrapper.silver {
        background-color: #d8be52;
        background: linear-gradient(to bottom,
                #d8be52,
                #a77d33 9%,
                #5f3f1d 93%,
                #1c140d);
        border-top: 2px solid #d8be52;
        border-bottom: 2px solid #1c140d;
    }

    .hs-button.silver {
        background: linear-gradient(to bottom,
                #6f5742,
                #81615d);
    }

    .hs-text.silver {
        background: radial-gradient(circle,
                #b6c2dd 25%,
                #838da5 75%,
                #43506e);
    }

    .hs-border.silver {
        background-color: #a1b9e8;
        box-shadow: 0px 2px 6px 0px #3a4663;
        background: linear-gradient(to bottom,
                #bfcce6,
                #a1b9e8 5%,
                #43506e 59%,
                #3a4663);
    }

    .hs-border:hover .hs-text.silver {
        background: radial-gradient(circle,
                #cfdbf5 22%,
                #a3afcc 83%,
                #697da9);
    }

    .ant-statistic-content-value {
        color: white !important;
        font-family: 'Pacifico', cursive !important;

    }

    .md-list {
        background-color: transparent !important;
    }

    .md-list-item-content {
        background-image: url(/images/game3-noti.png);
        background-size: cover;

        span {
            font-family: 'Balsamiq Sans', cursive !important;
        }

    }
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

li {
    list-style: none;
    display: inline-block;
}

.deck {
    width: 600px;
    height: 600px;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 12px 15px 20px 0 rgba(46, 61, 73, 0.5);
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    margin: auto;
    font-family: 'Pacifico', cursive;
    background-image: url('/images/chess-background.jpg');
}

.card {
    width: calc(25% - 38px);
    height: calc(25% - 26px);
    margin: 15px;
    position: relative;
    transform-style: preserve-3d;
    perspective: 500px;
    transition: transform .5s;
    cursor: pointer;
}

.front-face,
.back-face {
    width: 100%;
    height: 100% !important;
    // padding: 8px;
    position: absolute;
    border-radius: 5px;
    // box-shadow: 3px 3px 5px rgba(0, 0, 0, .2);
    backface-visibility: hidden;
    text-align: center;
    word-break: break-word;
}

.card.flip {
    transform: rotateY(180deg);
}

.front-face {
    font-family: 'Balsamiq Sans', cursive;
    background-image: url('/images/card-front.png');
    transform: rotateY(180deg);
}

.modal {
    z-index: -1;
    background: rgba(0, 0, 0, .7);
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    margin: auto;
    width: 600px;
    height: 600px;
    border-radius: 10px;
    position: absolute;
    top: 0;
}

h2 {
    text-transform: uppercase;
    color: #eee;
    padding-bottom: 30px;
}
</style>
