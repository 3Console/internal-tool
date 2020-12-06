<template>
  <div>
    <div class="background-header"></div>
    <div class="content">
      <a-row class="row-item">
        <a-col :span="4"></a-col>
        <a-col :span="16" class="card-center">
          <div class="title">Home</div>
          <a-card title="Notifications" style="width: 100%">
            <a slot="extra" href="#">See all >></a>
            <p>card content</p>
            <p>card content</p>
            <p>card content</p>
          </a-card>
          <a-divider class="divider"/>
        </a-col>
        <a-col :span="4"></a-col>
      </a-row>
      <a-row>
        <a-col :span="4"></a-col>
        <a-col :span="16">
          <div class="title-feature">Feature</div>
        </a-col>
        <a-col :span="4"></a-col>
      </a-row>
      <a-row class="row-item">
        <a-col :span="5"></a-col>
        <a-col :span="7" class="card-left">
          <a-card hoverable style="width: 100%" @click="goToAbsence">
            <img
              slot="cover"
              alt="example"
              src="/images/absence.png"
              style="height: 200px"
            />
            <a-card-meta title="Absence" description="Request absence" />
          </a-card>
        </a-col>
        <a-col :span="7">
          <a-card hoverable style="width: 100%" @click="goToOvertime">
            <img
              slot="cover"
              alt="example"
              src="/images/overtime.jpeg"
              style="height: 200px; border-bottom: 1px solid #d8d8d8"
            />
            <a-card-meta title="Overtime" description="Request overtime" />
          </a-card>
        </a-col>
        <a-col :span="5"></a-col>
      </a-row>
      <a-row class="row-item">
        <a-col :span="5"></a-col>
        <a-col :span="7" class="card-left">
          <a-card hoverable style="width: 100%" @click="goToAbsence">
            <img
              slot="cover"
              alt="example"
              src="/images/payroll.jpeg"
              style="height: 200px"
            />
            <a-card-meta title="Pay Slip" description="Check my pay slip per month" />
          </a-card>
        </a-col>
        <a-col :span="7">
          <a-card hoverable style="width: 100%" @click="goToOvertime">
            <img
              slot="cover"
              alt="example"
              src="/images/project-member.png"
              style="height: 200px;"
            />
            <a-card-meta title="My Project" description="Check info about project, member, ..." />
          </a-card>
        </a-col>
        <a-col :span="5"></a-col>
      </a-row>
    </div>
  </div>
</template>

<script>
import rf from './../../requests/RequestFactory';
export default {
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
  .content {
    padding: 20px 12px;
    position: relative;
    top: -250px;
  }

  .background-header {
    height: 300px;
    background: #1a73e8;
  }

  .title {
    margin-bottom: 40px;
    color: #fff;
    font-size: 32px;
    font-weight: 500;
  }

  .divider {
    margin: 50px 0px;
    background: #d8d8d8;
  }

  .category {
    padding: 12px;
  }

  .row-item {
    margin-top: 30px;
  }

  .card-left {
    position: relative;
    right: 10px;
  }

  .card-center {
    padding: 0 55px;
  }

  .title-feature {
    font-size: 20px;
    padding: 0 55px;
  }

  .ant-card {
    border-radius: 12px;
  }
</style>
