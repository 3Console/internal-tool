<template>
  <div style="margin: 0px 16px">
    <a-page-header style="border: 1px solid rgb(235, 237, 240)" title="Notifications" @back="toCategory" />
    <template v-if="!seeDetail">
      <div class="list">
        <template v-for="notification in notifications">
          <div :key="notification.id" class="list-item">
            <div class="created_at">{{ notification.created_at | fromNow }}</div>
            <div class="title" @click="openDetail(notification.id)">{{ notification.title }}</div>
          </div>
        </template>
      </div>
    </template>
    <template v-else>
      <a-row>
        <a-col :span="12" style="padding-right: 12px; border-right: 1px solid #d8d8d8; height: 100vh">
          <div class="list">
            <template v-for="notification in notifications">
              <div :key="notification.id" class="list-item">
                <div class="created_at">{{ notification.created_at | fromNow }}</div>
                <div class="title" @click="openDetail(notification.id)">{{ notification.title }}</div>
              </div>
            </template>
          </div>
        </a-col>
        <a-col :span="12">
          <div class="detail-box">
            <div class="detail-header">
              HIHI
              <span class="close-icon" @click="closeDetail"><a-icon type="close" /></span>
            </div>
            <div class="detail-content">
              <div class="time">2020-12-08</div>
              <div class="sender">From: Admin</div>
              <div class="content">Lorem ipsum quam sit</div>
            </div>
          </div>
        </a-col>
      </a-row>
    </template>
  </div>
</template>

<script>
import rf from '../../requests/RequestFactory';
export default {
  data() {
    return {
      notifications: [],
      seeDetail: false
    }
  },
  methods: {
    toCategory() {
      this.$router.push('/category')
    },
    openDetail(payslip_id) {
      this.seeDetail = true;
    },
    closeDetail() {
      this.seeDetail = false;
    },
    getAllNotifications() {
      return rf.getRequest('NotificationRequest').getAllNotifications().then(res => {
        this.notifications = res;
      })
    }
  },
  created() {
    this.getAllNotifications();
  }
}
</script>

<style lang="scss">
  .list {
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

  .detail-box {
    padding: 24px 16px;

    .detail-header {
      font-size: 24px;
      border-bottom: 1px solid #d8d8d8;
      padding-bottom: 15px;

      .close-icon {
        float: right;
        cursor: pointer;
      }
    }

    .detail-content {
      margin-top: 20px;

      .time {
        margin-bottom: 10px;
      }

      .sender {
        font-size: 18px;
        margin-bottom: 10px;
      }
    }
  }
</style>
