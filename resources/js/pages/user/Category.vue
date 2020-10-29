<template>
<div>
    <a-page-header style="border: 1px solid rgb(235, 237, 240)" title="Danh mục từ" sub-title="Bạn có thể thêm danh mục mới" @back="() => null" />
    <div class="category inline-flex">

        <div class="styles__container___3mCLH effectScale inline-flex" @click="createCategory()">
            <div class="styles__icon___25pzZ"><svg class="sc-bdVaJa fUuvxv" fill="#fff" width="2.2rem" height="2.2rem" viewBox="0 0 1024 1024" rotate="0">
                    <path d="M832 554.666h-277.334v277.334h-85.332v-277.334h-277.334v-85.332h277.334v-277.334h85.332v277.334h277.334v85.332z"></path>
                </svg></div>
            <div class="styles__text___NQdFz">Danh mục mới</div>
        </div>

        <div class="styles__container___16een inline-flex" @click="goToPhrase()">
            <div class="styles__overLay___2RQuM" style="background-image: url('images/book.svg');">
                <div class="styles__conName___Jiq61">
                    <div class="styles__viewName___3mvLd">Cụm từ</div>
                </div>
                <div class="styles__txtNum___3JT46">{{categories[0].total_word}} cụm từ</div>
            </div>
        </div>

        <div v-for="(category, index) in categories" :key="category.id" v-if="category.is_visible" :class="{'styles__container___2c6eo': true, 'inline-flex': true, 'last-category': (categories.length % 2 == 1 && index == categories.length - 1)}">
            <div :style="{ backgroundImage: 'url(' + (category.cover ? category.cover : 'images/default-cover.jpg')  + ')' }" :class="{styles__overLay___1WcJB : true}" @click="goToCategory(category.slug)">
                <div class="styles__conName___2JHZN">
                    <div class="styles__viewName___2PQg6">{{category.title}}</div>
                </div>
                <!-- <div class="styles__txtDate___1BKAV">{{category.created_at}}</div> -->
                <div class="styles__txtNum___39eD4">{{category.total_word}} từ</div>
            </div>
        </div>
    </div>
    <category-model @refresh="refresh()"></category-model>
</div>
</template>

<script>
import rf from './../../requests/RequestFactory';
import CategoryModel from '../../modals/Category';
export default {
    components: {
        CategoryModel
    },
    data() {
        return {
            categories: [],
            params: {}
        }
    },
    methods: {
        getCategories(params) {
            rf.getRequest('CategoryRequest').getCategories().then(res => {
                this.categories = res;
            })
        },
        createCategory() {
            this.$modal.show('category', { title: 'Thêm danh mục mới' });
        },
        goToPhrase() {
            this.$router.push({ name: 'Phrase' })
        },
        goToCategory(slug) {
            this.$router.push(`/category/${slug}`);
        },
        refresh() {
            this.getCategories();
        }
    },
    mounted() {
        this.getCategories();
    }

}
</script>

<style lang="scss" scoped>
@media screen and (max-width: 600px) {
    .category {
        height: 30rem !important;
    }

    .styles__container___16een,
    .styles__container___2c6eo {
        min-width: 50% !important;
        display: inline;
        height: 11rem !important;
        margin: 0px auto !important;
        border-radius: 0% !important;
    }
    .last-category {
        min-width: 100% !important;
    }
    .styles__viewName___3mvLd {
        font-size: 1.3rem !important;
    }

    .styles__container___3mCLH {
        // display: none !important;
        min-width: 100% !important;
        height: 6rem !important;
        margin: 0px auto !important;
        border-radius: 0% !important;
    }
}

.category {
    height: 25rem;
    width: 100%;
    flex-flow: wrap;
}

.inline-flex {
    display: inline-flex;
}

.styles__container___16een {
    min-width: 20rem;
    max-width: 29rem;
    width: 16vw;
    border-radius: .375rem;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    margin: .5rem;
    background: linear-gradient(0deg, #fec551, #fec551);
    height: 8rem;
}

.styles__overLay___2RQuM {
    width: 100%;
    height: 100%;
    background-position: 100% 100%;
    background-repeat: no-repeat;
}

.styles__conName___Jiq61 {
    display: flex;
    margin-top: .75rem;
}

.styles__viewName___3mvLd {
    padding: 0 .5rem 0 1rem;
    font-size: 2.3rem;
    font-weight: 600;
    font-style: normal;
    font-stretch: normal;
    line-height: 1.33;
    letter-spacing: normal;
    text-align: left;
    color: #fff;
    max-width: 12rem;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
}

.styles__txtNum___3JT46 {
    font-size: 12px;
    font-weight: bold;
    font-style: normal;
    font-stretch: normal;
    line-height: 1.33;
    letter-spacing: normal;
    text-align: left;
    color: #fff;
}

.styles__txtNum___3JT46 {
    padding: 0 1rem;
}

.styles__container___3mCLH {
    min-width: 15rem;
    max-width: 19rem;
    width: 16vw;
    border-radius: .375rem;
    background-position: 50%;
    background-size: cover;
    cursor: pointer;
    margin: .5rem;
    background: linear-gradient(0deg, #e8e8e8, #e8e8e8);
    box-shadow: inset -4px -4px #d8d8d8, inset 4px 4px #d8d8d8, inset -4px 4px #d8d8d8, inset 4px -4px #d8d8d8;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 8rem;
}

.styles__container___16een {
    min-width: 15rem;
    max-width: 19rem;
    width: 16vw;
    border-radius: .375rem;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    margin: .5rem;
    background: linear-gradient(0deg, #fec551, #fec551);
    transition: 0.3s ease-in-out;

    &:hover {
        box-shadow: 2px 5px 2px rgba(0, 0, 0, .5);
    }

}

.styles__icon___25pzZ {
    border-radius: 100%;
    background: #1da1f2;
    width: 37px;
    height: 37px;
    margin-right: .5rem;
}

.styles__text___NQdFz {
    font-style: normal;
    font-weight: 600;
    line-height: normal;
    font-size: 13.91px;
    letter-spacing: -.0642px;
    color: #000;
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

.effectScale:hover {
    // transform: scale(1.2);
    animation: gelatine 0.5s;
    /* transform: scale(1); */
}

.styles__container___2c6eo {
    min-width: 15rem;
    max-width: 19rem;
    width: 16vw;
    border-radius: .375rem;
    background-color: #efefef;
    display: flex;
    flex-direction: column;
    background-color: silver;
    background-position: 50%;
    background-size: cover;
    cursor: pointer;
    margin: .5rem;
    overflow: hidden;
    height: 8rem;
    transition: 0.3s ease-in-out;

    &:hover {
        box-shadow: 2px 5px 2px rgba(0, 0, 0, .5);
    }
}

.styles__overLay___1WcJB {
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;

    &:hover {
        //    opacity: 0.5;
    }
}

.styles__conName___2JHZN {
    display: flex;
    margin-top: .75rem;
}

.styles__txtDate___1BKAV,
.styles__txtNum___39eD4 {
    font-size: 15px;
    font-weight: bold;
    font-style: normal;
    font-stretch: normal;
    line-height: 1.33;
    letter-spacing: normal;
    text-align: left;
    color: #fff;
    text-shadow: 3px 3px 7px #000000;

}

.styles__txtNum___39eD4 {
    padding: 0 1rem;
    font-size: 12px;
    font-weight: bold;
    font-style: normal;
    font-stretch: normal;
    line-height: 1.33;
    letter-spacing: normal;
    text-align: left;
    color: #fff;
}

.styles__viewName___2PQg6 {
    padding: 0 .5rem 0 1rem;
    font-size: 1.5rem;
    font-weight: 600;
    font-style: normal;
    font-stretch: normal;
    line-height: 1.33;
    letter-spacing: normal;
    text-align: left;
    color: #fff;
    max-width: 12rem;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    text-shadow: 3px 3px 7px #000000;
}

.styles__txtDate___1BKAV {
    padding: .375rem 1rem 0;
}
</style>
