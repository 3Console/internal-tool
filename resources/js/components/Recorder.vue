<template>
<div class="record-btn" title="Nhấn vào đây để kiểm tra kĩ năng đọc của bạn" @click="handleRecord()">
    <md-icon :class="{'recording': isRecording}">mic</md-icon>
    {{text}}
    <a-tag v-show="score" :color="scoreColor" :style="{fontWeight: 'bold'}">{{this.score}}%</a-tag>
</div>
</template>

<script>
export default {
    props: {
        word: String
    },
    watch: {
        word: {
            immediate: true,
            handler() {
                this.score = 0;
                this.scoreColor = 'inherit';
                this.text = '';
            }
        }
    },
    data() {
        return {
            isRecording: false,
            speechRecognizer: {},
            text: '',
            scoreColor: 'inherit',
            score: 0
        }
    },
    methods: {
        handleRecord() {
            this.isRecording = !this.isRecording;
            if (this.isRecording) {
                this.text = 'Đang ghi âm ...';
                this.speechRecognizer.start();
                setTimeout(() => {
                    this.stopRecord();
                }, 4000);
                var finalTranscripts = '';

                this.speechRecognizer.onresult = (event) => {
                    var interimTranscripts = '';
                    for (var i = event.resultIndex; i < event.results.length; i++) {
                        var transcript = event.results[i][0].transcript;
                        transcript.replace("\n", "<br>");
                        if (event.results[i].isFinal) {
                            finalTranscripts += transcript;
                        } else {
                            interimTranscripts += transcript;
                        }
                    }
                    this.text = finalTranscripts + interimTranscripts;
                    this.score = this.similarity(this.$props.word.toLowerCase(), this.text.toLowerCase());
                    this.scoreColor = this.getGreenToRed(this.score);
                    if (this.score == 100) {
                        this.stopRecord();
                        this.text = finalTranscripts + interimTranscripts;
                    }
                };
                this.speechRecognizer.onerror = function (event) {

                };
            } else {
                this.stopRecord();
            }
        },
        stopRecord() {
            this.speechRecognizer.stop();
            this.isRecording = false;
            if(this.text == 'Đang ghi âm ...') {
                this.text = '';
            }

        },
        similarity(s1, s2) {
            var longer = s1;
            var shorter = s2;
            if (s1.length < s2.length) {
                longer = s2;
                shorter = s1;
            }
            var longerLength = longer.length;
            if (longerLength == 0) {
                return 1.0;
            }
            return Math.floor(((longerLength - this.editDistance(longer, shorter)) / parseFloat(longerLength)) * 100);
        },
        editDistance(s1, s2) {
            s1 = s1.toLowerCase();
            s2 = s2.toLowerCase();

            var costs = new Array();
            for (var i = 0; i <= s1.length; i++) {
                var lastValue = i;
                for (var j = 0; j <= s2.length; j++) {
                    if (i == 0)
                        costs[j] = j;
                    else {
                        if (j > 0) {
                            var newValue = costs[j - 1];
                            if (s1.charAt(i - 1) != s2.charAt(j - 1))
                                newValue = Math.min(Math.min(newValue, lastValue),
                                    costs[j]) + 1;
                            costs[j - 1] = lastValue;
                            lastValue = newValue;
                        }
                    }
                }
                if (i > 0)
                    costs[s2.length] = lastValue;
            }
            return costs[s2.length];
        },
        getGreenToRed(percent) {
            let g = percent < 50 ? 255 : Math.floor(255 - (percent * 2 - 100) * 255 / 100);
            let r = percent > 50 ? 255 : Math.floor((percent * 2) * 255 / 100);
            return 'rgb(' + r + ',' + g + ',0)';
        }
    },
    mounted() {
        var speechRecognizer = new webkitSpeechRecognition() || new SpeechRecognition();
        speechRecognizer.continuous = true;
        speechRecognizer.interimResults = true;
        speechRecognizer.lang = 'en-US';
        this.speechRecognizer = speechRecognizer;
        this.text = '';
        this.score = 0;
    }
}
</script>

<style lang="scss" scoped>
.record-btn {
    cursor: pointer;
    display: inline;
}

.recording {
    color: red !important;
    animation-name: pulse;
    animation-duration: 1.5s;
    animation-iteration-count: infinite;
    animation-timing-function: linear;
    border-radius: 50%;
    cursor: pointer;
}

@keyframes pulse {
    0% {
        box-shadow: 0px 0px 5px 0px rgba(173, 0, 0, .3);
    }

    65% {
        box-shadow: 0px 0px 5px 13px rgba(173, 0, 0, .3);
    }

    90% {
        box-shadow: 0px 0px 5px 13px rgba(173, 0, 0, 0);
    }
}
</style>
