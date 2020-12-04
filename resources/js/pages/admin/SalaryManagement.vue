<template>
  <div class="content">
    <template v-if="!isConfirmation">
      <div class="md-layout">
        <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-size-5">
            </div>
            <div class="md-layout-item md-size-30 label-field">Choose time</div>
          </div>
        </div>
        <div class="md-layout md-gutter">
          <div class="md-layout-item md-size-5">
          </div>
          <div class="md-layout-item md-size-30">
            <md-datepicker v-model="start_date">
              <label>Start date</label>
            </md-datepicker>
          </div>
          <div class="md-layout-item md-size-5 space-box">~</div>
          <div class="md-layout-item md-size-30">
            <md-datepicker v-model="end_date">
              <label>End date</label>
            </md-datepicker>
          </div>
        </div>
        <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100" style="margin-top: 20px">
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-size-5">
            </div>
            <div class="md-layout-item md-size-30 label-field">Choose user</div>
          </div>
        </div>
        <div class="md-layout md-gutter">
          <div class="md-layout-item md-size-5">
          </div>
          <div class="md-layout-item md-size-30">
            <md-field>
              <md-select id="user" name="user" placeholder="User" v-model="user_id">
                <template v-for="user in users">
                  <md-option :value="user.id" :key="user.id">{{ user.full_name }}</md-option>
                </template>
              </md-select>
            </md-field>
          </div>
        </div>
        <template v-if="user_id && start_date && end_date">
          <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100" style="margin-top: 20px">
            <div class="md-layout md-gutter">
              <div class="md-layout-item md-size-5">
              </div>
              <div class="md-layout-item md-size-30 label-field" style="margin-bottom: 10px">Working hours: {{ working_hours }}</div>
            </div>
          </div>
          <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100" style="margin-top: 20px">
            <div class="md-layout md-gutter">
              <div class="md-layout-item md-size-5">
              </div>
              <div class="md-layout-item md-size-30 label-field" style="margin-bottom: 10px">
                Approved absence request
                <md-field>
                  <label>Absence hours</label>
                  <md-input v-model="absence_hours" type="number"></md-input>
                </md-field>
              </div>
            </div>
            <div class="md-layout md-gutter">
              <div class="md-layout-item md-size-5">
              </div>
              <div class="md-layout-item md-size-30" style="padding-left: 0">
                <data-table :get-data="getUserAbsenceApprovedRequest" ref="absenceDatatable">
                  <th class="col_title_jp">Title</th>
                  <th class="col_start_date">Start_date</th>
                  <th class="col_end_date">End_date</th>
                  <template slot="body" slot-scope="{ item }">
                    <tr>
                      <td class="text-center" v-html="item.title"></td>
                      <td class="text-center" v-html="item.start_date"></td>
                      <td class="text-center" v-html="item.end_date"></td>
                    </tr>
                  </template>
                </data-table>
              </div>
            </div>
          </div>
          <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100" style="margin-top: 20px">
            <div class="md-layout md-gutter">
              <div class="md-layout-item md-size-5">
              </div>
              <div class="md-layout-item md-size-30 label-field" style="margin-bottom: 10px">
                Approved overtime request
                <md-field>
                  <label>Overtime hours</label>
                  <md-input v-model="overtime_hours" type="number"></md-input>
                </md-field>
              </div>
            </div>
            <div class="md-layout md-gutter">
              <div class="md-layout-item md-size-5">
              </div>
              <div class="md-layout-item md-size-30" style="padding-left: 0">
                <data-table :get-data="getUserOvertimeApprovedRequest" ref="overtimeDatatable">
                  <th class="col_title_jp">Title</th>
                  <th class="col_start_date">Start_date</th>
                  <th class="col_end_date">End_date</th>
                  <template slot="body" slot-scope="{ item }">
                    <tr>
                      <td class="text-center" v-html="item.title"></td>
                      <td class="text-center" v-html="item.start_date"></td>
                      <td class="text-center" v-html="item.end_date"></td>
                    </tr>
                  </template>
                </data-table>
              </div>
            </div>
          </div>
          <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100" style="margin-top: 20px">
            <div class="md-layout md-gutter">
              <div class="md-layout-item md-size-5"></div>
              <div class="md-layout-item md-size-30 label-field" style="margin-bottom: 10px">
                Other
                <md-field>
                  <label>Work late</label>
                  <md-input v-model="late_hours" type="number"></md-input>
                </md-field>
                <md-field>
                  <label>Support amount</label>
                  <md-input v-model="support_amount" type="number"></md-input>
                </md-field>
                <md-field>
                  <label>Bonus amount</label>
                  <md-input v-model="bonus_amount" type="number"></md-input>
                </md-field>
                <md-field>
                  <label>Violation amount</label>
                  <md-input v-model="violation_amount" type="number"></md-input>
                </md-field>
              </div>
            </div>
          </div>
          <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100" style="margin-top: 20px">
            <div class="md-layout md-gutter">
              <div class="md-layout-item md-size-5"></div>
              <md-button class="md-raised md-primary" @click="toggleConfirmation">Confirm</md-button>
            </div>
          </div>
        </template>
      </div>
    </template>
    <template v-else>
      <div class="md-layout">
        <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-size-5"></div>
            <div class="md-layout-item md-size-30 label-field" style="margin-bottom: 10px">Summary</div>
          </div>
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-size-5"></div>
            <div class="md-layout-item md-size-30 label-field" style="margin-bottom: 10px">
              <md-list>
                <md-list-item>
                  <span class="md-list-item-text">From: {{ start_date | dateFormat }}</span>
                </md-list-item>
                <md-list-item>
                  <span class="md-list-item-text">To: {{ end_date | dateFormat }}</span>
                </md-list-item>
                <md-list-item>
                  <span class="md-list-item-text">Working hours: {{ working_hours }}</span>
                </md-list-item>
                <md-list-item>
                  <span class="md-list-item-text">Absence hours: {{ absence_hours }}</span>
                </md-list-item>
                <md-list-item>
                  <span class="md-list-item-text">Overtime hours: {{ overtime_hours }}</span>
                </md-list-item>
                <md-list-item>
                  <span class="md-list-item-text">Work late: {{ late_hours }}</span>
                </md-list-item>
                <md-list-item>
                  <span class="md-list-item-text">Support amount: {{ support_amount }}</span>
                </md-list-item>
                <md-list-item>
                  <span class="md-list-item-text">Bonus amount: {{ bonus_amount }}</span>
                </md-list-item>
                <md-list-item>
                  <span class="md-list-item-text">Violation amount: {{ violation_amount }}</span>
                </md-list-item>
              </md-list>
            </div>
          </div>
        </div>
        <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100" style="margin-top: 20px">
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-size-5"></div>
            <md-button class="md-raised md-primary" @click="submitPaySlip">Submit</md-button>
            <md-button class="md-raised" style="margin-left: 10px" @click="toggleConfirmation">Cancel</md-button>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script>
import rf from '../../requests/RequestFactory';
import moment from 'moment';
export default {
  data() {
    return {
      isConfirmation: false,
      users: [],
      start_date: null,
      end_date: null,
      user_id: null,
      working_hours: 0,
      absence_hours: 0,
      overtime_hours: 0,
      late_hours: 0,
      support_amount: 0,
      bonus_amount: 0,
      violation_amount: 0
    }
  },
  watch: {
    'user_id' (newValue) {
      this.getUserAbsenceApprovedRequest(newValue);
      this.getUserOvertimeApprovedRequest(newValue);
      
      this.refresh();
    },
    'start_date' (newValue) {
      this.getWorkingHours();
    },
    'end_date' (newValue) {
      this.getWorkingHours();
    },
  },
  methods: {
    refresh() {
      this.isLoading = true;
      this.$refs.absenceDatatable.refresh();
      this.$refs.overtimeDatatable.refresh();
      this.$refs.datatable.$on('DataTable:finish', () => {
        this.isLoading = false;
      });
    },
    getEmployee() {
      return rf.getRequest('SalaryRequest').getEmployee().then(res => {
        this.users = res;
      });
    },
    getUserAbsenceApprovedRequest(params) {
      const meta = Object.assign({}, params, {
        id: this.user_id
      });
      return rf.getRequest('SalaryRequest').getUserAbsenceApprovedRequest(meta);
    },
    getUserOvertimeApprovedRequest(params) {
      const meta = Object.assign({}, params, {
        id: this.user_id
      });
      return rf.getRequest('SalaryRequest').getUserOvertimeApprovedRequest(meta);
    },
    getWorkingHours() {
      let start = moment(this.start_date);
      let end = moment(this.end_date);
      this.working_hours = (moment.duration(end.diff(start)).asDays() + 1) * 8;
    },
    filterTime(date) {
      return moment(date).format('YYYY-MM-DD');
    },
    toggleConfirmation() {
      this.isConfirmation = !this.isConfirmation;
    },
    submitPaySlip() {
      const meta = {
        user_id: this.user_id,
        start_date: moment(this.start_date).format('YYYY-MM-DD'),
        end_date: moment(this.end_date).format('YYYY-MM-DD'),
        working_hours: this.working_hours,
        absence_hours: this.absence_hours,
        overtime_hours: this.overtime_hours,
        late_hours: this.late_hours,
        support_amount: this.support_amount,
        bonus_amount: this.bonus_amount,
        violation_amount: this.violation_amount
      }
      return rf.getRequest('SalaryRequest').submitPaySlip(meta);
    }
  },
  created() {
    this.getEmployee();
  }
}
</script>

<style lang="scss">
  .label-field {
    padding-left: 0 !important;
    font-size: 18px;
    font-weight: bold;
  }
  .space-box {
    margin-top: 30px;
  }
  .md-list-item-text {
    padding-left: 12px;
    padding-top: 12px;
  }
  .md-list {
    max-width: 100%;
    display: inline-block;
    vertical-align: top;
    border: 1px solid rgba(#000, .12);
  }
</style>
