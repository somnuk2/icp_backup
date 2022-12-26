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
                          v-model="plan_career.options.value"
                          :options="plan_career.options"
                          label="อาชีพเป้าหมาย"
                          emit-value
                          map-options
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
                          v-model="qualification.options.value"
                          :options="qualification.options"
                          label="คุณสมบัติที่ต้องการ"
                          @new-value="newQualification"
                          use-input
                          input-debounce="0"
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
                    <!-- ค่าเป้าหมาย + ระดับความสำคัญ-->
                    <div class="row">
                      <!-- ค่าเป้าหมาย -->
                      <div class="col-md-6 col-xs-12 q-pa-md">
                        <q-select
                          color="green"
                          v-model="target.options.value"
                          :options="target.options"
                          label="ค่าเป้าหมาย"
                          emit-value
                          map-options
                        >
                          <template v-slot:prepend>
                            <q-icon name="flag_circle" />
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
                      <!-- ระดับความสำคัญ -->
                      <div class="col-md-6 col-xs-12 q-pa-md">
                        <q-select
                          color="green"
                          v-model="level.options.value"
                          :options="level.options"
                          label="ระดับความสำคัญ"
                          emit-value
                          map-options
                        >
                          <template v-slot:prepend>
                            <q-icon name="running_with_errors" />
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
                            :grid="$q.screen.xs"
                            title="ข้อมูลคุณสมบัติ/ทักษะ"
                            :rows="qualifications1"
                            :columns="columns"
                            row-key="skill"
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
                                  @click="editUser(props.row.qa_plan_career_id)"
                                ></q-btn>
                                <q-btn
                                  icon="delete"
                                  @click="
                                    onDelete(
                                      props.row.qa_plan_career_id,
                                      props.row.career_name,
                                      props.row.qualification_name
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
    <!-- <div>{{ filter1 }}</div> -->
    <!-- <div>
      {{ Plan_Career_ids }}
      {{ careers1 }}
      {{ career.options }}
    </div> -->
  </q-layout>
  <!-- <div class="py-2">
    {{ qualifications_ }}
  </div>
  <div class="py-2">
    {{ qualification }}
  </div> -->
</template>

<script>
import axios from "axios";
import { ref } from "vue";

export default {
  name: "FormQualification",
  components: {},
  data() {
    return {
      hosting: "https://icp2022.net/",
      url: "http://localhost:85/icp2022/api-member.php",
      url_api_career: "http://localhost:85/icp2022/api-career.php",
      url_api_plan_career: "http://localhost:85/icp2022/api-plan-career.php",
      url_api_qualification:
        "http://localhost:85/icp2022/api-qualification.php",
      url_api_qa_plan_career:
        "http://localhost:85/icp2022/api-qa-plan-career.php",

      // filterToggle: {
      //   nice_to_have: true,
      //   must_have: true,
      //   optional: true,
      // },
      // search: "",
      message: "Form Qualification",
      title: "กำหนดคุณสมบัติ/ทักษะ",
      // selected: "",
      // qualifications: Array,
      // emp_id1: "",
      // careerPath: "",
      // careers: Array,
      // careers1: Array,
      // career_qualifications: Array,
      isEdit: false,
      // qa_plan_career: {
      //   plan_career_id: "",
      //   qualification_id: "",
      //   level_id: "",
      //   target_id: "",
      // },
      status: "บันทึก",
      // target: {
      //   options: [
      //     "ระดับ 1: รู้จักทักษะเล็กน้อย",
      //     "ระดับ 2: เคยเรียนทักษะมาบ้าง",
      //     "ระดับ 3: เคยใช้ทักษะเป็นครั้งคราว",
      //     "ระดับ 4: ได้ใช้ทักษะประจําหรือในงาน",
      //     "ระดับ 5: ปัจจุบันสามารถสอนทักษะนี้แก่ผู้อื่นได้",
      //     "Yes",
      //     "No",
      //   ],
      //   choices: [
      //     {
      //       label: "Yes",
      //       value: "Yes",
      //     },
      //     {
      //       label: "No",
      //       value: "No",
      //     },
      //   ],
      // },
      // level: {
      //   options: [
      //     {
      //       label: "Must have",
      //       value: "Must have",
      //     },
      //     {
      //       label: "Nice to have",
      //       value: "Nice to have",
      //     },
      //     ,
      //     {
      //       label: "Option",
      //       value: "Option",
      //     },
      //   ],
      // },
      // Plan_Career_ids: Array,
      // career: { options: [] },
      // ca_qualification_ids: Array,
      // ca_qualifications: Array,
      columns: [
        { name: "actions", align: "center", label: "Action" },
        {
          name: "qa_plan_career_id",
          label: "รหัสคุณสมบัติอาชีพ",
          align: "center",
          field: (row) => row.qa_plan_career_id,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "plan_career_id",
          label: "รหัสแผนอาชีพ",
          align: "center",
          field: (row) => row.plan_career_id,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "career_id",
          label: "รหัสอาชีพ",
          align: "center",
          field: (row) => row.career_id,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "career_name",
          label: "อาชีพ",
          align: "center",
          field: (row) => row.career_name,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "qualification_id",
          required: true,
          label: "รหัสคุณสมบัติ",
          align: "center",
          field: (row) => row.qualification_id,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "qualification_name",
          required: true,
          label: "คุณสมบัติ",
          align: "left",
          field: (row) => row.qualification_name,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "level_id",
          label: "รหัสระดับ",
          align: "center",
          field: (row) => row.level_id,
          format: (val) => `${val}`,
        },
        {
          name: "level_name",
          label: "ระดับ",
          align: "left",
          field: (row) => row.level_name,
          format: (val) => `${val}`,
        },
        {
          name: "target_id",
          label: "รหัสเป้าหมาย",
          align: "center",
          field: (row) => row.target_id,
          format: (val) => `${val}`,
        },
        {
          name: "target_name",
          label: "เป้าหมาย",
          align: "left",
          field: (row) => row.target_name,
          format: (val) => `${val}`,
        },
      ],
      filter: ref(""),
      loading: ref(false),
      qa_plan_career_id: "",
      qualifications1: [],
      qualification: {
        options: [],
      },
      plan_careers: "",
      plan_career: {
        options: [],
      },
      targets: "",
      target: {
        options: [],
      },
      levels: "",
      level: {
        options: [],
      },
    };
  },
  methods: {
    createValue1(val, done) {
      done(val, "add-unique");
      console.log("new val:", val);
    },
    newQualification(val, done) {
      done(val, "add-unique");
      console.log("val:", val);
      if (confirm("คุณต้องการเพิ่มคุณสมบัติ [" + val + "] ใหม่หรือไม่ ?")) {
        var self = this;
        var member_id = Number(this.$store.getters.myMember_id);
        axios
          .post(this.url_api_qualification, {
            action: "insert",
            qualification_name: val,
            member_id: member_id,
          })
          .then(function (response) {
            console.log(response);
            // self.resetForm();
            // self.getUpdate();
            self.getQualification();
          })
          .catch(function (error) {
            console.log(error);
          });
      }
    },
    resetForm() {
      this.status = "บันทึก";
      this.isEdit = false;
      console.log("ยกเลิกการบันทึกข้อมูล");
      this.qualification.skill = "";
      this.qualification.level = "";
      this.qualification.goal = "";
      this.qualification.isVisible = false;
    },
    getUpdateQualification() {
      var self = this;
      axios
        .post(this.url_api_qa_plan_career, {
          action: "getAll",
        })
        .then(function (res) {
          console.log("Update Qualification:", res.data);
          self.qualifications1 = res.data;
          console.log("getUpdate():", self.qualifications1);
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
          self.plan_careers = res.data;
          console.log("get_plan_career_by_member_id:", self.plan_careers);
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
    getQualification() {
      console.log(" แสดงข้อมูลคุณสมบัติ ");
      var self = this;
      axios
        .post(this.url_api_qa_plan_career, {
          action: "getCareerQualifiation",
          // career_id: this.qualification.planCareerId,
        })
        .then(function (res) {
          console.log(res);
          var qualification_id = res.data.map((item) => item.qualification_id);
          var qualification_name = res.data.map(
            (item) => item.qualification_name
          );
          var full_names = res.data.map((item) => item.full_name);
          self.qualification.options.splice(0);
          for (var i = 0; i < qualification_id.length; i++) {
            self.qualification.options.push({
              label: qualification_name[i],
              value: qualification_id[i],
              description: full_names[i],
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
          console.log("เพิ่มข้อมูล:", this.plan_career.options.value);
          const newQualification = {
            plan_career_id: this.plan_career.options.value,
            qualification_id: this.qualification.options.value,
            level_id: this.level.options.value,
            target_id: this.target.options.value,
          };
          this.$emit("saveData", newQualification);
          axios
            .post(this.url_api_qa_plan_career, {
              action: "insert",
              plan_career_id: this.plan_career.options.value,
              qualification_id: this.qualification.options.value,
              level_id: this.level.options.value,
              target_id: this.target.options.value,
            })
            .then((res) => {
              console.log("insert:", res);
              // this.resetForm();
              this.getUpdate();
            })
            .catch(function (error) {
              console.log(error);
            });
        }
      } else {
        if (confirm("คุณต้องการบันทึกการแก้ไขข้อมูลหรือไม่?")) {
          console.log("การแก้ไขข้อมูล");
          axios
            .post(this.url_api_qa_plan_career, {
              action: "update",
              qa_plan_career_id: this.qa_plan_career_id,
              plan_career_id: this.plan_career.options.value,
              qualification_id: this.qualification.options.value,
              level_id: this.level.options.value,
              target_id: this.target.options.value,
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
    editUser(qa_plan_career_id) {
      this.status = "Update(อัพเดท)";
      this.isEdit = true;
      var self = this;
      axios
        .post(this.url_api_qa_plan_career, {
          action: "edit",
          qa_plan_career_id: qa_plan_career_id,
        })
        .then(function (response) {
          console.log("แก้ไข:", response.data);
          self.qa_plan_career_id = response.data.qa_plan_career_id;
          self.plan_career.options.value = response.data.plan_career_id;
          self.plan_career.options.label = response.data.career_name;
          self.qualification.options.value = response.data.qualification_id;
          self.qualification.options.label = response.data.qualification_name;
          self.level.options.value = response.data.level_id;
          self.level.options.label = response.data.level_name;
          self.target.options.value = response.data.target_id;
          self.target.options.label = response.data.target_name;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    onDelete(qa_plan_career_id, career_name, qualification_name) {
      if (
        confirm(
          "คุณต้องการลบคุณสมบัติ [ " +
            qualification_name +
            " ] อาชีพ [ " +
            career_name +
            " ] หรือไม่?"
        )
      ) {
        console.log("delete:", qa_plan_career_id);
        var self = this;
        axios
          .post(this.url_api_qa_plan_career, {
            action: "delete",
            qa_plan_career_id: qa_plan_career_id,
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
    customFilter(rows, terms) {
      console.log(terms, rows);
      let lowerSearch = terms.search ? terms.search.toLowerCase : "";
      const filteredRows = rows.filter((row, i) => {
        let ans = false;
        let c1 = this.filterToggle.nice_to_have && row.level == "Nice to have";
        let c2 = this.filterToggle.must_have && row.level == "Must have";
        let c3 = this.filterToggle.optional && row.level == "Optional";
        console.log("c1:", c1);
        console.log("c2:", c2);
        console.log("c3:", c3);
        let s1 = true;
        if (lowerSearch != "") {
          s1 = false;
          let s1_values = Object.values(row);
          let s1_lower = s1_values.map((x) => x.toString().toLowerCase());
          for (let val = 0; val < s1_lower.length; val++) {
            if (s1_lower[val].includes(lowerSearch)) {
              s1 = true;
              break;
            }
          }
        }
        ans = false;
        if ((c1 && s1) || (c2 && s1) || (c3 && s1)) {
          ans = true;
        }
        return ans;
      });
      return filteredRows;
    },
    getUpdate() {
      var self = this;
      axios
        .post(this.url_api_qa_plan_career, {
          action: "getAll",
        })
        .then(function (res) {
          console.log("getUpdate():", res);
          self.qualifications1 = res.data;
          console.log("getUpdate():", self.qualifications1);
        })
        .finally(() => {
          self.loading = false;
        });
    },
    // getEmployeeID() {
    //   console.log(" แสดงข้อมูลทั้งหมด ");
    //   var self = this;
    //   var memId = parseInt(this.$store.getters.myMember_id);
    //   var emp_id = Array;
    //   axios
    //     .post(this.url_api_career, {
    //       action: "getMemberId",
    //       member_id: memId,
    //     })
    //     .then(function (res) {
    //       emp_id = res.data;
    //       self.emp_id1 = emp_id["member_id"];
    //       self.storeEmp_id(self.emp_id1);
    //       // self.getCareer(self.emp_id1);
    //     })
    //     .catch(function (error) {
    //       console.log(error);
    //     });
    // },
    storeEmp_id(emp_id) {
      console.log("store Emp_id:", emp_id);
      this.$store.commit("setMyEmployee_id", emp_id);
      console.log("store employee_id", this.$store.getters.myEmployee_id);
    },
    onNext() {
      this.$router.replace({ name: "FormPlan" });
    },
    onPrevious() {
      this.$router.replace({ name: "FormPlanCareer" });
    },
    getTarget() {
      console.log(" ข้อมูลค่าเป้าหมาย ");
      var self = this;
      axios
        .post(this.url_api_qa_plan_career, {
          action: "getTarget",
        })
        .then(function (res) {
          self.targets = res.data;
          console.log("target:", self.targets);
          var target_id = res.data.map((item) => item.target_id);
          var target_name = res.data.map((item) => item.target_name);
          self.target.options.splice(0);
          for (var i = 0; i < target_id.length; i++) {
            self.target.options.push({
              label: target_name[i],
              value: target_id[i],
            });
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    getLevel() {
      console.log(" ข้อมูลระดับความสำคัญ ");
      var self = this;
      axios
        .post(this.url_api_qa_plan_career, {
          action: "getLevel",
        })
        .then(function (res) {
          self.levels = res.data;
          console.log("level:", self.levels);
          var level_id = res.data.map((item) => item.level_id);
          var level_name = res.data.map((item) => item.level_description);
          self.level.options.splice(0);
          for (var i = 0; i < level_id.length; i++) {
            self.level.options.push({
              label: level_name[i],
              value: level_id[i],
            });
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
  created() {
    this.getQualification();
    this.getCareer();
    this.getTarget();
    this.getLevel();
    this.getUpdate();
  },
  computed: {
    showAll: {
      get: function () {
        console.log(this.filterToggle);
        return (
          this.filterToggle.nice_to_have &&
          this.filterToggle.must_have &&
          this.filterToggle.optional
        );
      },
      set: function (newValue) {
        this.filterToggle.nice_to_have = newValue;
        this.filterToggle.must_have = newValue;
        this.filterToggle.optional = newValue;
      },
    },
    filter1() {
      return {
        search: this.search,
        nice_to_have: this.filterToggle.nice_to_have,
        must_have: this.filterToggle.must_have,
        optional: this.filterToggle.optional,
      };
    },
  },
};
</script>

<style scoped></style>
