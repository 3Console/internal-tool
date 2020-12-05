<template>
  <modal name="project"
    height="auto"
    :scrollable="true"
    :click-to-close="true"
    @before-open="beforeOpen"
    @before-close="beforeClose"
    >
    <div class="content">
      <div slot="top-right">
        <md-button class="top-right md-icon-button md-accent" @click="$modal.hide('project')">
          <md-icon>close</md-icon>
        </md-button>
      </div>
      <span class="md-title">{{title}}</span>
      <md-field>
        <label>Project name</label>
        <md-input type="text"
                  :name="`${_uid}_name`"
                  data-vv-validate-on="none"
                  data-vv-as="project_name"
                  v-validate="'required|max:30'"
                  data-vv-scope="general"
                  v-model="project_name"
                  :class="errors.has(`general.${_uid}_name`) ? 'is-invalid' : ''"
                  md-counter="30">
        </md-input>
        <div v-if="errors.has(`general.${_uid}_name`)">
          <md-icon class="md-accent">warning</md-icon>
          {{errors.first(`general.${_uid}_name`)}}
        </div>
      </md-field>
      <template v-if="editingId">
        <div>
          <md-radio v-model="status" value="active">Active</md-radio>
          <md-radio v-model="status" value="inactive">Inactive</md-radio>
        </div>
      </template>
      <div class="md-right">
        <md-button class="md-raised md-primary" @click="submit">Gửi</md-button>
        <md-button class="md-raised md-accent" @click="cancel">Bỏ qua</md-button>
      </div>
    </div>
  </modal>
</template>

<script>
import rf from '../requests/RequestFactory';
export default {
  data() {
    return {
      title: 'project',
      editingId: '',
      project_name: '',
      status: ''
    }
  },
  methods: {
    beforeOpen (event) {
      this.title = event.params.title;
      if(event.params.projectId) {
        this.editingId = event.params.projectId;
        rf.getRequest('ProjectRequest').getProject(this.editingId).then((project)=>{
          this.project_name = project.name;
          this.status= project.status;
        });
      }
    },
    beforeClose() {
      this.editingId = '';
      this.project_name = '';
    },
    async submit() {
      Promise.all([
        this.$validator.validateAll('general'),
      ]).then(() => {
        if (this.errors.any()) {
          return;
        }
        if(this.editingId) {
          this.updateProject();
        } else {
          this.createProject();
        }
      });
    },
    createProject() {
      rf.getRequest('ProjectRequest').createProject({project_name: this.project_name}).then((res)=>{
        this.$modal.hide('project');
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
    updateProject() {
      rf.getRequest('ProjectRequest').updateProject(this.editingId, {project_name: this.project_name, status: this.status}).then((res)=> {
        this.$modal.hide('project');
        this.$emit('refresh');
      });
      this.$toasted.show('Cập nhật nhân viên thành công!', {
        theme: 'bubble',
        position: 'top-right',
        duration : 1500,
        type: 'success'
      });
    },
    cancel() {
      this.$modal.hide('project');
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
