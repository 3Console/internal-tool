<template>
  <div>
    <a-page-header style="border: 1px solid rgb(235, 237, 240)" title="Absence" @back="toCategory" />
    <div class="form-field">
      <a-form :form="form" @submit="handleSubmit">
        <a-form-item label="Title">
          <a-input
            v-decorator="['title', { rules: [{ required: true, message: 'Please input your title!' }] }]"
            style="width: 30%"
          />
        </a-form-item>
        <a-form-item label="Absence type">
          <a-select
            v-decorator="[
              'absence_type',
              { rules: [{ required: true, message: 'Please select an absence type!' }] },
            ]"
            style="width: 30%"
            placeholder="Select a type"
          >
            <a-select-option v-for="type in absenceTypes" :value="type.id" :key="type.id">
              {{ type.name }}
            </a-select-option>
          </a-select>
        </a-form-item>
        <a-form-item label="Duration">
          <a-date-picker v-decorator="['start_date', config]" />
          ~
          <a-date-picker v-decorator="['end_date', config]" />
        </a-form-item>
        <a-form-item label="Content">
          <a-textarea :rows="4" v-decorator="['content', { rules: [{ required: true, message: 'Please input your content!' }] }]" style="width: 30%" />
        </a-form-item>
        <a-form-item>
          <a-button type="primary" html-type="submit">
            Submit
          </a-button>
        </a-form-item>
      </a-form>
    </div>
  </div>
</template>

<script>
import rf from '../../requests/RequestFactory';
import moment from 'moment';

export default {
  data() {
    return {
      form: this.$form.createForm(this, { name: 'absence_form' }),
      config: {
        rules: [{ type: 'object', required: true, message: 'Please select time!' }],
      },
      absenceTypes: []
    }
  },
  methods: {
    handleSubmit(e) {
      e.preventDefault();
      this.form.validateFields((err, values) => {
        if (!err) {
          this.createAbsenceRequest(values);
        }
      });
    },
    toCategory() {
      this.$router.push('/category')
    },
    createAbsenceRequest(params) {
      return rf.getRequest('UserAbsenceRequest').createAbsenceRequest({
        ...params,
        start_date: moment(params.start_date).format('YYYY-MM-DD'),
        end_date: moment(params.end_date).format('YYYY-MM-DD')
      }).then(res => {
        this.$notification.open({
          message: 'Notification',
          description: 'Create request successfully!',
        })
      })
      .catch(err => {
        this.$notification.open({
          message: 'Warning',
          description: `${err}`,
        })
      });
    },
    getAbsenceTypes() {
      return rf.getRequest('UserAbsenceRequest').getAbsenceTypes().then(res => {
        this.absenceTypes = res;
      })
    }
  },
  created() {
    this.getAbsenceTypes();
  }
}
</script>

<style lang="scss">
  .form-field {
    padding: 20px;
  }
</style>
