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
        <div class="md-layout-item md-size-35">
        </div>
        <div class="md-layout-item">
          <md-button  class="md-success" @click="createEmployee">Add</md-button>
          <md-button  class="md-info" @click="refresh">Refresh</md-button>
          <md-button  class="md-danger" @click="removeManyEmployees()">Delete</md-button>
        </div>
      </div>
      <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
        <md-card>
          <md-card-header data-background-color="green">
            <h4 class="title">Employees</h4>
            <p class="category">Here is a subtitle for this table</p>
          </md-card-header>
          <md-card-content>
            <data-table :get-data="getData" ref="datatable">
                <th class="col_checkbox">
                  <md-checkbox :plain="true" v-model="selectedAll"></md-checkbox>
                </th>
                <th class="col_title_en">Username</th>
                <th class="col_title_jp">Email</th>
                <th class="col_summary_en">Full Name</th>
                <th class="col_created_at">Created At</th>
                <th class="col_tools">Action</th>
                <template slot="body" slot-scope="{ item }">
                  <tr>
                    <td class="text-center">
                      <md-checkbox v-model="item.selected" @input="listenSelectRow"></md-checkbox>
                    </td>
                    <td class="text-center" v-html="item.name"></td>
                    <td class="text-center" v-html="item.email"></td>
                    <td class="text-center" v-html="item.full_name"></td>
                    <td class="text-center" v-html="item.created_at"></td>
                    <td class="text-center">
                        <md-button class="md-just-icon md-simple md-primary" @click="editEmployee(item.id)">
                          <md-icon>edit</md-icon>
                          <md-tooltip md-direction="top">Edit</md-tooltip>
                        </md-button>
                        <md-button class="md-just-icon md-simple md-danger" @click="removeOneEmployee(item.id)">
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
      <EmployeeModal @refresh="refresh()"/>
    </div>
  </div>
</template>

<script>
import {
  SimpleTable,
  OrderedTable
} from '@/components'

import rf from '../../requests/RequestFactory';
import EmployeeModal from '../../modals/Employee';

export default{
  components: {
    OrderedTable,
    SimpleTable,
    EmployeeModal
  },
  data () {
    return {
      searchInput: '',
      selectedAll: false
    }
  },
  methods: {
    removeOneEmployee(employeeId) {
      this.$modal.show('dialog', {
        title: 'Warning!',
        text: 'Are you sure to delete ?',
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
              return rf.getRequest('EmployeeRequest').removeOneEmployee(employeeId).then(() => {
                this.$modal.hide('dialog');
                this.$refs.datatable.refresh();
                this.$toasted.show('Delete employee successfully!', {
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
    removeManyEmployees() {
        this.$modal.show('dialog', {
          title: 'Warning!',
          text: 'Are you sure to delete ?',
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
                const employeeIds = this.$refs.datatable.rows.filter((row) => {
                  return row.selected === true;
                }).map(record => record.id);

                return rf.getRequest('EmployeeRequest').removeManyEmployeess(employeeIds).then(() => {
                  this.$modal.hide('dialog');
                  this.$refs.datatable.refresh();
                  this.$toasted.show('Delete employee successfully!', {
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
      createEmployee() {
        this.$modal.show('employee', {title: 'Add employee'});
      },
      editEmployee(employeeId) {
        this.$modal.show('employee', {title: 'Edit employee', employeeId: employeeId});
      },
      listenSelectRow() {
        if (!this.$refs.datatable) {
          return true;
        }

        this.selectedAll = this.$refs.datatable.rows.filter(row => row.selected === true).length === this.$refs.datatable.rows.length;
      },
      getData (params) {
        const meta = Object.assign({}, params, {
          search: this.searchInput,
        });
        return rf.getRequest('EmployeeRequest').getStudents(meta);
      },
      refresh() {
        this.isLoading = true;
        this.$refs.datatable.refresh();
        this.$refs.datatable.$on('DataTable:finish', () => {
          this.isLoading = false;
        });
      },
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
  }
}
</script>
