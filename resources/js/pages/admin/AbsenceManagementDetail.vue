<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout md-gutter" style="margin-bottom: 40px">
        <div class="md-layout-item md-size-5">
        </div>
        <div class="md-layout-item md-size-30">
          <div @click="toAbsenceList()" style="cursor: pointer">
            <md-icon>keyboard_backspace</md-icon>
            <span class="label-back">Back</span>
          </div>
        </div>
      </div>
      <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
        <div class="content-box">
          <div class="md-layout md-gutter content-detail">
            <div class="md-layout-item md-size-5">
            </div>
            <div class="md-layout-item md-size-15 label-detail">
              User: 
            </div>
            <div class="md-layout-item text-detail">
              {{ absence.full_name }} ({{ absence.email }})
            </div>
          </div>
          <div class="md-layout md-gutter content-detail">
            <div class="md-layout-item md-size-5">
            </div>
            <div class="md-layout-item md-size-15 label-detail">
              Title: 
            </div>
            <div class="md-layout-item text-detail">
              {{ absence.title }}
            </div>
          </div>
          <div class="md-layout md-gutter content-detail">
            <div class="md-layout-item md-size-5">
            </div>
            <div class="md-layout-item md-size-15 label-detail">
              Absence Type: 
            </div>
            <div class="md-layout-item text-detail">
              {{ absence.absence_type }}
            </div>
          </div>
          <div class="md-layout md-gutter content-detail">
            <div class="md-layout-item md-size-5">
            </div>
            <div class="md-layout-item md-size-15 label-detail">
              From: 
            </div>
            <div class="md-layout-item text-detail">
              {{ absence.start_date }}
            </div>
          </div>
          <div class="md-layout md-gutter content-detail">
            <div class="md-layout-item md-size-5">
            </div>
            <div class="md-layout-item md-size-15 label-detail">
              To: 
            </div>
            <div class="md-layout-item text-detail">
              {{ absence.end_date }}
            </div>
          </div>
          <div class="md-layout md-gutter content-detail">
            <div class="md-layout-item md-size-5">
            </div>
            <div class="md-layout-item md-size-15 label-detail">
              Reason: 
            </div>
            <div class="md-layout-item text-detail">
              {{ absence.reason }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import rf from '../../requests/RequestFactory';

export default {
  data() {
    return {
      absence: {},
      absence_id: this.$route.params.id
    }
  },
  methods: {
    toAbsenceList() {
      this.$router.push({ name: 'Absence Management' });
    },
    getAbsenceDetail() {
      return rf.getRequest('UserAbsenceRequest').getUserAbsenceDetail(this.absence_id).then(res => {
        this.absence = res;
      });
    }
  },
  created() {
    this.getAbsenceDetail();
  }
}
</script>

<style lang="scss">
  .label-back {
    margin-left: 10px;
    font-size: 20px;
    vertical-align: middle;
  }

  .content-box {
    border: 1px solid #d8d8d8;
    padding-top: 20px;
    margin-left: 45px;

    .content-detail {
      margin-bottom: 20px;

      .label-detail {
        font-size: 18px;
        font-weight: bold;
      }

      .text-detail {
        font-size: 18px;
      }
    }
  }
</style>
