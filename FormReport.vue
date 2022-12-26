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
                  <q-form method="post" class="q-gutter-md">
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
                          v-model="qualification_id"
                          :options="qa_plan_career.options"
                          label="คุณสมบัติที่ต้องการ"
                          emit-value
                          map-options
                          @update:model-value="
                            (val) => onQualificationSelected(val)
                          "
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
                    <!-- การเปลี่ยนหน้า -->
                    <div class="row">
                      <div
                        class="col-md-12 col-xs-12 q-pa-md row justify-center"
                      >
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
                    <!-- ตารางรายงานการประเมินตนเอง -->
                    <div class="row">
                      <div class="col-md-12 col-xs-12 q-pa-md">
                        <div class="q-pa-md">
                          <q-table
                            :grid="$q.screen.xs"
                            ref="myTable"
                            title="รายงานคุณสมบัติตามอาชีพเป้าหมาย"
                            :rows="qa_plan_careers"
                            :columns="main_columns"
                            row-key="qa_plan_career_id"
                            selection="multiple"
                            v-model:selected="selected"
                          >
                            <template v-slot:header="props">
                              <q-tr :props="props">
                                <q-th auto-width>
                                  <q-btn
                                    size="sm"
                                    color="secondary"
                                    round
                                    dense
                                    @click="toggleExpansions()"
                                    :icon="expansionsToggled ? 'remove' : 'add'"
                                  ></q-btn>
                                </q-th>
                                <q-th
                                  v-for="col in props.cols"
                                  :key="col.name"
                                  :props="props"
                                >
                                  {{ col.label }}
                                </q-th>
                              </q-tr>
                            </template>
                            <template v-slot:body="props">
                              <q-tr :props="props">
                                <q-td auto-width>
                                  <q-toggle
                                    v-model="props.expand"
                                    checked-icon="add"
                                    unchecked-icon="remove"
                                    :label="`Index: ${props.row.qa_plan_career_id}`"
                                    @update:model-value="
                                      subRow(props.row.qa_plan_career_id)
                                    "
                                  />
                                </q-td>
                                <q-td
                                  v-for="col in props.cols"
                                  :key="col.name"
                                  :props="props"
                                >
                                  {{ col.value }}
                                </q-td>
                              </q-tr>
                              <q-tr v-show="props.expand" :props="props">
                                <q-td colspan="100%">
                                  <div class="text-left">
                                    รหัสคุณสมบัติตามอาชีพเป้าหมาย:
                                    {{ props.row.qa_plan_career_id }}
                                    <q-table
                                      :grid="$q.screen.xs"
                                      title="รายงานผลการพัฒนาตนเอง"
                                      :rows="plans"
                                      :columns="columns"
                                      row-key="plan_id"
                                      selection="multiple"
                                      v-model:selected="selected_plan"
                                    >
                                    </q-table>
                                  </div>
                                </q-td>
                              </q-tr>
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
  name: "FormPivotTable",
  components: {},
  data() {
    return {
      expansionsToggled: false,
      hosting: "https://icp2022.net",
      url_api_pivot: "http://localhost:85/icp2022/api-pivot.php",
      url: "http://localhost:85/icp2022/api-member.php",
      url_api_career_qualification:
        "http://localhost:85/icp2022/api-qa-plan-career.php",
      url_api_self_assessment:
        "http://localhost:85/icp2022/api-self-assessment.php",
      url_api_plan: "http://localhost:85/icp2022/api-plan.php",
      url_api_plan_career: "http://localhost:85/icp2022/api-plan-career.php",
      url_api_qa_plan_career:
        "http://localhost:85/icp2022/api-qa-plan-career.php",

      title: "รายงานผลการพัฒนาตนเอง",
      message: "Form Report",
      selected: ref([]),
      selected_plan: ref([]),
      columns: [
        {
          required: true,
          name: "plan_id",
          align: "center",
          label: "รหัสการพัฒนา",
          field: (row) => row.plan_id,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "qa_plan_career_id",
          align: "center",
          label: "รหัสคุณสมบัติอาชีพ",
          field: (row) => row.qa_plan_career_id,
          format: (val) => `${val}`,
        },
        {
          name: "development_id",
          align: "center",
          label: "รหัสชนิดการพัฒนา",
          field: (row) => row.development_id,
          format: (val) => `${val}`,
        },
        {
          name: "development_name",
          align: "center",
          label: "ชนิดการพัฒนา",
          field: (row) => row.development_name,
          format: (val) => `${val}`,
        },
        {
          name: "plan_title",
          align: "left",
          label: "เรื่อง",
          field: (row) => row.plan_title,
          format: (val) => `${val}`,
        },
        {
          name: "plan_channel",
          align: "left",
          label: "ช่องทาง",
          field: (row) => row.plan_channel,
          format: (val) => `${val}`,
        },
        {
          name: "importance_id",
          align: "center",
          label: "รหัสความสำคัญ",
          field: (row) => row.importance_id,
          format: (val) => `${val}`,
        },
        {
          name: "importance_name",
          align: "center",
          label: "ความสำคัญ",
          field: (row) => row.importance_name,
          format: (val) => `${val}`,
        },
        {
          name: "frequency_id",
          align: "center",
          label: "รหัสความถี่",
          field: (row) => row.frequency_id,
          format: (val) => `${val}`,
        },
        {
          name: "frequency_name",
          align: "center",
          label: "ความถี่",
          field: (row) => row.frequency_name,
          format: (val) => `${val}`,
        },
        {
          name: "plan_start_date",
          align: "center",
          label: "วันเริ่มต้น",
          field: (row) => row.plan_start_date,
          format: (val) => `${val}`,
        },
        {
          name: "plan_end_date",
          align: "center",
          label: "วันสิ้นสุด",
          field: (row) => row.plan_end_date,
          format: (val) => `${val}`,
        },
      ],
      main_columns: [
        {
          name: "qa_plan_career_id",
          align: "center",
          label: "รหัสคุณสมบัติอาชีพ",
          field: (row) => row.qa_plan_career_id,
          format: (val) => `${val}`,
        },
        {
          name: "career_id",
          align: "center",
          label: "รหัสอาชีพ",
          field: (row) => row.career_id,
          format: (val) => `${val}`,
        },
        {
          name: "career_name",
          align: "left",
          label: "อาชีพ",
          field: (row) => row.career_name,
          format: (val) => `${val}`,
        },
        {
          name: "qualification_id",
          align: "center",
          label: "รหัสคุณสมบัติ",
          field: (row) => row.qualification_id,
          format: (val) => `${val}`,
        },
        {
          name: "qualification_name",
          align: "left",
          label: "คุณสมบัติ",
          field: (row) => row.qualification_name,
          format: (val) => `${val}`,
        },
        {
          name: "target_id",
          align: "center",
          label: "รหัสเป้าหมาย",
          field: (row) => row.target_id,
          format: (val) => `${val}`,
        },
        {
          name: "target_name",
          align: "left",
          label: "เป้าหมาย",
          field: (row) => row.target_name,
          format: (val) => `${val}`,
        },
        {
          name: "level_id",
          align: "center",
          label: "รหัสระดับ",
          field: (row) => row.level_id,
          format: (val) => `${val}`,
        },
        {
          name: "level_description",
          align: "left",
          label: "ระดับ",
          field: (row) => row.level_description,
          format: (val) => `${val}`,
        },
      ],
      qualification_id: "",
      qa_plan_careers: [],
      qa_plan_career: {
        options: [],
      },
      plan_career_id: "",
      plan_career: {
        options: [],
      },
      plans: [],
    };
  },
  methods: {
    // การเปลี่ยนตำแหน่งฟอร์ม
    onNext() {
      this.$router.replace({ name: "FormProgress" });
    },
    onPrevious() {
      this.$router.replace({ name: "FormSelfAssessment" });
    },
    // ข้อมูลรายงานการประเมินตนเอง
    getUpdate() {
      console.log(" แสดงข้อมูลทั้งหมด ");
      var self = this;
      axios
        .post(this.url_api_self_assessment, {
          action: "getAll",
        })
        .then(function (res) {
          console.log("self_assessment:", res);
          self.plans = res.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    toggleExpansions() {
      console.log("toggleExpansions");
      this.expansionsToggled = !this.expansionsToggled;
      let rowArray = [];
      if (this.expansionsToggled) {
        rowArray = this.qa_plan_careers.map((row) => row.qa_plan_career_id);
        console.log("qa_plan_career_id:", rowArray);
        //depends on what your key is set up to be - here it is row.name
      } else {
        rowArray = [];
      }
      this.$refs.myTable.setExpanded(rowArray);
    },
    subRow(qa_plan_career_id) {
      console.log("qa_plan_career_id:", qa_plan_career_id);
      this.getPlanByQaPlanCareerId(qa_plan_career_id);
    },
    // อาชีพเป้าหมาย
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
      this.getQaPlanCareerByPlanCareerId();
    },
    // คุณสมบัติ
    getQaPlanCareerByPlanCareerId() {
      console.log(" แสดงข้อมูลคุณสมบัติ ");
      var self = this;
      axios
        .post(this.url_api_qa_plan_career, {
          action: "get_qa_plan_career_by_plan_career_id",
          plan_career_id: this.plan_career_id,
        })
        .then(function (res) {
          console.log("qa_plan_careers:", res.data);
          self.qa_plan_careers = res.data;
          var qualification_id = res.data.map((item) => item.qualification_id);
          var qualification_name = res.data.map(
            (item) => item.qualification_name
          );
          var level_name = res.data.map((item) => item.level_name);
          var target_name = res.data.map((item) => item.target_name);
          self.qa_plan_career.options.splice(0);
          for (var i = 0; i < qualification_id.length; i++) {
            self.qa_plan_career.options.push({
              label: qualification_name[i],
              value: qualification_id[i],
              description: level_name[i] + ":" + target_name[i],
            });
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    onQualificationSelected(val) {
      console.log("เลือกคุณสมบัติ:", val.label);
      console.log("รหัสคุณสมบัติ:", val.value);
      this.getQaPlanCareerByQualificationId();
    },
    getQaPlanCareerByQualificationId() {
      console.log(
        " แสดงข้อมูลคุณสมบัติ plan_career_id/qualification_id:",
        this.plan_career_id.toString() + "/" + this.qualification_id.toString()
      );
      var self = this;
      axios
        .post(this.url_api_qa_plan_career, {
          action: "get_qa_plan_career_by_qualification_id",
          plan_career_id: this.plan_career_id,
          qualification_id: this.qualification_id,
        })
        .then(function (res) {
          console.log("qa_plan_careers:", res.data);
          self.qa_plan_careers = res.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    // getSelfAassessmentByQaPlanCareerId(qa_plan_career_id) {
    //   console.log(" แสดงข้อมูลการประเมินตนเอง: ", qa_plan_career_id);
    //   var self = this;
    //   axios
    //     .post(this.url_api_self_assessment, {
    //       action: "get_self_aassessment_by_qa_plan_career_id",
    //       qa_plan_career_id: qa_plan_career_id,
    //     })
    //     .then(function (res) {
    //       console.log("self_assessment:", res);
    //       self.self_assessments = res.data;
    //     })
    //     .catch(function (error) {
    //       console.log(error);
    //     });
    // },
    getPlanByQaPlanCareerId(qa_plan_career_id) {
      console.log(" แสดงข้อมูลการพัฒนาตนเอง: ", qa_plan_career_id);
      var self = this;
      axios
        .post(this.url_api_plan, {
          action: "get_plan_by_qa_plan_career_id",
          qa_plan_career_id: qa_plan_career_id,
        })
        .then(function (res) {
          console.log("plan:", res.data);
          self.plans = res.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
  mounted() {
    this.getUpdate();
    this.getCareer();
  },
  created() {},
};
</script>

<style lang="scss"></style>
<style scoped>
.myclass td:hover:before {
  display: none;
}
</style>
