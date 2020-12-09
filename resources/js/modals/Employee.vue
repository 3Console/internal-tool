<template>
  <modal name="employee"
      height="auto"
      :scrollable="true"
      :click-to-close="true"
      @before-open="beforeOpen"
      @before-close="beforeClose"
      >

        <div class="content">
          <div slot="top-right">
            <md-button class="top-right md-icon-button md-accent" @click="$modal.hide('employee')">
              <md-icon>close</md-icon>
            </md-button>
          </div>
          <span class="md-title">{{title}}</span>

          <md-field>
            <label>Full Name</label>
            <md-input type="text"
                      :name="`${_uid}_name`"
                      data-vv-validate-on="none"
                      data-vv-as="name"
                      v-validate="'required|max:30'"
                      data-vv-scope="general"
                      v-model="employee.full_name"
                      :class="errors.has(`general.${_uid}_name`) ? 'is-invalid' : ''"
                      md-counter="30">
            </md-input>
            <div v-if="errors.has(`general.${_uid}_name`)">
              <md-icon class="md-accent">warning</md-icon>
              {{errors.first(`general.${_uid}_name`)}}
            </div>
          </md-field>

          <md-field>
            <label>Username</label>
            <md-input type="text"
                      :name="`${_uid}_username`"
                      data-vv-validate-on="none"
                      data-vv-as="username"
                      v-validate="'required|min:6|max:30'"
                      data-vv-scope="general"
                      v-model="employee.name"
                      :class="errors.has(`general.${_uid}_username`) ? 'is-invalid' : ''"
                      md-counter="30">
           </md-input>
           <div v-if="errors.has(`general.${_uid}_username`)">
             <md-icon class="md-accent">warning</md-icon>
             {{errors.first(`general.${_uid}_username`)}}
           </div>
          </md-field>

          <md-field>
            <label>Email</label>
            <md-input  type="text"
                      :name="`${_uid}_email`"
                      data-vv-validate-on="none"
                      data-vv-as="email"
                      v-validate="'required|email'"
                      data-vv-scope="general"
                      v-model="employee.email"
                      :class="errors.has(`general.${_uid}_email`) ? 'is-invalid' : ''">
            </md-input>
            <div v-if="errors.has(`general.${_uid}_email`)">
              <md-icon class="md-accent">warning</md-icon>
              {{errors.first(`general.${_uid}_email`)}}
            </div>
          </md-field>

          <md-checkbox v-if="editingId" v-model="isEditPassword">Edit Password</md-checkbox>
          <div style="red-outline">
            <md-field>
              <label>Password</label>
              <md-input type="password"
                        :name="`${_uid}_password`"
                        data-vv-validate-on="none"
                        data-vv-as="password"
                        ref="password"
                        v-validate="'required|min:6|max:30'"
                        data-vv-scope="general"
                        v-model="employee.password"
                        :disabled="!!editingId && !isEditPassword"
                        :class="errors.has(`general.${_uid}_password`) ? 'is-invalid' : ''">
             </md-input>
             <div v-if="errors.has(`general.${_uid}_password`)">
               <md-icon class="md-accent">warning</md-icon>
               {{errors.first(`general.${_uid}_password`)}}
             </div>
            </md-field>

            <md-field :md-toggle-password="false">
              <label>Confirm password</label>
              <md-input type="password"
                        :name="`${_uid}_repassword`"
                        data-vv-validate-on="none"
                        data-vv-as="retype password"
                        v-validate="'required|confirmed:password'"
                        data-vv-scope="general"
                        v-model="employee.retype_password"
                        :disabled="!!editingId && !isEditPassword"
                        :class="errors.has(`general.${_uid}_password`) ? 'is-invalid' : ''">
              </md-input>
              <div v-if="errors.has(`general.${_uid}_repassword`)">
                <md-icon class="md-accent">warning</md-icon>
                {{errors.first(`general.${_uid}_repassword`)}}
              </div>
            </md-field>
          </div>
      </div>

      <div class="md-right">
        <md-button class="md-raised md-primary" @click="submit">Submit</md-button>
        <md-button class="md-raised md-accent" @click="cancel">Cancel</md-button>
      </div>
  </modal>
</template>

<script>
import rf from '../requests/RequestFactory';
export default {
  data () {
    return {
      title: 'employee',
      editingId: '',
      isEditPassword: false,
      employee: {
        full_name: '',
        name: '',
        email: '',
      }
    }
  },
  methods: {
    beforeOpen (event) {
      this.title = event.params.title;
      if(event.params.employeeId) {
        this.editingId = event.params.employeeId;
        rf.getRequest('EmployeeRequest').show(this.editingId).then((employee)=>{
          this.employee = employee;
        });
      }
    },
    beforeClose() {
      this.editingId = '';
      this.isEditPassword = false,
      this.employee = {
        name: '',
        full_name: '',
        email: '',
      };
    },
    async submit() {
        Promise.all([
          this.$validator.validateAll('general'),
        ]).then(() => {
            if (this.errors.any()) {
              return;
            }
            if(this.editingId) {
              this.updateOneEmployee();
            } else {
              this.createOneEmployee();
            }
        });
      },
    updateOneEmployee() {
      let params = this.employee;
      if(!this.isEditPassword) {
        params = {};
        params.name = this.employee.name;
        params.full_name = this.employee.full_name;
        params.email = this.employee.email;
      }
      rf.getRequest('EmployeeRequest').update(this.editingId, params).then((res)=> {
        this.$modal.hide('employee');
        this.$emit('refresh');
      });
      this.$toasted.show('Cập nhật nhân viên thành công!', {
        theme: 'bubble',
        position: 'top-right',
        duration : 1500,
        type: 'success'
      });
    },
    createOneEmployee() {
          rf.getRequest('EmployeeRequest').store(this.employee).then((res)=>{
            this.$modal.hide('employee');
            this.$emit('refresh');
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
      this.$modal.hide('employee');
    }
  }
}
</script>

<style lang="scss" scoped >
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
