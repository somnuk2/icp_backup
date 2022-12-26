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
                    <!-- อาชีพเป้าหมาย + คุณสมบัติ-->
                    <div class="row">
                      <!-- แผนอาชีพ -->
                      <div class="col-md-6 col-xs-12 q-pa-md">
                        <q-select
                          color="green"
                          v-model="plan_career_id"
                          :options="plan_career.options"
                          label="อาชีพเป้าหมาย"
                          emit-value
                          map-options
                          @update:model-value="
                            (val) => onPlanCareerSelected(val)
                          "
                        >
                          <template v-slot:prepend>
                            <q-icon name="work_history" />
                          </template>
                          <template v-slot:option="scope">
                            <q-item v-bind="scope.itemProps">
                              <q-item-section avatar>
                                <q-icon :name="scope.opt.icon" />
                              </q-item-section>
                              <q-item-section>
                                <q-item-label>{{
                                  scope.opt.label
                                }}</q-item-label>
                                <q-item-label caption>{{
                                  scope.opt.description
                                }}</q-item-label>
                              </q-item-section>
                            </q-item>
                          </template>
                        </q-select>
                      </div>
                      <!-- คุณสมบัติ -->
                      <div class="col-md-6 col-xs-12 q-pa-md">
                        <q-select
                          color="green"
                          v-model="qa_plan_career_id"
                          :options="qa_plan_career.options"
                          label="คุณสมบัติที่ต้องการ"
                          emit-value
                          map-options
                        >
                          <template v-slot:prepend>
                            <q-icon name="fact_check" />
                          </template>
                          <template v-slot:option="scope">
                            <q-item v-bind="scope.itemProps">
                              <q-item-section avatar>
                                <q-icon :name="scope.opt.icon" />
                              </q-item-section>
                              <q-item-section>
                                <q-item-label>{{
                                  scope.opt.label
                                }}</q-item-label>
                                <q-item-label caption>{{
                                  scope.opt.description
                                }}</q-item-label>
                              </q-item-section>
                            </q-item>
                          </template>
                        </q-select>
                      </div>
                    </div>
                    <!-- การพัฒนา ความสำคัญ ความถี่-->
                    <div class="row">
                      <!-- การพัฒนา -->
                      <div class="col-md-4 col-xs-12 q-pa-md">
                        <q-select
                          color="green"
                          v-model="development_id"
                          :options="development.options"
                          label="การพัฒนา"
                          emit-value
                          map-options
                        >
                          <template v-slot:prepend>
                            <q-icon name="post_add" />
                          </template>
                          <template v-slot:option="scope">
                            <q-item v-bind="scope.itemProps">
                              <q-item-section avatar>
                                <q-icon :name="scope.opt.icon" />
                              </q-item-section>
                              <q-item-section>
                                <q-item-label>{{
                                  scope.opt.label
                                }}</q-item-label>
                                <q-item-label caption>{{
                                  scope.opt.description
                                }}</q-item-label>
                              </q-item-section>
                            </q-item>
                          </template>
                        </q-select>
                      </div>
                      <!-- ความสำคัญ -->
                      <div class="col-md-4 col-xs-12 q-pa-md">
                        <q-select
                          color="green"
                          v-model="importance_id"
                          :options="importance.options"
                          label="ความสำคัญ"
                          emit-value
                          map-options
                        >
                          <template v-slot:prepend>
                            <q-icon name="saved_search" />
                          </template>
                          <template v-slot:option="scope">
                            <q-item v-bind="scope.itemProps">
                              <q-item-section avatar>
                                <q-icon :name="scope.opt.icon" />
                              </q-item-section>
                              <q-item-section>
                                <q-item-label>{{
                                  scope.opt.label
                                }}</q-item-label>
                                <q-item-label caption>{{
                                  scope.opt.description
                                }}</q-item-label>
                              </q-item-section>
                            </q-item>
                          </template>
                        </q-select>
                      </div>
                      <!-- ความถี่ -->
                      <div class="col-md-4 col-xs-12 q-pa-md">
                        <q-select
                          color="green"
                          v-model="frequency_id"
                          :options="frequency.options"
                          label="ความถี่"
                          emit-value
                          map-options
                        >
                          <template v-slot:prepend>
                            <q-icon name="perm_phone_msg" />
                          </template>
                          <template v-slot:option="scope">
                            <q-item v-bind="scope.itemProps">
                              <q-item-section avatar>
                                <q-icon :name="scope.opt.icon" />
                              </q-item-section>
                              <q-item-section>
                                <q-item-label>{{
                                  scope.opt.label
                                }}</q-item-label>
                                <q-item-label caption>{{
                                  scope.opt.description
                                }}</q-item-label>
                              </q-item-section>
                            </q-item>
                          </template>
                        </q-select>
                      </div>
                    </div>
                    <div class="row">
                      <!-- เรื่อง -->
                      <div class="col-md-6 col-xs-12 q-pa-md">
                        <q-input
                          standout
                          bottom-slots
                          v-model="plan.plan_title"
                          label="เรื่อง"
                          clearable
                        >
                          <template v-slot:prepend>
                            <q-icon name="list_alt" />
                          </template>
                          <template v-slot:append>
                            <q-icon name="favorite" />
                          </template>
                        </q-input>
                      </div>
                      <!-- ช่องทาง -->
                      <div class="col-md-6 col-xs-12 q-pa-md">
                        <q-input
                          standout
                          bottom-slots
                          v-model="plan.plan_channel"
                          label="ช่องทาง"
                          clearable
                        >
                          <template v-slot:prepend>
                            <q-icon name="play_lesson" />
                          </template>
                          <template v-slot:append>
                            <q-icon name="favorite" />
                          </template>
                        </q-input>
                      </div>
                    </div>
                    <div class="row">
                      <!-- วันเริ่มพัฒนา -->
                      <div class="col-md-6 col-xs-12 q-pa-md">
                        <q-input
                          filled
                          v-model="plan.plan_start_date"
                          label="วันเริ่มพัฒนา"
                        >
                          <template v-slot:append>
                            <q-icon name="event" class="cursor-pointer">
                              <q-popup-proxy
                                cover
                                transition-show="scale"
                                transition-hide="scale"
                              >
                                <q-date
                                  v-model="plan.plan_start_date"
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
                      <!-- วันสิ้นสุดพัฒนา -->
                      <div class="col-md-6 col-xs-12 q-pa-md">
                        <q-input
                          filled
                          v-model="plan.plan_end_date"
                          label="วันสิ้นสุดพัฒนา"
                        >
                          <template v-slot:append>
                            <q-icon name="event" class="cursor-pointer">
                              <q-popup-proxy
                                cover
                                transition-show="scale"
                                transition-hide="scale"
                              >
                                <q-date
                                  v-model="plan.plan_end_date"
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
                            class="my-sticky-header-column-table"
                            :grid="$q.screen.xs"
                            title="ข้อมูลการพัฒนาตนเอง"
                            :rows="plans1"
                            :columns="columns"
                            row-key="id"
                            :filter="filter"
                            :loading="loading"
                          >
                            <template v-slot:top-right>
                              <div class="col-9">
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
                              </div>
                            </template>
                            <template v-slot:body-cell-actions="props">
                              <q-td :props="props">
                                <q-btn
                                  icon="mode_edit"
                                  @click="editUser(props.row.plan_id)"
                                ></q-btn>
                                <q-btn
                                  icon="delete"
                                  @click="onDelete(props.row.plan_id)"
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
</template>

<script>
import axios from "axios";
import { ref } from "vue";

export default {
  name: "FormPlan",
  data() {
    return {
      // url: "https://icp2022.net/api-member.php",
      url_api_plan: "http://localhost:85/icp2022/api-plan.php",
      url_api_plan_career: "http://localhost:85/icp2022/api-plan-career.php",
      url_api_qa_plan_career:
        "http://localhost:85/icp2022/api-qa-plan-career.php",
      message: "Form Plan Career",
      title: "การพัฒนาตนเอง",
      plan: {
        plan_id: "",
        plan_title: "",
        plan_channel: "",
        plan_start_date: "",
        plan_end_date: "",
      },
      isEdit: false,
      status: "บันทึก",
      career: {
        options: [
          {
            label: this.Plan_Career_ids,
            value: this.Name_Plan_Careers,
          },
        ],
      },
      level: {
        options: [
          {
            label: "การเรียน",
            value: "1",
          },
          {
            label: "การปฏิบัติ",
            value: "2",
          },
        ],
      },
      level1: "",
      columns: [
        { name: "actions", align: "center", label: "Action" },
        {
          name: "plan_id",
          required: true,
          label: "รหัสแผนพัฒนาตนเอง",
          align: "center",
          field: (row) => row.plan_id,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "qa_plan_career_id",
          label: "รหัสคุณสมบัติอาชีพ",
          align: "center",
          field: (row) => row.qa_plan_career_id,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "qualification_name",
          label: "คุณสมบัติ",
          align: "left",
          field: (row) => row.qualification_name,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "development_id",
          label: "รหัสการพัฒนา",
          align: "center",
          field: (row) => row.development_id,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "development_description",
          label: "ชนิดการพัฒนา",
          align: "left",
          field: (row) => row.development_description,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "plan_title",
          label: "เรื่อง",
          align: "left",
          field: (row) => row.plan_title,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "plan_channel",
          label: "ช่องทาง",
          align: "left",
          field: (row) => row.plan_channel,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "frequency_id",
          label: "รหัสความถี่",
          align: "center",
          field: (row) => row.frequency_id,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "frequency_name",
          label: "ความถี่",
          align: "center",
          field: (row) => row.frequency_name,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "importance_id",
          label: "รหัสความสำคัญ",
          align: "center",
          field: (row) => row.importance_id,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "importance_name",
          label: "ความสำคัญ",
          align: "center",
          field: (row) => row.importance_name,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "plan_start_date",
          label: "วันเริ่ม",
          align: "center",
          field: (row) => row.plan_start_date,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "plan_end_date",
          label: "วันสิ้นสุด",
          align: "center",
          field: (row) => row.plan_end_date,
          format: (val) => `${val}`,
          sortable: true,
        },
      ],
      filter: ref(""),
      loading: true,
      plans1: [],
      qa_plan_career_id: "",
      qa_plan_career: {
        options: [],
      },
      plan_career_id: "",
      plan_career: {
        options: [],
      },
      development_id: "",
      development: {
        options: [],
      },
      importance_id: "",
      importance: {
        options: [],
      },
      frequency_id: "",
      frequency: {
        options: [],
      },
    };
  },
  methods: {
    resetForm() {
      this.status = "บันทึก";
      this.isEdit = false;
      console.log("ยกเลิก");
      this.plan.doing = "";
      this.plan.leaning = "";
    },
    getAllUser() {
      console.log(" แสดงข้อมูลทั้งหมด ");
      var self = this;
      axios
        .post(this.url_api_plan, {
          action: "getall",
        })
        .then(function (res) {
          console.log(res);
          self.plans = res.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    submitForm() {
      if (!this.isEdit) {
        if (confirm("คุณต้องการบันทึกการเพิ่มข้อมูลหรือไม่?")) {
          console.log("บันทึกการเพิ่มข้อมูล");
          const newPlan = {
            qa_plan_career_id: this.qa_plan_career_id,
            development_id: this.development_id,
            importance_id: this.importance_id,
            frequency_id: this.frequency_id,
            plan_title: this.plan.plan_title,
            plan_channel: this.plan.plan_channel,
            plan_start_date: this.plan.plan_start_date,
            plan_end_date: this.plan.plan_end_date,
          };
          this.$emit("saveData", newPlan);
          axios
            .post(this.url_api_plan, {
              action: "insert",
              qa_plan_career_id: this.qa_plan_career_id,
              development_id: this.development_id,
              importance_id: this.importance_id,
              frequency_id: this.frequency_id,
              plan_title: this.plan.plan_title,
              plan_channel: this.plan.plan_channel,
              plan_start_date: this.plan.plan_start_date,
              plan_end_date: this.plan.plan_end_date,
            })
            .then((res) => {
              console.log(res);
              // this.resetForm();
              this.getUpdate();
            })
            .catch(function (error) {
              console.log(error);
            });
        }
      } else {
        if (confirm("คุณต้องการบันทึกการแก้ไขข้อมูลหรือไม่?")) {
          axios
            .post(this.url_api_plan, {
              action: "update",
              plan_id: this.plan.plan_id,
              qa_plan_career_id: this.qa_plan_career_id,
              development_id: this.development_id,
              importance_id: this.importance_id,
              frequency_id: this.frequency_id,
              plan_title: this.plan.plan_title,
              plan_channel: this.plan.plan_channel,
              plan_start_date: this.plan.plan_start_date,
              plan_end_date: this.plan.plan_end_date,
            })
            .then((response) => {
              console.log(response);
              // this.resetForm();
              this.getUpdate();
            })
            .catch(function (error) {
              console.log(error);
            });
        }
      }
    },
    editUser(plan_id) {
      this.status = "Update(อัพเดท)";
      this.isEdit = true;
      var self = this;
      axios
        .post(this.url_api_plan, {
          action: "edit",
          plan_id: plan_id,
        })
        .then(function (response) {
          console.log("การพัฒนาต้นเอง:", response.data);
          self.plan.plan_id = response.data.plan_id;
          // อาชีพเป้าหมาย
          self.plan_career_id = response.data.plan_career_id;
          //คุณสมบัติตามอาชีพเป้าหมาย
          self.getQualification();
          self.qa_plan_career_id = response.data.qa_plan_career_id;
          // ชนิดการพัฒนา
          self.development_id = response.data.development_id;
          // ความสำคัญ
          self.importance_id = response.data.importance_id;
          // ความถี่
          self.frequency_id = response.data.frequency_id;
          // ชื่อเรื่องที่พัฒนา
          self.plan.plan_title = response.data.plan_title;
          // ช่องทางการพัฒนา
          self.plan.plan_channel = response.data.plan_channel;
          // วันเริ่มต้น
          self.plan.plan_start_date = response.data.plan_start_date;
          // วันสิ้นสุด
          self.plan.plan_end_date = response.data.plan_end_date;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    deleteUser(plan_id, plan_name) {
      if (confirm("คุณต้องการลบการพัฒนา [" + plan_name + "] หรือไม่ ?")) {
        var self = this;
        axios
          .post(this.url_api_plan, {
            action: "delete",
            planId: plan_id,
          })
          .then(function (response) {
            console.log(response);
            // self.resetForm();
            self.getAllUser();
          })
          .catch(function (error) {
            console.log(error);
          });
      }
    },
    onNext() {
      this.$router.replace({ name: "FormSelfAssessment" });
    },
    onPrevious() {
      this.$router.replace({ name: "FormQualification" });
    },
    getUpdate() {
      console.log(" แสดงข้อมูลการพัฒนาตนเอง ");
      var self = this;
      axios
        .post(this.url_api_plan, {
          action: "getall",
        })
        .then(function (res) {
          console.log("การพัฒนาตนเอง:", res.data);
          self.plans1 = res.data;
        })
        .finally(() => {
          self.loading = false;
        });
    },
    getCareer() {
      console.log(" ข้อมูลอาชีพ ");
      var self = this;
      var member_id = Number(this.$store.getters.myMember_id);
      console.log("member_id:", member_id);
      axios
        .post(this.url_api_plan_career, {
          action: "get_plan_career_by_member_id",
          member_id: member_id,
        })
        .then(function (res) {
          var plan_career_id = res.data.map((item) => item.plan_career_id);
          var career_name = res.data.map((item) => item.career_name);
          self.plan_career.options.splice(0);
          for (var i = 0; i < plan_career_id.length; i++) {
            self.plan_career.options.push({
              label: career_name[i],
              value: plan_career_id[i],
            });
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    onPlanCareerSelected(val) {
      console.log("เลือกอาชีพเป้าหมาย:", val.label);
      console.log("รหัสอาชีพเป้าหมาย:", val.value);
      this.getQualification();
    },
    getQualification() {
      console.log(" แสดงข้อมูลคุณสมบัติ ", this.plan_career.options.value);
      var self = this;
      axios
        .post(this.url_api_qa_plan_career, {
          action: "get_career_qualifiation_by_plan_career_id",
          plan_career_id: this.plan_career_id,
        })
        .then(function (res) {
          console.log(res);
          var qa_plan_career_id = res.data.map(
            (item) => item.qa_plan_career_id
          );
          var qualification_name = res.data.map(
            (item) => item.qualification_name
          );
          var level_name = res.data.map((item) => item.level_name);
          var target_name = res.data.map((item) => item.target_name);
          self.qa_plan_career.options.splice(0);
          for (var i = 0; i < qa_plan_career_id.length; i++) {
            self.qa_plan_career.options.push({
              label: qualification_name[i],
              value: qa_plan_career_id[i],
              description: level_name[i] + ":" + target_name[i],
            });
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    getDevelopment() {
      console.log(" แสดงข้อมูลการพัฒนา ");
      var self = this;
      axios
        .post(this.url_api_plan, {
          action: "getDevelopment",
        })
        .then(function (res) {
          var development_id = res.data.map((item) => item.development_id);
          var development_name = res.data.map((item) => item.development_name);
          self.development.options.splice(0);
          for (var i = 0; i < development_id.length; i++) {
            self.development.options.push({
              label: development_name[i],
              value: development_id[i],
            });
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    getImportance() {
      console.log(" แสดงข้อมูลด้านความสำคัญ ");
      var self = this;
      axios
        .post(this.url_api_plan, {
          action: "getImportance",
        })
        .then(function (res) {
          var importance_id = res.data.map((item) => item.importance_id);
          var importance_name = res.data.map((item) => item.importance_name);
          self.importance.options.splice(0);
          for (var i = 0; i < importance_id.length; i++) {
            self.importance.options.push({
              label: importance_name[i],
              value: importance_id[i],
            });
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    getFrequency() {
      console.log(" แสดงข้อมูลด้านความถี่ ");
      var self = this;
      axios
        .post(this.url_api_plan, {
          action: "getFrequency",
        })
        .then(function (res) {
          var frequency_id = res.data.map((item) => item.frequency_id);
          var frequency_name = res.data.map((item) => item.frequency_name);
          self.frequency.options.splice(0);
          for (var i = 0; i < frequency_id.length; i++) {
            self.frequency.options.push({
              label: frequency_name[i],
              value: frequency_id[i],
            });
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
  created() {
    this.getUpdate();
    this.getCareer();
    // this.getQualification();
    this.getDevelopment();
    this.getImportance();
    this.getFrequency();
  },
};
</script>

<style scope lang="sass">
.my-sticky-header-column-table
  /* height or max-height is important */
  height: 310px

  /* specifying max-width so the example can
    highlight the sticky column on any browser window */
  /* max-width: 600px */

  td:first-child
    /* bg color is important for td; just specify one */
    background-color: #c1f4cd !important

  tr th
    position: sticky
    /* higher than z-index for td below */
    z-index: 2
    /* bg color is important; just specify one */
    background: #fff

  /* this will be the loading indicator */
  thead tr:last-child th
    /* height of all previous header rows */
    top: 48px
    /* highest z-index */
    z-index: 3
  thead tr:first-child th
    top: 0
    z-index: 1
  tr:first-child th:first-child
    /* highest z-index */
    z-index: 3

  td:first-child
    z-index: 1

  td:first-child, th:first-child
    position: sticky
    left: 0
</style>
