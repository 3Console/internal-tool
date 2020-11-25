<template>
  <div>
    <a-page-header style="border: 1px solid rgb(235, 237, 240)" title="Trang chủ" />
    <div class="category inline-flex">
      <a-card hoverable style="width: 300px; height: 285px" @click="goToAbsence">
        <img
          slot="cover"
          alt="example"
          src="https://gw.alipayobjects.com/zos/rmsportal/JiqGstEfoWAOHiTxclqi.png"
        />
        <a-card-meta title="Đăng ký nghỉ phép" description="This is the description" />
      </a-card>
      <a-card hoverable style="width: 300px; height: 285px" @click="goToOvertime">
        <img
          slot="cover"
          alt="example"
          src="https://gw.alipayobjects.com/zos/rmsportal/JiqGstEfoWAOHiTxclqi.png"
        />
        <a-card-meta title="Đăng ký OT" description="This is the description" />
      </a-card>
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
    goToAbsence() {
      this.$router.push('/absence')
    },
    goToOvertime() {
      this.$router.push('/overtime')
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
  .category {
    padding: 12px;
  }
</style>
