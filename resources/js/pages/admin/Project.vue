<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout md-gutter">
        <div class="md-layout-item md-size-5">
        </div>
        <div class="md-layout-item md-size-30">
          <md-field >
            <label>Tìm kiếm</label>
            <md-input type="text" name="text" v-model="searchInput" @keyup.enter="$refs.datatable.refresh()"></md-input>
            <md-icon>search</md-icon>
          </md-field>
        </div>
        <div class="md-layout-item md-size-35">
        </div>
        <div class="md-layout-item">
          <md-button  class="md-success" @click="createProject">Thêm</md-button>
          <md-button  class="md-info" @click="refresh">Làm mới</md-button>
          <md-button  class="md-danger">Xóa</md-button>
        </div>
      </div>
      <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
        <md-card>
          <md-card-header data-background-color="green">
            <h4 class="title">Project</h4>
            <p class="category">Here is a subtitle for this table</p>
          </md-card-header>
          <md-card-content>
            <data-table :get-data="getData" ref="datatable">
              <th class="col_checkbox">
                <md-checkbox :plain="true" v-model="selectedAll"></md-checkbox>
              </th>
              <th class="col_title_en">Project Name</th>
              <th class="col_project_manager">Project Manager</th>
              <th class="col_title_jp">Status</th>
              <th class="col_tools">Công cụ</th>
              <template slot="body" slot-scope="{ item }">
                <tr>
                  <td class="text-center">
                    <md-checkbox v-model="item.selected" @input="listenSelectRow"></md-checkbox>
                  </td>
                  <td class="text-center" v-html="item.name" @click="toProjectDetail(item.id)" style="cursor: pointer"></td>
                  <td class="text-center" v-html="item.full_name"></td>
                  <td class="text-center" v-html="item.status"></td>
                  <td class="text-center">
                      <md-button class="md-just-icon md-simple md-primary" @click="editProject(item.id)">
                        <md-icon>edit</md-icon>
                        <md-tooltip md-direction="top">Edit</md-tooltip>
                      </md-button>
                      <md-button class="md-just-icon md-simple md-danger" @click="deleteProject(item.id)">
                        <md-icon>close</md-icon>
                        <md-tooltip md-direction="top">Delete</md-tooltip>
                      </md-button>
                  </td>
                </tr>
              </template>
            </data-table>
          </md-card-content>
        </md-card>
      </div>
      <v-dialog/>
      <ProjectModal @refresh="refresh()" />
    </div>
  </div>
</template>

<script>
import rf from '../../requests/RequestFactory';
import ProjectModal from '../../modals/Project';
export default {
  components: {
    ProjectModal
  },
  data() {
    return {
      searchInput: '',
    }
  },
  methods: {
    refresh() {
      this.isLoading = true;
      this.$refs.datatable.refresh();
      this.$refs.datatable.$on('DataTable:finish', () => {
        this.isLoading = false;
      });
    },
    getData (params) {
      const meta = Object.assign({}, params, {
        search: this.searchInput,
      });
      return rf.getRequest('ProjectRequest').getProjects(meta);
    },
    toProjectDetail(projectId) {
      this.$router.push({ name: 'Project Member', params: { id: projectId } });
    },
    createProject() {
      this.$modal.show('project', {title: 'Add project'});
    },
    editProject(projectId) {
      this.$modal.show('project', {title: 'Edit project', projectId: projectId});
    },
    deleteProject(projectId) {
      this.$modal.show('dialog', {
        title: 'Warning!',
        text: 'Are you sure to delete this project ?',
        buttons: [
          {
            title: 'Cancel',
            handler: () => {
              this.$modal.hide('dialog');
            }
          },
          {
            title: 'Confirm',
            default: true,
            handler: () => {
              return rf.getRequest('ProjectRequest').deleteProject(projectId).then(() => {
                this.$modal.hide('dialog');
                this.$refs.datatable.refresh();
                this.$toasted.show('Delete succesfully!', {
                  theme: 'bubble',
                  position: 'bottom-right',
                  duration : 1500,
                  type: 'success'
                });
              });
            }
          },
        ]
      });
    }
  }
}
</script>

<style lang="scss">

</style>
