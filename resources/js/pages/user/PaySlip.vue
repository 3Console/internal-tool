<template>
  <div style="margin: 0px 16px">
    <a-page-header style="border: 1px solid rgb(235, 237, 240)" title="Pay Slip" @back="toCategory" />
    <template v-if="payslips.length > 0">
      <div class="list">
        <template v-for="payslip in payslips">
          <div :key="payslip.id" class="list-item">
            <div class="created_at">{{ payslip.created_at | fromNow }}</div>
            <div class="title" @click="toDetail(payslip.id)">This month pay slip</div>
            <div class="duration">
              <span class="text-left">From: {{ payslip.start_date }}</span>
              <span>To: {{ payslip.end_date }}</span>
            </div>
          </div>
        </template>
      </div>
    </template>
    <template v-else>
      <div class="list">
        <div class="message">
          You have no pay slip
        </div>
      </div>
    </template>
  </div>
</template>

<script>
import rf from '../../requests/RequestFactory';
export default {
  data() {
    return {
      payslips: []
    }
  },
  methods: {
    toCategory() {
      this.$router.push('/category')
    },
    toDetail(payslip_id) {
      this.$router.push({ name: 'PaySlipDetail', params: { id: payslip_id } });
    },
    getPaySlips() {
      return rf.getRequest('SalaryRequest').getPaySlips().then(res => {
        this.payslips = res;
      })
    }
  },
  created() {
    this.getPaySlips();
  }
}
</script>

<style lang="scss">
  .list {
    .message {
      padding: 24px 16px;
      font-size: 24px;
      color: #476282;
    }

    .list-item {
      padding: 24px 16px;
      border-bottom: 1px solid #d8d8d8;

      .created_at {
        font-size: 12px;
      }

      .title {
        font-size: 24px;
        color: #476282;
        cursor: pointer;

        &:hover {
          color: #317eda;
        }
      }

      .duration {
        .text-left {
          margin-right: 10px;
        }
      }
    }
  }
</style>
