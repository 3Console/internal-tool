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
          <md-button  class="md-success">Thêm</md-button>
          <md-button  class="md-info" @click="refresh">Làm mới</md-button>
          <md-button  class="md-danger">Xóa</md-button>
        </div>
      </div>
      <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
        <md-card>
          <md-card-header data-background-color="green">
            <h4 class="title">Danh sách xin OT</h4>
            <p class="category">Here is a subtitle for this table</p>
          </md-card-header>
          <md-card-content>
            <vue-tabs
              active-tab-color="#4caf50" 
              active-text-color="#fff"
            >
              <v-tab title="Đang chờ xét duyệt">
                <data-table :get-data="getPendingRequest" ref="datatable">
                  <th class="col_checkbox">
                    <md-checkbox :plain="true" v-model="selectedAll"></md-checkbox>
                  </th>
                  <th class="col_title_en">Tên đăng nhập</th>
                  <th class="col_title_jp">Tiêu đề</th>
                  <th class="col_created_at">Thời gian OT</th>
                  <th class="col_tools">Công cụ</th>
                  <template slot="body" slot-scope="{ item }">
                    <tr>
                      <td class="text-center">
                        <md-checkbox v-model="item.selected" @input="listenSelectRow"></md-checkbox>
                      </td>
                      <td class="text-center" v-html="item.name"></td>
                      <td class="text-center" v-html="item.title"></td>
                      <td class="text-center" v-html="item.duration"></td>
                      <td class="text-center">
                          <md-button class="md-just-icon md-simple md-primary" @click="approveRequest(item.request_id)">
                            <md-icon>edit</md-icon>
                            <md-tooltip md-direction="top">Phê duyệt</md-tooltip>
                          </md-button>
                          <md-button class="md-just-icon md-simple md-danger" @click="rejectRequest(item.request_id)">
                            <md-icon>close</md-icon>
                            <md-tooltip md-direction="top">Từ chối</md-tooltip>
                          </md-button>
                      </td>
                    </tr>
                  </template>
                </data-table>
              </v-tab>
              <v-tab title="Đã phê duyệt">
                <data-table :get-data="getApprovedRequest" ref="datatable">
                  <th class="col_checkbox">
                    <md-checkbox :plain="true" v-model="selectedAll"></md-checkbox>
                  </th>
                  <th class="col_title_en">Tên đăng nhập</th>
                  <th class="col_title_jp">Tiêu đề</th>
                  <th class="col_created_at">Thời gian OT</th>
                  <template slot="body" slot-scope="{ item }">
                    <tr>
                      <td class="text-center">
                        <md-checkbox v-model="item.selected" @input="listenSelectRow"></md-checkbox>
                      </td>
                      <td class="text-center" v-html="item.name"></td>
                      <td class="text-center" v-html="item.title"></td>
                      <td class="text-center" v-html="item.duration"></td>
                    </tr>
                  </template>
                </data-table>
              </v-tab>
              <v-tab title="Đã từ chối">
                <data-table :get-data="getRejectedRequest">
                  <th class="col_checkbox">
                    <md-checkbox :plain="true" v-model="selectedAll"></md-checkbox>
                  </th>
                  <th class="col_title_en">Tên đăng nhập</th>
                  <th class="col_title_jp">Tiêu đề</th>
                  <th class="col_created_at">Thời gian OT</th>
                  <template slot="body" slot-scope="{ item }">
                    <tr>
                      <td class="text-center">
                        <md-checkbox v-model="item.selected" @input="listenSelectRow"></md-checkbox>
                      </td>
                      <td class="text-center" v-html="item.name"></td>
                      <td class="text-center" v-html="item.title"></td>
                      <td class="text-center" v-html="item.duration"></td>
                    </tr>
                  </template>
                </data-table>
              </v-tab>
            </vue-tabs>
          </md-card-content>
        </md-card>
      </div>
      <v-dialog/>
    </div>
  </div>
</template>
<script>
  const PENDING = 'pending';
  const APPROVED = 'approved';
  const REJECTED = 'rejected';

  import rf from '../../requests/RequestFactory';
  export default {
    data () {
      return {
        searchInput: '',
        selectedAll: false
      }
    },
    watch: {
      searchInput() {
        this.$refs.datatable.refresh();
      },
      selectedAll() {
        if (!this.$refs.datatable) {
          return true;
        }
        this.$refs.datatable.rows.forEach((row) => {
          this.$set(row, 'selected', this.selectedAll);
        });
      },
    },
    methods: {
      refresh() {
        this.isLoading = true;
        this.$refs.datatable.refresh();
        this.$refs.datatable.$on('DataTable:finish', () => {
          this.isLoading = false;
        });
      },
      getPendingRequest (params) {
        const meta = Object.assign({}, params, {
          search: this.searchInput,
          status: PENDING
        });
        return rf.getRequest('UserOvertimeRequest').getUserOvertimeRequests(meta);
      },
      getApprovedRequest (params) {
        const meta = Object.assign({}, params, {
          search: this.searchInput,
          status: APPROVED
        });
        return rf.getRequest('UserOvertimeRequest').getUserOvertimeRequests(meta);
      },
      getRejectedRequest (params) {
        const meta = Object.assign({}, params, {
          search: this.searchInput,
          status: REJECTED
        });
        return rf.getRequest('UserOvertimeRequest').getUserOvertimeRequests(meta);
      },
      approveRequest(requestId) {
        this.$modal.show('dialog', {
          title: 'Cảnh báo!',
          text: 'Bạn có muốn phê duyệt yêu cầu này ?',
          buttons: [
            {
              title: 'Bỏ qua',
              handler: () => {
                this.$modal.hide('dialog');
              }
            },
            {
              title: 'Xác nhận',
              default: true,
              handler: () => {
                return rf.getRequest('UserOvertimeRequest').approveRequest({ id: requestId }).then(() => {
                  this.$modal.hide('dialog');
                  this.$refs.datatable.refresh();
                  this.$toasted.show('Phê duyệt thành công!', {
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
      },
      rejectRequest(requestId) {
        this.$modal.show('dialog', {
          title: 'Cảnh báo!',
          text: 'Bạn có muốn từ chối yêu cầu này ?',
          buttons: [
            {
              title: 'Bỏ qua',
              handler: () => {
                this.$modal.hide('dialog');
              }
            },
            {
              title: 'Xác nhận',
              default: true,
              handler: () => {
                return rf.getRequest('UserOvertimeRequest').rejectRequest({ id: requestId }).then(() => {
                  this.$modal.hide('dialog');
                  this.$refs.datatable.refresh();
                  this.$toasted.show('Từ chối thành công!', {
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
  .vue-tabs .nav-tabs > li {
    text-decoration: none !important;
  }

  .vue-tabs .nav-tabs > li > a{
    color: #555;
  }
</style>
