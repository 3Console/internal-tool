<template >
  <div class="centered-container">
    <md-content class="md-elevation-3">

      <div class="title">
        <img src="/images/login-logo.png">
        <div class="md-title">Vocabulary Learning</div>
      </div>

      <div class="form">
         <md-field>
          <label>Tên đầy đủ</label>
          <md-input v-model="full_name" autofocus></md-input>
        </md-field>

        <md-field>
          <label>Tên đăng nhập</label>
          <md-input v-model="name" autofocus></md-input>
        </md-field>

        <md-field>
          <label>Email</label>
          <md-input v-model="email" type="email" autofocus></md-input>
        </md-field>

        <md-field md-has-password>
          <label>Mật khẩu</label>
          <md-input v-model="password" type="password" @keyup.enter="submit"></md-input>
        </md-field>

        <md-field md-has-password>
          <label>Nhập lại mật khẩu</label>
          <md-input v-model="re_password" type="password" @keyup.enter="submit"></md-input>
        </md-field>

      </div>

      <a-button type="dashed" @click="redirectToLogin()"> <a-icon type="left" /> Về trang đăng nhập </a-button>

      <div class="actions md-layout md-alignment-center-space-between" style="float: right;">
        <a-button type="primary"  @click="submit">Đăng ký</a-button>
      </div>

      <div class="loading-overlay" v-if="loading">
        <md-progress-spinner md-mode="indeterminate" :md-stroke="2"></md-progress-spinner>
      </div>

    </md-content>
    <div class="background" />
  </div>
</template>

<script>
import rf from '../requests/RequestFactory';
import AuthenticationUtils from '../common/AuthenticationUtils';

export default {
    name: 'LoginPage',
    data () {
      return {
        name: '',
        full_name: '',
        username: '',
        password: '',
        re_password: '',
        email: '',
        loading: false
      };
    },
    mounted () {
      this.name = this.$route.query.name;
    },
    methods: {
      redirectToLogin() {
        this.$router.push({ name: 'Login' });
      },
      submit () {
          const params = {
            name: this.name,
            password: this.password,
            full_name: this.full_name,
            email: this.email
          };
          this.register(params);
      },
      register (params) {
        return rf.getRequest('UserRequest').register(params).then(async (response) => {
          this.$router.push({ name: 'Login' })
        }).catch(async (error) => {
          console.log(error);
        }).finally(() => {
          this.loading = false;
        });
      },
    },
  };
</script>

<style lang="scss">
.centered-container {
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  height: 100vh;
  .title {
    text-align: center;
    margin-bottom: 30px;
    img {
      margin-bottom: 16px;
      max-width: 80px;
    }
  }
  .actions {
    .md-button {
      margin: 0;
    }
  }
  .form {
    margin-bottom: 60px;
  }
  .background {
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
    z-index: 0;
  }
  .md-content {
    z-index: 1;
    padding: 40px;
    width: 100%;
    max-width: 400px;
    position: relative;
  }
  .loading-overlay {
    z-index: 10;
    top: 0;
    left: 0;
    right: 0;
    position: absolute;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
  }
}
</style>
