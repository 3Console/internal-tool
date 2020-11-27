<template>
  <div class="profile-page">
    <div class="banner"></div>
    <div class="avatar">
      <a-avatar :size="128" icon="user" class="icon-avatar" />
      <span class="username">{{ user.full_name }}</span>
      <div class="tagname">@{{ user.name }}</div>
      <div class="tab-menu">
        <a-tabs type="card">
          <a-tab-pane key="1" tab="Profile">
            <div class="edit-field">
              <a-button type="primary" v-if="!isEdit" @click="toggleEdit()"><a-icon type="edit" /> Edit profile</a-button>
              <a-button type="default" v-else @click="toggleEdit()"><a-icon type="close" /> Cancel</a-button>
            </div>
            <template v-if="!isEdit">
              <div class="description-content">
                <div class="content-item">
                  <a-row>
                    <a-col :span="3">
                      <a-icon type="mail" />
                      <label>Email:</label>
                    </a-col>
                    <a-col :span="9">
                      <span>{{ user.email }}</span>
                    </a-col>
                  </a-row>
                </div>
                <div class="content-item">
                  <a-row>
                    <a-col :span="3">
                      <a-icon type="phone" />
                      <label>Phone:</label>
                    </a-col>
                    <a-col :span="9">
                      <span>{{ user.phone_number || 'N/A' }}</span>
                    </a-col>
                  </a-row>
                </div>
                <div class="content-item">
                  <a-row>
                    <a-col :span="3">
                      <a-icon type="environment" />
                      <label>Address:</label>
                    </a-col>
                    <a-col :span="9">
                      <span>{{ user.address || 'N/A' }}</span>
                    </a-col>
                  </a-row>
                </div>
              </div>
            </template>
            <template v-else>
              <div class="description-content">
                <a-form>
                  <a-form-item label="Email">
                    <a-input
                      v-model="user.email"
                      style="width: 30%"
                    />
                  </a-form-item>
                  <a-form-item label="Phone number">
                    <a-input
                      v-model="user.phone_number"
                      style="width: 30%"
                    />
                  </a-form-item>
                  <a-form-item label="Address">
                    <a-input
                      v-model="user.address"
                      style="width: 30%"
                    />
                  </a-form-item>
                  <!-- <a-form-item label="Content">
                    <a-textarea :rows="4" v-decorator="['content']" style="width: 30%" />
                  </a-form-item> -->
                  <a-form-item>
                    <a-button type="primary" @click="handleSubmit()">
                      Submit
                    </a-button>
                  </a-form-item>
                </a-form>
              </div>
            </template>
          </a-tab-pane>
          <a-tab-pane key="2" tab="Statistic">
            Content of Tab Pane 2
          </a-tab-pane>
        </a-tabs>
      </div>
    </div>
  </div>
</template>

<script>
import rf from '../../requests/RequestFactory';
export default {
  data() {
    return {
      user: {},
      isEdit: false,
      form: this.$form.createForm(this, { name: 'profile_form' }),
    }
  },
  methods: {
    handleSubmit() {
      return rf.getRequest('UserRequest').updateProfile(this.user)
      .then(res => {
        this.$notification.open({
          message: 'Notification',
          description: 'Update successfully!',
        });
        this.toggleEdit();
      })
      .catch(err => {
        this.$notification.open({
          message: 'Warning',
          description: `${err}`,
        })
      });
    },
    getProfile() {
      return rf.getRequest('UserRequest').getProfile().then(res => {
        this.user = res;
      })
    },
    toggleEdit() {
      this.isEdit = !this.isEdit;
    }
  },
  created() {
    this.getProfile();
  }
}
</script>

<style lang="scss" scoped>
  .profile-page {
    height: 100%;

    .banner {
      height: 200px;
      background-image: url('https://i.pinimg.com/originals/78/81/2f/78812fd262025d24e53452a1307bbb6d.png');
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
    }

    .avatar {
      padding: 24px 240px;
      position: relative;
      top: -60px;

      .icon-avatar {
        margin-top: 10px;
      }

      .username {
        font-size: 36px;
        font-weight: bold;
        position: relative;
        top: 15px;
        left: 20px;
      }

      .tagname {
        position: relative;
        left: 155px;
        top: -35px;
      }

      .tab-menu {
        .edit-field {
          margin-bottom: 10px;
          text-align: right;
        }

        .description-content {
          padding: 12px;
          padding-bottom: 0;
          border: 1px solid #d8d8d8;

          .content-item {
            margin-bottom: 20px;

          }
        }
      }
    }
  }

a.nostyle {
    color: inherit;
    text-decoration: none;
    padding: 0;
    margin: 0;
}

div.portfoliocard {
    position: relative;
    height: 450px;
    width: 400px;
    background: rgba(255, 255, 255, 1);
    border: 1px solid rgba(0, 0, 0, 0.7);
    box-shadow: 0px -1px 3px rgba(0, 0, 0, 0.1),
        0px 2px 6px rgba(0, 0, 0, 0.5);
    border-radius: 6px;
    margin: 10% auto;
    overflow: hidden;
    z-index: 100;
}

div.portfoliocard div.coverphoto {
    width: 100%;
    height: 120px;
    background: url('http://farm8.staticflickr.com/7149/6484148411_baf8d2e934_z.jpg');
    background-position: center center;
    border-top-right-radius: 5px;
    border-top-left-radius: 5px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    box-shadow: inset 0px 3px 20px rgba(255, 255, 255, 0.3),
        1px 0px 2px rgba(255, 255, 255, 0.7);
    z-index: 99;
}

div.portfoliocard div.left_col,
div.portfoliocard div.right_col {
    float: left;
    height: 340px;
}

div.portfoliocard div.left_col {
    width: 40%;
    padding-top: 85px;
    box-sizing: border-box;
}

div.portfoliocard div.right_col {
    width: 60%;
    background: rgba(245, 245, 245, 1);
    border-left: 1px solid rgba(230, 230, 230, 1);
    box-shadow: inset 0px 1px 1px rgba(255, 255, 255, 0.7);
    margin-left: -1px;
    border-bottom-right-radius: 5px;
}

div.portfoliocard div.profile_picture {
    width: 110px;
    height: 110px;
    background: rgba(255, 255, 255, 1);
    position: absolute;
    top: 65px;
    left: 40px;
    border-radius: 100%;
    background-image: url('http://cache.spreadshirt.net/Public/Common/images/profile-pic-placeholder_130x130.png');
    background-size: 100% 100%;
    padding: 7px;
    border: 4px solid rgba(255, 255, 255, 1)
}

div.portfoliocard div.right_col h2.name {
    font-size: 30px;
    font-weight: 300;
    color: rgba(30, 30, 30, 1);
    padding: 0;
    margin: 20px 10px 0px 30px;
}

div.portfoliocard div.right_col h3.location {
    font-size: 15px;
    font-weight: 300;
    color: rgba(170, 170, 170, 1);
    padding: 0;
    margin: -5px 10px 10px 30px;
}

div.portfoliocard ul.contact_information {
    margin-top: 20px;
    padding-left: 30px;
    list-style-type: none;
}

div.portfoliocard ul.contact_information li {
    height: 25px;
    width: 180px;
    line-height: 25px;
    font-weight: 300;
    font-size: 15px;
    color: rgba(140, 140, 140, 1);
    text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.8);
    padding: 5px 0px;
    background-repeat: no-repeat;
    background-size: 18px 18px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    box-shadow: 0px 1px 1px rgba(255, 255, 255, 0.6);
    cursor: default;
}

div.portfoliocard ul.contact_information li:before {
    content: "";
    width: 25px;
    height: 25px;
    display: block;
    float: left;
    background-position: center;
    background-size: 18px 18px;
    background-repeat: no-repeat;
    margin-right: 5px;
    opacity: 0.7;
}

div.portfoliocard ul.contact_information li:hover:before {
    opacity: 1;
}

div.portfoliocard ul.contact_information li.work:before {
    background-image: url('http://schulzmarcel.de/x/icons/case_24.png');
}

div.portfoliocard ul.contact_information li.website:before {
    background-image: url('http://schulzmarcel.de/x/icons/globe_24.png');
}

div.portfoliocard ul.contact_information li.mail:before {
    background-image: url('http://schulzmarcel.de/x/icons/paper_plane_24.png');
}

div.portfoliocard ul.contact_information li.phone:before {
    background-image: url('http://schulzmarcel.de/x/icons/phone_24.png');
}

div.portfoliocard ul.contact_information li.resume:before {
    background-image: url('http://schulzmarcel.de/x/icons/inbox_24.png');
}

div.portfoliocard div.followers,
div.portfoliocard div.following {
    margin: 15px 0px 0px 35px;
    font-weight: 300;
    font-size: 16px;
    color: rgba(30, 30, 30, 1);
}

div.portfoliocard div.follow_count {
    font-weight: 400;
    font-size: 25px;
    color: rgba(140, 140, 140, 1);
}
</style>
