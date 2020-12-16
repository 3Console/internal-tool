<template>
  <div id="member">
    <modal name="member"
          height="auto"
          :scrollable="true"
          :click-to-close="true"
          @before-open="beforeOpen"
          @before-close="beforeClose"
          >
      <div class="content">
        <div slot="top-right">
          <md-button class="top-right md-icon-button md-accent" @click="$modal.hide('member')">
            <md-icon>close</md-icon>
          </md-button>
        </div>
        <span class="md-title">{{title}}</span>
        <!-- <md-field>
        <label>Project name</label>
          <md-input type="text"
                    :name="`${_uid}_name`"
                    data-vv-validate-on="none"
                    data-vv-as="project_name"
                    v-validate="'required|max:30'"
                    data-vv-scope="general"
                    v-model="project_name"
                    :class="errors.has(`general.${_uid}_name`) ? 'is-invalid' : ''"
                    md-counter="30">
          </md-input>
          <div v-if="errors.has(`general.${_uid}_name`)">
            <md-icon class="md-accent">warning</md-icon>
            {{errors.first(`general.${_uid}_name`)}}
          </div>
        </md-field> -->
        <md-field>
          <md-select id="user" name="user" placeholder="User" v-model="user_id">
            <template v-for="user in users">
              <md-option :value="user.id" :key="user.id">{{ user.full_name }}</md-option>
            </template>
          </md-select>
          <div v-if="errors.has(`general.${_uid}_name`)">
            <md-icon class="md-accent">warning</md-icon>
            {{errors.first(`general.${_uid}_name`)}}
          </div>
        </md-field>
        <md-field>
          <md-select id="position"
                     :name="`${_uid}_position`"
                     data-vv-validate-on="none"
                     data-vv-as="position"
                     v-validate="'required'"
                     data-vv-scope="general"
                     placeholder="Position"
                     :class="errors.has(`general.${_uid}_position`) ? 'is-invalid' : ''"
                     v-model="position">
            <template v-for="position in positions">
              <md-option :value="position.id" :key="position.id">{{ position.name }}</md-option>
            </template>
          </md-select>
          <div v-if="errors.has(`general.${_uid}_position`)">
            <md-icon class="md-accent">warning</md-icon>
            {{errors.first(`general.${_uid}_position`)}}
          </div>
        </md-field>
        <div class="md-right">
          <md-button class="md-raised md-primary" @click="submit">Submit</md-button>
          <md-button class="md-raised md-accent" @click="cancel">Cancel</md-button>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
import rf from '../requests/RequestFactory';
export default {
  data() {
    return {
      title: 'member',
      users: [],
      positions: [],
      editingId: '',
      project_id: this.$route.params.id,
      user_id: null,
      position: null
    }
  },
  methods: {
    beforeOpen (event) {
      this.title = event.params.title;
      if(event.params.memberId) {
        this.editingId = event.params.memberId;
        rf.getRequest('ProjectRequest').getMember(this.editingId).then((member)=>{
          this.user_id = member.user_id;
          this.position = member.position_id;
        });
      }
    },
    beforeClose() {
      this.editingId = '';
      this.user_id = null;
      this.position = null;
    },
    getEmployee() {
      return rf.getRequest('SalaryRequest').getEmployee().then(res => {
        this.users = res;
      });
    },
    getPositions() {
      return rf.getRequest('ProjectRequest').getPositions().then(res => {
        this.positions = res;
      });
    },
    async submit() {
      Promise.all([
        this.$validator.validateAll('general'),
      ]).then(() => {
        if (this.errors.any()) {
          return;
        }
        if(this.editingId) {
          this.updateMember();
        } else {
          this.addMember();
        }
      });
    },
    addMember() {
      rf.getRequest('ProjectRequest').addMember({user_id: this.user_id, project_id: this.project_id, position: this.position}).then((res)=>{
        this.$modal.hide('member');
        this.$emit('refresh');
      });
      this.$toasted.show('Create successfully!', {
        theme: 'bubble',
        position: 'bottom-right',
        duration : 1500,
        type: 'success'
      });
    },
    updateMember() {
      rf.getRequest('ProjectRequest').updateMember(this.editingId, {user_id: this.user_id, position: this.position}).then((res)=> {
        this.$modal.hide('member');
        this.$emit('refresh');
      });
      this.$toasted.show('Update successfully!', {
        theme: 'bubble',
        position: 'bottom-right',
        duration : 1500,
        type: 'success'
      });
    },
    cancel() {
      this.$modal.hide('member');
    }
  },
  created() {
    this.getEmployee();
    this.getPositions();
  }
}
</script>

<style lang="scss" scoped >
  .content {
    padding: 30px 30px 10px 30px;
  }
  .md-right {
    float: right;
    padding: 0px 10px 20px;
  }
  .top-right {
    float: right;
  }
  .red-outline {
    border: 1px solid red;
  }
  .md-list {
    z-index: 999 !important;
  }
</style>

<style lang="scss">
  #member {
    z-index: 10 !important;
  }
</style>
