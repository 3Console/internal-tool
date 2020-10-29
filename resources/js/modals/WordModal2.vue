<template>
<modal name="word2" height="auto" width="400px" :scrollable="true" :click-to-close="true" @before-open="beforeOpen" @before-close="beforeClose">

    <div class="content">
        <div slot="top-right">
        </div>
        <span class="md-title">{{title}}</span>

        <md-field>
            <label>Từ</label>
            <md-input type="text" :name="`${_uid}_word`" @keyup.enter="translate()" data-vv-validate-on="none" data-vv-as="name" v-validate="'required|max:30'" data-vv-scope="general" v-model="word.word" :class="errors.has(`general.${_uid}_word`) ? 'is-invalid' : ''" md-counter="30">
            </md-input>
            <a-tooltip @click="translate()">
                <template slot="title">
                    Nhấn để dịch
                </template>
                <md-icon style="cursor: pointer;">translate</md-icon>
            </a-tooltip>
        </md-field>
        <div v-if="errors.has(`general.${_uid}_word`)">
            <md-icon class="md-accent">warning</md-icon>
            {{errors.first(`general.${_uid}_word`)}}
        </div>
        <md-field>
            <label>Nghĩa</label>
            <md-input type="text" :name="`${_uid}_meaning`" data-vv-validate-on="none" data-vv-as="nghĩa" v-validate="'required|max:300'" data-vv-scope="general" v-model="word.meaning" md-counter="300">
            </md-input>
        </md-field>
        <div v-if="errors.has(`general.${_uid}_meaning`)">
            <md-icon class="md-accent">warning</md-icon>
            {{errors.first(`general.${_uid}_meaning`)}}
        </div>
        <md-field>
            <label>Gợi ý</label>
            <md-input type="text" :name="`${_uid}_hint`" data-vv-validate-on="none" data-vv-as="gợi ý" v-validate="'required|max:300'" data-vv-scope="general" v-model="word.hint" md-counter="300">
            </md-input>
        </md-field>
        <div v-if="errors.has(`general.${_uid}_hint`)">
            <md-icon class="md-accent">warning</md-icon>
            {{errors.first(`general.${_uid}_hint`)}}
        </div>
        <a-row>
            Quan trọng
            <a-switch @change="onIsImportantChange" />
        </a-row>

        <a-row style="margin-top: 20px;">
            Ảnh
            <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" accepted-file-types=".jpg,.png,.jpeg" @vdropzone-success="uploadSuccess" @vdropzone-complete="afterComplete">

            </vue-dropzone>
        </a-row>

    </div>

    <div class="md-right">
        <a-button type="primary" @click="submit">Thêm</a-button>
        <a-button type="dashed" @click="cancel">Bỏ qua</a-button>
    </div>
</modal>
</template>

<script>
import rf from '../requests/RequestFactory';
export default {
    data() {
        return {
            title: 'Word',
            word: {
                word: '',
                hint: '',
                image: '',
                meaning: '',
                is_important: false,
                category_id: 1
            },
            dropzoneOptions: {
                url: `${process.env.MIX_APP_URL}/api/image/store`,
                thumbnailWidth: null,
                maxFiles: 1,
                maxFilesize: 1000,
                addRemoveLinks: true,
                headers: {
                    "My-Awesome-Header": "header value"
                },
                dictDefaultMessage: 'Nhấn vào đây hoặc kéo ảnh vào để tải lên',
            }
        }
    },
    methods: {
        beforeOpen(event) {
            this.title = event.params.title;
            this.word.category_id = event.params.categoryId;
        },
        beforeClose() {
            this.word = {
                word: '',
                hint: '',
                image: '',
                meaning: '',
                is_important: false,
                category_id: 1
            }
        },
        afterComplete(file, response) {
            // console.log(response);
        },
        uploadSuccess(file, response) {
            this.word.image = response;
        },
        onIsImportantChange(isImportant) {
            this.word.is_important = isImportant;
        },
        async submit() {
            this.createNewWord();
        },
        createNewWord() {
            rf.getRequest('WordRequest').store(this.word).then((res) => {
                this.$emit('refresh');
                this.$emit('created');
                this.$modal.hide('word2');
            }).catch((err) => {
                // this.$toasted.show('Đã có lỗi xảy ra, vui lòng kiểm tra lại!', {
                //   theme: 'bubble',
                //   position: 'top-right',
                //   duration : 1500,
                //   type: 'danger'
                // });
            });
        },
        translate() {
            rf.getRequest('TranslateRequest').translate({ text: this.word.word }).then(res => {
                this.word.meaning = res;
            })
        },
        cancel() {
            this.$modal.hide('word2');
        }
    }
}
</script>

<style lang="scss" scoped>
.content {
    padding: 30px 30px 10px 30px;
}

.md-right {
    float: right;
    padding: 0px 10px 20px;
}

.top-right {
    float: right;
}

.red-outline {
    border: 1px solid red;
}
</style>
