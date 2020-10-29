<template>
<div>
    <transition name="custom-classes-transition" enter-active-class="animated bounceInUp" leave-active-class="animated bounceOutUp">
        <div class="game-list" v-show="mode == 'list'">
            <h3>Trò chơi</h3>
            <div>
                <label class="typo__label">Trước khi bắt đầu, vui lòng chọn một hoặc nhiều danh mục từ</label>
                <multiselect v-model="selectedCategories" select-label=" Nhấn để chọn" deselect-label=" Nhấn để bỏ chọn" placeholder="Vui lòng chọn" :custom-label="titleWithCount" :close-on-select="false" style="width: 500px" label="title" track-by="id" :options="categories" :multiple="true" :taggable="true"></multiselect>
                <span>Tổng số từ được chọn: {{totalSelectedWord}}</span>
            </div>
            <br>
            <a-row>
                <a-col :span="8">
                    <a-card class="game-1" hoverable>
                        <img slot="cover" alt="example" class="game-background" src="/images/ai-la-trieu-phu-01.jpg" />
                        <template slot="actions" class="ant-card-actions">
                            <a-icon v-if="totalSelectedWord >= 15" width="3em" type="play-circle" theme="filled" @click="playGame(1)" />
                            <a-icon v-else class="lock-icon" type="lock" />
                        </template>
                        <a-card-meta title="Ai là triệu phú" description="Mô phỏng dựa trên game show Ai là triệu phú">

                        </a-card-meta>
                        <span>Yêu cầu tối thiểu: 15 từ</span>
                    </a-card>
                </a-col>
                <a-col class="game-2" :span="8">
                    <a-card hoverable>
                        <img slot="cover" alt="example" class="game-background" src="/images/mario-game.png" />
                        <template slot="actions" class="ant-card-actions">
                            <a-icon v-if="totalSelectedWord >= 5" type="play-circle" theme="filled" @click="playGame(2)" />
                            <a-icon v-else class="lock-icon" type="lock" />

                        </template>
                        <a-card-meta title="Hoàn thành từ" description="Hoàn thành từ bằng nghĩa và gợi ý">
                        </a-card-meta>
                        <span>Yêu cầu tối thiểu: 5 từ</span>
                    </a-card>
                </a-col>
                <a-col class="game-3" :span="8">
                    <a-card hoverable>
                        <img slot="cover" alt="example" class="game-background" src="/images/card-list.jpg" />
                        <template slot="actions" class="ant-card-actions">
                            <a-icon v-if="totalSelectedWord >= 8" type="play-circle" theme="filled" @click="playGame(3)" />
                            <a-icon v-else class="lock-icon" type="lock" />

                        </template>
                        <a-card-meta title="Trò chơi trí nhớ" description="Trò chơi luyện trí nhớ tìm cặp hình và từ giống nhau">
                        </a-card-meta>
                        <span>Yêu cầu tối thiểu: 8 từ</span>
                    </a-card>
                </a-col>
            </a-row>
        </div>
    </transition>
    <transition name="custom-classes-transition" enter-active-class="animated bounceInUp" leave-active-class="animated backOutUp">
        <div class="game-zone" v-show="mode == 'gamezone'">
            <Game1 v-if="currentGameId == 1" :ids="selectedIds" />
            <Game2 v-if="currentGameId == 2" :ids="selectedIds" @backToList="backToGameList()" />
            <Game3 v-if="currentGameId == 3" :ids="selectedIds" @backToList="backToGameList()" />
        </div>
    </transition>
</div>
</template>

<script>
import rf from '../../requests/RequestFactory';

import Game1 from '../user/game/Game1';
import Game2 from '../user/game/Game2';
import Game3 from '../user/game/Game3';
export default {
    components: {
        Game1,
        Game2,
        Game3
    },
    watch: {
        selectedCategories() {
            let ids = this.selectedCategories.map(category => category.id);
            this.selectedIds = ids;
            rf.getRequest('CategoryRequest').getTotalWordByCategories({ ids: ids }).then(res => {
                this.totalSelectedWord = res;
            })
        }
    },
    data() {
        return {
            selectedIds: [],
            totalSelectedWord: 0,
            selectedCategories: [

            ],
            categories: [

            ],
            mode: 'list',
            currentGameId: 0
        }
    },
    methods: {
        getCategories() {
            rf.getRequest('CategoryRequest').getCategories().then(categories => {
                this.categories = categories;
            })
        },
        titleWithCount({ title, total_word }) {
            if (total_word) {
                return `${title} [${total_word}]`
            }
        },
        playGame(gameId) {
            this.mode = '';
            setTimeout(() => {
                this.mode = 'gamezone';
            }, 1000)
            this.currentGameId = gameId;
        },
        backToGameList() {
            this.mode = '';
            setTimeout(() => {
                this.mode = 'list';
            }, 1000)
        }
    },
    mounted() {
        this.getCategories();
    },
}
</script>

<style lang="scss">
.multiselect__tag {
    background: #3d9fe8 !important;
}
</style>
<style lang="scss" scoped>
.game-zone {
    height: 700px;
}

.game-list {
    .anticon-play-circle {
        font-size: 31px !important;
        line-height: 22px;
        color: #33d433;
    }

    .lock-icon {
        font-size: 31px !important;
        color: #2b2a06;
    }

    .ant-card {
        opacity: 0.7;

        &:hover {
            opacity: 1;

            .anticon-play-circle:before {
                content: "";
                position: absolute;
                z-index: 0;
                left: 50%;
                top: 50%;
                transform: translateX(-50%) translateY(-50%);
                display: block;
                width: 50px;
                height: 50px;
                background: #73dc59;
                border-radius: 50%;
                animation: pulse-border 1500ms ease-out infinite;
            }

        }

    }
}

.game-1 {
    &:hover {
        .game-2 {

            opacity: 0.7;
        }
    }
}

@keyframes pulse-border {
    0% {
        transform: translateX(-50%) translateY(-50%) translateZ(0) scale(1);
        opacity: 1;
    }

    100% {
        transform: translateX(-50%) translateY(-50%) translateZ(0) scale(1.5);
        opacity: 0;
    }
}

.game-background {
    height: 330px;
}
</style>
