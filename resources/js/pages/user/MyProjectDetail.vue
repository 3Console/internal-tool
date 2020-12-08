<template>
  <div style="margin: 0px 16px">
    <a-page-header style="border: 1px solid rgb(235, 237, 240)" title="My Project Detail" @back="toMyProject" />
    <div style="padding: 36px 24px">
      <a-row>
        <a-col :span="12">
          <a-card title="General Info" bordered style="width: 100%">
            <p>Card content</p>
            <p>Card content</p>
            <p>Card content</p>
          </a-card>
        </a-col>
      </a-row>
      <div class="row-item">
        <div class="title">Project Manager</div>
        <a-row>
          <a-col :span="6" style="padding-right: 12px">
            <a-card bordered style="width: 100%">
              <a-card-meta :title="project_manager.full_name" :description="project_manager.email">
                <a-avatar
                  slot="avatar"
                  src="https://zos.alipayobjects.com/rmsportal/ODTLcjxAfvqbxHnVXCYX.png"
                />
              </a-card-meta>
            </a-card>
          </a-col>
        </a-row>
      </div>
      <div class="row-item">
        <div class="title">Members</div>
        <a-row>
          <template v-for="member in members">
            <a-col :key="member.id" :span="6" style="padding-right: 12px">
              <a-card bordered style="width: 100%; margin-bottom: 20px">
                <a-card-meta :title="member.full_name" :description="member.email">
                  <a-avatar
                    slot="avatar"
                    src="https://zos.alipayobjects.com/rmsportal/ODTLcjxAfvqbxHnVXCYX.png"
                  />
                </a-card-meta>
              </a-card>
            </a-col>
          </template>
        </a-row>
      </div>
    </div>
  </div>
</template>

<script>
import rf from '../../requests/RequestFactory';
export default {
  data() {
    return {
      project_id: this.$route.params.id,
      project_manager: {},
      members: []
    }
  },
  methods: {
    toMyProject() {
      this.$router.push('/project');
    },
    getProjectManager() {
      return rf.getRequest('ProjectRequest').getProjectManager(this.project_id).then(res => {
        this.project_manager = res;
      })
    },
    getProjectMembers() {
      return rf.getRequest('ProjectRequest').getOtherMembers(this.project_id).then(res => {
        this.members = res;
      })
    }
  },
  created() {
    this.getProjectManager();
    this.getProjectMembers();
  }
}
</script>

<style lang="scss" scoped>
  .row-item {
    margin-top: 20px;
    border-top: 1px solid #d8d8d8;

    .title {
      font-size: 24px;
      padding: 12px 0;
      color: #476282;
    }
  }
</style>
