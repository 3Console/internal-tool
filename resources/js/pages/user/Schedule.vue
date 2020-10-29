<template>
<div class="schedule">
    <button @click="handlePushNotification()">Bật thông báo</button>

    <button @click="handeTestNotification()">Kiểm tra thông báo</button>
    <br>
    <md-table style="width: 1000px;">
        <md-table-row>
            <md-table-head md-numeric>STT</md-table-head>
            <md-table-head>Token</md-table-head>
            <md-table-head>Ngày tạo</md-table-head>
        </md-table-row>

        <md-table-row v-for="(token, index) in tokens" :key="token.id">
            <md-table-cell md-numeric>{{index + 1}}</md-table-cell>
            <md-table-cell>{{token.token}}</md-table-cell>
            <md-table-cell>{{token.created_at}}</md-table-cell>
        </md-table-row>
    </md-table>
    <br>
    <table class="dayparts table">
        <thead>
            <tr>
                <td class="cell-label presets-label"></td>
                <td colspan="24"><span class="cell-label presetsSubtitle-label"></span>
                </td>
            </tr>
            <tr>
                <td rowspan="2"></td>
                <!-- <td class="cell-label am-label" colspan="12">Sáng</td>
                <td class="cell-label pm-label" colspan="12">Chiều</td> -->
            </tr>
            <tr class="hour-row">
                <td class="hour" v-for="hour in times" :value="hour.hour">
                    {{hour.hour}}
                </td>
            </tr>
        </thead>
        <tbody>
            <tr class="day" v-for="day in days">
                <td class="cell-label day-label" :value="day.dayNumber" :day-value="day.dayNumber">
                    {{day.dayName}}
                </td>
                <td class='dayparts-cell' :value="hour.hour" data='day' :class="{active: hour.isActive}" @click="activateDay(day, hour)" v-for='hour in day.times'></td>
            </tr>
        </tbody>
    </table>
    <button @click="saveSchedule()">Lưu lịch</button>
</div>
</template>

<script>
import rf from './../../requests/RequestFactory';
import moment from 'moment';

export default {
    watch: {
        days: {
            deep: true,
            immediate: true,
            handler: function (val, oldVal) {
                console.log(JSON.parse(JSON.stringify(this.days)).map(day => {
                    day.times = day.times.filter((time) => {
                        return time.isActive;
                    }).map(time => {
                        return time.hour;
                    })

                    if (day.times.length) {
                        let newDay = {};
                        newDay.dayNumber = day.dayNumber;
                        newDay.times = day.times;
                        return newDay;
                    }
                    return null;
                }).filter(Boolean));
            }
        },
    },
    data() {
        return {
            tokens: [],
            times: [ {
                hour: 7,
                isActive: false
            }, {
                hour: 8,
                isActive: false
            }, {
                hour: 9,
                isActive: false
            }, {
                hour: 10,
                isActive: false
            }, {
                hour: 11,
                isActive: false
            }, {
                hour: 12,
                isActive: false
            }, {
                hour: 13,
                isActive: false
            }, {
                hour: 14,
                isActive: false
            }, {
                hour: 15,
                isActive: false
            }, {
                hour: 16,
                isActive: false
            }, {
                hour: 17,
                isActive: false
            }, {
                hour: 18,
                isActive: false
            }, {
                hour: 19,
                isActive: false
            }, {
                hour: 20,
                isActive: false
            }, {
                hour: 21,
                isActive: false
            }, {
                hour: 22,
                isActive: false
            }, {
                hour: 23,
                isActive: false
            }, ],
            days: [{
                dayName: "Thứ hai",
                isActive: false,
                dayNumber: 0,
                times: [ {
                    hour: 7,
                    isActive: false
                }, {
                    hour: 8,
                    isActive: false
                }, {
                    hour: 9,
                    isActive: false
                }, {
                    hour: 10,
                    isActive: false
                }, {
                    hour: 11,
                    isActive: false
                }, {
                    hour: 12,
                    isActive: false
                }, {
                    hour: 13,
                    isActive: false
                }, {
                    hour: 14,
                    isActive: false
                }, {
                    hour: 15,
                    isActive: false
                }, {
                    hour: 16,
                    isActive: false
                }, {
                    hour: 17,
                    isActive: false
                }, {
                    hour: 18,
                    isActive: false
                }, {
                    hour: 19,
                    isActive: false
                }, {
                    hour: 20,
                    isActive: false
                }, {
                    hour: 21,
                    isActive: false
                }, {
                    hour: 22,
                    isActive: false
                }, {
                    hour: 23,
                    isActive: false
                }, ]
            }, {
                dayName: "Thứ ba",
                isActive: false,
                dayNumber: 1,
                times: [ {
                        hour: 7,
                        isActive: false
                    }, {
                        hour: 8,
                        isActive: false
                    }, {
                        hour: 9,
                        isActive: false
                    }, {
                        hour: 10,
                        isActive: false
                    }, {
                        hour: 11,
                        isActive: false
                    }, {
                        hour: 12,
                        isActive: false
                    }, {
                        hour: 13,
                        isActive: false
                    }, {
                        hour: 14,
                        isActive: false
                    }, {
                        hour: 15,
                        isActive: false
                    }, {
                        hour: 16,
                        isActive: false
                    }, {
                        hour: 17,
                        isActive: false
                    }, {
                        hour: 18,
                        isActive: false
                    }, {
                        hour: 19,
                        isActive: false
                    }, {
                        hour: 20,
                        isActive: false
                    }, {
                        hour: 21,
                        isActive: false
                    }, {
                        hour: 22,
                        isActive: false
                    }, {
                        hour: 23,
                        isActive: false
                    },

                ]
            }, {
                dayName: "Thứ tư",
                isActive: false,
                dayNumber: 2,
                times: [ {
                        hour: 7,
                        isActive: false
                    }, {
                        hour: 8,
                        isActive: false
                    }, {
                        hour: 9,
                        isActive: false
                    }, {
                        hour: 10,
                        isActive: false
                    }, {
                        hour: 11,
                        isActive: false
                    }, {
                        hour: 12,
                        isActive: false
                    }, {
                        hour: 13,
                        isActive: false
                    }, {
                        hour: 14,
                        isActive: false
                    }, {
                        hour: 15,
                        isActive: false
                    }, {
                        hour: 16,
                        isActive: false
                    }, {
                        hour: 17,
                        isActive: false
                    }, {
                        hour: 18,
                        isActive: false
                    }, {
                        hour: 19,
                        isActive: false
                    }, {
                        hour: 20,
                        isActive: false
                    }, {
                        hour: 21,
                        isActive: false
                    }, {
                        hour: 22,
                        isActive: false
                    }, {
                        hour: 23,
                        isActive: false
                    },

                ]
            }, {
                dayName: "Thứ năm",
                isActive: false,
                dayNumber: 3,
                times: [ {
                        hour: 7,
                        isActive: false
                    }, {
                        hour: 8,
                        isActive: false
                    }, {
                        hour: 9,
                        isActive: false
                    }, {
                        hour: 10,
                        isActive: false
                    }, {
                        hour: 11,
                        isActive: false
                    }, {
                        hour: 12,
                        isActive: false
                    }, {
                        hour: 13,
                        isActive: false
                    }, {
                        hour: 14,
                        isActive: false
                    }, {
                        hour: 15,
                        isActive: false
                    }, {
                        hour: 16,
                        isActive: false
                    }, {
                        hour: 17,
                        isActive: false
                    }, {
                        hour: 18,
                        isActive: false
                    }, {
                        hour: 19,
                        isActive: false
                    }, {
                        hour: 20,
                        isActive: false
                    }, {
                        hour: 21,
                        isActive: false
                    }, {
                        hour: 22,
                        isActive: false
                    }, {
                        hour: 23,
                        isActive: false
                    },

                ]
            }, {
                dayName: "Thứ sáu",
                isActive: false,
                dayNumber: 4,
                times: [ {
                        hour: 7,
                        isActive: false
                    }, {
                        hour: 8,
                        isActive: false
                    }, {
                        hour: 9,
                        isActive: false
                    }, {
                        hour: 10,
                        isActive: false
                    }, {
                        hour: 11,
                        isActive: false
                    }, {
                        hour: 12,
                        isActive: false
                    }, {
                        hour: 13,
                        isActive: false
                    }, {
                        hour: 14,
                        isActive: false
                    }, {
                        hour: 15,
                        isActive: false
                    }, {
                        hour: 16,
                        isActive: false
                    }, {
                        hour: 17,
                        isActive: false
                    }, {
                        hour: 18,
                        isActive: false
                    }, {
                        hour: 19,
                        isActive: false
                    }, {
                        hour: 20,
                        isActive: false
                    }, {
                        hour: 21,
                        isActive: false
                    }, {
                        hour: 22,
                        isActive: false
                    }, {
                        hour: 23,
                        isActive: false
                    },

                ]
            }, {
                dayName: "Thứ bảy",
                isActive: false,
                dayNumber: 5,
                times: [ {
                        hour: 7,
                        isActive: false
                    }, {
                        hour: 8,
                        isActive: false
                    }, {
                        hour: 9,
                        isActive: false
                    }, {
                        hour: 10,
                        isActive: false
                    }, {
                        hour: 11,
                        isActive: false
                    }, {
                        hour: 12,
                        isActive: false
                    }, {
                        hour: 13,
                        isActive: false
                    }, {
                        hour: 14,
                        isActive: false
                    }, {
                        hour: 15,
                        isActive: false
                    }, {
                        hour: 16,
                        isActive: false
                    }, {
                        hour: 17,
                        isActive: false
                    }, {
                        hour: 18,
                        isActive: false
                    }, {
                        hour: 19,
                        isActive: false
                    }, {
                        hour: 20,
                        isActive: false
                    }, {
                        hour: 21,
                        isActive: false
                    }, {
                        hour: 22,
                        isActive: false
                    }, {
                        hour: 23,
                        isActive: false
                    },

                ]
            }, {
                dayName: "Chủ nhật",
                isActive: false,
                dayNumber: 6,
                times: [ {
                        hour: 7,
                        isActive: false
                    }, {
                        hour: 8,
                        isActive: false
                    }, {
                        hour: 9,
                        isActive: false
                    }, {
                        hour: 10,
                        isActive: false
                    }, {
                        hour: 11,
                        isActive: false
                    }, {
                        hour: 12,
                        isActive: false
                    }, {
                        hour: 13,
                        isActive: false
                    }, {
                        hour: 14,
                        isActive: false
                    }, {
                        hour: 15,
                        isActive: false
                    }, {
                        hour: 16,
                        isActive: false
                    }, {
                        hour: 17,
                        isActive: false
                    }, {
                        hour: 18,
                        isActive: false
                    }, {
                        hour: 19,
                        isActive: false
                    }, {
                        hour: 20,
                        isActive: false
                    }, {
                        hour: 21,
                        isActive: false
                    }, {
                        hour: 22,
                        isActive: false
                    }, {
                        hour: 23,
                        isActive: false
                    },

                ]
            }, ],
            counter: 1,
            firebase: {}
        }
    },
    methods: {
        saveSchedule() {
            let schedule = JSON.parse(JSON.stringify(this.days)).map(day => {
                day.times = day.times.filter((time) => {
                    return time.isActive;
                }).map(time => {
                    return moment().hour(time.hour).utc().format('H');
                })

                if (day.times.length) {
                    let newDay = {};
                    newDay.dayNumber = day.dayNumber;
                    newDay.hours = day.times;
                    return newDay;
                }
                return null;
            }).filter(Boolean);
            let params = { schedule: schedule };
            rf.getRequest('NotificationRequest').saveSchedule(params).then(res => {
                this.$message.success('Lưu thành công');
            })
        },
        activateDay(selectedDay, selectedHour) {
            this.days = [...this.days].map(day => {
                if (day == selectedDay) {
                    day.times = day.times.map(time => {
                        if (time == selectedHour) {
                            time.isActive = !time.isActive;
                        }
                        return time;
                    })
                }
                return day;
            })
        },
        handlePushNotification() {
            const messaging = firebase.messaging();
            messaging
                .requestPermission()
                .then(function () {
                    console.log("Notification permission granted.");
                    return messaging.getToken();
                })
                .then((token) => {
                    rf.getRequest('NotificationRequest').saveToken({ token: token }).then(res => {
                        console.log(res);
                    })
                    console.log("token is : " + token);
                })
                .catch(function (err) {
                    console.log("Unable to get permission to notify.", err);
                });
        },
        handeTestNotification() {
            rf.getRequest('NotificationRequest').sendTestNotification().then(res => {
                console.log(res);
            })
        },
        clearAll: () => {
            for (i = 0; i < this.days.length; i++) {
                for (j = 0; j < this.days[0].times.length; j++) {
                    this.days[i].isActive = false
                    this.days[i].times[j].isActive = false
                }
            }
        }
    },
    mounted() {
        rf.getRequest('NotificationRequest').getSchedule().then(res => {
            let schedules = res;
            schedules.forEach(schedule => {
                this.days.forEach((day) => {
                    if (day.dayNumber == schedule.day_number) {
                        day.times.forEach(time => {
                            if (time.hour == moment().utc().hour(schedule.hour).local().format('H')) {
                                time.isActive = true;
                            }
                        })
                    }
                });
            })
        });
        rf.getRequest('NotificationRequest').getToken().then(res => {
            this.tokens = res;
        })
        var config = {
            apiKey: "AIzaSyBF0BWf1dDJkowVXJaUO1vISw1nM8I4tIo",
            authDomain: "fir-94e10.firebaseapp.com",
            databaseURL: "https://fir-94e10.firebaseio.com",
            projectId: "fir-94e10",
            storageBucket: "fir-94e10.appspot.com",
            messagingSenderId: "181434167743",
            appId: "1:181434167743:web:2dc7259964c3d033d8b10a",
            measurementId: "G-ZEWS3MD466"
        };
        this.firebase = firebase.initializeApp(config);

    },
}
</script>

<style lang="scss" scoped>
.schedule {
    padding: 30px;
    height: 800px;
}

.dayparts-cell {
    transition: .3s;
    background-color: #d3dcde;
    width: 30px;
    height: 30px;
    margin: 0;
    padding: 0;
    border: 1px solid #ededed;
    cursor: pointer;
}

.active {
    transition: .3s;
    background-color: #BDE130 !important;
}

.day-label,
.hour {
    cursor: pointer;
}

option {
    font-family: 'Open Sans'
}

.day-label {
    text-align: right;
    padding: 5px;
    transition: .3s;
}

.hour {
    transition: .3s;
}

.day-label:hover,
.hour:hover {
    color: #BDE130;
}

.dayparts-cell:hover {
    background: #dff460;
}

.active:hover {
    background: #617c84 !important;
}

.preactive {
    color: #BDE130;
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
