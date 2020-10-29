<template>
<modal name="word" height="auto" width="400px" :scrollable="true" :click-to-close="true" @before-open="beforeOpen" @before-close="beforeClose">

    <div class="content">
        <div slot="top-right">
        </div>
        <span class="md-title">{{title}}</span>

        <md-field>
            <label>Từ</label>
            <md-input type="text" :name="`${_uid}_name`" data-vv-validate-on="none" data-vv-as="name" v-validate="'required|max:30'" data-vv-scope="general" v-model="word.word" :class="errors.has(`general.${_uid}_title`) ? 'is-invalid' : ''" md-counter="30">
            </md-input>
            
            <div v-if="errors.has(`general.${_uid}_name`)">
                <md-icon class="md-accent">warning</md-icon>
                {{errors.first(`general.${_uid}_name`)}}
            </div>
        </md-field>
        <md-field>
            <label>Nghĩa</label>
            <md-input type="text" :name="`${_uid}_name`" data-vv-validate-on="none" data-vv-as="name" v-validate="'required|max:30'" data-vv-scope="general" v-model="word.meaning" :class="errors.has(`general.${_uid}_title`) ? 'is-invalid' : ''" md-counter="30">
            </md-input>
            <div v-if="errors.has(`general.${_uid}_name`)">
                <md-icon class="md-accent">warning</md-icon>
                {{errors.first(`general.${_uid}_name`)}}
            </div>
        </md-field>
        <md-field>
            <label>Gợi ý</label>
            <md-input type="text" :name="`${_uid}_name`" data-vv-validate-on="none" data-vv-as="name" v-validate="'required|max:30'" data-vv-scope="general" v-model="word.hint" :class="errors.has(`general.${_uid}_title`) ? 'is-invalid' : ''" md-counter="30">
            </md-input>
            <div v-if="errors.has(`general.${_uid}_name`)">
                <md-icon class="md-accent">warning</md-icon>
                {{errors.first(`general.${_uid}_name`)}}
            </div>
        </md-field>
        <a-row>
            Quan trọng
            <a-switch @change="onIsImportantChange" />
        </a-row>

        <a-row style="margin-top: 20px;">
            Ảnh
            <vue-dropzone ref="myVueDropzone" id="dropzone" 
            :options="dropzoneOptions"
            accepted-file-types=".jpg,.png,.jpeg"
             @vdropzone-success="uploadSuccess" 
            @vdropzone-complete="afterComplete">

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
                url: `${window.location.origin}/api/image/store`,
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
                this.$modal.hide('word');
            }).catch((err) => {
                // this.$toasted.show('Đã có lỗi xảy ra, vui lòng kiểm tra lại!', {
                //   theme: 'bubble',
                //   position: 'top-right',
                //   duration : 1500,
                //   type: 'danger'
                // });
            });
        },
        cancel() {
            this.$modal.hide('word');
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
