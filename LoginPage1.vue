<template>
  <q-layout view="hHh Lpr lFf">
    <q-page-container class="bg-grey-2">
      <q-page
        padding
        class="row items-center justify-center"
        style="background: linear-gradient(#74c588, #0ad13c)"
      >
        <div class="row full-width">
          <div class="col-md-8 offset-md-2 col-xs-12 q-pl-md q-pr-md q-pt-sm">
            <q-card flat class="bg-white text-black">
              <q-card-section class="bg-deep-purple-7">
                <h4 class="text-h5 text-white q-my-md text-center">
                  {{ title }}
                </h4>
              </q-card-section>
              <div class="row">
                <div class="col-md-6 col-xs-12 q-pa-md">
                  <q-img
                    placeholder-src="~assets/images/pics_topic_103.jpg"
                    src="~assets/images/pics_topic_103.jpg"
                    spinner-color="white"
                  ></q-img>
                </div>

                <div class="col-md-6 col-xs-12">
                  <div class="q-pa-md">
                    <!-- <div
                      class="text-h6 q-pb-md text-blue-8 text-center text-weight-bolder"
                    >
                      เข้าระบบ/Login
                    </div> -->
                    <q-form
                      @submit="OnLogin()"
                      @reset="onRegister()"
                      class="q-gutter-md"
                    >
                      <q-input
                        ref="email"
                        square
                        clearable
                        v-model="input.username"
                        type="email"
                        lazy-rules
                        :rules="[this.required, this.isEmail, this.short]"
                        label="Email"
                      >
                        <template v-slot:prepend>
                          <q-icon name="email" />
                        </template>
                      </q-input>
                      <!-- <q-input
                        ref="username"
                        v-if="register"
                        square
                        clearable
                        v-model="username"
                        lazy-rules
                        :rules="[this.required, this.short]"
                        type="username"
                        label="ผู้ใช้"
                      >
                        <template v-slot:prepend>
                          <q-icon name="person" />
                        </template>
                      </q-input> -->
                      <q-input
                        ref="password"
                        square
                        clearable
                        v-model="input.password"
                        :type="passwordFieldType"
                        lazy-rules
                        :rules="[this.required, this.short]"
                        label="รหัสผ่าน"
                      >
                        <template v-slot:prepend>
                          <q-icon name="lock" />
                        </template>
                        <template v-slot:append>
                          <q-icon
                            :name="visibilityIcon"
                            @click="switchVisibility"
                            class="cursor-pointer"
                          />
                        </template>
                      </q-input>
                      <q-input
                        ref="repassword"
                        v-if="register"
                        square
                        clearable
                        v-model="repassword"
                        :type="passwordFieldType"
                        lazy-rules
                        :rules="[this.required, this.short, this.diffPassword]"
                        label="ใส่รหัสผ่านซ้ำ"
                      >
                        <template v-slot:prepend>
                          <q-icon name="lock" />
                        </template>
                        <template v-slot:append>
                          <q-icon
                            :name="visibilityIcon"
                            @click="switchVisibility"
                            class="cursor-pointer"
                          />
                        </template>
                      </q-input>

                      <div>
                        <q-btn
                          icon="login"
                          label="Login"
                          type="submit"
                          color="primary"
                        />
                        <q-btn
                          icon="assignment_ind"
                          label="SIGN UP"
                          type="reset"
                          color="primary"
                          flat
                          class="q-ml-sm"
                        />
                      </div>
                    </q-form>
                  </div>
                </div>
              </div>
            </q-card>
          </div>
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
import axios from "axios";

export default {
  name: "LoginPage2",
  data() {
    return {
      hosting: "https://icp2022.net",
      url_api_member: "http://localhost:85/icp2022/api-member.php",

      title: "เข้าสู่ระบบ",
      email: "",
      username: "",
      password: "",
      repassword: "",
      register: false,
      passwordFieldType: "password",
      btnLabel: "กดปุ่ม",
      visibility: false,
      visibilityIcon: "visibility",
      emp_id: Array,
      input: {
        username: "",
        password: "",
      },
      member: {
        member_id: 0,
        full_name: "",
        status: "",
      },
    };
  },

  methods: {
    OnLogin() {
      if (this.input.username != "" && this.input.password != "") {
        this.checkMember();
      } else {
        console.log("A username and password must be present");
      }
    },
    checkMember() {
      console.log(" ตรวจสอบข้อมูลสมาชิค ");
      var self = this;
      axios
        .post(this.url_api_member, {
          action: "checkMember",
          user: this.input.username,
          pass: this.input.password,
        })
        .then(function (res) {
          console.log("data:", res.data);
          self.member.member_id = res.data.map((item) => item.member_id)[0];
          self.member.full_name = res.data.map((item) => item.full_name)[0];
          self.member.status = res.data.map((item) => item.status)[0];
          self.storeCommit(
            self.member.member_id,
            self.member.full_name,
            self.member.status
          );
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    storeCommit(member_id, full_name, status) {
      console.log("login:", member_id);
      console.log("login:", full_name);
      console.log("login:", status);
      if (member_id != 0 && full_name != "" && status != "") {
        this.$store.commit("setMyAuthenticate", true);
        this.$store.commit("setMyMember_id", member_id);
        this.$store.commit("setMyName", full_name);
        this.$store.commit("setMyStatus", status);
        this.$router.replace({ name: "home" });
      } else {
        console.log("The username and / or password is incorrect");
      }
    },
    required(val) {
      return (val && val.length > 0) || "ช่องที่ต้องกรอก";
    },
    diffPassword(val) {
      const val2 = this.password;
      return (val && val === val2) || "รหัสผ่านไม่ตรงกัน!";
    },
    short(val) {
      return (val && val.length > 3) || "ค่าสั้นเกินไป";
    },
    isEmail(val) {
      const emailPattern =
        /^(?=[a-zA-Z0-9@._%+-]{6,254}$)[a-zA-Z0-9._%+-]{1,64}@(?:[a-zA-Z0-9-]{1,63}\.){1,8}[a-zA-Z]{2,63}$/;
      return emailPattern.test(val) || "กรุณาใส่อีเมลที่ถูกต้อง";
    },

    switchTypeForm() {
      this.register = !this.register;
      this.title = this.register ? "ผู้ใช้ใหม่" : "การอนุญาต";
      this.btnLabel = this.register ? "การลงทะเบียน" : "ทางเข้า";
    },
    switchVisibility() {
      this.visibility = !this.visibility;
      this.passwordFieldType = this.visibility ? "text" : "password";
      this.visibilityIcon = this.visibility ? "visibility_off" : "visibility";
    },
    onSubmit() {
      console.log("click submit");
    },
    onReset() {
      this.name = null;
      this.password = null;
    },
    onRegister() {
      this.$router.replace({ name: "RegistrationPage" });
    },
    createState() {
      this.$store.commit("setMyAuthenticate", false);
      this.$store.commit("setMyMember_id", 0);
      this.$store.commit("setMyEmployee_id", 0);
      this.$store.commit("setMyName", "");
      this.$store.commit("setMyStatus", "");
    },
  },
  created() {
    this.createState();
  },
};
</script>
