<template>
  <div style="margin: 0px 16px">
    <a-page-header style="border: 1px solid rgb(235, 237, 240)" title="Pay Slip Detail" @back="toPaySlip" />
    <div style="padding: 24px">
      <a-descriptions title="Pay Slip Info" bordered :column=2>
        <a-descriptions-item label="Name">
          {{ payslip.full_name }}
        </a-descriptions-item>
        <a-descriptions-item label="DOB">
          01/01/2000
        </a-descriptions-item>
        <a-descriptions-item label="Address" :span="2">
          {{ payslip.address }}
        </a-descriptions-item>
        <a-descriptions-item label="Email">
          {{ payslip.email }}
        </a-descriptions-item>
        <a-descriptions-item label="ID Number">
          123456789
        </a-descriptions-item>
        <a-descriptions-item label="Slip ID">
          SLIP/{{ payslip.id }}
        </a-descriptions-item>
        <a-descriptions-item label="Bank account">
          12345678
        </a-descriptions-item>
        <a-descriptions-item label="From">
          {{ payslip.start_date }}
        </a-descriptions-item>
        <a-descriptions-item label="To">
          {{ payslip.end_date }}
        </a-descriptions-item>
      </a-descriptions>
      <a-descriptions bordered :column=1 style="margin-top: 10px">
        <a-descriptions-item label="Working hours">
          {{ payslip.working_hours }}
        </a-descriptions-item>
        <a-descriptions-item label="Absence hours">
          {{ payslip.absence_hours }}
        </a-descriptions-item>
        <a-descriptions-item label="Overtime hours">
          {{ payslip.overtime_hours }}
        </a-descriptions-item>
        <a-descriptions-item label="Late hours">
          {{ payslip.late_hours }}
        </a-descriptions-item>
        <a-descriptions-item label="Support amount">
          {{ payslip.support_amount }}
        </a-descriptions-item>
        <a-descriptions-item label="Bonus amount">
          {{ payslip.bonus_amount }}
        </a-descriptions-item>
        <a-descriptions-item label="Violation amount">
          {{ payslip.violation_amount }}
        </a-descriptions-item>
      </a-descriptions>
    </div>
  </div>
</template>

<script>
import rf from '../../requests/RequestFactory';
export default {
  data() {
    return {
      payslip: {},
      payslip_id: this.$route.params.id
    }
  },
  methods: {
    toPaySlip() {
      this.$router.push('/payslip');
    },
    getPaySlipDetail() {
      return rf.getRequest('SalaryRequest').getPaySlipDetail(this.payslip_id).then(res => {
        this.payslip = res;
      })
    }
  },
  created() {
    this.getPaySlipDetail();
  }
}
</script>

<style lang="scss">
  .ant-descriptions-bordered .ant-descriptions-view {
    border: 1px solid #d8d8d8 !important;
  }
</style>
