<template>
<div class="hangman" style="background-color: aliceblue;">
    <div class="guess">
        <ul class="word">
            <li v-for="(character, index) in characters" :data-pos="index" class="letter">
                {{ character.isVisible  ? character.content : '*' }}
            </li>
        </ul>
    </div>
    <div class="guessForm">
        <input v-model="inputCharacter" type="text" class="guessLetter" maxlength="1" placeholder="Nhập từ . . . " />
        <button @click="submit" class="guessButton">Đoán</button>
    </div>
    <h4 class="hint"><b>Gợi ý:</b> &nbsp;{{currentWord.hint}}</h4>
    <div class="wrong">
        <ul class="wrongLetters">
            <!-- <p>Wrong Letters: </p> -->
            <li v-for="character in wrongCharacters">{{character}}</li>
        </ul>
    </div>
    <div class="message" style="display: none;">
        <h1 class="title" style="display: block;">Awesome, You Won!</h1>
        <p class="text" style="display: block;">You solved the word in <span class="highlight">13</span> Guesses!<br>Score: <span class="highlight">38%</span></p>
        <button class="restart button" style="display: inline-block;">Play Again?</button>
    </div>
</div>
</template>

<script>
export default {

    data() {
        return {
            words: [{
                word: 'Name',
                hint: 'Day la ten',
                meaning: 'Name'
            }],
            currentWord: {},
            inputCharacter: '',
            characters: [],
            wrongCharacters: []
        }
    },
    watch: {
        characters: () => {
            console.log(this.characters);
        }
    },
    methods: {
        submit() {
            let inputCharacter = this.inputCharacter.trim().toLowerCase();
            if (this.characters.find(character => character.content == inputCharacter)) {
                this.characters = [...this.characters].map(character => {
                    return {
                        content: character.content,
                        isVisible: character.content == inputCharacter || character.isVisible
                    }
                });
                this.inputCharacter = '';
                return;
            }
            if(this.wrongCharacters.indexOf(inputCharacter) == -1) {
                this.wrongCharacters.push(inputCharacter);
            }
            this.inputCharacter = '';

        }
    },
    mounted() {
        this.currentWord = this.words[0];
        this.characters = this.words[0].word.split('').map(word => {
            return {
                content: word.toLowerCase(),
                isVisible: false
            }
        });
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

.hangman {
    margin: 0 auto;
    text-align: center;
    padding: 10px;
    font-family: 'Pacifico', cursive;
    
}

h1 {
    font-size: 50px;
    margin-bottom: 20px;
    color: $blue;
    font-weight: 300;
    font-family: 'Pacifico', cursive;
}

p {
    margin-bottom: 20px;
    color: gray;
    line-height: 1.3;

}

@keyframes letteranim {
    50% {
        transform: translateY(-5px) scale(1.05);
    }
}

.letter {
    display: inline-block;
    // color: transparent;
    border-bottom: 5px solid $blue;
    margin: 0 10px;
    font-size: 50px;
    padding: 10px;
    transition: .5s;

}

.word {
    display: block;
    white-space: nowrap;
    li { text-transform: uppercase; }

}

.correct {
    color: $blue;
    text-shadow: 1px 2px 0 $drk-blue;
    animation: letteranim .3s ease;
}

.guessForm {
    margin: 20px auto 0;

    input,
    .guessButton {}

    input[type="text"] {
        outline: none;
        padding: 10px;
        font-size: 30px;
        margin-bottom: 20px;
        margin-right: 5px;
        border: 1px solid #aaa;
        color: gray;
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

    p {
        margin-bottom: 10px;
    }

    li {
        display: inline-block;
        font-size: 40px;
        background: lighten(red, 15%);
        text-shadow: 1px 2px 0 red;
        padding: 10px;
        color: white;
        margin-right: 10px;
        animation: letteranim .3s ease;
    }
}

.message {
    display: none;
    padding: 20px;
    position: absolute;
    top: 110px;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
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
.hint {
    font-family: 'Pacifico', cursive;
}
</style>
