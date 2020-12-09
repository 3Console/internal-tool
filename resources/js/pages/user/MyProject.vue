<template>
  <div style="margin: 0px 16px">
    <a-page-header style="border: 1px solid rgb(235, 237, 240)" title="My Project" @back="toCategory" />
    <template v-if="projects.length > 0">
      <div style="padding: 36px 24px">
        <a-row>
          <template v-for="project in projects">
            <a-col :span="8" :key="project.id" style="margin-bottom: 20px; padding: 0 16px;">
              <a-card hoverable style="width: 100%" @click="toMyProjectDetail(project.project_id)">
                <img
                  slot="cover"
                  alt="example"
                  src="/images/project.png"
                  style="height: 200px"
                />
                <a-card-meta :title="project.name" description="This is the description" />
              </a-card>
            </a-col>
          </template>
        </a-row>
      </div>
    </template>
    <template v-else>
      <div class="message">
        You haven't joined a project yet 
      </div>
    </template>
  </div>
</template>

<script>
import rf from '../../requests/RequestFactory';
export default {
  data() {
    return {
      projects: []
    }
  },
  methods: {
    toCategory() {
      this.$router.push('/category')
    },
    toMyProjectDetail(project_id) {
      this.$router.push({ name: 'MyProjectDetail', params: { id: project_id } });
    },
    getUserProjects() {
      return rf.getRequest('ProjectRequest').getUserProjects().then(res => {
        this.projects = res;
      })
    }
  },
  created() {
    this.getUserProjects();
  }
}
</script>

<style lang="scss" scoped>
  .message {
    padding: 24px 16px;
    font-size: 24px;
    color: #476282;
  }
</style>
