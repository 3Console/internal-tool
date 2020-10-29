<template>
<div>
    <audio ref="background" id="background" src='/sound/background.mp3'></audio>
    <audio id="rightsound" ref="rightsound" src='/sound/right.mp3'></audio>
    <audio id="wrongsound" ref="wrongsound" src='/sound/wrong.ogg'></audio>
    <audio id="ready" ref="ready" src='/sound/ready.ogg'></audio>
    <audio id="start" ref="start" src='/sound/start.ogg'></audio>
    <!-- <audio autoplay id="intro"  ref="intro" src='/sound/intro.ogg'></audio> -->
    <audio id="start-play" ref="start-play" src='/sound/start-play.ogg'></audio>
    <audio id="gameover" ref="gameover" src='/sound/gameover.ogg'></audio>
    <div id="game">
        <div v-if="STEP == 1" class="start-screen">
            <div>
                <img @click="startGame()" class="rotating" src="/images/logo.png" />
            </div>
        </div>
        <div style="height: 725px;" v-if="STEP == 2">
            <div id="top">
                <img src="/images/logo.png" id="logo" />
                <ul id="levels">
                    <li :class="{score: score == 15}">15 - 150.000</li>
                    <li :class="{score: score == 14}">14 - 85.000</li>
                    <li :class="{score: score == 13}">13 - 60.000</li>
                    <li :class="{score: score == 12}">12 - 40.000</li>
                    <li :class="{score: score == 11}"> 11 - 30.000</li>
                    <li style="color: orange;" :class="{score: score == 10}">10 - 22.000</li>
                    <li :class="{score: score == 9}">9&nbsp&nbsp - 14.000</li>
                    <li :class="{score: score == 8}">8&nbsp&nbsp - 10.000</li>
                    <li :class="{score: score == 7}">7&nbsp&nbsp - 6.000</li>
                    <li :class="{score: score == 6}">6&nbsp&nbsp - 3.000</li>
                    <li style="color: orange;" :class="{score: score == 5}">5&nbsp&nbsp - 2.000</li>
                    <li :class="{score: score == 4}">4&nbsp&nbsp - 1.000</li>
                    <li :class="{score: score == 3}">3&nbsp&nbsp - 600</li>
                    <li :class="{score: score == 2}">2&nbsp&nbsp - 400</li>
                    <li :class="{score: score == 1}">1&nbsp&nbsp - 200</li>
                </ul>
                <div class="clear"></div>
            </div>
            <!-- <div id="options">

<div id="fifty" class="options-button" data-bind="click: fifty"></div>

<div id="phone-friend" class="options-button" data-bind="click: fadeOutOption"></div>

<div id="audience" class="options-button" data-bind="click: fadeOutOption"></div>

<div id="money">$<span data-bind="text: formatMoney()"></span></div>

</div> -->

            <div class="question-layout" v-if="this.currentQuestion">
                <div id="question-box">
                    <span class="question-content">{{this.currentQuestion['content'] ? this.currentQuestion['content'] : '' | capitalize}}</span>
                </div>
                <div id="answer-box" v-if="this.currentQuestion.options.length">
                    <div class="answer-group-1">
                        <div id="answer-one" class="answer" @click="checkResult(0)">
                            <span class="big-text">A.</span><span>{{this.currentQuestion.options[0]['content'] | capitalize}}</span>
                        </div>
                        <div id="answer-two" class="answer" @click="checkResult(1)">
                            <span class="big-text">B.</span><span>{{this.currentQuestion.options[1]['content'] | capitalize}}</span>
                        </div>
                    </div>
                    <div class="answer-group-2">
                        <div id="answer-three" class="answer" @click="checkResult(2)">
                            <span class="big-text">C.</span><span>{{this.currentQuestion.options[2]['content'] | capitalize}}</span>
                        </div>
                        <div id="answer-four" class="answer" @click="checkResult(3)">
                            <span class="big-text">D.</span><span>{{this.currentQuestion.options[3]['content'] | capitalize}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="STEP == 3" class="end-screen">
        </div>

    </div>
    <div style="height: 150px"></div>
</div>
</template>

<script>
import rf from './../../../requests/RequestFactory';

export default {
    props: {
        ids: Array
    },
    watch: {
        ids: {
            immediate: true,
            deep: true,
            handler(newValue, oldValue) {
                this.getData();
            }
        }
    },
    data() {
        return {
            STEP: 1,
            score: 0,
            currentQuestion: {},
            currentQuestionIndex: 0,
            importantQuestion: [5, 10, 15],
            questions: []
        }
    },
    methods: {
        startGame() {
            this.STEP = 2;
            this.playSound('start')
            // this.playSound('background');
        },
        gameOver() {
            this.STEP = 3;
        },
        getData() {
            rf.getRequest('GameRequest').getGame1Resource(this.$props.ids).then(res => {
                console.log(this.$props.ids)
                this.questions = res;
                this.currentQuestion = this.questions[0];
                console.log(res);
            })
        },
        checkResult(answerIndex) {
            this.stopSound('background');
            if (this.currentQuestion.options[answerIndex].correct) {

                document.getElementById(`answer-${this.indexToWord(answerIndex)}`).classList.add('correct-answer-blink');
                this.playSound('rightsound');
                this.score++;
                if (this.score == 5 || this.score == 10 || this.score == 15) {
                    this.$refs.start.play();
                }
                setTimeout(() => {
                    document.getElementById(`answer-${this.indexToWord(answerIndex)}`).classList.remove('correct-answer-blink');
                    document.getElementById(`answer-${this.indexToWord(answerIndex)}`).classList.add('correct-answer');
                    //Confirm continue model
                    setTimeout(() => {
                        this.goToNextQuestion();

                    }, 2000)
                }, 1000);
                return;
            }

            document.getElementById(`answer-${this.indexToWord(this.correctAnswerIndex())}`).classList.add('correct-answer-blink');
            setTimeout(() => {

                document.getElementById(`answer-${this.indexToWord(this.correctAnswerIndex())}`).classList.remove('correct-answer-blink');
                document.getElementById(`answer-${this.indexToWord(this.correctAnswerIndex())}`).classList.add('correct-answer');
            }, 1000);
            document.getElementById(`answer-${this.indexToWord(answerIndex)}`).classList.add('wrong-answer-blink');
            setTimeout(() => {
                document.getElementById(`answer-${this.indexToWord(answerIndex)}`).classList.remove('wrong-answer-blink');
                document.getElementById(`answer-${this.indexToWord(answerIndex)}`).classList.add('wrong-answer');
                this.playSound('gameover');
                this.gameOver();
            }, 1000);
            this.playSound('wrongsound');

        },
        goToNextQuestion() {
            this.currentQuestionIndex++;
            this.removeHighlightClass();
            this.stopSound('rightsound');
            this.playSound('ready');

            this.currentQuestion = this.questions[this.currentQuestionIndex];
            this.playSound('background');
            if (this.score == 10) {
                this.stopSound('background');
            }
        },
        playSound(ref) {
            this.$refs[ref].pause();
            this.$refs[ref].src = this.$refs[ref].src;
            this.$refs[ref].play();
        },
        stopSound(ref) {
            this.$refs[ref].pause();
            this.$refs[ref].src = this.$refs[ref].src;
        },
        correctAnswerIndex() {
            for (let i = 0; i < this.currentQuestion.options.length; i++) {
                if (this.currentQuestion.options[i].correct) {
                    return i;
                }
            }
        },
        indexToWord(index) {
            switch (index) {
                case 0:
                    return 'one';
                    break;
                case 1:
                    return 'two';
                    break;
                case 2:
                    return 'three';
                    break;
                case 3:
                    return 'four';
                    break;
                default:
                    break;
            }
        },
        removeHighlightClass() {
            for (let i = 0; i < 4; i++) {
                document.getElementById(`answer-${this.indexToWord(i)}`).classList.remove('wrong-answer');
                document.getElementById(`answer-${this.indexToWord(i)}`).classList.remove('correct-answer');
            }
        },
    },

    mounted() {
       this.getData();
    }
}
</script>

<style lang="scss">
body {
    background: black;
    font-family: 'Pacifico', cursive;
}

audio {
    display: none;
}

.clear {
    clear: both;
}

#game {
    background-image: url('/images/background.jpg');
    background-color: black;
    text-align: center;
}

.start-screen {
    height: 722px;

    img {
        width: 316px;
        margin-top: 200px;
        cursor: pointer;
    }
}

.end-screen {
    height: 722px;
}

.answer-group-2 {
    margin-top: 10px;
}

#top {
    width: 960px;
    margin: 0 auto;
}

#levels {
    float: right;
    list-style: none;
    margin: 0;
    padding: 0;
    color: white;
    text-align: right;
    margin-top: 40px;
    font-size: 1.3em;
    text-align: left;
}

#answer-one,
#answer-three {
    // margin-left: -150px;
}

#answer-two,
#answer-four {
    // margin-left: 163px;
}

.question-layout {
    height: 340px;
    width: 80%;
    margin-left: 7%;
    background-image: url(/images/game-layout.png);
    background-repeat: no-repeat;
    background-size: contain;
    font-family: 'PT Sans Narrow', sans-serif;
}

.active {
    color: green;
    font-weight: bold;
    text-decoration: underline;
}

.answer {
    width: 49%;
    display: inline-block;
}

#options {
    width: 960px;
    height: 70px;
    margin: 0 auto;
}

#question-box {
    width: 960px;
    margin: 0 auto;
    padding: 10px;
    font-size: 1.5em;
}

.question-content {
    font-size: 2.5em;
    color: #fff;
    font-family: 'Times New Roman', Times, serif;
}

.big-text {
    color: #FF7E00;
    font-size: 2em;
    margin-right: 15px;
}

#money {
    font-size: 1.9em;
    font-weight: bold;
    color: green;
    float: right;
    display: block;
    height: 50px;
    padding-top: 20px;
}

#logo {
    width: 392px;
    float: left;
    margin-left: 240px;
    margin-top: 60px;
}

#game-over {
    display: none;
    font-size: 8em;
    font-weight: bold;
    color: white;
    width: 980px;
    margin-top: 300px;
    margin: 0 auto;
    text-align: center;
}

#fifty {
    background: url('/images/50-50.png') no-repeat 0 0;
}

#phone-friend {
    background: url('/images/phone-friend.png') no-repeat 0 0;
}

#audience {
    background: url('/images/audience.png') no-repeat 0 0;
}

#answer-box {
    color: white;
    font-size: 1.3em;
    text-align: left;
    margin: 0 auto;
    margin-left: 92px;
    margin-top: 6px;
}

#pre-start {
    display: none;
}

.score {
    color: green !important;
    font-weight: bold;
}

.answer:hover {
    // text-decoration: underline;
    color: orange;
    cursor: pointer;
}

.options-button {
    width: 64px;
    height: 64px;
    margin-left: 12px;
    float: left;
    background-position: 0 0;
    cursor: pointer;
}

.options-button:hover {
    background-position: 0 -64px !important;
}

.correct-answer {
    color: green;
}

.wrong-answer {
    color: red;
}

.correct-answer-blink {
    color: green;
    animation: blinker 0.5s linear infinite;
}

.wrong-answer-blink {
    color: red;
    animation: blinker 0.5s linear infinite;
}

@keyframes blinker {
    50% {
        opacity: 0;
    }
}

#rotating {
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}
</style>
