<template>
  <q-layout view="hHh Lpr lFf">
    <q-page-container class="bg-grey-2">
      <q-page
        padding
        class="row items-center justify-center"
        style="background: linear-gradient(#74c588, #0ad13c)"
      >
        <div class="row full-width">
          <div
            class="col-md-8 offset-md-2 col-xs-16 q-pl-md q-pr-md q-pt-sm q-mt-xl q-mr-sm"
          >
            <q-card flat class="bg-white text-black">
              <q-card-section class="bg-blue-14">
                <h4 class="text-h5 text-white q-my-md text-center">
                  {{ title }}
                </h4>
              </q-card-section>
              <div class="row">
                <div class="col-md-12 col-xs-12 q-pa-md">
                  <q-form
                    @submit.prevent="submitForm"
                    @reset.prevent="resetForm"
                    method="post"
                    class="q-gutter-md"
                  >
                    <div class="row">
                      <!-- อาชีพเป้าหมาย -->
                      <div class="col-md-12 col-xs-12 q-pa-md">
                        <q-select
                          filled
                          color="blue-5"
                          v-model="plan_career.career_id"
                          use-input
                          input-debounce="0"
                          :options="career.options"
                          @new-value="createValue"
                          emit-value
                          map-options
                          label="อาชีพเป้าหมาย"
                        >
                          <template v-slot:prepend>
                            <q-icon name="work_history" />
                          </template>
                          <template v-slot:no-option>
                            <q-item>
                              <q-item-section class="text-grey">
                                ค้นหาไม่พบ
                              </q-item-section>
                            </q-item>
                          </template>
                        </q-select>
                      </div>
                    </div>
                    <div class="row">
                      <!-- วันเริ่มแผน -->
                      <div class="col-md-6 col-xs-12 q-pa-md">
                        <q-input
                          filled
                          v-model="plan_career.start_date"
                          label="วันเริ่มแผน"
                        >
                          <template v-slot:append>
                            <q-icon name="event" class="cursor-pointer">
                              <q-popup-proxy
                                cover
                                transition-show="scale"
                                transition-hide="scale"
                              >
                                <q-date
                                  v-model="plan_career.start_date"
                                  mask="DD-MM-YYYY"
                                >
                                  <div class="row items-center justify-end">
                                    <q-btn
                                      v-close-popup
                                      label="Close"
                                      color="primary"
                                      flat
                                    />
                                  </div>
                                </q-date>
                              </q-popup-proxy>
                            </q-icon>
                          </template>
                        </q-input>
                      </div>
                      <!-- วันสิ้นสุดแผน -->
                      <div class="col-md-6 col-xs-12 q-pa-md">
                        <q-input
                          filled
                          v-model="plan_career.end_date"
                          label="วันสิ้นสุดแผน"
                        >
                          <template v-slot:append>
                            <q-icon name="event" class="cursor-pointer">
                              <q-popup-proxy
                                cover
                                transition-show="scale"
                                transition-hide="scale"
                              >
                                <q-date
                                  v-model="plan_career.end_date"
                                  mask="DD-MM-YYYY"
                                >
                                  <div class="row items-center justify-end">
                                    <q-btn
                                      v-close-popup
                                      label="Close"
                                      color="primary"
                                      flat
                                    />
                                  </div>
                                </q-date>
                              </q-popup-proxy>
                            </q-icon>
                          </template>
                        </q-input>
                      </div>
                    </div>
                    <div class="row">
                      <div
                        class="col-md-12 col-xs-12 q-pa-md row justify-center"
                      >
                        <q-btn
                          label="บันทึก"
                          type="submit"
                          color="primary"
                          icon="save"
                        />
                        <q-btn
                          label="ยกเลิก"
                          type="reset"
                          color="primary"
                          flat
                          class="q-ml-sm"
                          icon="clear"
                        />
                        <q-btn
                          color="primary"
                          no-caps
                          flat
                          icon="skip_previous"
                          @click="onPrevious"
                        />
                        <q-btn
                          color="primary"
                          no-caps
                          flat
                          icon="skip_next"
                          @click="onNext"
                        />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 col-xs-12 q-pa-md">
                        <div class="q-pa-md">
                          <q-table
                            class="my-sticky-header-table"
                            :grid="$q.screen.xs"
                            title="ข้อมูลส่วนตัว"
                            :rows="plan_careers1"
                            :columns="columns"
                            row-key="Name_Plan_Career"
                            :filter="filter"
                            :loading="loading"
                          >
                            <template v-slot:top-right>
                              <q-input
                                borderless
                                dense
                                debounce="300"
                                v-model="filter"
                                placeholder="Search"
                              >
                                <template v-slot:append>
                                  <q-icon name="search" />
                                </template>
                              </q-input>
                            </template>
                            <template v-slot:body-cell-actions="props">
                              <q-td :props="props">
                                <q-btn
                                  icon="mode_edit"
                                  @click="editUser(props.row.plan_career_id)"
                                ></q-btn>
                                <q-btn
                                  icon="delete"
                                  @click="
                                    deleteUser(
                                      props.row.plan_career_id,
                                      props.row.career_name
                                    )
                                  "
                                ></q-btn>
                              </q-td>
                            </template>
                          </q-table>
                        </div>
                      </div>
                    </div>
                  </q-form>
                </div>
              </div>
            </q-card>
          </div>
        </div>
      </q-page>
    </q-page-container>
  </q-layout>

  <!-- <div class="py-2">
    {{ plan_careers_ }}
  </div>
  <div class="py-2">
    {{ plan_career }}
  </div> -->
</template>

<script>
import axios from "axios";
import { ref } from "vue";

export default {
  name: "FormPlanCareer",
  data() {
    return {
      hosting: "https://icp2022.net",
      url_api_career: "http://localhost:85/icp2022/api-career.php",
      url_api_plan_career: "http://localhost:85/icp2022/api-plan-career.php",

      message: "Form Plan Career",
      title: "กำหนดอาชีพเป้าหมาย",
      plan_careers: Array,
      emp_id: Array,
      plan_careers_: Array,
      careers: Array,
      //plan_career_id	member_id	Name_Plan_Career Description
      plan_career: {
        plan_career_id: "",
        member_id: "",
        career_id: "",
        start_date: "",
        end_date: "",
      },
      status: "บันทึก",
      // Ca: {
      //   label: Array,
      //   id: Array,
      // },
      career: {
        options: [],
      },
      columns: [
        { name: "actions", align: "center", label: "Action" },
        {
          name: "plan_career_id",
          label: "รหัสแผนอาชีพ",
          align: "center",
          field: (row) => row.plan_career_id,
          format: (val) => `${val}`,
        },
        {
          name: "member_id",
          label: "รหัสสมาชิค",
          align: "center",
          field: (row) => row.member_id,
          format: (val) => `${val}`,
        },
        {
          name: "career_id",
          label: "รหัสอาชีพ",
          align: "center",
          field: (row) => row.career_id,
          format: (val) => `${val}`,
        },
        {
          name: "career_name",
          label: "อาชีพ",
          align: "left",
          field: (row) => row.career_name,
          format: (val) => `${val}`,
        },
        {
          name: "start_date",
          label: "วันเริ่มแผน",
          align: "center",
          field: (row) => row.start_date,
          format: (val) => `${val}`,
        },
        {
          name: "end_date",
          label: "วันสิ้นสุดแผน",
          align: "center",
          field: (row) => row.end_date,
          format: (val) => `${val}`,
        },
      ],
      plan_careers1: [],
      loading: true,
      filter: ref(""),
    };
  },
  methods: {
    resetForm() {
      this.status = "บันทึก";
      this.isEdit = false;
      console.log("ยกเลิก");
      // this.plan_career.Plan_Career_id = 0;
      // this.plan_career.member_id = 0;
      this.plan_career.career_id = "";
    },
    getCareer() {
      console.log(" แสดงข้อมูลทั้งหมด ");
      var self = this;
      axios
        .post(this.url_api_career, {
          action: "getall",
        })
        .then(function (res) {
          console.log(res);
          self.careers = res.data;
          var ids = res.data.map((item) => item.career_id);
          var careers = res.data.map((item) => item.career_name);
          self.career.options.splice(0);
          for (var i = 0; i < ids.length; i++) {
            self.career.options.push({
              label: careers[i],
              value: ids[i],
            });
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    submitForm() {
      if (!this.isEdit) {
        if (confirm("คุณต้องการบันทึกการเพิ่มข้อมูลหรือไม่?")) {
          console.log("บันทึกการเพิ่มข้อมูล", this.plan_career);
          const newplan_career = {
            plan_career_id: this.plan_career.plan_career_id,
            member_id: this.plan_career.member_id,
            career_id: this.plan_career.career_id,
            start_date: this.plan_career.start_date,
            end_date: this.plan_career.end_date,
          };
          this.$emit("saveData", newplan_career);
          axios
            .post(this.url_api_plan_career, {
              action: "insert",
              plan_career_id: this.plan_career.plan_career_id,
              member_id: this.plan_career.member_id,
              career_id: this.plan_career.career_id,
              start_date: this.plan_career.start_date,
              end_date: this.plan_career.end_date,
            })
            .then((res) => {
              console.log(res);
              this.getUpdate();
            })
            .catch(function (error) {
              console.log(error);
            });
        }
      } else {
        if (confirm("คุณต้องการบันทึกการแก้ไขข้อมูลหรือไม่?")) {
          console.log("บันทึกการแก้ไขข้อมูล", this.plan_career);
          axios
            .post(this.url_api_plan_career, {
              action: "update",
              plan_career_id: this.plan_career.plan_career_id,
              member_id: this.plan_career.member_id,
              career_id: this.plan_career.career_id,
              start_date: this.plan_career.start_date,
              end_date: this.plan_career.end_date,
            })
            .then((response) => {
              console.log(response);
              this.getUpdate();
            })
            .catch(function (error) {
              console.log(error);
            });
        }
      }
    },
    editUser(plan_career_id) {
      this.isEdit = true;
      var self = this;
      axios
        .post(this.url_api_plan_career, {
          action: "edit",
          plan_career_id: plan_career_id,
        })
        .then(function (response) {
          console.log("แก้ไขข้อมูล:", response.data);
          self.plan_career.plan_career_id = response.data.plan_career_id;
          self.plan_career.member_id = response.data.member_id;
          self.plan_career.career_id = response.data.career_id;
          self.plan_career.start_date = response.data.start_date;
          self.plan_career.end_date = response.data.end_date;
          self.plan_careers_ = response.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    deleteUser(plan_career_id, career_name) {
      if (confirm("คุณต้องการลบ [" + career_name + "] หรือไม่ ?")) {
        var self = this;
        axios
          .post(this.url_api_plan_career, {
            action: "delete",
            plan_career_id: plan_career_id,
          })
          .then(function (response) {
            console.log(response);
            // self.resetForm();
            self.getUpdate();
          })
          .catch(function (error) {
            console.log(error);
          });
      }
    },
    getUpdate() {
      console.log(" แสดงข้อมูล Update ");
      var self = this;
      axios
        .post(this.url_api_plan_career, {
          action: "getAll",
        })
        .then(function (res) {
          console.log("res", res);
          self.plan_careers1 = res.data;
          console.log("plan_careers1:", self.plan_careers1);
        })
        .finally(() => {
          self.loading = false;
        });
    },
    getMemberId() {
      console.log(" แสดงข้อมูลทั้งหมด ");
      var self = this;
      var memId = parseInt(this.$store.getters.myMember_id);
      axios
        .post(this.url_api_career, {
          action: "getMemberId",
          member_id: memId,
        })
        .then(function (res) {
          self.emp_id = res.data;
          console.log("Member Id:", memId);
          console.log("get member id:", self.emp_id["member_id"]);
          self.plan_career.member_id = self.emp_id["member_id"];
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    createValue(val, done) {
      done(val, "add-unique");
      console.log("val:", val);
      if (confirm("คุณต้องการเพิ่มอาชีพ [" + val + "] ใช่ใหม?")) {
        var self = this;
        axios
          .post(this.url_api_career, {
            action: "insert",
            career_name: val,
            member_id: this.plan_career.member_id,
          })
          .then(function (response) {
            console.log("Insert:", response);
            // self.resetForm();
            // self.getUpdate();
            self.getCareer();
          })
          .catch(function (error) {
            console.log(error);
          });
      }
    },
    onNext() {
      this.$router.replace({ name: "FormQualification" });
    },
    onPrevious() {
      this.$router.replace({ name: "FormComponent" });
    },
  },
  mounted() {
    // this.getCareer();
    this.getUpdate();
    // this.getMemberId();
  },
  created() {
    this.getCareer();
    this.getUpdate();
    this.getMemberId();
  },
};
</script>

<style lang="sass">
.my-sticky-header-table
  height: 310px
  .q-table__top,
  .q-table__bottom,
  thead tr:first-child th
    background-color: #c1f4cd
  thead tr th
    position: sticky
    z-index: 1
  thead tr:first-child th
    top: 0
  &.q-table--loading thead tr:last-child th
    top: 48px
</style>
