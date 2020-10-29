<template>
<modal name="review" class="review-modal" height="auto" width="620px" style="overflow: visible;" :scrollable="true" :click-to-close="true" @before-open="beforeOpen" @before-close="beforeClose">

    <div class="content">
        <div class="plus-btn" v-if="showAddBtn">
            <a-tooltip>
                <template slot="title">
                    Thêm từ
                </template>
                <img @click="showWordModal()" src="/images/plus.png" alt="">
            </a-tooltip>
        </div>
        <template v-else>
            <div class="tool-bar">
                <Recorder :word="currentWord['word']" />

                <StarButton :word="currentWord" @refresh="getWordsByCategory()" />

                <a-button type="primary" shape="circle" icon="drag" size="large" />

                <div class="remove-btn" title="Xoá từ này">
                    <a-button type="danger" shape="circle" icon="delete" size="large" @click="removeWord()" />
                </div>
            </div>
            <div>
                <a-row style="padding-top: 17px;">
                    <a-col :xs="{ span: 24 }" :md="{ span: 12}">

                        <template v-if="editImageMode">
                            <img class="word-img" :src="tempImageUrl ? tempImageUrl : (currentWord['image'] ? currentWord['image'] : '/images/default.jpg' )" :title="currentWord['meaning']">
                            <a-icon title="Huỷ bỏ" @click="discardImageChange" type="close-circle" theme="filled" class="discard-image-icon" />
                            <a-icon title="Lưu thay đổi" @click="saveImageChange" type="check-circle" theme="filled" class="submit-image-icon" />
                        </template>
                        <template v-else>
                            <img class="word-img" :src="currentWord['image'] ? currentWord['image'] : '/images/default.jpg'" :title="currentWord['meaning']">

                            <a-icon @click="handleEditImage()" class="camera-icon" type="camera" />
                        </template>
                        <div class="fluency-percent">
                            Thông thạo:
                            <a-progress style="width: 59%;" :stroke-color="{'0%': '#108ee9','100%': '#87d068',}" :percent="currentWord.priority | formatPriorityToPercent" status="active" />
                        </div>
                        <input type="file" ref="image" @change="onImageChange" style="display: none" />
                    </a-col>
                    <a-col :xs="{ span: 24 }" :md="{ span: 12}">
                        <h2 style="display: inline-flex">
                            <SpeakButton :word="currentWord['word']" />
                            {{currentWord['word'] | capitalize}}
                        </h2>
                        <div class="word-info">

                            <a-button v-if="editMode" type="default" shape="circle" icon="check" size="normal" style="float: right;" @click="handleEdit" />
                            <a-button v-else type="default" shape="circle" icon="edit" size="normal" style="float: right;" @click="handleEdit" />

                            <h4 v-if="!editMode">{{currentWord['meaning']}}</h4>
                            <md-field class="meaning-edit" v-else>
                                <md-input v-model="editWord.meaning" @keyup.enter="handleEdit()"></md-input>
                            </md-field>
                            <p><b v-show="currentWord.hint || editMode">Gợi ý:</b> {{editMode ? '' : currentWord['hint']}}</p>
                            <md-field class="hint-edit" v-if="editMode">
                                <md-input type="text" v-model="editWord.hint" @keyup.enter="handleEdit()"></md-input>
                            </md-field>
                        </div>
                    </a-col>
                </a-row>
            </div>
        </template>
        <!-- Left button -->
        <div v-show="(currentWordIndex != 0 || showAddBtn) && words.length" class="arrow-btn styles__viewArrow___18Fs7 styles__viewArrowLeft___OPxnB" @click="previousWord()">
            <svg class="sc-bdVaJa fUuvxv" fill="rgb(0, 0, 0)" width="2rem" height="2rem" viewBox="0 0 1024 1024" rotate="0">
                <path d="M802.8 448h-428l166-158.8c23.8-25 23.8-65.4 0-90.4s-62.4-25-86.4 0l-276.4 268c-12 11.6-18 27.4-18 44.8v0.8c0 17.4 6 33.2 18 44.8l276.2 268c24 25 62.6 25 86.4 0s23.8-65.4 0-90.4l-166-158.8h428c33.8 0 61.2-28.6 61.2-64 0.2-36-27.2-64-61-64z"></path>
            </svg>
        </div>
        <!-- Right button -->
        <div v-show="!showAddBtn" class="arrow-btn styles__viewArrow___18Fs7 styles__viewArrowRight___xJqg7" @click="nextWord()">
            <svg class="sc-bdVaJa fUuvxv" fill="rgb(0, 0, 0)" width="2rem" height="2rem" viewBox="0 0 1024 1024" rotate="0">
                <path d="M569.8 825.2l276.2-268c12-11.6 18-27.4 18-44.8v-0.8c0-17.4-6-33.2-18-44.8l-276.2-268c-24-25-62.6-25-86.4 0s-23.8 65.4 0 90.4l166 158.8h-428c-34-0-61.4 28.6-61.4 64 0 36 27.4 64 61.2 64h428l-166 158.8c-23.8 25-23.8 65.4 0 90.4 24 25 62.6 25 86.6 0z"></path>
            </svg>
        </div>
    </div>

    <div class="content-mobile" style="display: none;">
        <div class="plus-btn" v-if="showAddBtn">
            <a-tooltip>
                <template slot="title">
                    Thêm từ
                </template>
                <img @click="showWordModal()" src="/images/plus.png" alt="">
            </a-tooltip>
        </div>
        <template v-else>
            <div class="tool-bar-mobile">
                <Recorder :word="currentWord['word']" />

                <StarButton :word="currentWord" @refresh="getWordsByCategory()" />

                <a-button type="primary" shape="circle" icon="drag" size="large" />

                <div class="remove-btn" title="Xoá từ này">
                    <a-button type="danger" shape="circle" icon="delete" size="large" @click="removeWord()" />
                </div>
            </div>
            <div>
                <a-row style="padding-top: 17px;">
                    <a-col :xs="{ span: 24 }" :md="{ span: 12}">

                        <template v-if="editImageMode">
                            <img class="word-img" :src="tempImageUrl ? tempImageUrl : (currentWord['image'] ? currentWord['image'] : '/images/default.jpg' )" :title="currentWord['meaning']">
                            <a-icon title="Huỷ bỏ" @click="discardImageChange" type="close-circle" theme="filled" class="discard-image-icon" />
                            <a-icon title="Lưu thay đổi" @click="saveImageChange" type="check-circle" theme="filled" class="submit-image-icon" />
                        </template>
                        <template v-else>
                            <img class="word-img" :src="currentWord['image'] ? currentWord['image'] : '/images/default.jpg'" :title="currentWord['meaning']">

                            <a-icon @click="handleEditImage()" class="camera-icon" type="camera" />
                        </template>
                       
                        <input type="file" ref="image" @change="onImageChange" style="display: none" />
                    </a-col>
                    <a-col :xs="{ span: 24 }" :md="{ span: 12}">
                        <h2 style="display: inline-flex">
                            <SpeakButton :word="currentWord['word']" />
                            {{currentWord['word'] | capitalize}}
                        </h2>
                        <div class="word-info">

                            <a-button v-if="editMode" type="default" shape="circle" icon="check" size="normal" style="float: right;" @click="handleEdit" />
                            <a-button v-else type="default" shape="circle" icon="edit" size="normal" style="float: right;" @click="handleEdit" />

                            <h4 v-if="!editMode">{{currentWord['meaning']}}</h4>
                            <md-field class="meaning-edit" v-else>
                                <md-input v-model="editWord.meaning" @keyup.enter="handleEdit()"></md-input>
                            </md-field>
                            <p><b v-show="currentWord.hint || editMode">Gợi ý:</b> {{editMode ? '' : currentWord['hint']}}</p>
                            <md-field class="hint-edit" v-if="editMode">
                                <md-input type="text" v-model="editWord.hint" @keyup.enter="handleEdit()"></md-input>
                            </md-field>
                        </div>
                    </a-col>
                </a-row>
            </div>
        </template>
        <!-- Left button -->
        <div v-show="(currentWordIndex != 0 || showAddBtn) && words.length" class="arrow-btn styles__viewArrow___18Fs7 styles__viewArrowLeft___OPxnB" @click="previousWord()">
            <svg class="sc-bdVaJa fUuvxv" fill="rgb(0, 0, 0)" width="2rem" height="2rem" viewBox="0 0 1024 1024" rotate="0">
                <path d="M802.8 448h-428l166-158.8c23.8-25 23.8-65.4 0-90.4s-62.4-25-86.4 0l-276.4 268c-12 11.6-18 27.4-18 44.8v0.8c0 17.4 6 33.2 18 44.8l276.2 268c24 25 62.6 25 86.4 0s23.8-65.4 0-90.4l-166-158.8h428c33.8 0 61.2-28.6 61.2-64 0.2-36-27.2-64-61-64z"></path>
            </svg>
        </div>
        <!-- Right button -->
        <div v-show="!showAddBtn" class="arrow-btn styles__viewArrow___18Fs7 styles__viewArrowRight___xJqg7" @click="nextWord()">
            <svg class="sc-bdVaJa fUuvxv" fill="rgb(0, 0, 0)" width="2rem" height="2rem" viewBox="0 0 1024 1024" rotate="0">
                <path d="M569.8 825.2l276.2-268c12-11.6 18-27.4 18-44.8v-0.8c0-17.4-6-33.2-18-44.8l-276.2-268c-24-25-62.6-25-86.4 0s-23.8 65.4 0 90.4l166 158.8h-428c-34-0-61.4 28.6-61.4 64 0 36 27.4 64 61.2 64h428l-166 158.8c-23.8 25-23.8 65.4 0 90.4 24 25 62.6 25 86.6 0z"></path>
            </svg>
        </div>
    </div>

    <word-modal @created="setNewestWord()" @refresh="reload()"></word-modal>
</modal>
</template>

<script>
import rf from '../requests/RequestFactory';
import SpeakButton from '../components/SpeakButton';
import Recorder from '../components/Recorder';
import StarButton from '../components/StarButton';
import WordModal from '../modals/Word';

export default {
    components: {
        SpeakButton,
        Recorder,
        StarButton,
        WordModal
    },
    data() {
        return {
            categoryId: 1,
            category: {
                title: '',
                image: '',
                active: false,
            },
            editMode: false,
            editWord: {

            },
            words: [],
            editImageMode: false,
            tempImageUrl: '',
            tempImage: {},
            currentWordIndex: 0,
            currentWord: {},
            showAddBtn: false
        }
    },
    methods: {
        async beforeOpen(event) {
            this.categoryId = event.params.categoryId;
            await rf.getRequest('CategoryRequest').getWordsByCategory(this.categoryId).then(res => {
                this.currentWordIndex = 0;
                this.words = res;
                if (!this.words.length) {
                    this.showAddBtn = true;
                    return;
                }
                this.currentWord = res[0];
                this.showAddBtn = false;
            });
        },
        beforeClose() {},
        cancel() {
            this.$modal.hide('category');
        },
        showWordModal() {
            this.$modal.show('word', { title: 'Thêm từ mới', categoryId: this.categoryId });
        },
        nextWord() {
            this.editMode = false;
            if (this.currentWordIndex < this.words.length) {
                if (this.currentWordIndex == (this.words.length - 1)) {
                    this.showAddBtn = true;
                    return;
                }
                this.currentWordIndex++
                this.currentWord = this.words[this.currentWordIndex];
            }

        },
        previousWord() {
            this.editMode = false;
            if (this.showAddBtn) {
                this.currentWordIndex == this.words.length - 1;
                this.currentWord = this.words[this.currentWordIndex];
                this.showAddBtn = !this.showAddBtn;
                return;
            }
            this.currentWordIndex--;
            this.currentWord = this.words[this.currentWordIndex];
        },
        removeWord() {
            this.$swal({
                icon: "error",
                title: "Cảnh báo",
                text: "Bạn có chắc chắn muốn xoá từ này ?",
                buttons: true,
                dangerMode: true,
                buttons: ["Huỷ", "Xoá"],
                className: "swal-delete-word"
            }).then((value) => {
                if (value) {
                    rf.getRequest('WordRequest').removeWord(this.currentWord.id).then(res => {
                        if (this.words.length == 1) {
                            this.words = [];
                            this.showAddBtn = true;
                        } else if (this.currentWordIndex == (this.words.length - 1)) {
                            this.words = this.words.filter((_, index) => index != this.currentWordIndex);
                            this.currentWord = this.words[this.words.length - 1];
                            this.currentWordIndex = this.words.length - 1;
                            this.$emit('reload');

                            return;
                        }
                        this.words = this.words.filter((_, index) => index != this.currentWordIndex);
                        this.currentWord = this.words[this.currentWordIndex];
                        this.$emit('reload');
                    })
                }
            })

        },
        handleEdit() {
            this.editMode = !this.editMode;
            if (this.editMode) {
                this.editWord = this.currentWord;
                return;
            }

            rf.getRequest('WordRequest').updateWord(this.editWord.id, this.editWord).then(res => {
                this.currentWord = res;
            })
        },
        handleEditImage() {
            this.$refs.image.click();
        },
        onImageChange(e) {
            const file = e.target.files[0];
            this.tempImage = file;
            this.tempImageUrl = URL.createObjectURL(file);
            if (this.tempImageUrl) {
                this.editImageMode = true;

            }
        },
        discardImageChange() {
            this.editImageMode = false;
        },
        saveImageChange() {
            let formData = new FormData();
            formData.append('file', this.tempImage);
            rf.getRequest('WordRequest').updateWordImage(this.currentWord.id, formData).then(res => {
                this.currentWord.image = res.image;
                this.words[this.currentWordIndex].image = res.image;
                this.editImageMode = false;
                this.$emit('reload');
            })
        },
        getWordsByCategory() {
            this.$emit('reload');
            rf.getRequest('CategoryRequest').getWordsByCategory(this.categoryId).then(res => {
                this.words = res;
                this.currentWord = this.words[this.currentWordIndex];
            });
        },
        setNewestWord() {
            rf.getRequest('CategoryRequest').getWordsByCategory(this.categoryId).then(res => {
                this.words = res;
                this.currentWordIndex = this.words.length - 1;
                this.currentWord = this.words[this.currentWordIndex];
                this.showAddBtn = false;
            });
        },
        reload() {
            this.$emit('reload');
        }
    }
}
</script>

<style lang="scss">
.swal-delete-word {
    border: 1px solid rgb(115 59 59 / 50%) !important;
}

@media screen and (max-width: 600px) {
    .review-modal {
        .v--modal {
            width: 100vh !important;
            left: 0px !important;
        }
    }
}
</style>
<style lang="scss" scoped>
@media screen and (max-width: 600px) {
    .content {
        display: none;
    }
    .tool-bar-mobile {
        
    }
    .content-mobile {
        display: block !important;
        width: 100vh !important;
        left: 0px !important;
    }

    .review-modal {
        width: 100vh !important;
        left: 0px !important;
    }

}

.content {
    align-items: center;
    justify-content: center;
    position: relative;
    flex-direction: column;
    height: 100%;
    background: #fff;
    border-radius: 1.75rem;
    width: 38rem;
    height: 31.9375rem;
    padding: 26px;
}

.fluency-percent {
    margin: 0px auto;
    margin-left: 17px;
    margin-top: 20px;
}

@keyframes gelatine {

    from,
    to {
        transform: scale(1, 1);
    }

    25% {
        transform: scale(0.97, 1.07);
    }

    50% {
        transform: scale(1.0, 1.0);
    }

    75% {
        transform: scale(0.97, 1.05);
    }
}

.plus-btn {
    text-align: center;
    padding: 130px;
    cursor: pointer;
    animation: gelatine 0.5s;
}

.camera-icon {
    position: absolute;
    right: 23px;
    font-size: 20px;
    background: beige;
    padding: 2px;
    border-radius: 0px 0px 0px 7px;
    cursor: pointer;
    color: darkblue;
}

.submit-image-icon {
    position: absolute;
    right: 47px;
    font-size: 20px;
    background: beige;
    padding: 2px;
    cursor: pointer;
    border-radius: 0px 0px 0px 7px;
    color: #2f9a2f;
}

.discard-image-icon {
    position: absolute;
    right: 23px;
    font-size: 20px;
    background: beige;
    padding: 2px;
    cursor: pointer;
    color: red;
}

.meaning-edit {
    width: 167px;
    margin-top: -13px;

    input {
        font-size: 17px !important;
        font-weight: bold;
        width: 167px;
    }
}

.tool-bar {
    text-align: right;
}

.word-img {
    width: 15rem;
    margin-left: 15px;
    height: 20rem;
    box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.5);
    border: 0.5px solid rgba(0, 0, 0, 0.2);
}

.word-info {
    width: 14rem;
    background-color: #d8d8d8;
    height: 9rem;
    border-radius: 15px;
    color: black;
    padding: 10px;
    display: table-cell;
}

.styles__viewArrowLeft___OPxnB {
    left: 0.25rem;
}

.v--modal {
    border-radius: 1.75 rem;
}

.styles__viewArrow___18Fs7 {
    width: 3.5rem;
    height: 3.5rem;
    position: absolute;
    border-radius: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    top: 50%;
    transform: translateY(-50%);
    background-color: #d8d8d8;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .5);
}

.v--modal-box {
    overflow: visible !important;
}

.styles__viewArrowRight___xJqg7 {
    right: 0rem;
}

.arrow-btn:hover {
    box-shadow: 0 2px #666;
}

.arrow-btn :active {
    /* box-shadow: 0 2px #666;
    transform: translateY(4px); */
}

.remove-btn {
    display: inline;
}

.styles__soundIcon___3F62k {
    margin-top: 16px;
}

.hint-edit {
    margin-top: -20px;
}
</style>
