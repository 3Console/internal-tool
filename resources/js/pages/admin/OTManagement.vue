<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout md-gutter">
        <div class="md-layout-item md-size-5">
        </div>
        <div class="md-layout-item md-size-30">
          <md-field >
            <label>Search</label>
            <md-input type="text" name="text" v-model="searchInput" @keyup.enter="$refs.datatable.refresh()"></md-input>
            <md-icon>search</md-icon>
          </md-field>
        </div>
      </div>
      <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
        <md-card>
          <md-card-header data-background-color="green">
            <h4 class="title">Overtime Requests</h4>
            <p class="category">Here is a subtitle for this table</p>
          </md-card-header>
          <md-card-content>
            <vue-tabs
              active-tab-color="#4caf50" 
              active-text-color="#fff"
            >
              <v-tab title="Pending">
                <data-table :get-data="getPendingRequest" ref="datatable">
                  <th class="col_checkbox">
                    <md-checkbox :plain="true" v-model="selectedAll"></md-checkbox>
                  </th>
                  <th class="col_title_en">Username</th>
                  <th class="col_title_jp">Title</th>
                  <th class="col_created_at">Created At</th>
                  <th class="col_tools">Action</th>
                  <template slot="body" slot-scope="{ item }">
                    <tr>
                      <td class="text-center">
                        <md-checkbox v-model="item.selected" @input="listenSelectRow"></md-checkbox>
                      </td>
                      <td class="text-center" v-html="item.name"></td>
                      <td class="text-center" v-html="item.title" @click="toOvertimeDetail(item.request_id)" style="cursor: pointer"></td>
                      <td class="text-center" v-html="item.created_at"></td>
                      <td class="text-center">
                          <md-button class="md-just-icon md-simple md-primary" @click="approveRequest(item.request_id)">
                            <md-icon>done</md-icon>
                            <md-tooltip md-direction="top">Approve</md-tooltip>
                          </md-button>
                          <md-button class="md-just-icon md-simple md-danger" @click="rejectRequest(item.request_id)">
                            <md-icon>close</md-icon>
                            <md-tooltip md-direction="top">Reject</md-tooltip>
                          </md-button>
                      </td>
                    </tr>
                  </template>
                </data-table>
              </v-tab>
              <v-tab title="Approved">
                <data-table :get-data="getApprovedRequest">
                  <th class="col_checkbox">
                    <md-checkbox :plain="true" v-model="selectedAll"></md-checkbox>
                  </th>
                  <th class="col_title_en">Username</th>
                  <th class="col_title_jp">Title</th>
                  <th class="col_created_at">Created At</th>
                  <template slot="body" slot-scope="{ item }">
                    <tr>
                      <td class="text-center">
                        <md-checkbox v-model="item.selected" @input="listenSelectRow"></md-checkbox>
                      </td>
                      <td class="text-center" v-html="item.name"></td>
                      <td class="text-center" v-html="item.title" @click="toOvertimeDetail(item.request_id)" style="cursor: pointer"></td>
                      <td class="text-center" v-html="item.created_at"></td>
                    </tr>
                  </template>
                </data-table>
              </v-tab>
              <v-tab title="Rejected">
                <data-table :get-data="getRejectedRequest">
                  <th class="col_checkbox">
                    <md-checkbox :plain="true" v-model="selectedAll"></md-checkbox>
                  </th>
                  <th class="col_title_en">Username</th>
                  <th class="col_title_jp">Title</th>
                  <th class="col_created_at">Created At</th>
                  <template slot="body" slot-scope="{ item }">
                    <tr>
                      <td class="text-center">
                        <md-checkbox v-model="item.selected" @input="listenSelectRow"></md-checkbox>
                      </td>
                      <td class="text-center" v-html="item.name"></td>
                      <td class="text-center" v-html="item.title" @click="toOvertimeDetail(item.request_id)" style="cursor: pointer"></td>
                      <td class="text-center" v-html="item.created_at"></td>
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
      toOvertimeDetail(request_id) {
        this.$router.push({ name: 'Overtime Management Detail', params: { id: request_id } });
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
          title: 'Warning!',
          text: 'Are you sure to approve this request ?',
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
                return rf.getRequest('UserOvertimeRequest').approveRequest({ id: requestId }).then(() => {
                  this.$modal.hide('dialog');
                  this.$refs.datatable.refresh();
                  this.$toasted.show('Approve successfully!', {
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
          title: 'Warning!',
          text: 'Are you sure to reject this request ?',
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
                return rf.getRequest('UserOvertimeRequest').rejectRequest({ id: requestId }).then(() => {
                  this.$modal.hide('dialog');
                  this.$refs.datatable.refresh();
                  this.$toasted.show('Reject successfully!', {
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
