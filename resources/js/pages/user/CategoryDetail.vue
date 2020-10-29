<template>
<div>
    <a-page-header style="border: 1px solid rgb(235, 237, 240)" title="Danh mục từ" :subTitle="category.title" @back="() => $router.go(-1)" />

    <div class="main-content">
        <a-row style="padding-top: 20px">
            <a-col class="desc-side" :span="10">
                <div class="frame">
                    <img class="phrase-img" :src="category.cover" alt="">
                </div>
                <div class="phrase-desc hit-the-floor">
                    <h2>{{category.title}}</h2>
                </div>

                <a-button-group style="text-align: center; width: 100%;">
                    <a-button type="primary" size="large" style="background-color: #31b108;" icon="plus-circle" @click="createWord()">
                        Thêm từ
                    </a-button>
                    <a-button type="primary" size="large" style="background-color: rgb(135 106 253);" icon="eye" @click="openReviewModal()">
                        Trình chiếu
                    </a-button>
                    <a-button type="primary" size="large" style="rgb(243 162 41);" icon="trophy">
                        Trò chơi
                    </a-button>
                </a-button-group>
                <!-- 
                <div class="styles__viewBtnPlay___3lqzv" style="padding-top: 20px">
                    <div id="btnGameCenter" class="styles__button___dn9S6 effectScale">
                        <div class="styles__text___GW6do" style="visibility: visible;">Chơi trò chơi</div>
                    </div>
                </div> -->

            </a-col>
            <a-col class="word-side" :span="10">

                <a-tabs default-active-key="1">
                    <a-tab-pane key="1">
                        <span slot="tab">
                            <a-icon type="ordered-list" />
                            Tất cả
                        </span>
                        <div v-if="!words.length">
                            <a-empty description="Danh sách trống" />
                        </div>
                        <div v-else class="styles__container___AS5GT" v-for="word in words" :key="word.id">
                            <div style="margin-right: 10px;">
                                <a-tooltip>
                                    <template slot="title">
                                        Độ thông thạo {{word.priority | formatPriorityToPercent}} %
                                    </template>
                                    <a-progress type="circle" :percent="word.priority | formatPriorityToPercent" :strokeWidth="10" :width="50" />
                                </a-tooltip>
                            </div>
                            <div class="styles__center___1alr7">
                                <div class="styles__viewTitle___trc68">

                                    <SpeakButton :word="word.word" />

                                    <div class="styles__textTitle___3ne0o"><span class="styles__textHighLight___EdWX6" :title="word.hint">
                                        </span><span>{{word.word | capitalize}}</span>

                                    </div>
                                    <StarButton :word.sync="word" @refresh="refresh()" />
                                </div>
                                <div class="styles__desc___2IcIn"><span>{{word.meaning}}</span></div>
                                <div class="styles__desc___2IcIn" v-if="word.hint">Gợi ý: <span>{{word.hint}}</span></div>
                            </div>
                            <div class="styles__right___4LtJ-">
                                <!-- <div class="styles__status___2gUWg" style="background: rgb(172, 172, 172);"></div> -->
                                <img :src="word.image" alt="ambitious">
                            </div>
                        </div>
                        <div>
                        </div>
                    </a-tab-pane>
                    <a-tab-pane key="2">
                        <span slot="tab">
                            <a-icon type="star" />
                            Yêu thích
                        </span>
                        <div v-if="!words.filter(word => word.is_important).length">
                            <a-empty description="Danh sách trống" />
                        </div>
                        <div v-else class="styles__container___AS5GT" v-for="word in words.filter(word => word.is_important)">
                            <div style="margin-right: 10px;">
                                <a-tooltip>
                                    <template slot="title">
                                        Độ thông thạo {{word.priority | formatPriorityToPercent}} %
                                    </template>
                                    <a-progress type="circle" :percent="word.priority | formatPriorityToPercent" :strokeWidth="10" :width="50" />
                                </a-tooltip>
                            </div>
                            <div class="styles__center___1alr7">
                                <div class="styles__viewTitle___trc68">

                                    <SpeakButton :word="word.word" />

                                    <div class="styles__textTitle___3ne0o"><span class="styles__textHighLight___EdWX6" :title="word.hint">
                                        </span><span>{{word.word | capitalize}}</span>

                                    </div>
                                    <StarButton :word.sync="word" @refresh="refresh()" />
                                </div>
                                <div class="styles__desc___2IcIn"><span>{{word.meaning}}</span></div>
                                <div class="styles__desc___2IcIn" v-if="word.hint">Gợi ý: <span>{{word.hint}}</span></div>
                            </div>
                            <div class="styles__right___4LtJ-">
                                <!-- <div class="styles__status___2gUWg" style="background: rgb(172, 172, 172);"></div> -->
                                <img :src="word.image" alt="ambitious">
                            </div>
                        </div>
                        <div>
                        </div>
                    </a-tab-pane>
                </a-tabs>
            </a-col>
        </a-row>
        <review-modal @reload="refresh()"></review-modal>
        <WordModal2 @refresh="refresh()"></WordModal2>
    </div>
    <div class="main-content-mobile" style="display:none;">
        <a-row>
            <a-col class="desc-side-mobile" :style="{backgroundImage: `url(${category.cover})`}" :span="24">
                <div class="phrase-desc hit-the-floor">
                    <h2>{{category.title}}</h2>
                </div>
            </a-col>
        </a-row>
        <a-row>
            <a-col class="word-side-mobile" :span="24">
                <a-button-group style="text-align: center;width: 100%;">
                    <a-button type="primary"  size="large" style="background-color: #31b108;width: 33%;" icon="plus-circle" @click="createWord()">
                    </a-button>
                    <a-button type="primary" size="large" style="background-color: rgb(135 106 253);width: 33%;" icon="eye" @click="openReviewModal()">
                    </a-button>
                    <a-button type="primary" size="large" style="rgb(243 162 41);width: 33%;" icon="trophy">
                    </a-button>
                </a-button-group>
                <a-tabs default-active-key="1">
                    <a-tab-pane key="1">
                        <span slot="tab">
                            <a-icon type="ordered-list" />
                            Tất cả
                        </span>
                        <div v-if="!words.length">
                            <a-empty description="Danh sách trống" />
                        </div>
                        <div v-else class="styles__container___AS5GT" v-for="word in words" :key="word.id">
                            <div style="margin-right: 10px;">
                                <a-tooltip>
                                    <template slot="title">
                                        Độ thông thạo {{word.priority | formatPriorityToPercent}} %
                                    </template>
                                    <a-progress type="circle" :percent="word.priority | formatPriorityToPercent" :strokeWidth="10" :width="50" />
                                </a-tooltip>
                            </div>
                            <div class="styles__center___1alr7">
                                <div class="styles__viewTitle___trc68">

                                    <SpeakButton :word="word.word" />

                                    <div class="styles__textTitle___3ne0o"><span class="styles__textHighLight___EdWX6" :title="word.hint">
                                        </span><span>{{word.word | capitalize}}</span>

                                    </div>
                                    <StarButton :word.sync="word" @refresh="refresh()" />
                                </div>
                                <div class="styles__desc___2IcIn"><span>{{word.meaning}}</span></div>
                                <div class="styles__desc___2IcIn" v-if="word.hint">Gợi ý: <span>{{word.hint}}</span></div>
                            </div>
                            <div class="styles__right___4LtJ-">
                                <!-- <div class="styles__status___2gUWg" style="background: rgb(172, 172, 172);"></div> -->
                                <img :src="word.image" alt="ambitious">
                            </div>
                        </div>
                        <div>
                        </div>
                    </a-tab-pane>
                    <a-tab-pane key="2">
                        <span slot="tab">
                            <a-icon type="star" />
                            Yêu thích
                        </span>
                        <div v-if="!words.filter(word => word.is_important).length">
                            <a-empty description="Danh sách trống" />
                        </div>
                        <div v-else class="styles__container___AS5GT" v-for="word in words.filter(word => word.is_important)">
                            <div style="margin-right: 10px;">
                                <a-tooltip>
                                    <template slot="title">
                                        Độ thông thạo {{word.priority | formatPriorityToPercent}} %
                                    </template>
                                    <a-progress type="circle" :percent="word.priority | formatPriorityToPercent" :strokeWidth="10" :width="50" />
                                </a-tooltip>
                            </div>
                            <div class="styles__center___1alr7">
                                <div class="styles__viewTitle___trc68">

                                    <SpeakButton :word="word.word" />

                                    <div class="styles__textTitle___3ne0o"><span class="styles__textHighLight___EdWX6" :title="word.hint">
                                        </span><span>{{word.word | capitalize}}</span>

                                    </div>
                                    <StarButton :word.sync="word" @refresh="refresh()" />
                                </div>
                                <div class="styles__desc___2IcIn"><span>{{word.meaning}}</span></div>
                                <div class="styles__desc___2IcIn" v-if="word.hint">Gợi ý: <span>{{word.hint}}</span></div>
                            </div>
                            <div class="styles__right___4LtJ-">
                                <!-- <div class="styles__status___2gUWg" style="background: rgb(172, 172, 172);"></div> -->
                                <img :src="word.image" alt="ambitious">
                            </div>
                        </div>
                        <div>
                        </div>
                    </a-tab-pane>
                </a-tabs>
            </a-col>
        </a-row>
        <review-modal @reload="refresh()"></review-modal>
        <WordModal2 @refresh="refresh()"></WordModal2>
    </div>
</div>
</template>

<script>
import rf from './../../requests/RequestFactory';
import ReviewModal from './../../modals/Review';
import WordModal2 from './../../modals/WordModal2';
import SpeakButton from './../../components/SpeakButton';
import StarButton from './../../components/StarButton';

export default {
    components: {
        ReviewModal,
        WordModal2,
        SpeakButton,
        StarButton
    },
    data() {
        return {
            words: [],
            favouriteWords: [],
            category: {},
            seachKey: '',
            newWord: {
                word: '',
                image: '',
                hint: '',
                meaning: ''
            }
        }
    },
    methods: {
        getCategory(categoryId) {
            rf.getRequest('CategoryRequest').getCategory(categoryId).then(res => {
                this.category = res;
            })
        },
        getWordsByCategory(categoryId) {
            rf.getRequest('CategoryRequest').getWordsByCategory(categoryId).then(res => {
                this.words = res;
            })
        },
        openReviewModal() {
            this.$modal.show('review', { categoryId: this.categoryId });
        },
        onSeach(value) {
            alert(value);
        },
        createWord() {
            this.$modal.show('word2', { categoryId: this.categoryId, title: 'Thêm từ mới' });
        },
        refresh() {
            this.newWord = {
                word: '',
                image: '',
                hint: '',
                meaning: ''
            }
            this.getWordsByCategory(this.categoryId);
        }
    },
    mounted() {
        rf.getRequest('CategoryRequest').getCategoryIdBySlug(this.$route.params.slug).then(res => {
            this.categoryId = res;
            // this.$modal.show('review', { categoryId: this.categoryId });
            this.getWordsByCategory(this.categoryId);
            this.getCategory(this.categoryId);
        })

    }

}
</script>

<style lang="scss" scoped>
@media screen and (max-width: 600px) {
    .main-content {
        display: none;
    }

    .main-content-mobile {
        display: block !important;
    }

    .word-side-mobile {
        border: 1px solid rgba(99, 99, 99, 0.2);
        padding: 15px;
    }

    .desc-side-mobile {
        background-size: cover;
        background-repeat: no-repeat;
        border: 1px solid rgba(99, 99, 99, 0.2);
    }
}

.desc-side {
    padding-right: 20px;
}

.hit-the-floor {
    color: #fff;
    font-size: 12em;
    font-weight: bold;
    font-family: Helvetica;
    text-shadow:
        0 1px 0 #ccc,
        0 2px 0 #c9c9c9,
        0 3px 0 #bbb,
        0 4px 0 #b9b9b9,
        0 5px 0 #aaa,
        0 6px 1px rgba(0, 0, 0, .1),
        0 0 5px rgba(0, 0, 0, .1),
        0 1px 3px rgba(0, 0, 0, .3),
        0 3px 5px rgba(0, 0, 0, .2),
        0 5px 10px rgba(0, 0, 0, .25),
        0 10px 10px rgba(0, 0, 0, .2),
        0 20px 20px rgba(0, 0, 0, .15);
}

.star-btn {
    margin-left: 5px;
}

.main-content {
    padding: 50px;
}

.phrase-img {
    height: 300px;
    box-shadow: 5px 7px 7px rgba(0, 0, 0, 0.2);
    border: 2px solid rgba(0, 0, 0, 0.3);
    border-radius: 5px;
}

.word-side {
    border: 1px solid rgb(99 99 99 / 20%);
    padding: 34px;
    height: 550px;
    // overflow: scroll;
    min-height: 101%;
    overflow-y: scroll;
    width: 550px;
}

.phrase-desc {
    font-size: 1.1875rem;
    font-weight: 400;
    font-style: normal;
    font-stretch: normal;
    line-height: normal;
    letter-spacing: normal;
    text-align: center;
    color: whitesmoke;
}

.styles__viewBtnPlay___3lqzv {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.styles__button___dn9S6 {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 3.0625rem;
    padding: 0 2.625rem;
    border-radius: 1.5rem;
    cursor: pointer;
    position: relative;
}

.styles__text___GW6do {
    font-size: 1.1875rem;
    font-weight: 400;
    color: #fff;
    white-space: nowrap;
}

.styles__viewLoading___oTL1G {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    justify-content: center;
    align-items: center;
}

#btnGameCenter {
    background: rgb(29, 161, 242);
    box-shadow: rgba(29, 161, 242, 0.7) 0px 0px 0px 0px;
    animation: 2s cubic-bezier(0.66, 0, 0, 1) 0s infinite normal none running pulse;
    cursor: pointer;
}

.styles__container___AS5GT {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .1);
    padding: .0625rem 0;
    height: 6rem;
}

.styles__left___22i0T {
    padding: 1rem 1rem 1rem 0;
}

.styles__center___1alr7 {
    flex-grow: 1;
    width: 1%;
    padding: .25rem 0;
}

.styles__viewTitle___trc68 {
    display: flex;
    align-items: center;
}

.styles__textTitle___3ne0o {
    font-weight: 600;
    line-height: 1.5rem;
    font-size: 1.125rem;
    color: #232323;
    cursor: pointer;
}

.styles__textHighLight___EdWX6 {
    background: #fc0;
}

.styles__desc___2IcIn {
    margin-top: .5rem;
    flex-grow: 1;
    padding-right: .5rem;
    font-weight: 400;
    line-height: 1rem;
    font-size: .75rem;
    color: #8c8c8c;
}

.styles__right___4LtJ- {
    width: 62px;
    height: 62px;
    position: relative;
    background: rgba(0, 0, 0, .1);
    border-radius: 4px;
}

.styles__status___2gUWg {
    position: absolute;
    top: .25rem;
    right: .25rem;
    border: 1px solid hsla(0, 0%, 100%, .8);
    border-radius: 4px;
    width: 1rem;
    height: 1rem;
}

.styles__right___4LtJ- img {
    width: 100%;
    height: 100%;
    border-radius: 5px;
}

::-webkit-scrollbar {
    -webkit-appearance: none;
    width: 10px;
    opacity: 0.5;
}

::-webkit-scrollbar-thumb {
    border-radius: 5px;
    background: rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0 0 1px rgba(255, 255, 255, .5);
}

.frame {
    text-align: center;
}
</style>
